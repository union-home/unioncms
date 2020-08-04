@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")

<style type="text/css">
    .case-text~div {
        display: none;
    }
    .case-text~div.active {
        display: block;
    }
</style>


<main class="case-main template">
    <div class="banner"></div>

    <div class="service py-md-5">
        <div class="container">
            <div class="row py-md-5 py-4">
                <div class="text-center col-12">
                    <div class="choose-header mb-md-5 mb-0">
                        <h4>详情信息</h4>
                        <p class="tc-gray-99 mb-0">THE DETAILS INFORMATION</p>
                    </div>
                </div>
            </div>
            <div class="detailed-content">
                <div class="row clearfix">
                    <div class="col-md-6 col-12 d-flex align-items-center pull-left">
                        <div class="detailed-item">
                            <div class="detailed-img position-relative">
                                {{--<img class="w-100" src="{{HOME_ASSET}}assets/img/product-img.png" alt="">--}}

                                <img class="w-100" src="{{HOME_ASSET}}assets/img/product-img.png" alt="">
                                <div class="position-absolute" style="top:0;bottom:18%;margin:.6rem;right:0;left:0;">
                                    <img class="w-100 h-100" src="{{GetUrlByPath($data->cover)}}" alt="">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mt-5 mt-md-0 pull-left">
                        <div class="detailed-item">
                            <div class="">
                                <h5>{{$data->title}}</h5>
                                <span class="tc-gray-99">
                                    <i class="fa fa-tag mr-1"></i>{{$data->category_name}}
                                </span>
                            </div>
                            <div class="lh-30">
                                {!! $data->introduct !!}
                            </div>
                            <!-- <div class="price-warper mt-3 mb-3">
                                <div class="tc-2nd">
                                    <span class="price tc-warn">￥999元</span>（一次购买，永久使用，提供模板源码）
                                </div>
                            </div>
                            <div class="buy-warper mt-3">
                                <div class="d-flex justify-content-around justify-content-md-start">
                                    <button class="btn bc-warn text-white rounded-0">在线购买</button>
                                    <button class="btn bc-theme text-white rounded-0 ml-0 ml-md-5">在线购买</button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="container">
            <div class="row py-md-5 py-4">
                {{--<div class="col-12 col-lg-3 order-lg-0 order-12">--}}
                {{--<div class="case-group text-center">--}}
                {{--<div class="case-title bc-gray-f2 py-2 px-3">--}}
                {{--其它应用--}}
                {{--</div>--}}
                {{--<div class="d-flex d-lg-block justify-content-around px-0 px-md-2">--}}
                {{--<div class="case-item my-2">--}}
                {{--<img class="w-100" src="{{HOME_ASSET}}assets/img/case-info-img.png" alt="">--}}
                {{--<p class="mb-0 py-2">多彩手机爱拍拍</p>--}}
                {{--</div>--}}
                {{--<div class="case-item my-2 ml-lg-0 ml-2">--}}
                {{--<img class="w-100" src="{{HOME_ASSET}}assets/img/case-info-img.png" alt="">--}}
                {{--<p class="mb-0 py-2">多彩手机爱拍拍</p>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="col-12 col-lg-12 order-lg-0 order-1">
                    <div class="case-group h-100">
                        <div class="case-list">
                            <ul class="case-title list-unstyled d-lg-none">
                                <li class="case-item">
                                    <div class="case-text d-flex justify-content-between align-items-center py-lg-0 py-3">
                                        <span>产品描述</span>
                                        <i class="expand fa fa-angle-right d-lg-none"></i>
                                    </div>
                                    <div class="py-3 px-md-2 border-top tc-gray-99">
                                        {!! $data->content !!}
                                    </div>
                                </li>
                                <!-- <li class="case-item">
                                    <div class="case-text d-flex justify-content-between align-items-center py-lg-0 py-3">
                                        <span>更新日志</span>
                                        <i class="expand fa fa-angle-right"></i>
                                    </div>
                                    <span class="py-3 border-top tc-gray-99">
                                        更新日志内容
                                    </span>
                                </li>
                                <li class="case-item">
                                    <div class="case-text d-flex justify-content-between align-items-center py-lg-0 py-3">
                                        <span>资料下载（1）</span>
                                        <i class="expand fa fa-angle-right"></i>
                                    </div>
                                    <span class="py-3 border-top tc-gray-99">
                                        资料下载内容
                                    </span>
                                </li>
                                <li class="case-item">
                                    <div class="case-text d-flex justify-content-between align-items-center py-lg-0 py-3">
                                        <span>用户评论</span>
                                        <i class="expand fa fa-angle-right"></i>
                                    </div>
                                    <span class="py-3 border-top tc-gray-99">
                                        用户评论内容
                                    </span>
                                </li> -->
                            </ul>

                            <ul class="case-title list-unstyled d-lg-block d-none">
                                <li class="case-item active py-lg-2 px-lg-3">
                                    <div class="case-text">
                                        <span>产品描述</span>
                                    </div>
                                </li>
                                <!-- <li class="case-item py-lg-2 px-lg-3">
                                    <div class="case-text">
                                        <span>更新日志</span>
                                    </div>
                                </li>
                                <li class="case-item py-lg-2 px-lg-3">
                                    <div class="case-text">
                                        <span>资料下载（1）</span>
                                    </div>
                                </li>
                                <li class="case-item py-lg-2 px-lg-3">
                                    <div class="case-text">
                                        <span>用户评论</span>
                                    </div>
                                </li> -->
                            </ul>
                        </div>
                        <div class="my-2">
                            <ul class="case-info list-unstyled">
                                <li class="introduce active list-inline-item">
                                    <div class="px-md-2 tc-gray-99">
                                        {!! $data->content !!}
                                    </div>
                                </li>
                                <!-- <li class="update list-inline-item">
                                    <div class="px-md-2 tc-gray-99">
                                        更新日志
                                    </div>
                                </li>
                                <li class="download-temporary list-inline-item">
                                    <div class="px-md-2 tc-gray-99">
                                        资料下载
                                    </div>
                                </li>
                                <li class="comment list-inline-item">
                                    <div class="px-md-2 tc-gray-99">
                                        用户评论
                                    </div>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="service news mb-5 pb-md-5">
        <div class="container">
            <div class="row py-md-5 py-4">
                <div class="text-center col-12">
                    <div class="choose-header mb-md-5 mb-0">
                        <h4>推荐产品</h4>
                        <p class="tc-gray-99 mb-0">Recommended Products</p>
                    </div>
                </div>
            </div>
            <div class="row">

                @if($rec_data)
                    @foreach($rec_data as $rec)
                        <div class="col-md-4 col-12">
                            <a class="d-block" href="{{url("/product/detail?id=$rec->id")}}">
                                <div class="service-link position-relative">
                                    <div class="pDetailed-img">
                                        <img class="w-100" src="{{GetUrlByPath($rec->cover)}}" alt="">
                                    </div>
                                    <div class="view-text text-white d-flex justify-content-center align-items-center">
                                        查看详情
                                    </div>
                                </div>
                                <div class="pDetailed-header py-3 text-center">
                                    <h5 class="pDetailed-title tc-black">
                                        {{$rec->title}}
                                    </h5>
                                    <p class="tc-gray-99">{{$rec->introduct}}</p>
                                </div>
                            </a>
                        </div>
                @endforeach
            @endif
            <!-- <div class="col-md-4 col-12">
                    <a href="pDetailed.html">
                        <div class="service-link position-relative">
                            <div class="pDetailed-img">
                                <img class="w-100" src="{{HOME_ASSET}}assets/img/template3-img.png" alt="">
                            </div>
                            <div class="view-text text-white d-flex justify-content-center align-items-center">
                                查看详情
                            </div>
                        </div>
                        <div class="pDetailed-header py-3 text-center">
                            <h5 class="pDetailed-title tc-black">
                                极简风企业官网
                            </h5>
                            <p class="tc-gray-99">企业集团类网站、极简风、品牌型官网</p>
                        </div>
                    </a>
                </div> -->
            </div>
        </div>
    </div>

</main>




@include("home.".HOME_SKIN.".footer")

