<?php

namespace App\Http\Controllers\Plugin\smsplatform\Controllers;

use App\Http\Controllers\Controller;
use App\Utils\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InitController extends Controller
{
    //构造函数
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    //处理函数
    static function send($event){
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);

        if (empty($config['account'])) return ["msg"=> '请先进行后台配置账户', "status"=>0];
        if (empty($config['pswd'])) return ["msg"=> '请先进行后台配置密码', "status"=>0];

        $post_data = array();
        $post_data['account'] = $config['account'];
        $post_data['pswd'] = $config['pswd'];
        $post_data['mobile'] = $event->tophone;
        $post_data['msg']= '【unionCMS管理系统】' . $event->content;
        $post_data['needstatus'] ="true";
        $post_data['resptype'] = "json";

        $url = 'http://118.178.188.81/msg/HttpBatchSendSM';

        $o="";
        foreach ($post_data as $k=>$v) $o.= "$k=".urlencode($v)."&";
        $post_data=substr($o,0,-1);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置是否返回response header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上

        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $time_out = 60;
        curl_setopt($ch, CURLOPT_TIMEOUT, $time_out);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $time_out);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $result = curl_exec($ch);

        curl_close($ch);

        if(!is_null(json_decode($result))){
            $output=json_decode($result,true);
            if(isset($output['result'])  && $output['result']=='0'){
                return ["msg"=>'发送成功',"status"=>200];
            }else{
                return ["msg"=>$output['result'],"status"=>40000];
            }
        }else{
            return ["msg"=>$result,"status"=>40000];
        }
    }
}