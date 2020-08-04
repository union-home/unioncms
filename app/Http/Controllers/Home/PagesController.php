<?php

namespace App\Http\Controllers\Home;

use App\Events\Login;
use App\Models\ContactUs;
use App\Models\Member;
use App\Models\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

    }

    //  关于我们
    public function about()
    {

        $loadcss = "about";
        $uri = "about";

        $page = Pages::find(1);

        set_seo_config("page", $page);//SEO配置渲染

        if(!$page){
            return back()->withErrors("数据不存在！");
        }

        return view('home.'.HOME_SKIN.'.pages.about',[
            "loadcss"=>$loadcss,
            "uri"=>$uri
        ]);
    }

    //联系我们
    function contact(){

        $loadcss = "contact";
        $uri = "contact";

        $page = Pages::find(2);

        if(!$page){
            return back()->withErrors("数据不存在！");
        }

        //获取联系我们的信息
        $contact_info = new ContactUs();

        $contact_infos = $contact_info->get();

        set_seo_config("page", $page);//SEO配置渲染

        return view('home.'.HOME_SKIN.'.pages.contact',[
            "loadcss"=>$loadcss,
            "uri"=>$uri,
            "contact_infos"=>$contact_infos
        ]);
    }

    //万能模板
    function load($page){
        $loadcss = $page;
        $uri = $page;
        $document_list = [];
        return view('home.'.HOME_SKIN.'.pages.'.$page,[
            "loadcss"=>$loadcss,
            "uri"=>$uri,
            'document_list' => $document_list
        ]);
    }
}
