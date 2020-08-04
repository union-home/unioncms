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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("user_info")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("user_login_histry")}}</li>
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
                                        {{getTranslateByKey("user_login_histry")}}
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                {{--<th>#id</th>--}}
                                                <th>{{getTranslateByKey("common_uid")}}</th>

                                                <th>{{getTranslateByKey("common_ip")}}</th>
                                                <th>{{getTranslateByKey("device_type")}}</th>
                                                <th>{{getTranslateByKey("device_name")}}</th>
                                                <th>{{getTranslateByKey("common_login_at")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($history as $val)
                                            <tr>
                                                {{--<td></td>--}}
                                                <td>{{$val->uid}}</td>
                                                <td>{{$val->ip}}</td>
                                                <td>{{$val->device_type}}</td>
                                                <td>{{$val->device_name}}</td>
                                                <td>{{$val->login_at}}</td>
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
                                {{ $history->links('globals.pagination.admin',['history'=>$history]) }}
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