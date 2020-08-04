<?php

namespace App\Http\Middleware;

use App;
use Closure;
use App\Models\Language;

class HomeLanguage
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

        if(is_install()){
            if(!isset(session("home_current_language")["shortcode"])){
                // 设置，默认语言

                $language = new Language();

                $data = $language->GetdataByFiled("shortcode",cacheGlobalSettingsByKey("default_language"),"home");
                //如果默认语言不存在，怎么办？
                //？？？
                //？？
                //？？
                $array = array(
                    "icon"=>UPLOADPATH.$data["icon"],
                    "shortcode" => $data["shortcode"],
                    "name"=>$data["name"]
                );

                session()->put("home_current_language",$array);
            }

            //设置当前语言
            App::setLocale(session("home_current_language")["shortcode"]);
        }

        return $next($request);
    }
}
