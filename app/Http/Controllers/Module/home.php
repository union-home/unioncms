<?php
Route::group([], function () {

    if(is_install()) {  //如果未安装程序，屏蔽所有数据表查询
        //获取已安装的module
        //加载模块的路由
        $modules_install_datas = json_decode(MODULE_INSTALL_ALL);
        foreach ($modules_install_datas as $modules_install_data) {
            //模块状态，1=已启用，0=未启用
            if($modules_install_data->status != 1) continue;

            if (file_exists(dirname(__FILE__) . "/" . $modules_install_data->identification . "/routes/home.php")) {
                include_once dirname(__FILE__) . "/" . $modules_install_data->identification . "/routes/home.php";
            }

            //类型：0.功能模块；1.插件
            if($modules_install_data->cloud_type != 0) continue;

            if(file_exists(dirname(__FILE__)."/".$modules_install_data->identification."/Helper/function.php")){
                include_once dirname(__FILE__)."/".$modules_install_data->identification."/Helper/function.php";
            }
        }
    }
});