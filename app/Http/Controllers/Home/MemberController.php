<?php

namespace App\Http\Controllers\Home;

use App\Models\Feedback;
use App\Models\Member;
use App\Models\Notice;
use App\Services\MemberService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller {
    private $login_unique;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);

        $this->login_unique = Member::LOGIN_UNIQUE;
    }

    //会员首页
    function index() {

        $loadcss = "index";
        $uri = "index";
        $list = Notice::leftJoin('notice_category as cat', 'cat.id', '=', 'notice.qcid')
            ->limit(18)
            ->get([
                'notice.id',
                'notice.title',
                'cat.name as cat_name',
            ])
            ->toArray();
        $notice_num = 6;
        $notice = [0 => [], 1 => [], 2 => [],];
        foreach ($list as $k => $n) {
            if (count($notice[0]) < $notice_num) {
                $notice[0][] = $n;
            } elseif (count($notice[1]) < $notice_num) {
                $notice[1][] = $n;
            } elseif (count($notice[2]) < $notice_num) {
                $notice[2][] = $n;
            }
        }
        return view('home.' . HOME_SKIN . '.member.index', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            'login_user' => session($this->login_unique),
            'notice' => $notice,
        ]);
    }

    public function noticeDetail($id = 0) {
        $loadcss = "index";
        $uri = "index";
        $notice_list = Notice::limit(5)
            ->orderByDesc('id')
            ->get([
                'notice.id',
                'notice.title',
            ])
            ->toArray();
        $detail = Notice::where('notice.id', $id)
            ->leftJoin('notice_category as cat', 'cat.id', '=', 'notice.qcid')
            ->leftJoin('members', 'members.uid', '=', 'notice.add_uid')
            ->select([
                'notice.*',
                'members.username',
                'cat.name as cat_name',
            ])->first();
        $detail = $detail ? $detail->toArray() : [];
        if (!$detail) return back();
        return view('home.' . HOME_SKIN . '.member.noticeDetail', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            'login_user' => session($this->login_unique),
            'detail' => $detail,
            'notice_list' => $notice_list,
        ]);
    }

    //会员设置
    function setting() {
        $login_user = session($this->login_unique);
        $loadcss = "setting";
        $uri = "member/setting";
        return view('home.' . HOME_SKIN . '.member.setting', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            'login_user' => $login_user,
        ]);
    }

    //编辑会员信息的操作流程
    function saveUser() {
        $params = $this->request->all();
        $login_user = session($this->login_unique);
        if ($this->request->ismethod('post')) return (new Member())->saveUserInfo($this->request, $login_user['uid'], $this->login_unique);
    }

    //留言板
    function message() {
        $login_user = session($this->login_unique);
        $loadcss = "setting";
        $uri = "member/message";

        $datas = Feedback::where(['uid' => $login_user['uid']])->orderBy("id", "desc")->paginate(20);

        return view('home.' . HOME_SKIN . '.member.message', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            "datas" => $datas
        ]);
    }

    //新增留言操作
    public function addFeedback() {
        $login_user = session($this->login_unique);
        if ($this->request->ismethod('post')) {
            $params = $this->request->all();
            $params['uid'] = $login_user['uid'];
            $feedback = new Feedback();
            return $feedback->InsertArr($params);
        } else return return_api_format(['status' => 40000, 'msg' => 'method error,must post method']);
    }

    public function deleteFeedback($id) {
        $login_user = session($this->login_unique);
        if ($this->request->ismethod('post')) {
            $params['id'] = $id;
            $params['uid'] = $login_user['uid'];
            return Feedback::deleteByUser($params);
        } else return return_api_format(['status' => 40000, 'msg' => 'method error,must post method']);
    }

    //退出
    function logout() {
        //清除sessin
        session()->forget($this->login_unique);
        return redirect(url("/login"));
    }

    //会员登陆密码更改
    function setPass() {
        $login_user = session($this->login_unique);
        $loadcss = "setting";
        $uri = "member/setpass";
        return view('home.' . HOME_SKIN . '.member.setpass', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            'login_user' => $login_user,
        ]);
    }

    //绑定邮箱页面
    function verifyEmail() {
        $login_user = session($this->login_unique);
        $loadcss = "setting";
        $uri = "member/verifyemail";
        return view('home.' . HOME_SKIN . '.member.verifyemail', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            'login_user' => $login_user,
        ]);
    }

    function untyingEmail() {
        $login_user = session($this->login_unique);
        $loadcss = "setting";
        $uri = "member/untyingemail";
        return view('home.' . HOME_SKIN . '.member.untyingemail', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            'login_user' => $login_user,
        ]);
    }

    //绑定手机号页面
    function verifyMobile() {
        $login_user = session($this->login_unique);
        $loadcss = "setting";
        $uri = "member/verifymobile";
        return view('home.' . HOME_SKIN . '.member.verifymobile', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            'login_user' => $login_user,
        ]);
    }

    function untyingMobile() {
        $login_user = session($this->login_unique);
        $loadcss = "setting";
        $uri = "member/untyingmobile";
        return view('home.' . HOME_SKIN . '.member.untyingmobile', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            'login_user' => $login_user,
        ]);
    }

    //安全认证
    public function safetySubmit() {
        $login_user = session($this->login_unique);
        if ($this->request->ismethod('post')) {
            $params = $this->request->all();
            switch ($params['form']) {
                case "setpass": //登陆密码
                    $params['uid'] = $login_user['uid'];
                    $return = Member::setUserPass($params);
                    break;
                case "send_bind_email": //发送绑定邮件的验证码
                    $params['uid'] = $login_user['uid'];
                    $return = MemberService::sendEmailBindCode($params);
                    break;
                case "bind_email": //绑定邮箱
                    $params['uid'] = $login_user['uid'];
                    $return = MemberService::checkEmailBindCode($params, $this->login_unique);
                    break;
                case "send_untying_email": //发送解绑邮件的验证码
                    $params['uid'] = $login_user['uid'];
                    $return = MemberService::sendEmailUntyingCode($params);
                    break;
                case "untying_email": //解绑邮箱
                    $params['uid'] = $login_user['uid'];
                    $return = MemberService::checkEmailUntyingCode($params, $this->login_unique);
                    break;

                case "send_bind_phone": //发送绑定手机号的验证码
                    $params['uid'] = $login_user['uid'];
                    $return = MemberService::sendSmsBindCode($params, $login_user);
                    break;
                case "bind_phone": //绑定手机号
                    $params['uid'] = $login_user['uid'];
                    $return = MemberService::checkSmsBindCode($params, $this->login_unique);
                    break;
                case "send_untying_phone": //发送解绑手机号的验证码
                    $params['uid'] = $login_user['uid'];
                    $return = MemberService::sendSmsUntyingCode($params, $login_user);
                    break;
                case "untying_phone": //解绑手机号
                    $params['uid'] = $login_user['uid'];
                    $return = MemberService::checkSmsUntyingCode($params, $this->login_unique);
                    break;
                default :
                    return return_api_format(['status' => 40000, 'msg' => 'Method does not exist']);
            }
            return $return;
        } else return return_api_format(['status' => 40000, 'msg' => 'method error,must post method']);

    }
}
