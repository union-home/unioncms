<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    //设置表名
    const TABLE_NAME="members_login_logs";
    protected $table = self::TABLE_NAME;
    //protected $primaryKey="uid";
    public $timestamps = false;

}
