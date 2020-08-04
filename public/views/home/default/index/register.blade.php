@include("home.".HOME_SKIN.".header")

<div class="login">
    <div class="login-container">
        <div class="login-cover">
            <div class="login-group d-flex flex-column justify-content-between">
                <div class="login-header d-flex justify-content-between">
                    <div class="">
                        <span></span>
                    </div>
                    <div class="">
                        <a class="cms-btn login-description" href="{{url("/")}}">
                            <span>返回首页</span>
                        </a>
                    </div>
                </div>
                <div class="login-main d-flex flex-md-row flex-column flex-wrap align-items-center justify-content-around">
                    <div class="login-left">
                        <div class="login-title font-weight-bold text-md-left text-center">{{__E('website_name')}}</div>
                        <div class="login-link d-flex justify-content-center flex-wrap mt-3 mt-lg-5">
                            <a class="cms-btn login-description mr-3" href="{{url("/about")}}">关于我们</a>
                            <a class="cms-btn login-help" href="{{url("/news")}}">新闻资讯</a>
                        </div>
                    </div>
                    <form action="{{url('homesubmit?form=register')}}" method="post" id="post_form">
                        <div class="login-right d-flex flex-column align-items-md-center mt-lg-0 mt-3">

                            {{csrf_field()}}

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="login-form ">
                                        <p class="mr-3" style="color: red;">{{$error}}</p>
                                    </div>
                                @endforeach
                            @endif

                            <div class="login-form mt-3">
                                <span class="mr-3">用户名</span>
                                <input name="username" placeholder="请输入用户名" value="{{session("_old_input")["username"]}}" required class="mt-md-0" type="text">
                            </div>

                            <div class="login-form mt-3">
                                <span class="mr-3">邮箱地址</span>
                                <input name="email" placeholder="邮箱地址" value="{{session("_old_input")["email"]}}" required class="mt-md-0" type="email">
                            </div>
                            <div class="login-form mt-3">
                                <span class="mr-3">手机号</span>
                                <input name="phone" placeholder="手机号" value="{{session("_old_input")["phone"]}}" required class="mt-md-0" type="tel">
                            </div>
                            <div class="login-form mt-3">
                                <span class="mr-3">验证码</span>
                                <div class="position-relative d-inline-block">
                                    <input class="mt-md-0" placeholder="验证码" type="text" name="code">
                                    <span class="verify-text rounded py-1 px-2" onclick="getSmsCode()">发送验证码</span>
                                </div>
                            </div>
                            <div class="login-form mt-3">
                                <span class="mr-3">密码</span>
                                <input name="password" placeholder="输入密码" value="" required class="" type="password">
                            </div>
                            <div class="login-form mt-3">
                                <span class="mr-3">确认密码</span>
                                <input name="password2" value="" placeholder="确认密码" required class="" type="password">
                            </div>
                            <div class="login-form mt-4 d-flex justify-content-around">
                                <span class="mr-3 d-md-inline-block d-none"></span>
                                <button type="submit" class="cms-btn mr-2 login-btn">注册</button>
                                <a href="{{url("/login")}}" class="cms-btn register-btn">去登录</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="login-footer text-center tc-black">
                    <div>
                        <span class="tc-gray-99">版权所有@ 2019 0306 www.unioncms.cn ICP备0505050505号</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/layer-v3.1.1/layer.js')}}"></script>
<script type="text/javascript">
    function getSmsCode() {
        console.log($('form input[name=phone]'));
        if (!$('form input[name=phone]').val()) {
            layer.msg('请输入手机号');
            return;
        }
        layer.msg('加载中', { icon: 16, shade: 0.01 });
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            "method":"post",
            "url": "{{url('/homesubmit?form=regCode')}}",
            "data": new FormData($('#post_form')[0]),
            "dataType":'json',
            "cache":false,
            "processData": false,
            "contentType": false,
            "success":function (res) {
                if(res.status==200){
                    getVerificationCode($('span.qr-code-text'));
                    layer.msg(res.msg, { icon: 1});
                }else{
                    layer.msg(res.msg, { icon: 5});
                }
            },
            "error":function (res) {
                console.log(res);
            }
        });
    };

    function getVerificationCode(_this) {
        var text = $(_this).text();
        $(_this).off("click");
        $(_this).css("opacity", 0.5);
        var that = $(_this);
        var time = 60;
        // 定时
        var intTime = setInterval(function () {
            time--;
            that.text("重新获取(" + time + ")");

            if (time <= 0) {
                that.css("opacity", 1).text(text);

                clearInterval(intTime);
                // 递归
                getVerificationCode();
            }
        }, 1000);
    }
</script>
</body>
</html>