<div class="col-md-3 col-12">
    <div class="problem-left h-100 p-3">
        <div class="border">
            <div class="problem-item py-2 px-3">
                @if(@$_GET['cate'])
                    @foreach($cate_list as $cl)
                        @if($cl['id']==$_GET['cate'])
                            {{$cl['name']}}
                        @endif
                    @endforeach
                @else
                    常见问题类别
                @endif
            </div>
        </div>
        <div class="problem-list border border-top-0 px-3">
            <ul class="list-unstyled mb-0">
                @if(@$_GET['cate'] > 0)
                    <a href="{{url('/faq')}}">
                        <li class="py-2">常见问题类别</li>
                    </a>
                @endif
                @foreach($cate_list as $cl)
                    <a href="{{url('/faq?cate=').$cl['id']}}">
                        <li class="py-2">{{$cl['name']}}</li>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
</div>