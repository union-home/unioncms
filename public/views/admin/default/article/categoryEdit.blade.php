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
            <li class="breadcrumb-item"><a href="#">内容管理</a></li>
            <li class="breadcrumb-item active">文字类别编辑</li>
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
                                            <input type="hidden" name="id" value="{{$data["id"]}}"/>
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_name")}}</label>
                                                <input type="text" name="name" value="{{$data["name"]}}"
                                                       class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_describe")}}</label>
                                                <input type="text" name="describe" value="{{$data["describe"]}}"
                                                       class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group">
                                                <label>{{getTranslateByKey("common_icon_type")}}</label>
                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="icon_type" name="icon_type" type="radio" value="css"
                                                               @if($data["icon_type"]=="css") checked @endif >
                                                        <label for="icon_type"> {{getTranslateByKey("common_icon_css_class")}} </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="icon_type2" name="icon_type" type="radio" value="img"
                                                               @if($data["icon_type"]=="img") checked @endif >
                                                        <label for="icon_type2"> {{getTranslateByKey("common_image")}} </label>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="form-group " id="icon_img_div"
                                                 @if($data["icon_type"]=="css") style="display: none;" @endif >
                                                <label>图标</label>
                                                <div class="fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview" data-trigger="fileinput"
                                                         style="width: 32px; height:32px;">

                                                    </div>
                                                    <span class="btn btn-primary  btn-file">
                                                                            <span class="fileinput-new">{{getTranslateByKey("common_select")}}</span>
                                                                            <span class="fileinput-exists">{{getTranslateByKey("common_change")}}</span>
                                                                            <input type="file" id="icon_img"
                                                                                   name="icon_img">
                                                                        </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput">{{getTranslateByKey("common_delete")}}</a>

                                                </div>
                                            </div>

                                            <div class="form-group " id="icon_css_div"
                                                 @if($data["icon_type"]=="img") style="display: none;" @endif>
                                                <label>图标</label>
                                                <input type="text" name="icon_css" value="{{$data["icon"]}}"
                                                       class="form-control form-control-rounded">
                                            </div>


                                            <button type="button" id="post_button"
                                                    class="btn btn-primary margin-l-5 mx-sm-3">{{getTranslateByKey("common_submit")}}</button>
                                            <button type="button" id="ton" onclick="history.go(-1);"
                                                    class="btn btn-default ">{{getTranslateByKey("common_back")}}</button>

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
    .ui-selectmenu-button.ui-button {
        width: 100em;
    }
</style>
</html>
<script>

    $(function () {

        $("input[name=icon_type]").change(function () {
            if ($(this).val() == "css") {
                $("#icon_css_div").show();
                $("#icon_img_div").hide();

            } else if ($(this).val() == "img") {
                $("#icon_css_div").hide();
                $("#icon_img_div").show();

            }
            ;
        })

        $("#post_button").click(function () {

            popup({
                type: 'load', msg: "正在请求", delay: 800, callBack: function () {

                    $.ajax({
                        "method": "post",
                        "url": "{{url('admin/ArticleSubmit?form=categoryEdit')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType": 'json',
                        "cache": false,
                        "processData": false,
                        "contentType": false,
                        "success": function (res) {

                            if (res.stauts == 200) {
                                popup({type: "success", msg: res.msg, delay: 2000});
                                setTimeout(function () {
                                    location.href = "{{url('admin/article/category')}}";
                                }, 2000);
                            } else {
                                popup({type: "error", msg: res.msg, delay: 2000});
                            }
                        },
                        "error": function (res) {
                            console.log(res);
                        }
                    })
                }
            });


        })

    })

</script>