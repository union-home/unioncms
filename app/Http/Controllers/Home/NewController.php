<?php

namespace App\Http\Controllers\Home;

use App\Models\NewsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewController extends Controller
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

    //首页新闻列表
    public static function indexNews()
    {
        $news = NewsModel::orderBy('id', 'desc')->limit(6)->get();
        
        if (!empty($news)) {
            foreach ($news as $key => &$value) $value->content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', '', ($value->content));//因为是首页，内容肯定不应该展示出来图片
        }
        return $news;
    }

    //新闻
    public function news()
    {
        $loadcss = "newList";
        $uri = "news";
        $get = $this->request->all();
        //分页
        if(isset($get["cid"])){
            $datas = NewsModel::orderBy("id", "desc")->where("cid","=",$get["cid"])->paginate(20);
        }else{
            $datas = NewsModel::orderBy("id", "desc")->paginate(20);
        }

        set_seo_config("news_list");//SEO配置渲染

        return view('home.'.HOME_SKIN.'.new.news',[
            "loadcss"=>$loadcss,
            "uri" =>$uri,
            "datas" => $datas
        ]);
    }

    //新闻详情
    public function newsDetail()
    {
        $loadcss = "newList";
        $uri = "news";

        $get = $this->request->all();

        if(!isset($get["id"])) return back()->withErrors("参数有误!");

        //获取信息
        $data = NewsModel::where("news.id","=",$get["id"])
            ->select("news.*","news_category.name as category_name")
            ->leftJoin("news_category","news_category.id","=","news.cid")
            ->first();
        if(empty($data)) return back()->withErrors("新闻不存在!");
        if(!empty($data)) $data->create_time = strtotime($data->create_at);

        $last_article = NewsModel::where("news.id", "<", $get["id"])->first();
        if(!empty($last_article)) $last_article->create_time = strtotime($last_article->create_at);
        $next_article = NewsModel::where("news.id", ">", $get["id"])->first();
        if(!empty($next_article)) $next_article->create_time = strtotime($next_article->create_at);

        set_seo_config("news", $data);//SEO配置渲染

        return view('home.'.HOME_SKIN.'.new.newsDetail',[
            "loadcss"=>$loadcss,
            "uri" =>$uri,
            "data"=>$data,
            "last_article" => $last_article,
            "next_article" => $next_article,
        ]);
    }


}
