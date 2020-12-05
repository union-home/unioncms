<?php

namespace App\Http\Controllers\Plugin\ossaliyun\Listeners;


use App\Http\Controllers\Plugin\ossaliyun\Controllers\InitController;
use App\Interfaces\ListenterPlugins;
use Exception;

class UploadDriver implements ListenterPlugins {

    /**
     * 事件.
     */
    public function callBack($event) {
        //上传文件
        if (isset($event->drive) && $event->drive == "ossaliyun") {

            if ($event->type == "put") {
                return InitController::upload($event);

            } else if ($event->type == "get") {

                return InitController::get($event);

            }

        } else {
            //多个上传会一起执行，所有不能断开返回
            //throw new Exception("drive有误！", 40000);

        }

    }

}