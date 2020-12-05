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
            <li class="breadcrumb-item active">专辑管理</li>
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
                                        专辑
                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/video/categoryAdd')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th>#id</th>
                                                <th>专辑名称</th>
                                                <th>{{getTranslateByKey("common_create_at")}}</th>
                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($category as $value)
                                                <tr>

                                                    <td>{{$value->id}}</td>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{$value->create_at}}</td>

                                                    <td>
                                                        <a class="btn btn-primary"
                                                           href="{{url('admin/video?cid='.$value->id)}}">
                                                            进入专辑
                                                        </a>
                                                        &nbsp;&nbsp;
                                                        <a class="btn btn-teal"
                                                           href="{{url('admin/video/categoryEdit/'.$value->id)}}">
                                                            {{getTranslateByKey("common_edit")}}
                                                        </a>
                                                        &nbsp;&nbsp;
                                                        <a class="btn btn-danger" href="javascript:;"
                                                           onclick="delData({{$value->id}})">
                                                            {{getTranslateByKey("common_delete")}}
                                                        </a>
                                                        &nbsp;&nbsp;
                                                        <a class="btn btn-info copyURL{{$value->id}}" href="javascript:;"
                                                           onclick="copyURL({{$value->id}})">
                                                            复制小程序专辑路径
                                                        </a>
                                                    </td>
                                                </tr>
                                                <input type="hidden" id="copyURL{{$value->id}}" value="{{'/pages/video/video?cid='.$value->id}}">
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                {{ $category->links('globals.pagination.admin',['category'=>$category]) }}
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
{{--复制专辑路径--}}


<!-- Common Plugins -->
@include('admin/default/js',['load'=> ["custom"]])
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/js/clipboard.min.js"></script>
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
                        location.href = "{{url('admin/video/categoryDelete')}}" + "/" + id
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }


    function copyURL(id) {
        var content = $('#copyURL'+id).val();
        var clipboard = new Clipboard('.copyURL'+id, {
            text: function() {
                return content;
            }
        });
        clipboard.on('success', function(e) {
            popup({type: "success", msg: '复制成功', delay: 800});
        });

        clipboard.on('error', function(e) {
            console.log(e);
        });

        /*var Url2 = document.getElementById('copyURL'+id);
        Url2.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        alert('複製成功')*/
    }
</script>