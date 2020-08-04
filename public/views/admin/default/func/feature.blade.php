@include("admin.".ADMIN_SKIN.".header")
{{--<link href="{{ADMIN_ASSET}}assets/lib/bootstrap/css/bootstrap.3-3.7.css" rel="stylesheet">--}}

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
<style type="text/css">
    .display-none {
        display: none;
    }

    .onlineModuleList {
        cursor: pointer;
    }


    * {
        margin: 0;
        padding: 0;
    }

    .mokuai .row div.col-md-3 {
        height: 340px;
        margin: 2rem 0;
    }

    .box {
        box-shadow: 0 0 8px #ccc;
        border-radius: 15px;
    }

    .box img {
        width: 101%;
        height: 215px;
    }

    .bottom p {
        color: #c5c9ce;
        display: inline-block;
        margin-right: 2px;
    }
    @media (max-width: 576px){.bottom p {
        margin-right: 8px;
    }
    }
    .bottom p a{
        color: #c5c9ce;
    }
    .bottom h5 p{
        font-size: 12px;
    }
    .bottom {
        padding: 5px 0px;
    }

    .page-header {
        border-bottom: 1px #ccc solid;
    }
    .card-body{
        padding: 20px 0;

    }

    .bottomtitle h5{
        line-height: 25px;
        font-weight: bold;
        /*width: 71px;*/
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .bottomtitle p{
        font-size: 12px;
    }
    .clearfix:after{
        visibility:hidden;
        clear:both;
        display:block;
        content:".";
        height:0;
    }.clearfix{
         *zoom:1;
     }

</style>
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("common_home_page")}}</a></li>
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("functional_module")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("functional_module_list")}}</li>
        </ol>
    </div>
</div>


<section class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body feacardb">
                    <section class="main-content">

                        <div class="row">
                            <div class="col-md-12">

                                <div class="">

                                    <div class="card-header card-default">
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                已安装模块
                                            </div>
                                            <div class="col-md-6 col-6 text-right onlineModuleList"
                                                 onclick="onlineModuleList()">
                                                在线模块
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="container-fluid mokuai">
                                            <div class="row d-flex">


                                                @if($modules_install_datas)
                                                    @foreach($modules_install_datas as $modules_install_data)

                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <div class="box">
                                                                <img src="{{MODULE_ADMIN_ASSET}}/{{$modules_install_data->icon}}">
                                                                <div class="bottom">
                                                                    <div class="bottomtitle clearfix mt-3">
                                                                        <h5>{{$modules_install_data->name}}

                                                                        </h5>
                                                                        <p>
                                                                            当前版本：{{$modules_install_data->version}}
                                                                        </p>
                                                                    </div>

                                                                    <p>
                                                                        <a href="{{url('admin/module?m='.$modules_install_data->identification)}}"  target="_blank">
                                                                            <span class="fa fa-cog"></span> 进入管理
                                                                        </a>
                                                                    </p>
                                                                    {{--                                                                    <br>--}}
                                                                    @if($modules_install_data->is_index == 0)
                                                                        <p>
                                                                            <a href="{{url('admin/feature/changeIndex?m='.$modules_install_data->identification.'&is_index=1')}}">
                                                                                <span class="fa fa-home fa-fw"></span> 设为‘前台首页’
                                                                            </a>
                                                                        </p>
                                                                    @else

                                                                        <p>
                                                                            <a href="{{url('admin/feature/changeIndex?m='.$modules_install_data->identification.'&is_index=0')}}">
                                                                                <span class="fa fa-home fa-fw"></span> 取消设为‘前台首页’
                                                                            </a>
                                                                        </p>
                                                                    @endif
                                                                    <br />
                                                                    @if($modules_install_data->status == 0)
                                                                        <p onclick="changeStatusQuestion(1, '{{url('admin/feature/changeStatus?m='.$modules_install_data->identification.'&status=1')}}')">
                                                                            <span class="fa fa-circle-o-notch"></span> 启用
                                                                        </p>

                                                                    @else
                                                                        <p onclick="changeStatusQuestion(0, '{{url('admin/feature/changeStatus?m='.$modules_install_data->identification.'&status=0')}}')">
                                                                            <span class="fa fa-ban"></span> 禁用
                                                                        </p>
                                                                    @endif
                                                                    <p>
                                                                        <span class="fa fa-refresh"></span> 立即更新
                                                                    </p>


                                                                    <p onclick="uninstallQuestion('{{url('admin/feature/uninstall?m='.$modules_install_data->identification)}}')">
                                                                        <span class=" fa fa-trash-o"></span> 卸载
                                                                    </p>

                                                                    <p>
                                                                        <a href="{{url('/admin/cloud')}}">
                                                                            <span class=" fa fa-plus-circle"></span> 更多
                                                                        </a>

                                                                    </p>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach

                                                @endif


                                            </div>
                                        </div>


                                    </div>

                                    @if($modules_not_install_datas)
                                        <div class="card-header card-default">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    未安装模块
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">

                                            <div class="container-fluid mokuai">
                                                <div class="row d-flex">
                                                    @foreach($modules_not_install_datas as $modules_not_install_data)

                                                        <div class="col-md-2 mb-3 ">
                                                            <div class="box">
                                                                <img src="{{MODULE_ADMIN_ASSET}}/{{$modules_not_install_data->icon}}">
                                                                <div class="bottom">
                                                                    <h5>{{$modules_not_install_data->name}}</h5>
                                                                    <p>
                                                                        <span class="glyphicon glyphicon-download"></span>{{$modules_not_install_data->version}}
                                                                    </p>

                                                                    <p>
                                                                        <a href="{{url('/admin/cloud')}}">
                                                                            <span class="glyphicon glyphicon-th-list"></span>更多
                                                                        </a>

                                                                    </p>

                                                                    <p>
                                                                            <span class="glyphicon glyphicon-cog">
                                                                           <a href="{{url('admin/feature/install?m='.$modules_not_install_data->identification)}}"
                                                                              class="btn btn-default">安装</a>
                                                                            </span>

                                                                    </p>


                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach

                                                </div>

                                            </div>
                                        </div>
                                    @endif


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

<script type="text/javascript">

    function onlineModuleList() {
        window.location.href = "{{url('admin/cloud?cloud_type=0')}}";
    }

    function changeStatusQuestion(status, url) {
        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: status == 1 ? '{{getTranslateByKey("common_sure_to_enabling")}}' : '{{getTranslateByKey("common_sure_to_forbidden")}}',
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function () {
                        location.href = url
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });
    }

    function uninstallQuestion(url) {
        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: '{{getTranslateByKey("common_sure_to_uninstall")}}',
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function () {
                        location.href = url
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });
    }
</script>
</body>
</html>