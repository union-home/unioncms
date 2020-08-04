<?php

namespace App\Http\Controllers\Admin;


use App\Libs\license\license;
use App\Models\CaseModel;
use App\Models\HomeVisitLog;
use App\Models\Member;
use App\Models\Modules;
use App\Models\Themes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //首页
    function index(){
        //GD库信息
        if(function_exists("gd_info")){
            $gd = gd_info();
            $gdinfo = $gd['GD Version'];
        }else $gdinfo = "未知";

        $freetype = $gd["FreeType Support"] ? "支持" : "不支持";
        $allowurl= ini_get("allow_url_fopen") ? "支持" : "不支持";
        $max_upload = ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled";
        $max_ex_time= ini_get("max_execution_time")."秒";
        $memory_limit = get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"无" ;
        $version = DB::select("select version() as version")[0]->version;

        //获取统计
        $total_member = Member::where("status","=",1)->count();

        //拓展总数
        $total_extend = Modules::count()+Themes::count();
        //案例数量
        $total_case = CaseModel::count();
        //总访问量
        $total_visit = HomeVisitLog::count();

        return view("admin/".ADMIN_SKIN."/index/index",[
            "gdinfo"=>$gdinfo,
            "freetype"=>$freetype,
            "allowurl"=>$allowurl,
            "max_upload"=>$max_upload,
            "max_ex_time"=>$max_ex_time,
            "memory_limit"=>$memory_limit,
            "version"=>$version,
            "total_member"=>$total_member,
            "total_case"=>$total_case,
            "total_extend" => $total_extend,
            "total_visit" =>$total_visit
        ]);
    }

    //退出
    function logout(Request $request){
        $request->session()->forget('admin_info');
        return redirect('admin/login');
    }

    //更新CMS
    function updateCmsVersion()
    {
        return license::updateCmsVersion($this->request);
    }

    function getBackCmsZipSize(){
        $params = $this->request->all();
        $path = storage_path() . '/backups';
        $file_name = $path . '/' . date('Ymd-His', $params['time']) . '.zip';// . '-' . random_verification_code(4)

        //备份目录所有的大小
        $backup_directory_file_size = get_dir_size(base_path(), 0, license::$backup_paths);

        /**
         * 获取备份目录下，筛选出正在备份的文件压缩包，并得到当前压缩包的大小
         */
        $handler = opendir($path); //打开当前文件夹由$path指定。
        while(($filename=readdir($handler))!==false){
            if($filename != '.' && $filename != '..'){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (strstr($path.'/'.$filename, $file_name)) {
                    return ['status' => 200, 'data' => [
                        'dir_filesize' => $backup_directory_file_size / 1024,//直接压缩文件备份的目录的大小
                        'zip_filesize' => filesize($path.'/'.$filename) / 1024,//当前正在进行压缩的包
                    ]];
                }
            }
        }

        // 这种方式：
        //          压缩包下载到本地 -> 本地解压 -> 本地打包生成指定ZIP【会有很多的步骤操作流程处理|！@！！】
        //
        // $path = storage_path() . '/backups/';
        // $handler = opendir($path); //打开当前文件夹由$path指定。
        // while(($filename=readdir($handler))!==false){
        //     if($filename != '.' && $filename != '..'){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
        //         if (strstr($path.'/'.$filename, '123456.zip.')) {
        //             var_export('压缩包：' . $path.'/'.$filename . '大小为：' . filesize($path.'/'.$filename));
        //         }
        //     }
        // }
    }
}
