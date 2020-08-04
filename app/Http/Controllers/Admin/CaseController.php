<?php

namespace App\Http\Controllers\Admin;

use App\Models\CaseCategory;
use App\Models\CaseModel;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CaseController extends Controller
{
    //列表
    function index(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $case = CaseModel::select("case.*","case_category.name as category_name")->orderBy('create_at','desc')
                ->join("case_category","case.cid","=","case_category.id");
        if(!empty($params['search'])) $case = $case->where('case.title', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/".ADMIN_SKIN."/case/index",["case"=>$case->paginate(__E('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(){

        $category = CaseCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }


        return view("admin/".ADMIN_SKIN."/case/add",["category"=>$category]);
    }

    //编辑
    function edit($id){

        $data = CaseModel::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        $category = CaseCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }

        return view("admin/".ADMIN_SKIN."/case/edit",["data"=>$data,"category"=>$category]);
    }

    //删除
    function caseDelete($id){

        $data = CaseModel::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(CaseModel::destroy($id)){
            return back()->with("successmsg","删除成功！");
        }

        return back()->with("errormsg","删除失败！");

    }

    //类别
    function category(){

        $category = CaseCategory::orderBy('create_at','desc')->paginate(__E('admin_page_count'));



        return view("admin/".ADMIN_SKIN."/case/category",["category"=>$category]);
    }

    //类别
    function categoryAdd(){

        return view("admin/".ADMIN_SKIN."/case/categoryAdd");
    }

    //类别
    function categoryEdit($id){

        $data = CaseCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        return view("admin/".ADMIN_SKIN."/case/categoryEdit",["data"=>$data]);
    }

    //类别删除
    function categoryDel($id){

        $data = CaseCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(CaseCategory::destroy($id)){
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

                    if(isset($_FILES['cover'])){
                        $pre_icon = UploadFile($this->request,"cover","case/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }

                    $case = new CaseModel();

                    $case->InsertArr($all);



                    break;

                case "edit":

                    CheckArrIsEmpty($all,["cover"]);


                    if($_FILES['cover']["size"]>0){
                        $pre_icon = UploadFile($this->request,"cover","case/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }

                    $case = new CaseModel();

                    $case->UpdateArr($all);

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
