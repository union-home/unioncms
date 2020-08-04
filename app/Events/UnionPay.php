<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class UnionPay {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     * request          自带请求类
     * drive            支付通道
     * req_type         pay=支付  callback=回调 getCode=获取code，
     * callback_data    回调数据，req_type=callback时，
     *                  req_type=getCode , codeReturnUrl=获取code返回地址
     *
     * pay_method       支付方式，微信，支付宝等
     * outTradeNo       订单号
     * totalFee         金额，单位元
     * openid           用户openid
     * pay_type         app=APP=APP支付   public=JSAPI=公众号支付 small=JSAPI=小程序支付
     * module           模块 为回调时，查找模块回调路径
     * action           回调方法  【上面的module/Api/Order/PayController::方法】
     */
    public function __construct($request, $drive, $req_type, $callback_data, $pay_method, $outTradeNo = '', $totalFee = '', $openid = '', $pay_type = '', $module = '', $action = '') {
        $this->req_type = $req_type;
        $this->callback_data = $callback_data;
        $this->request = $request;
        $this->drive = $drive;
        $this->pay_method = $pay_method;
        $this->outTradeNo = $outTradeNo;
        $this->totalFee = $totalFee;
        $this->openid = $openid;
        $this->pay_type = $pay_type;
        $this->module = $module;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
