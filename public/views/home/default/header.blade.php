<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
    <title>{{$seo_title}} --  Powered by UnionCMS</title>
    <meta name="keywords" content="{{$seo_keywords}}">
    <meta name="description" content="{{$seo_description}}">
    <link rel="stylesheet" href="{{HOME_ASSET}}assets/plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{{HOME_ASSET}}assets/plugins/awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/common.css">
    @if($loadcss=="index")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/index.css">
    @elseif($loadcss=="about")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/aboutUs.css">
    @elseif($loadcss=="contact")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/contact.css">
    @elseif($loadcss=="login")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/login.css">
    @elseif($loadcss=="news")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/news.css">
    @elseif($loadcss=="case")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/case.css">
    @elseif($loadcss=="product")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/product.css">
    @elseif($loadcss=="cDetailed")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/cDetailed.css">
    @elseif($loadcss=="faq")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/problem.css">
    @elseif($loadcss=="join")
        <link rel="stylesheet" href="{{HOME_ASSET}}assets/css/recruit.css">
    @endif

    <script src="{{HOME_ASSET}}assets/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script src="{{HOME_ASSET}}assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="{{HOME_ASSET}}assets/js/common.js"></script>
    {!! __E("head_codes") !!}
</head>
<body>