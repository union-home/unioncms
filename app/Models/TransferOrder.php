<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class TransferOrder extends Model {
    //设置表名
    const TABLE_NAME = "transfer_order";
    protected $table = self::TABLE_NAME;
    protected $primaryKey = "order_num";
    public $timestamps = false;

    //添加数据
    static function InsertArr($params) {
        if (!is_array($params)) return;

        $validator = Validator::make($params, [
            'order_num' => 'required|unique:transfer_order',
            'module' => 'required',
            'action' => 'required',
            'pay_method' => 'required',
        ], [
            'order_num.required' => '订单号不能为空',
            'order_num.unique' => '订单号已存在',
            'module.required' => '回调模块不能为空',
            'action.required' => '回调函数不能为空',
            'pay_method.required' => '支付方式不能为空',
        ]);
        if ($validator->fails()) return ["status" => 0, "msg" => $validator->errors()->first()];

        $add['order_num'] = $params['order_num'];
        $add['module'] = $params['module'];
        $add['child_module'] = $params['child_module'];
        $add['action'] = $params['action'];
        $add['pay_method'] = $params['pay_method'];
        $add['create_at'] = date("Y-m-d H:i:s");
        if (self::insert($add))
            return ["status" => 200, "msg" => "成功"];
        else
            return ["status" => 0, "msg" => "失败"];
    }

    //获取数据
    static function getOrder($order_num) {
        $res = self::where('order_num', $order_num)->orderByDesc('create_at')->first();
        return $res ? $res->toArray() : [];
    }
}
