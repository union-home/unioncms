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
            <li class="breadcrumb-item active">{{getTranslateByKey("feedback_manage")}}</li>
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
                                        {{getTranslateByKey("feedback_list")}}
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#id</th>
                                                <th>{{getTranslateByKey("common_user_unique")}}</th>
                                                <th>{{getTranslateByKey("common_user_name")}}</th>
                                                <th>{{getTranslateByKey("common_email")}}</th>
                                                <th>{{getTranslateByKey("common_user_tel")}}</th>
                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($datas as $value)
                                                <tr>
                                                    <td>{{$value->id}}</td>
                                                    <td>{{$value->uid}}</td>
                                                    <td>{{$value->user_name}}</td>
                                                    <td>{{$value->user_email}}</td>
                                                    <td>{{$value->user_tel}}</td>
                                                    <td>
                                                        <a class="btn btn-teal" href="{{url('admin/feedbacks/edit/'.$value->id)}}">{{getTranslateByKey("common_edit")}}</a> &nbsp;&nbsp;
                                                        @if($value->default==0) <a class="btn btn-danger" href="javascript:;" onclick="delData({{$value->id}})">{{getTranslateByKey("common_delete")}}</a> @endif
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
                                {{ $datas->links('globals.pagination.admin',['pages'=>$datas]) }}
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
                        location.href= "{{url('/admin/feedbacks/delete')}}"+"/"+id
                    }
                },
                cancel: {
                    text: "{{getTranslateByKey('common_cancel')}}"
                }
            }
        });

    }
</script>
</body>
</html>
