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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("other_relate")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("other_relate_case")}}</li>
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
                                        <div class="casetitle">
                                            {{getTranslateByKey("other_relate_case_list")}}
                                        </div>
                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/case/add')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                        <div class="btn-group float-right">
                                            <form action="{{url('admin/case')}}" method="get">
                                                <div class="card-search">
                                                    <input type="text" class="form-control" placeholder="Search inbox..." name="search" value="{{isset($params['search']) ? $params['search'] : ''}}">
                                                    <span class="fa fa-search" onclick="$('form').submit()"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th>#id</th>
                                                <th>{{getTranslateByKey("common_cover")}}</th>
                                                <th>{{getTranslateByKey("common_name")}}</th>
                                                <th>{{getTranslateByKey("common_tag")}}</th>
                                                <th>{{getTranslateByKey("other_relate_case_category")}}</th>
                                                <th>{{getTranslateByKey("common_create_at")}}</th>
                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($case as $value)
                                                <tr>

                                                    <td>{{$value->id}}</td>
                                                    <td><img src="{{GetUrlByPath($value->cover)}}" height="100" /></td>
                                                    <td>{{$value->title}}</td>
                                                    <td>{{$value->tags}}</td>
                                                    <td>{{$value->category_name}}</td>
                                                    <td>{{$value->create_at}}</td>

                                                    <td>
                                                        <a class="btn btn-teal" href="{{url('admin/case/edit/'.$value->id)}}">{{getTranslateByKey("common_edit")}}</a> &nbsp;&nbsp;
                                                        <a class="btn btn-danger" href="javascript:;" onclick="delData({{$value->id}})">{{getTranslateByKey("common_delete")}}</a>
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
                                {{ $case->links('globals.pagination.admin', ['case'=>$case]) }}
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
                    action: function(){
                        location.href= "{{url('/admin/case/delete')}}"+"/"+id
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }
</script>
