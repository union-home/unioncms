@include("admin.".ADMIN_SKIN.".header")
<link rel="stylesheet" href="{{asset('/assets/kindeditor/themes/default/default.css')}}"/>
<link rel="stylesheet" href="{{asset('/assets/kindeditor/plugins/code/prettify.css')}}"/>
<script charset="utf-8" src="{{asset('/assets/kindeditor/kindeditor-all.js')}}"></script>
{{--<script charset="utf-8" src="{{MODULE_ASSET}}/unionshop/assets/kindeditor/kindeditor-all-min.js"></script>--}}
<script charset="utf-8" src="{{asset('/assets/kindeditor/lang/zh-CN.js')}}"></script>
<script charset="utf-8" src="{{asset('/assets/kindeditor/plugins/code/prettify.js')}}"></script>
<script>
    KindEditor.ready(function (K) {
        var editor1 = K.create('textarea[name="content"]', {
            urlType:'domain',
            cssPath: "{{asset('/assets/kindeditor/plugins/code/prettify.css')}}",
            uploadJson: "{{asset('/assets/kindeditor/php/upload_json.php')}}",
            fileManagerJson: "{{asset('/assets/kindeditor/php/file_manager_json.php')}}",
            allowFileManager: true,
            afterCreate: function () {
                var self = this;
                K.ctrl(document, 13, function () {
                    self.sync();
                    K('form[name=example]')[0].submit();
                });
                K.ctrl(self.edit.doc, 13, function () {
                    self.sync();
                    K('form[name=example]')[0].submit();
                });
            },
            afterBlur: function(){this.sync();}
        });
        prettyPrint();
    });

</script>

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
            <li class="breadcrumb-item active">添加专辑</li>
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

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_name")}}</label>
                                                <input type="text" name="name" value=""
                                                       class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group" style="display: none">
                                                <label>{{getTranslateByKey("common_describe")}}</label>
                                                <input type="text" name="describe" value=""
                                                       class="form-control form-control-rounded">
                                            </div>
                                            <div class="form-group ">
                                                <label>培训说明</label>
                                                {{--<div id="content" style="min-height: 345px;" class="form-control"></div>
                                                <textarea name="content" id="text1" style="display: none;"></textarea>--}}
                                                <textarea name="content"
                                                          style="width:100%;height:400px;visibility:hidden;"></textarea>
                                            </div>
                                            <div class="form-group" style="display: none">
                                                <label>{{getTranslateByKey("common_icon_type")}}</label>
                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="icon_type" name="icon_type" type="radio" value="css"
                                                               checked>
                                                        <label for="icon_type"> {{getTranslateByKey("common_icon_css_class")}} </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="icon_type2" name="icon_type" type="radio"
                                                               value="img">
                                                        <label for="icon_type2"> {{getTranslateByKey("common_image")}} </label>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="form-group " id="icon_img_div" style="display: none;">
                                                <label>{{getTranslateByKey("common_icon")}}</label>
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

                                            <div class="form-group " id="icon_css_div" style="display: none">
                                                <label>{{getTranslateByKey("common_icon")}}</label>
                                                <input type="text" name="icon_css" value=""
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
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/js/wangEditor.min.js"></script>

</body>
<style>
    .ui-selectmenu-button.ui-button {
        width: 100em;
    }
</style>
</html>
<script>

    $(function () {
        var edit = window.wangEditor
        var editor2 = new edit('#content')

        // 下面两个配置，使用其中一个即可显示“上传图片”的tab。但是两者不要同时使用！！！
        editor2.customConfig.uploadImgServer = '{{url("admin/uploadByEditByName/wangEditor")}}'; // 上传图片到服务器
        editor2.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        };
        editor2.customConfig.uploadFileName = 'photo';
        editor2.customConfig.uploadImgTimeout = 3*60*10*1000

        var $text1 = $('#text1')
        editor2.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html)
        }
        editor2.create()
        // 初始化 textarea 的值
        $text1.val(editor2.txt.html())


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
                        "url": "{{url('admin/video/categoryAdd')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType": 'json',
                        "cache": false,
                        "processData": false,
                        "contentType": false,
                        "success": function (res) {

                            if (res.status == 200) {
                                popup({type: "success", msg: res.msg, delay: 2000});
                                setTimeout(function () {
                                    location.href = "{{url('admin/video/category')}}";
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