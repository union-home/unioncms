<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use App\Models\Modules;
use App\Models\Setting;
use App\Models\TemplateMessage;
use App\Models\Themes;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Libs\license\license;


class SettingsController extends Controller
{
    //base 设置
    function base(){
        $contact = new \App\Models\ContactUs();

        $contact_data = $contact::all();

        if(count($contact_data)>0){
            $contact_data = $contact_data->toArray();
        }else{
            $contact_data = [];
            $contact_data[0]['cid']="";
            $contact_data[0]['address']="";
            $contact_data[0]['personal']=json_encode([['name'=>'','contact'=>'']]);
        }
        //获取当前所有的SMS插件
        $plugin_sms_list = event(new \App\Events\GetPluginSmsConfig($this->request, __E('sms_driver')));

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

        return view("admin/".ADMIN_SKIN."/settings/base", [
            'contact_data'=>$contact_data,
            'plugin_list' => $local_start_plugin_list,
            'template_list' => TemplateMessage::getAdminList(),
            'template_type' => TemplateMessage::TEMPLATE_TYPE,
        ]);
    }

    //base 提交
    function baseSubmit(){

        if($this->request->ismethod('post')){

            $all = $this->request->all();

            switch ($all['form'])
            {
                case "website":

                    //文件上传
                    if(isset($_FILES['weblogo']) && $_FILES['weblogo']["size"]>0){
                        $weblogo = UploadFile($this->request,"weblogo","website/logo",ALLOWEXT,__E("upload_driver"));
                        if($weblogo){
                            $all['weblogo'] = $weblogo;
                        }
                    }
                    if(isset($_FILES['webicon']) && $_FILES['webicon']["size"]>0){
                       //$webicon = UploadFile($this->request,"webicon","website/webicon","jpg,png,gif","local");
                        $webicon = icoImg();
                       if($webicon){
                           $all['webicon'] = $webicon;
                       }
                    }


                    if($all['website_debug']){
                        $env['APP_DEBUG'] = $all['website_debug'];
                    }

                    if(isset($all['APP_LOG'])){
                        $env['APP_LOG'] = $all['APP_LOG'];
                    }

                    if(isset($all['LOG_LEVEL'])){
                        $env['LOG_LEVEL'] = $all['LOG_LEVEL'];
                    }

                    $settings=[];
                    $in_database = [
                        'website_name',
                        'weblogo',
                        'webicon',
                        'website_keys',
                        'website_desc',
                        'website_open_reg',
                        'website_reg_rqstd',
                        'multi_currency',
                        'default_currency',
                        'multilingual',
                        'default_language',
                        'website_statut',
                        'website_statut_when',
                        'admin_page_count',
                        'Useofcloud'    // 是否开启云  by andy update 2019-12-31
                        ];
                    foreach ($all as $key => $value){
                        if(in_array($key,$in_database)){
                            if($key=='website_reg_rqstd'){
                                $value = implode(",", $value);
                            }
                            array_push($settings,[ 'key' => $key, 'value' => $value]);
                        }
                    }

                    if(isset($env)){
                        modifyEnv($env);
                    }

                    $setting = new Setting;
                    $setting->updateBatch($settings);
                    //更新缓存
                    Cache::forget('settings');
                    break;

                case "contact":
                    $updates = [];
                    $inserts = [];

                    if($all['form_data']){
                        foreach ($all['form_data'] as $value){
                            if(!$value['address']){
                                continue;
                            }
                            if(isset($value['cid']) && $value['cid']){ // 更新
                                $updates[] = array(
                                    'cid' =>$value['cid'],
                                    'company_name'=>$value['company_name'],
                                    'address' => $value['address'],
                                    'personal' => json_encode(filterEmptyArr($value['personal']),JSON_UNESCAPED_UNICODE),
                                    'update_at' => date("Y-m-d H:i:s")
                                );
                            }else{             //插入
                                $inserts[] = array(
                                    'address' => $value['address'],
                                    'company_name'=>$value['company_name'],
                                    'personal' => json_encode(filterEmptyArr($value['personal']),JSON_UNESCAPED_UNICODE),
                                    'create_at' => date("Y-m-d H:i:s")
                                );
                            }
                        }

                    }

                    $contact = new \App\Models\ContactUs();

                    if(count($updates)){
                        $contact->updateBatch($updates);
                    }

                    if(count($inserts)){
                        $contact->insert($inserts);
                    }

                    if(isset($all["del_cid"]) && $all["del_cid"]){
                        $contact->deleteByIdList($all["del_cid"]);
                    }

                    break;

                case "email":

                    $update['MAIL_HOST'] = $all['MAIL_HOST'];

                    $update['MAIL_PORT'] = $all['MAIL_PORT'];

                    $update['MAIL_USERNAME'] = $update['MAIL_FROM_ADDRESS'] = $all['MAIL_FROM_ADDRESS'];

                    $update['MAIL_FROM_NAME'] = $all['MAIL_FROM_NAME'];

                    $update['MAIL_PASSWORD'] = $all['MAIL_PASSWORD'];

                    $update['MAIL_ENCRYPTION'] = $all['MAIL_ENCRYPTION'];

                    modifyEnv($update);

                    //更改模板内容
                    $settings=[];
                    $in_database = [
                        'mail_register_template',
                        'mail_forgot_template',
                        'mail_bind_template',
                        'mail_untying_template',
                    ];
                    foreach ($all as $key => $value){
                        if(in_array($key, $in_database)){
                            array_push($settings,[ 'key' => $key, 'value' => $value]);
                        }
                    }
                    $setting = new Setting;
                    $setting->updateBatch($settings);
                    //更新缓存
                    Cache::forget('settings');
                    break;
                case "test_email" :

                    sendEmail($all['email_adress']);

                    break;

                case "third_party":

                    $settings=[];
                    $in_database = [
                        'head_codes','foot_codes'
                    ];
                    foreach ($all as $key => $value){
                        if(in_array($key,$in_database)){
                            array_push($settings,[ 'key' => $key, 'value' => $value]);
                        }
                    }

                    $setting = new Setting;
                    $setting->updateBatch($settings);
                    //更新缓存
                    Cache::forget('settings');

                    break;
                case "sms":
                    $settings=[];
                    $in_database = [
                        'sms_driver'
                    ];
                    foreach ($all as $key => $value){
                        if(in_array($key, $in_database)){
                            array_push($settings,[ 'key' => $key, 'value' => $value]);
                        }
                    }
                    $setting = new Setting;
                    $setting->updateBatch($settings);
                    //更新缓存
                    Cache::forget('settings');

                    event(new \App\Events\SetPluginSmsConfig($this->request, $all['sms_driver'], $all));
                    break;
                case 'template_message' :
                    $update_data = $settings = [];
                    $in_database = [
                        'sms_register_template',
                        'sms_forgot_template',
                        'sms_bind_template',
                        'sms_untying_template',
                        'sms_login_template',
                        'sms_auth_template',

                        'mail_register_template',
                        'mail_forgot_template',
                        'mail_bind_template',
                        'mail_untying_template',
                        'mail_login_template',
                        'mail_auth_template',
                    ];
                    foreach ($all as $key => $value){
                        if(in_array($key, $in_database)){
                            $update_data['template_value'] = $value;
                            $update_data['template_id'] = $all[$key . "_id"];
                            $update_data['is_start'] = (isset($all['is_start'][$key])) ? $all['is_start'][$key] : 0;
                            TemplateMessage::where('template_key', $key)->update($update_data);
                        }
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

    //风格
    function themes(){
        $themes_arrs = [];
        $uninstallthemes = [];
        //获取已安装的主题列表
        $themes = Themes::orderBy("status","asc")
            ->orderBy("create_at","asc")
            ->get();
        if($themes){
            $themes = $themes->toArray();
            foreach ($themes as &$v){
                $path = config('view.paths')[0].'/home/'.$v['identification'].'/config.json';
                if (file_exists($path)){
                    $v['info']=json_decode(file_get_contents($path),true);
                }else{
                    $v['info']["preview"]="";
                    $v['info']["name"]="目录不存在";
                    $v['info']["version"]=null;
                    $v['info']["author"]=null;
                    $v['info']["description"]="请重新卸载安装！";
                }
                $themes_arrs[]=$v['identification'];
            }
        }

        //获取未安装的主题
        $unthemes = getDirContent(config('view.paths')[0].'/home',$themes_arrs);

        if($unthemes){
            foreach ($unthemes as $val){
                $path = config('view.paths')[0].'/home/'.$val.'/config.json';
                if (file_exists($path)){
                    $uninstallthemes[]=json_decode(file_get_contents($path),true);
                }
            }
        }

        return view("admin/".ADMIN_SKIN."/settings/themes",['themes'=>$themes,'uninstallthemes'=>$uninstallthemes]);
    }

    //风格安装
    function themes_install($identification){

        return license::locatThemeTemplateInstall($identification);

    }

    //卸载主题风格
    function themes_uninstall(){

        return license::themeTemplateUninstall($this->request);

    }

    //使用风格主题
    function theme_use($identification){
        if(!$identification){
            return back()->with("errormsg","参数有误！");
        }

        //获取风格是否已经安装
        $themes = new Themes();
        $is_exist = $themes->where("identification","=",$identification)->first();
        if(!$is_exist){
            return back()->with("errormsg","主题风格未安装！");
        }

        if($is_exist["status"]==1){
            return back()->with("errormsg","主题风格正在使用！");
        }
        DB::beginTransaction(); //开启事务

        //更新数据库
        $update["status"] = 2;
        $update["updated_at"] = date("Y-m-d H:i:s");
        $res = $themes->query("")->update($update);
        $update["status"] = 1;
        $res1 = $themes->where("identification","=",$identification)->update($update);
        if(!$res || !$res1){
            DB::rollback();  //回滚
            return back()->with("errormsg","主题风格切换失败，请重新再试！");
        };

        DB::commit();  //提交
        //更新env配置
        modifyEnv(["THEME"=>$identification]);
        return back()->with("successmsg","主题风格切换成功！");
    }

    //在线编辑主题模板
    function theme_edit($identification,Filesystem $filesystem){

        if(!$identification){
            return back()->with("errormsg","参数有误！");
        }

        //获取风格配置文件是否存在
        $themes_info = config('view.paths')[0].'/home/'.$identification.'/config.json';
        if (!file_exists($themes_info)){
            return back()->with("errormsg","主题不完整！");
        }

        //获取主题文件
        $path = config('view.paths')[0].'/home/'.$identification;
        $files = getDirContent($path,[],false);

        foreach ($files as $key => $file){
            $path_detail = $path."/".$file;
            if(is_dir($path_detail)){
                $all_files[$key]["size"] = "";//文件大小
            }else{
                if(file_exists($path_detail)){
                    $all_files[$key]["size"] = filesize($path_detail);//文件大小
                }
            }
            $all_files[$key]["name"]=$file;
            $all_files[$key]["lastmodified"] = date ("Y-m-d H:i:s ", filemtime($path_detail));//文件最后修改时间
            $all_files[$key]["extension"] = $filesystem->extension($path_detail);//文件扩展名
            $all_files[$key]["type"] = $filesystem->type($path_detail);//文件类型

        }


        return view("admin/".ADMIN_SKIN."/theme/edit",['files'=>$all_files]);
    }


    //删除主题
    function theme_delete($identification){
        // 删除主题模板文件夹
        del_dir_files(THEME_TEMPLATE_SKIN_PATH . $identification);
        return back()->with('successmsg', '删除成功!');
    }

}
