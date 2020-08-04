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
    /*.email span, .email input{
        float: left;
    }
    .email span{
        top: 0.7rem;
    }
    #email_test_button{
        margin-left: 1rem;
    }*/
    #send_email_button{text-align: center;cursor: pointer;}
    .bind-email{
        width: auto!important;
        background: none!important;
        font-size: 13px;
        margin-left: 20px;
    }
</style>

<main class="main px-md-5 p-md-3 p-3  bc-2nd-f7">
    <div class="product">
        <div class="row">
            <div class="col-12">
                <div class="setting-group">
                    <ul class="list-unstyled border-bottom pb-2" onclick="window.location.href='{{url('member/setting')}}'">
                        <li class="list-inline-item active mr-3" ><div class="tc-2nd">帐号安全</div></li>
                    </ul>
                    <span class="more d-md-none d-block">&gt;</span>
                </div>
            </div>
        </div>
        <div class="setting">
            <ul class="list-unstyled mb-0">
                <li class="userinfo list-inline-item w-100 active">
                    <div class="row">
                        <div class="col-12">
                            <div class="setting-header">
                                <span class="mr-2"></span>
                                <h6 class="d-inline">绑定邮箱</h6>
                                @if(!empty($login_user['email']))
                                    <span class="bind-email">已绑定： {{$login_user['email']}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="userinfo-content mt-md-3 mt-3">
                        <form method="post" action="" id="post_form" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row px-md-5 pb-md-5 px-2 px-2">
                                <div class="col-12 mt-md-3">
                                    <div class="">
                                        <div class="userinfo-group w-100 email">
                                            <span class="userinfo-text">邮箱地址：</span>
                                            <input class="bc-2nd-f7 d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text" name="email" value="" />
                                            <span class="form-control bc-2nd-f7 d-md-inline-block d-block w-25 mt-2 border px-2 py-1" id="send_email_button">
                                                发送验证码
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-md-3">
                                    <div class="">
                                        <div class="userinfo-group w-100">
                                            <span class="userinfo-text">验证码：</span>
                                            <input class="bc-2nd-f7 d-md-inline-block d-block w-25 mt-2 border px-2 py-1" name="email_code" type="text" placeholder="请输入验证码">
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
            </ul>

        </div>
    </div>
</main>


@include("home.".HOME_SKIN.".footer")
<link rel="stylesheet" type="text/css" href="{{ADMIN_ASSET}}assets/other/DialogJS/style/dialog.css">
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/zepto.min.js"></script>
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/dialog.min.js"></script>
<script type="text/javascript">
    $("#post_button").click(function () {
        popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
            $.ajax({
                "method":"post",
                "url":"{{url('member/safetySubmit?form=bind_email')}}",
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

    $("#send_email_button").click(function () {
        popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
            $.ajax({
                "method":"post",
                "url":"{{url('member/safetySubmit?form=send_bind_email')}}",
                "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                "dataType":'json',
                "cache":false,
                "processData": false,
                "contentType": false,
                "success":function (res) {
                    if(res.status==200){
                        popup({type:"success",msg:res.msg,delay:2000});
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