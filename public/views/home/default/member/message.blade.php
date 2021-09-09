@include("home.".HOME_SKIN.".member.header")

@include("home.".HOME_SKIN.".member.nav")

<style type="text/css">
    .pagination-group>ul>li{display: inline;}
    table img{max-width: 100px;}
</style>
<main class="main px-md-5 p-md-3 p-3  bc-2nd-f7">
    <div class="product">
        <div class="setting">
            <div class="row">
                <div class="col-12">
                    <div class="setting-header">
                        <span class="mr-2"></span>
                        <h6 class="d-inline">留言板</h6>
                    </div>
                </div>
            </div>
            <div class="userinfo-content mt-md-3 mt-3 px-md-5 px-2 pb-3">
                <form method="post" action="" id="post_form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="userinfo-group">
                                <span class="userinfo-text">姓名：</span>
                                <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="text" placeholder="请输入姓名" name="user_name">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="userinfo-group">
                                <span class="userinfo-text">邮箱：</span>
                                <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="email" placeholder="请输入邮箱" name="user_email">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="userinfo-group">
                                <span class="userinfo-text">电话：</span>
                                <input class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1" type="phone" placeholder="请输入电话" name="user_tel">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="userinfo-group message-group">
                                <span class="userinfo-text mt-2 align-top">内容：</span>
                                <textarea class="d-md-inline-block d-block w-25 mt-2 border px-2 py-1 bc-gray-f2" type="text" name="content" placeholder="留言须审核后才会显示"></textarea>
                            </div>
                        </div>
                        <div class="col-12 my-3">
                            <span class="userinfo-text mt-2 align-top d-md-inline-block d-none"></span>
                            <a href="javascript:" id="post_button">
                                <span class="message-submit d-inline-block text-white bc-theme py-2 px-5">提交留言</span>
                            </a>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <p class="border-bottom py-3">全部留言：</p>
                    </div>
                    <div class="col-12 text-center message-group">
                        @if(($datas->toArray())['total'] <= 0)
                            <div class="p-3 nomessage">
                                <img src="{{HOME_ASSET}}assets/member/img/nomessage-img.png" alt="">
                                <p class="pt-3 tc-gray-99">亲~还没有留言哦</p>
                            </div>
                        @else
                            <section class="main-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header card-default">
                                                留言列表
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>#id</th>
                                                        <th>名称</th>
                                                        <th>电子邮箱</th>
                                                        <th>会员电话</th>
                                                        <th>内容</th>
                                                        <th>操作</th>
                                                    </tr>
                                                    </thead>
                                                        <tbody>
                                                        @foreach($datas as $data)
                                                            <tr>
                                                                <td>{{$data->id}}</td>
                                                                <td>{{$data->user_name}}</td>
                                                                <td>{{$data->user_email}}</td>
                                                                <td>{{$data->user_tel}}</td>
                                                                <!-- <td>{{$data->content}}</td> -->
                                                                <td>{!! $data->content !!}</td>
                                                                <td>
                                                                    <a class="btn btn-danger" href="javascript:;" onclick="delData({{$data->id}})">删除</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        {{ $datas->links("home.".HOME_SKIN.".globals.pagination.page",['datas'=>$datas]) }}
                                    </div>
                                </div>
                            </section>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
</main>


@include("home.".HOME_SKIN.".footer")

<script src="{{HOME_ASSET}}assets/member/js/setting.js"></script>


<link rel="stylesheet" type="text/css" href="{{ADMIN_ASSET}}assets/other/DialogJS/style/dialog.css">
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/zepto.min.js"></script>
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/DialogJS/javascript/dialog.min.js"></script>


<link rel="stylesheet" href="{{ADMIN_ASSET}}assets/css/jquery-confirm.min.css">
<script type="text/javascript" src="{{ADMIN_ASSET}}assets/js/jquery-confirm.min.js"></script>


<script type="text/javascript">
    $(function(){
        $("#post_button").click(function () {
            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                $.ajax({
                    "method":"post",
                    "url" : "{{url('member/addFeedback')}}",
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
    })

    function delData(id) {
        $.confirm({
            title: '{{getHomeByKey("common_tip")}}',
            content: '{{getHomeByKey("common_sure_to_delete")}}',
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getHomeByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                            $.ajax({
                                headers: {
                                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                "method":"post",
                                "url" : "{{url('member/feedback/delete')}}"+"/"+id,
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
                    }
                },
                cancel: {
                    text: "{{getHomeByKey('common_cancel')}}"
                }
            }
        });
    }
</script>