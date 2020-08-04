<?php

namespace App\Http\Controllers\Admin;

use App\Events\Login;
use App\Models\Member;
use App\Models\MenuGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;

class LoginController extends Controller
{
    function __construct(Request $request)
    {
        parent::__construct($request);
        $request = $request;
        // 验证是否登录
        $this->middleware(function ( Request $request, Closure $next) {
            if (session("admin_info")){
                //返回上一层，带上已登录提示
                return redirect("/admin")->with("errormsg","已登录过!");
                exit();
            }
            return $next($request);
        });


    }

    //login
    function login(){

        if($this->request->isMethod("post")){

            $post = $this->request->all();

            //记住登录
            if(isset($post["is_remember"]) && $post["is_remember"]=="on"){
                session()->put(["admin_remember"=>$post["username"],"is_remember"=>"on"]);
            }else{
                session()->forget(["admin_remember","is_remember"]);
            }

            if(cacheGlobalSettingsByKey("admin_login_code")==1){

                //验证码验证码
                $this->validate($this->request, [
                    'captcha'  => 'required|captcha'
                ],[
                    'captcha.required' => '请填写验证码',
                    'captcha.captcha' => '验证码错误',
                ]);
            }

            if(!isset($post["password"]) || !isset($post["username"])){

                return back()->withErrors(['用户名或者密码必填！'])->withInput();
            }


            //判断空值处理
            $frist = Member::Where("password","=",md5("union_".md5($post["password"])))
                     ->where("username","=",$post["username"])
                     ->orwhere("email","=",$post["username"])
                     ->orWhere("phone","=",$post["username"])
                     ->first();

            if(!$frist){
                return back()->withErrors(['用户名或者密码错误！'])->withInput();
            }

            //更新登录信息
            $frist = $frist->toArray();


            //存放登录记录
            $login_info = array(
                            'admin_info'=>$frist
                        );

            if(isset($frist["gid"])){
                $MenuGroup = new MenuGroup();

                $auth_info = $MenuGroup->AuthLists($frist["gid"]);

            }else{
                $auth_info =null;
            }

            //存放权限信息
            $auth_info = array(
                            'auth_info'=>$auth_info
                        );

            $this->request->session()->put($login_info);
            $this->request->session()->put($auth_info);

            //登录后台的事件
            event(new Login($this->request));

            //返回上一级
            if(session("admin_previous")){
                return redirect(session("admin_previous"));
            }
            return redirect("/admin/index");

        }else if($this->request->isMethod("get")){

            return view("admin/".ADMIN_SKIN."/login/login");

        }

        return ;
    }
}
