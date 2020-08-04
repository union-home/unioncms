@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")

{{--template--}}
<main class="template">
    <div class="banner d-flex flex-column justify-content-center align-items-center">
        <div class="container">
            <div class="text-white">
                <div class="d-flex align-items-end mb-2">
                    <span class="fz-26 align-text-top">薪</span><span>--想要高薪，只要你愿意。</span>
                </div>
                <div class="d-flex align-items-end mb-2">
                    <span class="fz-26 align-text-top">满</span><span>--满载的不仅是你的钱包，还有你的理想。</span>
                </div>
                <div class="d-flex align-items-end mb-2">
                    <span class="fz-26 align-text-top">益</span><span>--收益金钱、学识和技能。</span>
                </div>
                <div class="d-flex align-items-end mb-2">
                    <span class="fz-26 align-text-top">足</span><span>--足够的发展空间。</span>
                </div>
            </div>

        </div>
    </div>

    <div class="pb-md-5 py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row py-3 py-md-5">
                        <div class="col-12 mb-md-5 text-center">
                            <h4>加入我们</h4>
                            <p class="tc-gray-99 mb-0">JOIN US</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="bc-2nd-f1 py-3 px-4 tc-gray-50">
                        <div class="pt-3">
                            <h6>诚邀专业人才加入，共同打造更有竞争力的网站管理系统，有意者请发送求职意向及简历至822495327@qq.com</h6>
                        </div>


                        @foreach($list as $l)
                        <div class="lh-30 pt-4">
                            <div class="">
                                <span>职位：{{$l['position']}}</span>
                            </div>
                            <div class="">
                                岗位职责：<br/>
                                {!!$l['description']!!}<br/>
                                岗位要求：<br/>
                                {!!$l['requirements']!!}
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include("home.".HOME_SKIN.".footer")