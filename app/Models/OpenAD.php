<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenAD extends Model {
    //设置表名
    const TABLE_NAME = "open_ad";
    const PK = "id";
    public $table = self::TABLE_NAME;
    public $primaryKey = self::PK;
    public $timestamps = false;

    //添加
    public static function add($all) {
        return self::insertGetId([
            //'req_type' => $all['req_type'],
            'app_type' => $all['app_type'] == 2 ? 2 : 1,
            'images' => $all['images'],
            'url' => $all['url'],
            'type' => $all['type'],
            'is_self_support' => intval($all['is_self_support']),
            'need_login' => intval($all['need_login']),
            'is_company' => intval($all['is_company']),
            'status' => 1,
            'create_at' => time(),
            'update_at' => time(),
        ]);
    }

    //编辑
    public static function edit($all) {
        if ($all['id'] <= 0) return false;
        $up = [
            //'req_type' => $all['req_type'],
            'app_type' => $all['app_type'] == 2 ? 2 : 1,
            'url' => $all['url'],
            'type' => $all['type'],
            'is_self_support' => intval($all['is_self_support']),
            'need_login' => intval($all['need_login']),
            'is_company' => intval($all['is_company']),
            'status' => intval($all['status']) == 1 ? 1 : 2,
            'update_at' => time(),
        ];
        if ($all['images']) $up['images'] = $all['images'];
        return self::where('id', $all['id'])->update($up);
    }
}
