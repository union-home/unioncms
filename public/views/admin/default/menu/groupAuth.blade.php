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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("common_system_setting")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("auth_manage")}}</li>
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
                                        {{getTranslateByKey("auth_config")}}
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="" id="post_form" enctype="multipart/form-data">
                                            <input type="hidden" name="gid" value="{{$gid}}" />
                                            {{csrf_field()}}
                                            @foreach($function as $value)

                                                <section class="auth_div">
                                                    <label for="label-{{$value["id"]}}"><input type="checkbox" class="F-1" name="fid_list[]" value="{{$value["id"]}}" @if(in_array($value["id"],$fid_lists)) checked @endif id="label-{{$value["id"]}}" /> {{$value["name"]}}</label>
                                                    <div class="row auth_div_sub">
                                                        @if(isset($value["sub"]))
                                                            @foreach($value["sub"] as $val)

                                                                @if(isset($val["sub"]))
                                                                    <div class="row col-sm-12">
                                                                        <div class="row col-sm-12" style="height: 30px;line-height: 30px;">&nbsp;&nbsp;&nbsp;&nbsp;<label for="label-{{$val["id"]}}"><input type="checkbox" class="F-2" name="fid_list[]" value="{{$val["id"]}}" @if(in_array($val["id"],$fid_lists)) checked @endif id="label-{{$val["id"]}}" style="float: left;margin-top: 8px;" />&nbsp; {{$val["name"]}}</label></div>
                                                                        <div class="row col-sm-12">

                                                                            @foreach($val["sub"] as $val2)
                                                                                <div class="col-sm-2">
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="label-{{$val2["id"]}}"><input type="checkbox" class=" FF-2 FF-sub" name="fid_list[]" value="{{$val2["id"]}}" @if(in_array($val2["id"],$fid_lists)) checked @endif id="label-{{$val2["id"]}}" /> {{$val2["name"]}}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-sm-2" style="height: 30px;line-height: 30px;">
                                                                        <label for="label-{{$val["id"]}}"><input type="checkbox" class="FF-1 FF-sub" name="fid_list[]" value="{{$val["id"]}}" @if(in_array($val["id"],$fid_lists)) checked @endif id="label-{{$val["id"]}}" /> {{$val["name"]}}</label>
                                                                    </div>
                                                                @endif

                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </section>

                                            @endforeach

                                            <button type="button" id="post_button" class="btn btn-primary margin-l-5 mx-sm-3">{{getTranslateByKey("common_submit")}}</button>
                                            <button type="button" id="ton" onclick="history.go(-1);" class="btn btn-default ">{{getTranslateByKey("common_back")}}</button>

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
<style>
    .auth_div{
        margin-bottom: 20px;
    }
    .auth_div > label {
        font-weight: bold;
        font-size: 16px;
    }
    .auth_div_sub{
        padding: 0 20px;
    }
</style>
<script>
    $(function () {
        $("#post_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/menuSubmit?form=groupAuth')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType":'json',
                        "cache":false,
                        "processData": false,
                        "contentType": false,
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});

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


        //多选框操作
        $(".F-1").change(function () {
            //if($(this).is(":checked")==true){}
            $(this).parent().parent().find("input[type='checkbox']").prop("checked",this.checked);
        })

        $(".F-2").change(function () {
            //if($(this).is(":checked")==true){}
            $(this).parent().parent().parent().find("input[type='checkbox']").prop("checked",this.checked);
            if($(this).is(":checked")==true){
                $(this).parent().parent().parent().parent().parent().find(".F-1").prop("checked",true);
            }else{

                if($(this).parent().parent().parent().parent().parent().find(".FF-sub:checked").length==0){
                    $(this).parent().parent().parent().parent().parent().find(".F-1").prop("checked",false);
                }
            }

        })
        
        $(".FF-1").change(function () {
            if($(this).is(":checked")==true){
                $(this).parent().parent().parent().parent().find(".F-1").prop("checked",true);
            }else{

                if($(this).parent().parent().parent().parent().find(".FF-sub:checked").length==0){
                    $(this).parent().parent().parent().parent().find(".F-1").prop("checked",false);
                }
            }
        })

        $(".FF-2").change(function () {
            if($(this).is(":checked")==true){
                $(this).parent().parent().parent().parent().find(".F-2").prop("checked",true);
                $(this).parent().parent().parent().parent().parent().parent().find(".F-1").prop("checked",true);
            }else{

                if($(this).parent().parent().parent().parent().parent().parent().find(".FF-sub:checked").length==0){
                    $(this).parent().parent().parent().parent().parent().parent().find(".F-1").prop("checked",false);
                }

                if($(this).parent().parent().parent().parent().find(".FF-sub:checked").length==0){
                    $(this).parent().parent().parent().parent().find(".F-2").prop("checked",false);
                }
            }
        })

    })
</script>

