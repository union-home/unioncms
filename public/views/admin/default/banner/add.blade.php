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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("advertising_management")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("banner_add")}}</li>
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

                                            <div class="form-group">
                                                <label>
                                                    {{--请求端--}}
                                                    {{getTranslateByKey("req_type")}}
                                                </label>
                                                <select name="req_type" class="form-control m-b">
                                                    @foreach(getReqType() as $key=>$val)
                                                        <option value="{{$key}}">{{$val}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group ">
                                                <label>
                                                    {{--图片--}}
                                                    {{getTranslateByKey("common_image")}}
                                                </label>
                                                <div class="fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview" data-trigger="fileinput"
                                                         style="width: 150px; height:150px;">
                                                    </div>
                                                    <span class="btn btn-primary  btn-file">
                                                        <span class="fileinput-new">
                                                            {{--选择--}}
                                                            {{getTranslateByKey("common_select")}}
                                                        </span>
                                                        <span class="fileinput-exists">
                                                            {{--更换--}}
                                                            {{getTranslateByKey("common_change")}}
                                                        </span>
                                                        <input type="file" id="images"
                                                               name="images">
                                                    </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput">
                                                        {{--删除--}}
                                                        {{getTranslateByKey("common_delete")}}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label>
                                                    {{--广告类型--}}
                                                    {{getTranslateByKey("advertising_type")}}
                                                </label>

                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="type1" name="type" type="radio" value="self"
                                                               checked>
                                                        <label for="type1">
                                                            {{--自带--}}
                                                            {{getTranslateByKey("bring_along")}}
                                                        </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="type" name="type" type="radio" value="jump">
                                                        <label for="type">
                                                            {{--跳转--}}
                                                            {{getTranslateByKey("advertising_roll")}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group ">
                                                <label>
                                                    {{--是否自营--}}
                                                    {{getTranslateByKey("is_it_self_run")}}
                                                </label>

                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="is_self_support" name="is_self_support" type="radio"
                                                               value="1" checked>
                                                        <label for="is_self_support">
                                                            {{--自营--}}
                                                            {{getTranslateByKey("self_support")}}
                                                        </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="is_self_support1" name="is_self_support" type="radio"
                                                               value="2">
                                                        <label for="is_self_support1">
                                                            {{--第三方--}}
                                                            {{getTranslateByKey("the_third_party")}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>
                                                    {{--是否需要登录--}}
                                                    {{getTranslateByKey("need_to_log_in")}}
                                                </label>

                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="need_login" name="need_login" type="radio" value="1">
                                                        <label for="need_login">
                                                            {{--需要--}}
                                                            {{getTranslateByKey("need")}}
                                                        </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="need_login1" name="need_login" type="radio" value="2"
                                                               checked>
                                                        <label for="need_login1">
                                                            {{--不需要--}}
                                                            {{getTranslateByKey("unwanted")}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group ">
                                                <label>
                                                    {{--是否公司内部--}}
                                                    {{getTranslateByKey("whether_within_the_company")}}
                                                </label>

                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="is_company" name="is_company" type="radio"
                                                               value="1" checked>
                                                        <label for="is_company">
                                                            {{--是--}}
                                                            {{getTranslateByKey("company_yes")}}
                                                        </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="is_company1" name="is_company" type="radio"
                                                               value="2">
                                                        <label for="is_company1">
                                                            {{--不是--}}
                                                            {{getTranslateByKey("company_no")}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>
                                                    {{--跳转链接--}}
                                                    {{getTranslateByKey("content_roll_url")}}
                                                </label>
                                                <input type="text" required name="url" value="#"
                                                       class="form-control form-control-rounded">
                                            </div>

                                            <button type="button" id="post_button"
                                                    class="btn btn-primary margin-l-5 mx-sm-3">
                                                {{getTranslateByKey("common_submit")}}
                                            </button>
                                            <button type="button" id="ton" onclick="history.go(-1);"
                                                    class="btn btn-default ">
                                                {{getTranslateByKey("common_back")}}
                                            </button>

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
        $("#post_button").click(function () {

            popup({
                type: 'load', msg: "正在请求", delay: 800, callBack: function () {

                    $.ajax({
                        "method": "post",
                        "url": "{{url('admin/banner/add')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType": 'json',
                        "cache": false,
                        "processData": false,
                        "contentType": false,
                        "success": function (res) {

                            if (res.status == 200) {
                                popup({type: "success", msg: res.msg, delay: 2000});
                                setTimeout(function () {
                                    location.href = "{{url('admin/banner')}}";
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
