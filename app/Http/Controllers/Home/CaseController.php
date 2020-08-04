<?php

namespace App\Http\Controllers\Home;

use App\Models\CaseCategory;
use App\Models\CaseModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CaseController extends Controller
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

    //案例
    public function example()
    {
        $loadcss = "case";
        $uri = "case";
        $get = $this->request->all();
        //获取所有案例分类
        $caseCategory = CaseCategory::all();
        //获取案例分页
        $where = [];
        $params['screen'] = isset($get['screen']) ? trim($get['screen']) : '';
        $params['search'] = isset($get['search']) ? trim($get['search']) : '';
        $params['cid'] = isset($get['cid']) ? intval($get['cid']) : -1;
        if(!empty($params['screen'])) $where[] = [$params['screen'], '=', 1];//筛选操作
        if(!empty($params['search'])) $where[] = ['title', 'LIKE', '%' . $params['search'] .'%'];//筛选操作

        if($params['cid'] != -1){
            $datas = CaseModel::where($where)
                ->orderBy('is_rec',"desc")
                ->orderBy('is_hot',"desc")
                ->orderBy('id',"desc")
                ->where("cid","=", $params['cid'])
                ->paginate(20);
        }else{
            $datas = CaseModel::where($where)
                ->orderBy('is_rec',"desc")
                ->orderBy('is_hot',"desc")
                ->orderBy('id',"desc")
                ->paginate(20);
        }
        //dd($datas);

        //SEO配置
        set_seo_config("case_list");

        return view('home.'.HOME_SKIN.'.case.case',[
            "loadcss"=>$loadcss,
            "uri" =>$uri,
            "datas"=>$datas,
            "caseCategory"=>$caseCategory,
            'params' => $params,
        ]);
    }

    //案例详情
    public function example_detail()
    {
        $loadcss = "cDetailed";
        $uri = "case";

        $get = $this->request->all();

        if(!isset($get["id"])){
            return back()->withErrors("参数有误!");
        }

        //获取案例信息
        $data = CaseModel::where("case.id","=",$get["id"])
            ->select("case.*","case_category.name as category_name")
            ->leftJoin("case_category","case_category.id","=","case.cid")
            ->first();

        set_seo_config("case", $data);//SEO配置渲染

        return view('home.'.HOME_SKIN.'.case.caseDetail',[
            "loadcss"=>$loadcss,
            "uri" =>$uri,
            "data"=>$data,
            "rec_data" => $this->getRecList($data['id'])
        ]);
    }

    private function getRecList($id = 0)
    {
        return CaseModel::where("is_rec", 1)->where('id', '<>', $id)->limit(8)->get();
    }
}
