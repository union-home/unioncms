<?php

namespace App\Http\Controllers\Plugin\qiniu\Listeners;


use App\Http\Controllers\Plugin\qiniu\Controllers\InitController;
use App\Interfaces\ListenterPlugins;

class UploadDriver implements ListenterPlugins
{

    /**
     * 事件.
     */
    public function callBack($event) {

        //上传文件
        if(isset($event->drive) && $event->drive =="qiniu"){

            if($event->type == "put"){

                return InitController::upload($event);

            }else if($event->type == "get"){

                return InitController::get($event);

            }



        }else{

                throw new \Exception("drive有误！",40000);

        }

    }

}