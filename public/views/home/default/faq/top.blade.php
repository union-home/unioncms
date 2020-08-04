<div class="banner d-flex flex-column justify-content-center align-items-center">
    <div class="container">
        <form action="{{url('/faq')}}" method="get">
            <div class="d-flex mb-2">
                <input type="hidden" name="cate" value="{{@$_GET['cate']}}">
                <input class="w-100 py-2 px-3 border-0" name="search" type="text" value="{{@$_GET['search']}}"
                       placeholder="请简单描述您的问题或问题关键字，如“忘记密码”">
                <button type="submit" class="search-btn py-2 px-4">查询问题</button>
            </div>
        </form>
        {{--            <div class="d-flex text-white">
                        <div class="text-nowrap"><span>热门问题：</span></div>
                        <ul class="list-unstyled mb-0">
                            <li class="list-inline-item text-nowrap"><span>建站宝盒</span></li>
                            <li class="list-inline-item text-nowrap"><span>域名注册</span></li>
                            <li class="list-inline-item text-nowrap"><span>主机管理</span></li>
                            <li class="list-inline-item text-nowrap"><span>网站建设</span></li>
                            <li class="list-inline-item text-nowrap"><span>主机管理</span></li>
                            <li class="list-inline-item text-nowrap"><span>魔方主机</span></li>
                            <li class="list-inline-item text-nowrap"><span>备案</span></li>
                        </ul>
                    </div>--}}
    </div>
</div>