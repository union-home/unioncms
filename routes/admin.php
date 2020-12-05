<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/login', "LoginController@login");

//黑名单
Route::any('/blacklist', function () {
    return view("admin/" . ADMIN_SKIN . "/other/403", ['content' => '您的IP：<span style="color:red;font-size: 1.6rem;">' . get_ip() . '</span>，已被纳入黑名单！！！']);
});
//菜单排序功能

//需要登录的路由组   黑名单中间件
Route::group(['middleware' => ['CheckAdmin', 'checkIpBlacklist']], function () {
    Route::any('/index', ["uses" => "IndexController@index", "permissions" => "admin/index"]);

    Route::any('/updateCmsVersion', ["uses" => "IndexController@updateCmsVersion", "permissions" => ""]);
    Route::any('/getBackCmsZipSize', ["uses" => "IndexController@getBackCmsZipSize", "permissions" => ""]);


    Route::any('/', ["uses" => "IndexController@index", "permissions" => "admin/index"]);

    Route::any('/clear', ["uses" => "ToolsController@clearCache", "permissions" => "admin/clear"]);

    Route::any('/logout', ["uses" => "IndexController@logout", "permissions" => "logout"]);

    Route::any('/base', ["uses" => "SettingsController@base", "permissions" => "admin/base"]);

    Route::any('/country', ["uses" => "CountryController@country", "permissions" => "admin/country"]);

    Route::any('/region/{country_code}/{level?}', ["uses" => "CountryController@region", "permissions" => "admin/region"]);

    Route::any('/currency', ["uses" => "CurrencyController@currency", "permissions" => "currency"]);

    Route::any('/currency/add', ["uses" => "CurrencyController@add", "permissions" => "currency/add"]);

    Route::any('/currency/edit', ["uses" => "CurrencyController@edit", "permissions" => "currency/edit"]);

    Route::any('/language', ["uses" => "LanguageController@index", "permissions" => "language"]);

    Route::any('/language/add', ["uses" => "LanguageController@add", "permissions" => "language/add"]);

    Route::any('/language/manage/{id}', ["uses" => "LanguageController@manage", "permissions" => "language/manage"]);

    Route::any('/language/edit/{id}', ["uses" => "LanguageController@edit", "permissions" => "language/edit"]);

    Route::post('/getLanguageByType', ["uses" => "LanguageController@getLanguageByType", "permissions" => "getLanguageByType"]);

    Route::any('/language/delete/{id}', ["uses" => "LanguageController@delete", "permissions" => "language/delete"]);


    Route::any('/languageSubmit', ["uses" => "LanguageController@Submit", "permissions" => "languageSubmit"]);

    Route::any('/change/language/{shortcode}', ["uses" => "LanguageController@change", "permissions" => "change/language"]);


    Route::any('/currencySubmit', ["uses" => "CurrencyController@Submit", "permissions" => "currencySubmit"]);


    Route::post('/baseSubmit', ["uses" => "SettingsController@baseSubmit", "permissions" => "baseSubmit"]);


    Route::any('/safe', ["uses" => "ToolsController@safe", "permissions" => "safe"]);

    Route::post('/toolSubmit', ["uses" => "ToolsController@toolSubmit", "permissions" => "toolSubmit"]);

    Route::any('/cache', ["uses" => "ToolsController@cache", "permissions" => "cache"]);

    Route::any('/upload', ["uses" => "ToolsController@upload", "permissions" => "upload"]);


    Route::any('/tables', ["uses" => "ToolsController@tables", "permissions" => "tables"]);

    Route::any('/recover', ["uses" => "ToolsController@recover", "permissions" => "recover"]);


    Route::post('/tableSubmit', ["uses" => "ToolsController@tableSubmit", "permissions" => "tableSubmit"]);


    //功能模块列表
    Route::any('/feature', ["uses" => "FuncController@feature", "permissions" => "feature"]);
    //功能下载
    Route::any('/feature/download', ["uses" => "FuncController@download", "permissions" => ""]);
    //功能安装
    Route::any('/feature/install', ["uses" => "FuncController@install", "permissions" => ""]);
    //功能 启用/禁用
    Route::any('/feature/changeStatus', ["uses" => "FuncController@changeStatus", "permissions" => ""]);
    //设为首页
    Route::any('/feature/changeIndex', ["uses" => "FuncController@changeIndex", "permissions" => ""]);
    //模块卸载
    Route::any('/feature/uninstall', ["uses" => "FuncController@uninstall", "permissions" => ""]);
    //更新模块的版本
    Route::any('/feature/uploadModuleVersion', ["uses" => "FuncController@uploadModuleVersion", "permissions" => ""]);
    //在线模块列表
    Route::any('/feature/onlineModuleList', ["uses" => "FuncController@onlineModuleList", "permissions" => ""]);


    //云应用
    Route::any('/cloud', ["uses" => "CloudController@index", "permissions" => "cloud"]);
    //功能下载
    Route::any('/cloud/download-temporary', ["uses" => "CloudController@download-temporary", "permissions" => ""]);
    //功能 启用/禁用
    Route::any('/cloud/changeStatus', ["uses" => "CloudController@changeStatus", "permissions" => ""]);
    Route::any('/cloud/getCloudAppDownloadProgress', ["uses" => "CloudController@getCloudAppDownloadProgress", "permissions" => ""]);


    //插件卸载
    Route::any('/plugin/uninstall', ["uses" => "CloudController@pluginUninstall", "permissions" => ""]);
    //插件更新版本
    Route::any('/plugin/downloadVersion', ["uses" => "CloudController@pluginDownloadVersion", "permissions" => ""]);


    //主题模板
    Route::any('/themeTemplate/downloadVersion', ["uses" => "CloudController@themeTemplateDownloadVersion", "permissions" => ""]);
    Route::any('/themeTemplate/uninstall', ["uses" => "CloudController@themeTemplateUninstall", "permissions" => ""]);


    Route::any('/admins', ["uses" => "UsersController@admins", "permissions" => "admins"]);

    Route::any('/member/add', ["uses" => "UsersController@memberAdd", "permissions" => "member/add"]);


    Route::any('/users', ["uses" => "UsersController@users", "permissions" => "users"]);

    Route::get('/userinfo/{id}', ["uses" => "UsersController@userinfo", "permissions" => "userinfo"]);

    Route::get('/myinfo', ["uses" => "UsersController@myinfo", "permissions" => "myinfo"]);

    Route::any('/agents', ["uses" => "UsersController@agents", "permissions" => "agents"]);


    Route::any('/history', ["uses" => "UsersController@history", "permissions" => "history"]);

    Route::post('/userSubmit', ["uses" => "UsersController@userSubmit", "permissions" => "userSubmit"]);


    Route::any('/themes', ["uses" => "SettingsController@themes", "permissions" => "themes"]);
    //安装主题
    Route::any('/themes/install/{theme}', ["uses" => "SettingsController@themes_install", "permissions" => "themes/install"]);
    //卸载主题
    Route::any('/themes/uninstall', ["uses" => "SettingsController@themes_uninstall", "permissions" => "themes/themes_uninstall"]);
    //使用主题
    Route::any('/themes/use/{theme}', ["uses" => "SettingsController@theme_use", "permissions" => "themes/use"]);

    //编辑主题
    Route::any('/themes/edit/{theme}', ["uses" => "SettingsController@theme_edit", "permissions" => "themes/edit"]);
    //删除未安装主题
    Route::any('/themes/delete/{theme}', ["uses" => "SettingsController@theme_delete", "permissions" => "themes/delete"]);


    Route::any('/pages', ["uses" => "PagesController@pages", "permissions" => "pages"]);

    Route::any('/pages/add', ["uses" => "PagesController@add", "permissions" => "pages/add"]);

    Route::any('/pages/edit/{id}', ["uses" => "PagesController@edit", "permissions" => "pages/edit"]);
    Route::any('/pages/delete/{id}', ["uses" => "PagesController@delete", "permissions" => "pages/delete"]);

    Route::any('/pageSubmit', ["uses" => "PagesController@submit", "permissions" => "pageSubmit"]);

    Route::any('/visit', ["uses" => "VisitController@index", "permissions" => "visit"]);//访问统计
    Route::any('/visit/ajaxStatistics', ["uses" => "VisitController@ajaxStatistics", "permissions" => "visit/ajaxStatistics"]);//访问统计

    //留言管理
    Route::any('/feedbacks', ["uses" => "FeedbacksController@index", "permissions" => "feedbacks"]);
    Route::any('/feedbacks/edit/{id}', ["uses" => "FeedbacksController@edit", "permissions" => "admin/feedbacks/edit"]);
    Route::any('/feedbacks/delete/{id}', ["uses" => "FeedbacksController@delete", "permissions" => "feedbacks/delete"]);


    Route::any('/faq', ["uses" => "FaqController@faq", "permissions" => "faq"]);

    Route::any('/faq/add', ["uses" => "FaqController@add", "permissions" => "faq/add"]);

    Route::any('/faq/edit/{id}', ["uses" => "FaqController@edit", "permissions" => "faq/edit"]);

    Route::any('/faq/delete/{id}', ["uses" => "FaqController@faqDelete", "permissions" => "faq/delete"]);


    Route::any('/faq/category', ["uses" => "FaqController@category", "permissions" => "faq/category"]);

    Route::any('/faq/category/add', ["uses" => "FaqController@categoryAdd", "permissions" => "faq/category/add"]);

    Route::any('/faq/category/edit/{id}', ["uses" => "FaqController@categoryEdit", "permissions" => "faq/category/edit"]);

    Route::any('/faq/category/delete/{id}', ["uses" => "FaqController@categoryDel", "permissions" => "faq/category/delete"]);


    Route::any('/faqSubmit', ["uses" => "FaqController@submit", "permissions" => "faqSubmit"]);


    //导航管理

    Route::any('/menu/home', ["uses" => "MenuController@home", "permissions" => "menu/home"]);

    Route::any('/menu/home/add', ["uses" => "MenuController@homeAdd", "permissions" => "menu/home/add"]);

    Route::any('/menu/home/edit/{id}', ["uses" => "MenuController@homeEdit", "permissions" => "menu/home/edit"]);

    Route::any('/menuSubmit', ["uses" => "MenuController@submit", "permissions" => "menuSubmit"]);


    Route::any('/menu/admin', ["uses" => "MenuController@admin", "permissions" => "menu/admin"]);

    Route::any('/menu/admin/add', ["uses" => "MenuController@adminAdd", "permissions" => "menu/admin/add"]);

    Route::any('/menu/admin/edit/{id}', ["uses" => "MenuController@adminEdit", "permissions" => "menu/admin/edit"]);

    Route::any('/menu/delete/{id}', ["uses" => "MenuController@delete", "permissions" => "menu/delete"]);

    //权限管理
    Route::any('/menu/auth', ["uses" => "MenuController@auth", "permissions" => "menu/auth"]);

    Route::any('/menu/auth/add', ["uses" => "MenuController@auth_add", "permissions" => "menu/auth/add"]);

    Route::any('/menu/auth/edit/{id}', ["uses" => "MenuController@auth_edit", "permissions" => "menu/auth/edit"]);

    Route::any('/menu/auth/delete/{id}', ["uses" => "MenuController@auth_delete", "permissions" => "menu/auth/delete"]);


    Route::any('/menu/group', ["uses" => "MenuController@group", "permissions" => "menu/group"]);


    Route::any('/menu/group/add', ["uses" => "MenuController@group_add", "permissions" => "menu/group/add"]);

    Route::any('/menu/group/delete/{id}', ["uses" => "MenuController@group_delete", "permissions" => "group/delete"]);


    Route::any('/group/auth/{id}', ["uses" => "MenuController@group_auth", "permissions" => "group/auth"]);


    //案例管理
    Route::group(["prefix" => "case"], function () {
        Route::any('/', ["uses" => "CaseController@index", "permissions" => "admin/case"]);

        Route::any('/add', ["uses" => "CaseController@add", "permissions" => "admin/case/add"]);

        Route::any('/edit/{id}', ["uses" => "CaseController@edit", "permissions" => "admin/case/edit"]);

        Route::any('/delete/{id}', ["uses" => "CaseController@caseDelete", "permissions" => "admin/case/delete"]);


        Route::any('/category', ["uses" => "CaseController@category", "permissions" => "admin/case/category"]);

        Route::any('/category/add', ["uses" => "CaseController@categoryAdd", "permissions" => "admin/case/category/add"]);

        Route::any('/category/edit/{id}', ["uses" => "CaseController@categoryEdit", "permissions" => "admin/case/category/edit"]);

        Route::any('/category/delete/{id}', ["uses" => "CaseController@categoryDel", "permissions" => "admin/case/category/delete"]);

    });


    //内容管理
    Route::group(["prefix" => "content"], function () {
        Route::any('/news', ["uses" => "NewsController@index", "permissions" => "admin/content/news"]);

        Route::any('/news/add', ["uses" => "NewsController@add", "permissions" => "admin/content/news/add"]);

        Route::any('/news/edit/{id}', ["uses" => "NewsController@edit", "permissions" => "admin/content/news/edit"]);

        Route::any('/news/delete/{id}', ["uses" => "NewsController@newsDelete", "permissions" => "admin/content/news/delete"]);

        Route::any('/news/category', ["uses" => "NewsController@category", "permissions" => "admin/case/category"]);

        Route::any('/news/category/add', ["uses" => "NewsController@categoryAdd", "permissions" => "admin/case/category/add"]);

        Route::any('/news/category/edit/{id}', ["uses" => "NewsController@categoryEdit", "permissions" => "admin/case/category/edit"]);

        Route::any('/news/category/delete/{id}', ["uses" => "NewsController@categoryDel", "permissions" => "admin/case/category/delete"]);


        Route::any('/join', ["uses" => "ContentController@join_list", "permissions" => "admin/content/join"]);

        Route::any('/join/add', ["uses" => "ContentController@joinAdd", "permissions" => "admin/content/join/add"]);

        Route::any('/join/edit/{id}', ["uses" => "ContentController@joinEdit", "permissions" => "admin/content/join/edit"]);

        Route::any('/join/delete/{id}', ["uses" => "ContentController@joinDel", "permissions" => "admin/content/join/delete"]);


        Route::any('/download-temporary', ["uses" => "ContentController@download-temporary", "permissions" => "admin/content/download-temporary"]);

        Route::any('/download-temporary/add', ["uses" => "ContentController@downloadAdd", "permissions" => "admin/content/download-temporary/add"]);

        Route::any('/download-temporary/edit/{id}', ["uses" => "ContentController@downloadEdit", "permissions" => "admin/content/download-temporary/edit"]);

        Route::any('/download-temporary/delete/{id}', ["uses" => "ContentController@downloadDel", "permissions" => "admin/content/download-temporary/delete"]);

        Route::any('/submit', ["uses" => "ContentController@submit", "permissions" => "admin/content/submit"]);


    });


    Route::any('/caseSubmit', ["uses" => "CaseController@submit", "permissions" => "admin/caseSubmit"]);

    Route::any('/newsSubmit', ["uses" => "NewsController@submit", "permissions" => "admin/newsSubmit"]);


    //产品管理
    Route::group(["prefix" => "product"], function () {
        Route::any('/', ["uses" => "ProductController@index", "permissions" => "admin/product"]);

        Route::any('/add', ["uses" => "ProductController@add", "permissions" => "admin/product/add"]);

        Route::any('/edit/{id}', ["uses" => "ProductController@edit", "permissions" => "admin/product/edit"]);

        Route::any('/delete/{id}', ["uses" => "ProductController@productsDelete", "permissions" => "admin/product/delete"]);


        Route::any('/category', ["uses" => "ProductController@category", "permissions" => "admin/product/category"]);

        Route::any('/category/add', ["uses" => "ProductController@categoryAdd", "permissions" => "admin/product/category/add"]);

        Route::any('/category/edit/{id}', ["uses" => "ProductController@categoryEdit", "permissions" => "admin/product/category/edit"]);

        Route::any('/category/delete/{id}', ["uses" => "ProductController@categoryDel", "permissions" => "admin/product/category/delete"]);

    });

    Route::any('/ProductSubmit', ["uses" => "ProductController@submit", "permissions" => "admin/ProductSubmit"]);

    //友情链接管理
    Route::group(["prefix" => "blogroll"], function () {
        Route::any('/', ["uses" => "BlogrollController@index", "permissions" => "admin/blogroll"]);

        Route::any('/add', ["uses" => "BlogrollController@add", "permissions" => "admin/blogroll/add"]);

        Route::any('/edit/{id}', ["uses" => "BlogrollController@edit", "permissions" => "admin/blogroll/edit"]);

        Route::any('/delete/{id}', ["uses" => "BlogrollController@delete", "permissions" => "admin/blogroll/delete"]);

        Route::any('/submit', ["uses" => "BlogrollController@submit", "permissions" => "admin/blogroll/submit"]);

    });
    //公告管理
    Route::group(["prefix" => "notice"], function () {
        Route::any('/', ["uses" => "NoticeController@notice", "permissions" => "admin/notice"]);

        Route::any('/add', ["uses" => "NoticeController@add", "permissions" => "admin/notice/add"]);

        Route::any('/edit/{id}', ["uses" => "NoticeController@edit", "permissions" => "admin/notice/edit"]);

        Route::any('/delete/{id}', ["uses" => "NoticeController@noticeDelete", "permissions" => "admin/notice/delete"]);


        Route::any('/category', ["uses" => "NoticeController@category", "permissions" => "admin/notice/category"]);

        Route::any('/category/add', ["uses" => "NoticeController@categoryAdd", "permissions" => "admin/notice/category/add"]);

        Route::any('/category/edit/{id}', ["uses" => "NoticeController@categoryEdit", "permissions" => "admin/notice/category/edit"]);

        Route::any('/category/delete/{id}', ["uses" => "NoticeController@categoryDel", "permissions" => "admin/notice/category/delete"]);

    });

    Route::any('/noticeSubmit', ["uses" => "NoticeController@submit", "permissions" => "admin/noticeSubmit"]);


    //模块入口
    Route::any('/module', ["uses" => "ModuleController@init", "permissions" => ""]);


    //协议管理
    Route::group(["prefix" => "agreement"], function () {
        Route::any('/', ["uses" => "AgreementController@index", "permissions" => "admin/agreement"]);

        Route::any('/add', ["uses" => "AgreementController@add", "permissions" => "admin/agreement/add"]);

        Route::any('/edit/{id}', ["uses" => "AgreementController@edit", "permissions" => "admin/agreement/edit"]);

        Route::any('/delete/{id}', ["uses" => "AgreementController@delete", "permissions" => "admin/agreement/delete"]);

        Route::any('/category', ["uses" => "AgreementController@category", "permissions" => "admin/agreement/category"]);

        Route::any('/category/add', ["uses" => "AgreementController@categoryAdd", "permissions" => "admin/agreement/category/add"]);

        Route::any('/category/edit/{id}', ["uses" => "AgreementController@categoryEdit", "permissions" => "admin/agreement/category/edit"]);

        Route::any('/category/delete/{id}', ["uses" => "AgreementController@categoryDel", "permissions" => "admin/agreement/category/delete"]);

    });
    Route::any('/agreementSubmit', ["uses" => "AgreementController@submit", "permissions" => "admin/agreementSubmit"]);

    Route::any('/seo', ["uses" => "SeoController@index", "permissions" => "admin/seo"]);
    Route::any('/seoSubmit', ["uses" => "SeoController@submit", "permissions" => "admin/seoSubmit"]);


    //增加编辑器的后台上传接口
    Route::any('/uploadByEditByName/{name}', ["uses" => "UploadIMGController@uploadByEditByName", "permissions" => ""]);

    //广告管理
    Route::group(["prefix" => "advertisement"], function () {
        Route::any('/', ["uses" => "AdvertisementController@index", "permissions" => "admin/advertisement"]);
        Route::any('/add', ["uses" => "AdvertisementController@add", "permissions" => "admin/advertisement/add"]);
        Route::any('/edit', ["uses" => "AdvertisementController@edit", "permissions" => "admin/advertisement/edit"]);
        Route::any('/delete/{id}', ["uses" => "AdvertisementController@delete", "permissions" => "admin/advertisement/delete"]);
    });
    //banner管理
    Route::group(["prefix" => "banner"], function () {
        Route::any('/', ["uses" => "BannerController@index", "permissions" => "admin/advertisement"]);
        Route::any('/add', ["uses" => "BannerController@add", "permissions" => "admin/banner/add"]);
        Route::any('/edit', ["uses" => "BannerController@edit", "permissions" => "admin/banner/edit"]);
        Route::any('/delete/{id}', ["uses" => "BannerController@delete", "permissions" => "admin/banner/delete"]);
    });
    //开屏广告管理
    Route::group(["prefix" => "openAD"], function () {
        Route::any('/', ["uses" => "OpenADController@index", "permissions" => "admin/openAD"]);
        Route::any('/add', ["uses" => "OpenADController@add", "permissions" => "admin/openAD/add"]);
        Route::any('/edit', ["uses" => "OpenADController@edit", "permissions" => "admin/openAD/edit"]);
        Route::any('/delete/{id}', ["uses" => "OpenADController@delete", "permissions" => "admin/openAD/delete"]);
    });

    //文章管理
    Route::group(["prefix" => "article"], function () {
        Route::any('/', ["uses" => "ArticleController@index", "permissions" => "admin/article"]);

        Route::any('/add', ["uses" => "ArticleController@add", "permissions" => "admin/article/add"]);

        Route::any('/edit/{id}', ["uses" => "ArticleController@edit", "permissions" => "admin/article/edit"]);

        Route::any('/delete/{id}', ["uses" => "ArticleController@productsDelete", "permissions" => "admin/article/delete"]);


        Route::any('/category', ["uses" => "ArticleController@category", "permissions" => "admin/article/category"]);

        Route::any('/category/add', ["uses" => "ArticleController@categoryAdd", "permissions" => "admin/article/category/add"]);

        Route::any('/category/edit/{id}', ["uses" => "ArticleController@categoryEdit", "permissions" => "admin/article/category/edit"]);

        Route::any('/category/delete/{id}', ["uses" => "ArticleController@categoryDel", "permissions" => "admin/article/category/delete"]);

    });

    Route::any('/ArticleSubmit', ["uses" => "ArticleController@submit", "permissions" => "admin/ArticleSubmit"]);


    //视频管理
    Route::group(["prefix" => "video"], function () {
        Route::any('/', ["uses" => "VideoController@index", "permissions" => "admin/video"]);
        Route::any('/add', ["uses" => "VideoController@add", "permissions" => "admin/video/add"]);
        Route::any('/edit/{id}', ["uses" => "VideoController@edit", "permissions" => "admin/video/edit"]);
        Route::any('/delete/{id}', ["uses" => "VideoController@delete", "permissions" => "admin/video/delete"]);

        Route::any('/category', ["uses" => "VideoController@category", "permissions" => "admin/video/category"]);
        Route::any('/categoryAdd', ["uses" => "VideoController@categoryAdd", "permissions" => "admin/video/categoryAdd"]);
        Route::any('/categoryEdit/{id?}', ["uses" => "VideoController@categoryEdit", "permissions" => "admin/video/categoryEdit"]);
        Route::any('/categoryDelete/{id}', ["uses" => "VideoController@categoryDelete", "permissions" => "admin/video/categoryDelete"]);
    });
});
