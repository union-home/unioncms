@include("admin.".ADMIN_SKIN.".header")

<body class="horizontal">

<!-- ============================================================== -->
<!--                        Topbar Start                            -->
<!-- ============================================================== -->
@include("admin.".ADMIN_SKIN.".topbar")
<!-- ============================================================== -->
<!--                        Topbar End                              -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!--                        Navigation Start                        -->
<!-- ============================================================== -->

@include("admin.".ADMIN_SKIN.".nav")

<!-- ============================================================== -->
<!--                        Navigation End                          -->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!--                        Content Start                           -->
<!-- ============================================================== -->
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">

    </div>
</div>
<section class="main-content">
    <div class="row w-no-padding margin-b-30">
        <div class="col-md-3">
            <div class="widget  bg-light">
                <div class="row row-table ">
                    <div class="margin-b-30">
                        <h2 class="margin-b-5">会员总数</h2>
                        <p class="text-muted">总会员数</p>
                        <span class="float-right text-primary widget-r-m">{{$total_member}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget  bg-light">
                <div class="row row-table ">
                    <div class="margin-b-30">
                        <h2 class="margin-b-5">扩展总数</h2>
                        <p class="text-muted">插件+模块+主题</p>
                        <span class="float-right text-indigo widget-r-m">{{$total_extend}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget  bg-light">
                <div class="row row-table ">
                    <div class="margin-b-30">
                        <h2 class="margin-b-5">案例数量</h2>
                        <p class="text-muted">案例总数</p>
                        <span class="float-right text-success widget-r-m">{{$total_case}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget  bg-light">
                <div class="row row-table ">
                    <div class="margin-b-30">
                        <h2 class="margin-b-5">访问量</h2>
                        <p class="text-muted">总访问量</p>
                        <span class="float-right text-warning widget-r-m">{{$total_visit}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="7"><h4>{{getTranslateByKey("index_system_info")}}</h4></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td align="right" colspan="2" >{{getTranslateByKey("index_system_name")}}：</td>
                            <td align="left" >{{getenv("APP_NAME")}}</td>
                            <td align="right" >{{getTranslateByKey("index_system_version")}}：</td>
                            <td align="left" >{{env("APP_VERSION")}} &nbsp;&nbsp;&nbsp;
                                @if($check_cms_version = cache("check_cms_version_update"))
                                    @if(!empty($check_cms_version['data']['version']) && $check_cms_version['data']['version'] != getenv("APP_VERSION"))
                                        <button class="btn btn-teal" type="button" onclick="cmsUpdateVersion('{{$check_cms_version['data']['version']}}')">更新</button>
                                    @endif
                                @endif
                            </td>
                            <td align="right" >{{getTranslateByKey("index_system_language_framework")}}：</td>
                            <td align="left" >Laravel Framework {{app()::VERSION}}</td>
                        </tr>

                        <tr>
                            <td align="right" colspan="2">{{getTranslateByKey("index_system_time")}}：</td>
                            <td align="left" >{{date("Y-m-d H:i:s")}}</td>
                            <td align="right" >{{getTranslateByKey("index_system_server_os")}}：</td>
                            <td align="left" >{{PHP_OS}}</td>
                            <td align="right" >{{getTranslateByKey("index_mysql_version")}}：</td>
                            <td align="left" >{{$version}}</td>
                        </tr>

                        <tr>
                            <td align="right" colspan="2">{{getTranslateByKey("index_php_version")}}：</td>
                            <td align="left" >{{PHP_VERSION}}</td>
                            <td align="right" >{{getTranslateByKey("index_gd_version")}}：</td>
                            <td align="left" >{{$gdinfo}}</td>
                            <td align="right" >FreeType：</td>
                            <td align="left" >{{$freetype}}</td>
                        </tr>

                        <tr>
                            <td align="right" colspan="2">{{getTranslateByKey("index_allow_curl")}}：</td>
                            <td align="left" >{{$allowurl}}</td>
                            <td align="right" >{{getTranslateByKey("index_max_upload_limit")}}：</td>
                            <td align="left" >{{$max_upload}}</td>
                            <td align="right" >{{getTranslateByKey("index_max_run_time")}}：</td>
                            <td align="left" >{{$max_ex_time}}</td>
                        </tr>

                        <tr>
                            <td align="right" colspan="2">{{getTranslateByKey("index_max_run_memory")}}：</td>
                            <td align="left" >{{$memory_limit}}</td>
                            <td align="right" ></td>
                            <td align="left" ></td>
                            <td align="right" ></td>
                            <td align="left" ></td>
                        </tr>




                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="7"><h4>{{getTranslateByKey("index_system_team")}}</h4></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td align="center" colspan="2">技术总监：</td>
                            <td align="center" >Henry Huang</td>
                            <td align="center" >项目负责人：</td>
                            <td align="center" >Henry Huang，Alun Liu</td>
                            <td align="center" >组长：</td>
                            <td align="center" >Mr He</td>
                        </tr>

                        <tr>
                            <td align="center" colspan="2">公司名称：</td>
                            <td align="center" >联盟之都网络科技（深圳）有限公司</td>
                            <td align="center" >CMS官网：</td>
                            <td align="center" ><a href="http://www.unioncms.cn">www.unioncms.cn</a></td>
                            <td align="center" >公司官网：</td>
                            <td align="center" ><a href="http://www.union-home.cn">www.union-home.cn</a></td>
                        </tr>


                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>




    @include('admin/'.ADMIN_SKIN.'/footer')




</section>
<!-- ============================================================== -->
<!--                        Content End                             -->
<!-- ============================================================== -->


<!-- Common Plugins -->
@include('admin/'.ADMIN_SKIN.'/js',['load'=> ["custom"]])

</body>
</html>