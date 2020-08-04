<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Module\comMission\Home\WeChatController;
use Closure;

class CheckWeChat
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
        //判断是否是微信浏览器，和是否有微信登录

        return $next($request);
    }
}
