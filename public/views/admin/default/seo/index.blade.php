@include("admin.".ADMIN_SKIN.".header")

<body class="horizontal">
<div id="load"></div>
<!-- ============================================================== -->
<!--                        Topbar Start                            -->
<!-- ============================================================== -->
@include("admin.".ADMIN_SKIN.".topbar")
<!-- ============================================================== -->
<!--                        Topbar End                              -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!--                        Navigation Start                        -->
<!-- ============================================================== -->
@include("admin.".ADMIN_SKIN.".nav")
<!-- ============================================================== -->
<!--                        Navigation End                          -->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!--                        Content Start                           -->
<!-- ============================================================== -->
<style type="text/css">
    .min-height-7-rem{min-height: 7rem;}
    .red, .color-red{color: red}
</style>
<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">首页</a></li>
            <li class="breadcrumb-item"><a href="#">系统设置</a></li>
            <li class="breadcrumb-item active">SEO设置</li>
        </ol>
    </div>
</div>

<section class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="tabs">
                        <div role="tabpanel" class="tab-pane" id="template_message">
                            <section class="main-content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="tabs">
                                                    <!-- Nav tabs -->

                                                    <ul class="nav seonav nav-tabs">
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link  active" href="#all" aria-controls="all" role="tab" data-toggle="tab">全局配置</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" href="#faq" aria-controls="faq" role="tab" data-toggle="tab">常见问题</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" href="#case" aria-controls="case" role="tab" data-toggle="tab">案例模块</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" href="#news" aria-controls="news" role="tab" data-toggle="tab">新闻模块</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" href="#joins" aria-controls="joins" role="tab" data-toggle="tab">招聘模块</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" href="#product" aria-controls="product" role="tab" data-toggle="tab">产品模块</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" href="#module" aria-controls="module" role="tab" data-toggle="tab">功能模块</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" href="#page" aria-controls="page" role="tab" data-toggle="tab">单页模块</a>
                                                        </li>

                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="all">

                                                            <form method="post" action="" id="post_form_all">
                                                                {{csrf_field()}}
                                                                <div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <div class="col-sm-10 col-form-label">
                                                                            <span class="color-red">{title}</span>：详情的标题
                                                                            <hr>
                                                                            <span class="color-red">{keywords}</span>：详情的关键字
                                                                            <hr>
                                                                            <span class="color-red">{description}</span>：详情的描述
                                                                        </div>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_all_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_all_title']) ? '' : $seo_list['seo_all_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_all_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_all_keywords']) ? '' : $seo_list['seo_all_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_all_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_all_description']) ? '' : $seo_list['seo_all_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <hr>
                                                                </div>

                                                                <button type="button" onclick="ajaxReq('post_form_all');" class="btn btn-sm btn-primary post_button">提交</button>
                                                            </form>

                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="faq">
                                                            <form method="post" action="" id="post_form_faq">
                                                                {{csrf_field()}}
                                                                <div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <div class="col-sm-10 col-form-label">
                                                                            <span class="color-red">{title}</span>：详情的标题
                                                                            <hr>
                                                                            <span class="color-red">{keywords}</span>：详情的关键字
                                                                            <hr>
                                                                            <span class="color-red">{description}</span>：详情的描述
                                                                        </div>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">详情页</label>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_faq_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_faq_title']) ? '' : $seo_list['seo_faq_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_faq_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_faq_keywords']) ? '' : $seo_list['seo_faq_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_faq_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_faq_description']) ? '' : $seo_list['seo_faq_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">列表页</label>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_faq_list_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_faq_list_title']) ? '' : $seo_list['seo_faq_list_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_faq_list_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_faq_list_keywords']) ? '' : $seo_list['seo_faq_list_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_faq_list_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_faq_list_description']) ? '' : $seo_list['seo_faq_list_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <hr>
                                                                </div>

                                                                <button type="button" onclick="ajaxReq('post_form_faq');" class="btn btn-sm btn-primary post_button">提交</button>
                                                            </form>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="case">
                                                            <form method="post" action="" id="post_form_case">
                                                                {{csrf_field()}}
                                                                <div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <div class="col-sm-10 col-form-label">
                                                                            <span class="color-red">{title}</span>：详情的标题
                                                                            <hr>
                                                                            <span class="color-red">{keywords}</span>：详情的关键字
                                                                            <hr>
                                                                            <span class="color-red">{description}</span>：详情的描述
                                                                        </div>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">详情页</label>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_case_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_case_title']) ? '' : $seo_list['seo_case_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_case_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_case_keywords']) ? '' : $seo_list['seo_case_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_case_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_case_description']) ? '' : $seo_list['seo_case_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">列表页</label>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_case_list_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_case_list_title']) ? '' : $seo_list['seo_case_list_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_case_list_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_case_list_keywords']) ? '' : $seo_list['seo_case_list_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_case_list_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_case_list_description']) ? '' : $seo_list['seo_case_list_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <hr>
                                                                </div>

                                                                <button type="button" onclick="ajaxReq('post_form_case');" class="btn btn-sm btn-primary post_button">提交</button>
                                                            </form>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="news">
                                                            <form method="post" action="" id="post_form_news">
                                                                {{csrf_field()}}
                                                                <div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <div class="col-sm-10 col-form-label">
                                                                            <span class="color-red">{title}</span>：详情的标题
                                                                            <hr>
                                                                            <span class="color-red">{keywords}</span>：详情的关键字
                                                                            <hr>
                                                                            <span class="color-red">{description}</span>：详情的描述
                                                                        </div>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">详情页</label>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_news_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_news_title']) ? '' : $seo_list['seo_news_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_news_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_news_keywords']) ? '' : $seo_list['seo_news_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_news_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_news_description']) ? '' : $seo_list['seo_news_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">列表页</label>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_news_list_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_news_list_title']) ? '' : $seo_list['seo_news_list_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_news_list_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_news_list_keywords']) ? '' : $seo_list['seo_news_list_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_news_list_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_news_list_description']) ? '' : $seo_list['seo_news_list_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <hr>
                                                                </div>

                                                                <button type="button" onclick="ajaxReq('post_form_news');" class="btn btn-sm btn-primary post_button">提交</button>
                                                            </form>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="joins">
                                                            <form method="post" action="" id="post_form_joins">
                                                                {{csrf_field()}}
                                                                <div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <div class="col-sm-10 col-form-label">
                                                                            <span class="color-red">{title}</span>：详情的标题
                                                                            <hr>
                                                                            <span class="color-red">{keywords}</span>：详情的关键字
                                                                            <hr>
                                                                            <span class="color-red">{description}</span>：详情的描述
                                                                        </div>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">详情页</label>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_joins_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_joins_title']) ? '' : $seo_list['seo_joins_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_joins_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_joins_keywords']) ? '' : $seo_list['seo_joins_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_joins_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_joins_description']) ? '' : $seo_list['seo_joins_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">列表页</label>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_joins_list_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_joins_list_title']) ? '' : $seo_list['seo_joins_list_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_joins_list_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_joins_list_keywords']) ? '' : $seo_list['seo_joins_list_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_joins_list_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_joins_list_description']) ? '' : $seo_list['seo_joins_list_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <hr>
                                                                </div>

                                                                <button type="button" onclick="ajaxReq('post_form_joins');" class="btn btn-sm btn-primary post_button">提交</button>
                                                            </form>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="product">
                                                            <form method="post" action="" id="post_form_product">
                                                                {{csrf_field()}}
                                                                <div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <div class="col-sm-10 col-form-label">
                                                                            <span class="color-red">{title}</span>：详情的标题
                                                                            <hr>
                                                                            <span class="color-red">{keywords}</span>：详情的关键字
                                                                            <hr>
                                                                            <span class="color-red">{description}</span>：详情的描述
                                                                        </div>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">详情页</label>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_product_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_product_title']) ? '' : $seo_list['seo_product_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_product_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_product_keywords']) ? '' : $seo_list['seo_product_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_product_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_product_description']) ? '' : $seo_list['seo_product_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">列表页</label>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_product_list_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_product_list_title']) ? '' : $seo_list['seo_product_list_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_product_list_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_product_list_keywords']) ? '' : $seo_list['seo_product_list_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_product_list_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_product_list_description']) ? '' : $seo_list['seo_product_list_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <hr>
                                                                </div>

                                                                <button type="button" onclick="ajaxReq('post_form_product');" class="btn btn-sm btn-primary post_button">提交</button>
                                                            </form>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="module">
                                                            <form method="post" action="" id="post_form_module">
                                                                {{csrf_field()}}
                                                                <div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <div class="col-sm-10 col-form-label">
                                                                            <span class="color-red">{title}</span>：详情的标题
                                                                            <hr>
                                                                            <span class="color-red">{keywords}</span>：详情的关键字
                                                                            <hr>
                                                                            <span class="color-red">{description}</span>：详情的描述
                                                                        </div>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">详情页</label>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_module_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_module_title']) ? '' : $seo_list['seo_module_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_module_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_module_keywords']) ? '' : $seo_list['seo_module_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_module_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_module_description']) ? '' : $seo_list['seo_module_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <hr>
                                                                </div>

                                                                <button type="button" onclick="ajaxReq('post_form_module');" class="btn btn-sm btn-primary post_button">提交</button>
                                                            </form>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="page">
                                                            <form method="post" action="" id="post_form_page">
                                                                {{csrf_field()}}
                                                                <div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <div class="col-sm-10 col-form-label">
                                                                            <span class="color-red">{title}</span>：详情的标题
                                                                            <hr>
                                                                            <span class="color-red">{keywords}</span>：详情的关键字
                                                                            <hr>
                                                                            <span class="color-red">{description}</span>：详情的描述
                                                                        </div>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group breadcrumb row">
                                                                        <label for="" class="col-sm-12 col-form-label">详情页</label>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 标题</label>
                                                                        <input type="text" name="seo_page_title" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_page_title']) ? '' : $seo_list['seo_page_title'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 关键字</label>
                                                                        <input type="text" name="seo_page_keywords" value="{{empty($seo_list) ? '' : (empty($seo_list['seo_page_keywords']) ? '' : $seo_list['seo_page_keywords'])}}" class="form-control col-sm-8" />
                                                                        <div class="col-sm-1"></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-1"></div>
                                                                        <label class="col-sm-2 col-form-label">SEO - 描述</label>
                                                                        <textarea class="form-control min-height-7-rem col-sm-8" placeholder="" name="seo_page_description">{{empty($seo_list) ? '' : (empty($seo_list['seo_page_description']) ? '' : $seo_list['seo_page_description'])}}</textarea>
                                                                        <div class="col-sm-1"></div>
                                                                    </div>

                                                                    <hr>
                                                                </div>

                                                                <button type="button" onclick="ajaxReq('post_form_page');" class="btn btn-sm btn-primary post_button">提交</button>
                                                            </form>
                                                        </div>




                                                    </div>
                                                </div>
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

    @include('admin/'.ADMIN_SKIN.'/footer')


</section>
<!-- ============================================================== -->
<!--                        Content End                             -->
<!-- ============================================================== -->



<!-- Common Plugins -->
@include('admin/default/js',['load'=> ["custom"]])
</body>
</html>
<script>

    function ajaxReq(id){

        var index = layer.load(1, {
            shade: [0.5,'#000'] ,//0.1透明度的白色背景
            content: '正在提交',
            success: function (layero) {
                layero.find('.layui-layer-content').css({
                    'padding-top': '39px',
                    'width': '80px',
                    "color":"#FFF",
                    "background-position":"center center"
                });
            }
        });

        $.ajax({
            "method":"post",
            "url":"{{url('admin/seoSubmit')}}",
            "data":$("#"+id).serialize(),
            "dataType":'json',
            "success":function (res) {
                layer.closeAll();
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

    }

    $(function () {

        {{--$(".post_button").click(function () {--}}
            {{--popup({type:'load',msg:"正在请求",delay:800,callBack:function(){--}}
                    {{--$.ajax({--}}
                        {{--"method":"post",--}}
                        {{--"url":"{{url('admin/seoSubmit')}}",--}}
                        {{--"data":$(this).parents().find("form").serialize(),--}}
                        {{--"dataType":'json',--}}
                        {{--"success":function (res) {--}}
                            {{--if(res.stauts==200){--}}
                                {{--popup({type:"success",msg:res.msg,delay:2000});--}}
                            {{--}else{--}}
                                {{--popup({type:"error",msg:res.msg,delay:2000});--}}
                            {{--}--}}
                        {{--},--}}
                        {{--"error":function (res) {--}}
                            {{--console.log(res);--}}
                        {{--}--}}
                    {{--})--}}
            {{--}});--}}
        {{--});--}}
    })
</script>