<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notice;
use App\Models\NoticeCategory;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    //列表
    function notice(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $notice = notice::select("notice.*","notice_category.name as category_name")->orderBy('create_at','desc')
                ->join("notice_category","notice.qcid","=","notice_category.id");
        if(!empty($params['search'])) $notice = $notice->where('notice.title', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/".ADMIN_SKIN."/notice/index", [ "notice" => $notice->paginate(__E('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(){

        $category = noticeCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }


        return view("admin/".ADMIN_SKIN."/notice/add",["category"=>$category]);
    }

    //编辑
    function edit($id){

        $data = notice::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        $category = noticeCategory::orderBy('create_at','desc')->get();

        if($category){
            $category=$category->toArray();
        }else{
            $category = [];
        }

        return view("admin/".ADMIN_SKIN."/notice/edit",["data"=>$data,"category"=>$category]);
    }

    //删除
    function noticeDelete($id){

        $data = notice::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(notice::destroy($id)){
            return back()->with("successmsg","删除成功！");
        }

        return back()->with("errormsg","删除失败！");

    }

    //类别
    function category(){

        $category = noticeCategory::orderBy('create_at','desc')->paginate(__E('admin_page_count'));



        return view("admin/".ADMIN_SKIN."/notice/category",["category"=>$category]);
    }

    //类别
    function categoryAdd(){

        return view("admin/".ADMIN_SKIN."/notice/categoryAdd");
    }

    //类别
    function categoryEdit($id){

        $data = noticeCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        return view("admin/".ADMIN_SKIN."/notice/categoryEdit",["data"=>$data]);
    }

    //类别删除
    function categoryDel($id){

        $data = noticeCategory::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(noticeCategory::destroy($id)){
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

                    $notice = new notice();
                    $all['add_uid'] = session("admin_info")['uid'];
                    $notice->InsertArr($all);



                    break;

                case "edit":

                    CheckArrIsEmpty($all);

                    $notice = new notice();

                    $notice->UpdateArr($all);

                    break;

                case "categoryAdd":

                    CheckArrIsEmpty($all,["icon_css"]);

                    //过滤参数
                    if($all["icon_type"]=="css"){
                        $all["icon"] = $all["icon_css"];
                    }else if($all["icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['icon_img'])){
                            $pre_icon = UploadFile($this->request,"icon_img","notice/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $noticeCategory = new noticeCategory();


                    $noticeCategory->InsertArr($all);

                    break;

                case "categoryEdit":

                    CheckArrIsEmpty($all,["icon_css"]);

                    //过滤参数
                    if($all["icon_type"]=="css"){
                        $all["icon"] = $all["icon_css"];
                    }else if($all["icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['icon_img'])){
                            $pre_icon = UploadFile($this->request,"icon_img","notice/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['icon'] = $pre_icon;
                            }
                        }
                    }

                    $noticeCategory = new noticeCategory();


                    $noticeCategory->UpdateArr($all);

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
