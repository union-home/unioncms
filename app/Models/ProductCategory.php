<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    //设置表名
    const TABLE_NAME="product_category";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr){

        if (!is_array($arr)){
            return ;
        }


        $this->name = $arr["name"];

        $this->describe = $arr["describe"];

        $this->icon_type = $arr["icon_type"];

        $this->icon = $arr["icon"];

        $this->create_at = date("Y-m-d H:i:s");

        //by andy update start
        if (trim($arr['id']) != '') {

            $classify_info = self::where('id', $arr['id'])->first();
            $this->pid = $classify_info['id'];
            $this->pid_path = $classify_info['pid_path'] . ',' . $classify_info['id'];
            $this->classify_grade = $classify_info['classify_grade'] + 1;
        } else {
            $this->pid_path = 1;
            $this->classify_grade = 1;
            $this->pid = 1;
        }

        //andy end


        return self::save();

    }

    //更新数据
    function UpdateArr($arr){

        if (!is_array($arr)){
            return ;
        }

        $obj = $this->find($arr["id"]);

        if ($arr['pid'] != $obj->pid) {
            $data = $this->find($arr["pid"]);
            $obj->pid = $arr['pid'];
            $obj->pid_path = $data['pid_path'];
            $obj->classify_grade = $data['classify_grade'] + 1;
        }

        $obj->name = $arr["name"];

        $obj->describe = $arr["describe"];

        $obj->icon_type = $arr["icon_type"];

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


}
