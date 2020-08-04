<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    //设置表名
    const TABLE_NAME="pages";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    private $field;

    function InsertArr($arr){

        if (!is_array($arr)){
            return ;
        }
        $this->name = $arr["name"];
        $this->url = $arr["url"];
        $this->content = base64_encode($arr["content"]);
        $this->create_at = date("Y-m-d H:i:s");
        $this->update_at = date("Y-m-d H:i:s");
        $this->seo_keywords = !isset($arr["seo_keywords"]) ? '' : $arr["seo_keywords"];
        $this->seo_description = !isset($arr["seo_description"]) ? '' : $arr["seo_description"];

        return self::save();

    }

    function UpdateArr($arr){
        if (!is_array($arr)){
            return ;
        }

        $obj = self::find($arr["id"]);

        $obj->name = $arr["name"];
        $obj->url = $arr["url"];
        $obj->content = base64_encode($arr["content"]);
        $obj->update_at = date("Y-m-d H:i:s");
        $obj->seo_keywords = !isset($arr["seo_keywords"]) ? '' : $arr["seo_keywords"];
        $obj->seo_description = !isset($arr["seo_description"]) ? '' : $arr["seo_description"];

        $obj->save();
    }

    static function getAll(){

        $data = self::all();

        return  $data?$data->toArray():[];
    }










}
