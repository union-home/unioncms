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
            <li class="breadcrumb-item"><a href="#">安全与工具</a></li>
            <li class="breadcrumb-item active">上传配置</li>
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
                                        <form action="" method="post" id="upload_form">

                                            {{csrf_field()}}

                                            <div class="form-group breadcrumb row">
                                                <label class="col-sm-12 col-form-label">上传配置</label>

                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">开启上传功能</label>
                                                <div class="col-sm-4">
                                                    <div class="form-inline">

                                                        <div class="radio radio-inline radio-primary">
                                                            <input id="upload_status" type="radio" value="1" name="upload_status" @if(__E("upload_status")==1) checked @endif >
                                                            <label for="upload_status"> 开启 </label>
                                                        </div>
                                                        <div class="radio radio-inline radio-primary">
                                                            <input id="upload_status2" type="radio" value="0" name="upload_status" @if(__E("upload_status")==0) checked @endif>
                                                            <label for="upload_status2"> 关闭 </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group row">
                                                <label for="upload_limit" class="col-sm-2 col-form-label">上传大小</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control" id="upload_limit" placeholder="上传大小限制" value="{{__E('upload_limit')}}" name="upload_limit" type="text">
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="text-muted">
                                                        上传文件大小(KB)
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="upload_format" class="col-sm-2 col-form-label">上传格式</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control" id="upload_format" placeholder="上传格式" value="{{__E('upload_format')}}" name="upload_format" type="text">
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="text-muted">
                                                        上传文件格式(gif、png等等，用,隔开)
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">上传驱动</label>
                                                <div class="col-sm-8">
                                                    <div class="form-inline">

                                                        <div class="radio radio-inline radio-primary">
                                                            <input id="upload_name" type="radio" value="local" name="upload_driver" @if(__E("upload_driver")=="local") checked @endif >
                                                            <label for="upload_name"> 本地 </label>
                                                        </div>
                                                        <div class="radio radio-inline radio-primary">
                                                            <input id="upload_name2" type="radio" value="S3" name="upload_driver" @if(__E("upload_driver")=="S3") checked @endif>
                                                            <label for="upload_name2"> S3 云 </label>
                                                        </div>

                                                        <div class="radio radio-inline radio-primary">
                                                            <input id="upload_name3" type="radio" value="qiniu" name="upload_driver" @if(__E("upload_driver")=="qiniu") checked @endif>
                                                            <label for="upload_name3"> 七牛云 </label>
                                                        </div>

                                                        <div class="radio radio-inline radio-primary">
                                                            <input id="upload_name4" type="radio" value="baidu" name="upload_driver" @if(__E("upload_driver")=="baidu") checked @endif>
                                                            <label for="upload_name4"> 百度云 </label>
                                                        </div>

                                                        <div class="radio radio-inline radio-primary">
                                                            <input id="upload_name5" type="radio" value="aliyun" name="upload_driver" @if(__E("upload_driver")=="aliyun") checked @endif>
                                                            <label for="upload_name5"> 阿里云 </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <section  id="local" @if(__E("upload_driver")=="local") style="display: none;" @endif>

                                                <div class="form-group breadcrumb row">
                                                    <label class="col-sm-12 col-form-label">驱动配置</label>

                                                </div>

                                                <section class="upload_driver" id="S3" @if(__E("upload_driver")!="S3") style="display: none;" @endif>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">S3用户名</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="" placeholder="S3用户名" name="" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">S3 KEY</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="" placeholder="S3 KEY" name="" type="text">
                                                        </div>
                                                    </div>

                                                </section>

                                                <section class="upload_driver" id="qiniu" @if(__E("upload_driver")!="qiniu") style="display: none;" @endif>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">七牛域名</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="qiniu_domain" placeholder="七牛域名" name="qiniu_domain" value="{{env('qiniu_domain')}}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">HTTPS域名</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="qiniu_https_domain" placeholder="HTTPS域名" name="qiniu_https_domain" value="{{env('qiniu_https_domain')}}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">自定义域名</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="qiniu_custom_domain" placeholder="自定义域名" name="qiniu_custom_domain" value="{{env('qiniu_custom_domain')}}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">AccessKey</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="qiniu_access_key" placeholder="AccessKey" name="qiniu_access_key" value="{{env('qiniu_access_key')}}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">SecretKey</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="qiniu_secret_key" placeholder="SecretKey" name="qiniu_secret_key" value="{{env('qiniu_secret_key')}}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">Bucket名字</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="qiniu_bucket" placeholder="Bucket名字" name="qiniu_bucket" value="{{env('qiniu_bucket')}}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">持久化处理回调地址</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="qiniu_notify_url" placeholder="持久化处理回调地址" name="qiniu_notify_url" value="{{env('qiniu_notify_url')}}" type="text">
                                                        </div>
                                                    </div>



                                                </section>


                                                <section class="upload_driver" id="baidu" @if(__E("upload_driver")!="baidu") style="display: none;" @endif>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">百度用户名</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="" placeholder="百度用户名" name="" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">百度 KEY</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="" placeholder="百度 KEY" name="" type="text">
                                                        </div>
                                                    </div>

                                                </section>


                                                <section class="upload_driver" id="aliyun" @if(__E("upload_driver")!="aliyun") style="display: none;" @endif>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">阿里云用户名</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="" placeholder="阿里云用户名" name="" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2 col-form-label">阿里云 KEY</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" id="" placeholder="阿里云 KEY" name="" type="text">
                                                        </div>
                                                    </div>

                                                </section>


                                            </section>







                                            <div class="form-group breadcrumb row">
                                                <label class="col-sm-2 col-form-label">图片设置</label>

                                            </div>

                                            <div class="form-group ">
                                                <div class="tabs">
                                                    <ul class="nav nav-tabs">
                                                        <li class="nav-item" role="presentation"><a class="nav-link  active" href="#thumb" aria-controls="thumb" role="tab" data-toggle="tab">缩略图</a></li>
                                                        <li class="nav-item" role="presentation"><a class="nav-link" href="#watermark" aria-controls="watermark" role="tab" data-toggle="tab">水印</a></li>

                                                    </ul>

                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="thumb">

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label">自动生成</label>
                                                                <div class="col-sm-4">
                                                                    <div class="form-inline">
                                                                        <div class="radio radio-primary">
                                                                            <input id="thumb_auto" type="radio" name="thumb_auto" value="1" @if(__E("thumb_auto")==1) checked @endif >
                                                                            <label for="thumb_auto"> 开启 </label>
                                                                        </div>
                                                                        <div class="radio  radio-primary">
                                                                            <input id="thumb_auto2" type="radio" name="thumb_auto" value="0" @if(__E("thumb_auto")==0) checked @endif>
                                                                            <label for="thumb_auto2"> 关闭 </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label">生成方式</label>
                                                                <div class="col-sm-4">
                                                                    <div class="form-inline">

                                                                        <div class="radio radio-primary">
                                                                            <input id="thumb_method" type="radio" name="thumb_method" value="draw" @if(__E("thumb_method")=="draw") checked @endif>
                                                                            <label for="thumb_method"> 拉伸 </label>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-inline">

                                                                        <div class="radio radio-primary">
                                                                            <input id="thumb_method2" type="radio" name="thumb_method" value="message" @if(__E("thumb_method")=="message") checked @endif>
                                                                            <label for="thumb_method2"> 留白 </label>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-inline">

                                                                        <div class="radio radio-primary">
                                                                            <input id="thumb_method3" type="radio" name="thumb_method" value="cut" @if(__E("thumb_method")=="cut") checked @endif>
                                                                            <label for="thumb_method3"> 裁减 </label>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="watermark">

                                                            <div class="form-group row">
                                                                <label for="inputEmail3" class="col-sm-2 col-form-label">水印类型</label>
                                                                <div class="col-sm-4">
                                                                    <div class="form-inline">

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_type" type="radio" name="watermark_type" value="img" @if(__E("watermark_type")=="img") checked @endif>
                                                                            <label for="watermark_type"> 图片 </label>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-inline">

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_type2" type="radio" name="watermark_type" value="text" @if(__E("watermark_type")=="text") checked @endif>
                                                                            <label for="watermark_type2"> 文字 </label>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="inputEmail3" class="col-sm-2 col-form-label">水印位置</label>
                                                                <div class="col-sm-4">
                                                                    <div class="form-inline">

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position" type="radio" name="watermark_position" value="left-up" @if(__E("watermark_position")=="left-up") checked @endif>
                                                                            <label for="watermark_position"> 左上 </label>
                                                                        </div>

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position2" type="radio" name="watermark_position" value="middle-up" @if(__E("watermark_position")=="middle-up") checked @endif>
                                                                            <label for="watermark_position2"> 中上 </label>
                                                                        </div>

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position3" type="radio" name="watermark_position" value="right-up" @if(__E("watermark_position")=="right-up") checked @endif>
                                                                            <label for="watermark_position3"> 右上 </label>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-inline">

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position4" type="radio" name="watermark_position" value="left-middle" @if(__E("watermark_position")=="left-middle") checked @endif>
                                                                            <label for="watermark_position4"> 左中 </label>
                                                                        </div>

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position5" type="radio" name="watermark_position" value="center" @if(__E("watermark_position")=="center") checked @endif>
                                                                            <label for="watermark_position5"> 中间 </label>
                                                                        </div>

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position6" type="radio" name="watermark_position" value="right-middle" @if(__E("watermark_position")=="right-middle") checked @endif>
                                                                            <label for="watermark_position6"> 右中 </label>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-inline">

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position7" type="radio" name="watermark_position" value="left-down" @if(__E("watermark_position")=="left-down") checked @endif>
                                                                            <label for="watermark_position7"> 左下 </label>
                                                                        </div>

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position8" type="radio" name="watermark_position" value="down" @if(__E("watermark_position")=="down") checked @endif>
                                                                            <label for="watermark_position8"> 低下 </label>
                                                                        </div>

                                                                        <div class="radio radio-primary">
                                                                            <input id="watermark_position9" type="radio" name="watermark_position" value="right-down" @if(__E("watermark_position")=="right-down") checked @endif>
                                                                            <label for="watermark_position9"> 右下 </label>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <section id="watermark_text" @if(__E("watermark_type")!="text") style="display: none" @endif >
                                                                <div class="form-group row">
                                                                    <label for="watermark_text" class="col-sm-2 col-form-label">水印文字</label>
                                                                    <div class="col-sm-4">
                                                                        <input class="form-control" id="watermark_text" name="watermark_text" value="{{__E('watermark_text')}}" placeholder="水印文字" type="text">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p class="text-muted">
                                                                            上传文件大小(KB)
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="watermark_text_size" class="col-sm-2 col-form-label">水印文字大小</label>
                                                                    <div class="col-sm-4">
                                                                        <input class="form-control" id="watermark_text_size" name="watermark_text_size" value="{{__E('watermark_text_size')}}" placeholder="水印文字大小" type="mumber">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p class="text-muted">
                                                                            像素(px)
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="watermark_text_angle" class="col-sm-2 col-form-label">文字角度</label>
                                                                    <div class="col-sm-4">
                                                                        <input class="form-control" id="watermark_text_angle" name="watermark_text_angle" value="{{__E('watermark_text_angle')}}" placeholder="文字角度" type="mumber">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p class="text-muted">
                                                                            水平为0
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="watermark_text_color" class="col-sm-2 col-form-label">文字颜色</label>
                                                                    <div class="col-sm-4">
                                                                        <input class="form-control" id="watermark_text_color" name="watermark_text_color" value="{{__E('watermark_text_color')}}" placeholder="文字颜色" type="text">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p class="text-muted">
                                                                            自定义颜色
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </section>


                                                            <section id="watermark_img" @if(__E("watermark_type")!="img") style="display: none" @endif>
                                                                <div class="form-group row">
                                                                    <label for="inputEmail3" class="col-sm-2 col-form-label">水印图片</label>
                                                                    <div class="col-sm-4">
                                                                        <div class="fileinput fileinput-new input-group col-md-12" data-provides="fileinput">
                                                                            <div class="form-control" data-trigger="fileinput"><span class="fileinput-filename"></span></div>
                                                                            <span class="input-group-addon btn btn-primary btn-file ">
                                                                                      <span class="fileinput-new">选择图片</span>
                                                                                      <span class="fileinput-exists">更换</span>
                                                                                      <input type="hidden"><input name="watermark_img" type="file">
                                                                                      </span>
                                                                            <a href="#" class="input-group-addon btn btn-danger  hover fileinput-exists" data-dismiss="fileinput">删除</a>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </section>






                                                        </div>


                                                    </div>
                                                </div>

                                            </div>


                                            <button type="button" id="upload_button" class="btn btn-sm btn-primary">提交</button>
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

        //配置选项卡
        $("input[name='upload_driver']").change(function () {
            if($(this).val()=="local"){
                $("#local").hide();
            }else {
                $("#local").show();
                $(".upload_driver").hide();
                $("#"+$(this).val()).show();
            }
        })

        //水印类型选项卡
        $("input[name='watermark_type']").change(function () {

            if($(this).val()=="img"){
                $("#watermark_img").show();
                $("#watermark_text").hide();

            }else if($(this).val()=="text"){
                $("#watermark_img").hide();
                $("#watermark_text").show();
            }

        })




        $("#upload_button").click(function () {

            $.ajax({
                "method":"post",
                "url":"{{url('admin/toolSubmit?form=upload')}}",
                "data":$("#upload_form").serialize(),
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