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
            <li class="breadcrumb-item active">{{getTranslateByKey("home_nav_edit")}}</li>
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


                                            <input type="hidden" name="id" value="{{$data["id"]}}" />
                                            <input type="hidden" name="type" value="home" />
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_name")}}</label>
                                                <input type="text" name="name" value="{{$data["name"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_link")}}</label>
                                                <input type="text" name="path" value="{{$data["path"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_level")}}</label>
                                                <select name="pid" class="form-control m-b">

                                                    <option value='0' @if($data["pid"]==0) selected @endif   >{{getTranslateByKey("common_top_nav")}}</option>

                                                    {{getTreeData($menu,$data["pid"])}}

                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>{{getTranslateByKey("pre_icon_type")}}</label>
                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="pre_icon_type" name="pre_icon_type" type="radio" value="css" @if($data["pre_icon_type"]=="css") checked @endif >
                                                        <label for="pre_icon_type"> {{getTranslateByKey("common_icon_css_class")}} </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="pre_icon_type2" name="pre_icon_type" type="radio" value="img" @if($data["pre_icon_type"]=="img") checked @endif >
                                                        <label for="pre_icon_type2"> {{getTranslateByKey("common_image")}} </label>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="form-group " id="pre_icon_img_div" @if($data["pre_icon_type"]=="css") style="display: none;" @endif>
                                                <label>{{getTranslateByKey("common_pre_icon")}}</label>
                                                <div class="fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview" data-trigger="fileinput" style="width: 32px; height:32px;">

                                                    </div>
                                                    <span class="btn btn-primary  btn-file">
                                                                            <span class="fileinput-new">{{getTranslateByKey("common_select")}}</span>
                                                                            <span class="fileinput-exists">{{getTranslateByKey("common_change")}}</span>
                                                                            <input type="file" id="pre_icon_img" name="pre_icon_img">
                                                                        </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">{{getTranslateByKey("common_delete")}}</a>

                                                </div>
                                            </div>

                                            <div class="form-group " id="pre_icon_css_div" @if($data["pre_icon_type"]=="img") style="display: none;" @endif >
                                                <label>{{getTranslateByKey("common_pre_icon")}}</label>
                                                <input type="text" name="pre_icon_css" value="" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group">
                                                <label>{{getTranslateByKey("suf_icon_type")}}</label>
                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="suf_icon_type" name="suf_icon_type" type="radio" value="css" @if($data["suf_icon_type"]=="css") checked @endif >
                                                        <label for="suf_icon_type"> {{getTranslateByKey("common_icon_css_class")}} </label>
                                                    </div>
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="suf_icon_type2" name="suf_icon_type" type="radio" value="img" @if($data["suf_icon_type"]=="img") checked @endif >
                                                        <label for="suf_icon_type2"> {{getTranslateByKey("common_image")}} </label>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group" id="suf_icon_img_div" @if($data["suf_icon_type"]=="css") style="display: none;" @endif>
                                                <label>{{getTranslateByKey("common_suf_icon")}}</label>
                                                <div class="fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview" data-trigger="fileinput" style="width: 32px; height:32px;">

                                                    </div>
                                                    <span class="btn btn-primary  btn-file">
                                                                            <span class="fileinput-new">{{getTranslateByKey("common_select")}}</span>
                                                                            <span class="fileinput-exists">{{getTranslateByKey("common_change")}}</span>
                                                                            <input type="file" id="suf_icon_img" name="suf_icon_img">
                                                                        </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">{{getTranslateByKey("common_delete")}}</a>

                                                </div>
                                            </div>

                                            <div class="form-group " id="suf_icon_css_div" @if($data["suf_icon_type"]=="img") style="display: none;" @endif>
                                                <label>{{getTranslateByKey("common_suf_icon")}}</label>
                                                <input type="text" name="suf_icon_css" value="" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>选中标识</label>
                                                <input type="text" name="selected" value="{{$data["selected"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>排序（值越大，越靠前）</label>
                                                <input type="text" name="order" value="{{$data["order"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group">
                                                <label>{{getTranslateByKey("common_status")}}</label>
                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="stauts" name="stauts" type="radio" value="1" @if($data["stauts"]==1) checked @endif >
                                                        <label for="stauts"> {{getTranslateByKey("common_open")}} </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="stauts2" name="stauts" type="radio" value="0" @if($data["stauts"]==0) checked @endif>
                                                        <label for="stauts"> {{getTranslateByKey("common_close")}} </label>
                                                    </div>
                                                </div>
                                            </div>









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
<style>
    .ui-selectmenu-button.ui-button{
        width: 100em;
    }
</style>
</html>
<script>

    $(function () {

        $("input[name=pre_icon_type]").change(function () {
            if($(this).val()=="css"){
                $("#pre_icon_css_div").show();
                $("#pre_icon_img_div").hide();

            }else if($(this).val()=="img"){
                $("#pre_icon_css_div").hide();
                $("#pre_icon_img_div").show();

            };
        })

        $("input[name=suf_icon_type]").change(function () {
            if($(this).val()=="css"){
                $("#suf_icon_css_div").show();
                $("#suf_icon_img_div").hide();

            }else if($(this).val()=="img"){
                $("#suf_icon_css_div").hide();
                $("#suf_icon_img_div").show();

            };
        })


        $("#post_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/menuSubmit?form=edit')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType":'json',
                        "cache":false,
                        "processData": false,
                        "contentType": false,
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});
                                setTimeout(function () {
                                    location.href="{{url('admin/menu/home')}}";
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