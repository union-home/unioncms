@include("home.".HOME_SKIN.".header")

<div class="login">
    <div class="login-container px-6">
        <div class="login-cover">
            <div class="login-group d-flex flex-column justify-content-between">
                <div class="login-header d-flex justify-content-between">
                    <div class="">
                        {{--<img src="{{GetLocalFileByPath(__E('weblogo'))}}" width="100px" class="img-fluid" alt="">--}}
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
                        <div class="login-link d-flex justify-content-center flex-wrap mt-5">
                            <a class="cms-btn login-description mr-3" href="{{url("/about")}}">关于我们</a>
                            <a class="cms-btn login-help" href="{{url("/news")}}">新闻资讯</a>
                        </div>
                    </div>
                    <form action="{{url('homesubmit?form=login')}}" method="post">
                        <div class="login-right d-flex flex-column align-items-md-center mt-lg-0 mt-5">
                            {{csrf_field()}}

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="login-form ">
                                        <p class="mr-3" style="color: red;">{{$error}}</p>
                                    </div>
                                @endforeach
                            @endif

                            <div class="login-form">
                                <span class="mr-3">用户名</span>
                                <input name="username" placeholder="请输入用户名" value="{{session("_old_input")["username"]}}" required class="mt-md-0" type="text">
                            </div>
                            <div class="login-form mt-3">
                                <span class="mr-3">密码</span>
                                <input name="password" placeholder="输入密码" value="" required class="" type="password">
                            </div>
                            <div class="login-form mt-4 d-flex justify-content-around">
                                <span class="mr-3 d-md-inline-block d-none"></span>
                                <button type="submit" class="cms-btn mr-2 login-btn">登录</button>
                                <a href="{{url("/register")}}" class="cms-btn register-btn">去注册</a>
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
</body>
</html>