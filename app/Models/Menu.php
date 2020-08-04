<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //设置表名
    const TABLE_NAME="menus";
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

                            if($arr["path"]!="#" && $arr["path"]!="javascript:;"){
                                $query->where("path","=",$arr["path"]);
                            }

                        });
                })->count();

        if($res){
            throw  new  \Exception("Data is exist.",40000);
        }

        //获取级别
        if($arr["pid"]==0){
            $this->level = 1;
        }else{
            //获取pid的level
            $pid = self::select("level")->find($arr["pid"]);
            if($pid){
                $pid = $pid->toArray();
                $this->level = $pid["level"]+1;
            }else{
                throw  new  \Exception("Father ID can't find it.",40000);
            }

        }

        $this->type = $arr["type"];
        $this->name = $arr["name"];
        $this->path = $arr["path"];
        $this->pid = $arr["pid"];
        $this->pre_icon = $arr["pre_icon"];
        $this->suf_icon = $arr["suf_icon"];
        if(isset($arr["selected"])){
            $this->selected = $arr["selected"];
        }else{
            $this->selected = "";
        }

        if(isset($arr["order"])){
            $this->order = $arr["order"];
        }else{
            $this->order = 0;
        }

        $this->stauts = $arr["stauts"];
        $this->pre_icon_type = $arr["pre_icon_type"];
        $this->suf_icon_type = $arr["suf_icon_type"];

        $this->create_at = date("Y-m-d H:i:s");

        return self::save();

    }

    //更新数据
    function UpdateArr($arr){

        if (!is_array($arr)){
            return ;
        }

        $obj = $this->find($arr["id"]);

        //获取级别
        if($arr["pid"]==0){
            $obj->level = 1;
        }else{
            //获取pid的level
            $pid = self::select("level")->find($arr["pid"]);
            if($pid){
                $pid = $pid->toArray();
                $obj->level = $pid["level"]+1;
            }else{
                throw  new  \Exception("Father ID can't find it.",40000);
            }

        }

        $obj->type = $arr["type"];
        $obj->name = $arr["name"];
        $obj->path = $arr["path"];
        $obj->pid = $arr["pid"];
        $obj->pre_icon = $arr["pre_icon"];
        $obj->suf_icon = $arr["suf_icon"];
        if(isset($arr["selected"])){
            $obj->selected = $arr["selected"];
        }

        if(isset($arr["order"])){
            $obj->order = $arr["order"];
        }else{
            $obj->order = 0;
        }


        $obj->stauts = $arr["stauts"];
        $obj->pre_icon_type = $arr["pre_icon_type"];
        $obj->suf_icon_type = $arr["suf_icon_type"];

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

    //获取所有
    static function getAll($type="home",$not_id=""){

        if(!$not_id){
            $data = self::where("type","=",$type)->orderBy("order","desc")->get();
        }else{
            $data = self::where("type","=",$type)->where("id","!=",$not_id)->orderBy("order","desc")->get();
        }

        if(!$data){
            $data = array();
        }else{
            $data = $data->toArray();
        }



        return $data;
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
