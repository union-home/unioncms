@include("home.".HOME_SKIN.".header")

<body>

<!-- ==============================================
**Preloader**
=================================================== -->
<div id="loader">
    <div id="element">
        <div class="circ-one"></div>
        <div class="circ-two"></div>
    </div>
</div>

<!-- ==============================================
**Header**
=================================================== -->
<header class="opt3">
    <!-- Start Header top Bar -->
        @include("home.".HOME_SKIN.".topbar")
    <!-- End Header top Bar -->

    <!-- Start Navigation -->
        @include("home.".HOME_SKIN.".nav")
    <!-- End Navigation -->
</header>


<!-- ==============================================
**Inner Banner**
=================================================== -->
<section class="inner-banner">
    <div class="container">
        <div class="contents">
            <h1>常见问题</h1>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. <span>Lorem Ipsum has been the industry's standard dummy text ever since</span></p>
        </div>
    </div>
</section>

<!-- ==============================================
**FAQ**
=================================================== -->
<section class="faq-outer grey-bg padding-lg" id="faq-{{$id}}">
    <div class="container">
        <div class="row">
            <div class="col-md-3 faq-left">
                <ul>

                    @foreach($category as $value)
                    <li @if($id == $value["id"]) class="active" @endif> <a href="{{url('faq/'.$value["id"])}}#faq-{{$value["id"]}}">
                            <div class="icon"><span class="icon-general"></span></div>
                            <div class="cnt-block">
                                <h3>{{$value["name"]}}</h3>
                                <p>{{$value["describe"]}}</p>
                            </div>
                        </a>
                    </li>
                    @endforeach


                </ul>
            </div>
            <div class="col-md-9 faq-right">
                <div id="accordion" role="tablist">

                    @foreach($faq as $val)
                    <!-- Start:accordion item 01 -->
                    <div class="card">
                        <div class="card-header" role="tab" id="heading{{$val["id"]}}">
                            <h5 class="mb-0"> <a data-toggle="collapse" href="#collapse{{$val["id"]}}" aria-expanded="true" aria-controls="collapseOne"> {{$val["title"]}} </a> </h5>
                        </div>
                        <div id="collapse{{$val["id"]}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$val["id"]}}" data-parent="#accordion">
                            <div class="card-body">
                                <p>{{$val["content"]}}</p>
                            </div>
                        </div>
                    </div>
                    <!-- End:accordion item 01 -->
                    @endforeach

                    @if(count($faq)<=0)
                            <div class="card">
                                暂无数据！！
                            </div>

                        @endif

                </div>
            </div>
        </div>
    </div>
</section>



<!-- ==============================================
**Signup Section**
=================================================== -->
<section class="signup-outer padding-lg video-bg" data-vide-bg="mp4: {{HOME_ASSET}}assets/video/working-space.mp4, webm: {{HOME_ASSET}}assets/video/working-space.webm, ogv: {{HOME_ASSET}}assets/video/working-space.ogv" data-vide-options="loop: true, muted: false, position: 0% -60%">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <ul class="clearfix">
                    <li> <span class="icon-men"></span>
                        <h4>Signup for an <span>Account</span></h4>
                    </li>
                    <li> <span class="icon-chat"></span>
                        <h4>Discuss with <span>our team</span></h4>
                    </li>
                    <li> <span class="icon-lap"></span>
                        <h4>Receive a <span>good support</span></h4>
                    </li>
                </ul>
                <div class="signup-form">
                    <form action="#" method="get">
                        <div class="email">
                            <input name="email" type="text" placeholder="email">
                        </div>
                        <div class="password">
                            <input name="password" type="password" placeholder="password">
                        </div>
                        <button class="signup-btn">Sign up Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==============================================
**Footer opt1**
=================================================== -->
    @include("home.".HOME_SKIN.".footer")

    @include("home.".HOME_SKIN.".js")

