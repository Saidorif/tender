<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\UserCar;
use App\User;
use App\Tender;
use App\Application;

class AutoLicenseSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'license:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check auto license (integration with IIS)';

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
        $tender_ids = Tender::where(['status' => 'completed'])->pluck('id')->toArray();
        $apps = Application::whereIn('tender_id',$tender_ids)->get();
        foreach($apps as $app){
            $inn = $app->user->inn;
            try {
                //Send query
                $client = new \GuzzleHttp\Client();
                $response = $client->get('http://10.10.10.118/services/api/tender/get-org-data/'.$inn, [
                    'auth' => [
                        'tenderuser', 
                        'b2d672d1127974cdb3f5e7890cd5dafc2657bcb125c2212a5e9fd7a890c42724'
                    ]
                ]);
                $data_resp = json_decode($response->getBody()->getContents(),true);
                if(!empty($data_resp['result']['code'])){
                    $this->info($data_resp['result']['message']);
                }else{
                    $the_user = User::where(['inn' => $inn])->first();
                    if($the_user){
                        $user_cars = UserCar::where(['user_id' => $the_user->id])->get();
                        foreach($data_resp['result']['automobiles'] as $auto ){
                            foreach($user_cars as $u_car){
                                if($u_car->auto_number == $auto['automobile_number']){
                                    $u_car->license_start_date = Carbon::createFromTimestamp($auto['card_start_date'])->format('Y-m-d');
                                    $u_car->license_exp_date = Carbon::createFromTimestamp($auto['card_end_date'])->format('Y-m-d');
                                    $u_car->license_number = $auto['card_number'];
                                    $u_car->license_status = 1;
                                    $u_car->save();
                                }
                            }
                        }
                    }
                    $this->info('Success request');
                }
            } catch (\Throwable $th) {
                // throw $th;
                $this->info('Что-то пошло не так. Пожалуйста, повторите попытку позже');
            }
        }
    }
}
