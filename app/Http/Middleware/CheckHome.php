<?php

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;

class CheckHome
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
        if (!session(Member::LOGIN_UNIQUE)){
            /**
             * 不同的模块，返回自己的登陆界面
             */
            $prefix = request()->route()->getPrefix();
            if (!empty($prefix) && strstr($prefix, 'module')) {
                $url = 'module/' . explode('/', $prefix)[1] . '/login';
                $routes = Cache::get('allRoutes');
                if(!$routes){
                    $res = app('router')->getRoutes();
                    //Cache::put('allRoutes', $res, 60);//添加一个缓存 Cache::get('allRoutes');
                    foreach($res as $route) {
                        if($route->uri==$url){
                            Cache::put('allRoutes', true, 60);
                            return redirect($url);
                        };
                    }
                }else{
                    return redirect($url);
                }
            }
            //获取当前路径，登录后依然回到该路径
            session()->put("previous",url()->current());
            return redirect("/login");
        }
        return $next($request);
    }
}
