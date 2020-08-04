<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Themes extends Model
{
    //设置表名
    const TABLE_NAME="themes";
    protected $table = self::TABLE_NAME;
    //protected $primaryKey="uid";
    public $timestamps = false;

}
