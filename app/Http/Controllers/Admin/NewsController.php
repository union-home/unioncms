<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\NewsModel;

class NewsController extends Controller
{
    //新闻列表
    function index(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $news = NewsModel::select("news.*","news_category.name as category_name")->orderBy('create_at','desc')
                ->join("news_category","news.cid","=","news_category.id");
        if(!empty($params['search'])) $news = $news->where('news.title', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/".ADMIN_SKIN."/news/index",["news"=>$news->paginate(__E('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(){

        $category = NewsCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }


        return view("admin/".ADMIN_SKIN."/news/add",["category"=>$category]);
    }

    //编辑
    function edit($id){

        $data = NewsModel::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        $category = NewsCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }

        return view("admin/".ADMIN_SKIN."/news/edit",["data"=>$data,"category"=>$category]);
    }

    //删除
    function newsDelete($id){

        $data = NewsModel::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(NewsModel::destroy($id)){
            return back()->with("successmsg","删除成功！");
        }

        return back()->with("errormsg","删除失败！");

    }

    //类别
    function category(){

        $category = NewsCategory::orderBy('create_at','desc')->paginate(__E('admin_page_count'));



        return view("admin/".ADMIN_SKIN."/news/category",["category"=>$category]);
    }

    //类别
    function categoryAdd(){

        return view("admin/".ADMIN_SKIN."/news/categoryAdd");
    }

    //类别
    function categoryEdit($id){

        $data = NewsCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        return view("admin/".ADMIN_SKIN."/news/categoryEdit",["data"=>$data]);
    }

    //类别删除
    function categoryDel($id){

        $data = NewsCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(NewsCategory::destroy($id)){
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
                        $pre_icon = UploadFile($this->request,"cover","news/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }

                    $case = new NewsModel();

                    $case->InsertArr($all);



                    break;

                case "edit":

                    CheckArrIsEmpty($all,["cover"]);


                    if($_FILES['cover']["size"]>0){
                        $pre_icon = UploadFile($this->request,"cover","news/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }

                    $case = new NewsModel();

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
                            $pre_icon = UploadFile($this->request,"icon_img","news/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $FaqCategory = new NewsCategory();


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
                            $pre_icon = UploadFile($this->request,"icon_img","news/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $FaqCategory = new NewsCategory();


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
