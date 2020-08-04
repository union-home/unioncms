@include("home.".HOME_SKIN.".member.header")

<link rel="stylesheet" href="{{HOME_ASSET}}assets/plugins/awesome/css/font-awesome.min.css">

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="{{HOME_ASSET}}assets/css/common.css">
<link rel="stylesheet" href="{{HOME_ASSET}}assets/css/index.css">

@include("home.".HOME_SKIN.".member.nav")

<main class="main px-md-5 px-3 p-3 bc-2nd-f7 flex-grow-1">
    <div class="product">
        <div class="row">
            <div class="col-lg-9 col-md-7 col-12">
                <div class="bc-white p-4">
                    <h6>{{$detail['title']}}</h6>
                    <div class="mb-3">
                        <span>【 {{$detail['cat_name']}} 】</span>
                    </div>
                    <div class="lh-30 mb-5 tc-gray-99">
                        {!! $detail['content'] !!}
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                        <div class="text-center mt-5 tc-gray-99">
                            <span>{{$detail['username']}}</span><br/>
                            <span>{{$detail['create_at']}}</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-3 col-md-5 col-12 d-md-block d-none">
                <div class="bc-white p-3 h-100">
                    <div class="text-center">
                        <span>最新公告</span>
                    </div>
                    <div class="text-nowrap">
                        <ul class="mb-0 lh-40 details-list list-unstyled">
                            @foreach($notice_list as $nl)
                                <li class="w-100 text-nowrap" style="cursor: pointer"
                                onclick="window.location='{{url('/member/noticeDetail/'.$nl['id'])}}'">
                                    <span class="d-block text-truncate">{{$nl['title']}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>


@include("home.".HOME_SKIN.".footer")