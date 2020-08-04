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
            <li class="breadcrumb-item active">多货币</li>
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
                                        货币列表
                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/currency/add')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#id</th>
                                                <th>中文名</th>
                                                <th>英文代码</th>
                                                <th>符号代码</th>
                                                <th>费率</th>
                                                <th>符号位置</th>
                                                <th>创建时间</th>
                                                <th>更新时间</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($currency as $value)
                                                <tr>
                                                    <td>{{$value->id}}</td>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{$value->code}}</td>
                                                    <td>{{$value->symbol}}</td>
                                                    <td>{{$value->rate}}</td>
                                                    <td>{{$value->position==1?"前面":"后面"}}</td>
                                                    <td>{{$value->create_at}}</td>
                                                    <td>{{$value->update_at}}</td>
                                                    <td><a class="btn btn-teal" href="{{url('admin/currency/edit?id='.$value->id)}}">编辑</a> &nbsp;&nbsp;  @if($value->is_fix==0) <a class="btn btn-danger" href="javascript:;" onclick="delData({{$value->id}})">删除</a> @endif</td>
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
                                {{ $currency->links('globals.pagination.admin',['currency'=>$currency]) }}
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
            title: '温馨提示',
            content: '你确定要删除吗?',
            type: 'default',
            buttons: {
                ok: {
                    text: "确定",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        location.href="{{url('admin/currency')}}?id="+id;
                    }
                },
                cancel: {
                    text: "取消"
                }
            }
        });

    }
</script>