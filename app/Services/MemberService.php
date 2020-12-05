<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MembersVerifyLogs;
use App\Models\TemplateMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberService {
    /**
     * 手机绑定：发送验证码
     * @param $params
     * @return array
     */
    static function sendSmsBindCode($params = [], $login_user) {
        if (empty($params['phone'])) return return_api_format(['status' => 40000, 'msg' => '请输入绑定的手机号！']);
        if (!is_mobile($params['phone'])) return return_api_format(['status' => 40000, 'msg' => '请输入正确的手机号！']);
        if ($login_user['phone_active'] == 1 && $params['phone'] == $login_user['phone']) return return_api_format(['status' => 40000, 'msg' => '您已绑定该手机号！']);
        if (!empty(MembersVerifyLogs::getLastVerifyCode($params['uid'], 1, 1))) return return_api_format(['status' => 200, 'msg' => '您已发送验证码！']);

        $params['phone_code'] = random_verification_code(6);//验证码

        $template_content = TemplateMessage::getTemplateMessage('sms_bind_template', $params['phone_code']);
        if ($template_content['status'] != 1) return return_api_format(['status' => 40000, 'msg' => $template_content['msg']]);
        $send_content = $template_content['data'];

        $verify_data = [
            'uid' => $params['uid'],
            'verify_type' => 1,//手机号
            'origin_type' => 1,//PC
            'verify_code' => $params['phone_code'],
            'verify_receive' => $params['phone'],
            'verify_title' => '绑定手机号',
            'verify_content' => $send_content,
        ];
        return MembersVerifyLogs::createData($verify_data);//插入【发送验证】记录
        return return_api_format(['status' => 200, 'msg' => 'success']);
    }

    //手机号的code进行认证，通过之后，手机号绑定成功
    static function checkSmsBindCode($params = [], $login_unique = Member::LOGIN_UNIQUE) {
        $validator = Validator::make($params, [
            'phone' => 'required',
            'phone_code' => 'required',
        ], [
            'phone.required' => '请输入绑定的手机号！',
            'phone_code.required' => '请输入验证码！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 40000, 'msg' => $validator->errors()->first()]);
        if (!is_mobile($params['phone'])) return return_api_format(['status' => 40000, 'msg' => '请输入正确的手机号！']);

        if (empty($verify_code = MembersVerifyLogs::getLastVerifyCode($params['uid'], 1, 1))) return return_api_format(['status' => 40000, 'msg' => '验证码已失效，请重新发送！']);
        if ($verify_code->verify_receive != $params['phone']) return return_api_format(['status' => 40000, 'msg' => '该手机号与验证码不匹配！']);
        if (empty($params['phone_code'])) return return_api_format(['status' => 40000, 'msg' => '请重新发送验证码！']);
        if ($verify_code->verify_code != $params['phone_code']) return return_api_format(['status' => 40000, 'msg' => '该验证码不匹配！']);
        if (empty($user = Member::lockForUpdate()->find($params['uid']))) return return_api_format(['status' => 40000, 'msg' => '账户已丢失，请重新登陆！']);

        $params['phone_active'] = 1;
        DB::beginTransaction();
        try {
            //1.更新会员的资料
            $user->uid = !isset($params['uid']) ? 0 : $params['uid'];
            $user->update_at = date('Y-m-d H:i:s');
            $user->phone = $params['phone'];
            $user->phone_active = $params['phone_active'];
            $user->save();

            //2.认证记录表 更新操作
            MembersVerifyLogs::where('id', $verify_code->id)->update(['is_active' => 1]);

            DB::commit();

            //同步SESSION --- PC站点
            if ($verify_code->origin_type == 1) Member::changeUserInfoSynchSession($login_unique, ['phone', 'phone_active'], $params);

            return return_api_format(['status' => 200, 'msg' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return return_api_format(['status' => 40000, 'msg' => '手机号绑定失败！']);
        }
    }

    /**
     * 手机号解绑：发送验证码
     * @param $params
     * @return array
     */
    static function sendSmsUntyingCode($params = [], $login_user = []) {
        if (empty($params['phone'])) return return_api_format(['status' => 40000, 'msg' => '请输入解绑的手机号！']);
        if (!is_mobile($params['phone'])) return return_api_format(['status' => 40000, 'msg' => '请输入正确的手机号！']);
        if ($params['phone'] != $login_user['phone']) return return_api_format(['status' => 40000, 'msg' => '您尚未绑定该手机号，无需解绑！']);

        if (!empty(MembersVerifyLogs::getLastVerifyCode($params['uid'], 1, 1, 0))) return return_api_format(['status' => 200, 'msg' => '您已发送验证码！']);
        $params['phone_code'] = random_verification_code(6);//验证码

        $template_content = TemplateMessage::getTemplateMessage('sms_untying_template', $params['phone_code']);
        if ($template_content['status'] != 1) return return_api_format(['status' => 40000, 'msg' => $template_content['msg']]);
        $send_content = $template_content['data'];

        $verify_data = [
            'uid' => $params['uid'],
            'verify_type' => 1,//手机号
            'origin_type' => 1,//PC
            'bind_type' => 0,//解绑
            'verify_code' => $params['phone_code'],
            'verify_receive' => $params['phone'],
            'verify_title' => '解绑手机号',
            'verify_content' => $send_content,
        ];
        return MembersVerifyLogs::createData($verify_data);//插入【发送验证】记录
        return return_api_format(['status' => 200, 'msg' => 'success']);
    }

    //手机号的code进行认证，通过之后，手机号解绑成功
    static function checkSmsUntyingCode($params = [], $login_unique = Member::LOGIN_UNIQUE) {
        $validator = Validator::make($params, [
            'phone' => 'required',
            'phone_code' => 'required',
        ], [
            'phone.required' => '请输入解绑的手机号！',
            'phone_code.required' => '请输入验证码！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 40000, 'msg' => $validator->errors()->first()]);
        if (!is_mobile($params['phone'])) return return_api_format(['status' => 40000, 'msg' => '请输入正确的手机号！']);

        if (empty($verify_code = MembersVerifyLogs::getLastVerifyCode($params['uid'], 1, 1, 0))) return return_api_format(['status' => 40000, 'msg' => '验证码已失效，请重新发送！']);
        if ($verify_code->verify_receive != $params['phone']) return return_api_format(['status' => 40000, 'msg' => '该手机号与验证码不匹配！']);
        if (empty($params['phone_code'])) return return_api_format(['status' => 40000, 'msg' => '请重新发送验证码！']);
        if ($verify_code->verify_code != $params['phone_code']) return return_api_format(['status' => 40000, 'msg' => '该验证码不匹配！']);
        if (empty($user = Member::lockForUpdate()->find($params['uid']))) return return_api_format(['status' => 40000, 'msg' => '账户已丢失，请重新登陆！']);

        $params['phone'] = '';
        $params['phone_active'] = 0;
        DB::beginTransaction();
        try {
            //1.更新会员的资料
            $user->uid = !isset($params['uid']) ? 0 : $params['uid'];
            $user->update_at = date('Y-m-d H:i:s');
            $user->phone = $params['phone'];
            $user->phone_active = $params['phone_active'];
            $user->save();

            //2.认证记录表 更新操作
            MembersVerifyLogs::where('id', $verify_code->id)->update(['is_active' => 1]);

            DB::commit();

            //同步SESSION --- PC站点
            if ($verify_code->origin_type == 1) Member::changeUserInfoSynchSession($login_unique, ['phone', 'phone_active'], $params);
            return return_api_format(['status' => 200, 'msg' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return return_api_format(['status' => 40000, 'msg' => '手机号解绑失败！']);
        }
    }


    /**
     * 邮箱绑定：发送验证码
     * @param $params
     * @return array
     */
    static function sendEmailBindCode($params = []) {
        if (empty($params['email'])) return return_api_format(['status' => 40000, 'msg' => '请输入绑定的邮箱账户！']);
        $params['email_code'] = random_verification_code(6);//验证码

        if (!empty(MembersVerifyLogs::getLastVerifyCode($params['uid'], 0, 1))) return return_api_format(['status' => 200, 'msg' => '您已发送验证码！']);

        $template_content = TemplateMessage::getTemplateMessage('mail_bind_template', $params['email_code']);
        if ($template_content['status'] != 1) return return_api_format(['status' => 40000, 'msg' => $template_content['msg']]);
        $send_content = $template_content['data'];

        $time = time();
        $verify_data = [
            'uid' => $params['uid'],
            'verify_type' => 0,//邮箱
            'origin_type' => 1,//PC
            'verify_code' => $params['email_code'],
            'verify_receive' => $params['email'],
            'verify_title' => '绑定邮箱验证',
            'verify_content' => $send_content,
        ];
        return MembersVerifyLogs::createData($verify_data);//插入【发送验证】记录
        return return_api_format(['status' => 200, 'msg' => 'success']);
    }

    //邮件的code进行认证，通过之后，邮件绑定成功
    static function checkEmailBindCode($params = [], $login_unique = Member::LOGIN_UNIQUE) {
        $validator = Validator::make($params, [
            'email' => 'required',
            'email_code' => 'required',
        ], [
            'email.required' => '请输入绑定的邮箱账户！',
            'email_code.required' => '请输入验证码！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 40000, 'msg' => $validator->errors()->first()]);

        if (empty($verify_code = MembersVerifyLogs::getLastVerifyCode($params['uid'], 0, 1))) return return_api_format(['status' => 40000, 'msg' => '验证码已失效，请重新发送！']);
        if ($verify_code->verify_receive != $params['email']) return return_api_format(['status' => 40000, 'msg' => '该邮箱与验证码不匹配！']);
        if (empty($params['email_code'])) return return_api_format(['status' => 40000, 'msg' => '请重新发送验证码！']);
        if ($verify_code->verify_code != $params['email_code']) return return_api_format(['status' => 40000, 'msg' => '该验证码不匹配！']);
        if (empty($user = Member::lockForUpdate()->find($params['uid']))) return return_api_format(['status' => 40000, 'msg' => '账户已丢失，请重新登陆！']);

        $params['email_active'] = 1;
        DB::beginTransaction();
        try {
            //1.更新会员的资料
            $user->uid = !isset($params['uid']) ? 0 : $params['uid'];
            $user->update_at = date('Y-m-d H:i:s');
            $user->email = $params['email'];
            $user->email_active = $params['email_active'];
            $user->save();

            //2.认证记录表 更新操作
            MembersVerifyLogs::where('id', $verify_code->id)->update(['is_active' => 1]);

            DB::commit();

            //同步SESSION --- PC站点
            if ($verify_code->origin_type == 1) Member::changeUserInfoSynchSession($login_unique, ['email', 'email_active'], $params);

            return return_api_format(['status' => 200, 'msg' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return return_api_format(['status' => 40000, 'msg' => '邮箱绑定失败！']);
        }
    }

    /**
     * 邮箱解绑：发送验证码
     * @param $params
     * @return array
     */
    static function sendEmailUntyingCode($params = []) {
        if (empty($params['email'])) return return_api_format(['status' => 40000, 'msg' => '请输入解绑的邮箱账户！']);
        $params['email_code'] = random_verification_code(6);//验证码

        if (!empty(MembersVerifyLogs::getLastVerifyCode($params['uid'], 0, 1, 0))) return return_api_format(['status' => 200, 'msg' => '您已发送验证码！']);

        $template_content = TemplateMessage::getTemplateMessage('mail_untying_template', $params['email_code']);
        if ($template_content['status'] != 1) return return_api_format(['status' => 40000, 'msg' => $template_content['msg']]);
        $send_content = $template_content['data'];

        $time = time();
        $verify_data = [
            'uid' => $params['uid'],
            'verify_type' => 0,//邮箱
            'origin_type' => 1,//PC
            'bind_type' => 0,//解绑
            'verify_code' => $params['email_code'],
            'verify_receive' => $params['email'],
            'verify_title' => '解绑邮箱验证',
            'verify_content' => $send_content,
        ];
        return MembersVerifyLogs::createData($verify_data);//插入【发送验证】记录
        return return_api_format(['status' => 200, 'msg' => 'success']);
    }

    //邮件的code进行认证，通过之后，邮件解绑成功
    static function checkEmailUntyingCode($params = [], $login_unique = Member::LOGIN_UNIQUE) {
        $validator = Validator::make($params, [
            'email' => 'required',
            'email_code' => 'required',
        ], [
            'email.required' => '请输入解绑的邮箱账户！',
            'email_code.required' => '请输入验证码！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 40000, 'msg' => $validator->errors()->first()]);

        if (empty($verify_code = MembersVerifyLogs::getLastVerifyCode($params['uid'], 0, 1, 0))) return return_api_format(['status' => 40000, 'msg' => '验证码已失效，请重新发送！']);
        if ($verify_code->verify_receive != $params['email']) return return_api_format(['status' => 40000, 'msg' => '该邮箱与验证码不匹配！']);
        if (empty($params['email_code'])) return return_api_format(['status' => 40000, 'msg' => '请重新发送验证码！']);
        if ($verify_code->verify_code != $params['email_code']) return return_api_format(['status' => 40000, 'msg' => '该验证码不匹配！']);
        if (empty($user = Member::lockForUpdate()->find($params['uid']))) return return_api_format(['status' => 40000, 'msg' => '账户已丢失，请重新登陆！']);

        $params['email'] = '';
        $params['email_active'] = 0;
        DB::beginTransaction();
        try {
            //1.更新会员的资料
            $user->uid = !isset($params['uid']) ? 0 : $params['uid'];
            $user->update_at = date('Y-m-d H:i:s');
            $user->email = $params['email'];
            $user->email_active = $params['email_active'];
            $user->save();

            //2.认证记录表 更新操作
            MembersVerifyLogs::where('id', $verify_code->id)->update(['is_active' => 1]);

            //同步SESSION --- PC站点
            if ($verify_code->origin_type == 1) Member::changeUserInfoSynchSession($login_unique, ['email', 'email_active'], $params);

            DB::commit();
            return return_api_format(['status' => 200, 'msg' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return return_api_format(['status' => 40000, 'msg' => '邮箱解绑失败！']);
        }
    }

    static function saveUserInfo($request, $user, $login_unique = Member::LOGIN_UNIQUE) {
        $params = $request->all();
        if (isset($_FILES['avatar'])) {
            $pre_icon = UploadFile($request, 'avatar', 'avatar/' . date('Y-m-d') . '/' . uniqid(), ALLOWEXT, __E('upload_driver'));
            if ($pre_icon) $update['avatar'] = $pre_icon;
        }
        $update['uid'] = $user['uid'];
        if (isset($params['nickname'])) $update['nickname'] = $params['nickname'];
        if (isset($params['birthday'])) $update['birthday'] = $params['birthday'];
        $res = (new Member())->UpdateArr($update);
        if (!$res) return return_api_format(['status' => 40000, 'msg' => '更新失败！']);

        if (is_array($user)) Member::changeUserInfoSynchSession($login_unique, ['avatar', 'username', 'nickname', 'birthday'], $update);//同步SESSION

        return return_api_format(['status' => 200, 'msg' => '更新成功！', 'data' => []]);
    }

    /**
     * 登录 - 获取验证码
     * @param array $params
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getLoginCode($params) {
        $validator = Validator::make($params, [
            'phone' => 'required',
        ], [
            'phone.required' => '手机号为必填项！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 0, 'msg' => $validator->errors()->first()]);


        $user = Member::where('type', 'member')->where('phone', $params['phone'])->first();
        if ($user && intval($user->status) != 1) return return_api_format(['status' => 0, 'msg' => '该账户已被禁用']);


        if (!empty($re = MembersVerifyLogs::getLastVerifyCode($user->uid ?: 0, 1, 1, 1, $params['phone']))) {
            return return_api_format(['status' => 200, 'msg' => '您已发送验证码！']);
        }

        $params['phone_code'] = random_verification_code(6);//验证码

        //$template_content = TemplateMessage::getTemplateMessage('sms_login_template', $params['phone_code']);
        $template_content = TemplateMessage::getTemplateMessage('sms_register_template', $params['phone_code']);
        if ($template_content['status'] != 1) return return_api_format(['status' => 0, 'msg' => $template_content['msg']]);
        $send_content = $template_content['data'];

        $verify_data = [
            'uid' => $user->uid,
            'verify_type' => 1,//手机号
            'origin_type' => 1,//PC
            'verify_code' => $params['phone_code'],
            'verify_receive' => $params['phone'],
            'verify_title' => '短信登录',
            'verify_content' => $send_content,
        ];
        return MembersVerifyLogs::createData($verify_data);//插入【发送验证】记录
    }

    /**
     * 获取验证码
     * @param array $type getType  1=注册 2=登录 3=忘记密码 4=修改手机 5=绑定新手机  template=模板名字   msg=模板提示
     * @param array $params
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getCode($type, $params) {
        $validator = Validator::make($type, [
            'getType' => 'required',
            'template' => 'required',
            'msg' => 'required',
        ], [
            'getType.required' => '发送类型为必填项',
            'template.required' => '发送模板为必填项',
            'msg.required' => '模板提示为必填项',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 0, 'msg' => $validator->errors()->first()]);
        $validator = Validator::make($params, [
            'phone' => 'required',
        ], [
            'phone.required' => '手机号为必填项！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 0, 'msg' => $validator->errors()->first()]);

        $user = Member::where('type', 'member')->where('phone', $params['phone'])->first();
        //需要更新类型
        if ($type['updateType'] == 1) {
            if ($user) {
                $type['msg'] = '登录账号';
                $type['getType'] = 2;
                $type['template'] = 'sms_login_template';//暂时用户绑定的
            } else {
                $type['msg'] = '注册账户';
                $type['getType'] = 1;
                $type['template'] = 'sms_register_template';//注册
            }
        }
        //1=注册  5=绑定新手机 / 手机要不存在
        //2=登录 3=忘记密码 4=修改手机 / 手机要存在
        if (in_array($type['getType'], [2, 3, 4, 6, 8])) {
            if (!$user) return return_api_format(['status' => 0, 'msg' => '手机号不存在']);
            if (intval($user->status) != 1) return return_api_format(['status' => 0, 'msg' => '该账户已被禁用']);
        } elseif (in_array($type['getType'], [1, 5])) {
            if ($user) return return_api_format(['status' => 0, 'msg' => '手机号已存在']);
        } elseif (in_array($type['getType'], [9])) {
        } else {
            return return_api_format(['status' => 0, 'msg' => '请求类型错误']);
        }

        //去掉限制
//        if (!empty($re = MembersVerifyLogs::getLastVerifyCode(intval($user->uid), 1, 1, 1, $params['phone']))) {
//            return return_api_format(['status' => 200, 'msg' => '您已发送验证码！']);
//        }

        //获取短信验证码,10分钟内保持一样
        $isexit = MembersVerifyLogs::where("verify_receive", $params['phone'])
            ->where("created_at", ">=", date("Y-m-d H:i:s", time() - 10 * 60))
            ->where('is_active', 0)
            ->orderBy("created_at", "desc")
            ->first();
        if ($isexit) {
            $params['phone_code'] = $isexit->verify_code;
        } else {
            $params['phone_code'] = random_verification_code(6);//验证码
        }
        if ($user->uid) MembersVerifyLogs::deleteUserAllSMS($user->uid);

        $template_content = TemplateMessage::getTemplateMessage($type['template'], $params['phone_code']);
        if ($template_content['status'] != 1) return return_api_format(['status' => 0, 'msg' => $template_content['msg']]);
        $send_content = $template_content['data'];
        $template_id = $template_content['template_id'];

        $verify_data = [
            'uid' => $user->uid,
            'verify_type' => 1,//手机号
            'origin_type' => 1,//PC
            'verify_code' => $params['phone_code'],
            'verify_receive' => $params['phone'],
            'verify_title' => $type['msg'],
            'verify_content' => $send_content,
            'template_id' => $template_id,
        ];
        return MembersVerifyLogs::createData($verify_data);//插入【发送验证】记录
    }

    /**
     * 注册 - 获取验证码
     * @param array $params
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getRegisterCode($params) {
        if (__E("website_open_reg") != 1) return return_api_format(['status' => 40000, 'msg' => '系统关闭注册功能！']);
        $validator = Validator::make($params, [
            'phone' => 'required',
        ], [
            'phone.required' => '手机号为必填项！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 40000, 'msg' => $validator->errors()->first()]);


        if (!empty($user = Member::where('type', 'member')
            ->where('phone', $params['phone'])
            ->first())) return return_api_format(['status' => 40000, 'msg' => '手机号已存在']);

        if (!empty(MembersVerifyLogs::getLastVerifyCode(0, 1, 1, 1, $params['phone']))) return return_api_format(['status' => 200, 'msg' => '您已发送验证码！']);
        $params['phone_code'] = random_verification_code(6);//验证码

        $template_content = TemplateMessage::getTemplateMessage('sms_register_template', $params['phone_code']);
        if ($template_content['status'] != 1) return return_api_format(['status' => 40000, 'msg' => $template_content['msg']]);
        $send_content = $template_content['data'];

        $verify_data = [
            'uid' => 0,
            'verify_type' => 1,//手机号
            'origin_type' => 1,//PC
            'verify_code' => $params['phone_code'],
            'verify_receive' => $params['phone'],
            'verify_title' => '注册账户',
            'verify_content' => $send_content,
        ];
        return MembersVerifyLogs::createData($verify_data);//插入【发送验证】记录
    }

    static function register($params = []) {
        if (__E("website_open_reg") != 1) return ['error' => '系统关闭注册功能！'];
        $validator = Validator::make($params, [
            'username' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'code' => 'required',
            'email' => 'required',
        ], [
            'username.required' => '用户名为必填项！',
            'phone.required' => '手机号为必填项！',
            'password.required' => '密码为必填项！',
            'code.required' => '验证码为必填项！',
            'email.required' => '邮箱为必填项！',
        ]);
        if ($validator->fails()) return ['error' => $validator->errors()->first()];

        if (empty($verify_code = MembersVerifyLogs::getLastVerifyCode(0, 1, 1, 1, $params['phone']))) return ['error' => '验证码已失效，请重新发送！'];
        if ($verify_code->verify_receive != $params['phone']) return ['error' => '该手机号与验证码不匹配！'];
        if (empty($params['code'])) return ['error' => '请重新发送验证码！'];
        if ($verify_code->verify_code != $params['code']) return ['error' => '该验证码不匹配！'];

        if (!empty($user = Member::where('type', 'member')
            ->where('username', $params['username'])
            ->first())) return ['error' => '用户名已存在'];

        //判断是否开启注册功能
        if (__E('website_open_reg') != 1) return ['error' => '系统关闭注册功能！'];
        //注册前钩子

        if (!Member::create([
            'username' => $params['username'],
            'phone' => $params['phone'],
            'password' => member_encryption_mode($params['password']),
            'phone_active' => 1,
            'status' => 1,
            'avatar' => 'avatar/avatar.jpg',
            'type' => 'member',
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        ])) return array('error' => '注册失败！');
    }

    /**
     * 找回密码 - 获取验证码
     * @param array $params
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getForgetCode($params) {
        $validator = Validator::make($params, [
            'phone' => 'required',
        ], [
            'phone.required' => '手机号为必填项！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 40000, 'msg' => $validator->errors()->first()]);


        if (empty($user = Member::where('type', 'member')
            ->where('phone', $params['phone'])
            ->first())) return return_api_format(['status' => 40000, 'msg' => '手机号不存在']);
        if (intval($user->status) != 1) return return_api_format(['status' => 40000, 'msg' => '该账户已被禁用']);

        if (!empty(MembersVerifyLogs::getLastVerifyCode($user->uid, 1, 1, 1, $params['phone']))) return return_api_format(['status' => 200, 'msg' => '您已发送验证码！']);
        $params['phone_code'] = random_verification_code(6);//验证码

        $template_content = TemplateMessage::getTemplateMessage('sms_forgot_template', $params['phone_code']);
        if ($template_content['status'] != 1) return return_api_format(['status' => 40000, 'msg' => $template_content['msg']]);
        $send_content = $template_content['data'];

        $verify_data = [
            'uid' => $user->uid,
            'verify_type' => 1,//手机号
            'origin_type' => 1,//PC
            'verify_code' => $params['phone_code'],
            'verify_receive' => $params['phone'],
            'verify_title' => '找回密码',
            'verify_content' => $send_content,
        ];
        return MembersVerifyLogs::createData($verify_data);//插入【发送验证】记录
    }

    static function forget($params) {
        $validator = Validator::make($params, [
            'phone' => 'required',
            'password' => 'required',
            'password2' => [
                'required',
                'same:password'
            ],
            'code' => 'required',
        ], [
            'phone.required' => '手机号不能为空！',
            'password.required' => '密码不能为空！',
            'password2.required' => '请再次输入密码！',
            'password2.same' => '密码与确认密码不匹配！',
            'code.required' => '验证码为必填项！',
        ]);
        if ($validator->fails()) return ['error' => $validator->errors()->first()];

        if (empty($user = Member::where('type', 'member')
            ->where('phone', $params['phone'])
            ->lockForUpdate()
            ->first())) return ['error' => '手机号不存在！'];
        if (intval($user->status) != 1) return ['error' => '该账户已被禁用'];
        if (empty($verify_code = MembersVerifyLogs::getLastVerifyCode($user->uid, 1, 1, 1, $params['phone']))) return ['error' => '验证码已失效，请重新发送！'];
        if ($verify_code->verify_receive != $params['phone']) return ['error' => '该手机号与验证码不匹配！'];
        if (empty($params['code'])) return ['error' => '请重新发送验证码！'];
        if ($verify_code->verify_code != $params['code']) return ['error' => '该验证码不匹配！'];

        DB::beginTransaction();
        try {
            //1.更新会员的资料
            $user->update_at = date('Y-m-d H:i:s');
            $user->password = member_encryption_mode($params['password']);
            $user->save();

            //2.认证记录表 更新操作
            MembersVerifyLogs::where('id', $verify_code->id)->update(['is_active' => 1]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => '密码更新失败！'];
        }
    }
}