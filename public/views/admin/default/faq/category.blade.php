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
            <li class="breadcrumb-item active">{{getTranslateByKey("other_relate_faq_category")}}</li>
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
                                        {{getTranslateByKey("other_relate_faq_category")}}
                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/faq/category/add')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th>#id</th>
                                                <th>{{getTranslateByKey("common_name")}}</th>
                                                <th>{{getTranslateByKey("common_describe")}}</th>
                                                <th>{{getTranslateByKey("common_icon")}}</th>
                                                <th>{{getTranslateByKey("common_create_at")}}</th>
                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($category as $value)
                                                <tr>

                                                    <td>{{$value->id}}</td>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{$value->describe}}</td>
                                                    <td>{{$value->icon}}</td>
                                                    <td>{{$value->create_at}}</td>

                                                    <td>
                                                        <a class="btn btn-teal" href="{{url('admin/faq/category/edit/'.$value->id)}}">{{getTranslateByKey("common_edit")}}</a> &nbsp;&nbsp;
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
                                {{ $category->links('globals.pagination.admin',['category'=>$category]) }}
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
                        location.href= "{{url('/admin/faq/category/delete')}}"+"/"+id
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }
</script>