<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AgreementModel extends Model
{
    //设置表名
    const TABLE_NAME = "agreement";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    //添加数据
    function InsertArr($params){
        if (!is_array($params)) return ;

        $validator = Validator::make($params, [
            'title' => 'required',
            'cid' => 'required',
        ], [
            'title.required' => '协议名称为必填项！',
            'cid.required' => '协议分类为必选项！',
        ]);
        if ($validator->fails()) return ["stauts"=> 40000, "msg"=> $validator->errors()->first()];

        $this->title = !isset($params['title']) ? '' : $params['title'];
        $this->content = !isset($params['content']) ? null : $params['content'];
        $this->cid = !isset($params['cid']) ? 0 : $params['cid'];
        $this->seo_keywords = !isset($params["seo_keywords"]) ? '' : $params["seo_keywords"];
        $this->seo_description = !isset($params["seo_description"]) ? '' : $params["seo_description"];
        $this->create_at = date("Y-m-d H:i:s");
        $this->update_at = date("Y-m-d H:i:s");
        if(!self::save()) return ["stauts"=>40000, "msg"=>"协议新增失败！"];
        return ["stauts"=>200, "msg"=>"success"];
    }

    //更新数据
    function UpdateArr($params){
        if (!is_array($params)) return ;
        $obj = $this->lockForUpdate()->find($params["id"]);

        $validator = Validator::make($params, [
            'title' => 'required',
            'cid' => 'required',
        ], [
            'title.required' => '协议名称为必填项！',
            'cid.required' => '协议分类为必选项！',
        ]);
        if ($validator->fails()) return ["stauts"=> 40000, "msg"=> $validator->errors()->first()];

        $obj->title = $params["title"];
        $obj->content = !isset($params['content']) ? null : $params['content'];
        $obj->cid = !isset($params['cid']) ? 0 : $params['cid'];
        $obj->seo_keywords = !isset($params["seo_keywords"]) ? '' : $params["seo_keywords"];
        $obj->seo_description = !isset($params["seo_description"]) ? '' : $params["seo_description"];
        $obj->update_at = date("Y-m-d H:i:s");
        if(!$obj->save()) return ["stauts"=>40000, "msg"=>"协议更新失败！"];
        return ["stauts"=>200, "msg"=>"success"];
    }

    //删除
    static function deleteById($id){
        //查询是否有下级
        $data = self::where("id","=",$id)->count();
        if($data >= 1) return false;
        return self::destroy($id);
    }
}
