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
    .float-left{float: left;}
    .float-right{float: right;}
    .font-600{
        white-space: nowrap;
    }
    p{
        margin: 0;
    }
    .buying{
        width: 100%;
    }
    .lead{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        overflow: hidden;
    }
    @media (max-width: 576px) {
        .lead{
            margin-top: 10px;
        }
    }
    .name{
        text-align: left;
    }
    .text-muted{
        color: #181818!important;
    }
    .author{
        text-align: left;
        margin-top: 10px;
        margin-bottom: 16px;
    }
    .description{
        text-align: left;
        margin-bottom: 36px;
    }
    .text-sm{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }
    .card-search{
        margin-bottom:20px;
    }
    .rounded-circle{
        width: 100%;
        height: 100%;
    }
    .forbidden{
        color:#f4516c;
    }
    .d-inline-block{
        display: inline-block;
    }
    .card-body{
        overflow-y: initial;
    }
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
            <form action="{{url('admin/cloud')}}" method="get">
                <button class="btn float-right">搜索</button>

                <div class="card-search">
                    <input type="text" value="{{@$_GET["search"]}}" class="form-control" placeholder="请输入关键词" name="search" value="{{isset($params['search']) ? $params['search'] : ''}}">
                </div>

                @if($cloud_apps && $cloud_apps['cloud_type'])
<p class="d-inline-block">
    <a href="{{url('admin/cloud?cloud_type=-1')}}" class="btn  @if(!isset($_GET['cloud_type']) || $_GET['cloud_type']==-1) btn-primary @endif" style="width: initial"  > 全部应用 </a>
    @foreach($cloud_apps['cloud_type'] as $k => $v)
        <a href="{{url('admin/cloud?search='.@$_GET["search"].'&cloud_type='.$k)}}" class="btn  @if(isset($_GET['cloud_type']) && $_GET['cloud_type'] == $k) btn-primary @endif"  > {{$v['value']}} </a>
    @endforeach
</p>


                @endif


            </form>
        </div>
    </div>
    <hr>



    @if($cloud_apps)
        <div class="row">
            @if($cloud_apps['data']['data'])
                @foreach($cloud_apps['data']['data'] as $cloud)
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">

                                @if($cloud["cloud_type"]==3)
                                    <div class="row">
                                        <div class="col-sm-9 col-md-6">
                                            <img alt="icon" class="margin-b-10" src="http://cloud.unioncms.cn//uploads/{{$cloud['icon']}}" height="100%" width="100%">
                                        </div>
                                        <div class="col-sm-3 col-md-6">
                                            <p class="lead margin-b-0 name">{{$cloud['name']}}</p>
                                            <p class="text-muted author">{{$cloud['author']}}</p>
                                            <p class="text-sm description">{{$cloud['description']}}</p>
                                            <input type="hidden" name="module_name" value="{{$cloud['name']}}" />
                                            <input type="hidden" name="identification" value="{{$cloud['identification']}}" />
                                            <input type="hidden" name="cloud_type" value="{{$cloud['cloud_type']}}" />
                                            @if($cloud['is_free'] == 0)
                                                @if($cloud['cloud_type'] == 0)
                                                    @if(!in_array($cloud['identification'], $cloud_install_datas))
                                                        <button class="btn btn-primary" onclick="downloadModule( this )">
                                                            <i class="demo-pli-male icon-fw"></i>
                                                            下载
                                                        </button>
                                                        <button class="btn btn-danger" onclick="uploadModuleVersion( this )">
                                                            <i class="demo-pli-male icon-fw"></i>
                                                            强制安装
                                                        </button>
                                                    @endif
                                                @elseif($cloud['cloud_type'] == 1)
                                                    @if(!in_array($cloud['identification'], $cloud_install_datas))
                                                        <button class="btn btn-primary" onclick="installApplication( this )">
                                                            <i class="demo-pli-male icon-fw"></i>
                                                            安装
                                                        </button>
                                                    @endif
                                                @elseif($cloud['cloud_type'] == 3)
                                                    <button class="btn btn-primary" onclick="installThemeTemplate( this )">
                                                        <i class="demo-pli-male icon-fw"></i>
                                                        安装
                                                    </button>
                                                @endif

                                                @if(!empty($cloud['releaselist']) && count($cloud['releaselist']) > 1)
                                                    @if($cloud_install_lists)
                                                        @foreach($cloud_install_lists as $local_cloud)
                                                            @if($local_cloud['identification'] == $cloud['identification'])
                                                                @if($local_cloud['version'] < $cloud['releaselist'][0]['version'])
                                                                    <button class="btn btn-danger" onclick="uploadModuleVersion( this )">
                                                                        <i class="demo-pli-male icon-fw"></i>
                                                                        强制更新最新版
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif

                                                @if(in_array($cloud['identification'], $cloud_install_datas))
                                                    <button class="btn btn-warning" onclick="unInstallApplication( this, {{$cloud["cloud_type"]}} )">
                                                        <i class="demo-pli-male icon-fw"></i>
                                                        卸载
                                                    </button>


                                                @endif
                                            @else
                                                <button class="btn btn-primary buying">
                                                    <i class="demo-pli-male icon-fw"></i>
                                                    购买
                                                </button>
                                                <hr>
                                            @endif

                                            <ul class="list-unstyled margin-b-0 text-center row">
                                                @if($cloud['is_free'] == 0)
                                                    <li class="col-lg-4 col-md-6  col-3">
                                                        <span class="font-600">免费</span>
                                                    </li>
                                                @else
                                                    <li class="col-lg-4 col-md-6 col-3">
                                                        <span class="font-600">付费</span>
                                                        <p class="text-muted text-sm margin-b-0">{{$cloud['money']}}</p>
                                                    </li>
                                                @endif
                                                <li class="col-lg-4 col-md-6 col-3">
                                                    <span class="font-600">版本列表</span>
                                                    <p class="text-muted text-sm margin-b-0">
                                                        @if(!empty($cloud['releaselist']) && count($cloud['releaselist']) > 1)
                                                            <select name="version">
                                                                @foreach($cloud['releaselist'] as $release)
                                                                    <option value="{{$release['version']}}">{{$release['version']}}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <select name="version">
                                                                <option value="{{$cloud['detail']['version']}}">{{$cloud['detail']['version']}}</option>
                                                            </select>
                                                        @endif
                                                    </p>
                                                </li>
                                                <li class="col-lg-4 col-md-6 col-3">
                                                    <span class="font-600">应用类型</span>
                                                    <p class="text-muted text-sm margin-b-0">
                                                        {{$cloud_apps['cloud_type'][$cloud['cloud_type']]['value']}}
                                                    </p>
                                                </li>
                                                <li class="col-lg-4 col-md-6 col-3">
                                                    <span class="font-600">状态</span>
                                                    <p class="text-muted text-sm margin-b-0">
                                                    @if(in_array($cloud['identification'], $cloud_install_datas))
                                                        @if($cloud['cloud_type'] == 3)
                                                            <!-- 主题模板 -->
                                                                <a href="{{url('admin/themes')}}" class="btn btn-danger"> 设置 </a>
                                                            @else
                                                                @if($cloud_install_lists)
                                                                    @foreach($cloud_install_lists as $local_cloud)
                                                                        @if($local_cloud['identification'] == $cloud['identification'])
                                                                            @if($local_cloud['status'] == 0)
                                                                                <a href="javascript:;" onclick="changeStatusQuestion(1, '{{url('admin/cloud/changeStatus?m='.$local_cloud['identification'].'&status=1')}}')" class="btn btn-success">启用</a>
                                                                            @else
                                                                                <a href="javascript:;" onclick="changeStatusQuestion(0, '{{url('admin/cloud/changeStatus?m='.$local_cloud['identification'].'&status=0')}}')" class="forbidden">禁用</a>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </p>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                @elseif($cloud["cloud_type"]!=3)
                                    <div class="row">
                                        <div class="col-sm-9 col-md-6">
                                    <img alt="icon" class="rounded-circle margin-b-10" src="http://cloud.unioncms.cn//uploads/{{$cloud['icon']}}" width="60">
                                        </div>
                                        <div class="col-sm-3 col-md-6">
                                    <p class="lead margin-b-0 name">{{$cloud['name']}}</p>
                                    <p class="text-muted author">{{$cloud['author']}}</p>
                                    <p class="text-sm description">{{$cloud['description']}}</p>
                                    <input type="hidden" name="module_name" value="{{$cloud['name']}}" />
                                    <input type="hidden" name="identification" value="{{$cloud['identification']}}" />
                                    <input type="hidden" name="cloud_type" value="{{$cloud['cloud_type']}}" />
                                    @if($cloud['is_free'] == 0)
                                        @if($cloud['cloud_type'] == 0)
                                            @if(!in_array($cloud['identification'], $cloud_install_datas))
                                                <button class="btn btn-primary" onclick="downloadModule( this )">
                                                    <i class="demo-pli-male icon-fw"></i>
                                                    下载
                                                </button>
                                                <button class="btn btn-danger" onclick="uploadModuleVersion( this )">
                                                    <i class="demo-pli-male icon-fw"></i>
                                                    强制安装
                                                </button>
                                            @endif
                                        @elseif($cloud['cloud_type'] == 1)
                                            @if(!in_array($cloud['identification'], $cloud_install_datas))
                                                <button class="btn btn-primary" onclick="installApplication( this )">
                                                    <i class="demo-pli-male icon-fw"></i>
                                                    安装
                                                </button>
                                            @endif
                                        @elseif($cloud['cloud_type'] == 3)
                                            <button class="btn btn-primary" onclick="installThemeTemplate( this )">
                                                <i class="demo-pli-male icon-fw"></i>
                                                安装
                                            </button>
                                        @endif

                                        @if(!empty($cloud['releaselist']) && count($cloud['releaselist']) > 1)
                                            @if($cloud_install_lists)
                                                @foreach($cloud_install_lists as $local_cloud)
                                                    @if($local_cloud['identification'] == $cloud['identification'])
                                                        @if($local_cloud['version'] < $cloud['releaselist'][0]['version'])
                                                            <button class="btn btn-danger" onclick="uploadModuleVersion( this )">
                                                                <i class="demo-pli-male icon-fw"></i>
                                                                强制更新最新版
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif

                                        @if(in_array($cloud['identification'], $cloud_install_datas))
                                            <button class="btn btn-warning" onclick="unInstallApplication( this, {{$cloud["cloud_type"]}} )">
                                                <i class="demo-pli-male icon-fw"></i>
                                                卸载
                                            </button>
                                        @endif
                                    @else
                                        <button class="btn btn-primary buying">
                                            <i class="demo-pli-male icon-fw"></i>
                                            购买
                                        </button>
                                        <hr>
                                    @endif
                                    <ul class="list-unstyled margin-b-0 text-center row">
                                        @if($cloud['is_free'] == 0)
                                            <li class="col-lg-4 col-md-6  col-3">
                                                <span class="font-600">免费</span>
                                            </li>
                                        @else
                                            <li class="col-lg-4 col-md-6 col-3">
                                                <span class="font-600">付费</span>
                                                <p class="text-muted text-sm margin-b-0">{{$cloud['money']}}</p>
                                            </li>
                                        @endif
                                        <li class="col-lg-4 col-md-6 col-3">
                                            <span class="font-600">版本列表</span>
                                            <p class="text-muted text-sm margin-b-0">
                                                @if(!empty($cloud['releaselist']) && count($cloud['releaselist']) > 1)
                                                    <select name="version">
                                                        @foreach($cloud['releaselist'] as $release)
                                                            <option value="{{$release['version']}}">{{$release['version']}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select name="version">
                                                        <option value="{{$cloud['detail']['version']}}">{{$cloud['detail']['version']}}</option>
                                                    </select>
                                                @endif
                                            </p>
                                        </li>
                                        <li class="col-lg-4 col-md-6 col-3">
                                            <span class="font-600">应用类型</span>
                                            <p class="text-muted text-sm margin-b-0">
                                                {{$cloud_apps['cloud_type'][$cloud['cloud_type']]['value']}}
                                            </p>
                                        </li>
                                        <li class="col-lg-4 col-md-6 col-3">
                                            <span class="font-600">状态</span>
                                            <p class="text-muted text-sm margin-b-0">
                                            @if(in_array($cloud['identification'], $cloud_install_datas))
                                                @if($cloud['cloud_type'] == 3)
                                                    <!-- 主题模板 -->
                                                        <a href="{{url('admin/themes')}}" class="btn btn-danger"> 设置 </a>
                                                    @else
                                                        @if($cloud_install_lists)
                                                            @foreach($cloud_install_lists as $local_cloud)
                                                                @if($local_cloud['identification'] == $cloud['identification'])
                                                                    @if($local_cloud['status'] == 0)
                                                                        <a href="javascript:;" onclick="changeStatusQuestion(1, '{{url('admin/cloud/changeStatus?m='.$local_cloud['identification'].'&status=1')}}')" class="btn btn-success">启用</a>
                                                                    @else
                                                                        <a href="javascript:;" onclick="changeStatusQuestion(0, '{{url('admin/cloud/changeStatus?m='.$local_cloud['identification'].'&status=0')}}')" class="forbidden">禁用</a>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif
                                            </p>
                                        </li>
                                    </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        @if($cloud_apps['data']['last_page'] > 1)
            <div class="row">
                <div class="col-sm-12">
                    <nav aria-label="..." class="float-right">
                        <ul class="pagination">
                            <li class="page-item @if($params['page'] == 1) disabled @endif">
                                <a class="page-link" href="?page={{$cloud_apps['data']['current_page'] - 1}}" rel="next">上一页</a>
                            </li>
                            <li class="page-item @if($cloud_apps['data']['last_page'] == $params['page']) disabled @endif">
                                <a class="page-link" href="?page={{$cloud_apps['data']['current_page'] + 1}}" rel="next">下一页</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
    @endif

    @include('admin/'.ADMIN_SKIN.'/footer')

</section>
<!-- ============================================================== -->
<!-- 						Content End		 						-->
<!-- ============================================================== -->

<!-- Common Plugins -->
@include('admin/default/js',['load'=> ["custom"]])


<script type="text/javascript">
    //下载模块
    function downloadModule( _this ) {

        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: "确定要下载吗？",
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        var index = layer.load(1, {
                            shade: [0.5,'#000'] ,//0.1透明度的白色背景
                            content: '正在下载',
                            success: function (layero) {
                                layero.find('.layui-layer-content').css({
                                    'padding-top': '39px',
                                    'width': '80px',
                                    "color":"#FFF",
                                    "background-position":"center center"
                                });
                            }
                        });

                        window.location.href = "{{url('admin/feature/download')}}?module_name=" + $(_this).siblings('input[name=module_name]').val()
                            + '&version=' + $(_this).siblings('ul').find('select[name=version]').val() + '&identification=' + $(_this).siblings('input[name=identification]').val();

                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });
    }

    //更新模块
    function uploadModuleVersion( _this ) {

        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: "确定要强制更新吗？该操作会同步数据库!!",
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        var index = layer.load(1, {
                            shade: [0.5,'#000'] ,//0.1透明度的白色背景
                            content: '正在下载',
                            success: function (layero) {
                                layero.find('.layui-layer-content').css({
                                    'padding-top': '39px',
                                    'width': '80px',
                                    "color":"#FFF",
                                    "background-position":"center center"
                                });
                            }
                        });

                        window.location.href = "{{url('admin/feature/uploadModuleVersion')}}?module_name=" + $(_this).siblings('input[name=module_name]').val()
                            + '&version=' + $(_this).siblings('ul').find('select[name=version]').val() + '&identification=' + $(_this).siblings('input[name=identification]').val();

                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });
    }

    //插件
    function installApplication(_this)
    {

        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: "确定要下载吗？",
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){

                        var index = layer.load(1, {
                            shade: [0.5,'#000'] ,//0.1透明度的白色背景
                            content: '正在下载',
                            success: function (layero) {
                                layero.find('.layui-layer-content').css({
                                    'padding-top': '39px',
                                    'width': '80px',
                                    "color":"#FFF",
                                    "background-position":"center center"
                                });
                            }
                        });

                        window.location.href = "{{url('admin/plugin/downloadVersion')}}?app_name=" + $(_this).siblings('input[name=module_name]').val()
                            + '&version=' + $(_this).siblings('ul').find('select[name=version]').val() + '&identification=' + $(_this).siblings('input[name=identification]').val();

                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }

    //主题风格
    function installThemeTemplate(_this)
    {

        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: "确定要下载吗？",
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){

                        var index = layer.load(1, {
                            shade: [0.5,'#000'] ,//0.1透明度的白色背景
                            content: '正在下载',
                            success: function (layero) {
                                layero.find('.layui-layer-content').css({
                                    'padding-top': '39px',
                                    'width': '80px',
                                    "color":"#FFF",
                                    "background-position":"center center"
                                });
                            }
                        });

                        var params = "name=" + $(_this).siblings('input[name=module_name]').val()
                            + '&version=' + $(_this).siblings('ul').find('select[name=version]').val() + '&identification=' + $(_this).siblings('input[name=identification]').val() + '&cloud_type=' + $(_this).siblings('input[name=cloud_type]').val();
                        ajaxRequest("{{url('admin/themeTemplate/downloadVersion')}}?" + params);

                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }

    //卸载
    function unInstallApplication(_this, cloud_type)
    {
        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: '{{getTranslateByKey("common_sure_to_uninstall")}}',
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){

                        var index = layer.load(1, {
                            shade: [0.5,'#000'] ,//0.1透明度的白色背景
                            content: '正在卸载',
                            success: function (layero) {
                                layero.find('.layui-layer-content').css({
                                    'padding-top': '39px',
                                    'width': '80px',
                                    "color":"#FFF",
                                    "background-position":"center center"
                                });
                            }
                        });

                        switch(cloud_type)
                        {
                            case 0: //卸载功能模块
                                window.location.href = "{{url('admin/feature/uninstall')}}?m=" + $(_this).siblings('input[name=identification]').val();
                                break;
                            case 1:
                                window.location.href = "{{url('admin/plugin/uninstall')}}?m=" + $(_this).siblings('input[name=identification]').val();
                                break;
                            case 3:
                                window.location.href = "{{url('admin/themeTemplate/uninstall')}}?m=" + $(_this).siblings('input[name=identification]').val();
                                break;
                        }

                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });
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
                    action: function(){
                        location.href = url
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });
    }


    function ajaxRequest(url)
    {
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            "method":"post",
            "url": url ,
            "dataType":'json',
            "cache":false,
            "processData": false,
            "contentType": false,
            "success":function (res) {
                if(res.status==200){
                    layer.closeAll();
                    popup({type:"success",msg:res.msg,delay:2000});
                    setTimeout(function () {
                        location.reload();
                    },2000);
                }else{
                    popup({type:"error",msg:res.msg,delay:2000});
                }
            },
            "error":function (res) {
                console.log(res);
            }
        })
    }
</script>
</body>
</html>