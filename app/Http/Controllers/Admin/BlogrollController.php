<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blogroll;
use App\Http\Controllers\Controller;

class BlogrollController extends Controller
{
    //列表
    function index(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $case = Blogroll::orderBy('create_at','desc');
        if(!empty($params['search'])) $case = $case->where('title', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/".ADMIN_SKIN."/blogroll/index",["case"=>$case->paginate(__E('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(){
        return view("admin/".ADMIN_SKIN."/blogroll/add",[]);
    }

    //编辑
    function edit($id){

        $data = Blogroll::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        return view("admin/".ADMIN_SKIN."/blogroll/edit",["data"=>$data]);
    }

    //删除
    function delete($id){

        $data = Blogroll::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        if(Blogroll::destroy($id)){
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
                    if($_FILES['cover']["size"]>0){
                        $pre_icon = UploadFile($this->request,"cover","blogroll/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }

                    $roll = new Blogroll();

                    $roll->InsertArr($all);



                    break;

                case "edit":

                    CheckArrIsEmpty($all,["cover"]);


                    if($_FILES['cover']["size"]>0){
                        $pre_icon = UploadFile($this->request,"cover","blogroll/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                        if($pre_icon){
                            $all['cover'] = $pre_icon;
                        }
                    }

                    $roll = new Blogroll();

                    $roll->UpdateArr($all);

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
