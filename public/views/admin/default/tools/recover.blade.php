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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("tool_safety_and_tools")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("tool_data_maintain")}}</li>
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

                                            <a href="{{url('admin/tables')}}" class="btn btn-default">{{getTranslateByKey("tool_table_maintain")}}</a>
                                            <a href="{{url('admin/recover')}}" class="btn btn-primary">{{getTranslateByKey("tool_backup_recovery")}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post" id="table_form">
                                            {{csrf_field()}}
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="all" /></th>
                                                    <th>{{getTranslateByKey("common_filename")}}</th>
                                                    <th>{{getTranslateByKey("common_file_type")}}</th>
                                                    <th>{{getTranslateByKey("common_create_at")}}</th>
                                                    <th>{{getTranslateByKey("common_size")}}</th>
                                                    <th>{{getTranslateByKey("common_action")}}</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($files as $val)
                                                    <tr>
                                                        <td><input type="checkbox" name="table[]" value="{{$val}}" /></td>
                                                        <td>{{$val}}</td>
                                                        <td>{{filetype($basedir.$val)}}</td>
                                                        <td>{{date('Y-m-d H:i:s',filectime($basedir.$val))}}</td>
                                                        <td>{{round(filesize($basedir.$val)/1024,3)}}KB</td>
                                                        <td><a href="javascript:;" onclick="dotableone('recover','{{$val}}')" class="btn btn-primary">{{getTranslateByKey("common_import")}}</a>  <a href="javascript:;" onclick="dotableone('del','{{$val}}')" class="btn btn-danger">{{getTranslateByKey("common_delete")}}</a></td>
                                                    </tr>
                                                @endforeach

                                                @if(!$files)
                                                    <tr>
                                                        <td colspan="6" align="center">{{getTranslateByKey("common_no_data")}}</td>
                                                    </tr>
                                                @endif


                                                </tbody>
                                            </table>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="table_repair" onclick="dotable('del')" class="btn btn-primary">{{getTranslateByKey("common_delete")}}</button>
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


                alert(res.msg);

                if(res.stauts==200){


                }else{

                }

            },
            "error":function (res) {
                console.log(res);
            }
        })
    }

    function dotableone(form,filename) {

        $.ajax({
            "method":"post",
            "url":"{{url('admin/tableSubmit')}}?form="+form+"&filename="+filename,
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