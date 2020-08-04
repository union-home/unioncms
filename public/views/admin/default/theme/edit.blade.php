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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("common_home_page")}}</a></li>
            <li class="breadcrumb-item"><a href="#">风格管理</a></li>
            <li class="breadcrumb-item active">风格编辑</li>
        </ol>
    </div>
</div>

<section class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <section class="main-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-default">
                                        所有文件
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>文件名称</th>
                                                <th>类型</th>
                                                <th>大小</th>
                                                <th>修改时间</th>
                                                <th>后缀</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($files as $value)
                                                <tr>
                                                    <td>@if($value["type"]=="dir") <a href="#">{{$value["name"]}}</a> @else {{$value["name"]}} @endif</td>
                                                    <td>{{$value["type"]}}</td>
                                                    <td>{{$value["size"]}}</td>
                                                    <td>{{$value["lastmodified"]}}</td>
                                                    <td>{{$value["extension"]}}</td>
                                                    <td>
                                                        @if($value["type"]!="dir")
                                                            <a class="btn btn-teal" href="{{url('admin/faq/edit/')}}">{{getTranslateByKey("common_edit")}}</a> &nbsp;&nbsp;
                                                            <a class="btn btn-danger" href="javascript:;" onclick="delData()">{{getTranslateByKey("common_delete")}}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                        <div class="col-md-12">
                                            <button type="button" id="ton" onclick="history.go(-1);" class="btn btn-default ">{{getTranslateByKey("common_back")}}</button>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>



                    </section>


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

