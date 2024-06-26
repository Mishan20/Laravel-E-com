<?php

namespace App\Trait;

trait SMS_Notification
{
    public function sendSMS($id, $msg)
    {
        $user = config('services.textitbiz.username');
        $pass = config('services.textitbiz.password');
        $baseurl = "http://www.textit.biz/sendmsg";
        
        $url = "$baseurl/?To=$id&Text=$msg&User=$user&Pass=$pass";
        $response = file($url);
    }
}
