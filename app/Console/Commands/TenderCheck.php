<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tender;
use App\TenderLot;
use App\Application;
use App\ApplicationBall;

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
        $tenders = Tender::where(['status' => 'completed'])->get();
        $this->info('Completed tenders count '.$tenders->count());
        $tenderlots = TenderLot::whereIn('tender_id',$tenders->pluck('id')->toArray())->get();
        $this->info('Tenderlots count '.$tenderlots->count());
        foreach($tenderlots as $lot){
            $applicationBall = ApplicationBall::orderBy('total_ball','DESC')->where(['lot_id' => $lot->id])->first();
            //grab the application
            $application = $applicationBall->application;
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
            $this->info('Application which earn high ball ('.$applicationBall->company_name.') '.$applicationBall->total_ball);
            $this->info('Accpeted cars '.$cars_accepted);
            $this->info('Rejected cars '.$cars_rejected);
            $this->info('Cars with license '.$cars_license);
            // 0. Check Application is winner or not
            // 1. Change lot status
            // 2. Change application status
            // 3. Change direction status
            // 4. Generate contract
        }
    }
}
