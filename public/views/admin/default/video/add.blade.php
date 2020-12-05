@include("admin.".ADMIN_SKIN.".header")


<body class="horizontal">

<!-- ============================================================== -->
<!-- 						Topbar Start 							-->
<!-- ============================================================== -->
@include("admin.".ADMIN_SKIN.".topbar")
<!-- ============================================================== -->
<!--                        Topbar End                              -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- 						Navigation Start 						-->
<!-- ============================================================== -->
@include("admin.".ADMIN_SKIN.".nav")
<!-- ============================================================== -->
<!-- 						Navigation End	 						-->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- 						Content Start	 						-->
<!-- ============================================================== -->

<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("common_home_page")}}</a></li>
            <li class="breadcrumb-item"><a href="#">内容管理</a></li>
            <li class="breadcrumb-item active">添加视频</li>
        </ol>
    </div>
</div>

<section class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <section class="main-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-body">
                                        <form method="post" action="" id="post_form" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            {{--<div class="form-group ">
                                                <label>
                                                    专辑列表
                                                </label>
                                                <select name="cid" class="form-control m-b" readonly>

                                                    @foreach($category as $value)
                                                        <option value='{{$value["id"]}}'
                                                                @if($_GET['cid']==$value["id"]) selected @endif >
                                                            {{$value["name"]}}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>--}}

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_name")}}</label>
                                                <input type="text" name="title" value="" required
                                                       class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>类型</label>
                                                <div class="form-inline">
                                                    @foreach(\App\Models\Video::type as $key=>$val)
                                                        <div class="radio radio-inline radio-success">
                                                            <input id="{{$key}}" type="radio" name="type"
                                                                   value="{{$key}}"
                                                                   @if($key=='local') checked @endif
                                                            >
                                                            <label for="{{$key}}"> {{$val}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="form-group file">
                                                <label>视频路径</label>
                                                <input type="file" name="file" value=""
                                                       class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group url" style="display:none;">
                                                <label>视频路径</label>
                                                <input type="text" name="url" value=""
                                                       class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group">
                                                <label>视频排序</label>
                                                <input type="number" name="sort" value="0"
                                                       class="form-control form-control-rounded">
                                            </div>


                                            <div class="form-group " style="display:none;">
                                                <label>{{getTranslateByKey("common_hot_active")}}</label>
                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="is_hot" type="radio" name="is_hot" value="0" checked>
                                                        <label for="is_hot"> {{getTranslateByKey("common_not_hot")}} </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="is_hot2" type="radio" name="is_hot" value="1">
                                                        <label for="is_hot2"> {{getTranslateByKey("common_hot")}} </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group " style="display:none;">
                                                <label>{{getTranslateByKey("common_rec_active")}}</label>
                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="is_rec" type="radio" name="is_rec" value="0" checked>
                                                        <label for="is_rec"> {{getTranslateByKey("common_not_rec")}} </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="is_rec2" type="radio" name="is_rec" value="1">
                                                        <label for="is_rec2"> {{getTranslateByKey("common_rec")}} </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group " style="display:none;">
                                                <label>简介</label>

                                                <textarea name="introduct" style="height: 150px;" required></textarea>
                                            </div>

                                            <input type="hidden" name="cid" value="{{$_GET['cid']}}" >

                                            <button type="button"
                                                    class="btn btn-primary margin-l-5 mx-sm-3 sub">
                                                {{getTranslateByKey("common_submit")}}
                                            </button>
                                            <button type="button" onclick="history.go(-1);"
                                                    class="btn btn-default ">
                                                {{getTranslateByKey("common_back")}}
                                            </button>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </section>


                </div>
            </div>
        </div>
    </div>

    @include('admin/'.ADMIN_SKIN.'/footer')


</section>
<!-- ============================================================== -->
<!-- 						Content End		 						-->
<!-- ============================================================== -->


<!-- Common Plugins -->
@include('admin/default/js',['load'=> ["custom"]])

</body>

</html>
<script>
    $('input[name="type"]').click(function () {
        var type = $('input[name="type"]:checked').val();
        if (type == 'local') {
            $('.file').show();
            $('.url').hide();
        } else {
            $('.url').show();
            $('.file').hide();
        }

    });
    $('.sub').click(function () {
        popup({type: 'load', msg: "正在请求", delay: 50000});
        $('#post_form').submit();
    });
</script>
