<?php

namespace App\Http\Controllers\Admin;

use App\Events\UpdateLanguage;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class LanguageController extends Controller
{


    //多语言
    function index(){

        return view("admin/".ADMIN_SKIN."/settings/language",["data"=>$this->languages]);
    }

    //查找
    function getLanguageByType(){
        if($this->request->ismethod('post')) {

            $all = $this->request->all();
            header("Content-type: text/html; charset=utf-8");
            //查找后台语言
            $language = new Language();

            if($all["type"]){
                $languages = $language->where("type","=",$all["type"])->get();
                if($languages){

                    foreach ($languages as $value){
                        echo "<option value='".$value["id"]."'>".$value["name"]."</option>";
                    }
                }
            }



        }

    }


    //多语言添加
    function add(){

        //查找后台语言
        $language = new Language();

        $admin_language = $language->where("type","=","admin")->get();

        if($admin_language){
            $admin_language = $admin_language->toArray();
        }else{
            $admin_language = [];
        }

        return view("admin/".ADMIN_SKIN."/settings/languageAdd",["language"=>$admin_language]);
    }

    //编辑
    function edit($id){

        $data = Language::find($id);

        if (!$data){
            session()->flash("errormsg","数据不存在！");
            return redirect("admin/language");
        }

        return view("admin/".ADMIN_SKIN."/settings/languageEdit",["data"=>$data->toArray()]);
    }

    //删除
    function delete($id){
        $data = Language::find($id);

        if (!$data){
            session()->flash("errormsg","数据不存在！");
            return redirect("admin/language");
        }

        //删除
        if(!Language::destroy($id)){
            return back()->with("errormsg","数据删除失败，请重新再试！");
        }

        //删除语言文件
        $path = base_path()."/resources/lang/".$data->type."/".$data->shortcode.".php";
        if(file_exists($path)){
            unlink($path);
        }
        //清空缓存
        Cache::forget('languages');
        return back()->with("successmsg","删除成功！");


    }

    //manage管理
    function manage($id){

        $data = Language::find($id);

        if (!$data){
            session()->flash("errormsg","数据不存在！");
            return redirect("admin/language");
        }

        $language = $data;


        //判断文件是否存在
        if(!is_dir(base_path()."/resources/lang/".$data["type"])){
            mkdir(base_path()."/resources/lang/".$data["type"],0777);
        }

        if(file_exists(base_path()."/resources/lang/".$data["type"]."/".$data["shortcode"].".php")){
            $data = include (base_path()."/resources/lang/".$data["type"]."/".$data["shortcode"].".php");
            ksort($data);
        }else{
            //创建语言文件
            file_put_contents(base_path()."/resources/lang/".$data["type"]."/".$data["shortcode"].".php","<?php ".PHP_EOL.PHP_EOL."  return ".var_export(array(),true).";");

        }


        return view("admin/".ADMIN_SKIN."/settings/languageManage",["data"=>$data,"language"=>$language]);
    }


    //改变语言
    function change($shortcode){

        \App\Http\Controllers\Common\CommonController::change($shortcode,"admin");

        return back();


    }
    //处理操作
    function Submit(){
        if($this->request->ismethod('post')){

            $all = $this->request->all();

            $language = new Language();

            switch ($all['form'])
            {
                case "add":

                    CheckArrIsEmpty($all,["copy"]);

                    //文件上传
                    if(isset($_FILES['icon'])){
                        $icon = UploadFile($this->request,"icon","icon/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($icon){
                            $all['icon'] = $icon;
                        }
                    }

                    $res = $language->InsertArr($all);

                    if(!$res){
                        return ["stauts"=>40000,"msg"=>"Add data error!"];
                    }

                    if($all["copy"]){
                        //同步语言包的key,创建文件
                        $data = $language->GetdataByFiled("id",$all["copy"]);

                        if($data){
                            if(!is_dir(base_path()."/resources/lang/".$data["type"])){
                                mkdir(base_path()."/resources/lang/".$data["type"],0777);
                            }

                            if(file_exists(base_path()."/resources/lang/".$data["type"]."/".$data["shortcode"].".php")){
                                $data = include (base_path()."/resources/lang/".$data["type"]."/".$data["shortcode"].".php");

                            }else{
                                $data = array();
                            }
                            //创建语言文件
                            file_put_contents(base_path()."/resources/lang/".$all["type"]."/".$all["shortcode"].".php","<?php ".PHP_EOL.PHP_EOL."  return ".var_export($data,true).";");

                        }
                    }

                    break;

                case "edit":

                    //文件上传
                    if(isset($_FILES['icon'])){
                        $icon = UploadFile($this->request,"icon","icon/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($icon){
                            $all['icon'] = $icon;
                        }
                    }

                    $language->UpdateArr($all);

                    break;

                case "ManageUpdate":

                    //语言包数据
                    $data_detail = $language->find($all['id']);

                    if(!$data_detail){
                        return ["stauts"=>40000,"msg"=>"Language data error!"];
                    };


                    $data_detail = $data_detail->toArray();

                    if(file_exists(base_path()."/resources/lang/".$data_detail["type"]."/".$data_detail["shortcode"].".php")){
                        foreach ($all as $key => $val){
                            if(in_array($key,["_token","id","type","form"])){
                                continue;
                            }
                            $temp[$key]=$val;
                        }
                        $data = $temp;

                        //创建语言文件
                        file_put_contents(base_path()."/resources/lang/".$data_detail["type"]."/".$data_detail["shortcode"].".php","<?php ".PHP_EOL.PHP_EOL."  return ".var_export($data,true).";");

                        //更新同一个type的语言包key
                        event(new UpdateLanguage($data_detail,$data));

                    }



                    break;

                default :

                    return ["stauts"=>40000,"msg"=>"Method does not exist"];
            }


            return ["stauts"=>200,"msg"=>"success"];

        }else{
            return ["stauts"=>40000,"msg"=>"method error,must post method"];
        }



    }


}
