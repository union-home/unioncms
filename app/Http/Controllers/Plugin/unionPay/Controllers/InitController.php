<?php

namespace App\Http\Controllers\Plugin\unionPay\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Plugin\unionPay\Lib\AlipayApi;
use App\Http\Controllers\Plugin\unionPay\Lib\Log;
use App\Http\Controllers\Plugin\unionPay\Lib\WeChatApi;
use App\Models\TransferOrder;
use Illuminate\Http\Request;

class InitController extends Controller {
    //构造函数
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    //处理函数
    public static function weChatPay($event) {
        if (!$event->outTradeNo || !$event->pay_type || $event->totalFee <= 0 || !$event->module || !$event->action) {
            return ["msg" => '参数错误', "status" => 0];
        }
        $clapi = new WeChatApi();
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
        $clapi->setConfig('MCHID', $config['wx_MCH']);
        $clapi->setConfig('KEY', $config['wx_KEY']);
        $clapi->setConfig('openid', $event->openid);
        $clapi->setConfig('totalFee', $event->totalFee * 100);
        $clapi->setConfig('outTradeNo', $event->outTradeNo);
        $clapi->setConfig('module', $event->module);
        $clapi->setConfig('action', $event->action);
        if ($event->pay_type == 'app') {//APP支付
            $clapi->setConfig('APPID', $config['wx_APP_ID']);
            $clapi->setConfig('APPSECRET', $config['wx_APP_SECRET']);
            $clapi->setConfig('TRADETYPE', $config['wx_APP_TRADETYPE']);
        } elseif ($event->pay_type == 'public') {//公众号
            $clapi->setConfig('APPID', $config['wx_PUBLIC_APPID']);
            $clapi->setConfig('APPSECRET', $config['wx_PUBLIC_APPSECRET']);
            $clapi->setConfig('TRADETYPE', $config['wx_PUBLIC_TRADETYPE']);
        } elseif ($event->pay_type == 'small') {//小程序
            $clapi->setConfig('APPID', $config['wx_SMALL_APPID']);
            $clapi->setConfig('APPSECRET', $config['wx_SMALL_APPSECRET']);
            $clapi->setConfig('TRADETYPE', $config['wx_SMALL_TRADETYPE']);
        } else {
            return ["msg" => '请求类型错误', "status" => 0];
        }
        $result = $clapi->pay();
        if ($result['status'] == 200) {
            return $result;
        } else {
            return ["msg" => $result['msg'], "status" => 0];
        }
    }

    //处理函数
    public static function aliPayPay($event) {
        $clapi = new AlipayApi();
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
        $clapi->setConfig('appid', $config['ali_appid']);
        $clapi->setConfig('gateway', $config['ali_gateway']);
        $clapi->setConfig('rsaPrivateKey', $config['ali_rsaPrivateKey']);
        $clapi->setConfig('alipayrsaPublicKey', $config['ali_alipayrsaPublicKey']);
        $clapi->setConfig('outTradeNo', $event->outTradeNo);
        $clapi->setConfig('totalFee', $event->totalFee);
        $clapi->setConfig('module', $event->module);
        $clapi->setConfig('action', $event->action);

        if ($event->pay_type == 'app') {
            $result = $clapi->pay();
            $result = json_decode($result, true);
        } elseif ($event->pay_type == 'public') {
            $result = $clapi->pay();
            $result = json_decode($result, true);
        } else {
            return ["msg" => '请求类型错误', "status" => 0];
        }
        if ($result['status'] == 200) {
            return $result;
        } else {
            return ["msg" => $result['msg'], "status" => 0];
        }
    }

    //回调
    public static function callback($event) {
        if ($event->pay_method == 'WeChat') {
            $clapi = new WeChatApi();
            $data = $clapi->callback($event->callback_data);
        } elseif ($event->pay_method == 'Alipay') {
            $clapi = new AlipayApi();
            $data = $clapi->callback($event->callback_data);
        }
        $find = TransferOrder::getOrder($data['out_trade_no']);
        $data['pay_method'] = $find['pay_method'];

        //自动获取模块回调路径，可能需要调整到cms外面
        $namespace = 'App\Http\Controllers\Module\\' . $find['module'] . '\Api\Order\PayController';
        if (!class_exists($namespace)) {
            //获取主题的回调
            $namespace = 'MyView\\'.env("THEME","default").'\Http\Home\PayController';
            if(!class_exists($namespace)){
                Log::write('类不存在：', $data['out_trade_no'] . PHP_EOL, 'order/' . date('Y-m') . '/' . date('Y-m-d') . '/' . $data['out_trade_no'] . '.log');
                return false;
            }
            $action = $find['action'];
            $module = new $namespace($event->request);
            $module->$action($data);

        }
        //调用模块回调
        $action = $find['action'];
        $module = new $namespace($event->request);
        $module->$action($data);
    }

    //微信code
    public static function weChatCode($event) {
        $clapi = new WeChatApi();
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
        if ($event->pay_type == 'public') {//公众号
            $clapi->setConfig('APPID', $config['wx_PUBLIC_APPID']);
            $clapi->setConfig('APPSECRET', $config['wx_PUBLIC_APPSECRET']);
        } elseif ($event->pay_type == 'small') {//小程序
            $clapi->setConfig('APPID', $config['wx_SMALL_APPID']);
            $clapi->setConfig('APPSECRET', $config['wx_SMALL_APPSECRET']);
        } else {
            return ["msg" => '请求类型错误', "status" => 0];
        }
        $clapi->getCode($event->callback_data);
    }

    public static function codeGetWeChatInfo($event) {
        $clapi = new WeChatApi();
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
        if ($event->pay_type == 'public') {//公众号
            $clapi->setConfig('APPID', $config['wx_PUBLIC_APPID']);
            $clapi->setConfig('APPSECRET', $config['wx_PUBLIC_APPSECRET']);
        } elseif ($event->pay_type == 'small') {//小程序
            $clapi->setConfig('APPID', $config['wx_SMALL_APPID']);
            $clapi->setConfig('APPSECRET', $config['wx_SMALL_APPSECRET']);
        } else {
            return ["msg" => '请求类型错误', "status" => 0];
        }
        $clapi->codeGetWeChatInfo($event->callback_data);
    }
}


