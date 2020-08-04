<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    //首页
    Route::get("/","HomeController@index");
    //所有友情链接
    Route::get("/blogroll","HomeController@blogroll");
    //招聘管理
    Route::get("/join","HomeController@join");
    //注册
    Route::get("/register","HomeController@register");
    //登录
    Route::get("/login","HomeController@login");

    Route::get("/forget","HomeController@forget");
    //关于我们
    Route::get("/about","PagesController@about");
    //联系我们
    Route::get("/contact","PagesController@contact");
    //常见问题
    Route::get("/faq","HomeController@faq");
    //常见问题详情
    Route::get("/faq/detail","HomeController@detail");

    Route::post("/homesubmit","HomeController@submit");

    Route::any("/language/{shortcode}","HomeController@language");

    Route::any("/page/{page}","PagesController@load");

    //新闻管理
    Route::group(["prefix"=>"news"], function () {
        Route::get("/", "NewController@news");
        Route::get("/detail", "NewController@newsDetail");
    });

    //案例管理
    Route::group(["prefix"=>"case"], function () {
        Route::get("/","CaseController@example");
        Route::get("/detail","CaseController@example_detail");
    });

    //产品管理
    Route::group(["prefix"=>"product"], function () {
        Route::get("/","ProductController@product");
        Route::get("/detail","ProductController@product_detail");
    });

    //增加主题的路由
    if(file_exists(base_path() . '/public/views/home/'.env("THEME","default").'/Http/routes/home.php')){
        require_once base_path() . '/public/views/home/'.env("THEME","default").'/Http/routes/home.php';
    }

});

//会员中心
Route::group(["prefix"=>"member","middleware"=>["CheckHome"]], function () {
    Route::get("/","MemberController@index");
    //公告详情页
    Route::get("/noticeDetail/{id}","MemberController@noticeDetail");
    Route::get("/setting","MemberController@setting");
    Route::post("/saveUser","MemberController@saveUser");
    Route::get("/message","MemberController@message");
    Route::post("/addFeedback","MemberController@addFeedback");
    Route::post("/feedback/delete/{id}","MemberController@deleteFeedback");
    Route::get("/logout","MemberController@logout");

    Route::get("/setpass","MemberController@setPass");//设置登陆密码
    Route::get("/verifyemail","MemberController@verifyEmail");//绑定邮箱
    Route::get("/untyingemail","MemberController@untyingEmail");//解绑邮箱
    Route::get("/verifymobile","MemberController@verifyMobile");//绑定手机号
    Route::get("/untyingmobile","MemberController@untyingMobile");//解绑手机号
    
    Route::post("/safetySubmit","MemberController@safetySubmit");//安全认证的所有操作流程处理
});
