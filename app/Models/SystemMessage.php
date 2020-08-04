<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemMessage extends Model
{
    //设置表名
    const TABLE_NAME="system_message";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr){

    }

    //更新数据
    function UpdateArr($arr){



    }

    //获取数据
    static function getData(){
        $data = self::orderBy("status","asc")
            ->orderBy("created_at","desc")
            ->get();
        if($data){
            return $data->toArray();
        }
        return [];

    }







}
