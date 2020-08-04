<?php

namespace App\Http\Controllers\Admin;

use App\Libs\backup\BackUpDB;
use App\Models\Modules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class ToolsController extends Controller
{
    //安全设置
    function safe(){

        return view("admin/".ADMIN_SKIN."/tools/safe");
    }

    //缓存设置
    function cache(){

        return view("admin/".ADMIN_SKIN."/tools/cache");
    }

    //上传设置
    function upload(){
        //获取当前所有的上传插件
        $plugin_sms_list = event(new \App\Events\GetPluginUploadConfig($this->request, __E('upload_driver')));

        /**
         * 过滤掉，当前尚未开启的插件，只展示开启状态的插件
         */
        $has_plugin_list = Modules::where([
                'cloud_type' => 1, //插件类型
                'status' => 1, //启用
            ])->whereIn('identification', array_column($plugin_sms_list, 'identification'))->pluck('identification')->toArray();
        $local_start_plugin_list = [];
        if(!empty($has_plugin_list))
        {
            foreach($plugin_sms_list as &$plugin){
                if(in_array($plugin['identification'], $has_plugin_list)) $local_start_plugin_list[] = $plugin;
            }
        }

        return view("admin/".ADMIN_SKIN."/tools/upload", [
            'plugin_list' => $local_start_plugin_list,
        ]);
    }

    //数据维护
    function tables(){

        //$sql = "select * from information_schema.tables where table_schema='".env('DB_DATABASE')."'";
        $sql="SHOW TABLE STATUS FROM " . env('DB_DATABASE');
        //获取所有表
        $tables = \DB::select($sql);

        return view("admin/".ADMIN_SKIN."/tools/tables",['tables'=>$tables]);
    }

    //数据恢复
    function recover(){

        $basedir = base_path()."/backup/";
        if(!is_dir($basedir)){
            mkdir($basedir,0777);
        }
        $files = getDirContent($basedir);

        return view("admin/".ADMIN_SKIN."/tools/recover",["files"=>$files,"basedir"=>$basedir]);

    }

    function tableSubmit(){

        if($this->request->ismethod('post')){

            $all = $this->request->all();
            /*
             *

            REPAIR TABLE `table_name` 修复表
            OPTIMIZE TABLE `table_name` 优化表

            */
            switch ($all['form'])
            {
                case "optimize":

                    if(!empty($all['table'])){

                        foreach ($all['table'] as $value){
                            $sql="OPTIMIZE TABLE `".$value."`";
                            //获取所有表
                            $tables = \DB::select($sql);
                        }

                    }else{
                        return ["stauts"=>40000,"msg"=>"data must need!"];
                    }
                    break;

                case "repair":

                    if(!empty($all['table'])){

                        foreach ($all['table'] as $value){
                            $sql="REPAIR TABLE `".$value."`";
                            //获取所有表
                            $tables = \DB::select($sql);
                        }

                    }else{
                        return ["stauts"=>40000,"msg"=>"data must need!"];
                    }
                    break;

                case "backup":

                    $db = new \App\Libs\backup\BackUpDB();

                    $db->backupDB($all);

                    break;

                case "del":

                    if(isset($all["filename"]) && file_exists(base_path().'/backup/'.$all["filename"])){
                        unlink(base_path().'/backup/'.$all["filename"]);
                    }

                    if(isset($all["table"])){
                        if(count($all["table"]) > 0){
                            foreach ($all["table"] as $val){
                                if(file_exists(base_path().'/backup/'.$val)){
                                    unlink(base_path().'/backup/'.$val);
                                }
                            }
                        }else{
                            return ["stauts"=>40000,"msg"=>"Please select a data！"];
                        }

                    }


                    break;

                case "recover":

                    if(isset($all["filename"]) && file_exists(base_path().'/backup/'.$all["filename"])){
                        //导入数据
                        $db = new \App\Libs\backup\BackUpDB();

                        $db->ImportSql(base_path().'/backup/'.$all["filename"]);
                    }else{
                        return ["stauts"=>40000,"msg"=>"Data does not exist！"];
                    }



                    break;

                default :

                    return ["stauts"=>40000,"msg"=>"Method does not exist"];
            }


            return ["stauts"=>200,"msg"=>"success"];

        }else{
            return ["stauts"=>40000,"msg"=>"method error,must post method"];
        }
    }

    //提交处理
    function toolSubmit(){

        if($this->request->ismethod('post')){

            $all = $this->request->all();

            switch ($all['form'])
            {
                case "safe":

                    if($all['COOKIE_NAME']){
                        $env['COOKIE_NAME'] = $all['COOKIE_NAME'];
                    }

                    if($all['SESSION_DOMAIN']){
                        $env['SESSION_DOMAIN'] = $all['SESSION_DOMAIN'];
                    }

                    if($all['SESSION_DRIVER']){
                        $env['SESSION_DRIVER'] = $all['SESSION_DRIVER'];
                    }

                    if($all['SESSION_LIFETIME']){
                        $env['SESSION_LIFETIME'] = $all['SESSION_LIFETIME'];
                    }

                    if($all['SESSION_ENCRYPT']){
                        $env['SESSION_ENCRYPT'] = $all['SESSION_ENCRYPT'];
                    }





                    $settings=[];
                    $in_database = [
                        'limit_count',
                        'limit_time',
                        'filter_strings',
                        'blacklist_ip',
                        'admin_login_code',
                        'home_submit_code'
                    ];
                    foreach ($all as $key => $value){
                        if(in_array($key,$in_database)){
                            array_push($settings,[ 'key' => $key, 'value' => $value]);
                        }
                    }

                    modifyEnv($env);
                    $setting = new Setting;
                    $setting->updateBatch($settings);
                    //更新缓存

                    Cache::forget('settings');
                    break;

                case "cache":

                    if($all['CACHE_PREFIX']){
                        $env['CACHE_PREFIX'] = $all['CACHE_PREFIX'];
                    }

                    if($all['CACHE_DRIVER']){
                        $env['CACHE_DRIVER'] = $all['CACHE_DRIVER'];
                    }

                    if($all['REDIS_HOST']){
                        $env['REDIS_HOST'] = $all['REDIS_HOST'];
                    }

                    if($all['REDIS_PASSWORD']){
                        $env['REDIS_PASSWORD'] = $all['REDIS_PASSWORD'];
                    }

                    if($all['REDIS_PORT']){
                        $env['REDIS_PORT'] = $all['REDIS_PORT'];
                    }

                    if($all['MEMCACHED_HOST']){
                        $env['MEMCACHED_HOST'] = $all['MEMCACHED_HOST'];
                    }

                    if($all['MEMCACHED_USERNAME']){
                        $env['MEMCACHED_USERNAME'] = $all['MEMCACHED_USERNAME'];
                    }

                    if($all['MEMCACHED_PASSWORD']){
                        $env['MEMCACHED_PASSWORD'] = $all['MEMCACHED_PASSWORD'];
                    }

                    if($all['MEMCACHED_PORT']){
                        $env['MEMCACHED_PORT'] = $all['MEMCACHED_PORT'];
                    }


                    modifyEnv($env);



                    break;

                case "upload":

                    $settings=[];
                    $in_database = [
                        'upload_status',
                        'upload_limit',
                        'upload_format',
                        'upload_driver',
                        'thumb_auto',
                        'thumb_method',
                        'watermark_type',
                        'watermark_position',
                        'watermark_text',
                        'watermark_text_size',
                        'watermark_text_angle',
                        'watermark_text_color',
                        //'watermark_img',等等图片完成后开放

                    ];
                    foreach ($all as $key => $value){
                        if(in_array($key,$in_database)){
                            array_push($settings,[ 'key' => $key, 'value' => $value]);
                        }
                    }

                    $setting = new Setting;
                    $setting->updateBatch($settings);

                    if(isset($all['qiniu_domain'])){
                        $env['qiniu_domain'] = $all['qiniu_domain'];
                    }else{
                        $env['qiniu_domain'] = "";
                    }
                    if(isset($all['qiniu_https_domain'])){
                        $env['qiniu_https_domain'] = $all['qiniu_https_domain'];
                    }else{
                        $env['qiniu_https_domain'] = "";
                    }
                    if(isset($all['qiniu_custom_domain'])){
                        $env['qiniu_custom_domain'] = $all['qiniu_custom_domain'];
                    }else{
                        $env['qiniu_custom_domain'] = "";
                    }
                    if(isset($all['qiniu_access_key'])){
                        $env['qiniu_access_key'] = $all['qiniu_access_key'];
                    }else{
                        $env['qiniu_access_key'] = "";
                    }
                    if(isset($all['qiniu_secret_key'])){
                        $env['qiniu_secret_key'] = $all['qiniu_secret_key'];
                    }else{
                        $env['qiniu_secret_key'] = "";
                    }
                    if(isset($all['qiniu_bucket'])){
                        $env['qiniu_bucket'] = $all['qiniu_bucket'];
                    }else{
                        $env['qiniu_bucket'] = "";
                    }
                    if(isset($all['qiniu_notify_url'])){
                        $env['qiniu_notify_url'] = $all['qiniu_notify_url'];
                    }else{
                        $env['qiniu_notify_url'] = "";
                    }


                    if(isset($env)) modifyEnv($env);


                    //更新缓存

                    Cache::forget('settings');

                    event(new \App\Events\SetPluginUploadConfig($this->request, $all['upload_driver'], $all));
                    break;

                default :

                    return ["stauts"=>40000,"msg"=>"Method does not exist"];
            }


            return ["stauts"=>200,"msg"=>"success"];

        }else{
            return ["stauts"=>40000,"msg"=>"method error,must post method"];
        }
    }


    //清空缓存
    function clearCache(){
        //var_dump(Artisan::call("view:clear"));
        //PHP7.0不报错
        Artisan::call("view:clear");
        Artisan::call("cache:clear");
        Artisan::call("config:clear");
        Artisan::call("route:clear");
        Artisan::call("clear-compiled");

        //重新生成缓存，判断运行模式（是否开启调式模式）
        if(!env("APP_DEBUG")){ //关闭调式模式，需要重新生成
            // Artisan::call("config:cache");
            // Artisan::call("route:cache");
            // Artisan::call("optimize");
        }
        return ["stauts"=>200,"msg"=>"success"];
    }
}