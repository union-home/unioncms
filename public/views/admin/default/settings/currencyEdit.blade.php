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
            <li class="breadcrumb-item active">货币编辑</li>
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
                                        <form method="post" action="" id="currency_form">
                                            {{csrf_field()}}
                                            <input name="id" type="hidden" value="{{$currency["id"]}}" />
                                            <div class="form-group ">
                                                <label>中文名</label>
                                                <input type="text" name="name" value="{{$currency["name"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>英文代码</label>
                                                <input type="text" name="code" value="{{$currency["code"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>费率</label>
                                                <input type="text" name="rate" value="{{$currency["rate"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>符号代码</label>
                                                <input type="text" name="symbol" value="{{$currency["symbol"]}}" class="form-control form-control-rounded">
                                            </div>


                                            <div class="form-group ">
                                                <label>符号位置</label>

                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="phone_active" type="radio" name="position" @if($currency["position"]==1) checked @endif  value="1" >
                                                        <label for="phone_active"> 前面 </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="phone_active1" type="radio" name="position" @if($currency["position"]==2) checked @endif value="2" >
                                                        <label for="phone_active1"> 后面 </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <button type="button" id="currency_button" class="btn btn-primary margin-l-5 mx-sm-3">提交</button>
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
</html>
<script>

    $(function () {

        $("#currency_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/currencySubmit?form=edit')}}",
                        "data":$("#currency_form").serialize(),
                        "dataType":'json',
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});
                                setTimeout(function () {
                                    location.href="{{url('admin/currency')}}";
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