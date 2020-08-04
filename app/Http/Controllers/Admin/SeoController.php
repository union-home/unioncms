<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    function index(){


        return view('admin/'.ADMIN_SKIN.'/seo/index', [
            'seo_list' => Setting::where('type', 'seo')->pluck('value', 'key')
        ]);
    }

    function submit(){

        if($this->request->ismethod('post')){
            $type_name = 'seo';
            $params = $this->request->all();
            $settings = [];
            foreach ($params as $key => $value){
                if(strpos($key, $type_name . '_') !== false && !empty($key)){
                    Setting::updateOrInsert(['type' => $type_name, 'key' => $key], ['value' => empty($value) ? '' : $value]);
                }
            }
            //更新缓存
            Cache::forget('settings');

            return ['stauts'=>200, 'msg'=>'success'];
        }else{
            return ['stauts'=>40000,'msg'=>'method error,must post method'];
        }
    }
}
