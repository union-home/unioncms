<?php

namespace App\Http\Controllers\Plugin\unionPay\Listeners;


use App\Http\Controllers\Plugin\unionPay\Controllers\InitController;
use App\Interfaces\ListenterPlugins;

class UnionPay implements ListenterPlugins {
    /**
     * 事件.
     */
    public function callBack($event) {
        //支付
        if ($event->req_type == "pay") {
            if ($event->pay_method == "WeChat") {
                //微信支付
                return InitController::weChatPay($event);
            } elseif ($event->pay_method == "Alipay") {
                //支付宝支付
                return InitController::aliPayPay($event);
            }
        } elseif ($event->req_type == "callback") {

            return InitController::callback($event);
        } elseif ($event->req_type == "getCode"){
            if ($event->pay_method == "WeChat") {
                //微信code
                return InitController::weChatCode($event);
            } elseif ($event->pay_method == "Alipay") {
                //支付宝code
//                return InitController::aliPayCode($event);
            }
        } elseif ($event->req_type == "codeGetInfo"){
            if ($event->pay_method == "WeChat") {
                //微信code
                InitController::codeGetWeChatInfo($event);
            } elseif ($event->pay_method == "Alipay") {
                //支付宝code
//                return InitController::aliPayCode($event);
            }
        } elseif ($event->req_type == "refund") {
            return InitController::refund($event);
        } elseif ($event->req_type == "checkRefund") {
            return InitController::checkRefund($event);
        } else {
            //throw new \Exception("drive有误！",40000);
            // 事件会所有执行，所以不能打回错误
        }
    }
}