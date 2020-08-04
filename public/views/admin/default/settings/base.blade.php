@include("admin.".ADMIN_SKIN.".header")

<body class="horizontal">
<div id="load"></div>
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
<style type="text/css">
    .min-height-7-rem{min-height: 7rem;}
    .red{color: red}
</style>
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">首页</a></li>
            <li class="breadcrumb-item"><a href="#">系统设置</a></li>
            <li class="breadcrumb-item active">基本设置</li>
        </ol>
    </div>
</div>

<section class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="tabs">
                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs base-nav">
                            <li class="nav-item" role="presentation"><a class="nav-link  active" href="#website" aria-controls="website" role="tab" data-toggle="tab">网站设置</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="#contact" aria-controls="contact" role="tab" data-toggle="tab">联系我们</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="#email" aria-controls="email" role="tab" data-toggle="tab">SMTP邮箱设置</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="#sms" aria-controls="sms" role="tab" data-toggle="tab">SMS短信设置</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="#third_party" aria-controls="third_party" role="tab" data-toggle="tab">第三方代码</a></li>
                            {{--<li class="nav-item" role="presentation"><a class="nav-link" href="#oauth_config" aria-controls="oauth_config" role="tab" data-toggle="tab">第三方配置</a></li>--}}
                            <li class="nav-item" role="presentation"><a class="nav-link" href="#template_message" aria-controls="template_message" role="tab" data-toggle="tab">模板消息</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="website">
                                <section class="main-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post" action="{{url('admin/baseSubmit')}}" id="website_form" enctype='multipart/form-data'>
                                                        {{csrf_field()}}
                                                        <div class="form-group breadcrumb row">
                                                            <label for="" class="col-sm-12 col-form-label">前台相关</label>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label>网站名称</label>
                                                            <input type="text" name="website_name" value="{{cacheGlobalSettingsByKey('website_name')}}" placeholder="网站名称" class="form-control form-control-rounded">
                                                        </div>
                                                        <div class="form-group">
                                                            <ul class="nav nav-tabs">
                                                                <li class="nav-item" role="presentation"><a class="nav-link  active" href="#weblogo" aria-controls="weblogo" role="tab" data-toggle="tab">网站logo</a></li>
                                                                <li class="nav-item" role="presentation"><a class="nav-link" href="#webicon" aria-controls="contact" role="tab" data-toggle="tab">地址栏icon</a></li>
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div role="tabpanel" class="tab-pane active" id="weblogo">
                                                                    <div class="fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-preview" data-trigger="fileinput" style="width: 250px; height:75px;">
                                                                            @if(cacheGlobalSettingsByKey('weblogo'))<img class="img-fluid " src="{{GetLocalFileByPath(cacheGlobalSettingsByKey('weblogo'))}}">@endif
                                                                        </div>
                                                                        <span class="btn btn-primary  btn-file">
                                                                            <span class="fileinput-new">选择</span>
                                                                            <span class="fileinput-exists">更换</span>
                                                                            <input type="file" id="weblogo1" name="weblogo">
                                                                        </span>
                                                                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">删除</a>
                                                                    </div>
                                                                </div>

                                                                <div role="tabpanel" class="tab-pane" id="webicon">
                                                                    <div class="fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-preview" data-trigger="fileinput" style="width: 32px; height:32px;">
                                                                            @if(cacheGlobalSettingsByKey('webicon'))<img class="img-fluid " src="{{GetLocalFileByPath(cacheGlobalSettingsByKey('webicon'))}}">@endif
                                                                        </div>
                                                                        <span class="btn btn-primary  btn-file">
                                                                            <span class="fileinput-new">选择</span>
                                                                            <span class="fileinput-exists">更换</span>
                                                                            <input type="file" id="image" name="webicon">
                                                                        </span>
                                                                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">删除</a>
                                                                    </div>
                                                                    <p class="text-muted">
                                                                        <br>
                                                                        建议尺寸 64 * 64 (像素)的.ico文件。 <br>
                                                                        如果无法正常显示新上传图标，清空浏览器缓存后访问。
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>关键词</label>
                                                            <input type="text" name="website_keys" value="{{cacheGlobalSettingsByKey('website_keys')}}"  placeholder="关键词，不要超过100个字符！" class="form-control">
                                                        </div>
                                                        <div class="form-group ">
                                                            <label>描述</label>
                                                            <textarea placeholder="请填写描述，不要超过200个字符！" name="website_desc" class="form-text" rows="4" style="height: 100px;">{{cacheGlobalSettingsByKey('website_desc')}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>开启注册</label>
                                                            <div class="form-inline">
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="website_op_reg" name="website_open_reg" type="radio" value="1" @if(cacheGlobalSettingsByKey('website_open_reg') ==1) checked @endif>
                                                                    <label for="website_op_reg"> 开启 </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="website_op_reg2" name="website_open_reg" type="radio" value="0" @if(cacheGlobalSettingsByKey('website_open_reg') ==0) checked @endif >
                                                                    <label for="website_op_reg2"> 关闭 </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>注册验证</label>
                                                            <div class="form-inline">
                                                                <div class=" checkbox checkbox-inline checkbox-inverse">
                                                                    <input id="website_reg_rqstd" name="website_reg_rqstd[]" value="phone" type="checkbox" @if(in_array('phone',explode(",", cacheGlobalSettingsByKey('website_reg_rqstd')))) checked @endif>
                                                                    <label for="website_reg_rqstd"> 手机号码 </label>
                                                                </div>
                                                                <div class=" checkbox checkbox-inline checkbox-inverse">
                                                                    <input id="website_reg_rqstd2" name="website_reg_rqstd[]" value="email" type="checkbox" @if(in_array('email',explode(",", cacheGlobalSettingsByKey('website_reg_rqstd')))) checked @endif>
                                                                    <label for="website_reg_rqstd2"> 电子邮件 </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>开启多货币</label>
                                                            <div class="form-inline">
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="multi_currency" name="multi_currency" type="radio" value="1" @if(cacheGlobalSettingsByKey('multi_currency') ==1) checked @endif>
                                                                    <label for="multi_currency"> 开启 </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="multi_currency2" name="multi_currency" type="radio" value="0" @if(cacheGlobalSettingsByKey('multi_currency') ==0) checked @endif>
                                                                    <label for="multi_currency2"> 关闭 </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>默认货币</label>
                                                            <select name="default_currency" class="form-control m-b">
                                                                @foreach($currencys as $currency)
                                                                    <option value="{{$currency['id']}}" @if(cacheGlobalSettingsByKey('default_currency') ==$currency['id']) selected @endif>{{$currency["name"]}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>开启多语言</label>
                                                            <div class="form-inline">
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="multilingual" name="multilingual" type="radio" value="1" @if(cacheGlobalSettingsByKey('multilingual') ==1) checked @endif>
                                                                    <label for="multilingual"> 开启 </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="multilingual2" name="multilingual" type="radio" value="0" @if(cacheGlobalSettingsByKey('multilingual') ==0) checked @endif>
                                                                    <label for="multilingual2"> 关闭 </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>默认语言</label>
                                                            <select name="default_language" class="form-control m-b">
                                                                @foreach($languages["admin"] as $language)
                                                                    <option value="{{$language['shortcode']}}" @if(cacheGlobalSettingsByKey('default_language') ==$language['shortcode']) selected @endif>{{$language["name"]}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label>网站维护</label>
                                                            <div class="form-inline">
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="website_statut" name="website_statut" type="radio" value="0" @if(cacheGlobalSettingsByKey('website_statut') ==0) checked @endif>
                                                                    <label for="website_statut"> 维护中 </label>
                                                                </div>
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="website_statut2" name="website_statut" type="radio" value="1" @if(cacheGlobalSettingsByKey('website_statut') ==1) checked @endif>
                                                                    <label for="website_statut2"> 正常 </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>维护中显示的文字</label>
                                                            <input type="text" name="website_statut_when" placeholder="维护中显示的文字" value="{{cacheGlobalSettingsByKey('website_statut_when')}}" class="form-control">
                                                        </div>
                                                        <div class="form-group breadcrumb row">
                                                            <label for="" class="col-sm-12 col-form-label">后台相关</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>调式模式</label>
                                                            <div class="form-inline">
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="website_debug" name="website_debug" value="true" type="radio" @if(env('APP_DEBUG') == true) checked @endif>
                                                                    <label for="website_debug"> 开启 </label>
                                                                </div>
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="website_debug2" name="website_debug" value="false" type="radio" @if(env('APP_DEBUG') == false) checked @endif >
                                                                    <label for="website_debug2"> 关闭 </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <p class="text-muted">
                                                                    将显示错误信息到html上
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>日志模式</label>
                                                            <div class="form-inline">
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG1" name="APP_LOG" value="single" type="radio" @if(env('APP_LOG') =='single') checked @endif>
                                                                    <label for="APP_LOG1"> single(单文件) </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG2" name="APP_LOG" value="daily" type="radio" @if(env('APP_LOG') =='daily') checked @endif >
                                                                    <label for="APP_LOG2"> daily(日期模式) </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG3" name="APP_LOG" value="syslog" type="radio" @if(env('APP_LOG') =='syslog') checked @endif >
                                                                    <label for="APP_LOG3"> syslog(记录到syslog中) </label>
                                                                </div>
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG4" name="APP_LOG" value="errorlog" type="radio" @if(env('APP_LOG') =='errorlog') checked @endif >
                                                                    <label for="APP_LOG4"> errorlog(记录到PHP的error_log中) </label>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label>日志级别</label>
                                                            <div class="form-inline">
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG_LEVEL1" name="LOG_LEVEL" value="debug" type="radio" @if(env('LOG_LEVEL') =='debug') checked @endif>
                                                                    <label for="APP_LOG_LEVEL1"> debug </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG_LEVEL2" name="LOG_LEVEL" value="info" type="radio" @if(env('LOG_LEVEL') =='info') checked @endif >
                                                                    <label for="APP_LOG_LEVEL2"> info </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG_LEVEL3" name="LOG_LEVEL" value="notice" type="radio" @if(env('LOG_LEVEL') =='notice') checked @endif >
                                                                    <label for="APP_LOG_LEVEL3"> notice </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG_LEVEL4" name="LOG_LEVEL" value="warning" type="radio" @if(env('LOG_LEVEL') =='warning') checked @endif >
                                                                    <label for="APP_LOG_LEVEL4"> warning </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG_LEVEL5" name="LOG_LEVEL" value="error" type="radio" @if(env('LOG_LEVEL') =='error') checked @endif >
                                                                    <label for="APP_LOG_LEVEL5"> error </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG_LEVEL6" name="LOG_LEVEL" value="critical" type="radio" @if(env('LOG_LEVEL') =='critical') checked @endif >
                                                                    <label for="APP_LOG_LEVEL6"> critical </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG_LEVEL7" name="LOG_LEVEL" value="alert" type="radio" @if(env('LOG_LEVEL') =='alert') checked @endif >
                                                                    <label for="APP_LOG_LEVEL7"> alert </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="APP_LOG_LEVEL8" name="LOG_LEVEL" value="emergency" type="radio" @if(env('LOG_LEVEL') =='emergency') checked @endif >
                                                                    <label for="APP_LOG_LEVEL8"> emergency </label>
                                                                </div>
                                                            </div>

                                                        </div>


                                                         <div class="form-group">
                                                            <label>是否开启云运用</label>
                                                            <div class="form-inline">
                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="Useofcloud1" name="Useofcloud"
                                                                           value="true" type="radio"
                                                                           @if(cacheGlobalSettingsByKey('Useofcloud') =='true') checked @endif>
                                                                    <label for="Useofcloud1"> 开启 </label>
                                                                </div>

                                                                <div class=" radio radio-inline radio-inverse">
                                                                    <input id="Useofcloud2" name="Useofcloud"
                                                                           value="false" type="radio"
                                                                           @if(cacheGlobalSettingsByKey('Useofcloud') =='false') checked @endif >
                                                                    <label for="Useofcloud2"> 不开启 </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>后台每页显示的数量</label>
                                                            <input type="text" name="admin_page_count" placeholder="后台每页显示的数量" value="{{cacheGlobalSettingsByKey('admin_page_count')}}" class="form-control">
                                                        </div>

                                                        <button type="button" id="website_button" class="btn btn-primary margin-l-5 mx-sm-3">提交</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </section>


                            </div>
                            <div role="tabpanel" class="tab-pane" id="contact">
                                <section class="main-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form method="get" action="" id="contact_form">
                                                        {{csrf_field()}}
                                                        <input value="" type="hidden" name="del_cid">
                                                          <section id="contact_section">
                                                              @foreach($contact_data as $key=>$value)
                                                                  <section>
                                                                      <input value="{{$value['cid']}}" class="del_cid" type="hidden" name="form_data[{{$key}}][cid]">
                                                                      <div class="form-group ">
                                                                          <label style="width: 100%;">联系地址 <i class=" fa fa-trash-o del_address" onclick="address_del(this)"></i></label>
                                                                          <div class="input-group">
                                                                              <input type="text" placeholder="联系地址" required value="{{$value['address']}}" name="form_data[{{$key}}][address]" class="form-control">
                                                                              <span class="input-group-btn">
                                                                                <button type="button" class="btn btn-default"><i class="fa fa-map-marker"></i></button>
                                                                            </span>
                                                                          </div>
                                                                      </div>

                                                                      <div class="form-group ">
                                                                          <label>公司名称</label>
                                                                          <div class="input-group">
                                                                              <input type="text" placeholder="公司名称" required value="{{$value['company_name']}}" name="form_data[{{$key}}][company_name]" class="form-control">
                                                                          </div>
                                                                      </div>

                                                                      <div class="form-group">
                                                                          <label>联系人员 <i class="fa fa-plus" style="font-size: 16px;" key="{{$key}}" onclick="contact_add(this)"></i></label>

                                                                          @foreach(json_decode($value['personal'],true) as $key1=>$value1)

                                                                              <div class="row contact_div">
                                                                                  <div class="col-md-2">
                                                                                      <input type="text" placeholder="联系姓名" required name="form_data[{{$key}}][personal][{{$key1}}][name]" value="{{$value1['name']}}" class="form-control">
                                                                                  </div>
                                                                                  <div class="col-md-3">
                                                                                      <input type="text" placeholder="联系方式" required name="form_data[{{$key}}][personal][{{$key1}}][contact]" value="{{$value1['contact']}}" class="form-control">
                                                                                  </div>

                                                                                  <div class="col-md-1">
                                                                                      <i class=" fa fa-trash-o del_user" onclick="contact_del(this)"></i>
                                                                                  </div>

                                                                              </div>
                                                                          @endforeach


                                                                      </div>
                                                                  </section>
                                                              @endforeach
                                                          </section>




                                                        <button type="button" id="contact_button" class="btn btn-primary mx-sm-3">提交</button>
                                                        <button type="button" id="contact_add" onclick="contact_div_add()" class="btn btn-primary mx-sm-3"><i class="fa fa-plus"></i></button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </section>


                            </div>
                            <div role="tabpanel" class="tab-pane" id="email">
                                <section class="main-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post" action="" id="email_form">
                                                        {{csrf_field()}}
                                                        <div class="form-group row">
                                                            <label for="MAIL_USERNAME" class="col-sm-1 col-form-label">发件人</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" id="MAIL_USERNAME" name="MAIL_FROM_NAME" value="{{env('MAIL_FROM_NAME')}}" placeholder="发件人" type="text">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="text-muted">
                                                                    所显示的发件人姓名
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="MAIL_FROM_ADDRESS" class="col-sm-1 col-form-label">邮箱账号</label>
                                                            <div class="col-sm-4">
                                                                <input placeholder="邮箱账号" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" value="{{env('MAIL_FROM_ADDRESS')}}" class="form-control" type="text">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="text-muted">
                                                                    用于发送邮件的邮箱账号
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="MAIL_PASSWORD" class="col-sm-1 col-form-label">邮箱密码</label>
                                                            <div class="col-sm-4">
                                                                <input placeholder="邮箱密码" id="MAIL_PASSWORD" name="MAIL_PASSWORD" value="{{env('MAIL_PASSWORD')}}" class="form-control" type="text">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="text-muted">
                                                                    用于发送邮件的邮箱密码
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="MAIL_HOST" class="col-sm-1 col-form-label">SMTP</label>
                                                            <div class="col-sm-4">
                                                                <input placeholder="SMTP" id="MAIL_HOST" name="MAIL_HOST" value="{{env('MAIL_HOST')}}" class="form-control" type="text">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="text-muted">
                                                                    如QQ邮箱为smtp.qq.com
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="MAIL_PORT" class="col-sm-1 col-form-label">发送端口</label>
                                                            <div class="col-sm-4">
                                                                <input placeholder="发送端口" id="MAIL_PORT" name="MAIL_PORT" value="{{env('MAIL_PORT')}}" class="form-control" type="text">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="text-muted">
                                                                    用于邮件发送端口（TLS一般为25，SSL一般为465）
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="MAIL_ENCRYPTION" class="col-sm-1 col-form-label">发送方式</label>
                                                            <div class="col-sm-4">
                                                                <div class="radio radio-purple">
                                                                    <input type="radio" name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION" value="ssl" @if(env('MAIL_ENCRYPTION')=='ssl') checked @endif>
                                                                    <label for="MAIL_ENCRYPTION"> SSL服务方式</label>
                                                                </div>
                                                                <div class="radio radio-purple">
                                                                    <input type="radio" name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION2" value="tls" @if(env('MAIL_ENCRYPTION')=='tls') checked @endif>
                                                                    <label for="MAIL_ENCRYPTION2"> TLS服务方式 </label>
                                                                </div>
                                                                <p class="text-muted">
                                                                    默认邮箱服务方式为TLS<br />
                                                                    如果使用TLS方式25端口无法发送，请尝试使用SSL方式465端口发件
                                                                </p>
                                                            </div>

                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="email_adress" class="col-sm-1 col-form-label">发送测试</label>
                                                            <div class="col-sm-4">
                                                                <input placeholder="测试邮箱地址" id="email_adress" name="email_adress" class="form-control" type="text">
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <input  class="form-control" type="button" id="email_test_button" value="发送">
                                                            </div>
                                                        </div>
                                                        <button type="button" id="email_button" class="btn btn-sm btn-primary">提交</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="sms">
                                <section class="main-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form method="post" action="" id="sms_form">
                                                        {{csrf_field()}}
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">SMS服务商</label>
                                                            <div class="col-sm-8">
                                                                <div class="form-inline">
                                                                    @if($plugin_list)
                                                                        @foreach($plugin_list as $key => $plugin)
                                                                            @if($plugin)
                                                                                <div class="radio radio-inline radio-primary">
                                                                                    <input id="upload_name{{$key}}" type="radio" value="{{$plugin['identification']}}" name="sms_driver" @if(!empty(__E("sms_driver")) && __E("sms_driver")==$plugin['identification']) checked @endif >
                                                                                    <label for="upload_name{{$key}}"> {{$plugin['name']}} </label>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <section id="local">
                                                            <div class="form-group breadcrumb row">
                                                                <label class="col-sm-12 col-form-label">SMS配置</label>
                                                            </div>
                                                            @if($plugin_list)
                                                                @foreach($plugin_list as $key => $plugin)
                                                                    @if($plugin)
                                                                        <section class="sms_driver" id="{{$plugin['identification']}}" @if(__E("sms_driver")!=$plugin['identification']) style="display: none;" @endif>
                                                                            @if($plugin && !empty($plugin['change_field']) )
                                                                                @foreach($plugin['change_field'] as $k => $v)
                                                                                    <div class="form-group row">
                                                                                        <label for="" class="col-sm-2 col-form-label">{{$v['name']}}</label>
                                                                                        <div class="col-sm-4">
                                                                                            <input class="form-control" id="" placeholder="{{$v['value']}}" name="{{$v['value']}}" type="text" value="{{empty($plugin[$v['value']]) ? '' : $plugin[$v['value']]}}">
                                                                                        </div>
                                                                                    </div>  
                                                                                @endforeach  
                                                                            @endif
                                                                        </section>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </section>

                                                        <button type="button" id="sms_button" class="btn btn-sm btn-primary">提交</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="third_party">
                                <section class="main-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form method="post" action="" id="third_party_form">

                                                        {{csrf_field()}}

                                                        <div class="form-group ">
                                                            <label for="head_codes">顶部代码</label>
                                                            <textarea placeholder="顶部代码！" id="head_codes" name="head_codes" class="form-text" rows="4" style="height: 100px;">{{cacheGlobalSettingsByKey('head_codes')}}</textarea>
                                                            <p class="text-muted">
                                                                代码会放在 head 标签内
                                                            </p>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="foot_codes">底部代码</label>
                                                            <textarea placeholder="底部代码！" id="foot_codes"  name="foot_codes" class="form-text" rows="4" style="height: 100px;">{{cacheGlobalSettingsByKey('foot_codes')}}</textarea>
                                                            <p class="text-muted">
                                                                代码会放在 body 标签底部
                                                            </p>
                                                        </div>
                                                        <button type="button" id="third_party_button" class="btn btn-primary margin-l-5 mx-sm-3">提交</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            {{--<div role="tabpanel" class="tab-pane" id="oauth_config">--}}
                                {{--<section class="main-content">--}}
                                    {{--<div class="row">--}}
                                        {{--<div class="col-sm-12">--}}
                                            {{--<div class="card">--}}

                                                {{--<div class="card-body">--}}
                                                    {{--<form method="post" action="" id="third_party_form">--}}
                                                        {{--{{csrf_field()}}--}}
                                                    {{--</form>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</section>--}}
                            {{--</div>--}}
                            <div role="tabpanel" class="tab-pane" id="template_message">
                                <section class="main-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post" action="" id="template_message_form">
                                                        {{csrf_field()}}
                                                        <div class="form-group row">
                                                            <label for="mail_register_template" class="col-sm-1 col-form-label">模板消息类型</label>
                                                            <div class="col-sm-4">
                                                                短信
                                                            </div>
                                                            <div class="col-sm-4">
                                                                邮箱
                                                            </div>
                                                            <div class="col-sm-3">
                                                                是否开启
                                                            </div>
                                                        </div>
                                                        @if(!empty($template_list['template_list']))
                                                            @foreach($template_list['template_list'] as $key => $_template)
                                                                @if($_template)
                                                                    @foreach($_template as $template)
                                                                        @if($key == 0)
                                                                            
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <div class="form-group row">
                                                            <label class="col-sm-1 col-form-label">注册账户</label>
                                                            <div class="col-sm-4">
                                                                <textarea class="form-control min-height-7-rem" placeholder="您的验证码为：{$code}" name="sms_register_template">{{$template_list['sms_register_template']['template_value']}}</textarea>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <textarea class="form-control min-height-7-rem" placeholder="您的验证码为：{$code}" name="mail_register_template">{{$template_list['mail_register_template']['template_value']}}</textarea>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="checkbox" name="is_start[sms_register_template]" value="1" @if($template_list['sms_register_template']['is_start'] == 1) checked="checked" @endif> 短信
                                                                <small style="color:green;margin-left:15px;">切记：{$code}为验证码</small><br>
                                                                <input type="checkbox" name="is_start[mail_register_template]" value="1" @if($template_list['mail_register_template']['is_start'] == 1) checked="checked" @endif> 邮件
                                                                <small style="color:green;margin-left:15px;">切记：{$code}为验证码</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-1 col-form-label">找回密码</label>
                                                            <div class="col-sm-4">
                                                                <textarea class="form-control min-height-7-rem" placeholder="您的验证码为：{$code}" name="sms_forgot_template">{{$template_list['sms_forgot_template']['template_value']}}</textarea>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <textarea class="form-control min-height-7-rem" placeholder="您的验证码为：{$code}" name="mail_forgot_template">{{$template_list['mail_forgot_template']['template_value']}}</textarea>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="checkbox" name="is_start[sms_forgot_template]" value="1" @if($template_list['sms_forgot_template']['is_start'] == 1) checked="checked" @endif> 短信
                                                                <small style="color:green;margin-left:15px;">切记：{$code}为验证码</small><br>
                                                                <input type="checkbox" name="is_start[mail_forgot_template]" value="1" @if($template_list['mail_forgot_template']['is_start'] == 1) checked="checked" @endif> 邮件
                                                                <small style="color:green;margin-left:15px;">切记：{$code}为验证码</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-1 col-form-label">绑定账户</label>
                                                            <div class="col-sm-4">
                                                                <textarea class="form-control min-height-7-rem" placeholder="您的验证码为：{$code}" name="sms_bind_template">{{$template_list['sms_bind_template']['template_value']}}</textarea>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <textarea class="form-control min-height-7-rem" placeholder="您的验证码为：{$code}" name="mail_bind_template">{{$template_list['mail_bind_template']['template_value']}}</textarea>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="checkbox" name="is_start[sms_bind_template]" value="1" @if($template_list['sms_bind_template']['is_start'] == 1) checked="checked" @endif> 短信
                                                                <small style="color:green;margin-left:15px;">切记：{$code}为验证码</small><br>
                                                                <input type="checkbox" name="is_start[mail_bind_template]" value="1" @if($template_list['mail_bind_template']['is_start'] == 1) checked="checked" @endif> 邮件
                                                                <small style="color:green;margin-left:15px;">切记：{$code}为验证码</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-1 col-form-label">解除绑定</label>
                                                            <div class="col-sm-4">
                                                                <textarea class="form-control min-height-7-rem" placeholder="您的验证码为：{$code}" name="sms_untying_template">{{$template_list['sms_untying_template']['template_value']}}</textarea>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <textarea class="form-control min-height-7-rem" placeholder="您的验证码为：{$code}" name="mail_untying_template">{{$template_list['mail_untying_template']['template_value']}}</textarea>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="checkbox" name="is_start[sms_untying_template]" value="1" @if($template_list['sms_untying_template']['is_start'] == 1) checked="checked" @endif> 短信
                                                                <small style="color:green;margin-left:15px;">切记：{$code}为验证码</small><br>
                                                                <input type="checkbox" name="is_start[mail_untying_template]" value="1" @if($template_list['mail_untying_template']['is_start'] == 1) checked="checked" @endif> 邮件
                                                                <small style="color:green;margin-left:15px;">切记：{$code}为验证码</small>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="template_message_button" class="btn btn-sm btn-primary">提交</button>
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
<style>
    .contact_div{margin-bottom: 20px}
    .del_address{margin-top: 9px;font-size: 20px;float: right;}
    .del_user{margin-top: 9px;font-size: 20px;}
</style>
</body>
</html>
<script>

    //添加联系人员
    function contact_add($this) {
        var key_add = $($this).attr('key');
        var key_personal = $($this).parent().parent().find('.row').length;
        var contact = '<div class="row contact_div">\n' +
            '<div class="col-md-2">\n' +
            '<input type="text" placeholder="联系姓名" name="form_data['+key_add+'][personal]['+key_personal+'][name]" value="" class="form-control">\n' +
            '</div>\n' +
            '<div class="col-md-3">\n' +
            '<input type="text" placeholder="联系方式" name="form_data['+key_add+'][personal]['+key_personal+'][contact]" value="" class="form-control">\n' +
            '</div>\n' +
            '<div class="col-md-1">'+
            '<i class=" fa fa-trash-o" onclick="contact_del(this)" style="margin-top: 9px;font-size: 20px;"></i>'+
            '</div>'+
            '</div>\n'
            ;
        $($this).parent().parent().append(contact);
    }

    //删除地址
    function address_del($this){
        var del_address = $.find(".del_address");
        if(del_address.length == 1){
            alert("需要保留一条数据");
            return false;
        }
        var del_cid = $($this).parent().parent().parent().find(".del_cid");

        if(del_cid.val()){
            var del_cid_val = $("input[name=del_cid]").val();
            if(del_cid_val){
                $("input[name=del_cid]").val(del_cid_val+","+del_cid.val())
            }else {
                $("input[name=del_cid]").val(del_cid.val())
            }
        };

        $($this).parent().parent().parent().remove();
    }
    
    //删除联系人
    function contact_del($this) {

        $($this).parent().parent().remove();
    }

    //增加一块联系人区域
    function contact_div_add() {
        var key_count = $("#contact_section").find("section").length
        var content = '<section>\n' +
            '<div class="form-group ">\n' +
            '<label style="width: 100%;">联系地址 <i class=" fa fa-trash-o del_address" onclick="address_del(this)"></i>\n' +
            '</label>\n' +
            '<div class="input-group">\n' +
            '<input type="text" placeholder="联系地址" required  name="form_data['+key_count+'][address]" class="form-control">\n' +
            '<span class="input-group-btn">\n' +
            '<button type="button" class="btn btn-default"><i class="fa fa-map-marker"></i></button>\n' +
            '</span>\n' +
            '</div>\n' +
            '</div>\n' +
            '<div class="form-group ">\n' +
            '<label>公司名称</label>\n' +
            '<div class="input-group">\n' +
            '<input type="text" placeholder="公司名称" required value="" name="form_data['+key_count+'][company_name]" class="form-control">\n' +
            ' </div>\n' +
            '</div>\n' +
            '<div class="form-group">\n' +
            '<label>联系人员 <i class="fa fa-plus" style="font-size: 16px;" key="'+key_count+'" onclick="contact_add(this)"></i></label>\n' +
            '\n' +
            '<div class="row contact_div">\n' +
            '<div class="col-md-2">\n' +
            '<input type="text" placeholder="联系姓名" required name="form_data['+key_count+'][personal][0][name]" value="" class="form-control">\n' +
            '</div>\n' +
            '<div class="col-md-3">\n' +
            '<input type="text" placeholder="联系方式" required name="form_data['+key_count+'][personal][0][contact]" value="" class="form-control">\n' +
            '</div>\n' +
            '\n' +
            '<div class="col-md-1">\n' +
            '<i class=" fa fa-trash-o del_user" onclick="contact_del(this)"></i>\n' +
            '</div>\n' +
            '\n' +
            '</div>\n' +
            '\n' +
            '</div>\n' +
            '</section>';

        $("#contact_section").append(content);

    }
    $(function () {

        //website 提交
        $("#website_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/baseSubmit?form=website')}}",
                        "data": new FormData($('#website_form')[0]),                   //$("#website_form").serialize(),
                        "dataType":'json',
                        "cache":false,
                        "processData": false,
                        "contentType": false,
                        "success":function (res) {

                            if(res.stauts==200){
                                 popup({
                                    type: "success", msg: res.msg, delay: 2000, callBack: function () {
                                        window.location.reload();
                                    }
                                });
                            }else{
                                popup({type:"error",msg:res.msg,delay:2000});
                            }

                        },
                        "error":function (res) {
                            console.log("错误信息：");
                            console.log(res);
                        }
                    })

            }});


        })

        //  联系我们提交
        $("#contact_button").click(function () {

            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/baseSubmit?form=contact')}}",
                        "data":$("#contact_form").serialize(),
                        "dataType":'json',
                        "success":function (res) {
                            console.log(res);
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


        //email 提交
        $("#email_button").click(function () {
            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/baseSubmit?form=email')}}",
                        "data":$("#email_form").serialize(),
                        "dataType":'json',
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

        //email 测试
        $("#email_test_button").click(function () {
            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                $.ajax({
                    "method":"post",
                    "url":"{{url('admin/baseSubmit?form=test_email')}}",
                    "data":{'email_adress':$("#email_adress").val(),"_token":'{{csrf_token()}}'},
                    "dataType":'json',
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

        //第三方代码
        $("#third_party_button").click(function () {
            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/baseSubmit?form=third_party')}}",
                        "data":$("#third_party_form").serialize(),
                        "dataType":'json',
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
        });

        //SMS
        $("#sms_button").click(function () {
            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/baseSubmit?form=sms')}}",
                        "data":$("#sms_form").serialize(),
                        "dataType":'json',
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
        });

        $("#template_message_form input[type=checkbox]").change(function(){
            if ($(this).is(':checked')) $(this).attr('checked');
            else $(this).removeAttr('checked');
        });

        //模板消息
        $("#template_message_button").click(function () {
            popup({type:'load',msg:"正在请求",delay:800,callBack:function(){
                    $.ajax({
                        "method":"post",
                        "url":"{{url('admin/baseSubmit?form=template_message')}}",
                        "data":$("#template_message_form").serialize(),
                        "dataType":'json',
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
        });

        

        //配置选项卡
        $("input[name='sms_driver']").change(function () {
            $(".sms_driver").hide();
            $("#"+$(this).val()).show();
        })
    })

</script>