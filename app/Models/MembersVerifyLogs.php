<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembersVerifyLogs extends Model {
    const TABLE_NAME = "members_verify_logs",
        CODE_EXPIRE_TIME = 60 * 10; //验证码过期时长 10 分钟
    protected $table = self::TABLE_NAME;
    public $timestamps = false;

    /**
     * 获取当前认证的最新数据
     * @param int $uid
     * @param int $verify_type
     * @param int $origin_type
     * @param int $bind_type
     * @return Model|null|static
     */
    public static function getLastVerifyCode($uid = 0, $verify_type = 0, $origin_type = 0, $bind_type = 1, $verify_receive = '') {
        $where = [
            'uid' => $uid, //会员标识
            'is_active' => 0,//必须是尚未认证的
            'verify_type' => $verify_type, //认证类型
            'origin_type' => $origin_type, //来源类型
            'bind_type' => $bind_type //绑定类型【1.绑定；0.解绑】
        ];
        if (!empty($verify_receive)) $where['verify_receive'] = $verify_receive;
        return self::where($where)
            ->where('enddate_at', '>=', date('Y-m-d H:i:s'))
            ->first();
    }

    public static function createData($params = []) {
        $verify_data = [
            'uid' => empty($params['uid']) ? 0 : $params['uid'],
            'verify_type' => !isset($params['verify_type']) ? 0 : $params['verify_type'],
            'origin_type' => !isset($params['origin_type']) ? 0 : $params['origin_type'],
            'bind_type' => !isset($params['bind_type']) ? 1 : $params['bind_type'],
            'verify_code' => empty($params['verify_code']) ? '' : $params['verify_code'],
            'verify_receive' => empty($params['verify_receive']) ? '' : $params['verify_receive'],
            'verify_title' => empty($params['verify_title']) ? '' : $params['verify_title'],
            'verify_content' => empty($params['verify_content']) ? '' : $params['verify_content'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'enddate_at' => date('Y-m-d H:i:s', time() + self::CODE_EXPIRE_TIME), //过期时间
        ];
        self::insert($verify_data);//插入【发送验证】记录


        /**
         *
         * 暂时不开启短信或者邮箱发送
         *
         */
        // return return_api_format(['status' => 200, 'msg' => 'success']);


        switch ($verify_data['verify_type']) {
            case 0: //邮箱
                sendEmail($verify_data['verify_receive'], $verify_data['verify_content'], $verify_data['verify_title']);//发送邮件操作
                return return_api_format(['status' => 200, 'msg' => 'success']);
                break;
            case 1: //手机号
                $return = event(new \App\Events\SendSMSDriver(new Request(), __E('sms_driver'), '', $verify_data['verify_receive'], '', $verify_data['verify_content']));
                foreach ($return as $v) {
                    if (!empty($v)) return $v;
                }
                break;
        }
    }

    //删除短信
    public static function deleteSMS($verify_code) {
        if (is_object($verify_code)) {
            $id = $verify_code->id;
        } elseif (is_array($verify_code)) {
            $id = $verify_code['id'];
        }
        return self::destroy($id);
    }

    //删除用户所有短信
    public static function deleteUserAllSMS($uid) {
        if ($uid <= 0) return true;
        return self::query()->where('uid', $uid)->delete();
    }
}