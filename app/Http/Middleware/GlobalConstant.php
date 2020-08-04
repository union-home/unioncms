<?php

namespace App\Http\Middleware;

use Closure;

class GlobalConstant
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
        //主题路径
        define("ADMIN_SKIN_PATH", "views/admin/");
        define("HOME_SKIN_PATH","views/home/");
        define("INSTALL_SKIN_PATH","views/install/");
        define("THEME_TEMPLATE_SKIN_PATH", base_path() . '/public/' . HOME_SKIN_PATH);

        //模块路径
        define("MODULE_PATH",app_path()."/Http/Controllers/Module/");
        define("MODULE_VIEW","views/module/");
        define("MODULE_ADMIN_VIEW","views/admin/default/module/");

        //前台的module路径
        define("MODULE_ASSET",asset(MODULE_VIEW));
        //后台的module路径
        define("MODULE_ADMIN_ASSET",asset(MODULE_ADMIN_VIEW));

        //检测主题
        define("ADMIN_SKIN","default");

        define("HOME_SKIN",env("THEME","default"));
        //admin 路径
        define("ADMIN_ASSET",asset(ADMIN_SKIN_PATH.ADMIN_SKIN).'/');
        //前台路径
        define("HOME_ASSET",asset(HOME_SKIN_PATH.HOME_SKIN).'/');
        //安装路径
        define("INSTALL_ASSET",asset(INSTALL_SKIN_PATH).'/');

        //本地上传路径
        define("UPLOADPATH",asset("/")."uploads/");
        //默认允许的上传文件格式
        define("ALLOWEXT","png,jpeg,jpg,gif,zip,rar,pdf,doc,txt,xls,avi,mp3,mp4");
        //忽略权限判断
        define("IGNOREAUTH",array("","logout"));

        //插件路径
        define("PLUGIN_PATH",app_path()."/Plugin/");
        define("PLUGIN_PATH_FILE",app_path()."/Http/Controllers/Plugin/");

        return $next($request);
    }
}
