<?php

namespace App\Console\Commands;

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
        $tenders = Tender::where(['status' => 'completed'])->where('time','<',date('Y-m-d H:m:s'))->get();
        $this->info('Completed tenders count '.$tenders->count());
        $tenderlots = TenderLot::whereIn('tender_id',$tenders->pluck('id')->toArray())->where(['status' => 'pending'])->get();
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
                    $app_balls = ApplicationBall::where(['lot_id' => $lot->id,'status' => 'active'])->get();
                    foreach($app_balls as $ball){
                        $ball->status = 'rejected';
                        $ball->save();
                    }
                    $this->info('Other balls changed to rejected');
                    //Change other applications to rejected
                    $apps = Application::where(['lot_id' => $lot->id,'status' => 'accepted'])->get();
                    foreach($apps as $a){
                        $a->status = 'rejected';
                        $a->tender_status = 'rejected';
                        $a->save();
                    }
                    // 2. Change lot status
                    $lot->status = 'completed';
                    $lot->save();

                    // 3. Generate contract
                    $contract_date = Carbon::parse($lot->tender->time)->format('Y-m-d');
                    $contractArray = [
                        'user_id' => $user->id,
                        'app_id' => $application->id,
                        'app_ball_id' => $applicationBall->id,
                        'tender_id' => $lot->tender_id,
                        'lot_id' => $lot->id,
                        'number' => '1',
                        'date' => Carbon::parse($lot->tender->time)->format('Y-m-d'),
                        'exp_date' => Carbon::parse($lot->tender->time)->addYears($application->contract_time),
                        'contract_period' => $application->contract_time,
                    ];
                    $contract = Contract::create($contractArray);

                    // 4. Change direction status
                    $direction_ids = $lot->getDirection();
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
        }
    }
}
