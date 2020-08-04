<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{cacheGlobalSettingsByKey('website_name')}}{{getTranslateByKey("login_title")}}</title>
    <link rel="icon" type="image/ico" sizes="48x48" href="{{GetLocalFileByPath(cacheGlobalSettingsByKey('webicon'))}}">

    <link href="{{ADMIN_ASSET}}assets/other/jqueryToast/css/toast.style.css" rel="stylesheet">
    <!-- Common Plugins -->
    <link href="{{ADMIN_ASSET}}assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Css-->
    <link href="{{ADMIN_ASSET}}assets/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        html,body{
            height: 100%;
        }
    </style>
</head>

<body class="bg-light">

<div class="misc-wrapper">
    <div class="misc-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-11">
                    <div class="misc-header text-center">
                        <img alt="" src="{{UPLOADPATH.$settings["weblogo"]["value"]}}" width="200" class="logo-icon margin-r-10">
                    </div>
                    <div class="misc-box">
                        <form role="form" method="post" autocomplete="off" action="">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label  for="exampleuser1">{{getTranslateByKey("common_username")}}</label>
                                <div class="group-icon">
                                    <input id="exampleuser1" type="text" value="{{session("_old_input")["username"]?session("_old_input")["username"]:session("admin_remember")}}" name="username" placeholder="{{getTranslateByKey("common_enter_username")}}" class="form-control" required="">
                                    <span class="icon-user text-muted icon-input"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">{{getTranslateByKey("common_login_password")}}</label>
                                <div class="group-icon">
                                    <input id="exampleInputPassword1" name="password" type="password" placeholder="{{getTranslateByKey("common_enter_login_password")}}" class="form-control" required>
                                    <span class="icon-lock text-muted icon-input"></span>
                                </div>
                            </div>

                            @if(cacheGlobalSettingsByKey("admin_login_code")==1)
                                <div class="form-group">
                                    <label for="code">{{getTranslateByKey("common_verfy_code")}}</label>
                                    <div class="group-icon d-flex">
                                        <div class="w-100">
                                            <input class="w-100" id="code" name="captcha" type="text" placeholder="{{getTranslateByKey("common_enter_verfy_code")}}">
                                        </div>
                                        <div class="">
                                            <img class="h-100" src="{{captcha_src()}}" style="cursor: pointer" onclick="this.src='{{captcha_src()}}'+Math.random()" />
                                        </div>

                                    </div>
                                </div>
                            @endif
                            <div class="clearfix">
                                <div class="float-left">
                                    <div class="checkbox checkbox-primary margin-r-5">
                                        <input id="checkbox2" type="checkbox" name="is_remember" checked="">
                                        <label for="checkbox2"> {{getTranslateByKey("login_remember_login")}} </label>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <button type="submit" style="margin-top: 12px;" class="btn btn-block btn-primary btn-rounded box-shadow">{{getTranslateByKey("common_login")}}</button>
                                </div>
                            </div>
                            <hr>

                            <a href="{{url("/")}}" class="btn btn-block btn-rounded">{{getTranslateByKey("login_back_to_home")}}</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center text-center misc-footer">
                <p>Copyright &copy; {{date("Y")}} {{cacheGlobalSettingsByKey('website_name')}}</p>
            </div>
        </div>
    </div>

</div>


</body>
</html>
<script src="{{ADMIN_ASSET}}assets/lib/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/jqueryToast/js/toast.script.js"></script>
<script>

    var toastMsg;
    var toastType

    @if ($errors->any())
        toastType = 'error';
        @foreach ($errors->all() as $error)
            toastMsg  = "{{$error}}";
        @endforeach
    @endif

    if(toastMsg){
        $.Toast("温馨提示!", toastMsg, toastType, {
            // append to body
            appendTo: "body",
            // is stackable?
            stack: true,
            // 'toast-top-left'
            // 'toast-top-right'
            // 'toast-top-center'
            // 'toast-bottom-left'
            // 'toast-bottom-right'
            // 'toast-bottom-center'
            position_class: "toast-bottom-right",
            // true = snackbar
            fullscreen: false,
            // width
            width: 250,
            // space between toasts
            spacing: 20,
            // in milliseconds
            timeout: 2000,
            // has close button
            has_close_btn: false,
            // has icon
            has_icon: false,
            // is sticky
            sticky: false,
            // border radius in pixels
            border_radius: 6,
            // has progress bar
            has_progress: true,
            // RTL support
            rtl: false
        });
    }

</script>
