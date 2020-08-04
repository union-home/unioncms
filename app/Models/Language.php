<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //设置表名
    const TABLE_NAME="languages";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr){

        if (!is_array($arr)){
            return ;
        }

        //判断语言是否重复
        $res = self::where("type","=",$arr["type"])
                ->where(function($query)use ($arr) {
                    $query->where("name","=",$arr["name"])
                        ->orWhere(function($query)use($arr){
                            $query->where("shortcode","=",$arr["shortcode"]);
                        });
                })->count();

        if($res){
            throw  new  \Exception("Data is exist.",40000);
        }

        $this->type = $arr["type"];
        $this->name = $arr["name"];
        $this->shortcode = $arr["shortcode"];
        $this->remarks = $arr["remarks"];
        $this->status = $arr["status"];
        $this->icon = $arr["icon"];
        $this->create_at = date("Y-m-d H:i:s");

        //清空缓存
        Cache::forget('languages');
        return self::save();

    }

    //更新数据
    function UpdateArr($arr){

        if (!is_array($arr)){
            return ;
        }

        $obj = $this->find($arr["id"]);


        $obj->remarks = $arr["remarks"];
        $obj->status = $arr["status"];
        $obj->icon = $arr["icon"];

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

    //获取所有语言
    static function getAll(){

        if (!Cache::has('languages')) {
            $language = self::all();
            $data = array();
            if($language){
                foreach ($language->toArray() as $key=>$value){
                    $temp[$value["type"]][]=$value;
                }
                $data = $temp;
            }

            Cache::put('languages', $data, 5);

        }else{

            return Cache::get('languages');

        }


        return $data;
    }

}
