<?php

namespace App\Http\Controllers\Admin;

use App\Events\CheckVersionUpdate;
use App\Libs\license\license;
use App\Models\Modules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FuncController extends Controller
{
    //模块列表
    function feature(){
		
        return license::FuncFeature();
    }

    //下载模块
    function download()
    {
        return license::FuncDownload($this->request);
    }

    //模块安装
    function install(){
        return license::FuncInstall($this->request);
    }

    //卸载
    function uninstall(){
        return license::FuncUninstall($this->request);
    }

    //模块的启用与禁用操作流程处理
    function changeStatus(){
        return license::FuncChangeStatus($this->request);
    }

    //是否设置为网站首页模块
    function changeIndex(){
        return license::FuncChangeIndex($this->request);
    }

    //更新模块的版本
    function uploadModuleVersion()
    {
        return license::FuncUploadModuleVersion($this->request);
    }
}
