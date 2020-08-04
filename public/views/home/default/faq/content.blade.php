@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")

<main class="problem">
    @include("home.".HOME_SKIN.".faq.top")

    <div class="pb-md-5 py-3">
        <div class="container">
            <div class="row">
                @include("home.".HOME_SKIN.".faq.left")
                <div class="col-md-9 col-12">
                    <div class="problem-left p-3 mt-md-0 mt-3">
                        <div class="d-flex pb-3 border-bottom">
                            <div class="mr-3">
                                <a class="tc-gray-99 h-cp" onclick="history.go(-1)">
                                    <i class="fa fa-reply-all"></i>
                                    <span class="">返回</span>
                                </a>
                            </div>
                        </div>
                        <div class=" py-3">
                            <div class="">
                                <h5 class="text-center">{{$data['title']}}</h5>
                                <div class="tc-gray-99 d-flex justify-content-center py-3">
                                    <div class="">
                                        <span>发布时间:</span>
                                        <span>{{$data['create_at']}}</span>
                                    </div>
                                </div>
                                <div class="lh-30">
                                    {!!$data['content']!!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

@include("home.".HOME_SKIN.".footer")
<script src="{{HOME_ASSET}}assets/js/problem.js"></script>