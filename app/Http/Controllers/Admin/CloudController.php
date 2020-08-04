<?php

namespace App\Http\Controllers\Admin;

use App\Libs\license\license;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 云应用
 * Class CloudController
 * @package App\Http\Controllers\Admin
 */
class CloudController extends Controller
{
    //云应用列表
    function index(){
        return license::cloudIndex($this->request);
    }

    //云应用的启用与禁用操作流程处理
    function changeStatus(){
        return license::cloudChangeStatus($this->request);
    }

    //插件 - 卸载
    function pluginUninstall(){
        return license::pluginUninstall($this->request);
    }

    //安装/更新 插件的版本
    function pluginDownloadVersion()
    {
        return license::pluginDownloadVersion($this->request);
    }

    //主题模板 - 安装/更新
    function themeTemplateDownloadVersion()
    {
        return license::themeTemplateDownloadVersion($this->request);
    }

    //主题模板 - 卸载
    function themeTemplateUninstall()
    {
        return license::themeTemplateUninstall($this->request);   
    }

    // 进度条 --- 废弃！！！
    function getCloudAppDownloadProgress()
    {
        return license::getCloudAppDownloadProgress($this->request);
    }
}
