<?php

namespace App\Models;

use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberWalletRecord extends Model {
    //设置表名
    const TABLE_NAME = 'members_wallet_record';
    const PK = 'id';
    public $table = self::TABLE_NAME;
    public $primaryKey = self::PK;
    public $timestamps = false;
    public static $operation_type = [
        'login' => [1],//类型
        'releasePosts' => [2],//类型
        'commentPosts' => [3],//类型
        'invitationRegister' => [4],//类型
    ];
    public static $type = [
        'addInt' => ['addInt'],//类型
        'reduceInt' => ['reduceInt'],//类型
        'addCoin' => ['addCoin'],//类型
        'reduceCoin' => ['reduceCoin'],//类型
    ];

    //添加
    public static function add($typeArr, $operationTypeArr, $uid, $num, $continuous_num = 1, $remark = '') {
        $up['type'] = $typeArr[0];//添加/减少
        $up['operation_type'] = $operationTypeArr[0];//添加/减少
        $up['uid'] = $uid;
        $up['num'] = $num;
        $up['continuous_num'] = $continuous_num;
        $up['remark'] = $remark ?: '';
        $up['day'] = bbsGetDay(2);
        $up['create_at'] = bbsGetDay();
        $up['update_at'] = time();
        return self::query()->insertGetId($up);
    }

    //查询
    public static function check($uid, $operationTypeArr, $day = null) {
        return self::query()
            ->where([
                'uid' => $uid,
                'operation_type' => $operationTypeArr[0],
            ])
            ->where(function ($q) use ($day) {
                if ($day) $q->where('day', $day);
            })
            ->orderByDesc('create_at')
            ->first();
    }
}
