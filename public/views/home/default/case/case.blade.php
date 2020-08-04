@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")


<main class="case-main template">
    <div class="banner"></div>

    <div class="service mb-1 py-3">
        <div class="container">
            <div class="row py-3 text-center">
                <div class="col-12">
                    <div class="choose-header">
                        <h4>经典案例</h4>
                        <p class="tc-gray-99 mb-0">SERVICE CASE</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-6 my-3 order-md-0 order-12 d-flex justify-content-between">
                    <div class=" align-items-center">
                        <div class="d-inline-block mr-md-2">全部案例分类</div>
                    </div>
                </div>
            </div>

            <div class="sort-menu-item">
                <div class="row my-2">
                @foreach($caseCategory as $caseCat)
                    <div class="col-lg-2 col-6">
                        <div class="sort-group">
                            <ul class="list-unstyled mb-2">
                                    <li><a class="text-nowrap @if(isset($_GET["cid"]) && $caseCat->id == $_GET["cid"]) tc-theme  @else tc-gray-99 @endif" href="{{url("/case?cid=$caseCat->id")}}">{{$caseCat->name}}</a></li>
                            </ul>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-6 my-3 order-md-0 order-12 d-flex justify-content-between">
                    <div class="align-items-center">
                        <div class="d-inline-block">
                            <span class="sort-type @if(empty($params['screen']) || !in_array($params['screen'], ['is_rec', 'is_hot'])) active @endif d-inline-block py-2 px-md-3 px-2 border rounded" onclick="clickSelected(0)">全部</span>
                            <span class="sort-type d-inline-block py-2 px-md-3 px-2 border rounded @if(!empty($params['screen']) && $params['screen'] == 'is_rec')) active @endif" onclick="clickSelected(1)">推荐</span>
                            <span class="sort-type d-inline-block py-2 px-md-3 px-2 mx-md-2 border rounded @if(!empty($params['screen']) && $params['screen'] == 'is_hot')) active @endif" onclick="clickSelected(2)">热门</span>
                        </div>
                    </div>
                    <div class="sort-menu border rounded d-md-none d-block">
                        <img class="w-100" src="{{HOME_ASSET}}assets/img/mean-icon.png" alt="">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 order-md-0 order-1">
                    <div class="search-group mt-md-0 mt-3">
                        <input type="hidden" name="cid" value="{{$params['cid']}}" />
                        <input type="hidden" name="screen" value="{{$params['screen']}}" />
                        <input class="w-100 py-2 px-3 border" type="text" name="search" placeholder="搜索案例名称" value="{{$params['search']}}" />
                        <i class="fa fa-search tc-gray-99" onclick="search()"></i>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                @if(($datas->toArray())['total'] > 0)
                    @foreach($datas as $data)
                        <div class="col-md-3 col-6 mt-md-0 mb-4">
                            <a class="service-link position-relative d-block" href="{{url("/case/detail?id=$data->id")}}">
                                <div class="card border-0">
                                    <div class="service-img"><img class="card-img-top" src="{{GetUrlByPath($data->cover)}}" alt=""></div>
                                    <div class="card-body px-0 text-white bc-theme">
                                        <p class="card-text">{{$data->title}}</p>
                                    </div>
                                </div>
                                <div class="view-text text-white rounded pb-5 d-flex justify-content-center align-items-center">
                                    查看详情
                                </div>
                            </a>
                        </div>
                    @endforeach

                    <div class="col-12">
                        {{ $datas->links("home.".HOME_SKIN.".globals.pagination.page",['datas'=>$datas]) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    $('input[name=search]').bind('keyup', function(event) {
    　　if (event.keyCode == "13") {
    　　　　//回车执行查询
            search();
    　　}
    });

    function search() {
        window.location.href = "{{ url('/case') }}?cid=" + $('input[name=cid]').val() + "&screen=" + $('input[name=screen]').val() + "&search=" + $('input[name=search]').val();
    }
    
    function clickSelected(status) {
        switch(parseInt(status)) {
             case 1: //推荐
                $('input[name=screen]').val('is_rec');
                break;
             case 2: //热门
                $('input[name=screen]').val('is_hot');
                break;
             default:
                $('input[name=screen]').val('');
                break;
        }
        search();
    }
</script>
@include("home.".HOME_SKIN.".footer")

