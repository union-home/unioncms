<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    //设置表名
    const TABLE_NAME="article";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr){
        if (!is_array($arr)) return ;

        $this->title = $arr["title"];
        $this->tags = $arr["tags"];
        if(isset($arr["cover"])){
            $this->cover = $arr["cover"];
        }else{
            $this->cover = "";
        }
        $this->introduct = $arr["introduct"];
        $this->content = $arr["content"];
        $this->cid = $arr["cid"];
        $this->is_hot = !isset($arr['is_hot']) ? 0 : $arr['is_hot'];
        $this->is_rec = !isset($arr['is_rec']) ? 0 : $arr['is_rec'];
        $this->seo_keywords = !isset($arr["seo_keywords"]) ? '' : $arr["seo_keywords"];
        $this->seo_description = !isset($arr["seo_description"]) ? '' : $arr["seo_description"];
        $this->create_at = date("Y-m-d H:i:s");
        return self::save();
    }

    //更新数据
    function UpdateArr($arr){

        if (!is_array($arr)){
            return ;
        }

        $obj = $this->find($arr["id"]);

        $obj->title = $arr["title"];
        $obj->tags = $arr["tags"];
        if(isset($arr["cover"])){
            $obj->cover = $arr["cover"];
        }
        $obj->introduct = $arr["introduct"];
        $obj->content = $arr["content"];
        $obj->cid = $arr["cid"];
        $obj->is_hot = !isset($arr['is_hot']) ? 0 : $arr['is_hot'];
        $obj->is_rec = !isset($arr['is_rec']) ? 0 : $arr['is_rec'];
        $obj->seo_keywords = !isset($arr["seo_keywords"]) ? '' : $arr["seo_keywords"];
        $obj->seo_description = !isset($arr["seo_description"]) ? '' : $arr["seo_description"];
        $obj->update_at = date("Y-m-d H:i:s");

        $obj->save();

    }

    //通过filed查找数据
    function GetdataByFiled($filed,$value,$type=null){

        if($type){
            $data = self::where($filed,"=",$value)->where("type","=",$type)->orderBy("create_at","asc")->first();
        }else{
            $data = self::where($filed,"=",$value)->orderBy("create_at","asc")->first();
        }

        if($data){
            return $data->toArray();
        }else{
            return array();
        }

    }

    //删除
    static function deleteById($id){

        //查询是否有下级
        $data = self::where("pid","=",$id)->count();

        if($data >= 1){

            return false;

        }

        return self::destroy($id);

    }

}
