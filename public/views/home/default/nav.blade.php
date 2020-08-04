<header class="header">
    <div class="nav-container">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
            <div class="container nav-group d-flex justify-content-between flex-md-row">

                <div class="header-user d-flex align-items-center d-lg-none">
                    @if(session("home_info"))
                        <div class="header-img ml-3 shadow-sm">
                            <a href="{{url("/member")}}">
                                <img width="40" src="{{GetUrlByPath(session("home_info")['avatar'])}}" alt="">
                            </a>
                        </div>
                    @endif
                </div>

                <a class="navbar-brand font-weight-bolder mr-lg-3 mr-0" href="{{url("/")}}">
                    <span class="tc-theme">
                        <img src="{{GetLocalFileByPath(__E('weblogo'))}}" width="150px" class="img-fluid" alt="">
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="mr-auto"></ul>
                    <ul class="navbar-nav">


                        @foreach($menus["home"] as $homeVal)
                            @if(isset($homeVal["sub"]))
                                <li class="nav-item position-relative submenu-group ">
                                    <span class="d-flex justify-content-between @if($uri==$homeVal["selected"]) active @endif">
                                        <a class="nav-link submenu-item " href="{{url($homeVal["path"])}}">{{$homeVal["name"]}}</a>
                                        <i class="d-md-none d-inline-block fa fa-angle-right"></i>
                                    </span>
                                    @foreach($homeVal["sub"] as $homeVal2)
                                        <a class="nav-link submenu-item submenu @if($uri==$homeVal2["selected"]) @endif"  href="{{url($homeVal2["path"])}}">{{$homeVal2["name"]}}</a>
                                    @endforeach
                                </li>
                            @else
                                <li class="nav-item position-relative submenu-group @if($uri==$homeVal["selected"]) active @endif ">
                                    <a class="nav-link submenu-item" href="{{url($homeVal["path"])}}">{{$homeVal["name"]}}</a>
                                </li>
                            @endif
                        @endforeach



                        {{--<li class="nav-item position-relative submenu-group @if($uri=="home") active @endif ">--}}
                            {{--<a class="nav-link submenu-item" href="{{url("/")}}">首页</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item position-relative submenu-group @if($uri=="case") active @endif">--}}
                            {{--<a class="nav-link submenu-item" href="{{url("/case")}}">经典案例</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item position-relative submenu-group @if($uri=="product") active @endif">--}}
                            {{--<a class="nav-link submenu-item" href="{{url("/product")}}">产品列表</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item position-relative submenu-group @if($uri=="news") active @endif">--}}
                            {{--<a class="nav-link submenu-item" href="{{url("/news")}}">新闻资讯</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item position-relative submenu-group @if($uri=="about") active @endif">--}}
                            {{--<a class="nav-link submenu-item" href="{{url("/about")}}">关于我们</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item position-relative submenu-group ">--}}
                            {{--<span class="d-flex justify-content-between @if($uri=="contact") active @endif">--}}
                                {{--<a class="nav-link submenu-item" href="{{url("/contact")}}">联系我们</a>--}}
                            {{--</span>--}}

                            {{--<a class="nav-link submenu-item submenu" href="{{url("/message")}}">留言</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item position-relative submenu-group ">--}}
                            {{--<span class="d-flex justify-content-between @if($uri=="faq") active @endif">--}}
                                {{--<a class="nav-link submenu-item" href="{{url("/faq")}}">常见问题</a>--}}
                            {{--</span>--}}

                        {{--</li>--}}
                        {{--<li class="nav-item position-relative submenu-group ">--}}
                            {{--<span class="d-flex justify-content-between @if($uri=="join") active @endif">--}}
                                {{--<a class="nav-link submenu-item" href="{{url("/join")}}">加入我们</a>--}}
                            {{--</span>--}}

                        {{--</li>--}}
                        <li class="nav-item position-relative submenu-group">

                            @if(!session("home_info"))
                                <div class="nav-item position-relative submenu-group d-flex justify-content-lg-center justify-content-around align-items-lg-center">
                                    <a class="nav-link submenu-btn" href="{{url("/login")}}">登录</a>
                                    <span class="d-lg-inline d-none">/</span>
                                    <a class="nav-link submenu-btn" href="{{url("/register")}}">注册</a>
                                </div>
                            @else

                                <div class="header-user d-lg-flex align-items-center" style="line-height: 37px;">

                                    <div class=" ml-lg-3">
                                    <!-- shadow-sm header-img border -->
                                        <a href="{{url("/member")}}">
                                            <!-- <img width="40" src="{{GetUrlByPath(session("home_info")['avatar'])}}" alt=""> -->
                                            个人中心
                                        </a>
                                    </div>
                                </div>

                            @endif

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>