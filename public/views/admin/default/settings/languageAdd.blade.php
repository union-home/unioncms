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
            <li class="breadcrumb-item active">多语言添加</li>
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

                                    <div class="card-body">
                                        <form method="post" action="" id="post_form" enctype="multipart/form-data">
                                            {{csrf_field()}}


                                            <div class="form-group ">
                                                <label>语言包类型</label>
                                                <div>
                                                    <select name="type" id="type">
                                                        <option value="api">API语言包</option>
                                                        <option value="admin" selected="selected">后台语言包</option>
                                                        <option value="home">前台语言包</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>复制语言包</label>
                                                <div>
                                                    <select name="copy" id="copy">
                                                        <@foreach($language as $val)
                                                        <option value="{{$val["id"]}}">{{$val["name"]}}</option>
                                                        <@endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>语言名字</label>
                                                <input type="text" name="name" value="" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>语言缩写</label>
                                                <input type="text" name="shortcode" value="" class="form-control form-control-rounded">
                                            </div>


                                            <div class="form-group ">
                                                <label>备注</label>
                                                <input type="text" name="remarks" value="" class="form-control form-control-rounded">
                                            </div>


                                            <div class="form-group ">
                                                <label>状态</label>

                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="phone_active" type="radio" name="status" checked value="1" >
                                                        <label for="phone_active"> 启用 </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="phone_active1" type="radio" name="status" value="0" >
                                                        <label for="phone_active1"> 禁用 </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>语言图标</label>
                                                <div class="fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview" data-trigger="fileinput" style="width: 80px; height:80px;">
                                                    </div>
                                                    <span class="btn btn-primary  btn-file">
                                                        <span class="fileinput-new">选择</span>
                                                        <span class="fileinput-exists">修改</span>
                                                        <input type="file" id="image" name="icon">
                                                    </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">删除</a>
                                                </div>
                                            </div>


                                            <button type="button" id="post_button" class="btn btn-primary margin-l-5 mx-sm-3">提交</button>
                                            <button type="button" id="ton" onclick="history.go(-1);" class="btn btn-default ">返回</button>

                                        </form>
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
<style>
    .ui-selectmenu-button.ui-button{
        width: 100em;
    }
</style>
</html>
<script>

    $(function () {

        //联动语言包
        $("#type").change(function () {
            var type_val = $(this).val();
            if(type_val){
                $.ajax({
                    "method":"post",
                    "url":"{{url('admin/getLanguageByType')}}",
                    "data":{"type":type_val,"_token":"{{csrf_token()}}"},
                    "dataType":'html',
                    "success":function (res) {

                        $("#copy").empty().append(res);
                    },
                    "error":function (res) {
                        console.log(res);
                    }
                })

            }
            
        });
        $("#post_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/languageSubmit?form=add')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType":'json',
                        "cache":false,
                        "processData": false,
                        "contentType": false,
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});
                                setTimeout(function () {
                                    location.href="{{url('admin/language')}}";
                                },2000);
                            }else{
                                popup({type:"error",msg:res.msg,delay:2000});
                            }
                        },
                        "error":function (res) {
                            console.log(res);
                        }
                    })
                }});



        })

    })

</script>