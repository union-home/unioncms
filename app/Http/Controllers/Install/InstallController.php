<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use App\Libs\license\SqlLog;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{


      static  private $dataPath = __DIR__."/data/unioncms.sql";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        //判断是否安装过)
        if(self::checkInstall()){
            throw new \Exception("CMS已经安装过，如需重新安装，请删除Public目录下install.lock文件。");
        }

        view()->share([
            'cms_name' => 'UnionCMS',
            'cms_url' => 'http://www.unioncms.cn',
            ]);
    }

    public static function checkInstall()
    {
        return is_file(public_path() . '/install.lock') ? true : false;
    }

    public function index()
    {
        $params = $this->request->all();
        $params['install'] = isset($params['install']) ? $params['install'] : 1;
        switch (intval($params['install'])) {
            case 2: //检测环境
                $data               = [];
                $data['phpversion'] = @phpversion();
                $data['os']         = PHP_OS;
                $tmp                = function_exists('gd_info') ? gd_info() : [];
                // $server             = $_SERVER["SERVER_SOFTWARE"];
                // $host               = $this->request->host();
                // $name               = $_SERVER["SERVER_NAME"];
                // $max_execution_time = ini_get('max_execution_time');
                // $allow_reference    = (ini_get('allow_call_time_pass_reference') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
                // $allow_url_fopen    = (ini_get('allow_url_fopen') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
                // $safe_mode          = (ini_get('safe_mode') ? '<font color=red>[×]On</font>' : '<font color=green>[√]Off</font>');

                $err = 0;
                if (empty($tmp['GD Version'])) {
                    $gd = '<font color=red>[×]Off</font>';
                    $err++;
                } else {
                    $gd = '<font color=green>[√]On</font> ' . $tmp['GD Version'];
                }

                if (class_exists('pdo')) {
                    $data['pdo'] = '<i class="fa fa-check correct"></i> 已开启';
                } else {
                    $data['pdo'] = '<i class="fa fa-remove error"></i> 未开启';
                    $err++;
                }

                if (extension_loaded('pdo_mysql')) {
                    $data['pdo_mysql'] = '<i class="fa fa-check correct"></i> 已开启';
                } else {
                    $data['pdo_mysql'] = '<i class="fa fa-remove error"></i> 未开启';
                    $err++;
                }

                if (extension_loaded('curl')) {
                    $data['curl'] = '<i class="fa fa-check correct"></i> 已开启';
                } else {
                    $data['curl'] = '<i class="fa fa-remove error"></i> 未开启';
                    $err++;
                }

                if (extension_loaded('gd')) {
                    $data['gd'] = '<i class="fa fa-check correct"></i> 已开启';
                } else {
                    $data['gd'] = '<i class="fa fa-remove error"></i> 未开启';
                    if (function_exists('imagettftext')) {
                        $data['gd'] .= '<br><i class="fa fa-remove error"></i> FreeType Support未开启';
                    }
                    $err++;
                }

                if (extension_loaded('mbstring')) {
                    $data['mbstring'] = '<i class="fa fa-check correct"></i> 已开启';
                } else {
                    $data['mbstring'] = '<i class="fa fa-remove error"></i> 未开启';
                    if (function_exists('imagettftext')) {
                        $data['mbstring'] .= '<br><i class="fa fa-remove error"></i> FreeType Support未开启';
                    }
                    $err++;
                }

                if (extension_loaded('fileinfo')) {
                    $data['fileinfo'] = '<i class="fa fa-check correct"></i> 已开启';
                } else {
                    $data['fileinfo'] = '<i class="fa fa-remove error"></i> 未开启';
                    $err++;
                }

                $swoole_info =w_getSysInfo();
                if($swoole_info["swoole_loader"]){
                    $data['swoole_loader'] = '<i class="fa fa-check correct"></i> 已开启';
                } else {
                    $data['swoole_loader'] = '<i class="fa fa-remove error"></i> 未开启';
                    $err++;
                }


                if (ini_get('file_uploads')) {
                    $data['upload_size'] = '<i class="fa fa-check correct"></i> ' . ini_get('upload_max_filesize');
                } else {
                    $data['upload_size'] = '<i class="fa fa-remove error"></i> 禁止上传';
                }

                if (function_exists('session_start')) {
                    $data['session'] = '<i class="fa fa-check correct"></i> 支持';
                } else {
                    $data['session'] = '<i class="fa fa-remove error"></i> 不支持';
                    $err++;
                }

                if (version_compare(phpversion(), '5.6.0', '>=') && version_compare(phpversion(), '7.0.0', '<') && ini_get('always_populate_raw_post_data') != -1) {
                    $data['always_populate_raw_post_data']          = '<i class="fa fa-remove error"></i> 未关闭';
                    $data['show_always_populate_raw_post_data_tip'] = true;
                    $err++;
                } else {
                    $data['always_populate_raw_post_data'] = '<i class="fa fa-check correct"></i> 已关闭';
                }

                $folders    = [
                    "app",
                    "backup",
                    "config",
                    "public",
                    "resources",
                    "storage",
                    ".env"
                ];
                $newFolders = [];
                foreach ($folders as $dir) {
                    $testDir = base_path()."/".$dir;
                    self::sp_dir_create($testDir);
                    if(!is_file($testDir)){
                        if (self::sp_testwrite($testDir)) {
                            $newFolders[$dir]['w'] = true;
                        } else {
                            $newFolders[$dir]['w'] = false;
                            $err++;
                        }
                    }else{
                        if(is_writable($testDir)){
                            $newFolders[$dir]['w'] = true;
                        }else{
                            $newFolders[$dir]['w'] = false;
                            $err++;
                        }
                    }

                    if (is_readable($testDir)) {
                        $newFolders[$dir]['r'] = true;
                    } else {
                        $newFolders[$dir]['r'] = false;
                        $err++;
                    }
                }
                $data['folders'] = $newFolders;
                view()->share(['data' => $data]);
                break;
            case 4: //创建数据 - 提交
                $params = $this->request->all();

                /**
                 * 设置数据库配置
                 */
                if(isset($params['dbhost'])) $env['DB_HOST'] = $params['dbhost'];
                if(isset($params['dbname'])) $env['DB_DATABASE'] = $params['dbname'];
                if(isset($params['dbuser'])) $env['DB_USERNAME'] = $params['dbuser'];
                if(isset($params['dbpw'])) $env['DB_PASSWORD'] = $params['dbpw'];
                if(isset($params['dbprefix'])) $env['DB_PREFIX'] = $params['dbprefix'];
                if(isset($env)) $install['env'] = $env;

                /**
                 * 网站SEO
                 */
                $settings=[];
                $in_database = [
                    'website_name',
                    'website_keys',
                    'website_desc',
                    ];
                foreach ($params as $key => $value){
                    if(in_array($key,$in_database)){
                        if($key=='website_reg_rqstd'){
                            $value = implode(",", $value);
                        }
                        array_push($settings,[ 'key' => $key, 'value' => $value]);
                    }
                }
                $install['settings'] = $settings;

                /**
                 * 设置管理员信息
                 */
                $install['admin'] = [
                    'username' => $params['manager'],
                    'email' => $params['manager_email'],
                    'password' => member_encryption_mode($params['manager_pwd']),
                ];

                /**
                 * SQL文件处理
                 */
                $con = mysqli_connect($params['dbhost'], $params['dbuser'], $params['dbpw']) or die('不能连接数据库 $DB_HOST');
                $sql    = "CREATE DATABASE IF NOT EXISTS `{$env['DB_DATABASE']}` DEFAULT CHARACTER SET " . $params['dbcharset'];
                mysqli_query($con, $sql);

                $sql  = get_split_sql(self::$dataPath, $env['DB_PREFIX'], $params['dbcharset'], 'union_');
                $install['sql'] = $sql;

                session()->put('install', $install);
                break;
            default:
                # code...
                break;
        }
        return view('install/index/install' . $params['install']);
        // return view('home/install/' . __FUNCTION__);
    }

    public function testDbPwd()
    {
        if ($this->request->method('post')) {
            $dbConfig         = $this->request->all();
            $dbConfig['type'] = "mysql";
            $supportInnoDb = false;
            try {
                $conf = mysqli_connect($dbConfig['hostname'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']) or die('不能连接数据库 $DB_HOST');//连接数据库
                return ['msg' => '验证成功!', 'status' => 200];
            } catch (\Exception $e) {
                return ['msg' => '数据库账号或密码不正确！' . $e->getMessage(), 'status' => 40000];
            }
        } else {
            return ['msg' => '非法请求方式!', 'status' => 40000];
        }
    }

    public function start()
    {
        $install = session('install');

        if (empty($install['sql'])) return ['msg' => "非法安装!", 'status' => 40000];

        $params = $this->request->all();
        $sqlIndex = isset($params['sql_index']) ? intval($params['sql_index']) : 0;

        if ($sqlIndex >= count($install['sql'])) {
            $installError = session('install.error');
            return ['status' => 200, 'msg' => "安装完成!", 'data' => ['done' => 1, 'error' => $installError]];
        }

        $sqlToExec = $install['sql'][$sqlIndex] . ';';

        //使用之前的方式，一次性录入
        $db_config = session('install.env');

        /**
         * 这种方式录入太慢了 --- 主要是国家省市区表数据量太多的问题【分离出来】，让会员手动导入
         */
        $conf = mysqli_connect($db_config['DB_HOST'], $db_config['DB_USERNAME'], $db_config['DB_PASSWORD'], $db_config['DB_DATABASE']) or die('不能连接数据库 $DB_HOST');//连接数据库

        mysqli_query($conf,"set names utf8"); //**设置字符集***

        /**
         * 一次性导入SQL文件的方式
         */
        // self::importSqlFiles($conf, $database_file);
        // return ['status' => 200, 'msg' => "安装完成!", 'data' => ['done' => 1]];
        // exit;


        /**
         * 安装行数进行导入，对于客户而言，会有一点点体验感
         * 现在的处理方式：把 ‘地区表’ 拆出一个SQL文件，让会员手动导入，量太大了【并且删除了测试数据，尽量只新增表，数据不做新增，要不然不建议使用下面这种方式】
         */

        $result = self::sp_execute_sql($conf, $sqlToExec, $sqlIndex);
        if (!empty($result['error'])) {
            $installError = session('install.error');
            $installError = empty($installError) ? 0 : $installError;

            session('install.error', $installError + 1);
            return ['msg' => $result['message'], 'status' => 40000, 'data' => [
                'sql'       => $sqlToExec,
                'exception' => $result['exception']
            ]];
        } else {
            return ['status' => 200, 'msg' => $result['message'], 'data' => [
                'sql' => $sqlToExec
            ]];
        }
    }

    /**
     * 数据表与数据录入
     */
    private static function importSqlFiles($conf, $database_file = ''){
        header('content-type:text/html;charset=utf-8');
        if(empty($database_file)) $database_file = self::$dataPath;

        if(is_file($database_file))
        {
            $tables_name = [];
            $_sql = file_get_contents($database_file);
            $_arr = explode(';', $_sql);
            foreach ($_arr as $_value) {
                mysqli_query($conf, "SET NAMES 'utf8'");
                mysqli_query($conf, $_value.';');
                SqlLog::setSql($_value);
                // foreach (SqlLog::importTableNames() as $k => $v) {
                //     if (!in_array($v, $tables_name)) $tables_name[] = $v;
                // }
            }
        }else throw new \Exception("数据库SQL文件丢失！", 1);   
    }

    public function setDbConfig()
    {
        $env = session('install.env');
        self::writeDatabaseConfig($env);
        return ['msg' => '数据配置文件写入成功!', 'status' => 200];
    }

    public function setSite()
    {
        try {
            $setting = new Setting;
            $setting->updateBatch(session('install.settings'));

            Cache::forget('settings');//更新缓存

            $admin = session('install.admin');
            if (Member::where('username', $admin['username'])->first()) {
                Member::where('username', $admin['username'])->update($admin);
            }else{
                $admin['status'] = 1;
                $admin["gid"] = 0;
                $admin["type"] = "admin";
                $admin["avatar"] = "avatar/avatar.jpg";
                $admin["create_at"] = date("Y-m-d H:i:s");
                Member::updateOrCreate($admin);
            }

            write_lock_file(public_path(), '', 'install.lock');
        } catch (\Exception $e) {
            return ['msg' => "网站创建失败!" . $e->getMessage(), 'status' => 40000];
        }
        return ['msg' => '网站创建完成!【请手动导入根目录 ‘unioncms - area’ 地区表，数据量太大】', 'status' => 200];
    }

    /**
     * 数据库配置项重写
     */
    private function writeDatabaseConfig($params = [])
    {
        $limit_unique = ['DB_PREFIX', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
        $update_env = [];
        foreach ($params as $key => $value) {
            if (in_array($key, $limit_unique)) $update_env[$key] = $value;
        }
        modifyEnv($update_env);//更新ENV配置文件中的数据库配置项
    }

    private function sp_execute_sql($db, $sql, $sqlIndex = 0 )
    {
        $sql = trim($sql);
        preg_match('/CREATE TABLE .+ `([^ ]*)`/', $sql, $matches);
        if ($matches) {
            $table_name = $matches[1];
            $msg        = "创建数据表".$table_name;
            try {
                mysqli_query($db, $sql);
                return [
                    'error'   => 0,
                    'message' => $msg . ' 成功！'
                ];
            } catch (\Exception $e) {
                return [
                    'error'     => 1,
                    'message'   => $msg . ' 失败！',
                    'exception' => $e->getTraceAsString()
                ];
            }

        } else {
            $msg = '执行成功!';
            if (preg_match('/((INSERT\\s+?INTO))[\\s`]+?(\\w+)[\\s`]+?/is', $sql, $table_name)) {
                $msg = '数据表' . array_pop($table_name) . '录入数据……';
            }else if (preg_match('/((Table structure for))[\\s`]+?(\\w+)[\\s`]+?/is', $sql, $table_name)) {
                $msg = '创建数据表' . array_pop($table_name) . '……开始';
            }else if (preg_match('/((CREATE TABLE))[\\s`]+?(\\w+)[\\s`]+?/is', $sql, $table_name)) {
                $msg = '创建数据表' . array_pop($table_name) . '……结束' . '执行成功!';
            }else if (preg_match('/((-- Records of))[\\s`]+?(\\w+)[\\s`]+?/is', $sql, $table_name)) {
                $msg = '数据表' . array_pop($table_name) . '录入数据……';
            }else{
            }
            try {
                mysqli_query($db, $sql);
                return [
                    'error'   => 0,
                    'message' => 'SQL' . $msg
                ];
            } catch (\Exception $e) {
                return [
                    'error'     => 1,
                    'message'   => 'SQL' . $msg . '执行失败！',
                    'exception' => $e->getTraceAsString()
                ];
            }
        }
    }

    private static function sp_dir_create($path, $mode = 0777)
    {
        if (is_dir($path))
            return true;
        $ftp_enable = 0;
        //$path       = sp_dir_path($path);
        $temp       = explode('/', $path);
        $cur_dir    = '';
        $max        = count($temp) - 1;
        for ($i = 0; $i < $max; $i++) {
            $cur_dir .= $temp[$i] . '/';
            if (@is_dir($cur_dir))
                continue;
            @mkdir($cur_dir, 0777, true);
            @chmod($cur_dir, 0777);
        }
        return is_dir($path);
    }

    private static function sp_testwrite($d)
    {
        $tfile = "_test.txt";
        $fp    = @fopen($d . "/" . $tfile, "w");
        if (!$fp) {
            return false;
        }
        fclose($fp);
        $rs = @unlink($d . "/" . $tfile);
        if ($rs) {
            return true;
        }
        return false;
    }
}
