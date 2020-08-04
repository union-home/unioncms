@include("home.".HOME_SKIN.".member.header")

@include("home.".HOME_SKIN.".member.nav")

<style type="text/css">
    .fileinput-preview {
        margin-bottom: 10px;
        border: 1px solid #ccc;
        padding: 5px;
    }
    .btn-file {
        overflow: hidden;
        position: relative;
        vertical-align: middle;
    }
    .btn-file > input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        font-size: 23px;
        height: 100%;
        width: 100%;
        direction: ltr;
        cursor: pointer;
    }
    .fileinput-exists .fileinput-new, .fileinput-new .fileinput-exists {
        display: none;
    }
    img{max-width: 100%}
    .userinfo-content{    min-height: 519px;}
</style>

<main class="main px-md-5 p-md-3 p-3  bc-2nd-f7">
    <div class="product">
        <div class="row">
            <div class="col-12">
                <div class="setting-group">
                    <ul class="list-unstyled border-bottom pb-2">
                        <li class="list-inline-item active mr-3" ><div class="tc-2nd">帐号安全</div></li>
                    </ul>
                    <span class="more d-md-none d-block">&gt;</span>
                </div>
            </div>
        </div>
        <div class="setting">
            <ul class="list-unstyled mb-0">
                <li class="companyinfo list-inline-item w-100 d-none">
                    <div class="row">
                        <div class="col-12">
                            <div class="setting-header">
                                <span class="mr-2"></span>
                                <h6 class="d-inline">企业资料</h6>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="userinfo list-inline-item w-100 active">
                    <div class="row">
                        <div class="col-12">
                            <div class="setting-header">
                                <span class="mr-2"></span>
                                <h6 class="d-inline">设置登陆密码</h6>
                            </div>
                        </div>
                    </div>
                    <div class="userinfo-content mt-md-3 mt-3">
                        <form method="post" action="" id="post_form" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row px-md-5 pb-md-5 px-2 px-2">
                                <div class="col-12 mt-md-3">
                                    <div class="">
                                        <div class="userinfo-group w-100">
                                            <span class="userinfo-text">旧密码：</span>
                                            <input class="bc-2nd-f7 d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text" name="old_pass" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-md-3">
                                    <div class="">
                                        <div class="userinfo-group w-100">
                                            <span class="userinfo-text">新密码：</span>
                                            <input class="bc-2nd-f7 d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="password" name="password" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-md-3">
                                    <div class="">
                                        <div class="userinfo-group w-100">
                                            <span class="userinfo-text">再次输入密码：</span>
                                            <input class="bc-2nd-f7 d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="password" name="password_confirmation" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 my-3 d-flex justify-content-md-start justify-content-around">
                                    <span class="userinfo-text d-md-inline-block d-none"></span>
                                    <input class="save-btn py-2 px-5 bc-theme border-0 text-white" type="button" value="保存" id="post_button">
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="message">

                </li>
            </ul>

        </div>
    </div>
</main>


@include("home.".HOME_SKIN.".footer")
<link rel="stylesheet" type="text/css" href="{{ADMIN_ASSET}}assets/other/DialogJS/style/dialog.css">
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/zepto.min.js"></script>
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/dialog.min.js"></script>
<script src="{{HOME_ASSET}}assets/member/js/setting.js"></script>
<script type="text/javascript">
    $("#post_button").click(function () {
        popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
            $.ajax({
                "method":"post",
                "url":"",
                "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                "dataType":'json',
                "cache":false,
                "processData": false,
                "contentType": false,
                "success":function (res) {
                    if(res.status==200){
                        popup({type:"success",msg:res.msg,delay:2000});
                        setTimeout(function () {
                            location.href="";
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
    });
</script>