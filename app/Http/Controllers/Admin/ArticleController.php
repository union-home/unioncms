<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    //新闻列表
    function index(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $news = ArticleModel::select("article.*","article_category.name as category_name")->orderBy('create_at','desc')
                ->join("article_category","article.cid","=","article_category.id");
        if(!empty($params['search'])) $news = $news->where('article.title', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/".ADMIN_SKIN."/article/index",["case"=>$news->paginate(__E('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(){

        $category = ArticleCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }


        return view("admin/".ADMIN_SKIN."/article/add",["category"=>$category]);
    }

    //编辑
    function edit($id){

        $data = ArticleModel::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        $category = ArticleCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }

        return view("admin/".ADMIN_SKIN."/article/edit",["data"=>$data,"category"=>$category]);
    }

    //删除
    function productsDelete($id){

        $data = ArticleModel::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(ArticleModel::destroy($id)){
            return back()->with("successmsg","删除成功！");
        }

        return back()->with("errormsg","删除失败！");

    }

    //类别
    function category(){

        $category = ArticleCategory::orderBy('create_at','desc')->paginate(__E('admin_page_count'));



        return view("admin/".ADMIN_SKIN."/article/category",["category"=>$category]);
    }

    //类别
    function categoryAdd(){
        $data = ArticleCategory::orderByDesc('id')->get();
        return view("admin/".ADMIN_SKIN."/article/categoryAdd",compact('data'));
    }

    //类别
    function categoryEdit($id){

        $category = ArticleCategory::where('id', '!=', $id)->orderByDesc('id')->get();

        $data = ArticleCategory::find($id);

        if (!$data) {
            back()->with("errormsg", "数据不存在！");
        }

        return view("admin/" . ADMIN_SKIN . "/article/categoryEdit", ["data" => $data], compact('category'));
    }

    //类别删除
    function categoryDel($id){

        $data = ArticleCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(ArticleCategory::destroy($id)){
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
                    if(isset($_FILES['cover']) && $_FILES['cover']["size"] >0 ){
                        $pre_icon = UploadFile($this->request,"cover","article/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }
                    $case = new ArticleModel();
                    $case->InsertArr($all);
                    break;
                case "edit":
                    CheckArrIsEmpty($all,["cover"]);
                    if($_FILES['cover']["size"]>0){
                        $pre_icon = UploadFile($this->request,"cover","article/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }
                    $case = new ArticleModel();
                    $case->UpdateArr($all);
                    break;
                case "categoryAdd":
                    CheckArrIsEmpty($all,["icon_css"]);
                    //过滤参数
                    if($all["icon_type"]=="css"){
                        $all["icon"] = $all["icon_css"];
                    }else if($all["icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['icon_img']) && $_FILES['icon_img']["size"]>0){
                            $pre_icon = UploadFile($this->request,"icon_img","article/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }
                    $FaqCategory = new ArticleCategory();
                    $FaqCategory->InsertArr($all);
                    break;
                case "categoryEdit":
                    CheckArrIsEmpty($all,["icon_css"]);
                    //过滤参数
                    if($all["icon_type"]=="css"){
                        $all["icon"] = $all["icon_css"];
                    }else if($all["icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['icon_img']) && $_FILES['icon_img']["size"]>0){
                            $pre_icon = UploadFile($this->request,"icon_img","article/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }
                    $FaqCategory = new ArticleCategory();
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
