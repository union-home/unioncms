@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")

<main class="template">
    <div class="py-md-5 py-3">
        <div class="container">
            <div class="col-12 mb-md-5 mb-0 text-center">
                <h4>友情链接</h4>
                <p class="tc-gray-99">BLOGROLL</p>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-between px-3 pb-3">
                    <h6 class="new-title mb-0">友情链接列表</h6>
                </div>
            </div>
            <div class="col-12 text-center">
                <div class="row">
                    @foreach($roll_list2 as $l2)
                        <div class="col-lg-2 col-md-4 col-6">
                            <a class="d-block text-body py-1 border my-2" href="{{$l2['url']}}" target="_blank">
                                <img src="{{UPLOADPATH.$l2['cover']}}" width="18" height="16">
                                <span class="align-middle">{{$l2['title']}}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    @foreach($roll_list1 as $l1)
                        <div class="col-lg-2 col-md-4 col-6">
                            <a class="d-block text-body py-1 border my-2" href="{{$l1['url']}}" target="_blank">
                                <span class="align-middle">{{$l1['title']}}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>

@include("home.".HOME_SKIN.".footer")

