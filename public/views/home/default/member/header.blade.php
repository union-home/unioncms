<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
    <title>会员中心</title>

    <script src="{{HOME_ASSET}}assets/member/plugins/jquery/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="{{HOME_ASSET}}assets/member/plugins/bootstrap/bootstrap.min.css">
    <script src="{{HOME_ASSET}}assets/member/plugins/bootstrap/bootstrap.min.js"></script>

    <script src="{{HOME_ASSET}}assets/member/js/common.js"></script>

    <link rel="stylesheet" href="{{HOME_ASSET}}assets/member/plugins/awesome/css/font-awesome.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{HOME_ASSET}}assets/member/css/common.css">

    @if($loadcss=="index")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/member/css/index.css">
    @elseif($loadcss=="setting")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/member/css/setting.css">


    @endif

</head>
<body class="d-flex flex-column">