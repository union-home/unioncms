<?php

namespace App\Http\Controllers\Admin;

use App\Models\Functions;
use App\Models\Menu;
use App\Models\MenuGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    //前台导航
    function home(){

        $data = Menu::getAll("home");

        $menu = listToTree($data,"id","pid","sub",'0');

        return view("admin/".ADMIN_SKIN."/menu/home",["data"=>$menu]);
    }

    //前台导航添加
    function homeAdd(){

        $menu = Menu::getAll("home");

        $menu = listToTree($menu,"id","pid","sub",'0');

        return view("admin/".ADMIN_SKIN."/menu/homeAdd",["menu"=>$menu]);
    }


    //前台导航编辑
    function homeEdit($id){

        $data = Menu::find($id);

        if(!$data){
            return back()->withErrors("数据不存在！");
        }

        $menu = Menu::getAll("home",$id);

        $menu = listToTree($menu,"id","pid","sub",'0');


        return view("admin/".ADMIN_SKIN."/menu/homeEdit",["data"=>$data->toArray(),"menu"=>$menu]);
    }



    //后台导航
    function admin(){

        $data = Menu::getAll("admin");

        $menu = listToTree($data,"id","pid","sub",'0');

        return view("admin/".ADMIN_SKIN."/menu/admin",["data"=>$menu]);

    }

    //后台导航添加
    function adminAdd(){

        $menu = Menu::getAll("admin");

        $menu = listToTree($menu,"id","pid","sub",'0');

        return view("admin/".ADMIN_SKIN."/menu/adminAdd",["menu"=>$menu]);
    }


    //后台导航编辑
    function adminEdit($id){

        $data = Menu::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        $menu = Menu::getAll("admin",$id);

        $menu = listToTree($menu,"id","pid","sub",'0');


        return view("admin/".ADMIN_SKIN."/menu/adminEdit",["data"=>$data->toArray(),"menu"=>$menu]);
    }

    //删除
    function delete($id){
        $data = Menu::deleteById($id);

        if(!$data){
            return back()->with("errormsg","数据不存在或者下级菜单存在！");
        }else{
            //清空缓存
            Cache::forget("menus");
            return back()->with("successmsg","删除成功！");
        }
    }


    //权限管理
    function group(){


        $MenuGroup = MenuGroup::orderBy('create_at','desc')->paginate(__E('admin_page_count'));


        return view("admin/".ADMIN_SKIN."/menu/group",["menugroup"=>$MenuGroup]);

    }

    //权限组添加
    function group_add(){

        return view("admin/".ADMIN_SKIN."/menu/groupAdd");
    }

    //权限组删除
    function group_delete($id){

        $data = MenuGroup::deleteById($id);

        if(!$data){
            return back()->with("errormsg","数据不存在或者存在权限组的人员！");
        }else{

            return back()->with("successmsg","删除成功！");
        }

    }


    //权限编辑
    function group_auth($gid){

        if(!isset($gid)){
            return back()->with("errormsg","参数不存在！");
        }

        $data = Functions::getAll("");

        $function = listToTree($data,"id","pid","sub",'0');

        $group_detail = MenuGroup::where("id","=",$gid)->first()->toArray();

        return view("admin/".ADMIN_SKIN."/menu/groupAuth",["function"=>$function,"gid"=>$gid,"fid_lists"=>explode(",",$group_detail["fid_lists"])]);
    }

    //权限列表
    function auth(){

        $data = Functions::getAll("");

        $menu = listToTree($data,"id","pid","sub",'0');

        return view("admin/".ADMIN_SKIN."/menu/auth",["data"=>$menu]);
    }

    //权限添加
    function auth_add(){

        $data = Functions::getAll("",null);

        $function = listToTree($data,"id","pid","sub",'0');

        return view("admin/".ADMIN_SKIN."/menu/authAdd",["function"=>$function]);
    }

    //权限编辑
    function auth_edit($id){

        $data = Functions::find($id);

        if(!$data){
            return back()->with("errormsg","数据不存在！");
        }

        $function = Functions::getAll($id);

        $function = listToTree($function,"id","pid","sub",'0');

        return view("admin/".ADMIN_SKIN."/menu/authEdit",["function"=>$function,"data"=>$data->toArray()]);
    }

    //权限删除
    function auth_delete($id){

        $data = Functions::deleteById($id);

        if(!$data){
            return back()->with("errormsg","数据不存在或者下级菜单存在！");
        }else{

            return back()->with("successmsg","删除成功！");
        }

    }


   //处理
    function submit(){


        if($this->request->ismethod('post')){

            $all = $this->request->all();

            $menu = new Menu();

            switch ($all['form'])
            {
                case "add":

                    CheckArrIsEmpty($all,array("pre_icon_css","suf_icon_css"));

                    //过滤参数
                    if($all["pre_icon_type"]=="css"){
                        $all["pre_icon"] = $all["pre_icon_css"];
                    }else if($all["pre_icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['pre_icon_img'])){
                            $pre_icon = UploadFile($this->request,"pre_icon_img","menu/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['pre_icon'] = $pre_icon;
                            }
                        }
                    }

                    if($all["suf_icon_type"]=="css"){
                        $all["suf_icon"] = $all["suf_icon_css"];
                    }else if($all["suf_icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['suf_icon_img'])){
                            $suf_icon = UploadFile($this->request,"suf_icon_img","menu/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($suf_icon){
                                $all['suf_icon'] = $suf_icon;
                            }
                        }
                    }

                    $menu->InsertArr($all);

                    //清空缓存
                    Cache::forget("menus");



                    break;

                case "edit":

                    CheckArrIsEmpty($all,array("pre_icon_css","suf_icon_css"));

                    //过滤参数
                    if($all["pre_icon_type"]=="css"){
                        $all["pre_icon"] = $all["pre_icon_css"];
                    }else if($all["pre_icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['pre_icon_img'])){
                            $pre_icon = UploadFile($this->request,"pre_icon_img","menu/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($pre_icon){
                                $all['pre_icon'] = $pre_icon;
                            }
                        }
                    }

                    if($all["suf_icon_type"]=="css"){
                        $all["suf_icon"] = $all["suf_icon_css"];
                    }else if($all["suf_icon_type"]=="img"){
                        //文件上传
                        if(isset($_FILES['suf_icon_img'])){
                            $suf_icon = UploadFile($this->request,"suf_icon_img","menu/".date("Y-m-d")."/".uniqid(),ALLOWEXT,__E("upload_driver"));
                            if($suf_icon){
                                $all['suf_icon'] = $suf_icon;
                            }
                        }
                    }

                    $menu->UpdateArr($all);

                    //清空缓存
                    Cache::forget("menus");

                    break;

                case "group_add":

                    CheckArrIsEmpty($all);

                    $MenuGroup = new MenuGroup();

                    $MenuGroup->InsertArr($all);

                    break;


                case "authAdd":

                    CheckArrIsEmpty($all);

                    $function = new Functions();

                    $function->InsertArr($all);

                    break;

                case "authEdit":

                    CheckArrIsEmpty($all);

                    $function = new Functions();

                    $function->UpdateArr($all);


                    break;

                case "groupAuth":

                    $member_group = new MenuGroup();
                    $all["id"] = $all['gid'];
                    $all["fid_lists"] =implode(",",$all['fid_list']);

                    $member_group->UpdateArr($all);

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
