@include("admin.".ADMIN_SKIN.".header")
<style>

    .countrylist nav{
        overflow-y: hidden;
    }
    .countrylist nav.float-right{
        float: none !important;
    }
    .countrylist nav ul li{
        white-space: nowrap;
    }
</style>
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
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("common_system_setting")}}</a></li>
            <li class="breadcrumb-item active">{{getTranslateByKey("common_country_list")}}</li>
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
                                        {{getTranslateByKey("common_country_list")}}
                                        <div class="btn-group float-right">
                                            <a href="{{url('admin/currency/add')}}" class="btn btn-default btn-sm">
                                                <em class="fa fa-plus"></em>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th>{{getTranslateByKey("country_flag")}}</th>
                                                <th>{{getTranslateByKey("country_chinese_name")}}</th>
                                                <th>{{getTranslateByKey("country_code")}}</th>

                                                <th>{{getTranslateByKey("common_action")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($country as $value)
                                                <tr>

                                                    <td></td>
                                                    <td>{{$value->c_country_name}}</td>
                                                    <td>{{$value->c_country_code}}</td>

                                                    <td>
                                                        <a class="btn btn-teal" href="{{url('admin/region/'.$value->c_country_code)}}">{{getTranslateByKey("country_look_area")}}</a> &nbsp;&nbsp;
                                                        {{--<a class="btn btn-teal" href="{{url('admin/country/edit?country_code='.$value->c_country_code)}}">编辑</a> &nbsp;&nbsp;
                                                        @if($value->is_fix==0) <a class="btn btn-danger" href="javascript:;" onclick="delData({{$value->id}})">删除</a> @endif--}}
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
                            <div class="col-md-6"></div>
                            <div class="col-sm-12 col-md-6 countrylist">
                                {{ $country->links('globals.pagination.admin',['country'=>$country]) }}
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

        location.href="{{url('admin/currency')}}?id="+id;

    }
</script>