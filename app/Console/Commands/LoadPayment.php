<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load payments';

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
        $months = [1 => '1',2 => '2',3 => '3',4 => '4',5 => '5',6 => '6',7 => '7',8 => '8',9 => '9',10 => 'A',11 => 'B',12 => 'C'];
        $days = [
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '9',
            10 => 'A',
            11 => 'B',
            12 => 'C',
            13 => 'D',
            14 => 'E',
            15 => 'F',
            16 => 'G',
            17 => 'H',
            18 => 'I',
            19 => 'J',
            20 => 'K',
            21 => 'L',
            22 => 'M',
            23 => 'N',
            24 => 'O',
            25 => 'P',
            26 => 'Q',
            27 => 'R',
            28 => 'S',
            29 => 'T',
            30 => 'U',
            31 => 'V',
        ];
        $reys_number = 1;
        $reys = \App\ReysNumber::where(['date' => date('Y-m-d'),'status' => 'active'])->orderBy('id','DESC')->first();
        if($reys != null){
            $reys_number = $reys->number + 1;
        }

        //Algoritm
        $G = substr(date('Y'),-1);//Latest char of current year (0,1,2,3,...9)
        $M = $months[date('n')];//Month of operation day of bank (1,2,3,....A,B,C)
        $D = $days[date('j')];//Day of operation day of bank (1,2,3,...A,B,C,....V)
        $RRRR = sprintf("%04d", $reys_number);//Number of race(0001...9999)
        $file_name = '/PAYINF104'.$RRRR.'.'.$G.$M.$D;

        $result = [];
        $ascii29 = chr(29);//Razdilitel
        // $file_path = '//10.10.10.118/kaznafiles/'.$file_name;
        //$file_path = base_path().'/theBank'.$file_name;
         $file_path = '//10.10.10.118/kaznafiles/PAYINF1040004.018';
        try {
            $this->info('Loading file '.$file_name.'...');
            if(file_exists($file_path)){
                $this->info('Parsing file '.$file_name.'...');
                $content = \File::get($file_path);
                $content = iconv( "Windows-1251", "UTF-8", ($content));
                $arr = explode($ascii29,$content);
                $counter = 1;
                $count = 0;
                foreach($arr as $c){
                    $result[$count][] = $c;
                    if($counter == 17){
                        $counter = 0;
                        $count++;
                    }
                    $counter++;
                }
                $the_result = [];
                foreach($result as $key => $r){
                    if(count($r) > 15){
                        $res = [];
                        $the_day = substr($r[5],0,2);
                        $the_month = substr($r[5],2,2);
                        $the_year = substr($r[5],-4);
                        $data = $the_year."-".$the_month."-".$the_day;
                        $res['type']      = $r[0];
                        $res['operday']   = $r[1];
                        $res['id']        = $r[2];
                        $res['klsdox']    = $r[3];
                        $res['docnumb']   = $r[4];
                        $res['docdate']   = $r[5];
                        $res['doctype']   = $r[6];
                        $res['sumpay']    = $r[7];
                        $res['clmfo']     = $r[8];
                        $res['clacc']     = $r[9];
                        $res['clinn']     = $r[10];
                        $res['clname']    = $r[11];
                        $res['comfo']     = $r[12];
                        $res['coacc']     = $r[13];
                        $res['coinn']     = $r[14];
                        $res['coname']    = $r[15];
                        $res['purpose']   = $r[16];
                        $res['the_date']   = $data;
                        $the_result[] = $res;

                    }
                }
                if(count($the_result) > 0 ){
                    $this->info('Writing to DB ...');
                    foreach($the_result as $k => $d){
                        if($d['klsdox'] == '4014108604262773422967279'){
                            $payment = \App\Payment::where(['transaction_id' => $d['id']])->first();
                            if($payment == null){
                                $user = \App\User::where(['inn' => $d['clinn']])->first();
                                if($user != null){
                                    $new_payment = new \App\Payment();
                                    $new_payment->user_id = $user->id;
                                    $new_payment->summ = $d['sumpay'] / 100;
                                    $new_payment->transaction_id = $d['id'];
                                    $new_payment->date = $d['the_date'];
                                    $new_payment->status = 'accepted';
                                    $new_payment->details = $d['purpose'];
                                    $new_payment->created_by = 2;
                                    $new_payment->inn = $user->inn;
                                    $new_payment->save();
                                    //Update user balance
                                    $user->balance = $user->balance + $new_payment->summ;
                                    $user->save();
                                }
                            }
                        }
                    }
                }
                if($reys == null){
                    $reys = new \App\ReysNumber();
                    $reys->number = 1;
                    $reys->date = date('Y-m-d');
                    $reys->status = 'active';
                    $reys->save();
                }else{
                    $new_reys = new \App\ReysNumber();
                    $new_reys->number = $reys->number + 1;
                    $new_reys->date = date('Y-m-d');
                    $new_reys->status = 'active';
                    $new_reys->save();
                    $reys_number = $new_reys->number;
                    $reys_number = $reys->number + 1;
                }
                $this->info('Payments updated successfuly...');
            }else{
                $this->info('File not found. Payments not loaded!');
            }
        } catch (\Throwable $th) {
            throw $th;
            $this->info('Payments not loaded!');
        }
    }
}
