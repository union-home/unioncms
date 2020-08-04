<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AgreementCategory extends Model
{
    //设置表名
    const TABLE_NAME = "agreement_category";
    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    public $timestamps = false;

    //添加数据
    function InsertArr($params){
        if (!is_array($params)) return ;

        $validator = Validator::make($params, [
            'name' => 'required',
        ], [
            'name.required' => '协议分类为必填项！',
        ]);
        if ($validator->fails()) return ["stauts"=> 40000, "msg"=> $validator->errors()->first()];

        $this->name = !isset($params['name']) ? '' : $params['name'];
        $this->describe = !isset($params['describe']) ? '' : $params['describe'];
        $this->create_at = date("Y-m-d H:i:s");
        $this->update_at = $this->create_at;
        if(!self::save()) return ["stauts"=>40000, "msg"=>"协议分类新增失败！"];
        return ["stauts"=>200, "msg"=>"success"];
    }

    //更新数据
    function UpdateArr($params){
        if (!is_array($params)) return ;
        $obj = $this->lockForUpdate()->find($params["id"]);

        $validator = Validator::make($params, [
            'name' => 'required',
        ], [
            'name.required' => '协议分类为必填项！',
        ]);
        if ($validator->fails()) return ["stauts"=> 40000, "msg"=> $validator->errors()->first()];

        $obj->name = !isset($params['name']) ? '' : $params['name'];
        $obj->describe = !isset($params['describe']) ? '' : $params['describe'];
        $obj->update_at = date("Y-m-d H:i:s");
        if(!$obj->save()) return ["stauts"=>40000, "msg"=>"协议分类更新失败！"];
        return ["stauts"=>200, "msg"=>"success"];
    }
}
