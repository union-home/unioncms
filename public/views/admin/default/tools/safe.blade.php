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
            <li class="breadcrumb-item active">{{getTranslateByKey("tool_security_setting")}}</li>
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
                            <div class="col-sm-12">
                                <div class="card">

                                    <div class="card-body">
                                        <form method="post" action="" id="safe_form">
                                            {{csrf_field()}}
                                            <div class="form-group breadcrumb row">
                                                <label for="inputEmail3" class="col-sm-1 col-form-label">{{getTranslateByKey("tool_routine_settings")}}</label>

                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("tool_cookie_name")}}</label>
                                                <input type="text" name="COOKIE_NAME" value="{{env('COOKIE_NAME')}}" placeholder="UnionCMS" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("tool_session_domain")}}</label>
                                                <input type="text" name="SESSION_DOMAIN" value="{{env('SESSION_DOMAIN')}}" placeholder="" class="form-control form-control-rounded">
                                            </div>



                                            <div class="form-group">
                                                <label>{{getTranslateByKey("tool_session_drive")}}</label>
                                                <select name="SESSION_DRIVER" class="form-control m-b">
                                                    <option value="file" @if(env('SESSION_DRIVER')=='file') selected @endif>File</option>
                                                    <option value="redis" @if(env('SESSION_DRIVER')=='redis') selected @endif>Redis</option>
                                                    <option value="memcached" @if(env('SESSION_DRIVER')=='memcached') selected @endif>Memcached</option>
                                                    <option value="database" @if(env('SESSION_DRIVER')=='database') selected @endif>Database</option>
                                                    <option value="apc" @if(env('SESSION_DRIVER')=='apc') selected @endif>Apc</option>
                                                    <option value="array" @if(env('SESSION_DRIVER')=='array') selected @endif>Array</option>

                                                </select>
                                            </div>

                                            <div class="form-group row">
                                                <label for="SESSION_LIFETIME" class="col-sm-1 col-form-label">{{getTranslateByKey("tool_session_lifetime")}}</label>
                                                <div class="col-sm-2">
                                                    <input class="form-control" id="SESSION_LIFETIME" name="SESSION_LIFETIME" value="{{env('SESSION_LIFETIME')}}" placeholder="{{getTranslateByKey("tool_session_lifetime")}}" type="number">
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="text-muted">
                                                        {{getTranslateByKey("common_minute")}}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>{{getTranslateByKey("tool_session_encrypt")}}</label>
                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="SESSION_ENCRYPT1" name="SESSION_ENCRYPT" value="false" type="radio" @if(env('SESSION_ENCRYPT')==false) checked @endif>
                                                        <label for="SESSION_ENCRYPT1"> {{getTranslateByKey("tool_session_no_encrypt")}} </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="SESSION_ENCRYPT2" name="SESSION_ENCRYPT" value="true" type="radio" @if(env('SESSION_ENCRYPT')==true) checked @endif>
                                                        <label for="SESSION_ENCRYPT2"> {{getTranslateByKey("tool_session_need_encrypt")}} </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>账号锁定</label>
                                                <div class="form-inline">


                                                    连续登录失败&nbsp;<input type="text" name="limit_count" value="{{cacheGlobalSettingsByKey('limit_count')}}" placeholder="" class="inline" style="max-width: 10%">&nbsp;次，锁定账号&nbsp;<input type="text" name="limit_time" value="{{cacheGlobalSettingsByKey('limit_time')}}" placeholder="" class="inline" style="max-width: 10%">&nbsp;分钟

                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>敏感字符过滤</label>
                                                <textarea placeholder="admin" name="filter_strings" class="form-text" rows="4" style="height: 100px;">{{cacheGlobalSettingsByKey('filter_strings')}}</textarea>
                                                <p class="text-muted">
                                                    敏感字符过滤，用|隔开！
                                                </p>
                                            </div>

                                            <div class="form-group ">
                                                <label>IP黑名单</label>
                                                <textarea placeholder="127.0.0.1" name="blacklist_ip" class="form-text" rows="4" style="height: 100px;">{{cacheGlobalSettingsByKey('blacklist_ip')}}</textarea>
                                                <p class="text-muted">
                                                    IP黑名单，用,隔开！
                                                </p>
                                            </div>

                                            <div class="form-group breadcrumb row">
                                                <label for="inputEmail3" class="col-sm-1 col-form-label">验证码</label>

                                            </div>

                                            <div class="form-group ">
                                                <label>后台登录验证码</label>

                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="admin_login_code1" name="admin_login_code" type="radio" value="1" @if(cacheGlobalSettingsByKey('admin_login_code')==1) checked @endif>
                                                        <label for="admin_login_code1"> 开启 </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="admin_login_code2" name="admin_login_code" type="radio" value="0" @if(cacheGlobalSettingsByKey('admin_login_code')==0) checked @endif>
                                                        <label for="admin_login_code2"> 关闭 </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>前台提交验证码</label>

                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="home_submit_code1" name="home_submit_code" type="radio" value="1" @if(cacheGlobalSettingsByKey('home_submit_code')==1) checked @endif>
                                                        <label for="home_submit_code1"> 开启 </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="home_submit_code2" name="home_submit_code" type="radio" value="0" @if(cacheGlobalSettingsByKey('home_submit_code')==0) checked @endif>
                                                        <label for="home_submit_code2"> 关闭 </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" id="safe_button" class="btn btn-primary margin-l-5 mx-sm-3">提交</button>

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

        $("#safe_button").click(function () {

            $.ajax({
                "method":"post",
                "url":"{{url('admin/toolSubmit?form=safe')}}",
                "data":$("#safe_form").serialize(),
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

        })
    })
</script>