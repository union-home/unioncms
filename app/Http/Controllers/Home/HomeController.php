<?php

namespace App\Http\Controllers\Home;

use App\Events\GetModuleSetIndex;
use App\Events\Login;
use App\Models\Blogroll;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Join;
use App\Models\Language;
use App\Models\Member;
use App\Models\MembersVerifyLogs;
use App\Services\MemberService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\CommonController;

class HomeController extends Controller
{
    private $login_unique;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->login_unique = Member::LOGIN_UNIQUE;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()     //网站首页
    {
        $view = (new GetModuleSetIndex($this->request))->view;

        if ($view) {
            return $view;
        }else{
            $loadcss = "index";
            $uri = "home";
           //news_list
            return view('home.'.HOME_SKIN.'.index.index',[
                "loadcss" => $loadcss,
                "uri" => $uri,
                "news_list" => NewController::indexNews(),
                "roll_list1" => Blogroll::getData(1,18),//无图标
                "roll_list2" => Blogroll::getData(2,6)//有图标
            ]);
        }
    }
    public function Blogroll() {

            $loadcss = "index";
            $uri = "home";
            return view('home.'.HOME_SKIN.'.index.blogroll',[
                "loadcss" => $loadcss,
                "uri" => $uri,
                "roll_list1" => Blogroll::getData(1,0),//无图标
                "roll_list2" => Blogroll::getData(2,0)//有图标
            ]);
    }

    //加入我们
    function join(){

        $loadcss = "join";
        $uri = "join";

        $list = Join::where("status","=",1)->get();

        return view('home.'.HOME_SKIN.'.index.join',[
            "loadcss"=>$loadcss,
            "uri"=>$uri,
            "list"=>$list
        ]);
    }

    //切换语言
    function language($shortcode){

        CommonController::change($shortcode,"home");

        return back();

    }

    //faq
    /*public function faq($id=null)
    {
        $category = FaqCategory::all();
        if($category){

            $category = $category->toArray();
            if($id){
                $faq = Faq::where("qcid","=",$id)->get();
            }else{
                $faq = Faq::where("qcid","=",$category[0]["id"])->get();
                $id = $category[0]["id"];
            }


        }else{
            $category = [];
            $faq = [];
        }
        return view('home.'.HOME_SKIN.'.index.faq',["category"=>$category,"faq"=>$faq,"id"=>$id]);
    }*/
    //常见问题
    function faq(Request $request) {

        $loadcss = "faq";
        $uri = "faq";

        //获取问题分类
        $cate = new FaqCategory();
        $cate_list = $cate->get()->toArray();
        $problem = new Faq();
        $problem_list = $problem->where(function ($q) use ($request) {
            if ($request->cate > 0) {
                $q->where('qcid', $request->cate);
            }
            if ($request->search != '') {
                $q->where('title','LIKE', '%' . $request->search . '%');
            }
        })->paginate(6);
        return view('home.' . HOME_SKIN . '.faq.problem', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            "cate_list" => $cate_list,
            "problem_list" => $problem_list
        ]);
    }
    //常见问题
    function detail(Request $request) {
        $id = intval($request->id);
        if(!$id) return back();
        $loadcss = "faq";
        $uri = "faq";

        //获取问题分类
        $cate = new FaqCategory();
        $cate_list = $cate->get()->toArray();
        $problem = new Faq();
        $data = $problem->where('id',$id)->first();
        if(!$data) return back();
        $data = $data->toArray();
        return view('home.' . HOME_SKIN . '.faq.content', [
            "loadcss" => $loadcss,
            "uri" => $uri,
            "cate_list" => $cate_list,
            "data" => $data
        ]);
    }


    //注册
    function register(){

        $loadcss = "login";

        return view('home.'.HOME_SKIN.'.index.register',[
            "loadcss"=>$loadcss
        ]);
    }

    //注册处理
    private function registerDo($post){

        //判断是否开启注册功能
        if(__E("website_open_reg")!=1){
            return array("error"=>"系统关闭注册功能！");
        }

        if(empty($verify_code = MembersVerifyLogs::getLastVerifyCode(0, 1, 1, 1, $post['phone'])))  return [ 'error' => '验证码已失效，请重新发送！' ];
        if($verify_code->verify_receive != $post['phone']) return ['error' => '该手机号与验证码不匹配！' ];
        if(empty($post['code'])) return ['error' => '请重新发送验证码！' ];
        if($verify_code->verify_code != $post['code']) return ['error' => '该验证码不匹配！' ];
        MembersVerifyLogs::where('id', $verify_code->id)->update([ 'is_active' => 1]);
        //注册前钩子

        //注册处理
        $Member = new Member();
        $res = $Member->InsterArr($post);

        if(isset($res["error"]) && $res["error"]){
            return $res;
        }
        //注册后钩子
    }

    //登录
    function login(){

        $loadcss = "login";

        return view('home.'.HOME_SKIN.'.index.login',[
            "loadcss"=>$loadcss
        ]);
    }

    function forget(){
        $loadcss = "login";
        return view('home.'.HOME_SKIN.'.index.forget',[
            "loadcss"=>$loadcss
        ]);
    }

    //登录处理
    function loginDo($post){

        $Member = new Member();
        $data = $Member->GetdataByFiled($post,"member");
        if(!$data){
            return array("error"=>"用户名或者密码有误！");
        }
        if (intval($data['status']) != 1) return array("error"=>"该账户已被禁用！");

        //记录登录信息
        $array = array(
            $this->login_unique => $data
        );

        session()->put($array);
        //触发记录事件
        event(new Login($this->request, $this->login_unique));

        //登录后钩子
    }



    //处理
    function submit(){

        $post = $this->request->all();

        switch ($post["form"]){
            case "register":
                $res = $this->registerDo($post);
                break;
            case "regCode":
                return MemberService::getRegisterCode($post);
                break;
            case "reg":
                $res = MemberService::register($post);
                break;
            case "forgetCode":
                return MemberService::getForgetCode($post);
                break;
            case "forget":
                $res = MemberService::forget($post);
                break;
            case "login":
                $res = $this->loginDo($post);
                break;
            default :
                return back()->withErrors("Method does not exist");
                break;
        }
        //错误返回
        if(isset($res["error"]) && $res["error"]){
            return back()->withErrors($res["error"])->withInput();
        }

        //成功跳转
        if(session("previous")){
            return redirect(session("previous"));
        }
        return redirect(url("/member"));
//        return redirect("/");

    }




}
