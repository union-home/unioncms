<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadIMGController extends Controller
{
    //wangEditor 的自定义上传
    function uploadByEditByName($name){

        if($name=="wangEditor"){
            if($_FILES["photo"]["size"]>0){
                $pre_icon = UploadFile($this->request,"photo",$name."/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                if($pre_icon){
                    $url = GetUrlByPath($pre_icon);
                }
            }

            return ["errno"=>0,"data"=>[$url]];
        }


    }




}
