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
            <li class="breadcrumb-item active">招聘添加</li>
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

                                            <input type="hidden" name="id" value="{{$joins["id"]}}">
                                            <div class="form-group ">
                                                <label>职位：</label>
                                                <input type="text" name="position" value="{{$joins["position"]}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>岗位职责：</label>
                                                <div id="description" style="height: 352px;" class="form-control">{!! $joins["description"] !!}</div>
                                                <textarea name="description" id="text1" style="display: none;"></textarea>
                                            </div>

                                            <div class="form-group ">
                                                <label>岗位要求：</label>
                                                <div id="requirements" style="min-height: 552px;" class="form-control">{!! $joins["requirements"] !!}</div>
                                                <textarea name="requirements" id="text2" style="display: none;"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>招聘状态：</label>
                                                <div class="form-inline">
                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="website_op_reg" name="status" type="radio" value="1" @if($joins["status"]==1) checked="" @endif >
                                                        <label for="website_op_reg"> 开启 </label>
                                                    </div>

                                                    <div class=" radio radio-inline radio-inverse">
                                                        <input id="website_op_reg2" name="status" type="radio" value="0" @if($joins["status"]==0) checked="" @endif >
                                                        <label for="website_op_reg2"> 关闭 </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_seo_keywords")}}</label>
                                                <input type="text" name="seo_keywords" value="{{$joins['seo_keywords']}}" class="form-control form-control-rounded">
                                            </div>
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_seo_description")}}</label>
                                                <textarea name="seo_description" style="height: 100px;" class="form-control">{{$joins['seo_description']}}</textarea>
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

<script src="//unpkg.com/wangeditor/release/wangEditor.min.js"></script>
</body>
<style>
    .ui-selectmenu-button.ui-button{
        width: 100em;
    }
    .w-e-text-container{
        height: 500px !important;/*!important是重点，因为原div是行内样式设置的高度300px*/
    }
</style>
</html>
<script>

    $(function () {

        var edit = window.wangEditor
        var description = new edit('#description')

        // 下面两个配置，使用其中一个即可显示“上传图片”的tab。但是两者不要同时使用！！！
        description.customConfig.uploadImgServer = '{{url("admin/uploadByEditByName/wangEditor")}}'; // 上传图片到服务器
        description.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        };
        description.customConfig.uploadFileName = 'photo';
        description.customConfig.uploadImgTimeout = 3*60*10*1000

        var $text1 = $('#text1')
        description.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html)
        }
        description.create()
        // 初始化 textarea 的值
        $text1.val(description.txt.html())


        var requirements = new edit('#requirements')

        // 下面两个配置，使用其中一个即可显示“上传图片”的tab。但是两者不要同时使用！！！
        requirements.customConfig.uploadImgShowBase64 = true   // 使用 base64 保存图片
        // editor.customConfig.uploadImgServer = '/upload'  // 上传图片到服务器

        var $text2 = $('#text2')
        requirements.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text2.val(html)
        }
        requirements.create()
        // 初始化 textarea 的值
        $text2.val(requirements.txt.html())



        $("#post_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){

                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/content/submit?form=joinEdit')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType":'json',
                        "cache":false,
                        "processData": false,
                        "contentType": false,
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});
                                setTimeout(function () {
                                    location.href="{{url('admin/content/join')}}";
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
