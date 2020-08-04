@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")


<main class="template">
    <div class="banner"></div>

    <div class="news py-md-5">
        <div class="container">
            <div class="row py-3 py-md-5">
                <div class="col-12 mb-md-5 text-center">
                    <h4>新闻资讯</h4>
                    <p class="tc-gray-99 mb-0">News And Information</p>
                </div>
            </div>
            <div class="row">
                @if(($datas->toArray())['total'] > 0)
                    <div class="col-12">
                        @foreach($datas as $data)
                            <div class="news-group p-3">
                                <a href="{{url("/news/detail?id=$data->id")}}">
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong class="news-text tc-theme tc-black">{{$data->title}}</strong>
                                        <small class="news-date text-muted">{{date('Y-m-d', strtotime($data->create_at))}}</small>
                                    </div>
                                    <div class="tc-black lh-30">
                                        {!! str_limit(strip_tags($data->content), $limit = 100, $end = '...') !!}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        {{ $datas->links("home.".HOME_SKIN.".globals.pagination.page",['datas'=>$datas]) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

@include("home.".HOME_SKIN.".footer")