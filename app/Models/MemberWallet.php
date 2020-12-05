<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberWallet extends Model {
    //设置表名
    const TABLE_NAME = 'members_wallet';
    const PK = 'id';
    public $table = self::TABLE_NAME;
    public $primaryKey = self::PK;
    public $timestamps = false;

    //检查钱包
    public static function checkWallet($uid) {
        if (self::query()->where('uid', $uid)->first()) {
            return true;
        } else {
            return self::add($uid);
        }
    }


    //编辑钱包
    public static function edit($w, $up) {
        $up['update_at'] = time();
        return self::query()->where($w)->update($up);
    }

    //添加钱包
    public static function add($uid) {
        $up['uid'] = $uid;
        $up['create_at'] = bbsGetDay();
        $up['update_at'] = time();
        return self::query()->insertGetId($up);
    }

    //获取钱包信息
    public static function getWallet($uid) {
        return self::query()->where('uid', $uid)->first();
    }
}
