<?php

namespace App\Http;

use App\Http\Middleware\GlobalConstant;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        GlobalConstant::class,//全局常量中间件
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'Chemodelogin'     =>\App\Http\Middleware\Chemodelogin::class,   //H5模块登录检测
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'AdminLanguage' =>\App\Http\Middleware\AdminLanguage::class,
        'HomeLanguage' =>\App\Http\Middleware\HomeLanguage::class,
        'CheckAdmin'=> \App\Http\Middleware\CheckAdmin::class,
        'CheckHome'=> \App\Http\Middleware\CheckHome::class,
        'CheckWeChat'=> \App\Http\Middleware\CheckWeChat::class,
        'cors' => \App\Http\Middleware\Cors::class,
        'jwt.auth'=>\App\Http\Middleware\authJWT::class,
        'checkInstall'=>\App\Http\Middleware\CheckInstall::class,//检测应用是否安装
        'checkIpBlacklist' => \App\Http\Middleware\CheckIpBlacklist::class,//检测IP黑名单
        'home.visitlog'=> \App\Http\Middleware\HomeVisitLog::class,//全部Home模块的访问记录
        'appleapi.jwt.auth'=> \App\Http\Middleware\CnpscyAuthJwt::class,
        
    ];

}
