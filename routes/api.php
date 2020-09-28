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
    Route::post('area/regionby', 'AreaController@regionby');
    Route::post('complaint/store', 'ComplaintController@store');
    // Route::post('create-user', 'UserController@createUser');
    Route::get('complaintcategory/list', 'ComplaintCategoryController@list');
    Route::group(['middleware' => 'jwt.auth'], function(){
        // Route::group(['middleware' => 'permit'], function(){

            //Dashboard
            Route::get('dashboard', 'DashboardController@index');

            //User model
            Route::get('profile', 'UserController@profile');
            Route::post('change-password', 'UserController@changePasword');
            Route::post('carrier', 'UserController@carrier');
            Route::get('carrier/edit/{id}', 'UserController@carrierEdit');
            Route::get('carrier/update', 'UserController@carrierUpdate');

            // ComplaintCategory
            Route::get('complaintcategory', 'ComplaintCategoryController@index');
            Route::post('complaintcategory/store', 'ComplaintCategoryController@store');
            Route::post('complaintcategory/update/{id}', 'ComplaintCategoryController@update')->where('id', '[0-9]+');
            Route::get('complaintcategory/edit/{id}', 'ComplaintCategoryController@edit')->where('id', '[0-9]+');
            Route::delete('complaintcategory/destroy/{id}', 'ComplaintCategoryController@destroy')->where('id', '[0-9]+');

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

            //Direction Type CRUD
            Route::post('directiontype', 'DirectionTypeController@index');
            Route::post('directiontype/store', 'DirectionTypeController@store');
            Route::get('directiontype/list', 'DirectionTypeController@list');
            Route::get('directiontype/edit/{id}', 'DirectionTypeController@edit');
            Route::post('directiontype/update/{id}', 'DirectionTypeController@update');
            Route::delete('directiontype/destroy/{id}', 'DirectionTypeController@destroy');

            //Application CRUD
            Route::post('application', 'ApplicationController@index');
            Route::post('application/store', 'ApplicationController@store');
            Route::get('application/list', 'ApplicationController@list');
            Route::get('application/edit/{id}', 'ApplicationController@edit');
            Route::post('application/update/{id}', 'ApplicationController@update');
            Route::delete('application/destroy/{id}', 'ApplicationController@destroy');

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
            Route::get('busmodel/edit/{id}', 'BusModelController@edit');
            Route::post('busmodel/update/{id}', 'BusModelController@update');
            Route::delete('busmodel/destroy/{id}', 'BusModelController@destroy');

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

            //Direction CRUD
            Route::post('direction', 'DirectionController@index');
            Route::post('direction/store', 'DirectionController@store');
            Route::get('direction/list', 'DirectionController@list');
            Route::post('direction/find', 'DirectionController@find');
            Route::get('direction/timingdetails', 'DirectionController@timingdetails');
            Route::get('direction/timingtarif/{id}', 'DirectionController@timingtarif');
            Route::post('direction/schedule/{id}', 'DirectionController@schedule');
            Route::get('direction/edit/{id}', 'DirectionController@edit');
            Route::post('direction/update/{id}', 'DirectionController@update');
            Route::delete('direction/destroy/{id}', 'DirectionController@destroy');

            //Region CRUD
            Route::post('region', 'RegionController@index');
            Route::post('region/store', 'RegionController@store');
            
            Route::get('region/edit/{id}', 'RegionController@edit');
            Route::post('region/update/{id}', 'RegionController@update');
            Route::delete('region/destroy/{id}', 'RegionController@destroy');
            
            //ConditionalSignController CRUD
            Route::post('conditionalsign', 'ConditionalSignController@index');
            Route::post('conditionalsign/store', 'ConditionalSignController@store');
            
            Route::get('conditionalsign/edit/{id}', 'ConditionalSignController@edit');
            Route::post('conditionalsign/update/{id}', 'ConditionalSignController@update');
            Route::delete('conditionalsign/destroy/{id}', 'ConditionalSignController@destroy');
            
            //Area CRUD
            Route::post('area', 'AreaController@index');
            Route::post('area/store', 'AreaController@store');
            Route::get('area/list', 'AreaController@list');
            
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
        // });
    });


});

