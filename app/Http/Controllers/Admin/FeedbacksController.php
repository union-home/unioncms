<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbacksController extends Controller
{
    function index(){
        $datas = Feedback::orderBy('create_at','desc')->paginate(cacheGlobalSettingsByKey('admin_page_count'));
        return view("admin/".ADMIN_SKIN."/feedbacks/index",["datas"=>$datas]);
    }

    //编辑
    function edit($id){
        $page = Feedback::find($id);
        if(!$page) return back()->withErrors("数据不存在！");
        return view("admin/".ADMIN_SKIN."/feedbacks/edit",["page"=>$page]);
    }

    //处理
    function submit(){
        $all = $this->request->all();
        switch ($all['form'])
        {
            case "edit":
                CheckArrIsEmpty($all);
                $page = new Feedback();
                $page->UpdateArr($all);
                break;
            default :
                return ["stauts"=>40000,"msg"=>"Method does not exist"];
        }
        return ["stauts"=>200,"msg"=>"success"];
    }

    //删除
    function delete($id){
        $data = Feedback::find($id);
        if(!$data) return back()->with("errormsg","数据不存在！");
        if(Feedback::destroy($id)) return back()->with("successmsg","删除成功！");
        return back()->with("errormsg","删除失败！");
    }

}
