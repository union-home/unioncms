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
            <li class="breadcrumb-item active">文章编辑</li>
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

                                            <input type="hidden" name="id" value="{{$data['id']}}" />
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_category")}} &nbsp;&nbsp; <a href="{{url('admin/article/category')}}">{{getTranslateByKey("common_category_manage")}}</a></label>
                                                <select name="cid" class="form-control m-b">

                                                    @foreach($category as $value)
                                                        <option value='{{$value["id"]}}' @if($data["cid"] == $value["id"]) selected @endif >{{$value["name"]}}</option>
                                                        @endforeach

                                                </select>
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_name")}}</label>
                                                <input type="text" name="title" value="{{$data['title']}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_tag")}}</label>
                                                <input type="text" name="tags" value="{{$data['tags']}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group " >
                                                <label>{{getTranslateByKey("common_cover")}}</label>
                                                <div class="fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview" data-trigger="fileinput" style="width: 160px; height:160px;">
                                                        <img src="{{GetUrlByPath($data['cover'])}}" width="150" height="150" />
                                                    </div>
                                                    <span class="btn btn-primary  btn-file">
                                                                            <span class="fileinput-new">{{getTranslateByKey("common_select")}}</span>
                                                                            <span class="fileinput-exists">{{getTranslateByKey("common_change")}}</span>
                                                                            <input type="file" id="cover" name="cover">
                                                                        </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">{{getTranslateByKey("common_delete")}}</a>

                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_hot_active")}}</label>
                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="is_hot" type="radio" name="is_hot" value="0" @if($data['is_hot']==0) checked @endif >
                                                        <label for="is_hot"> {{getTranslateByKey("common_not_hot")}} </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="is_hot2" type="radio" name="is_hot" value="1" @if($data['is_hot']==1) checked @endif >
                                                        <label for="is_hot2"> {{getTranslateByKey("common_hot")}} </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_rec_active")}}</label>
                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="is_rec" type="radio" name="is_rec" value="0" @if($data['is_rec']==0) checked @endif >
                                                        <label for="is_rec"> {{getTranslateByKey("common_not_rec")}} </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="is_rec2" type="radio" name="is_rec" value="1" @if($data['is_rec']==1) checked @endif >
                                                        <label for="is_rec2"> {{getTranslateByKey("common_rec")}} </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>简介</label>

                                                <textarea name="introduct" style="height: 150px;">{!! $data['introduct'] !!}</textarea>
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_content")}}</label>
                                                <div id="content" style="min-height: 552px;" class="form-control">{!! $data['content'] !!}</div>
                                                <textarea name="content" id="text1" style="display: none;"></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_seo_keywords")}}</label>
                                                <input type="text" name="seo_keywords" value="{{$data['seo_keywords']}}" class="form-control form-control-rounded">
                                            </div>
                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_seo_description")}}</label>
                                                <textarea name="seo_description" style="height: 100px;" class="form-control">{{$data['seo_description']}}</textarea>
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





        $("#post_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){

                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/ArticleSubmit?form=edit')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType":'json',
                        "cache":false,
                        "processData": false,
                        "contentType": false,
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});
                                setTimeout(function () {
                                    location.href="{{url('admin/article')}}";
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
