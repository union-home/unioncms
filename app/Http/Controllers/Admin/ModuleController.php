<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;

class ModuleController extends Controller
{
    function init(){
        $path = app_path("Http/Controllers/Module/".$_GET["m"]."/Admin/IndexController.php");
        if($_GET["m"] && file_exists($path)){
            $classname = '\App\Http\Controllers\Module\\'.$_GET["m"].'\Admin\IndexController';
            $controller = new $classname($this->request);
            if (method_exists($controller, 'index')) return call_user_func_array(array($controller, "index"),[]);
        }
        $m = $_GET["m"];
        return view("admin/".ADMIN_SKIN."/module/default/admin/index",[
            "module_name" => 'default',
            "module_url" => url('admin/module?m=' . $m),
            "_module_name" => $m,
            'nav_active' => 'index',
            'user_total' => Member::where('type', 'member')->count(),
        ]);
    }
}
