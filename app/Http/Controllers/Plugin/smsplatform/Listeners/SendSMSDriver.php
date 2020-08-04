<?php

namespace App\Http\Controllers\Plugin\smsplatform\Listeners;


use App\Http\Controllers\Plugin\smsplatform\Controllers\InitController;
use App\Interfaces\ListenterPlugins;

class SendSMSDriver implements ListenterPlugins
{

    /**
     * 事件.
     */
    public function callBack($event) {
        //上传文件
        if(isset($event->drive) && $event->drive =="smsplatform"){
           return InitController::send($event);
        }else{
            // throw new \Exception("drive有误！",40000);
        }

    }

}