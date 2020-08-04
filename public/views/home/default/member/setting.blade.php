@include("home.".HOME_SKIN.".member.header")

@include("home.".HOME_SKIN.".member.nav")

<style type="text/css">
    .fileinput-preview {
        margin-bottom: 10px;
        border: 1px solid #ccc;
        padding: 5px;
    }
    .btn-file {
        overflow: hidden;
        position: relative;
        vertical-align: middle;
    }
    .btn-file > input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        font-size: 23px;
        height: 100%;
        width: 100%;
        direction: ltr;
        cursor: pointer;
    }
    .fileinput-exists .fileinput-new, .fileinput-new .fileinput-exists {
        display: none;
    }
    img{max-width: 100%}
    .cursor-pointer{cursor: pointer;}
</style>

<main class="main px-md-5 p-md-3 p-3  bc-2nd-f7">
    <div class="product">
        <div class="row">
            <div class="col-12">
                <div class="setting-group">
                    <ul class="list-unstyled border-bottom pb-2">
                        <li class="list-inline-item active mr-3"><div class="tc-2nd">用户资料</div></li>
                        <li class="list-inline-item mx-3 mr-0"><div class="tc-2nd">帐号安全</div></li>
                    </ul>
                    <span class="more d-md-none d-block">&gt;</span>
                </div>
            </div>
        </div>
        <div class="setting">
            <ul class="list-unstyled mb-0">
                <li class="companyinfo list-inline-item w-100 d-none">
                    <div class="row">
                        <div class="col-12">
                            <div class="setting-header">
                                <span class="mr-2"></span>
                                <h6 class="d-inline">企业资料</h6>
                            </div>
                        </div>
                    </div>
                    <div class="userinfo-content mt-md-3 mt-3">
                        <div class="row px-md-5 px-2 py-2">
                            <div class="col-12 mt-md-3">
                                <div class="row">
                                    <div class="col-md-8 col-12">
                                        <div class="userinfo-group w-md-75 w-100">
                                            <span class="userinfo-text">凡科网帐号：</span>
                                            <input class="d-md-inline-block d-block mt-2 border px-2 py-1 account" type="text" value="GI18739270">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="d-md-inline-block text-nowrap modify mt-2">
                                            <span class="tc-theme">[修改]</span>（凡科网帐号只能修改1次）
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-content d-flex justify-content-between">
                                    <div class="userinfo-group">
                                        <span class="userinfo-text">注册主体：</span>
                                        <div class="d-md-inline-block mt-md-0 mt-2 text-nowrap">
                                            <label class="radion-icon active mb-0 mr-2">
                                                <input class="d-none" type="radio" name="main">
                                                <span class="align-text-bottom">企业</span>
                                            </label>
                                            <label class="radion-icon mb-0 mr-2">
                                                <input class="d-none" type="radio" name="main">
                                                <span class="align-text-bottom">企业</span>
                                            </label>
                                            <label class="radion-icon mb-0 mr-2">
                                                <input class="d-none" type="radio" name="main">
                                                <span class="align-text-bottom">企业</span>
                                            </label>
                                            <label class="radion-icon mb-0 mr-2">
                                                <input class="d-none" type="radio" name="main">
                                                <span class="align-text-bottom">企业</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text"><span class="tc-warn mr-1">*</span>企业名称：</span>
                                    <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text">所在行业：</span>
                                    <select class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1">
                                        <option>未知</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text">工商注册时间：</span>
                                    <select class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1">
                                        <option>1970-01</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text"><span class="tc-warn mr-1">*</span>注册者职位：</span>
                                    <select class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1">
                                        <option>设计师</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text">负责人：</span>
                                    <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text">联系手机：</span>
                                    <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text" value="13690293333">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text">联系邮箱：</span>
                                    <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text">固定电话：</span>
                                    <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text">联系地址：</span>
                                    <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="userinfo-group">
                                    <span class="userinfo-text">邮政编码：</span>
                                    <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                </div>
                            </div>
                            <div class="col-12 my-3 d-flex justify-content-md-start justify-content-around">
                                <input class="save-btn py-2 px-4 px-md-5 bc-theme border-0 text-white" type="button" value="保存">
                                <input class="save-btn py-2 px-4 px-md-5 ml-2 border-0 text-white" type="button" value="保存">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="userinfo list-inline-item w-100 active">
                    <div class="row">
                        <div class="col-12">
                            <div class="setting-header">
                                <span class="mr-2"></span>
                                <h6 class="d-inline">个人资料</h6>
                            </div>
                        </div>
                    </div>
                    <div class="userinfo-content mt-md-3 mt-3">
                        <form method="post" action="" id="post_form" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row px-md-5 pb-md-5 px-2 px-2">
                                <div class="col-12 mt-md-3">
                                    <div class="">
                                        <div class="userinfo-group w-100">
                                            <span class="userinfo-text">帐号：</span>
                                            <input class="bc-2nd-f7 d-md-inline-block d-block w-25 mt-2 border px-2 py-1" disabled type="text" value="{{$login_user['username']}}" />
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-12 mt-3">
                                    <div class="userinfo-group">
                                        <span class="userinfo-text">职务：</span>
                                        <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                    </div>
                                </div> -->
                                <div class="col-12 mt-3">
                                    <div class="userinfo-group">
                                        <span class="userinfo-text">昵称：</span>
                                        <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text" name="nickname" value="{{$login_user['nickname']}}">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="userinfo-group">
                                        <span class="userinfo-text">头像：</span>
                                        <div class="fileinput-new d-md-inline-block mt-md-0 mt-2 text-nowrap" data-provides="fileinput">
                                            <div class="fileinput-preview" data-trigger="fileinput" style="width: 160px; height:160px;">
                                                <img src="{{GetUrlByPath($login_user['avatar'])}}" />
                                            </div>
                                            <span class="btn btn-primary  btn-file">
                                                <span class="fileinput-new">选择</span>
                                                <span class="fileinput-exists">更换</span>
                                                <input type="file" id="cover" name="avatar">
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">删除</a>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="userinfo-content d-flex justify-content-between">
                                        <div class="userinfo-group">
                                            <span class="userinfo-text">性别：</span>
                                            <div class="d-md-inline-block mt-md-0 mt-2 text-nowrap">
                                                <label class="radion-icon active mb-0 mr-2">
                                                    <input class="d-none" type="radio" name="male" value="男" @if($login_user['male'] == '男') selected @endif>
                                                    <span class="align-text-bottom">男</span>
                                                </label>
                                                <label class="radion-icon mb-0 mr-2">
                                                    <input class="d-none" type="radio" name="male" value="女" @if($login_user['male'] == '女') selected @endif>
                                                    <span class="align-text-bottom">女</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="userinfo-group">
                                                <span class="userinfo-text">验证手机：</span>
                                                <input class="bc-2nd-f7 d-md-inline-block d-block mt-2 border px-2 py-1 account" disabled type="text" value="{{$login_user['phone']}}">
                                                <span class="d-md-inline-block text-nowrap mt-2 @if($login_user['phone_active'] == 1) tc-theme @else tc-warn @endif" @if($login_user['phone_active'] != 1) onclick="window.location.href='{{url('member/verifymobile')}}'" @endif>
                                                @if($login_user['phone_active'] == 1)
                                                        <i class="mr-1 fa fa-check-circle"></i>
                                                        已验证
                                                    @else
                                                        立即验证
                                                    @endif
                                            </span>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="userinfo-group">
                                                <span class="userinfo-text">验证邮箱：</span>
                                                <input class="bc-2nd-f7 d-md-inline-block d-block mt-2 border px-2 py-1 account" disabled type="text" value="{{$login_user['email']}}">
                                                <span class="d-md-inline-block text-nowrap mt-2 @if($login_user['email_active'] == 1) tc-theme @else tc-warn @endif" @if($login_user['email_active'] != 1) onclick="window.location.href='{{url('member/verifyemail')}}'" @endif>
                                                    @if($login_user['email_active'] == 1)
                                                        <i class="mr-1 fa fa-check-circle"></i>
                                                        已验证
                                                    @else
                                                        立即验证
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="userinfo-group">
                                        <span class="userinfo-text">生日：</span>
                                        <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="date" name="birthday" value="{{empty($login_user['birthday']) ? '' : $login_user['birthday']}}">
                                    </div>
                                </div>
                                <!-- <div class="col-12 mt-3">
                                    <div class="userinfo-group">
                                        <span class="userinfo-text">籍贯：</span>
                                        <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text" value="">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="userinfo-group">
                                        <span class="userinfo-text">家庭电话：</span>
                                        <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="userinfo-group">
                                        <span class="userinfo-text">身份证号码：</span>
                                        <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text">
                                    </div>
                                </div> -->
                                <div class="col-12 my-3 d-flex justify-content-md-start justify-content-around">
                                    <span class="userinfo-text d-md-inline-block d-none"></span>
                                    <input class="save-btn py-2 px-5 bc-theme border-0 text-white" type="button" value="保存" id="post_button">
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="safety list-inline-item w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="setting-header">
                                <span class="mr-2"></span>
                                <h6 class="d-inline">帐户安全</h6>
                            </div>
                        </div>
                    </div>
                    <div class="userinfo-content mt-md-3 mt-3 px-md-5 px-2 pb-3">
                        <!-- <div class="row py-2">
                            <div class="col-12 mt-md-3">
                                <div class="userinfo-group d-inline-block mt-2 mt-md-0 mr-md-5">
                                    <span class="tc-2nd">凡科网帐号：</span><span>gi18739270</span>
                                </div>
                                <div class="userinfo-group d-inline-block mt-2 mt-md-0">
                                    <span class="tc-2nd">员工帐号：</span><span>boss</span>
                                </div>
                            </div>
                        </div> -->
                        <div class="row pt-2 pb-4 border-bottom">
                            <div class="col-lg-3 col-md-6 col-12 mt-3">
                                <div class="safety-group isActive card">
                                    <div class="safety-group-img d-flex align-items-center justify-content-center">
                                        <img class="card-img-top" src="{{HOME_ASSET}}assets/member/img/password-icon.png" alt="">
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-title ">登录密码</h6>
                                        <p class="card-text tc-2nd">定期更换有助于帐号安全</p>
                                        <a class="d-block py-2 setting-btn" href="{{url('member/setpass')}}">设置密码</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 mt-3">
                                <div class="safety-group isActive card">
                                    <div class="safety-group-img d-flex align-items-center justify-content-center">
                                        <img class="card-img-top" src="{{HOME_ASSET}}assets/member/img/protect-icon.png" alt="">
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-title ">登录保护</h6>
                                        <p class="card-text tc-2nd">验证手机，提高安全性</p>
                                        @if($login_user['phone_active'] == 1)
                                        <a class="d-block py-2 setting-btn" href="{{url('member/verifymobile')}}">已开启</a>
                                        @else
                                        <a class="d-block py-2 setting-btn" href="{{url('member/verifymobile')}}">开启保护</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-lg-3 col-md-6 col-12 mt-3">
                                <div class="safety-group card @if($login_user['email_active'] == 1) active @endif">
                                    <div class="safety-group-img d-flex align-items-center justify-content-center">
                                        <img class="card-img-top" src="{{HOME_ASSET}}assets/member/img/email-icon.png" alt="">
                                    </div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title">绑定邮箱</h5>
                                        @if(empty($login_user['email']))
                                            <p class="card-text tc-2nd"> 用于找回密码 </p>
                                            <a class="d-block py-2 setting-btn" href="{{url('member/verifyemail')}}">绑定</a>
                                        @else
                                            <p class="card-text tc-2nd">{{($login_user['email'])}}</p>
                                            <a class="d-inline-block py-2 phone-btn" href="{{url('member/verifyemail')}}">修改</a>
                                            <a class="d-inline-block py-2 phone-btn" href="{{url('member/untyingemail')}}">解绑</a>
                                        @endif
                                    </div>
                                    <div class="angle"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 mt-3">
                                <div class="safety-group card @if($login_user['phone_active'] == 1) active @endif">
                                    <div class="safety-group-img d-flex align-items-center justify-content-center">
                                        <img class="card-img-top phone-icon" src="{{HOME_ASSET}}assets/member/img/phone-icon.png" alt="">
                                    </div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title">绑定手机</h5>
                                        @if(empty($login_user['phone']))
                                            <p class="card-text tc-2nd"> 用于找回密码 </p>
                                            <a class="d-block py-2 setting-btn" href="{{url('member/verifymobile')}}">绑定</a>
                                        @else
                                            <p class="card-text tc-2nd">{{get_encryption_mobile($login_user['phone'])}}</p>
                                            <a class="d-inline-block py-2 phone-btn" href="{{url('member/verifymobile')}}">修改</a>
                                            <a class="d-inline-block py-2 phone-btn" href="{{url('member/untyingmobile')}}">解绑</a>
                                        @endif
                                    </div>
                                    <div class="angle"></div>
                                </div>
                            </div>


                        </div>
                    </div>
                </li>
                <li class="message">

                </li>
            </ul>

        </div>
    </div>
</main>


@include("home.".HOME_SKIN.".footer")
<link rel="stylesheet" type="text/css" href="{{ADMIN_ASSET}}assets/other/DialogJS/style/dialog.css">
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/zepto.min.js"></script>
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/dialog.min.js"></script>
<script src="{{HOME_ASSET}}assets/member/js/setting.js"></script>
<script type="text/javascript">
    $("#post_button").click(function () {
        popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
            $.ajax({
                "method":"post",
                "url":"{{url('member/saveUser')}}",
                "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                "dataType":'json',
                "cache":false,
                "processData": false,
                "contentType": false,
                "success":function (res) {
                    if(res.status==200){
                        popup({type:"success",msg:res.msg,delay:2000});
                        setTimeout(function () {
                            location.href="";
                        },2000);
                    }else{
                        popup({type:"error",msg:res.msg,delay:2000});
                    }
                },
                "error":function (res) {
                    console.log(res);
                }
            })
        }});
    });
</script>