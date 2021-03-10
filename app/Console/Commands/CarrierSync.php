<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Hash;

class CarrierSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carrier:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get carriers list from EIIS';

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
        try {
            //Send query
            $client = new \GuzzleHttp\Client();
            $response = $client->get('http://10.10.10.118/services/api/tender/get-org-inn-list', [
                'auth' => [
                    'tenderuser', 
                    'b2d672d1127974cdb3f5e7890cd5dafc2657bcb125c2212a5e9fd7a890c42724'
                ]
            ]);
            $data_resp = json_decode($response->getBody()->getContents(),true);
            if(!empty($data_resp['result'])){
                $this->info('Retrieved ' . count($data_resp['result']).' carriers');
                //store cariers if doesn't exist in DB
                $carriers = 0;
                $new_carriers = 0;
                foreach($data_resp['result'] as $key => $inn){
                    $the_user = User::where(['inn' => $inn['inn']])->first();
                    if(!$the_user){
                        if($key%50){
                            sleep(10);
                        }
                        try {
                            //Send query
                            $new_client = new \GuzzleHttp\Client();
                            $new_response = $new_client->get('http://10.10.10.118/services/api/tender/get-org-data/'.$inn['inn'], [
                                'auth' => [
                                    'tenderuser', 
                                    'b2d672d1127974cdb3f5e7890cd5dafc2657bcb125c2212a5e9fd7a890c42724'
                                ]
                            ]);
                            $data_resp = json_decode($new_response->getBody()->getContents(),true);
                            if(!empty($data_resp['result']['code'])){
                                $this->info($data_resp['result']['message']);
                            }else{
                                $user = User::create([
                                    'name' => $data_resp['result']['fio'],
                                    'email' => $data_resp['result']['inn'].'@mail.ru',
                                    'password' => Hash::make('secret'),
                                    'role_id' => 9,
                                    'region_id' => 1,
                                    'area_id' => 1,
                                    'status' => 'inactive',
                                    'phone' => $data_resp['result']['phone_number'],
                                    'bank_number' => $data_resp['result']['account_number'],
                                    'oked' => $data_resp['result']['oked'],
                                    'inn' => $data_resp['result']['inn'],
                                    'mfo' => $data_resp['result']['mfo'],
                                    'address' => $data_resp['result']['address'],
                                    'balance' => 0,
                                    'company_name' => $data_resp['result']['name'],
                                    'updated_by' => 1,
                                    'created_by' => 1,
                                ]);
                                if($user){
                                    $new_carriers ++;
                                    $this->info('New carrier saved successfully');
                                }
                            }
                        } catch (\Throwable $th) {
                            // throw $th;
                            $this->info('Что-то пошло не так. Пожалуйста, повторите попытку позже');
                        }
                    }else{
                        $carriers ++;
                    }
                }
                $this->info('New carriers count '.$new_carriers);
                $this->info('Old carriers count '.$carriers);
            }
            else{
                $this->info('Empty response');
            }
        } catch (\Throwable $th) {
            // throw $th;
            $this->info('Что-то пошло не так. Пожалуйста, повторите попытку позже');
        }
    }
}
