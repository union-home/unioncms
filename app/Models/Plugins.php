<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Plugins extends Model
{
    //设置表名
    const TABLE_NAME = "plugins";
    protected $table = self::TABLE_NAME;
    public $timestamps = true;
    protected $guarded = [];
}
