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
            <li class="breadcrumb-item active">{{getTranslateByKey("tool_cache_settings")}}</li>
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
                                        <form method="post" action="" id="cache_form">

                                            {{csrf_field()}}
                                            <div class="form-group ">
                                                <label for="CACHE_PREFIX">{{getTranslateByKey("tool_cache_pro")}}</label>
                                                <input type="text" name="CACHE_PREFIX" id="CACHE_PREFIX" value="{{env('CACHE_PREFIX')}}" placeholder="{{getTranslateByKey("tool_cache_pro")}}" class="form-control form-control-rounded">
                                            </div>

                                            {{--<div class="form-group ">
                                                <label>缓存时长</label>
                                                <input type="text" placeholder="5" class="form-control form-control-rounded">
                                            </div>--}}

                                            <div class="form-group">
                                                <label>{{getTranslateByKey("tool_cache_mode")}}</label>
                                                <select name="CACHE_DRIVER" class="form-control m-b">
                                                    <option value="file" @if(env('CACHE_DRIVER')=='file') selected @endif>File</option>
                                                    <option value="redis" @if(env('CACHE_DRIVER')=='redis') selected @endif>Redis</option>
                                                    <option value="memcached" @if(env('CACHE_DRIVER')=='memcached') selected @endif>Memcached</option>
                                                    <option value="database" @if(env('CACHE_DRIVER')=='database') selected @endif>Database</option>
                                                    <option value="apc" @if(env('CACHE_DRIVER')=='apc') selected @endif>Apc</option>
                                                    <option value="array" @if(env('CACHE_DRIVER')=='array') selected @endif>Array</option>


                                                </select>
                                            </div>

                                            <section>
                                                <div class="form-group breadcrumb row">
                                                    <label for="" class="col-sm-12 col-form-label">{{getTranslateByKey("tool_redis_settings")}}</label>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="REDIS_HOST" class="col-sm-3 col-form-label">{{getTranslateByKey("common_redis_host")}}</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" id="REDIS_HOST" name="REDIS_HOST" value="{{env('REDIS_HOST')}}" placeholder="127.0.0.1" type="text">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="text-muted">
                                                            {{getTranslateByKey("common_redis_host")}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="REDIS_PASSWORD" class="col-sm-3 col-form-label">{{getTranslateByKey("common_redis_password")}}</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" id="REDIS_PASSWORD" name="REDIS_PASSWORD" value="{{env('REDIS_PASSWORD')}}" placeholder="" type="text">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="text-muted">
                                                            {{getTranslateByKey("common_redis_password")}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="REDIS_PORT" class="col-sm-3 col-form-label">{{getTranslateByKey("common_redis_port")}}</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" id="REDIS_PORT" name="REDIS_PORT" value="{{env('REDIS_PORT')}}" placeholder="6379" type="text">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="text-muted">
                                                            {{getTranslateByKey("common_redis_port")}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </section>

                                            <section>
                                                <div class="form-group breadcrumb row">
                                                    <label for="" class="col-sm-12 col-form-label">{{getTranslateByKey("tool_memcache_settings")}}</label>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="MEMCACHED_HOST" class="col-sm-3 col-form-label">{{getTranslateByKey("common_memcache_host")}}</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" id="MEMCACHED_HOST" name="MEMCACHED_HOST" value="{{env('MEMCACHED_HOST')}}" placeholder="127.0.0.1" type="text">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="text-muted">
                                                            {{getTranslateByKey("common_memcache_host")}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="MEMCACHED_USERNAME" class="col-sm-3 col-form-label">{{getTranslateByKey("common_memcache_username")}}</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" id="MEMCACHED_USERNAME" name="MEMCACHED_USERNAME" value="{{env('MEMCACHED_USERNAME')}}" placeholder="{{getTranslateByKey("common_memcache_username")}}" type="text">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="text-muted">
                                                            {{getTranslateByKey("common_memcache_username")}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="MEMCACHED_PASSWORD" class="col-sm-3 col-form-label">{{getTranslateByKey("common_memcache_password")}}</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" id="MEMCACHED_PASSWORD" name="MEMCACHED_PASSWORD" value="{{env('MEMCACHED_PASSWORD')}}" placeholder="{{getTranslateByKey("common_memcache_password")}}" type="text">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="text-muted">
                                                            {{getTranslateByKey("common_memcache_password")}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="MEMCACHED_PORT" class="col-sm-3 col-form-label">{{getTranslateByKey("common_memcache_port")}}</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" id="MEMCACHED_PORT" name="MEMCACHED_PORT" value="{{env('MEMCACHED_PORT')}}" placeholder="11211" type="text">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="text-muted">
                                                            {{getTranslateByKey("common_memcache_port")}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </section>

                                            <button type="button" id="cache_button" class="btn btn-primary margin-l-5 mx-sm-3">{{getTranslateByKey("common_submit")}}</button>

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

        $("#cache_button").click(function () {

            $.ajax({
                "method":"post",
                "url":"{{url('admin/toolSubmit?form=cache')}}",
                "data":$("#cache_form").serialize(),
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