<?php

namespace App\Http\Controllers\Common;


use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    static function change($shortcode,$type="home"){

        if(!is_string($shortcode)){
            session()->flash("errormsg","参数有误！");
            return ;
        }

        $language = new Language();

        $data = $language->GetdataByFiled("shortcode",$shortcode,$type);

        if(!$data){
            session()->flash("errormsg","数据不存在！");
            return ;
        }

        $array = array(
            "icon"=>UPLOADPATH.$data["icon"],
            "shortcode" => $data["shortcode"],
            "name"=>$data["name"]
        );

        if($type=="home"){
            $type="home_current_language";
        }else{
            $type="admin_current_language";
        }

        session()->put($type,$array);

        return ;

    }


}
