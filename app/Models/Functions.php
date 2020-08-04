<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    //设置表名
    const TABLE_NAME="functions";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr){

        if (!is_array($arr)){
            return ;
        }

        //判断语言是否重复
        $res = self::where("name","=",$arr["name"])
                        ->orWhere(function($query)use($arr){

                            if($arr["path"]!="#" && $arr["path"]!="javascript:;"){
                                $query->where("path","=",$arr["path"]);
                            }

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


        $this->name = $arr["name"];
        $this->path = $arr["path"];
        $this->pid = $arr["pid"];
        $this->permissions = $arr["permissions"];

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

        $obj->name = $arr["name"];
        $obj->path = $arr["path"];
        $obj->pid = $arr["pid"];
        $obj->permissions = $arr["permissions"];

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

    //获取所有,$level限制等级
    static function getAll($not_id="",$level=null){

        if(!$not_id && !$level){
            $data = self::get();
        }else{
            if($not_id && !$level){
                $data = self::where("id","!=",$not_id)->get();
            }else if(!$not_id && $level){
                $data = self::where("level","<=",$level)->get();
            }else if($not_id && $level){
                $data = self::where("id","!=",$not_id)->where("level","<=",$level)->get();
            }

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
