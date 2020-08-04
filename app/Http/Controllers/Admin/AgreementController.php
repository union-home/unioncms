<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgreementCategory;
use App\Models\AgreementModel;

class AgreementController extends Controller
{
    //协议列表
    function index(){
        $agreements = AgreementModel::select("agreement.*","agreement_category.name as category_name")
                ->leftJoin("agreement_category","agreement.cid","=","agreement_category.id")
                ->orderBy('create_at', 'desc')
                ->paginate(__E('admin_page_count'));
        return view("admin/".ADMIN_SKIN."/agreement/index", ["agreement" => $agreements]);
    }

    //添加
    function add(){
        $category = AgreementCategory::orderBy('create_at','desc')->get();
        $category = $category ? $category->toArray() : [];
        return view("admin/".ADMIN_SKIN."/agreement/add",["category"=>$category]);
    }

    //编辑
    function edit($id){
        $data = AgreementModel::find($id);
        if(!$data) return back()->with("errormsg","数据不存在！");

        $category = AgreementCategory::orderBy('create_at','desc')->get();
        $category = $category ? $category->toArray() : [];

        return view("admin/".ADMIN_SKIN."/agreement/edit",["data"=>$data,"category"=>$category]);
    }

    //删除
    function delete($id){
        $data = AgreementModel::find($id);
        if(!$data) return back()->with("errormsg","数据不存在！");
        if(AgreementModel::destroy($id)) return back()->with("successmsg","删除成功！");
        return back()->with("errormsg","删除失败！");
    }

    //类别 - 列表
    function category(){
        $category = AgreementCategory::orderBy('create_at','desc')->paginate(__E('admin_page_count'));
        return view("admin/".ADMIN_SKIN."/agreement/category",["category"=>$category]);
    }

    //类别 - 新增
    function categoryAdd(){
        return view("admin/".ADMIN_SKIN."/agreement/categoryAdd");
    }

    //类别 - 编辑
    function categoryEdit($id){
        $data = AgreementCategory::find($id);
        if(!$data) return back()->with("errormsg","数据不存在！");
        return view("admin/".ADMIN_SKIN."/agreement/categoryEdit",["data"=>$data]);
    }

    //类别删除
    function categoryDel($id){
        $data = AgreementCategory::find($id);
        if(!$data) return back()->with("errormsg","数据不存在！");
        if(AgreementCategory::destroy($id)) return back()->with("successmsg","删除成功！");
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
                    $case = new AgreementModel();
                    $return = $case->InsertArr($all);
                    break;
                case "edit":
                    $case = new AgreementModel();
                    $return = $case->UpdateArr($all);
                    break;
                case "categoryAdd":
                    CheckArrIsEmpty($all,["icon_css"]);
                    $FaqCategory = new AgreementCategory();
                    $return = $FaqCategory->InsertArr($all);
                    break;
                case "categoryEdit":
                    CheckArrIsEmpty($all,["icon_css"]);
                    $FaqCategory = new AgreementCategory();
                    $return = $FaqCategory->UpdateArr($all);
                    break;
                default :
                    return ["stauts"=>40000,"msg"=>"Method does not exist"];
            }
            return $return;
        }else return ["stauts"=>40000,"msg"=>"method error,must post method"];
    }
}