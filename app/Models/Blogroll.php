<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Blogroll extends Model {
    //设置表名
    const TABLE_NAME = "blogroll";
    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr) {

        if (!is_array($arr)) {
            return;
        }


        $this->title = $arr["title"];
        $this->url = $arr["url"];
        if (isset($arr["cover"])) {
            $this->cover = $arr["cover"];
            $this->type = 2;
        } else {
            $this->cover = "";
            $this->type = 1;
        }
        $this->create_at = date("Y-m-d H:i:s");
        $this->update_at = date("Y-m-d H:i:s");
        $this->is_rec = !isset($arr['is_rec']) ? 0 : $arr['is_rec'];
        return self::save();

    }

    //更新数据
    function UpdateArr($arr) {

        if (!is_array($arr)) {
            return;
        }

        $obj = $this->find($arr["id"]);

        $obj->title = $arr["title"];
        $obj->url = $arr["url"];
        if (isset($arr["cover"])) {
            $obj->cover = $arr["cover"];
            $obj->type = 2;
        }
        $obj->is_rec = !isset($arr['is_rec']) ? 0 : $arr['is_rec'];
        $obj->update_at = date("Y-m-d H:i:s");
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
    static function getData($type = 1, $len = 0) {
        $data = self::where("type", $type);
        if ($len > 0) {
            $data = $data->limit($len);
        }
        $data = $data->orderByDesc('is_rec')->orderByDesc('update_at')->get();
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
