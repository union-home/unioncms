<?php

namespace App\Http\Controllers\Plugin\chuanglan\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Plugin\chuanglan\Lib\ChuanglanSmsApi;
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
        $clapi  = new ChuanglanSmsApi();
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);

        $clapi->setConfig('api_account', $config['API_ACCOUNT']);
        $clapi->setConfig('api_password', $config['API_PASSWORD']);

        $result = $clapi->sendSMS($event->tophone,$event->content );
        if(!is_null(json_decode($result))){
            $output=json_decode($result,true);
            if(isset($output['code'])  && $output['code']=='0'){
                return ["msg"=>'发送成功',"status"=>200];
            }else{
                return ["msg"=>$output['errorMsg'],"status"=> 40000];
            }
        }else{
            return ["msg"=>$result,"status"=>40000];
        }
    }
}


