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
<style type="text/css">
    .display-none{display: none;}
</style>
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("common_home_page")}}</a></li>
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("cloud_app")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("cloud_app_list")}}</li>
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                已安装插件
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table table-hover table-maillist">
                                                <tbody>
                                                @if($plugins_install_datas)
                                                    @foreach($plugins_install_datas as $plugins_install_data)
                                                        <tr>
                                                            <td>
                                                                <a class="float-left" href="#"><img class="media-object rounded-circle" src="{{MODULE_ADMIN_ASSET}}/{{$plugins_install_data->icon}}" width="40" alt=""> </a>
                                                            </td>
                                                            <td><strong><a class="color-info">{{$plugins_install_data->name}}</a></strong></td>
                                                            <td>
                                                                <a>{{$plugins_install_data->description}}</a>
                                                            </td>
                                                            <td class="mail-date">
                                                                @if($plugins_install_data->status == 0)
                                                                    <a href="{{url('admin/cloud/changeStatus?m='.$plugins_install_data->identification.'&status=1')}}" class="btn btn-success">启用</a>
                                                                @else
                                                                    <a href="{{url('admin/cloud/changeStatus?m='.$plugins_install_data->identification.'&status=0')}}" class="btn btn-danger">禁用</a>
                                                                @endif

                                                                <a href="{{url('admin/cloud/uninstall?m='.$plugins_install_data->identification)}}" class="btn btn-danger">卸载</a>


                                                                @if($cloud_plugins)
                                                                    @if($cloud_plugins['data'])
                                                                        @foreach($cloud_plugins['data'] as $cloud)
                                                                            @if(!empty($cloud['releaselist']) && count($cloud['releaselist']) > 1 && $plugins_install_data->identification == $cloud['identification'])
                                                                                &nbsp;
                                                                                &nbsp;
                                                                                &nbsp;
                                                                                &nbsp;
                                                                                ||
                                                                                &nbsp;
                                                                                &nbsp;
                                                                                &nbsp;
                                                                                &nbsp;
                                                                                <select name="version">
                                                                                    @foreach($cloud['releaselist'] as $release)
                                                                                        <option value="{{$release['version']}}" @if($plugins_install_data->version == $release['version']) selected @endif >{{$release['version']}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <input type="hidden" name="plugin_name" value="{{$cloud['name']}}" />
                                                                                <a href="javascript:;" onclick="downloadVersion(this)" class="btn btn-default">更新版本</a>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-header card-default">
                                        <div class="row">
                                            <div class="col-md-6">
                                                云端插件
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-maillist">
                                                <tbody>
                                                @if($cloud_plugins)
                                                    @if($cloud_plugins['data'])
                                                        @foreach($cloud_plugins['data'] as $cloud)
                                                            <tr>
                                                                <td>
                                                                    <a class="float-left" href="#">
                                                                        <img class="media-object rounded-circle" src="{{$cloud['icon']}}" width="40" alt="">
                                                                    </a>
                                                                </td>
                                                                <td><strong><a class="color-info">{{$cloud['name']}}</a></strong></td>
                                                                <td>
                                                                    <a>{{$cloud['description']}}</a>
                                                                </td>
                                                                <td class="mail-date">
                                                                    <input type="hidden" name="plugin_name" value="{{$cloud['name']}}" />
                                                                    @if(in_array($cloud['name'], $local_plugins))
                                                                        <a href="javascript:;" class="btn btn-default"> 已下载 </a>
                                                                    @else
                                                                        @if(!empty($cloud['releaselist']) && count($cloud['releaselist']) > 1)
                                                                            <select name="version">
                                                                                @foreach($cloud['releaselist'] as $release)
                                                                                    <option value="{{$release['version']}}">{{$release['version']}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        @else
                                                                            <select name="version" class="display-none">
                                                                                <option value="{{$cloud['version']}}">{{$cloud['version']}}</option>
                                                                            </select>
                                                                        @endif
                                                                        <a href="javascript:;" onclick="downloadVersion(this)" class="btn btn-default">下载</a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endif
                                                </tbody>
                                            </table>

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


<script type="text/javascript">
    function downloadVersion( _this ) {
        popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
            window.location.href = "{{url('admin/cloud/downloadVersion')}}?plugin_name=" + $(_this).siblings('input[name=plugin_name]').val()
            + '&version=' + $(_this).siblings('select[name=version]').val();
        }});
    }
</script>
</body>
</html>