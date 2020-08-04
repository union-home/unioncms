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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("common_user_manage")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("common_manager")}}</li>
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
                                        <div class="card-header-title">
                                            {{getTranslateByKey("admin_manager_list")}}
                                        </div>

                                        <div class="btn-group  float-right float-right1">
                                            <a href="{{url('admin/member/add')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                        <div class="btn-group float-right float-right1">
                                            <form action="{{url('admin/admins')}}" method="get">
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
                                                <th>{{getTranslateByKey("common_username")}}</th>
                                                <th>{{getTranslateByKey("common_nickusername")}}</th>
                                                <th>{{getTranslateByKey("common_phone_number")}}</th>
                                                <th>{{getTranslateByKey("common_email_address")}}</th>
                                                <th>{{getTranslateByKey("common_create_at")}}</th>
                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($members as $member)
                                            <tr>
                                                <td>{{$member->uid}}</td>
                                                <td>{{$member->username}}</td>
                                                <td>{{$member->nickname}}</td>
                                                <td>{{$member->phone}}</td>
                                                <td>{{$member->email}}</td>
                                                <td>{{$member->create_at}}</td>
                                                <td>
                                                    @if($member->uid != "1")
                                                        <a href="{{url('/admin/userinfo/'.$member->uid)}}" class="btn btn-teal">{{getTranslateByKey("common_edit")}}</a>
                                                        <a href="javascript: void(0);" class="btn btn-danger">{{getTranslateByKey("common_disable")}}</a>
                                                    @endif

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
                                {{ $members->links('globals.pagination.admin',['members'=>$members]) }}
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