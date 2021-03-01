<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group([

    'middleware' => 'api',
    'namespace' => '\App\Http\Controllers',

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'UserController@register');
    Route::get('region/list', 'RegionController@list');
    Route::get('area/user-list', 'AreaController@userList');
    Route::post('area/regionby', 'AreaController@regionby');
    Route::post('complaint/store', 'ComplaintController@store');
    Route::post('getaccess', 'ClientAccessController@store');
    Route::post('checkuser', 'UserController@checkuser');
    Route::post('get-tarif-by-number', 'DirectionController@getTarifByNumber');
    Route::get('complaintcategory/list', 'ComplaintCategoryController@list');
    Route::post('tender/index', 'TenderController@userIndex');
    Route::post('tender/index-completed', 'TenderController@userCompleted');
    Route::post('find-direction', 'DirectionController@findForUsers');
    Route::post('find-direction/{id}', 'DirectionController@directionInfoForUsers');
    Route::group(['middleware' => 'jwt.auth'], function(){
        Route::group(['middleware' => 'permit'], function(){

            //Client accesses
            Route::post('getaccess/index', 'ClientAccessController@index');
            Route::post('getaccess/activate', 'ClientAccessController@activate');
            Route::post('getaccess/delete', 'ClientAccessController@destroy');

            //Dashboard
            Route::get('dashboard', 'DashboardController@index');

            //File upload
            Route::post('file/store', 'FileController@store');
            Route::delete('file/destroy/{id}', 'FileController@destroy');

            //User model
            Route::post('user/find', 'UserController@find');
            Route::get('profile', 'UserController@profile');
            Route::post('change-password', 'UserController@changePasword');
            Route::post('carrier', 'UserController@carrier');
            Route::get('carrier/edit/{id}', 'UserController@carrierEdit');
            Route::post('carrier/update/{id}', 'UserController@carrierUpdate');

            //Payment model
            Route::post('payment', 'PaymentController@index');
            Route::post('payment/store', 'PaymentController@store');
            Route::get('payment/edit/{id}', 'PaymentController@edit');
            Route::post('payment/update/{id}', 'PaymentController@update');
            Route::delete('payment/destroy/{id}', 'PaymentController@destroy');

            // ComplaintCategory
            Route::get('complaintcategory', 'ComplaintCategoryController@index');
            Route::post('complaintcategory/store', 'ComplaintCategoryController@store');
            Route::post('complaintcategory/update/{id}', 'ComplaintCategoryController@update')->where('id', '[0-9]+');
            Route::get('complaintcategory/edit/{id}', 'ComplaintCategoryController@edit')->where('id', '[0-9]+');
            Route::delete('complaintcategory/destroy/{id}', 'ComplaintCategoryController@destroy')->where('id', '[0-9]+');

            // Tender Announce
            Route::post('tender', 'TenderController@index');
            Route::post('tender/announce', 'TenderController@announceTender');//Объявить тендер
            Route::post('tender/store', 'TenderController@store');
            Route::post('tender/list', 'TenderController@list');
            Route::get('tender/ball/{id}', 'TenderController@appBall')->where('id', '[0-9]+');
            Route::post('tender/remove/{id}', 'TenderController@remove')->where('id', '[0-9]+');
            Route::post('tender/update/{id}', 'TenderController@update')->where('id', '[0-9]+');
            Route::post('tender/reject/{id}', 'TenderController@reject')->where('id', '[0-9]+');
            Route::get('tender/complete/{id}', 'TenderController@complete')->where('id', '[0-9]+');
            Route::get('tender/edit/{id}', 'TenderController@edit')->where('id', '[0-9]+');
            Route::delete('tender/destroy/{id}', 'TenderController@destroy')->where('id', '[0-9]+');
            //
            Route::post('tender/completed-tenders','TenderController@completedTenders');
            Route::get('tender/completed-tenders/{id}','TenderController@completedTendersLots');
            Route::get('tender/completed-lots/{id}','TenderController@completedTendersBall');
            Route::get('tender/check-tenders','TenderController@checkTenders');
            Route::get('tender/app-cars/{id}','TenderController@appCars');
            Route::post('tender/approve/{id}','TenderController@tenderLotApprove');
            Route::get('tender/getinfo/{id}','TenderController@getinfo');//DATA FOR PROTOLOl

            // Complaint
            Route::post('complaint', 'ComplaintController@index');
            Route::get('complaint/count', 'ComplaintController@count');            
            Route::post('complaint/update/{id}', 'ComplaintController@update')->where('id', '[0-9]+');
            Route::get('complaint/edit/{id}', 'ComplaintController@edit')->where('id', '[0-9]+');
            // Route::delete('complaint/destroy/{id}', 'ComplaintController@destroy')->where('id', '[0-9]+');

            //Employee CRUD
            Route::post('employee', 'EmployeeController@index');
            Route::post('checkemail', 'EmployeeController@checkemail');
            Route::post('employee/store', 'EmployeeController@store');
            Route::get('employee/list', 'EmployeeController@list');
            Route::get('employee/edit/{id}', 'EmployeeController@edit');
            Route::post('employee/update/{id}', 'EmployeeController@update');
            Route::delete('employee/destroy/{id}', 'EmployeeController@destroy');
            
            //TarifCity CRUD
            Route::get('tarifcity', 'TarifCityController@index');
            Route::post('tarifcity/store', 'TarifCityController@store');
            Route::get('tarifcity/list', 'TarifCityController@list');
            Route::get('tarifcity/edit/{id}', 'TarifCityController@edit');
            Route::post('tarifcity/update/{id}', 'TarifCityController@update');
            Route::delete('tarifcity/destroy/{id}', 'TarifCityController@destroy');

            //Direction Type CRUD
            Route::post('directiontype', 'DirectionTypeController@index');
            Route::post('directiontype/store', 'DirectionTypeController@store');
            Route::get('directiontype/list', 'DirectionTypeController@list');
            Route::get('directiontype/edit/{id}', 'DirectionTypeController@edit');
            Route::post('directiontype/update/{id}', 'DirectionTypeController@update');
            Route::delete('directiontype/destroy/{id}', 'DirectionTypeController@destroy');

            //Application CRUD
            Route::post('application', 'ApplicationController@index');
            Route::post('application/car/store', 'ApplicationController@carStore');
            Route::delete('application/car/destroy/{id}', 'ApplicationController@carDestroy');
            Route::post('application/car/setstatus', 'ApplicationController@setStatus');
            Route::post('application/store', 'ApplicationController@store');
            Route::post('application/tender/store', 'ApplicationController@storeFromTenders');
            Route::get('application/list', 'ApplicationController@list');
            Route::get('application/edit/{id}', 'ApplicationController@edit');
            Route::get('application/show/{id}', 'ApplicationController@show');
            Route::post('application/update/{id}', 'ApplicationController@update');
            Route::get('application/activate/{id}', 'ApplicationController@activate');

            //Bus Type CRUD
            Route::post('bustype', 'BusTypeController@index');
            Route::post('bustype/store', 'BusTypeController@store');
            Route::get('bustype/list', 'BusTypeController@list');
            Route::get('bustype/edit/{id}', 'BusTypeController@edit');
            Route::post('bustype/update/{id}', 'BusTypeController@update');
            Route::delete('bustype/destroy/{id}', 'BusTypeController@destroy');

            //Bus Model CRUD
            Route::post('busmodel', 'BusModelController@index');
            Route::post('busmodel/store', 'BusModelController@store');
            Route::get('busmodel/list', 'BusModelController@list');
            Route::post('busmodel/find', 'BusModelController@find');
            Route::post('busmodel/get-by-marka', 'BusModelController@getByMarkaId');
            Route::get('busmodel/edit/{id}', 'BusModelController@edit');
            Route::post('busmodel/update/{id}', 'BusModelController@update');
            Route::delete('busmodel/destroy/{id}', 'BusModelController@destroy');

            //Bus Marka CRUD
            Route::post('busmarka', 'BusMarkaController@index');
            Route::post('busmarka/store', 'BusMarkaController@store');
            Route::get('busmarka/list', 'BusMarkaController@list');
            Route::post('busmarka/find', 'BusMarkaController@find');
            Route::get('busmarka/edit/{id}', 'BusMarkaController@edit');
            Route::post('busmarka/update/{id}', 'BusMarkaController@update');
            Route::delete('busmarka/destroy/{id}', 'BusMarkaController@destroy');

            //Bus Class CRUD
            Route::post('tclass', 'TClassController@index');
            Route::post('tclass/store', 'TClassController@store');
            Route::get('tclass/list', 'TClassController@list');
            Route::post('tclass/find', 'TClassController@find');
            Route::get('tclass/edit/{id}', 'TClassController@edit');
            Route::post('tclass/update/{id}', 'TClassController@update');
            Route::delete('tclass/destroy/{id}', 'TClassController@destroy');

            //Station CRUD
            Route::post('station', 'StationController@index');
            Route::post('station/store', 'StationController@store');
            Route::get('station/list', 'StationController@list');
            Route::post('station/regionby', 'StationController@regionby');
            Route::get('station/edit/{id}', 'StationController@edit');
            Route::post('station/update/{id}', 'StationController@update');
            Route::delete('station/destroy/{id}', 'StationController@destroy');

            //Passport CRUD
            Route::post('passport', 'PassportController@index');
            Route::post('passport/store', 'PassportController@store');
            Route::get('passport/list', 'PassportController@list');
            Route::get('passport/edit/{id}', 'PassportController@edit');
            Route::post('passport/update/{id}', 'PassportController@update');
            Route::delete('passport/destroy/{id}', 'PassportController@destroy');

            //PassportTiming CRUD
            Route::post('timing', 'PassportTimingController@index');
            Route::post('timing/store/{id}', 'PassportTimingController@store');
            Route::get('timing/list', 'PassportTimingController@list');
            Route::get('timing/edit/{id}', 'PassportTimingController@edit');
            Route::delete('timing/destroy/{id}', 'PassportTimingController@destroy');

            //SchemaDetails
            Route::get('schemadetail', 'SchemaDetailController@index');
            Route::post('schemadetail/store/{id}', 'SchemaDetailController@store');
            Route::get('schemadetail/list', 'SchemaDetailController@list');
            Route::get('schemadetail/edit/{id}', 'SchemaDetailController@edit');
            Route::delete('schemadetail/destroy/{id}', 'SchemaDetailController@destroy');

            //Direction CRUD
            Route::post('direction', 'DirectionController@index');
            Route::post('direction/store', 'DirectionController@store');
            Route::get('direction/list', 'DirectionController@list');
            Route::post('direction/find', 'DirectionController@find');
            Route::get('direction/timingdetails', 'DirectionController@timingdetails');
            Route::get('direction/timingtarif/{id}', 'DirectionController@timingtarif');
            Route::post('direction/passporttarif/approve', 'DirectionController@listTarifApprove');
            Route::post('direction/passporttarif/list', 'DirectionController@listTarif');
            Route::post('direction/passporttarif/{id}', 'DirectionController@storeTarif');
            Route::post('direction/schedule/{id}', 'DirectionController@schedule');
            Route::get('direction/getschedule/{id}', 'DirectionController@getSchedule');
            Route::get('direction/requirement/{id}', 'DirectionController@requirement');
            Route::post('direction/requirement/{id}', 'DirectionController@storeRequirement');
            Route::get('direction/edit/{id}', 'DirectionController@edit');
            Route::post('direction/update/{id}', 'DirectionController@update');
            Route::delete('direction/destroy/{id}', 'DirectionController@destroy');
            Route::delete('direction/car/destroy/{id}', 'DirectionController@deleteDirectionCar');

            //Approve titul xronometraj...
            Route::get('titul', 'DirectionController@titul');
            Route::get('titul/approve/{id}', 'DirectionController@titulApprove');
            Route::get('titul/activate/{id}', 'DirectionController@titulActivate');
            Route::get('titul/reject/{id}', 'DirectionController@titulReject');
            Route::get('titul/edit/{id}', 'DirectionController@titulEdit');
            
            Route::get('xronom', 'DirectionController@xronom');
            Route::get('xronom/approve/{id}', 'DirectionController@xronomApprove');
            Route::get('xronom/activate/{id}', 'DirectionController@xronomActivate');
            Route::get('xronom/reject/{id}', 'DirectionController@xronomReject');
            Route::get('xronom/edit/{id}', 'DirectionController@xronomEdit');
            
            Route::get('sxema', 'DirectionController@sxema');
            Route::get('sxema/approve/{id}', 'DirectionController@sxemaApprove');
            Route::get('sxema/activate/{id}', 'DirectionController@sxemaActivate');
            Route::get('sxema/reject/{id}', 'DirectionController@sxemaReject');
            Route::get('sxema/edit/{id}', 'DirectionController@sxemaEdit');
            
            Route::get('xjadval', 'DirectionController@xjadval');
            Route::get('xjadval/approve/{id}', 'DirectionController@xjadvalApprove');
            Route::get('xjadval/activate/{id}', 'DirectionController@xjadvalActivate');
            Route::get('xjadval/reject/{id}', 'DirectionController@xjadvalReject');
            Route::get('xjadval/edit/{id}', 'DirectionController@xjadvalEdit');
            
            Route::get('dirreq', 'DirectionController@dirReq');
            Route::get('dirreq/edit/{id}', 'DirectionController@dirReqEdit');
            Route::get('dirreq/approve/{id}', 'DirectionController@dirReqApprove');
            Route::get('dirreq/activate/{id}', 'DirectionController@dirReqActivate');
            Route::get('dirreq/reject/{id}', 'DirectionController@dirReqReject');

            //Integration
            Route::post('adliya','IntegrationController@adliya');
            Route::post('gai/vehicle','IntegrationController@getVehicleInfo');
            Route::get('get-license-list/{inn}','IntegrationController@getLicenseList');
            Route::get('check-license/{auto_number}','IntegrationController@checkLicense');

            Route::get('setting','SettingController@index');
            Route::post('setting/update','SettingController@update');

            //Contract
            Route::get('contract','ContractController@index');
            Route::get('contract/edit/{id}','ContractController@edit');

            //Region CRUD
            Route::post('region', 'RegionController@index');
            Route::post('region/store', 'RegionController@store');
            Route::get('region/edit/{id}', 'RegionController@edit');
            Route::post('region/update/{id}', 'RegionController@update');
            Route::delete('region/destroy/{id}', 'RegionController@destroy');
            
            //ConditionalSignController CRUD
            Route::post('conditionalsign', 'ConditionalSignController@index');
            Route::get('conditionalsign/list', 'ConditionalSignController@list');
            Route::post('conditionalsign/store', 'ConditionalSignController@store');
            Route::get('conditionalsign/edit/{id}', 'ConditionalSignController@edit');
            Route::post('conditionalsign/update/{id}', 'ConditionalSignController@update');
            Route::delete('conditionalsign/destroy/{id}', 'ConditionalSignController@destroy');
            
            //Area CRUD
            Route::post('area', 'AreaController@index');
            Route::post('area/store', 'AreaController@store');
            Route::get('area/list', 'AreaController@list');
            Route::post('area/regionxron', 'AreaController@regionxron');
            Route::get('area/edit/{id}', 'AreaController@edit');
            Route::post('area/update/{id}', 'AreaController@update');
            Route::delete('area/destroy/{id}', 'AreaController@destroy');

            //Position Model
            Route::get('position/all','PositionController@index');
            Route::get('position/list','PositionController@list');
            Route::post('position/store','PositionController@store');
            Route::get('position/edit/{id}','PositionController@edit');
            Route::post('position/update/{id}','PositionController@update');
            Route::delete('position/destroy/{id}','PositionController@destroy');

            //Role model
            Route::get('role', 'RoleController@index');
            Route::post('role/store', 'RoleController@store');
            Route::get('role/list', 'RoleController@list');
            Route::get('role/edit/{id}', 'RoleController@edit');
            Route::post('role/update/{id}', 'RoleController@update');
            Route::delete('role/destroy/{id}', 'RoleController@destroy');

            // Controllers
            Route::get('controller', 'ContsController@index');
            Route::post('controller/find', 'ContsController@find');
            Route::post('controller/store', 'ContsController@store');
            Route::post('controller/update/{id}', 'ContsController@update')->where('id', '[0-9]+');
            Route::get('controller/edit/{id}', 'ContsController@edit')->where('id', '[0-9]+');
            Route::get('all-controller-actions', 'ContsController@allContActions');

            // Actions
            Route::get('action', 'ActionController@index');
            Route::post('action/store', 'ActionController@store');
            Route::post('action/update/{id}', 'ActionController@update')->where('id', '[0-9]+');
            Route::get('action/edit/{id}', 'ActionController@edit')->where('id', '[0-9]+');

            //Permissions
            Route::post('permissions', 'PermissionController@index');
            Route::post('permissions/store/{id}', 'PermissionController@store')->where('id', '[0-9]+');
        });
    });


});

