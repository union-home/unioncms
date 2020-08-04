<?php

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;

/**
 * Home 模块访问记录
 * Class HomeVisitLog
 * @package App\Http\Middleware
 */
class HomeVisitLog
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
        if(is_install()) { //如果未安装程序，屏蔽所有数据表查询
            $login_user = session(Member::LOGIN_UNIQUE);
            $uid = empty($login_user) ? 0 : $login_user['uid'];
            \App\Models\HomeVisitLog::createLog(['uid' => $uid]);
        }

        return $next($request);
    }
}
