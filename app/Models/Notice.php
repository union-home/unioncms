<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model {
    //设置表名
    const TABLE_NAME = "notice";
    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr) {

        if (!is_array($arr)) {
            return;
        }


        $this->add_uid = $arr["add_uid"];
        $this->title = $arr["title"];
        $this->content = $arr["content"];
        $this->qcid = $arr["qcid"];
        $this->create_at = date("Y-m-d H:i:s");
        $this->update_at = date("Y-m-d H:i:s");
        $this->seo_keywords = !isset($arr["seo_keywords"]) ? '' : $arr["seo_keywords"];
        $this->seo_description = !isset($arr["seo_description"]) ? '' : $arr["seo_description"];

        return self::save();

    }

    //更新数据
    function UpdateArr($arr) {

        if (!is_array($arr)) {
            return;
        }

        $obj = $this->find($arr["id"]);

        $obj->title = $arr["title"];
        $obj->content = $arr["content"];
        $obj->qcid = $arr["qcid"];
        $obj->update_at = date("Y-m-d H:i:s");
        $obj->seo_keywords = !isset($arr["seo_keywords"]) ? '' : $arr["seo_keywords"];
        $obj->seo_description = !isset($arr["seo_description"]) ? '' : $arr["seo_description"];

        $obj->save();

    }

    //通过filed查找数据
    function GetdataByFiled($filed, $value, $type = null) {

        if ($type) {
            $data = self::where($filed, "=", $value)->where("type", "=", $type)->orderBy("create_at", "asc")->first();
        } else {
            $data = self::where($filed, "=", $value)->orderBy("create_at", "asc")->first();
        }

        if ($data) {
            return $data->toArray();
        } else {
            return array();
        }

    }

    //获取所有
    static function getAll($type = "home", $not_id = "") {

        if (!$not_id) {
            $data = self::where("type", "=", $type)->get();
        } else {
            $data = self::where("type", "=", $type)->where("id", "!=", $not_id)->get();
        }

        if (!$data) {
            $data = array();
        } else {
            $data = $data->toArray();
        }


        return $data;
    }

    //删除
    static function deleteById($id) {

        //查询是否有下级
        $data = self::where("pid", "=", $id)->count();

        if ($data >= 1) {

            return false;

        }

        return self::destroy($id);

    }

}
