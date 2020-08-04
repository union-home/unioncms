<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    //列表
    function faq(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $faq = Faq::select("faq.*","faq_category.name as category_name")->orderBy('create_at','desc')
                ->join("faq_category","faq.qcid","=","faq_category.id");
        if(!empty($params['search'])) $faq = $faq->where('faq.title', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/".ADMIN_SKIN."/faq/index", [ "faq" => $faq->paginate(__E('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(){

        $category = FaqCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }


        return view("admin/".ADMIN_SKIN."/faq/add",["category"=>$category]);
    }

    //编辑
    function edit($id){

        $data = Faq::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        $category = FaqCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }

        return view("admin/".ADMIN_SKIN."/faq/edit",["data"=>$data,"category"=>$category]);
    }

    //删除
    function faqDelete($id){

        $data = Faq::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(Faq::destroy($id)){
            return back()->with("successmsg","删除成功！");
        }

        return back()->with("errormsg","删除失败！");

    }

    //类别
    function category(){

        $category = FaqCategory::orderBy('create_at','desc')->paginate(__E('admin_page_count'));



        return view("admin/".ADMIN_SKIN."/faq/category",["category"=>$category]);
    }

    //类别
    function categoryAdd(){

        return view("admin/".ADMIN_SKIN."/faq/categoryAdd");
    }

    //类别
    function categoryEdit($id){

        $data = FaqCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        return view("admin/".ADMIN_SKIN."/faq/categoryEdit",["data"=>$data]);
    }

    //类别删除
    function categoryDel($id){

        $data = FaqCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(FaqCategory::destroy($id)){
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
                case "add":


                    CheckArrIsEmpty($all);

                    $faq = new Faq();

                    $faq->InsertArr($all);



                    break;

                case "edit":

                    CheckArrIsEmpty($all);

                    $faq = new Faq();

                    $faq->UpdateArr($all);

                    break;

                case "categoryAdd":

                    CheckArrIsEmpty($all,["icon_css"]);

                    //过滤参数
                    if($all["icon_type"]=="css"){
                        $all["icon"] = $all["icon_css"];
                    }else if($all["icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['icon_img'])){
                            $pre_icon = UploadFile($this->request,"icon_img","faq/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $FaqCategory = new FaqCategory();


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
                            $pre_icon = UploadFile($this->request,"icon_img","faq/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $FaqCategory = new FaqCategory();


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
