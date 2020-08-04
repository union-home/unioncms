<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuGroup extends Model
{
    //设置表名
    const TABLE_NAME="member_groups";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    //添加数据
    function InsertArr($arr){

        if (!is_array($arr)){
            return ;
        }


        $this->name = $arr["name"];

        $this->create_at = date("Y-m-d H:i:s");

        return self::save();

    }

    //更新数据
    function UpdateArr($arr){

        if (!is_array($arr)){
            return ;
        }

        $obj = $this->find($arr["id"]);

        if(isset($arr["name"])){
            $obj->name = $arr["name"];
        }

        if(isset($arr["fid_lists"])){
            $obj->fid_lists = $arr["fid_lists"];
        }


        $obj->update_at = date("Y-m-d H:i:s");

        $obj->save();

    }

    //获取权限数据
    function AuthLists($gid){

        $fid_list = self::select("fid_lists")->whereIn("id",explode(",",$gid))->get();

        if($fid_list){
            $fid_list = $fid_list->toArray();
            $arr = [];
            foreach ($fid_list as $value){
                $arr = array_merge($arr,explode(",",$value["fid_lists"]));
            }

            if($arr){
                $functions = new Functions();
                $data = $functions->whereIn("id",$arr)->get();

                if($data){
                    $data = $data->toArray();

                    $all_permissions = [];

                    foreach ($data as $key => $value){
                        if($value["permissions"]){
                            $all_permissions[$value["permissions"]] = $value;
                        }else{
                            $all_permissions[] = $value;
                        }

                    }

                    return $all_permissions;
                }
            }
        }

        return null;


    }

    //通过ID删除
    static function deleteById($id){

        //查询是否有下级

        $data = Member::whereRaw("FIND_IN_SET($id,gid)")->count();

        if($data >= 1){

            return false;

        }

        return self::destroy($id);
    }

}
