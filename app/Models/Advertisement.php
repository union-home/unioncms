<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model {
    //设置表名
    const TABLE_NAME = "advertisement";
    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    public $timestamps = false;

    //添加
    public static function add($all) {
        return self::insertGetId([
            'req_type' => $all['req_type'],
            'images' => $all['images'],
            'url' => $all['url'],
            'type' => $all['type'],
            'is_self_support' => intval($all['is_self_support']),
            'need_login' => intval($all['need_login']),
            'is_company' => intval($all['is_company']),
            'status' => 1,
            'create_at' => time(),
            'update_at' => time(),
            'display_page' => $all['display_page'] ?: '',
            'display_position' => $all['display_position'] ?: '',
            'display_module' => $all['display_module'] ?: '',
        ]);
    }

    //编辑
    public static function edit($all) {
        if ($all['id'] <= 0) return false;
        $up = [
            'req_type' => $all['req_type'],
            'url' => $all['url'],
            'type' => $all['type'],
            'is_self_support' => intval($all['is_self_support']),
            'need_login' => intval($all['need_login']),
            'is_company' => intval($all['is_company']),
            'status' => intval($all['status']) == 1 ? 1 : 2,
            'update_at' => time(),
            'display_page' => $all['display_page'] ?: '',
            'display_position' => $all['display_position'] ?: '',
            'display_module' => $all['display_module'] ?: '',
        ];
        if ($all['images']) $up['images'] = $all['images'];
        return self::where('id', $all['id'])->update($up);
    }

    //获取广告
    public static function apiGetAdvertisementList($arr) {
        $len = $arr['pagesize'] ?: 10;
        $res = self::where('status', 1)
            ->where(function ($q) use ($arr) {
                if ($arr['req_type']) $q->where('req_type', $arr['req_type']);
                if ($arr['display_position']) $q->where('display_position', $arr['display_position']);
                if ($arr['display_page']) $q->where('display_page', $arr['display_page']);
                if ($arr['display_module']) $q->where('display_module', $arr['display_module']);
            })
            ->limit($len)
            ->get(['id', 'images', 'url'])
            ->toArray();
        foreach ($res as &$val) {
            $val['images'] = GetUrlByPath($val['images']);
        }
        return $res;
    }
}
