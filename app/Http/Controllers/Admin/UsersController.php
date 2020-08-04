<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoginLog;
use App\Models\MenuGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;

class UsersController extends Controller {
    //管理员列表
    function admins() {
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $user = Member::where('type', '=', 'admin')->orderBy('create_at', 'desc');
        if (!empty($params['search'])) $user = $user->where('username', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/" . ADMIN_SKIN . "/users/admins", ['members' => $user->paginate(cacheGlobalSettingsByKey('admin_page_count')), 'params' => $params]);
    }

    //注册会员
    function users() {
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $user = Member::where('type', '=', 'member')->orderBy('create_at', 'desc');
        if (!empty($params['search'])) $user = $user->where('username', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/" . ADMIN_SKIN . "/users/users", ['members' => $user->paginate(cacheGlobalSettingsByKey('admin_page_count')), 'params' => $params]);
    }

    //代理管理
    function agents() {
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $user = Member::where('type', '=', 'agent')->orderBy('create_at', 'desc');
        if (!empty($params['search'])) $user = $user->where('username', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/" . ADMIN_SKIN . "/users/agents", ['members' => $user->paginate(cacheGlobalSettingsByKey('admin_page_count')), 'params' => $params]);
    }


    //info信息查看
    function userinfo($uid) {

        $user = Member::find($uid);

        if (!$user) {
            return back()->with('errormsg', 'no data');
        }

        //获取用户组
        $MenuGroup = MenuGroup::orderBy('create_at', 'desc')->get();

        if ($MenuGroup) {
            $MenuGroup = $MenuGroup->toArray();
        }

        return view("admin/" . ADMIN_SKIN . "/users/userinfo", ['member' => $user->toArray(), "MenuGroup" => $MenuGroup]);
    }

    function memberAdd() {

        //获取用户组
        $MenuGroup = MenuGroup::orderBy('create_at', 'desc')->get();

        if ($MenuGroup) {
            $MenuGroup = $MenuGroup->toArray();
        }

        return view("admin/" . ADMIN_SKIN . "/users/memberAdd", ["MenuGroup" => $MenuGroup]);
    }

    //我的信息
    function myinfo() {

        $user = Member::find(session("admin_info")['uid']);

        if (!$user) {
            return back()->with('errormsg', 'no data');
        }

        //获取用户组
        $MenuGroup = MenuGroup::orderBy('create_at', 'desc')->get();

        if ($MenuGroup) {
            $MenuGroup = $MenuGroup->toArray();
        }

        return view("admin/" . ADMIN_SKIN . "/users/userinfo", ['member' => $user->toArray(), "MenuGroup" => $MenuGroup]);
    }

    //登录历史
    function history() {
        $history = LoginLog::orderBy('login_at', 'desc')
            ->where("uid", "=", session("admin_info")['uid'])
            ->paginate(__E('admin_page_count'));
        return view("admin/" . ADMIN_SKIN . "/users/history", ["history" => $history]);
    }


    //操作
    function userSubmit() {
        if ($this->request->ismethod('post')) {
            $all = $this->request->all();

            switch ($all['form']) {

                case "add":

                    //文件上传
                    if (isset($_FILES['avatar'])) {
                        $avatar = UploadFile($this->request, "avatar", "avatar/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
                        if ($avatar) {
                            $all['avatar'] = $avatar;
                        }
                    }

                    foreach ($all as $key => $value) {
                        if ($key != "form" && $key != "_token") {
                            $inster[$key] = $value;
                        }
                    }

                    if (!empty($inster)) {

                        if ($inster['password']) {
                            $inster['password'] = md5("union_" . md5($inster["password"]));
                        }

                        if (isset($all["gid"])) {
                            $inster["gid"] = implode(",", $all["gid"]);
                        }

                        $Member = new Member();

                        $res = $Member->InsterArrByAdmin($inster);

                        if (!$res) {
                            return ["stauts" => 40000, "msg" => "添加失败！"];
                        }

                        return ["stauts" => 200, "msg" => "success"];

                    }

                    break;

                case "update":

                    if ($all['uid']) {

                        //文件上传
                        if (!empty($all['avatar'])) {
                            $avatar = UploadFile($this->request, "avatar", "avatar/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
                            if ($avatar) {
                                $all['avatar'] = $avatar;
                            }
                        }

                        foreach ($all as $key => $value) {
                            if ($key != "form" && $key != "_token") {
                                $update[$key] = $value;
                            }
                        }

                        if (!empty($update)) {

                            if ($update['password']) {
                                $update['password'] = md5("union_" . md5($update["password"]));
                            } else {
                                unset($update['password']);
                            }

                            if (isset($all["gid"])) {
                                $update["gid"] = implode(",", $all["gid"]);
                            }

                            $Member = new Member();

                            $res = $Member->UpdateArr($update);

                            if (!$res) {
                                return ["stauts" => 40000, "msg" => "更新失败！"];
                            }
                            //更新登录者的session
                            if ($all['uid'] == session("admin_info")["uid"]) {

                                $this->request->session()->put("admin_info", array_merge(session("admin_info"), $update));

                            }
                            return ["stauts" => 200, "msg" => "success"];

                        }
                    }

                    break;

                default:

                    return ["stauts" => 40000, "msg" => "Method does not exist"];

            }


            return $all;
        }
    }
}
