<?php

namespace App\Console\Commands;

use App\Certificate;
use Illuminate\Console\Command;
use App\Tender;
use App\TenderLot;
use App\Application;
use App\ApplicationBall;
use App\Direction;
use App\Contract;
use Carbon\Carbon;

class TenderCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tender:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tender applications ball and generate contract';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tenders = Tender::where(['status' => 'completed'])->where('time','<',now())->get();
        foreach ($tenders as $tender){
            $this->info('Tender ID: '.$tender->id.' ADDRESS: '.$tender->address);
        }
        $this->info('Completed tenders count '.$tenders->count());
        $tenderlots = TenderLot::whereIn('tender_id',$tenders->pluck('id')->toArray())->where(['status' => 'pending'])->get();
        $closed_tenderlots = 0;
        $this->info('Tenderlots count '.$tenderlots->count());
        foreach($tenderlots as $lot){
            $this->info('**********************************************************************');
            $this->info('Checking tender : '.$lot->tender->address.' at : '.$lot->tender->time);
            $applicationBallss = 0;
            $applicationBall = Application::orderBy('total_ball','DESC')
                                    ->where(['lot_id' => $lot->id,'status' => 'accepted'])
                                    ->with(['cars','user'])
                                    ->first();
            if($applicationBall != null){
                //grab the application
                $application = $applicationBall;
                $user = $application->user;
                //Check application cars
                $cars_count = $application->cars->count();
                $cars_license = 0;
                $cars_accepted = 0;
                $cars_rejected = 0;
                foreach($application->cars  as $car){
                    if($car->status == 'accepted'){
                        $cars_accepted++;
                    }
                    if($car->status == 'rejected'){
                        $cars_rejected++;
                    }
                    if($car->license_status == 1){
                        $cars_license++;
                    }
                }
                $this->info('Application which earn high ball ('.$user->company_name.') '.$application->total_ball);
                $this->info('All cars '.$cars_count);
                $this->info('Accepted cars '.$cars_accepted);
                $this->info('Rejected cars '.$cars_rejected);
                $this->info('Cars with license '.$cars_license);

                // 0. Check Application is winner or not
                if($cars_count == $cars_accepted && $cars_count == $cars_license){
                    $this->info('('.$user->company_name.') is winner');
                    // 1. Change application and app_balls status
                    $application->status = 'winnner';
                    $application->tender_status = 'winnner';
                    $application->save();
                    $applicationBall->status = 'winner';
                    $applicationBall->save();
                    $this->info('Application Ball changed to winner');
                    //Change other application balls to rejected
                    $app_balls = ApplicationBall::where(['lot_id' => $lot->id,'status' => 'active'])->where('app_id','!=',$application->id)->get();
                    foreach($app_balls as $ball){
                        $ball->status = 'rejected';
                        $ball->save();
                    }
                    $this->info('Other balls changed to rejected');
                    //Change other applications to rejected
                    $apps = Application::where(['lot_id' => $lot->id,'status' => 'accepted'])->where('id','!=',$application->id)->get();
                    foreach($apps as $a){
                        $a->status = 'rejected';
                        $a->tender_status = 'rejected';
                        $a->save();
                    }
                    // 2. Change lot status
                    $lot->status = 'completed';
                    $lot->save();

                    // 3. Generate contract
                    $direction_ids = $lot->getDirection();
                    $contract_date = Carbon::parse($lot->tender->time)->format('Y-m-d');
                    if($application->contract_time){
                        $contract_time = $application->contract_time;
                    }else{
                        $contract_time = 1;
                    }
                    $contractArray = [
                        'user_id' => $user->id,
                        'app_id' => $application->id,
                        'app_ball_id' => $applicationBall->id,
                        'tender_id' => $lot->tender_id,
                        'region_id' => $application->user->region_id,
                        'created_by' => 2,
                        'lot_id' => $lot->id,
                        'direction_ids' => $direction_ids,
                        'number' => '1',
                        'date' => Carbon::parse($lot->tender->time)->format('Y-m-d'),
                        'exp_date' => Carbon::parse($lot->tender->time)->addYears($application->contract_time),
                        'contract_period' => $contract_time,
                    ];
                    $contract = Contract::create($contractArray);

                    //4. Generate certificate (GUVOHNOMA)
                    foreach($application->cars  as $car){
                        $number_seria = $this->generateCertificateNumber($application);
                        $number = str_pad((int)$number_seria['number'],6,"0",STR_PAD_LEFT);
                        $text = $application->user->company_name."\n";
                        $text .= "ДАТА: ".$contract->exp_date."\n";
                        $text .= "Гос номер: ".$car->auto_number."\n";
                        $text .= "Номер: ".$number_seria['seria'].' '.$number."\n";
                        $the_file = time().'_'.$application->id;
                        $qrcode = \QrCode::encoding('UTF-8')->format('png')->size(200)->generate($text, public_path('qrcodes/'.$the_file.'.png'));
                        $certificateArray = [
                            'company_name' => $application->user->company_name,
                            'contract_id' => $contract->id,
                            'seria' => $number_seria['seria'],
                            'number' => $number,
                            'car_id' => $car->id,
                            'direction_id' => $car->direction_id,
                            'exp_date' => $contract->exp_date,
                            'qr_code' => 'qrcodes/'.$the_file.'.png',
                            'user_id' => $application->user_id,
                        ];
                        $certificate = Certificate::create($certificateArray);
                        $last_certificate_number = (int)$certificate->number + 1;
                    }

                    // 5. Change direction status
                    $directions = Direction::whereIn('id', $direction_ids)->get();
                    foreach($directions as $dir){
                        $dir->status = 'busy';
                        $dir->contract_id = $contract->id;
                        $dir->save();
                    }

                }
                if($cars_rejected > 0){
                    $this->info('('.$user->company_name.') is rejected. Accepted cars '.$cars_accepted.' Rejected cars '. $cars_rejected.')');
                    // 1. Change application status to rejected
                    $application->status = 'rejected';
                    $application->tender_status = 'rejected';
                    $application->save();
                    $applicationBall->status = 'rejected';
                    $applicationBall->save();
                }
            }else{
                $this->info('No applications received. Changing directions status to "free to use"');
                // 1. Change directions status
                $direction_ids = $lot->getDirection();
                $directions = Direction::whereIn('id', $direction_ids)->get();
                foreach($directions as $dir){
                    $this->info('ID: '.$dir->id.' - '.$dir->name.' changed.');
                    $dir->status = 'active';
                    $dir->contract_id = null;
                    $dir->tender_id = null;
                    $dir->lot_id = null;
                    $dir->reys_status = null;
                    $dir->save();
                }
                // 2. Change lot status
                $lot->status = 'completed';
                $lot->save();
            }
            //Check if all applications are rejected
            $rejected_apps = 0;
            $all_apps = Application::orderBy('total_ball','DESC')
                ->where(['lot_id' => $lot->id])
                ->where('status','!=','active')
                ->get();
            foreach ($all_apps as $a_app){
                if($a_app->status == 'rejected'){
                    $rejected_apps++;
                }
            }
            if(count($all_apps) == $rejected_apps){
                $this->info('All applications are rejected. Change directions status tu "free-to-use"');
                // 1. Change directions status
                $direction_ids = $lot->getDirection();
                $directions = Direction::whereIn('id', $direction_ids)->get();
                foreach($directions as $dir){
                    $this->info('ID: '.$dir->id.' - '.$dir->name.' changed.');
                    $dir->status = 'active';
                    $dir->contract_id = null;
                    $dir->tender_id = null;
                    $dir->lot_id = null;
                    $dir->reys_status = null;
                    $dir->save();
                }
            }
            //$this->info('Application balls : ');
            if($lot->status == 'completed'){
                $closed_tenderlots++;
            }
            //Check for all tender lots closed
            $the_tender_lots_count =  TenderLot::where('tender_id','=',$lot->tender_id)->count();
            if($the_tender_lots_count == $closed_tenderlots){
                $this->info('Tender at : '.$lot->tender->address.' '.$lot->tender->time.' is closed.');
            }
        }
    }

    public function generateCertificateNumber(Application $application)
    {
        $chars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $last_certificate_number = 1;
        $seria = 'AA';
        $last_certificate = Certificate::orderBy('id','DESC')->first();
        if($last_certificate){
            if((int)$last_certificate->number >= 999999){
                $last_certificate_number = 1;
                $seria = $last_certificate->seria;
                $this->info('Last sertificate number is over');
                $last_seria_number = substr($seria,-1,1);
                $next_char_index = array_search($last_seria_number,$chars) + 1;
                $seria = 'A'.$chars[$next_char_index];
                $this->info('Last seria '.$last_seria_number);
                $this->info('Next char index '.$next_char_index);
            }else{
                $last_certificate_number = (int)$last_certificate->number + 1;
                $seria = $last_certificate->seria;
            }
        }
        $number = str_pad($last_certificate_number,6,"0",STR_PAD_LEFT);
        return [
            'number' => $last_certificate_number,
            'seria' => $seria
        ];
    }
}
