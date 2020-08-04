<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    //设置表名
    const TABLE_NAME="attachments";
    protected $table = self::TABLE_NAME;
    //protected $primaryKey="id";
    public $timestamps = false;

    //添加数据   by andy update 之前用的是对象 save方法
    // 现在改成insert 写入和 update 方法
    function InsertArr($arr) {

        if (!is_array($arr)) {
            return;
        }

        //查找
        $obj = self::where("path_md5", "=", md5($arr["path"]))->first();

        if ($obj) {

            $data = [
                'path' => $arr["path"],
                'path_md5' => md5($arr["path"]),
                'drive' => $arr["drive"],
                'update_at' => date("Y-m-d H:i:s")
            ];

            return self::where('path_md5', md5($arr["path"]))->update($data);

        } else {
            //新增

            $data = [
                'path' => $arr["path"],
                'path_md5' => md5($arr["path"]),
                'drive' => $arr["drive"],
                'update_at' => date("Y-m-d H:i:s"),
                'create_at' => date("Y-m-d H:i:s")
            ];

            return self::insert($data);

        }


    }



    //获取所有
    static function getByPath($path){

        $data = self::where("path_md5","=",md5($path))->orwhere("path","=",$path)->first();
        if(!$data){
            return null;
        }

        return $data->toArray();
    }

    //删除
    function deleteByPathMD5($path){

        return self::where("path_md5","=",md5($path))->delete();

    }

}
