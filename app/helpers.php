<?php
use App\Setting;

if(!function_exists('getAppFee')){
    function getAppFee()
    {
        $setting = Setting::first();
        return $setting->salary;
    }
}