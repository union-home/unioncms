<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    //单页列表
    function pages(){
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $pages = Pages::orderBy('create_at','desc');
        if(!empty($params['search'])) $pages = $pages->where('name', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/".ADMIN_SKIN."/pages/pages",["pages"=>$pages->paginate(cacheGlobalSettingsByKey('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(){

        return view("admin/".ADMIN_SKIN."/pages/add");

    }

    //编辑
    function edit($id){

        $page = Pages::find($id);

        if(!$page){
            return back()->withErrors("数据不存在！");
        }

        return view("admin/".ADMIN_SKIN."/pages/edit",["page"=>$page]);

    }





    //处理
    function submit(){

        $all = $this->request->all();

        switch ($all['form'])
        {
            case "add":

                CheckArrIsEmpty($all);

                $page = new Pages();
                $res = $page->InsertArr($all);

                if(!$res){
                    return ["stauts"=>40000,"msg"=>"Add data error!"];
                }

                break;

            case "edit":

                CheckArrIsEmpty($all);

                $page = new Pages();

                $page->UpdateArr($all);

                break;



            default :

                return ["stauts"=>40000,"msg"=>"Method does not exist"];
        }

        return ["stauts"=>200,"msg"=>"success"];

    }

}
