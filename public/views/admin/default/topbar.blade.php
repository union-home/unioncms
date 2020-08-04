<div class="top-bar light-top-bar">
    <div class="container-fluid">
        <div class="">
            <nav class="navbar navbar-expand-lg navbar-light">
                {{--                <a class="navbar-brand" href="#">Navbar</a>--}}
                <a class="admin-logo" href="{{url('admin')}}">
                    <h1>
                        <img alt="" src="{{GetUrlByPath(cacheGlobalSettingsByKey('weblogo'))}}"
                             class="logo-icon margin-r-10" style="max-width: 215px;">
                        {{--                                            <img alt="" src="{{asset('/logo.png')}}" class="toggle-none hidden-xs" style="max-width: 215px;">--}}
                    </h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <ul class="navbar-nav navbar-padding ml-auto bg-light">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="clearCache();">清空缓存</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url("/")}}" target="_blank">前台网站</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{session("admin_current_language")["icon"]}}"
                                     style="width: 20px;"> {{session("admin_current_language")["name"]}}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach($languages["admin"] as $language)
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{url("admin/change/language/".$language['shortcode'])}}">
                                            <img class="rounded-circle" src="{{UPLOADPATH.$language['icon']}}"
                                                 style="width: 20px;"/> {{$language["name"]}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{session("admin_info")['username']}}(系统管理员)
                            </a>
                            <ul class="dropdown-menu top-dropdown" id="dropdown-menu">

                                <li>
                                    <a class="dropdown-item" href="{{url('admin/myinfo')}}"><i class="icon-user"></i>
                                        个人信息</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{url('admin/history')}}"><i
                                                class="fa fa-history"></i> 登录历史</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{url('admin/base')}}"><i class="icon-settings"></i>
                                        系统设置</a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{url('admin/logout')}}"><i class="icon-logout"></i>
                                        退出</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            {{--            <div class="col">--}}
            {{--                <a class="admin-logo" href="{{url('admin')}}">--}}
            {{--                    <h1>--}}
            {{--                        <img alt="" src="{{GetUrlByPath(cacheGlobalSettingsByKey('weblogo'))}}" class="logo-icon margin-r-10" style="max-width: 215px;">--}}
            {{--                        <img alt="" src="{{asset('/logo.png')}}" class="toggle-none hidden-xs" style="max-width: 215px;">--}}
            {{--                    </h1>--}}
            {{--                </a>--}}

            {{--                <ul class="list-inline top-right-nav">--}}

            {{--                    @if($check_cms_version = cache("check_cms_version_update"))--}}
            {{--                        @if(!empty($check_cms_version['data']['version']) && $check_cms_version['data']['version'] != getenv("APP_VERSION"))--}}
            {{--                            <li class="dropdown d-none-m">--}}
            {{--                                <a class="" href="javascript:;" onclick="cmsUpdateVersion('{{$check_cms_version['data']['version']}}')">待更新版本：{{$check_cms_version['data']['version']}}</a>--}}
            {{--                            </li>--}}
            {{--                        @endif--}}
            {{--                    @endif--}}

            {{--                    <li class="dropdown d-none-m">--}}
            {{--                        <a class="" href="#" onclick="clearCache();">清空缓存</a>--}}
            {{--                    </li>--}}

            {{--                    <li class="dropdown d-none-m">--}}
            {{--                        <a class="" href="{{url("/")}}" target="_blank" >前台网站</a>--}}
            {{--                    </li>--}}

            {{--                    <li class="dropdown avtar-dropdown d-none-m">--}}
            {{--                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
            {{--                                <img src="{{session("admin_current_language")["icon"]}}" style="width: 20px;"> {{session("admin_current_language")["name"]}}--}}
            {{--                            </a>--}}
            {{--                            <ul class="dropdown-menu top-dropdown">--}}
            {{--                                @foreach($languages["admin"] as $language)--}}
            {{--                                    <li>--}}
            {{--                                        <a class="dropdown-item" href="{{url("admin/change/language/".$language['shortcode'])}}">--}}
            {{--                                            <img class="rounded-circle" src="{{UPLOADPATH.$language['icon']}}" style="width: 20px;" /> {{$language["name"]}}</a>--}}
            {{--                                    </li>--}}
            {{--                                @endforeach--}}
            {{--                            </ul>--}}
            {{--                        </li>--}}

            {{--                    <li class="dropdown avtar-dropdown">--}}

            {{--                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
            {{--                            <img alt="" class="rounded-circle" src="{{GetUrlByPath(session("admin_info")['avatar'])}}" width="30">--}}
            {{--                            {{session("admin_info")['username']}}(系统管理员)--}}
            {{--                        </a>--}}
            {{--                        <ul class="dropdown-menu top-dropdown" id="dropdown-menu">--}}
            {{--                            --}}{{--                            <li>--}}
            {{--                            --}}{{--                                <a class="dropdown-item" href="#" onclick="clearCache();">清空缓存</a>--}}
            {{--                            --}}{{--                            </li>--}}
            {{--                            --}}{{--                            <li>--}}
            {{--                            --}}{{--                                <a class="dropdown-item" href="{{url("/")}}" target="_blank" >前台网站</a>--}}
            {{--                            --}}{{--                            </li>--}}
            {{--                            --}}{{--                            <li>--}}
            {{--                            --}}{{--                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
            {{--                            --}}{{--                                    <img src="{{session("admin_current_language")["icon"]}}" style="width: 20px;"> --}}
            {{--                            --}}{{--                                    {{session("admin_current_language")["name"]}}--}}
            {{--                            --}}{{--                                </a>--}}
            {{--                            --}}{{--                                <ul class="dropdown-menu top-dropdown">--}}
            {{--                            --}}{{--                                    @foreach($languages["admin"] as $language)--}}
            {{--                            --}}{{--                                        <li>--}}
            {{--                            --}}{{--                                            <a class="dropdown-item" href="{{url("admin/change/language/".$language['shortcode'])}}">--}}
            {{--                            --}}{{--                                                <img class="rounded-circle" src="{{UPLOADPATH.$language['icon']}}" style="width: 20px;" /> {{$language["name"]}}</a>--}}
            {{--                            --}}{{--                                        </li>--}}
            {{--                            --}}{{--                                    @endforeach--}}
            {{--                            --}}{{--                                </ul>--}}
            {{--                            --}}{{--                            </li>--}}
            {{--                            <li>--}}
            {{--                                <a class="dropdown-item" href="{{url('admin/myinfo')}}"><i class="icon-user"></i> 个人信息</a>--}}
            {{--                            </li>--}}
            {{--                            <li>--}}
            {{--                                <a class="dropdown-item" href="{{url('admin/history')}}"><i class="fa fa-history"></i> 登录历史</a>--}}
            {{--                            </li>--}}
            {{--                            <li>--}}
            {{--                                <a class="dropdown-item" href="{{url('admin/base')}}"><i class="icon-settings"></i> 系统设置</a>--}}
            {{--                            </li>--}}
            {{--                            <li class="dropdown-divider"></li>--}}
            {{--                            <li>--}}
            {{--                                <a class="dropdown-item" href="{{url('admin/logout')}}"><i class="icon-logout"></i> 退出</a>--}}
            {{--                            </li>--}}
            {{--                            --}}{{--                            <li class="avtar-dropdown">--}}
            {{--                            --}}{{--                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
            {{--                            --}}{{--                                    <img alt="" class="rounded-circle" src="{{GetUrlByPath(session("admin_info")['avatar'])}}" width="30">--}}
            {{--                            --}}{{--                                    {{session("admin_info")['username']}}(系统管理员)--}}
            {{--                            --}}{{--                                </a>--}}
            {{--                            --}}{{--                            </li>--}}
            {{--                        </ul>--}}

            {{--                    </li>--}}

            {{--                </ul>--}}
            {{--            </div>--}}
        </div>
    </div>
</div>
