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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("advertising_management")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("banner_list")}}</li>
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
                                    <div class="card-header card-default">
                                        <div class="faqtitle">
                                            {{getTranslateByKey("banner_list")}}
                                        </div>
                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/banner/add')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                        {{--<div class="btn-group float-right">
                                            <form method="get">
                                                <div class="card-search">
                                                    <input type="text" class="form-control"
                                                           placeholder="Search inbox..." name="search"
                                                           value="{{isset($params['search']) ? $params['search'] : ''}}">
                                                    <span class="fa fa-search" onclick="$('form').submit()"></span>
                                                </div>
                                            </form>
                                        </div>--}}
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th>{{getTranslateByKey("req_type")}}</th>
                                                <th>{{getTranslateByKey("common_image")}}</th>
                                                <th>{{getTranslateByKey("advertising_type")}}</th>
                                                <th>{{getTranslateByKey("is_it_self_run")}}</th>
                                                <th>{{getTranslateByKey("need_to_log_in")}}</th>
                                                <th>{{getTranslateByKey("whether_within_the_company")}}</th>
                                                <th>{{getTranslateByKey("content_roll_url")}}</th>
                                                <th>{{getTranslateByKey("common_status")}}</th>
                                                <th>{{getTranslateByKey("common_create_at")}}</th>
                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($ad as $value)
                                                <tr>

                                                    <td>{{getReqType()[$value->req_type]}}</td>
                                                    <td>
                                                        <img src="{{GetUrlByPath($value->images)}}" alt="" width="100">
                                                    </td>
                                                    <td>
                                                        @if($value->type=='self')
                                                            APP自带
                                                        @else
                                                            跳转
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($value->is_self_support==1)
                                                            自营
                                                        @else
                                                            第三方
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($value->need_login==1)
                                                            需要
                                                        @else
                                                            不需要
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($value->is_company==1)
                                                            是
                                                        @else
                                                            不是
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($value->status==1)
                                                            <lable class="btn btn-xs btn-success">启用</lable>
                                                        @else
                                                            <lable class="btn btn-xs btn-danger">禁用</lable>
                                                        @endif
                                                    </td>
                                                    <td>{{$value->url}}</td>
                                                    <td>{{date('Y-m-d H:i:s',$value->create_at)}}</td>

                                                    <td>
                                                        <a class="btn btn-teal"
                                                           href="{{url('admin/banner/edit?id='.$value->id)}}">
                                                            {{getTranslateByKey("common_edit")}}
                                                        </a>
                                                        &nbsp;&nbsp;
                                                        <a class="btn btn-danger" href="javascript:;"
                                                           onclick="delData({{$value->id}})">{{getTranslateByKey("common_delete")}}</a>
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
                                {{ $ad->links('globals.pagination.admin',['ad'=>$ad]) }}
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
    function delData(id) {
        $.confirm({
            title: '{{getTranslateByKey("common_tip")}}',
            content: '{{getTranslateByKey("common_sure_to_delete")}}',
            type: 'default',
            buttons: {
                ok: {
                    text: "{{getTranslateByKey('common_ensure')}}",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function () {
                        location.href = "{{url('/admin/banner/delete')}}" + "/" + id
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });
    }
</script>
