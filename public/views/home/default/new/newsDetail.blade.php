@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")

<main class="template">
    <div class="banner"></div>

    <div class="news pb-md-5 py-3">
        <div class="container">
            <div class="row py-3 border-bottom">
                <div class="col-12">
                    <h5>{{$data->title}}</h5>
                    <p class="tc-gray-99 mb-0">{{$data->create_at}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tc-gray-99 lh-30 py-3">
                        {!! $data->content !!}
                    </div>
                </div>
            </div>
            <div class="row">
                @if(!empty($last_article))
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="media my-3">
                            <div class="align-self-center p-2 mr-3 text-center bc-gray-f2">
                                <h4>{{date('d', $last_article->create_time)}}</h4>
                                <span class="tc-gray-99">{{date('Y-m', $last_article->create_time)}}</span>
                            </div>
                            <div class="media-body">
                                <h6 class="mt-0">
                                    <a class="tc-black" href="{{url("/news/detail?id=$last_article->id")}}">
                                        <span class="nDetailed-title">{{$last_article->title}}</span>
                                    </a>
                                    <a class="pull-right nDetailed-link tc-black" href="{{url("/news/detail?id=$last_article->id")}}"><span>上一篇</span></a>
                                </h6>
                                <span class="tc-gray-99">
                                    {!! str_limit(strip_tags($last_article->content), $limit = 100, $end = '...') !!}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!empty($next_article))
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="media my-3">
                            <div class="align-self-center p-2 mr-3 text-center bc-gray-f2">
                                <h4>{{date('d', $next_article->create_time)}}</h4>
                                <span class="tc-gray-99">{{date('Y-m', $next_article->create_time)}}</span>
                            </div>
                            <div class="media-body">
                                <h6 class="mt-0">
                                    <a class="tc-black" href="{{url("/news/detail?id=$next_article->id")}}"><span class="nDetailed-title">{{$next_article->title}}</span></a>
                                    <a class="pull-right nDetailed-link tc-black" href="{{url("/news/detail?id=$next_article->id")}}"><span>下一篇</span></a>
                                </h6>
                                <span class="tc-gray-99">
                                    {!! str_limit(strip_tags($next_article->content), $limit = 100, $end = '...') !!}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

@include("home.".HOME_SKIN.".footer")