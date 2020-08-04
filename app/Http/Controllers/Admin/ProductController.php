<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\NewsModel;
use App\Models\ProductCategory;
use App\Models\ProductModel;

class ProductController extends Controller
{
    //新闻列表
    function index(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $news = ProductModel::select("product.*","product_category.name as category_name")->orderBy('create_at','desc')
                ->join("product_category","product.cid","=","product_category.id");
        if(!empty($params['search'])) $news = $news->where('product.title', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/".ADMIN_SKIN."/product/index",["case"=>$news->paginate(__E('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(){

        $category = ProductCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }


        return view("admin/".ADMIN_SKIN."/product/add",["category"=>$category]);
    }

    //编辑
    function edit($id){

        $data = ProductModel::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        $category = ProductCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }

        return view("admin/".ADMIN_SKIN."/product/edit",["data"=>$data,"category"=>$category]);
    }

    //删除
    function productsDelete($id){

        $data = ProductModel::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(ProductModel::destroy($id)){
            return back()->with("successmsg","删除成功！");
        }

        return back()->with("errormsg","删除失败！");

    }

    //类别
    function category(){

        $category = ProductCategory::orderBy('create_at','desc')->paginate(__E('admin_page_count'));



        return view("admin/".ADMIN_SKIN."/product/category",["category"=>$category]);
    }

    //类别
    function categoryAdd(){
        $data = ProductCategory::orderByDesc('id')->get();
        return view("admin/".ADMIN_SKIN."/product/categoryAdd",compact('data'));
    }

    //类别
    function categoryEdit($id){

        $category = ProductCategory::where('id', '!=', $id)->orderByDesc('id')->get();

        $data = ProductCategory::find($id);

        if (!$data) {
            back()->with("errormsg", "数据不存在！");
        }

        return view("admin/" . ADMIN_SKIN . "/product/categoryEdit", ["data" => $data], compact('category'));
    }

    //类别删除
    function categoryDel($id){

        $data = ProductCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(ProductCategory::destroy($id)){
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
                        $pre_icon = UploadFile($this->request,"cover","product/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }

                    $case = new ProductModel();

                    $case->InsertArr($all);



                    break;

                case "edit":

                    CheckArrIsEmpty($all,["cover"]);


                    if($_FILES['cover']["size"]>0){
                        $pre_icon = UploadFile($this->request,"cover","product/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }

                    $case = new ProductModel();

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
                            $pre_icon = UploadFile($this->request,"icon_img","product/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $FaqCategory = new ProductCategory();


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
                            $pre_icon = UploadFile($this->request,"icon_img","product/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $FaqCategory = new ProductCategory();


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
