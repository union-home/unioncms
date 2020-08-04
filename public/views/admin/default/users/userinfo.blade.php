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
            <li class="breadcrumb-item active">{{getTranslateByKey("user_details")}}</li>
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
                                        <form method="post" action="" id="userinfo_form" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <input name="uid" value="{{$member['uid']}}" type="hidden" />
                                            <div class="form-group">
                                                <label>{{getTranslateByKey("user_avater")}}</label>
                                                <div class="fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview" data-trigger="fileinput" style="width: 200px; height:200px;">
                                                        <img src="{{GetUrlByPath($member['avatar'])}}" style="width: 180px; height:180px;">
                                                    </div>
                                                    <span class="btn btn-primary  btn-file">
                                                        <span class="fileinput-new">{{getTranslateByKey("common_select")}}</span>
                                                        <span class="fileinput-exists">{{getTranslateByKey("common_change")}}</span>
                                                        <input type="file" id="image" name="avatar">
                                                    </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">{{getTranslateByKey("common_delete")}}</a>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_username")}}</label>
                                                <input type="text" name="username" value="{{$member['username']}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_nickusername")}}</label>
                                                <input type="text" name="nickname" value="{{$member['nickname']}}" class="form-control form-control-rounded">
                                            </div>

                                            <div class="form-group">
                                                <fieldset class="jquery-Ui-fieldset">
                                                    <label for="select-icons-button">{{getTranslateByKey("common_member_type")}}</label>
                                                    <select id="select-type" disabled style="display: none;">
                                                        <optgroup label="用户类型">
                                                            <option @if($member['type']=="admin") selected @endif >{{getTranslateByKey("common_manager")}}</option>
                                                            <option @if($member['type']=="agent") selected @endif>{{getTranslateByKey("common_agent_account")}}</option>
                                                            <option @if($member['type']=="member") selected @endif>{{getTranslateByKey("common_member")}}</option>
                                                        </optgroup>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            @if($member['type']!="member")

                                                <div class="form-group">
                                                    <label for="select-icons-button">{{getTranslateByKey("common_gid_group")}}</label>
                                                    <div class="row">
                                                        @foreach($MenuGroup as $value)
                                                            <div class="col-sm-2">
                                                                <label for="group-{{$value["id"]}}">
                                                                    <input type="checkbox" name="gid[]" @if(in_array($value["id"],explode(",",$member["gid"]))) checked @endif value="{{$value["id"]}}" id="group-{{$value["id"]}}" /> {{$value["name"]}}
                                                                </label>

                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>

                                            @endif


                                            {{--<div class="form-group">--}}
                                                {{--<fieldset class="jquery-Ui-fieldset">--}}
                                                    {{--<label for="select-icons-button">所在地区</label>--}}
                                                    {{--<select name="" id="select-icons" style="display: none;">--}}
                                                        {{--<optgroup label="Browsers">--}}
                                                            {{--<option value="chrome" data-icon="fa-chrome" selected="selected">Chrome</option>--}}
                                                            {{--<option value="firefox" data-icon="fa-firefox">Firefox</option>--}}
                                                            {{--<option value="safari" data-icon="fa-safari">Safari</option>--}}
                                                            {{--<option value="opera" data-icon="fa-opera">Opera</option>--}}
                                                            {{--<option value="IE" data-icon="fa-internet-explorer">IE</option>--}}
                                                        {{--</optgroup>--}}
                                                    {{--</select>--}}
                                                {{--</fieldset>--}}
                                            {{--</div>--}}

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_contact_phone")}}</label>
                                                <input type="text" name="phone" value="{{$member['phone']}}" class="form-control form-control-rounded">
                                            </div>


                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_phone_active")}}</label>

                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="phone_active" type="radio" name="phone_active" value="0" @if($member['phone_active']==0) checked @endif >
                                                        <label for="phone_active"> {{getTranslateByKey("common_not_active")}} </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="phone_active1" type="radio" name="phone_active" value="1" @if($member['phone_active']==1) checked @endif >
                                                        <label for="phone_active1"> {{getTranslateByKey("common_active")}} </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_email")}}</label>
                                                <input type="text" name="email" value="{{$member['email']}}" class="form-control form-control-rounded">
                                            </div>


                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_email_active")}}</label>

                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="email_active" type="radio" name="email_active" value="0" @if($member['email_active']==0) checked @endif >
                                                        <label for="email_active"> {{getTranslateByKey("common_not_active")}} </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="email_active2" type="radio" name="email_active" value="1" @if($member['email_active']==1) checked @endif >
                                                        <label for="email_active2"> {{getTranslateByKey("common_active")}} </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_account_status")}}</label>

                                                <div class="form-inline">
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="status" type="radio" name="status" value="0" @if($member['status']==0) checked @endif>
                                                        <label for="status"> {{getTranslateByKey("common_disable")}} </label>
                                                    </div>
                                                    <div class="radio radio-inline radio-success">
                                                        <input id="status1" type="radio" name="status" value="1" @if($member['status']==1) checked @endif>
                                                        <label for="status1"> {{getTranslateByKey("common_enable")}} </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group ">
                                                <label>{{getTranslateByKey("common_login_password")}}</label>
                                                <input type="text" name="password" placeholder="{{getTranslateByKey("user_if_empty_not_change")}}" class="form-control form-control-rounded">
                                            </div>



                                            <button type="button" id="userinfo_button" class="btn btn-primary margin-l-5 mx-sm-3">{{getTranslateByKey("common_submit")}}</button>
                                            <button type="button" id="ton" onclick="history.go(-1);" class="btn btn-default ">{{getTranslateByKey("common_back")}}</button>

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

    $(function () {

        $("#userinfo_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/userSubmit?form=update')}}",
                        "data":  new FormData($('#userinfo_form')[0]),                                  //$("#userinfo_form").serialize(),
                        "dataType":'json',
                        "cache":false,
                        "processData": false,
                        "contentType": false,
                        "success":function (res) {

                            if(res.stauts==200){
                                popup({type:"success",msg:res.msg,delay:2000});
                            }else{
                                popup({type:"error",msg:res.msg,delay:2000});
                            }
                        },
                        "error":function (res) {
                            console.log(res);
                        }
                    })
                }});



        })

    })

</script>