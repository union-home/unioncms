<?php

namespace App\Http\Controllers\Plugin\chuanglan\Listeners;


use App\Http\Controllers\Plugin\chuanglan\Controllers\InitController;
use App\Interfaces\ListenterPlugins;

class SendSMSDriver implements ListenterPlugins
{
    /**
     * 事件.
     */
    public function callBack($event) {

        //上传文件
        if(isset($event->drive) && $event->drive =="chuanglan"){

           return InitController::send($event);

        }else{
            //throw new \Exception("drive有误！",40000);
            // 事件会所有执行，所以不能打回错误
        }
    }
}