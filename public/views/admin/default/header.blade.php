<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<title>UnionCMS 管理首页</title>--}}
    <title>{{cacheGlobalSettingsByKey('website_name')}}{{getTranslateByKey("login_title")}}</title>
    <link rel="icon" type="image/ico" sizes="48x48" href="{{GetLocalFileByPath(cacheGlobalSettingsByKey('webicon'))}}">

    <link href="{{ADMIN_ASSET}}assets/other/jqueryToast/css/toast.style.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ADMIN_ASSET}}assets/other/DialogJS/style/dialog.css">

    <!-- Common Plugins -->
    <link href="{{ADMIN_ASSET}}assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sweet Alerts -->
    <link rel="stylesheet" href="{{ADMIN_ASSET}}assets/css/jquery-confirm.min.css">

    <!-- Jquery UI -->
    <link href="{{ADMIN_ASSET}}assets/lib/jquery-ui/jquery-ui.css" rel="stylesheet">

    <!-- Custom Css-->

    <link href="{{ADMIN_ASSET}}assets/css/style.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ADMIN_ASSET}}assets/js/html5shiv.min.js"></script>
    <script src="{{ADMIN_ASSET}}assets/js/respond.min.js"></script>
    <![endif]-->

</head>