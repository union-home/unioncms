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
            <li class="breadcrumb-item active">多语言</li>
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
                                        多语言列表
                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/language/add')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach($data as $key=>$val)
                                        <h5>
                                            @if($key=="admin")后台语言包@elseif($key=="home") 前台语言包 @elseif($key=="api") API语言包 @endif
                                        </h5>
                                        <div class="card-body">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td align="center" colspan="2">语言名称</td>
                                                    <td align="center" >语言图标</td>
                                                    <td align="center" >语言缩写</td>
                                                    <td align="center" >状态</td>
                                                    <td align="center" >备注</td>
                                                    <td align="center" >创建时间</td>
                                                    <td align="center" >操作</td>
                                                </tr>
                                                @foreach($val as $key1=>$val1)
                                                    <tr>
                                                        <td align="center" colspan="2">{{$val1['name']}}</td>
                                                        <td align="center" ><img src="{{UPLOADPATH.$val1['icon']}}" style="width: 30px; height:30px;"></td>
                                                        <td align="center" >{{$val1['shortcode']}}</td>
                                                        <td align="center" >{{$val1['status']==1?"启用":"禁用"}}</td>
                                                        <td align="center" >{{$val1['remarks']}}</td>
                                                        <td align="center" >{{$val1['create_at']}}</td>
                                                        <td align="center" >

                                                            <a href="{{url("admin/language/manage/".$val1['id'])}}" class="btn btn-teal">管理</a>&nbsp;

                                                            <a href="{{url("admin/language/edit/".$val1['id'])}}" class="btn btn-default">编辑</a>&nbsp;

                                                            {{--@if($val1['status']=="1")
                                                            <a href="javascript:;" class="btn btn-danger">禁用</a>&nbsp;
                                                            @elseif($val1['status']=="0")
                                                                <a href="javascript:;" class="btn btn-teal">启用</a>&nbsp;
                                                            @endif--}}

                                                            <a href="javascript:;" onclick="delData('{{$val1['id']}}')" class="btn btn-danger">删除</a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endforeach
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
                    action: function(){
                        location.href= "{{url('/admin/language/delete')}}"+"/"+id
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }
</script>