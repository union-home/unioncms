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
            <li class="breadcrumb-item"><a href="#">内容管理</a></li>
            <li class="breadcrumb-item active">视频管理</li>
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
                                        <div class="producttitle">
                                            <a href="{{url('admin/video/category')}}"
                                               class="btn btn-danger btn-xs">
                                                返回专辑
                                            </a>
                                        </div>

                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/video/add?cid='.$_GET['cid'])}}"
                                               class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>

                                        </div>
                                        <div class="btn-group float-right">
                                            <form action="{{url('admin/video')}}" method="get">
                                                <div class="card-search">
                                                    <input type="hidden" name="cid" value="{{$_GET['cid']}}">
                                                    <input type="text" class="form-control"
                                                           placeholder="Search inbox..." name="search"
                                                           value="{{isset($params['search']) ? $params['search'] : ''}}">
                                                    <span class="fa fa-search" onclick="$('form').submit()"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th>#id</th>
                                                <th>视频分类</th>
                                                <th>视频类型</th>
                                                <th>标题</th>
                                                <th>视频路径</th>
                                                <th>排序</th>
                                                <th>{{getTranslateByKey("common_create_at")}}</th>
                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($case as $value)
                                                <tr>
                                                    <td>{{$value->id}}</td>
                                                    <td>{{$value->cate->name}}</td>
                                                    <td>{{\App\Models\Video::type[$value->type]}}</td>
                                                    <td>{{$value->title}}</td>
                                                    <td style="width: 200px;">
                                                        {{GetUrlByPath($value->url)}}
                                                    </td>
                                                    <td>{{$value->sort}}</td>
                                                    <td>{{$value->created_at}}</td>

                                                    <td>
                                                        <a class="btn btn-teal"
                                                           href="{{url('admin/video/edit/'.$value->id)}}">{{getTranslateByKey("common_edit")}}</a>
                                                        &nbsp;&nbsp;
                                                        <a class="btn btn-danger" href="javascript:;"
                                                           onclick="delData({{$value->id}})">{{getTranslateByKey("common_delete")}}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                {{ $case->links('globals.pagination.admin',['case'=>$case]) }}
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
<script>
    function delData(id) {

        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: '{{getTranslateByKey("common_sure_to_delete")}}',
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function () {
                        location.href = "{{url('admin/video/delete')}}" + "/" + id
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }
</script>
