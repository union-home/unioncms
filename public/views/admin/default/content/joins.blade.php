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
            <li class="breadcrumb-item active">招聘管理</li>
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
                                        <div class="joinstitle">
                                            招聘管理
                                        </div>
                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/content/join/add')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                        <div class="btn-group float-right">
                                            <form action="{{url('admin/content/join')}}" method="get">
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
                                                <th>状态</th>
                                                <th>职位</th>
                                                <th>发布时间</th>
                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($joins as $value)
                                                <tr>

                                                    <td>{{$value->id}}</td>
                                                    <td>{{$value->status==1?"启用":"禁用"}}</td>
                                                    <td>{{$value->position}}</td>
                                                    <td>{{$value->created_at}}</td>
                                                    <td>
                                                        <a class="btn btn-teal" href="{{url('admin/content/join/edit/'.$value->id)}}">{{getTranslateByKey("common_edit")}}</a> &nbsp;&nbsp;
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
                                {{ $joins->links('globals.pagination.admin',['joins'=>$joins]) }}
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
                        location.href= "{{url('admin/content/join/delete')}}"+"/"+id
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }
</script>
