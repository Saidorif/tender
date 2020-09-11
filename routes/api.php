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
    // Route::post('create-user', 'AuthController@createUser');
    
    Route::group(['middleware' => 'jwt.auth'], function(){
        // Route::group(['middleware' => 'permit'], function(){

            //Dashboard
            Route::get('dashboard', 'DashboardController@index');

            //User model
            Route::get('profile', 'UserController@profile');
            Route::post('change-password', 'UserController@changePasword');

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

            //Bus Type CRUD
            Route::post('bustype', 'BusTypeController@index');
            Route::post('bustype/store', 'BusTypeController@store');
            Route::get('bustype/list', 'BusTypeController@list');
            Route::get('bustype/edit/{id}', 'BusTypeController@edit');
            Route::post('bustype/update/{id}', 'BusTypeController@update');
            Route::delete('bustype/destroy/{id}', 'BusTypeController@destroy');

            //Passport CRUD
            Route::post('passport', 'PassportController@index');
            Route::post('passport/store', 'PassportController@store');
            Route::get('passport/list', 'PassportController@list');
            Route::get('passport/edit/{id}', 'PassportController@edit');
            Route::post('passport/update/{id}', 'PassportController@update');
            Route::delete('passport/destroy/{id}', 'PassportController@destroy');

            //Direction CRUD
            Route::post('direction', 'DirectionController@index');
            Route::post('direction/store', 'DirectionController@store');
            Route::get('direction/list', 'DirectionController@list');
            Route::get('direction/edit/{id}', 'DirectionController@edit');
            Route::post('direction/update/{id}', 'DirectionController@update');
            Route::delete('direction/destroy/{id}', 'DirectionController@destroy');

            //Region CRUD
            Route::post('region', 'RegionController@index');
            Route::post('region/store', 'RegionController@store');
            Route::get('region/list', 'RegionController@list');
            Route::get('region/edit/{id}', 'RegionController@edit');
            Route::post('region/update/{id}', 'RegionController@update');
            Route::delete('region/destroy/{id}', 'RegionController@destroy');
            
            //Area CRUD
            Route::post('area', 'AreaController@index');
            Route::post('area/store', 'AreaController@store');
            Route::get('area/list', 'AreaController@list');
            Route::post('area/regionby', 'AreaController@regionby');
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

