<!-- Common Plugins -->
<script src="{{ADMIN_ASSET}}assets/lib/jquery/dist/jquery.min.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/bootstrap/js/popper.min.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/pace/pace.min.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/ace-menu/ace-responsive-menu-min.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/nano-scroll/jquery.nanoscroller.min.js"></script>
<script src="{{ADMIN_ASSET}}assets/lib/metisMenu/metisMenu.min.js"></script>

<!-- Jquery UI -->
<script src="{{ADMIN_ASSET}}assets/lib/jquery-ui/jquery-ui.min.js"></script>
<script src="{{ADMIN_ASSET}}assets/js/jquery.ui.custom.js"></script>

<!--Sweet Alerts-->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/zepto.min.js"></script>
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/dialog.min.js"></script>

<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/jqueryToast/js/toast.script.js"></script>

<script type="text/javascript" src="{{ADMIN_ASSET}}assets/layer/layer/layer.js"></script>

<!---->
@foreach($load as $value)
    @if($value)
        <script src="{{ADMIN_ASSET}}assets/js/{{$value}}.js"></script>
    @endif
@endforeach

<script>

    var toastMsg;
    var toastType

    @if(session('errormsg'))

        toastMsg = "{{session('errormsg')}}";
    toastType = 'error';

    @elseif(session('successmsg'))

        toastMsg = "{{session('successmsg')}}";
    toastType = 'success';

    @endif

    if (toastMsg) {
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
        toastMsg = null

    }

    //清空缓存
    function clearCache() {

        var index = layer.load(1, {
            shade: [0.5, '#000'],//0.1透明度的白色背景
            content: '正在清理中...',
            success: function (layero) {
                layero.find('.layui-layer-content').css({
                    'padding-top': '39px',
                    'width': '80px',
                    "color": "#FFF",
                    "background-position": "center center"
                });
            }
        });

        $.ajax({
            "method": "post",
            "url": "{{url('admin/clear')}}",
            "dataType": 'json',
            "data": {"_token": "{{csrf_token()}}"},
            "success": function (res) {
                layer.closeAll();
                if (res.stauts == 200) {
                    popup({
                        type: "success", msg: res.msg, delay: 2000, callBack: function () {
                            window.location.reload();
                        }
                    });
                } else {
                    popup({
                        type: "error", msg: res.msg, delay: 2000, callBack: function () {
                            window.location.reload();
                        }
                    });
                }
            },
            "error": function (res) {
                console.log(res);
            }
        })
    }


    //更新
    function cmsUpdateVersion(update_version) {
        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: '{{getTranslateByKey("common_sure_to_update_cms")}}',
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function () {
                        download(update_version);
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });
    }

    //开始下载
    function download(update_version) {

        var index = layer.load(1, {
            shade: [0.5, '#000'],//0.1透明度的白色背景
            content: '版本备份中...',
            success: function (layero) {
                layero.find('.layui-layer-content').css({
                    'padding-top': '39px',
                    'width': '80px',
                    "color": "#FFF",
                    "background-position": "center center"
                });
            }
        });

        bakFiles(update_version, index);
    }

    //备份
    function bakFiles(update_version, index) {

        var time = '{{time()}}';
        var params = '?identification=cms&cloud_type=2&version=' + update_version + '&time=' + time;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            "method": "post",
            "url": "{{url('admin/updateCmsVersion')}}" + params,
            "dataType": 'json',
            "cache": false,
            "processData": false,
            "contentType": false,
            "success": function (res) {
                if (res.status == 200) {
                    layer.closeAll();
                    popup({type: "success", msg: res.msg, delay: 2000});
                    setTimeout(function () {
                        update(update_version);
                    }, 2000);

                } else {
                    popup({type: "error", msg: res.msg, delay: 2000});
                }
            },
            "error": function (res) {
                console.log(res);
            }
        });

    }

    //更新
    function update(update_version) {

        layer.open({
            type: 1,
            skin: 'layui-layer-demo', //样式类名
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: false, //开启遮罩关闭
            content: '<div class="col-md-12">\n' +
                '    <div class="card">\n' +
                '        <div class="card-header card-default">\n' +
                '            正在下载最新版本，请稍后...\n' +
                '        </div>\n' +
                '        <div class="card-body">\n' +
                '            <div class="progress-info text-muted">完成 <span class="float-right" id="progress-info">0%</span></div>\n' +
                '            <div class="progress">\n' +
                '                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '</div>'
        });

        var file_size = 0;
        var progress = 0;

        var time = '{{time()}}';
        var params = '?identification=cms&cloud_type=2&version=' + update_version + '&time=' + time + "&is_update=true&action=prepare-download&origin_host="+"{{$_SERVER["HTTP_HOST"]}}";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            "method": "post",
            "url": "{{url('admin/updateCmsVersion')}}" + params,
            "dataType": 'json',
            "cache": false,
            "processData": false,
            "contentType": false,
        })
            .done(function (json) {

                file_size = json.file_size;

                var params = '?identification=cms&cloud_type=2&version=' + update_version + '&time=' + time + "&is_update=true&action=start-download&origin_host="+"{{$_SERVER["HTTP_HOST"]}}";

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    "method": "post",
                    "url": "{{url('admin/updateCmsVersion')}}" + params,
                    "dataType": 'json',
                    "cache": false,
                    "processData": false,
                    "contentType": false,
                })
                    .done(function (json) {
                        // set progress to 100 when got the response
                        progress = 100;

                        console.log("Downloading finished");
                        console.log(json);
                    })
                    .fail(showAjaxError);

                var interval_id = window.setInterval(function () {

                    $('#progress-info').html(progress + "%");
                    $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress).html(progress + "%");

                    if (progress == 100) {
                        clearInterval(interval_id);
                        layer.closeAll();
                        // 到此远程文件下载完成，继续其他逻辑
                        var index = layer.load(1, {
                            shade: [0.5, '#000'],//0.1透明度的白色背景
                            content: '版本升级中...',
                            success: function (layero) {
                                layero.find('.layui-layer-content').css({
                                    'padding-top': '39px',
                                    'width': '80px',
                                    "color": "#FFF",
                                    "background-position": "center center"
                                });
                            }
                        });

                        var params = '?identification=cms&cloud_type=2&version=' + update_version + '&time=' + time + "&is_update=true&action=unzip-file&origin_host="+"{{$_SERVER["HTTP_HOST"]}}";

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            "method": "post",
                            "url": "{{url('admin/updateCmsVersion')}}" + params,
                            "dataType": 'json',
                            "cache": false,
                            "processData": false,
                            "contentType": false,
                        })
                            .done(function (res) {

                                if (res.status == 200) {
                                    layer.closeAll();
                                    popup({type: "success", msg: res.msg, delay: 2000});
                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000);

                                } else {
                                    popup({type: "error", msg: res.msg, delay: 2000});
                                }

                            })
                            .fail(showAjaxError)


                    } else {
                        var params = '?identification=cms&cloud_type=2&version=' + update_version + '&time=' + time + "&is_update=true&action=get-file-size&origin_host="+"{{$_SERVER["HTTP_HOST"]}}";

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            "method": "post",
                            "url": "{{url('admin/updateCmsVersion')}}" + params,
                            "dataType": 'json',
                            "cache": false,
                            "processData": false,
                            "contentType": false,
                        })
                            .done(function (json) {
                                progress = (json.size / file_size * 100).toFixed(2);

                                // updateProgress(progress);

                                console.log("Progress: " + progress);
                            })
                            .fail(showAjaxError);
                    }

                }, 300);

            })
            .fail(showAjaxError);

    }

    function showAjaxError() {
        layer.alert('网络错误！', {
            icon: 1,
            skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
        })
    }


</script>





