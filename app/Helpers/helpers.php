<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

function validateLogin(){

    $code = Setting::get_value('purchase_code')??'';
    $is_login = false;
    $url = '';
    if($code==''){
        $is_login = true;
    }
    $data=array();
    $data['is_login']=$is_login;
    $data['url']=$url;

    return $data;
}
function validateAdmin(){
    $todayDate = \Carbon\Carbon::now();
    $today = $todayDate->format('d-m-Y');
    $last_date = Cache::get('validate_admin');
    $interval = $todayDate->diffInDays($last_date);
    if(is_null(Cache::get('validate_admin'))){
        Cache::forever('validate_admin', $today);
    }
    if($interval>15) {
        Cache::forever('validate_admin', $today);
        $code = Setting::get_value('purchase_code') ?? '';
        $domain = env('APP_URL');
        $path = 'https://wrteam.in/validator/home/validator?purchase_code=' . $code . '&domain_url=' . $domain;
        $response = file_get_contents($path);
        $data = json_decode($response, true);

        if (isset($data['error']) && $data['error'] == true) {
            $setting = Setting::where('variable', 'purchase_code')->first() ?? new Setting();
            $setting->value = '';
            $setting->save();
        }
    }
}

function isInstalled(){
    if(!file_exists(storage_path('installed'))){
        return false;
    }
    return true;
}
function currentVersion(){
    $versionFilePath = base_path('version.txt');
    $version = file_get_contents($versionFilePath);
    //$version = chop($version, '"\0","\t","\n","\x0B","\r"," "'); // this function is remove the all /n/r and white space
    $version = trim($version); // this function is remove the all /n/r and white space
    //$version = floatval($version);
    //dd($version);
    if($version == ""){
        $version = "1.7.0";
    }
    return $version;
}
function fixVersion(){
    $versionFilePath = base_path('version.txt');
    $currentVersion = currentVersion();
    file_put_contents($versionFilePath, $currentVersion);
}
