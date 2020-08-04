<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersLoginLogs extends Model
{
    //设置表名
    const TABLE_NAME="members_login_logs";
    protected $table = self::TABLE_NAME;
    //protected $primaryKey="id";
    public $timestamps = false;

    function InsertArr($arr){

        if (!is_array($arr)){
            return ;
        }
        $this->uid = $arr["uid"];
        $this->ip = $arr["ip"];
        $this->login_at = $arr["login_at"];
        $this->device_type = $arr["device_type"];
        $this->device_name = $arr["device_name"];
        $this->device_token = $arr["device_token"];

        self::save();

    }
}
