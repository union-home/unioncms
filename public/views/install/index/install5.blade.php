<!doctype html>
<html>
<head>
    @include("install.head")
    <script src="__STATIC__/js/jquery.js"></script>
</head>
<body>
<div class="wrap">
        @include("install.header")
    <section class="section">
        <div style="padding: 40px 20px;">
            <div class="text-center">
                <a style="font-size: 18px;">恭喜您，安装完成！</a>
                <br>
                <br>
                <div class="alert alert-danger" style="width: 360px;display: inline-block;text-align: left;">
                    为了您的站点安全<br>
                    &nbsp;1.切忌不可删除 public 下面的install lock文件，用于标识程序已安装;<br>
                    &nbsp;2.如若被删除，可手动新增该文件即可，重新安装流程会覆盖所有数据，谨记;<br>
                    另请对SQL做好备份，以防数据丢失！
                </div>
            </div>

            <div class="text-center">
                <a class="btn btn-success" href="{{url('/')}}/">进入前台</a>
                <a class="btn btn-success" href="{{url('/admin')}}">进入后台</a>
            </div>

        </div>
    </section>
</div>

@include("install.footer")
</body>
</html>
