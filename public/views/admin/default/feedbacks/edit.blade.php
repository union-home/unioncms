@include("admin.".ADMIN_SKIN.".header")
<!-- Wysihtml5 and Summernote -->
<link href="{{ADMIN_ASSET}}assets/lib/wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet">
<link href="{{ADMIN_ASSET}}assets/lib/summernote/summernote.css" rel="stylesheet">


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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("other_relate")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("feedback_edit")}}</li>
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
                                            <input type="hidden" name="id" value="{{$page->id}}"  />

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_user_unique")}}</label>
                                                <input type="text" name="uid" value="{{$page->uid}}" class="form-control form-control-rounded" disabled="">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_user_name")}}</label>
                                                <input type="text" name="user_name" value="{{$page->user_name}}" class="form-control form-control-rounded" disabled="">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_email")}}</label>
                                                <input type="text" name="user_email" value="{{$page->user_email}}" class="form-control form-control-rounded" disabled="">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("user_tel")}}</label>
                                                <input type="text" name="user_tel" value="{{$page->user_tel}}" class="form-control form-control-rounded" disabled="">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_user_name")}}</label>
                                                <input type="text" name="user_name" value="{{$page->user_name}}" class="form-control form-control-rounded" disabled="">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_feedback_content")}}</label>
                                                <textarea name="content" style="height: 150px;">{!! $page->content !!}</textarea>
                                            </div>


                                            <!-- <button type="button" id="post_button" class="btn btn-primary margin-l-5 mx-sm-3">{{getTranslateByKey("common_submit")}}</button> -->
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

<!-- Wysihtml5 and Summernote -->
<script src="{{ADMIN_ASSET}}assets/lib/wysihtml5/wysihtml5-0.3.0.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/wysihtml5/bootstrap-wysihtml5.js"></script>

<script src="{{ADMIN_ASSET}}assets/lib/summernote/summernote.js"></script>


</body>
<style>
    .ui-selectmenu-button.ui-button{
        width: 100em;
    }
</style>
</html>
<script>

    $(function () {
        $('.summernote').summernote({
            lang: 'zh-CN',
            height:'400px'
        });

        $("#post_button").click(function () {
            return;
            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $("input[name='content']").val($('.summernote').summernote('code'));
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/feedbackSubmit?form=edit')}}",
                        "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                        "dataType":'json',
                        "cache":false,
                        "processData": false,
                        "contentType": false,
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});
                                setTimeout(function () {
                                    location.href="{{url('admin/feedbacks')}}";
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