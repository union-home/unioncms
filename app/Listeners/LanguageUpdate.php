<?php

namespace App\Listeners;

use App\Models\Language;

class LanguageUpdate
{

    /**
     * 为订阅者注册监听器.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        //监听检查更新事件
        $events->listen(
            'App\Events\UpdateLanguage',
            'App\Listeners\LanguageUpdate@updateData'
        );


    }

    /**
     * 更新事件.
     */
    public function updateData($event) {

        //更新数据
        //获取所有type的语言包
        $language = new Language();

        $data = $language->where("type","=",$event->language_detail["type"])
                         ->where("id","!=",$event->language_detail["id"])
                         ->get();

        if(!$data){
            return ;
        }

        foreach ($data->toArray() as $value){

            if(file_exists(base_path()."/resources/lang/".$event->language_detail["type"]."/".$value["shortcode"].".php")){
                $key_data = include (base_path()."/resources/lang/".$event->language_detail["type"]."/".$value["shortcode"].".php");
                $temp = [];
                foreach ($event->data as $key => $val){
                    if(isset($key_data[$key])){
                        $temp[$key]=$key_data[$key];
                    }else{
                        $temp[$key] = $val;
                    }
                }

                //创建语言文件
                file_put_contents(base_path()."/resources/lang/".$event->language_detail["type"]."/".$value["shortcode"].".php","<?php ".PHP_EOL.PHP_EOL."  return ".var_export($temp,true).";");

            }

        }


    }

}