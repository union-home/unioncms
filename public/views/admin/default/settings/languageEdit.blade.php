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
            <li class="breadcrumb-item active">多语言编辑</li>
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
                                        <form method="post" action="" id="post_form" enctype="multipart/form-data" >
                                            {{csrf_field()}}
                                            <input type="hidden" name="id" value="{{$data["id"]}}" />

                                            <div class="form-group ">
                                                <label for="simple-button">语言包类型</label>
                                                <div>
                                                    <select name="type"  id="simple" disabled="true" style="display: none;">
                                                        <option value="api" @if($data["type"]=="api")selected="selected"@endif>API语言包</option>
                                                        <option value="admin" @if($data["type"]=="admin")selected="selected"@endif>后台语言包</option>
                                                        <option value="home" @if($data["type"]=="home")selected="selected"@endif >前台语言包</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>语言名字</label>
                                                <input type="text" name="name" readonly value="{{$data["name"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>语言缩写</label>
                                                <input type="text" name="shortcode" readonly value="{{$data["shortcode"]}}" class="form-control form-control-rounded">
                                            </div>


                                            <div class="form-group ">
                                                <label>备注</label>
                                                <input type="text" name="remarks" value="{{$data["remarks"]}}" class="form-control form-control-rounded">
                                            </div>


                                            <div class="form-group ">
                                                <label>状态</label>

                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="phone_active" type="radio" name="status" @if($data["status"]=="1") checked @endif  value="1" >
                                                        <label for="phone_active"> 启用 </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="phone_active1" type="radio" name="status" @if($data["status"]=="0") checked @endif value="0" >
                                                        <label for="phone_active1"> 禁用 </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>语言图标</label>
                                                <div class="fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview" data-trigger="fileinput" style="width: 80px; height:80px;">
                                                        <img src="{{UPLOADPATH.$data['icon']}}" style="width: 70px; height:70px;">
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

        $("#post_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/languageSubmit?form=edit')}}",
                        "data": new FormData($('#post_form')[0]),                   //$("#post_form").serialize(),
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