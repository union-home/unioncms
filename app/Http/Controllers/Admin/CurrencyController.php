<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{


    //多货币
    function currency(){

        if (isset($_GET["id"]) && $_GET["id"]){
            if(Currency::destroy($_GET["id"])){
                session()->flash("successmsg","删除成功！");
            }else{
                session()->flash("errormsg","删除失败！");
            }
        }




        $currency = Currency::orderBy('create_at','desc')->paginate(__E('admin_page_count'));


        return view("admin/".ADMIN_SKIN."/settings/currency",["currency"=>$currency]);
    }

    //多货币添加
    function add(){

        return view("admin/".ADMIN_SKIN."/settings/currencyAdd",["currency"=>[]]);
    }

    //多货币编辑
    function edit(){
        if (isset($_GET["id"]) && $_GET["id"]){
            $currency = Currency::find($_GET["id"]);
            if(!$currency){
                session()->flash("errormsg","数据不存在！");
                return redirect("admin/currency");
            }else{
                $currency = $currency->toArray();
            }
        }

        return view("admin/".ADMIN_SKIN."/settings/currencyEdit",["currency"=>$currency]);
    }



    //处理操作
    function Submit(){
        if($this->request->ismethod('post')){

            $all = $this->request->all();

            $currenty = new Currency();

            switch ($all['form'])
            {
                case "add":

                    CheckArrIsEmpty($all);

                    $currenty->InsertArr($all);

                    break;

                case "edit":

                    CheckArrIsEmpty($all);

                    $currenty->UpdateArr($all);

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
