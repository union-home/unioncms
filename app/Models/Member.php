<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Member extends Model
{
    //设置表名
    const TABLE_NAME = 'members',
        DEFAULT_PASS = '123456',
    LOGIN_UNIQUE = 'home_info',
    ADMIN_LOGIN_UNIQUE = 'admin_info'; //登陆的 SESSION 标识
    protected $table = self::TABLE_NAME;
    protected $primaryKey='uid';
    public $timestamps = false;
    protected $guarded = [];

    /*protected $fillable = [
        'username','avatar', 'password','type','c_code','phone','email','nickname','phone_active','email_active','status'
    ];*/

    //后台添加
    function InsterArrByAdmin($arr){
        if (!is_array($arr)) return ;
        //判断用户名是否重复
        $res = self::where('username','=',$arr['username'])->count();

        if($res){
            return array('error'=>'用户名已存在！');
        }

        $this->username = $arr['username'];

        $this->nickname = !isset($arr['nickname']) ? $arr['username'] : $arr['nickname'];

        if(isset($arr['gid'])){
            $this->gid = $arr['gid'];
        }else{
            $this->gid = '';
        }

        $this->phone = !isset($arr['phone']) ? '' : $arr['phone'];

        $this->phone_active = !isset($arr['phone_active']) ? 0 : $arr['phone_active'];

        $this->email = !isset($arr['email']) ? '' : $arr['email'];

        $this->email_active = !isset($arr['email_active']) ? 0 : $arr['email_active'];

        $this->password = md5('union_'.md5($arr['password']));

        if(isset($arr['avatar'])){
            $this->avatar= $arr['avatar'];
        }else{
            $this->avatar= 'avatar/avatar.jpg';
        }

        $this->type = $arr['type'];

        $this->status = !isset($arr['status']) ? 0 : $arr['status'];

        $this->create_at = $this->update_at = date('Y-m-d H:i:s');

        $bool = self::save();

        if(!$bool){
            return array('error'=>'注册失败！');
        }
        return true;
    }

    //注册插入
    function InsterArr($arr){
        //判断是否开启注册功能
        if(__E("website_open_reg")!=1){
            return array("error"=>"系统关闭注册功能！");
        }
        if (!is_array($arr)){
            return ;
        }
        //密码是否一致
        if($arr['password'] != $arr['password2']){
            return array('error'=>'两次密码不一致！');
        }

        //判断用户名是否重复
        $res = self::where('username','=',$arr['username'])
           ->count();

        if($res){
            return array('error'=>'用户名已存在！');
        }

        if (isset($arr['phone'])) {
            $this->phone = $arr['phone'];
            $this->phone_active = 1;
        }
        if (isset($arr['email'])) $this->email = $arr['email'];
        $this->username = $arr['username'];
        $this->password = md5('union_'.md5($arr['password']));
        $this->avatar= 'avatar/avatar.jpg';
        $this->type = 'member';
        $this->status = 1;
        $this->create_at = $this->update_at = date('Y-m-d H:i:s');

        $bool = self::save();

        if(!$bool){
            return array('error'=>'注册失败！');
        }

        return true;
    }

    //更改会员的登陆密码
    static function setUserPass($params){
        $validator = Validator::make($params, [
            'old_pass' => 'required',
            'password' => 'required',
            'password_confirmation' => [
                'required',
                'same:password'
            ],
        ], [
            'old_pass.required' => '旧密码为必填项！',
            'password.required' => '新密码为必填项！',
            'password_confirmation.required' => '确认密码为必填项！',
            'password_confirmation.same' => '新密码与确认密码不匹配！',
        ]);
        if ($validator->fails()) return return_api_format([ 'status' => 40000, 'msg' => $validator->errors()->first() ]);

        if(empty($user = self::where([
            'uid' => $params['uid'],
            'password' => md5('union_'.md5($params['old_pass']))
        ])->lockForUpdate()->first())) return return_api_format([ 'status' => 40000, 'msg' => '旧密码不匹配！' ]);

        if(md5('union_'.md5($params['old_pass'])) == md5('union_'.md5($params['password']))) return return_api_format([ 'status' => 40000, 'msg' => '登陆密码尚未变更！' ]);

        $user->uid = !isset($params['uid']) ? 0 : $params['uid'];
        $user->update_at = date('Y-m-d H:i:s');
        $user->password = md5('union_'.md5($params['password']));
        if(!$user->save()) return return_api_format([ 'status' => 40000, 'msg' => '更改登陆密码失败！' ]);
        else return return_api_format([ 'status' => 200, 'msg' => '更改登陆密码成功！' ]);
    }

    //更新数据
    function UpdateArr($arr){
        if (!is_array($arr)) return ;
        $obj = $this->lockForUpdate()->find($arr['uid']);

        foreach ($arr as $key => $val){
            if($key =='uid') continue;
            $obj->$key = $val;
        }
        $obj->update_at = date('Y-m-d H:i:s');
        return $obj->save();
    }

    //查找信息
    //通过filed查找数据
    function GetdataByFiled($arr, $type='admin'){
        $data = self::where(array(
                            'username'=>$arr['username'],
                            'password'=>md5('union_'.md5($arr['password']))))

                ->where('type','=',$type)
                ->orderBy('create_at','asc')
                ->first();
        if($data) return $data->toArray();
        else return [];
    }

    /**
     * 编辑会员的基本信息
     * @param $request
     * @param $uid
     * @param $login_unique
     * @return array
     */
    function saveUserInfo($request, $uid = 0, $login_unique = self::LOGIN_UNIQUE)
    {
        $params = $request->all();
        if(isset($_FILES['avatar'])){
            $pre_icon = UploadFile($request, 'avatar','avatar/'.date('Y-m-d').'/'.uniqid(),ALLOWEXT,__E('upload_driver'));
            if($pre_icon) $update['avatar'] = $pre_icon;
        }
        $update['uid'] = $uid;
        if(isset($params['male'])) $update['male'] = $params['male'];
        if(isset($params['nickname'])) $update['nickname'] = $params['nickname'];
        if(isset($params['birthday'])) $update['birthday'] = $params['birthday'];
        $res = $this->UpdateArr($update);
        if(!$res) return return_api_format([ 'status' => 40000, 'msg' => '更新失败！' ]);

        self::changeUserInfoSynchSession($login_unique, ['avatar', 'nickname', 'birthday', 'male'], $update);//同步SESSION

        return return_api_format([ 'status' => 200, 'msg' => '更新成功！' ]);
    }

    /**
     * 登陆会员更改信息之后，及时同步到SESSION
     * @param string $login_unique
     * @param array $change_field
     * @param array $change_data
     */
    public static function changeUserInfoSynchSession($login_unique = self::LOGIN_UNIQUE, $change_field = [], $change_data = [])
    {
        if(!empty($login_unique))
        {
            $login_user = session($login_unique);
            if(!empty($change_field))
            {
                foreach($change_field as $field)
                {
                    if(isset($change_data[$field])) $login_user[$field] = $change_data[$field];
                }
            }
            session()->put([$login_unique => $login_user]);
        }
    }

    public static function makeUniqueUsername($user_name)
    {
        $old_name = $user_name;
        do{
            $user_name = $old_name . '_' . date('YmdHis') . '_' . random_verification_code();
        }while(self::where('username','=',$user_name)->count() != 0);
        return $user_name;
    }
}
