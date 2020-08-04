<?php

namespace App\Http\Controllers\Admin;

use App\Models\CaseCategory;
use App\Models\CaseModel;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Join;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    //招聘
    function join_list(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $joins = Join::orderby("status","desc")->orderby("created_at","desc");
        if(!empty($params['search'])) $joins = $joins->where('position', 'LIKE', '%' . $params['search'] . '%');
        $joins = $joins->paginate(__E('admin_page_count'));
        return view("admin/".ADMIN_SKIN."/content/joins",compact('joins', 'params'));//compact('title','intro')
    }

    //招聘添加
    function joinAdd(){

        return view("admin/".ADMIN_SKIN."/content/joinAdd",compact(''));
    }

    //招聘编辑
    function joinEdit($id){

        if(!$id){
            return back()->with("errormsg","数据不存在！");
        }

        $joins = Join::find($id);

        if($joins){
            $joins=$joins->toArray();
        }else{
            $joins = [];
        }

        return view("admin/".ADMIN_SKIN."/content/joinEdit",compact('joins'));
    }

    //招聘删除
    function joinDel($id){

        if(!$id){
            return back()->with("errormsg","数据不存在！");
        }

        $res = Join::deleteById($id);

        if($res){
            return back()->with("successmsg","删除成功！");
        }

        return back()->with("errormsg","删除失败！");


    }















   //处理
    function submit(){


        if($this->request->ismethod('post')){

            $all = $this->request->all();



            switch ($all['form'])
            {
                case "joinAdd":

                    $joins = new Join();

                    $joins->InsertArr($all);

                    break;

                case "joinEdit":



                    $joins = new Join();

                    $joins->UpdateArr($all);

                    break;

                case "categoryAdd":

                    CheckArrIsEmpty($all,["icon_css"]);

                    //过滤参数
                    if($all["icon_type"]=="css"){
                        $all["icon"] = $all["icon_css"];
                    }else if($all["icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['icon_img'])){
                            $pre_icon = UploadFile($this->request,"icon_img","case/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $FaqCategory = new CaseCategory();


                    $FaqCategory->InsertArr($all);

                    break;

                case "categoryEdit":

                    CheckArrIsEmpty($all,["icon_css"]);

                    //过滤参数
                    if($all["icon_type"]=="css"){
                        $all["icon"] = $all["icon_css"];
                    }else if($all["icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['icon_img'])){
                            $pre_icon = UploadFile($this->request,"icon_img","case/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $FaqCategory = new CaseCategory();


                    $FaqCategory->UpdateArr($all);

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
