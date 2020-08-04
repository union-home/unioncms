<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Feedback extends Model
{
    //设置表名
    const TABLE_NAME = 'feedback';
    protected $table = self::TABLE_NAME;
    protected $primaryKey = 'id';
    public $timestamps = false;

    //添加数据
    function InsertArr($params){
        $validator = Validator::make($params, [
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_tel' => 'required',
            'content' => 'required',
        ], [
            'user_name.required' => '姓名为必填项！',
            'user_email.required' => '邮箱为必填项！',
            'user_email.email' => '请输入正确的邮箱！',
            'user_tel.required' => '电话为必填项！',
            'content.required' => '留言内容为必填项！',
        ]);
        if ($validator->fails()) return return_api_format([ 'status' => 40000, 'msg' => $validator->errors()->first() ]);

        $this->uid = !isset($params['uid']) ? 0 : $params['uid'];
        if(empty($this->uid)) return return_api_format([ 'status' => 40000, 'msg' => '会员信息丢失，请重新登录' ]);
        $this->user_name = !isset($params['user_name']) ? '' : $params['user_name'];
        $this->user_email = !isset($params['user_email']) ? '' : $params['user_email'];
        $this->user_tel = !isset($params['user_tel']) ? '' : $params['user_tel'];
        if(!is_mobile($this->user_tel)) return return_api_format([ 'status' => 40000, 'msg' => '请输入正确手机号' ]);
        $this->content = !isset($params['content']) ? '' : $params['content'];
        $this->user_name = !isset($params['user_name']) ? '' : $params['user_name'];
        $this->create_at = date('Y-m-d H:i:s');
        $this->update_at = date('Y-m-d H:i:s');
        if(!self::save()) return return_api_format([ 'status' => 40000, 'msg' => '留言失败！' ]);
        else return return_api_format([ 'status' => 200, 'msg' => '留言成功！', 'data' => $this ]);
    }

    //更新数据
    function UpdateArr($arr){
        if (!is_array($arr)) return ;
        $obj = $this->find($arr['id']);
        $obj->title = $arr['title'];
        $obj->content = $arr['content'];
        $obj->qcid = $arr['qcid'];
        $obj->update_at = date('Y-m-d H:i:s');
        $obj->save();
    }

    //删除
    static function deleteById($id){
        $data = self::where('id','=',$id)->count();
        if($data >= 1) return false;
        return self::destroy($id);
    }

    //删除会员自己的留言
    static function deleteByUser($where){
        if(!self::where($where)->delete()) return return_api_format([ 'status' => 40000, 'msg' => '删除留言失败！' ]);
        else return return_api_format([ 'status' => 200, 'msg' => '删除留言成功！' ]);
    }

}
