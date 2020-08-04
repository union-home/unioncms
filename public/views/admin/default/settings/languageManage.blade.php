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
            <li class="breadcrumb-item active">多语言管理</li>
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

                                        <form method="post" autocomplete="off" action="" id="post_form">

                                            <div class="card-header card-default">
                                                {{$language["name"]}}（@if($language["type"]=="admin")后台语言包@elseif($language["type"]=="home") 前台语言包 @elseif($language["type"]=="api") API语言包 @endif）
                                            </div>


                                            {{csrf_field()}}

                                            <input type="hidden" name="id" value="{{$language["id"]}}" />
                                            <input type="hidden" name="type" value="{{$language["type"]}}" />



                                            <div class="form-group ">
                                                <input type="text"  placeholder="快速搜索语言" value="" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group breadcrumb row">
                                                <label for="" class="col-sm-12 col-form-label">数据列表</label>
                                            </div>

                                            <section id="data_div">
                                                @foreach($data as $key=>$val)
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <div class="form-group ">
                                                                <input type="text" onchange="changeKey($(this))" value="{{$key}}" class="margin-l-5">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-5">
                                                            <div class="form-group ">
                                                                <input type="text" name="{{$key}}" value="{{$val}}" class="margin-l-5 change-key">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <div class="form-group ">
                                                                <i class=" fa fa-trash-o del_user" onclick="remove_div($(this))"></i>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </section>





                                            <button type="button" id="post_button" class="btn btn-primary margin-l-5 mx-sm-3">提交</button>
                                            <button type="button" id="add_button" class="btn btn-info margin-l-5 mx-sm-3">添加</button>
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

    <div style="display: none;" id="hide_div">

        <div class="row">
            <div class="col-sm-5">
                <div class="form-group ">
                    <input type="text" onchange="changeKey($(this))" class="margin-l-5">
                </div>
            </div>

            <div class="col-sm-5">
                <div class="form-group ">
                    <input type="text" name="" value="" class="margin-l-5 change-key">
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group ">
                    <i class=" fa fa-trash-o del_user" onclick="remove_div($(this))"></i>
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
    .del_user{margin-top: 9px;font-size: 20px;}
</style>
</html>
<script>

    //值改变
    function changeKey(_this) {
        _this.parent().parent().parent().find('.change-key').attr('name',_this.val())
    }
    //移除
    function remove_div(_this) {
        _this.parent().parent().parent().remove();
    }

    $(function () {

        //提交
        $("#post_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/languageSubmit?form=ManageUpdate')}}",
                        "data":$("#post_form").serialize(),
                        "dataType":'json',
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});
                                setTimeout(function () {
                                    //location.href="{{url('admin/language')}}";
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

        //添加
        $("#add_button").click(function () {



            $("#data_div").append($("#hide_div").html());
        })

    })

</script>