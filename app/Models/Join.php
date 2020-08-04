<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Join extends Model
{
    //设置表名
    const TABLE_NAME="join";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr){

        if (!is_array($arr)){
            return ;
        }


        $this->position = $arr["position"];
        $this->description = $arr["description"];
        $this->requirements = $arr["requirements"];
        $this->created_at = date("Y-m-d H:i:s");
        $this->seo_keywords = !isset($arr["seo_keywords"]) ? '' : $arr["seo_keywords"];
        $this->seo_description = !isset($arr["seo_description"]) ? '' : $arr["seo_description"];

        return self::save();

    }

    //更新数据
    function UpdateArr($arr){

        if (!is_array($arr)){
            return ;
        }

        $obj = $this->find($arr["id"]);

        $obj->position = $arr["position"];
        $obj->description = $arr["description"];
        $obj->requirements = $arr["requirements"];
        $obj->status = $arr["status"];
        $obj->updated_at = date("Y-m-d H:i:s");
        $obj->seo_keywords = !isset($arr["seo_keywords"]) ? '' : $arr["seo_keywords"];
        $obj->seo_description = !isset($arr["seo_description"]) ? '' : $arr["seo_description"];

        $obj->save();

    }

    //删除
    static function deleteById($id){

        return self::destroy($id);

    }

}
