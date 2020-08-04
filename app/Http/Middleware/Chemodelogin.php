<?php

namespace App\Http\Middleware;

use App\Events\CheckVersionUpdate;
use Closure;


class Chemodelogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          
        //检查是否登录，权限检查
        if (empty(session("admin_info"))){
            //获取当前路径，登录后依然回到改路径

            session()->put("previous",url()->current());
            return redirect("module/admin/unionH5/alogin");
        }


        //判断权限
        if(session("admin_info")["gid"]!=="0"){

            $url_detail = $request->route()->getAction();

            //判断过滤的URL
            if(!in_array($url_detail["permissions"],IGNOREAUTH)){
                if(!isset(session("auth_info")[$url_detail["permissions"]])){

                    //中间间不能直接返回view
                    return response()->view("admin/".ADMIN_SKIN."/prompt",["data"=>['message'=>'没有权限！','url' =>url()->previous(), 'jumpTime'=>3,'status'=>false]]);

                }
            }

        };

        dd(888);

              
        event(new CheckVersionUpdate($request));

        return $next($request);
    }
}




