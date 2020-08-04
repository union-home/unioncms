@include("admin.".ADMIN_SKIN.".header")

<body class="horizontal">

<!-- ============================================================== -->
<!-- 						Topbar Start 							-->
<!-- ============================================================== -->
@include("admin.".ADMIN_SKIN.".topbar")
<!-- ============================================================== -->
<!--                        Topbar End                              -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- 						Navigation Start 						-->
<!-- ============================================================== -->
@include("admin.".ADMIN_SKIN.".nav")
<!-- ============================================================== -->
<!-- 						Navigation End	 						-->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- 						Content Start	 						-->
<!-- ============================================================== -->

<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">首页</a></li>
            <li class="breadcrumb-item"><a href="#">系统设置</a></li>
            <li class="breadcrumb-item active">风格管理</li>
        </ol>
    </div>
</div>

<section class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                        <section class="main-content">
                            <div class=" breadcrumb row bg-success">
                                <label for="" class="col-sm-11 col-form-label">已安装主题</label>
                                <label for="" class="col-sm-1 col-form-label text-right"><a style="color: #FFF;" href="{{url('admin/cloud?search=&cloud_type=3')}}">在线主题</a></label>
                            </div>
                            <div class="row">
                                <!-- Column -->
                                @foreach($themes as $value)

                                <div class="col-lg-4">
                                    <div class="card" >
                                        <img class="card-img-top img-fluid" src="{{asset(HOME_SKIN_PATH.$value['info']['preview'])}}" style="min-height: 372px;" alt="#">
                                        <div class="card-body">

                                            <h3 class="font-normal">{{$value['info']['name']}} <span class="float-right">V{{$value['info']['version']}}</span></h3>
                                            <p class="mb-0 mt-3">作者：{{$value['info']['author']}}</p>
                                            <p class="mb-0 mt-3">{{$value['info']['description']}}</p>

                                            @if($value['status']==1)
                                                <button class="btn btn-success mt-3">正在使用</button>
                                            @else
                                                <a href="{{url("admin/themes/use/".$value["identification"])}}" class="btn btn-primary mt-3">使用</a>
                                            @endif
                                            @if($value['identification']!='default' && $value['status'] !=1 )
                                                <a href="{{url("admin/themes/uninstall?m=".$value["identification"])}}" class="btn btn-danger mt-3">卸载</a>
                                            @endif

                                            {{--<a href="{{url("admin/themes/edit/".$value["identification"])}}" class="btn btn-default mt-3">编辑</a>--}}
                                            {{--@if($value['status']=='1')
                                                <button class="btn btn-default mt-3">更新</button>
                                            @endif--}}


                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <!-- Column -->
                            </div>

                    </section>

                    @if($uninstallthemes)
                    <section class="main-content">
                        <div class="form-group breadcrumb row">
                            <label for="" class="col-sm-12 col-form-label">未安装主题</label>
                        </div>
                        <div class="row">
                            <!-- Column -->
                            @foreach($uninstallthemes as $value)
                                <div class="col-lg-4">
                                    <div class="card">
                                        <img class="card-img-top img-fluid" src="{{asset(HOME_SKIN_PATH.$value['preview'])}}" alt="#">
                                        <div class="card-body">
                                            <h3 class="font-normal">{{$value['name']}} <span class="float-right">V{{$value['version']}}</span></h3>
                                            <p class="mb-0 mt-3">作者：{{$value['author']}}</p>
                                            <p class="mb-0 mt-3">{{$value['description']}}</p>

                                            <a href="{{url("admin/themes/install/".$value["identification"])}}"  class="btn btn-default mt-3">安装</a>
                                            <a href="{{url("admin/themes/delete/".$value["identification"])}}" class="btn btn-danger mt-3">删除</a>

                                        </div>
                                    </div>
                                </div>
                        @endforeach
                            <!-- Column -->
                        </div>

                    </section>
                    @endif

                </div>

            </div>
        </div>
    </div>



    @include('admin/'.ADMIN_SKIN.'/footer')


</section>
<!-- ============================================================== -->
<!-- 						Content End		 						-->
<!-- ============================================================== -->



<!-- Common Plugins -->
@include('admin/default/js',['load'=> ["custom"]])

</body>
</html>
