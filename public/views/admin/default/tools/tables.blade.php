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
            <li class="breadcrumb-item"><a href="#">安全与工具</a></li>
            <li class="breadcrumb-item active">数据维护</li>
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
                                        <div class="buttons">

                                            <a href="{{url('admin/tables')}}" class="btn btn-primary">数据表维护</a>
                                            <a href="{{url('admin/recover')}}" class="btn btn-default">备份恢复</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post" id="table_form">
                                            {{csrf_field()}}
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="all" /></th>
                                                    <th>数据表</th>
                                                    <th>记录行</th>
                                                    <th>数据长度</th>
                                                    <th>引擎</th>
                                                    <th>修改日期</th>
                                                    <th>排序规则</th>
                                                    <th>注释</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($tables as $val)
                                                    <tr>
                                                        <td><input type="checkbox" name="table[]" value="{{$val->Name}}" /></td>
                                                        <td>{{$val->Name}}</td>
                                                        <td>{{$val->Rows}}</td>
                                                        <td>{{$val->Data_length/1024}}KB</td>
                                                        <td>{{$val->Engine}}</td>
                                                        <td>{{$val->Create_time}}</td>
                                                        <td>{{$val->Collation}}</td>
                                                        <td>{{$val->Comment}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="table_optimize" onclick="dotable('optimize')" class="btn btn-primary">优化表</button>
                                <button type="button" id="table_repair" onclick="dotable('repair')" class="btn btn-primary">修复表</button>
                                <button type="button" id="table_backup" onclick="dotable('backup')" class="btn btn-primary">备份表</button>
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
    
    function dotable(form) {

        $.ajax({
            "method":"post",
            "url":"{{url('admin/tableSubmit')}}?form="+form,
            "data":$("#table_form").serialize(),
            "dataType":'json',
            "success":function (res) {
                console.log(res);
                if(res.stauts==200){

                }else{

                }

                alert(res.msg);

            },
            "error":function (res) {
                console.log(res);
            }
        })
    }

    $(function () {

        $("#all").click(function(){
             // this 全选的复选框
             var checked=this.checked;
             //获取name=box的复选框 遍历输出复选框
             $("input[name='table[]']").each(function(){
                     this.checked=checked;
                 });
         });

    })
</script>