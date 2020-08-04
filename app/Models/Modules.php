<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    //设置表名
    const TABLE_NAME="modules",
        CLOUD_TYPE = [
        0 => [
            'key' => 'modules',
            'value' => '功能模块',
        ],
        1 => [
            'key' => 'plugins',
            'value' => '插件',
        ],
    ];
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;


}
