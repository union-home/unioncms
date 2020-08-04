<?php

namespace App\Http\Controllers\Home;

use App\Models\CaseCategory;
use App\Models\CaseModel;
use App\Models\ProductCategory;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
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

    //产品
    public function product()
    {
        $loadcss = "product";
        $uri = "product";
        $get = $this->request->all();
        //获取所有产品分类
        $ProductCategory = ProductCategory::all();
        //获取案例分页
        $where = [];
        $params['screen'] = isset($get['screen']) ? trim($get['screen']) : '';
        $params['search'] = isset($get['search']) ? trim($get['search']) : '';
        $params['cid'] = isset($get['cid']) ? intval($get['cid']) : -1;
        if(!empty($params['screen'])) $where[] = [$params['screen'], '=', 1];//筛选操作
        if(!empty($params['search'])) $where[] = ['title', 'LIKE', '%' . $params['search'] .'%'];//筛选操作

        if($params['cid'] != -1){
            $datas = ProductModel::where($where)->orderBy("id","desc")->where("cid", "=", $params['cid'])->paginate(20);
        }else{
            $datas = ProductModel::where($where)->orderBy("id","desc")->paginate(20);
        }

        set_seo_config("product_list");//SEO配置渲染

        return view('home.'.HOME_SKIN.'.product.product',[
            "loadcss"=>$loadcss,
            "uri" =>$uri,
            "datas"=>$datas,
            "ProductCategory"=>$ProductCategory,
            'params' => $params
        ]);
    }

    //产品详情
    public function product_detail()
    {
        $loadcss = "product";
        $uri = "product";

        $get = $this->request->all();

        if(!isset($get["id"])){
            return back()->withErrors("参数有误!");
        }

        //获取产品信息
        $data = ProductModel::where("product.id","=",$get["id"])
                ->select("product.*","product_category.name as category_name")
                ->leftJoin("product_category","product_category.id","=","product.cid")
                ->first();

        set_seo_config("product", $data);//SEO配置渲染

        return view('home.'.HOME_SKIN.'.product.productDetail',[
            "loadcss"=>$loadcss,
            "uri" =>$uri,
            "data"=>$data,
            "rec_data" => $this->getRecList($data['id'])
        ]);
    }

    private function getRecList($id = 0)
    {
        return ProductModel::where("is_rec", 1)->where('id', '<>', $id)->limit(6)->get();
    }
}
