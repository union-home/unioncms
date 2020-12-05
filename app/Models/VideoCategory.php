<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model {
    //设置表名
    const TABLE_NAME = "video_category";
    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr) {

        if (!is_array($arr)) {
            return;
        }


        $this->name = $arr["name"];

        $this->describe = $arr["describe"];
        $this->content = $arr["content"];

        $this->icon_type = $arr["icon_type"];

        $this->icon = $arr["icon"];

        $this->create_at = date("Y-m-d H:i:s");

        return self::save();

    }

    //更新数据
    function UpdateArr($arr) {

        if (!is_array($arr)) {
            return;
        }

        $obj = $this->find($arr["id"]);


        $obj->name = $arr["name"];

        $obj->describe = $arr["describe"];
        $obj->content = $arr["content"];

        $obj->icon_type = $arr["icon_type"];

        $obj->icon = $arr["icon"];

        return $obj->save();

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


}
