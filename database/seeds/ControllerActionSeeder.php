<?php

use Illuminate\Database\Seeder;
use App\Conts;
use App\Action;

class ControllerActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $controllers = [
            'DashboardController' => [
                'index',
            ],
            'ClientAccessController' => [
                'index',
                'activate',
                'destroy',
            ],
            'FileController' => [
                'store',
                'destroy',
            ],
            'UserController' => [
                'find',
                'profile',
                'changePasword',
                'carrier',
                'carrierEdit',
                'carrierUpdate',
                'checkuser',
                'register',
            ],
            'PaymentController' => [
                'index',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'ComplaintCategoryController' => [
                'index',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'TenderController' => [
                'index',
                'store',
                'list',
                'appBall',
                'remove',
                'update',
                'reject',
                'complete',
                'edit',
                'destroy',
                'completedTenders',
                'completedTendersLots',
                'completedTendersBall',
                'checkTenders',
                'appCars',
                'tenderLotApprove',
                'getinfo',
            ],
            'ComplaintController' => [
                'index',
                'count',
                'update',
                'edit',
                'store',
            ],
            'EmployeeController' => [
                'index',
                'checkemail',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
            ],
            'TarifCityController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
            ],
            'DirectionTypeController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
            ],
            'ApplicationController' => [
                'index',
                'carStore',
                'carDestroy',
                'setStatus',
                'store',
                'storeFromTenders',
                'list',
                'edit',
                'update',
                'activate',
            ],
            'BusTypeController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
            ],
            'BusModelController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
                'find',
                'getByMarkaId',
            ],
            'BusMarkaController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
                'find',
            ],
            'TClassController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
                'find',
            ],
            'StationController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
                'regionby',
            ],
            'PassportController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
            ],
            'PassportTimingController' => [
                'index',
                'store',
                'list',
                'edit',
                'destroy',
            ],
            'SchemaDetailController' => [
                'index',
                'store',
                'list',
                'edit',
                'destroy',
            ],
            'DirectionController' => [
                'index',
                'store',
                'list',
                'find',
                'timingdetails',
                'timingtarif',
                'listTarifApprove',
                'listTarif',
                'storeTarif',
                'schedule',
                'getSchedule',
                'requirement',
                'storeRequirement',
                'edit',
                'update',
                'destroy',
                'deleteDirectionCar',
            ],
            'IntegrationController' => [
                'adliya',
                'getVehicleInfo',
                'getLicenseList',
                'checkLicense',
            ],
            'RegionController' => [
                'index',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'ConditionalSignController' => [
                'index',
                'list',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'AreaController' => [
                'index',
                'list',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'PositionController' => [
                'index',
                'list',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'RoleController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
            ],
            'ContsController' => [
                'index',
                'find',
                'trashed',
                'restore',
                'store',
                'update',
                'edit',
                'allContActions',
            ],
            'ActionController' => [
                'edit',
                'store',
                'trashed',
                'restore',
                'update',
                'index',
            ],
            'PermissionController' => [
                'index',
                'store',
            ]
        ];
        foreach($controllers as $key => $controller){
            $cont = Conts::create([
                'name' => $key,
                'label' => $key,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if($cont){
                foreach($controller as $key => $item){
                    $ation = DB::table('actions')->insert([
                        'conts_id' => $cont->id,
                        'code' => $item,
                        'name' => $item,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
