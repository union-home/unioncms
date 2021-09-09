<!doctype html>
<html>
<head>
    @include("install.head")
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "/"
        };
    </script>
    <style type="text/css">
        .display-none{display: none;}
    </style>
</head>
<body>
    <div class="wrap">
        @include("install.header")
        <section class="section">
            <div class="step">
                <ul class="unstyled">
                    <li class="on"><em>1</em>检测环境</li>
                    <li class="on"><em>2</em>创建数据</li>
                    <li class="current"><em>3</em>完成安装</li>
                </ul>
            </div>
            <div class="install" id="log">
                <ul id="install-msg-panel" class="unstyled"></ul>
            </div>
            <div class="bottom text-center">
                <a class="install-load" href="javascript:;"><i class="fa fa-refresh fa-spin"></i>&nbsp;正在安装...</a>
                <br>
                <a class="display-none install-ok" href="{{url('/')}}">&nbsp;网站前台 </a>
                <br>
                <a class="display-none install-ok" href="{{url('/admin')}}">&nbsp;网站后台 </a>
            </div>
        </section>
    </div>
    @include("install.footer")
    <script src="{{INSTALL_ASSET}}/assets/js/wind.js"></script>
    <script src="{{INSTALL_ASSET}}/assets/js/noty/noty-2.4.1.js"></script>
    <script type="text/html" id="exec-success-msg-tpl">
        <li>
            <i class="fa fa-check correct"></i>
            {message}<br>
            <!--<pre>{sql}</pre>-->
        </li>
    </script>
    <script type="text/html" id="exec-fail-msg-tpl">
        <li>
            <i class="fa fa-remove error"></i>
            {message}<br>
            <pre>{sql}</pre>
            <!--<pre>{exception}</pre>-->
        </li>
    </script>
    <script type="text/javascript">
        $(function () {
            $installMsgPanel.append('数据量较大，需要花费几分钟时间，数据录入中……');
            install(0);
        });

        Wind.use("noty", function () {

        });

        var $installMsgPanel = $('#install-msg-panel');
        var $log             = $("#log");
        var execSuccessTpl   = $('#exec-success-msg-tpl').html();
        var execFailTpl      = $('#exec-fail-msg-tpl').html();
        var sqlExecResult;

        function install(sqlIndex) {
            $.ajax({
                headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{url('install/start')}}",
                data: {sql_index: sqlIndex},
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    console.log(data);
                    var line = sqlIndex + 1;
                    if (data.status == 200) {

                        if (!(data.data && data.data.done)) {
                            var tpl = execSuccessTpl;
                            tpl     = tpl.replace(/\{message\}/g, line + '.' + data.msg);
                            // tpl     = tpl.replace(/\{sql\}/g, data.data.sql);
                            $installMsgPanel.append(tpl);

                        } else {
                            $installMsgPanel.append('<li><i class="fa fa-check correct"></i>数据库安装完成!</li>');

                            sqlExecResult = data.data;

                            if (data.data.error) {
                                noty({
                                    text: "安装过程,共" + data.data.error + "个SQL执行错误,可能您在此数据库下已经安装过,请查看问题后重新安装,或者<br>"
                                    + '<a target="_blank" href="#">反馈问题</a>',
                                    type: 'confirm',
                                    layout: "center",
                                    timeout: false,
                                    modal: true,
                                    buttons: [
                                        {
                                            addClass: 'btn btn-primary',
                                            text: '确定',
                                            onClick: function ($noty) {
                                                $noty.close();
                                            }
                                        },
                                        {
                                            addClass: 'btn btn-danger',
                                            text: '取消',
                                            onClick: function ($noty) {
                                                $noty.close();

                                            }
                                        }
                                    ]
                                });
                            } else {
                                stepAction(0)
                            }
                        }

                    } else  {  //if (data.code == 0)

                        var tpl = execFailTpl;
                        tpl     = tpl.replace(/\{message\}/g, line + '.' + data.msg);
                        tpl     = tpl.replace(/\{sql\}/g, data.data.sql);
                        tpl     = tpl.replace(/\{exception\}/g, data.data.exception);
                        $installMsgPanel.append(tpl);
                    }

                    $log.scrollTop(1000000000);

                    if (!(data.data && data.data.done)) {
                        sqlIndex++;
                        install(sqlIndex);
                    }


                },
                error: function () {

                },
                complete: function () {

                }
            });
        }

        var stepUrls = [
            "{{url('install/setDbConfig')}}",
            "{{url('install/setSite')}}",
        ];

        function stepAction(index) {
            $.ajax({
                headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: stepUrls[index],
                dataType: 'json',
                data: {_hithinkcmf: 1},
                type: 'post',
                success: function (data) {
                    if (data.status == 200) {
                        $installMsgPanel.append('<li><i class="fa fa-check correct"></i>' + data.msg + '</li>');
                        $log.scrollTop(1000000000);
                        if (index + 1 == stepUrls.length) {
                            $('a.install-load').html('<i class="fa fa-check correct"></i>安装完成！');
                            $('a.install-ok').show();
                        } else {
                            index++;
                            stepAction(index);
                        }
                    } else {
                        $installMsgPanel.append('<li><i class="fa fa-remove error"></i>' + data.msg + '</li>');
                        $log.scrollTop(1000000000);
                        noty({
                            text: data.msg,
                            type: 'confirm',
                            layout: "center",
                            timeout: false,
                            modal: true,
                            buttons: [
                                {
                                    addClass: 'btn btn-primary',
                                    text: '重试',
                                    onClick: function ($noty) {
                                        $noty.close();
                                        stepAction(index);
                                    }
                                },
                                {
                                    addClass: 'btn btn-danger',
                                    text: '取消',
                                    onClick: function ($noty) {
                                        $noty.close();
                                    }
                                }
                            ]
                        });
                    }

                },
                error: function () {

                }
            });
        }
    </script>
</body>
</html>
