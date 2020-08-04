<header class="header">
    <div class="nav-container">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
            <div class="container-fluid nav-group d-flex justify-content-between flex-md-row">

                <div class="header-user d-flex align-items-center">
                    <a class="header-btn bc-theme text-decoration-none px-3 text-white d-md-inline-block d-none" href="{{url("/member")}}">
                        个人中心
                    </a>
                    <div class="header-img shadow-sm ml-3">
                        <a href="{{url("/member")}}">
                            <img width="40" src="{{GetUrlByPath(session("home_info")['avatar'])}}" alt="">
                        </a>
                    </div>
                </div>

                <a class="navbar-brand font-weight-bolder mr-md-3 mr-0" href="{{url("/")}}">
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
                        <li class="nav-item position-relative submenu-group @if($uri=="home") active @endif ">
                            <a class="nav-link submenu-item" href="{{url("/")}}">首页</a>
                        </li>
                        {{--<li class="nav-item position-relative submenu-group  ">--}}
                        {{--<span class="d-flex justify-content-between @if($uri=="case") active @endif">--}}
                        {{--<a class="nav-link submenu-item " href="{{url("/case")}}">经典案例</a>--}}
                        {{--<i class="d-md-none d-inline-block fa fa-angle-right"></i>--}}
                        {{--</span>--}}
                        {{--<a class="nav-link submenu-item submenu @if($uri=="product") active @endif" href="{{url("/product")}}">产品列表</a>--}}
                        {{--</li>--}}
                        <li class="nav-item position-relative submenu-group @if($uri=="case") active @endif">
                            <a class="nav-link submenu-item" href="{{url("/case")}}">经典案例</a>
                        </li>
                        <li class="nav-item position-relative submenu-group @if($uri=="product") active @endif">
                            <a class="nav-link submenu-item" href="{{url("/product")}}">产品列表</a>
                        </li>
                        <li class="nav-item position-relative submenu-group @if($uri=="news") active @endif">
                            <a class="nav-link submenu-item" href="{{url("/news")}}">新闻资讯</a>
                        </li>
                        <li class="nav-item position-relative submenu-group @if($uri=="about") active @endif">
                            <a class="nav-link submenu-item" href="{{url("/about")}}">关于我们</a>
                        </li>
                        <li class="nav-item position-relative submenu-group ">
                            <span class="d-flex justify-content-between @if($uri=="contact") active @endif">
                                <a class="nav-link submenu-item" href="{{url("/contact")}}">联系我们</a>
                                <i class="d-md-none d-inline-block fa fa-angle-right"></i>
                            </span>

                            {{--<a class="nav-link submenu-item submenu" href="{{url("/message")}}">留言</a>--}}
                        </li>

                    </ul>
                </div>

            </div>
        </nav>
    </div>
</header>

<nav class="sidenav">
    <div class="position-fixed h-100 bc-theme">
        <ul class="list-unstyled">
            <li class="sidenav-item @if($uri=="index") active @endif ">
                <a class="sidenav-menu d-flex justify-content-between d-block text-md-left text-center" href="{{url("/member")}}">
                    <span class="sidenav-title manage-title">管理</span>
                    <i class="fa fa-angle-right @if($uri=="index") d-md-inline-block d-none @endif "></i>
                </a>
            </li>
            <li class="sidenav-item @if($uri=="member/setting") active @endif ">
                <a class="sidenav-menu d-flex justify-content-between d-block" href="{{url("member/setting")}}">
                    <span class="sidenav-title setting-title">设置</span>
                    <i class="fa fa-angle-right @if($uri=="member/setting") d-md-inline-block d-none @endif"></i>
                </a>
            </li>
            <li class="sidenav-item @if($uri=="member/message") active @endif">
                <a class="sidenav-menu d-flex justify-content-between d-block" href="{{url("member/message")}}">
                    <span class="sidenav-title message-title d-md-inline-block d-none">留言版</span>
                    <span class="sidenav-title message-title d-md-none d-inline-block">留言</span>
                    <i class="fa fa-angle-right @if($uri=="member/message") d-md-inline-block d-none @endif"></i>
                </a>
            </li>
            <li class="sidenav-item">
                <a class="sidenav-menu d-flex justify-content-between d-block" href="{{url("member/logout")}}">
                    <span class="sidenav-title quit-title">退出</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>