<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Language;
use App\Models\SystemMessage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //构造函数
    public function __construct(Request $request)
    {
        $this->request = $request;

        if(is_install()){ //如果未安装程序，屏蔽所有数据表查询
            $this->settings = cacheGlobalSettings();//设置配置
            $this->languages = Language::getAll();//语言列表
            $this->currencys = Currency::getAll();//货币列表
            $this->menus = getMenuData();//菜单列表
            $this->systemMessages = SystemMessage::getData();//获取站内信

            //SEO配置
            set_seo_config();

            //视图间共享数据
            view()->share(array(
                "languages" => $this->languages,
                "currencys" => $this->currencys,
                "settings"  => $this->settings,
                "menus"     => $this->menus,
                "systemMessages"=>$this->systemMessages
            ));
        }

    }
}
