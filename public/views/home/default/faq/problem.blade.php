@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")

<main class="problem">
    @include("home.".HOME_SKIN.".faq.top")

    <div class="pb-md-5 py-3">
        <div class="container">
            <div class="row">
                @include("home.".HOME_SKIN.".faq.left")
                <div class=" col-md-9 col-12">
                    <div class="problem-left p-3 mt-md-0 mt-3">
                        <h6 class="problem-title bc-white py-2 pl-3">常见问题列表</h6>
                        <div class="">
                            <ul class="list-unstyled">
                                @foreach($problem_list as $list)
                                    <li class="py-2">
                                        <a class="d-md-flex justify-content-between" href="{{url('/faq/detail?id=').$list['id']}}">
                                            <div class="text-nowrap d-flex">
                                                <span class="d-inline-block text-body text-truncate">{{$list['title']}}</span>
                                            </div>
                                            <div class="d-md-block d-none">
                                                <span class="tc-gray-99">{{$list['create_at']}}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-12 pageList">
                    @if(count($problem_list) > 0)
                        {{$problem_list->links()}}
                    @endif
{{--                    <div class="pagination-group d-flex justify-content-center mt-3">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="active" href="#">1</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="" href="#">2</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="" href="#">3</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="" href="#"><i class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</main>

@include("home.".HOME_SKIN.".footer")
<script src="{{HOME_ASSET}}assets/js/problem.js"></script>