@include("home.".HOME_SKIN.".member.header")

@include("home.".HOME_SKIN.".member.nav")


<main class="main px-md-5 px-3 p-3 bc-2nd-f7">
    <div class="product">
        <div class="row">
            <div class="col-12">
                <div class="product-group my-2 px-md-3 px-2 d-flex justify-content-between align-items-center">
                    <div class="product-header d-flex justify-content-around align-items-center py-4">
                        <div class="" style="margin: 20px;">
                            <img width="40" src="{{GetUrlByPath(session("home_info")['avatar'])}}" alt="">
                        </div>
                        <div class="product-text">
                            <div class="tc-theme py-1">
                                <span>昵称：</span>
                                <span class="">{{$login_user['username']}}</span>
                            </div>
                            <div class=" py-1">
                                <span>手机号：</span>
                                <span class="">{{$login_user['phone']?:"暂无"}}</span>
                            </div>
                            <div class=" py-1">
                                <span>邮箱：</span>
                                <span class="">{{$login_user['email']?:"暂无"}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="{{url('member/setting')}}">去设置</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product">
        <div class="row">
            <div class="col-12">
                <div class="product-title">
                    <h5 class="ml-4 my-2">常用产品</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkjz-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">UNIONCMS官网</h6>
                            <span class="tc-2nd">轻松拥有专属网站</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="http://www.unioncms.cn">
                            <i class="fa fa-link mr-2"></i> 直接访问
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="product">
        <div class="row">
            <div class="col-12">
                <div class="product-title product-use">
                    <h5 class="ml-4 my-3">开通产品</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkrh-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">凡科悦客</h6>
                            <span class="tc-2nd">轻松管理会员和营销</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="#">
                            升级<i class="fa fa-step-forward ml-2"></i>
                        </a>
                        <a class="text-decoration-none tc-2nd" href="#">
                            进入管理<i class="fa fa-step-forward ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkrh-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">凡科悦客</h6>
                            <span class="tc-2nd">轻松管理会员和营销</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="#">
                            升级<i class="fa fa-step-forward ml-2"></i>
                        </a>
                        <a class="text-decoration-none tc-2nd" href="#">
                            进入管理<i class="fa fa-step-forward ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkrh-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">凡科悦客</h6>
                            <span class="tc-2nd">轻松管理会员和营销</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="#">
                            升级<i class="fa fa-step-forward ml-2"></i>
                        </a>
                        <a class="text-decoration-none tc-2nd" href="#">
                            进入管理<i class="fa fa-step-forward ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkrh-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">凡科悦客</h6>
                            <span class="tc-2nd">轻松管理会员和营销</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="#">
                            升级<i class="fa fa-step-forward ml-2"></i>
                        </a>
                        <a class="text-decoration-none tc-2nd" href="#">
                            进入管理<i class="fa fa-step-forward ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkrh-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">凡科悦客</h6>
                            <span class="tc-2nd">轻松管理会员和营销</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="#">
                            升级<i class="fa fa-step-forward ml-2"></i>
                        </a>
                        <a class="text-decoration-none tc-2nd" href="#">
                            进入管理<i class="fa fa-step-forward ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkrh-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">凡科悦客</h6>
                            <span class="tc-2nd">轻松管理会员和营销</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="#">
                            升级<i class="fa fa-step-forward ml-2"></i>
                        </a>
                        <a class="text-decoration-none tc-2nd" href="#">
                            进入管理<i class="fa fa-step-forward ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkrh-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">凡科悦客</h6>
                            <span class="tc-2nd">轻松管理会员和营销</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="#">
                            升级<i class="fa fa-step-forward ml-2"></i>
                        </a>
                        <a class="text-decoration-none tc-2nd" href="#">
                            进入管理<i class="fa fa-step-forward ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header border-bottom d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/fkrh-logo.png" alt="">
                        </div>
                        <div class="product-text">
                            <h6 class="">凡科悦客</h6>
                            <span class="tc-2nd">轻松管理会员和营销</span>
                        </div>
                    </div>
                    <div class="product-body d-flex justify-content-around py-3">
                        <a class="text-decoration-none tc-2nd" href="#">
                            升级<i class="fa fa-step-forward ml-2"></i>
                        </a>
                        <a class="text-decoration-none tc-2nd" href="#">
                            进入管理<i class="fa fa-step-forward ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product">
        <div class="row">
            <div class="col-12">
                <div class="product-title product-sales tc-gray-99">
                    <h5 class="ml-4 my-3">营销精选</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/zf-img.png" alt="">
                        </div>
                        <div class="product-text ml-2">
                            <h6 class="">涨粉版本 买二送二</h6>
                            <span class="tc-2nd">[凡科互动]</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/zf-img.png" alt="">
                        </div>
                        <div class="product-text ml-2">
                            <h6 class="">涨粉版本 买二送二</h6>
                            <span class="tc-2nd">[凡科互动]</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/zf-img.png" alt="">
                        </div>
                        <div class="product-text ml-2">
                            <h6 class="">涨粉版本 买二送二</h6>
                            <span class="tc-2nd">[凡科互动]</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="product-group my-2 px-md-3 px-2">
                    <div class="product-header d-flex justify-content-around align-items-center py-4">
                        <div class="">
                            <img src="{{HOME_ASSET}}assets/member/img/zf-img.png" alt="">
                        </div>
                        <div class="product-text ml-2">
                            <h6 class="">涨粉版本 买二送二</h6>
                            <span class="tc-2nd">[凡科互动]</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <div class="product">
        <div class="row">
            <div class="col-12">
                <div class="product-title product-notice">
                    <h5 class="ml-4 my-3">平台公告</h5>
                </div>
            </div>
        </div>
        <div class="product-group">
            <div class="row my-2 px-md-3 px-2 py-md-4 py-3">
                <div class="col-lg-4 col-md-6 col-12">
                    @foreach($notice[0] as$list)
                        <div class="mb-0 text-truncate tc-2nd">
                            <a class="notice-link tc-2nd text-truncate d-block"
                               href="{{url('member/noticeDetail/'.$list['id'])}}">
                                [{{$list['cat_name']}}] {{$list['title']}}
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    @foreach($notice[1] as$list)
                        <div class="mb-0 text-truncate tc-2nd">
                            <a class="notice-link tc-2nd text-truncate d-block"
                               href="{{url('member/noticeDetail/'.$list['id'])}}">
                                [{{$list['cat_name']}}] {{$list['title']}}
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    @foreach($notice[2] as$list)
                        <div class="mb-0 text-truncate tc-2nd">
                            <a class="notice-link tc-2nd text-truncate d-block"
                               href="{{url('member/noticeDetail/'.$list['id'])}}">
                                [{{$list['cat_name']}}] {{$list['title']}}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>

@include("home.".HOME_SKIN.".footer")