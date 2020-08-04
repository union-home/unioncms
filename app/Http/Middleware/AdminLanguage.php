<?php

namespace App\Http\Middleware;

use App;
use Closure;
use App\Models\Language;

class AdminLanguage
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
        if(!isset(session("admin_current_language")["shortcode"])){
            // 设置，默认语言

            $language = new Language();

            $data = $language->GetdataByFiled("shortcode",cacheGlobalSettingsByKey("default_language"),"admin");

            $array = array(
                "icon"=>UPLOADPATH.$data["icon"],
                "shortcode" => $data["shortcode"],
                "name"=>$data["name"]
            );

            session()->put("admin_current_language",$array);
        }
        //设置当前语言的目录
        //App::setLocale(session("admin_current_language")["shortcode"]);

        App::setLocale("admin");

        return $next($request);
    }
}
