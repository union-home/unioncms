<?php


use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use \Mail as Mail;
use Illuminate\Support\Facades\Storage;


//快速修改.env文件
/*

// 你可以更新你想要的任何值 key => value
$data = [
 'APP_ENV' => 'your_environment',
 'APP_KEY' => 'your_key',
 'APP_DEBUG' => 'trueOrFalse',
 'DB_DATABASE' => 'test',
 'DB_USERNAME' => 'test',
 'DB_PASSWORD' => 'test',
 'DB_HOST' => 'localhost',
 'CACHE_DRIVER' => 'file',
 'SESSION_DRIVER' => 'file',
];

// 或者
$data = [
 'DB_HOST' => '127.0.0.1',
];

// 使用函数更新
modifyEnv($data);

*/
function modifyEnv(array $data) {
    $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';

    $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));

    $contentArray->transform(function ($item) use ($data) {
        foreach ($data as $key => $value) {
            if (str_contains($item, $key)) {
                return $key . '=' . $value;
            }
        }

        return $item;
    });

    $content = implode($contentArray->toArray(), "\n");

    File::put($envPath, $content);
}


//获取全局settings缓存
function cacheGlobalSettings() {

    if (Cache::has('settings')) {
        return Cache::get('settings');
    }

    $settings = Setting::all();

    if ($settings) {
        $settings = $settings->toArray();
        foreach ($settings as $key => $value) {
            $all_setting[$value['key']] = $value;
        }
        Cache::put('settings', $all_setting, 5);
    }

    return Cache::get('settings');


}

//获取全局settings缓存通过key
function cacheGlobalSettingsByKey($key, $field = "value") {

    return Cache::get('settings')[$key][$field];

}

//获取全局settings缓存通过key
function __E($key, $field = "value") {
    if (!isset(Cache::get('settings')[$key])) {
        // by andy update 这里用之前的会一直报错  缓存不存在 重新获取
        $cache = Setting::where('key', $key)->first();
        //throw new \Exception("缓存" . $key . "不存在!");
        if (empty($cache)) throw new \Exception("缓存" . $key . "不存在!");
        return empty($cache[$field]) ? '' : $cache[$field];
    }
    $cache = Cache::get('settings')[$key];
    return empty($cache[$field]) ? '' : $cache[$field];
}

//发送邮件
function sendEmail($to_email = '', $content = '我是测试的内容！', $subject = '邮件测试') {
    checkEmail($to_email);

    // 模板文件
    /*Mail::send('globals.emails.test',['name'=>$name],function($message){
        $to = '282584778@qq.com';
        $message ->to($to)->subject('邮件测试');
    });*/

    try {
        //测试邮件
        Mail::raw($content, function ($message) use ($to_email, $subject) {
            $to = $to_email;
            $message->to($to)->subject($subject);
        });
        // 返回的一个错误数组，利用此可以判断是否发送成功
        return Mail::failures();

    } catch (Exception $exception) {
        throw new Exception($exception->getMessage(), 40000);
    }

}

//检测邮件格式
function checkEmail($email_adress) {

    $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';

    if (!preg_match($pattern, $email_adress)) {
        throw new Exception("Incorrect email address！", 40000);
    }
}

//获取某目录下所有子文件和子目录,可以过滤
function getDirContent($path, $filter = [], $onlydir = true) {
    if (!is_dir($path)) {
        return false;
    }
    //readdir方法
    /* $dir = opendir($path);
    $arr = array();
    while($content = readdir($dir)){
        if($content != '.' && $content != '..'){
            $arr[] = $content;
        }
    }
    closedir($dir); */

    //scandir方法
    $arr = array();
    $data = scandir($path);
    foreach ($data as $value) {
        if ($value != '.' && $value != '..' && $value != ".DS_Store" && !in_array($value, $filter)) {
            if ($onlydir) {
                if (is_dir($path . "/" . $value)) {
                    $arr[] = $value;
                } else {
                    continue;
                }
            } else {
                $arr[] = $value;
            }

        }
    }
    return $arr;
}

//上传单文件
function UploadFile($request,
                    $field,
                    $filename,
                    $allowExt = ALLOWEXT,
                    $drive = "local",
                    $preview = null,
                    $preview_w = 0,
                    $preview_h = 0,
                    $watermark_type = null,
                    $watermark_text = "",
                    $preview_watermark = null,
                    $watermark = null
) {

    //判断是否开启文件上传功能
    if (__E("upload_status") == 0) {
        throw new Exception("系统没有开启上传功能！", 40000);
    }

    //判断文件大小
    if ($_FILES[$field]['size'] <= 0) {

        throw new Exception("文件没有选择！", 40000);

    } else {

        //判断文件大小
        if ($_FILES[$field]['size'] / 1024 > __E("upload_limit")) {
            throw new Exception("超出文件设置大小！", 40000);
        }

        //判断文件格式
        $file = $request->file($field);
        //获取文件的扩展名
        $ext = $file->getClientOriginalExtension();
        $ext = strtolower($ext);
        //过滤文件格式
        if (!in_array($ext, explode(",", $allowExt))) {
            throw new Exception("文件格式不允许！", 40000);
        }
    }

    switch (__E("upload_driver")) {

        case "local":

            return _upload($request, $field, $filename, $allowExt, $drive, true, $preview, $preview_w, $preview_h, $watermark_type, $watermark_text, $preview_watermark, $watermark);

            break;


        default :

            //判断插件是否存在
            if (is_dir(PLUGIN_PATH_FILE . __E("upload_driver"))) {

                //触发上传驱动事件

                $filename = event(new \App\Events\UploadDriver($request, $field, $filename, $allowExt, $drive, "put"));

                return $filename[0];

            } else {

                throw new Exception("Upload driver does not exist！", 40000);

            }

            break;


    }


}

//上传操作
function _upload($request,
                 $field,
                 $filename,
                 $allowExt,
                 $drive,
                 $addAttachment = true,
                 $preview = null,
                 $preview_w = 0,
                 $preview_h = 0,
                 $watermark_type = null,
                 $watermark_text = "",
                 $preview_watermark = null,
                 $watermark = null
) {
    if ($_FILES[$field]['size'] <= 0) {
        return false;
    }
    $file = $request->file($field);
    if ($file->isValid()) { //括号里面的是必须加的哦
        //如果括号里面的不加上的话，下面的方法也无法调用的
        //获取文件的扩展名
        $ext = $file->getClientOriginalExtension();
        //获取文件的绝对路径
        $path = $file->getRealPath();

        //定义文件名
        $filename = $filename . '.' . $ext;

        //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
        Storage::disk($drive)->put($filename, file_get_contents($path));

        if ($preview) {
            //定义预览名称,设置裁剪图片保存的名称
            $pre_filename = public_path() . "/" . 'uploads' . "/" . "preview" . "/" . $filename;
            if (!is_dir(dirname($pre_filename))) {
                mk_dir(dirname($pre_filename), 0777);
            }
            try {
                //缩略图
                $image = \Intervention\Image\Facades\Image::make(public_path() . "/" . 'uploads' . "/" . $filename);
                if ($preview_w && $preview_h) {
                    $image->height($preview_h);
                    $image->width($preview_w);
                } else if ($preview_w) {
                    $image->widen($preview_w);
                } else if ($preview_h) {
                    $image->heighten($preview_h);
                }
                if ($preview_watermark) {
                    if ($watermark_type == "img") {
                        $image->insert(GetUrlByPath(__E("watermark_img")), __E("watermark_position"), 10, 10);
                    } else if ($watermark_type == "text") {
                        $image->text($watermark_text, 20, 20, function ($font) {
                            $font->file(public_path() . '/xkb.ttf');
                            $font->size(__E("watermark_text_size"));
                            $font->color(__E("watermark_text_color"));
//                        $font->align('center');
                            $font->valign('top');
                            $font->angle(__E("watermark_text_angle"));
                        });
                    }
                }
                $image->save($pre_filename);

                //原图
                if ($watermark) {
                    $image2 = \Intervention\Image\Facades\Image::make(public_path() . "/" . 'uploads' . "/" . $filename);
                    if ($watermark_type == "img") {
                        $image2->insert(GetUrlByPath(__E("watermark_img")), __E("watermark_position"), 10, 10);
                    } else if ($watermark_type == "text") {
                        $image2->text($watermark_text, 20, 20, function ($font) {
                            $font->file(public_path() . '/xkb.ttf');
                            $font->size(__E("watermark_text_size"));
                            $font->color(__E("watermark_text_color"));
//                        $font->align('center');
                            $font->valign('top');
                            $font->angle(__E("watermark_text_angle"));
                        });
                    }
                    $image2->save(public_path() . "/" . 'uploads' . "/" . $filename);
                }

            } catch (Exception $exception) {
                throw new \Exception($exception->getMessage());
            }
        }

        //添加到附件表
        if ($addAttachment) {
            addAttachment($filename, $drive);
            if ($pre_filename) {
                addAttachment("preview" . "/" . $filename, $drive);
            }
        }

        return $filename;
    }
}


//添加附件表
function addAttachment($filename, $drive) {

    $arr["path"] = $filename;
    $arr["drive"] = $drive;

    $Attachment = new \App\Models\Attachments();

    return $Attachment->InsertArr($arr);


}

//删除附件
function delAttachment($filename) {

    $arr["path"] = $filename;

    $Attachment = new \App\Models\Attachments();

    return $Attachment->deleteByPathMD5($arr);

}

//获取本地存储的文件
function GetLocalFileByPath($path) {
    return asset('uploads') . '/' . $path;
}

//获取驱动的URL
function GetUrlByPath($path) {
    if (!$path) return $path;
    if (strpos($path, 'http') !== false) return $path;
    $data = \App\Models\Attachments::getByPath($path);
    if ($data) {
        switch ($data["drive"]) {
            case "local":
                return GetLocalFileByPath($path);
                break;
            default :
                //触发上传驱动事件
                $drive = event(new \App\Events\UploadDriver(null, '', $data["path"], '', $data["drive"], "get"));
                return !empty($drive) ? $drive[0] : $path;
                break;
        }
    } else {
        return $path;
    }
}

//参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
function curl_request($url, $post = '', $cookie = '', $returnCookie = 0, $json = false, $header = array()) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 0);
    //curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
    if ($post && !$json) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    if ($json) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge(array(
                'Content-Type: application/json; charset=utf-8',
                //伪造IP
                //'CLIENT-IP:85.25.105.77','X-FORWARDED-FOR:85.25.105.77',//此处可以改为任意假IP
                'Content-Length: ' . strlen($post)
            ), $header)
        );
    }

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    if ($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    }
    curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    //不输出头信息
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    if (curl_errno($curl)) {
        //return false;
        throw new Exception("Error:" . curl_error($curl));
    }
    curl_close($curl);
    if ($returnCookie) {
        list($header, $body) = explode("\r\n\r\n", $data, 2);
        preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
        $info['cookie'] = substr($matches[1][0], 1);
        $info['content'] = $body;
        return $info;
    } else {
        return $data;
    }
}

//过滤值为空的数组
function filterEmptyArr($array) {

    if (!is_array($array)) return false;

    $return_arr = array();
    foreach ($array as $k => $v) {
        if (is_array($v)) {

            foreach ($v as $k1 => $v1) {
                if ($v1) {
                    $return_arr[$k] = $v;
                }
            }

        } else if ($v) {
            $return_arr[$k] = $v;
        }


    }

    return $return_arr;
}

//验证数组是否为空,除了指定的key
function CheckArrIsEmpty($arr, $except = []) {
    if (!is_array($arr)) return false;
    foreach ($arr as $k => $value) {
        if (is_array($value)) {
            CheckArrIsEmpty($value);
        } else if (!$value && $value != 0) {
            if (!in_array($k, $except)) {
                throw  new  Exception($k . " is empty.", 40000);
            }
        }
    }
}

/**
 * 获取客户端浏览器信息
 * @param null
 * @return  string
 * @author  huang
 */
function get_broswer() {
    $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
    if (stripos($sys, "Firefox/") > 0) {
        preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
        $exp[0] = "Firefox";
        $exp[1] = $b[1];    //获取火狐浏览器的版本号
    } elseif (stripos($sys, "Maxthon") > 0) {
        preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
        $exp[0] = "傲游";
        $exp[1] = $aoyou[1];
    } elseif (stripos($sys, "MSIE") > 0) {
        preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
        $exp[0] = "IE";
        $exp[1] = $ie[1];  //获取IE的版本号
    } elseif (stripos($sys, "OPR") > 0) {
        preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
        $exp[0] = "Opera";
        $exp[1] = $opera[1];
    } elseif (stripos($sys, "Edge") > 0) {
        //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
        preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
        $exp[0] = "Edge";
        $exp[1] = $Edge[1];
    } elseif (stripos($sys, "Chrome") > 0) {
        preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
        $exp[0] = "Chrome";
        $exp[1] = $google[1];  //获取google chrome的版本号
    } elseif (stripos($sys, 'rv:') > 0 && stripos($sys, 'Gecko') > 0) {
        preg_match("/rv:([\d\.]+)/", $sys, $IE);
        $exp[0] = "IE";
        $exp[1] = $IE[1];
    } else {
        $exp[0] = "未知浏览器";
        $exp[1] = "";
    }
    return $exp[0] . '(' . $exp[1] . ')';
}

/**
 * 获取客户端操作系统信息,包括win10
 * @param null
 * @return  string
 * @author  huang
 */
function get_os() {

    $agent = $_SERVER['HTTP_USER_AGENT'];
    $os = false;

    if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
        $os = 'Windows 95';
    } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
        $os = 'Windows ME';
    } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
        $os = 'Windows 98';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
        $os = 'Windows Vista';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
        $os = 'Windows 7';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
        $os = 'Windows 8';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
        $os = 'Windows 10';#添加win10判断
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
        $os = 'Windows XP';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
        $os = 'Windows 2000';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
        $os = 'Windows NT';
    } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
        $os = 'Windows 32';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'SunOS';
    } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'IBM OS/2';
    } else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)) {
        $os = 'Macintosh';
    } else if (preg_match('/PowerPC/i', $agent)) {
        $os = 'PowerPC';
    } else if (preg_match('/AIX/i', $agent)) {
        $os = 'AIX';
    } else if (preg_match('/HPUX/i', $agent)) {
        $os = 'HPUX';
    } else if (preg_match('/NetBSD/i', $agent)) {
        $os = 'NetBSD';
    } else if (preg_match('/BSD/i', $agent)) {
        $os = 'BSD';
    } else if (preg_match('/OSF1/i', $agent)) {
        $os = 'OSF1';
    } else if (preg_match('/IRIX/i', $agent)) {
        $os = 'IRIX';
    } else if (preg_match('/FreeBSD/i', $agent)) {
        $os = 'FreeBSD';
    } else if (preg_match('/teleport/i', $agent)) {
        $os = 'teleport';
    } else if (preg_match('/flashget/i', $agent)) {
        $os = 'flashget';
    } else if (preg_match('/webzip/i', $agent)) {
        $os = 'webzip';
    } else if (preg_match('/offline/i', $agent)) {
        $os = 'offline';
    } else {
        $os = '未知操作系统';
    }
    return $os;
}

//ico 图片生成
function icoImg() {
    if (isset($_FILES['webicon']['type']) && $_FILES['webicon']['size'] > 0) {

        switch ($_FILES['webicon']['type']) {
            case "image/jpeg":
                $im = imagecreatefromjpeg($_FILES['webicon']['tmp_name']);
                break;

            case "image/png":
                $im = imagecreatefrompng($_FILES['webicon']['tmp_name']);
                break;

            case "image/gif":
                $im = imagecreatefromgif($_FILES['webicon']['tmp_name']);
                break;

            default:

                throw new Exception("File ico error", 40000);
        }


        if ($im) {
            $imginfo = getimagesize($_FILES['webicon']['tmp_name']);

            if (!is_array($imginfo)) {
                throw new Exception("File ico error", 40000);
            }

            $resize_im = @imagecreatetruecolor(48, 48);
            $size = 48;
            imagecopyresampled($resize_im, $im, 0, 0, 0, 0, $size, $size, $imginfo[0], $imginfo[1]);

            include_once base_path() . "/app/Libs/image/phpthumb.ico.php";
            $icon = new phpthumb_ico();

            $gd_image_array = array($resize_im);
            $icon_data = $icon->GD2ICOstring($gd_image_array);

            $filename = public_path() . "/uploads/website/webicon" . ".ico";

            if (file_put_contents($filename, $icon_data)) {
                return "website/webicon.ico";
            } else {
                throw new \Exception("Create file ico error", 40000);
            }


        }


    }

}

//生成树形结构数据

function listToTree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
    $tree = array();
    if (is_array($list)) {
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }

        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];

            if ($root == $parentId) {
                $tree[$data[$pk]] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][$data[$pk]] = &$list[$key];
                }
            }
        }
    }

    return $tree;
}

//读取树形数据,树形数据$data，$pid 当前菜单的父ID
function getTreeData($data, $pid = 0) {

    foreach ($data as $key => $val) {

        if ($pid == $val["id"]) {
            $select = " selected ";
        } else {
            $select = "  ";
        }

        echo "<option value='" . $val["id"] . "' " . $select . " >" . cerate_xxx($val["level"]) . $val["name"] . "</option>";

        if (isset($val["sub"])) {
            getTreeData($val["sub"], $pid);
        }

    }

}

//读取树形数据,树形数据$data，$type 前台还是后台
function getTreeDataForTable($data, $type = "home") {

    foreach ($data as $key => $val) {

        $class = '';

        if ($val["level"] == 1) {
            $class = "style='font-weight: bold;font-size: 20px;'";
        }

        $stauts = $val["stauts"] == '1' ? '启用' : '禁用';

        echo "<tr><td>" . $val["id"] . "</td>" .

            "<td " . $class . ">" . cerate_xxx($val["level"]) . $val["name"] . "</td>" .

            "<td>" . $val["path"] . "</td>" .

            "<td>" . $val["pre_icon"] . "</td>" .

            "<td>" . $val["suf_icon"] . "</td>" .

            "<td>" . $val["order"] . "</td>" .

            "<td>" . $stauts . "</td>" .


            "<td>" .
            "<a class=\"\" href=\"" . url('admin/menu/' . $type . '/edit/' . $val["id"]) . "\">编辑</a> &nbsp;&nbsp;" .
            "<a class=\"\" href=" . "#" . ">高级选项</a> &nbsp;&nbsp;" .
            "<a class=\"\" href=\"javascript:;\" onclick=\"delData(" . $val["id"] . ")\" >删除</a></td>" .
            "</tr>";

        if (isset($val["sub"])) {
            getTreeDataForTable($val["sub"], $type);
        }

    }

}

//读取树形数据,树形数据$data
function getTreeDataForAuthTable($data) {

    foreach ($data as $key => $val) {

        $class = '';

        if ($val["level"] == 1) {
            $class = "style='font-weight: bold;font-size: 20px;'";
        }

        echo "<tr><td>" . $val["id"] . "</td>" .

            "<td " . $class . ">" . cerate_xxx($val["level"]) . $val["name"] . "</td>" .

            "<td>" . $val["path"] . "</td>" .

            "<td>" . $val["permissions"] . "</td>" .

            "<td>" .
            "<a class=\"\" href=\"" . url('admin/menu/auth/edit/' . $val["id"]) . "\">编辑</a> &nbsp;&nbsp;" .
            "<a class=\"\" href=\"javascript:;\" onclick=\"delData(" . $val["id"] . ")\" >删除</a></td>" .
            "</tr>";

        if (isset($val["sub"])) {
            getTreeDataForAuthTable($val["sub"]);
        }

    }

}

//创建下级标示
function cerate_xxx($index) {

    $str = "";

    if ($index != 1) {

        for ($i = 2; $i < $index; $i++) {
            $str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        $str .= "|—";

    }


    return $str;

}

//缓存菜单
function getMenuData() {

    if (Cache::has('menus')) {
        //return Cache::get('menus');
    }

    $home_menu = \App\Models\Menu::getAll("home");

    $menu["home"] = listToTree($home_menu, "id", "pid", "sub", '0');

    $admin_menu = \App\Models\Menu::getAll("admin");

    $menu["admin"] = listToTree($admin_menu, "id", "pid", "sub", '0');

    Cache::put('menus', $menu, 5);

    return Cache::get('menus');
}

//读取后台admin菜单
function getAdminMenus($menus) {

    foreach ($menus["admin"] as $val) {
        $icon = $val["pre_icon"] ? "<i class='" . $val["pre_icon"] . "'></i>" : "";

        echo "<li><a href='" . url($val["path"]) . "'> " . $icon . $val["name"] . "</a>";

        getSubAdminMenus($val);

        echo "</li>";
    }
}

//读取二级菜单
function getSubAdminMenus($val) {
    if (isset($val["sub"])) {
        echo "<ul>";
        foreach ($val["sub"] as $val1) {
            $icon = $val1["pre_icon"] ? "<i class='" . $val1["pre_icon"] . "'></i>" : "";
            echo "<li><a href='" . url($val1["path"]) . "'>" . $icon . $val1["name"] . "</a>";
            if (isset($val1["sub"])) {
                getSubAdminMenus($val1);
            }
            echo "</li>";
        }
        echo "</ul>";
    }
}

//获取本地翻译语言
function getTranslateByKey($key) {
    //echo (__("admin.zh.index_allow_curl"));
    echo __(session("admin_current_language")["shortcode"] . "." . $key);
}

function getHomeByKey($key) {
    echo __(session("home_current_language")["shortcode"] . "." . $key);
}

//获取上一页的URL
function getPreUrl() {
    return url()->previous();
}

function excelTime($date, $time = false) {
    if (function_exists('GregorianToJD')) {
        if (is_numeric($date)) {
            $jd = GregorianToJD(1, 1, 1970);
            $gregorian = JDToGregorian($jd + intval($date) - 25569);
            $date = explode('/', $gregorian);
            $date_str = str_pad($date [2], 4, '0', STR_PAD_LEFT)
                . "-" . str_pad($date [0], 2, '0', STR_PAD_LEFT)
                . "-" . str_pad($date [1], 2, '0', STR_PAD_LEFT)
                . ($time ? " 00:00:00" : '');
            return $date_str;
        }
    } else {
        $date = $date > 25568 ? $date + 1 : 25569;
        /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
        $ofs = (70 * 365 + 17 + 2) * 86400;
        $date = date("Y-m-d", ($date * 86400) - $ofs) . ($time ? " 00:00:00" : '');
    }
    return $date;
}

//是否为手机号码
if (!function_exists('is_mobile')) {
    function is_mobile(string $text) {
        $search = '/^0?1[3|4|5|6|7|8][0-9]\d{8}$/';
        if (preg_match($search, $text)) return true;
        else return false;
    }
}

//手机号码 中间4位加密
if (!function_exists('get_encryption_mobile')) {
    function get_encryption_mobile($tel) {
        $new_tel = preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2', $tel);
        return $new_tel;
    }
}

//随机验证码
if (!function_exists('random_verification_code')) {
    function random_verification_code($length = 6) {
        $code = '';
        for ($i = 0; $i < $length; $i++) $code .= mt_rand(0, 9);
        return $code;
    }
}

//API统一的数据返回格式
if (!function_exists('return_api_format')) {
    function return_api_format($return = []) {
        $return['data'] = !isset($return['data']) ? [] : $return['data'];
        $return['msg'] = !isset($return['msg']) ? '获取成功' : $return['msg'];
        $return['status'] = !isset($return['status']) ? (empty($return['data']) ? 40000 : 200) : $return['status'];
        return response()->json($return);
    }
}

if (!function_exists('member_encryption_mode')) {
    function member_encryption_mode($password) {
        return md5("union_" . md5($password));
    }
}

if (!function_exists('get_dir_files')) {
    // 列出指定目录下所有目录和文件
    function get_dir_files($dir) {
        $arr = [];
        if (is_dir($dir)) {//如果是目录，则进行下一步操作
            $d = opendir($dir);//打开目录
            if ($d) {//目录打开正常
                while (($file = readdir($d)) !== false) {//循环读出目录下的文件，直到读不到为止
                    if ($file != '.' && $file != '..') {//排除一个点和两个点
                        if (is_dir($file)) {//如果当前是目录
                            $arr[$file] = get_dir_files($file);//进一步获取该目录里的文件
                        } else {
                            $arr[] = $file;//记录文件名
                        }
                    }
                }
            }
            closedir($d);//关闭句柄
        }
        return $arr;
    }
}

if (!function_exists('get_file_filtering')) {
    /**
     * 获取指定格式的文件
     * @param array $array
     * @param array $format
     * @return array
     */
    function get_file_filtering($array = [], $format = []) {
        $return = [];
        if (empty($array) || empty($format)) return $return;
        foreach ($array as $key => $value) {
            $arr = pathinfo($value);
            if (!empty($arr['extension']) && in_array($arr['extension'], $format)) $return[] = $value;
        }
        return $return;
    }
}

if (!function_exists('write_lock_file')) {
    /**
     * 写入锁文件
     * @param $path
     */
    function write_lock_file($path, $content = '', $file_name = 'lock') {
        $lock_file = fopen($path . '/' . $file_name, 'w+');//创建 锁文件
        fwrite($lock_file, empty($content) ? date('Y-m-d H:i:s') : $content);//写入
    }
}

if (!function_exists('del_dir_files')) {
    /**
     * 删除文件夹与下方的所有文件
     * @param $dirName 文件夹名称
     * @param int $delete_dir 是否删除文件夹【1.删除；0.不删除】
     */
    function del_dir_files($dirName, $delete_dir = 1) {
//        if ($handle = @opendir($dirName)) {
//            while (false !== ($item = @readdir($handle))) {
//                if ($item != '.' && $item != '..') {
//                    if (is_dir($dirName . '/' . $item)) del_dir_files($dirName . '/' . $item);
//                    else @unlink($dirName . '/' . $item);
//                }
//            }
//            @closedir($handle);
//        }
//        if ($delete_dir == 1) @rmdir($dirName);
    }
}

if (!function_exists('get_module_name')) {
    /**
     * 通过 模块的JSON文件，获得模块的名称
     * @param string $path
     * @return mixed
     */
    function get_module_name($path = '') {
        $cloud_modules = json_decode(file_get_contents($path . '/config.json'), true);
        return empty($cloud_modules['identification']) ? '' : $cloud_modules['identification'];
    }
}

if (!function_exists('get_client_info')) {
    /**
     * 获取IP与浏览器信息、语言
     */
    function get_client_info(): array {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $XFF = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $client_pos = strpos($XFF, ', ');
            $client_ip = false !== $client_pos ? substr($XFF, 0, $client_pos) : $XFF;
            unset($XFF, $client_pos);
        } else $client_ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? $_SERVER['LOCAL_ADDR'] ?? '0.0.0.0';
        $client_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) : '';
        $client_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return ['ip' => &$client_ip, 'lang' => &$client_lang, 'agent' => &$client_agent];
    }
}

if (!function_exists('get_ip')) {
    function get_ip(): string {
        $data = get_client_info();
        return empty($data['ip']) ? '' : $data['ip'];
    }
}

if (!function_exists('get_month_days')) {
    /**
     * 获取某月份的所有日期列表
     * @param string $time
     * @param string $format
     * @return array
     */
    function get_month_days($time = '', $format = 'Y-m-d') {
        $time = $time != '' ? $time : time();
        //获取当前周几
        $week = date('d', $time);
        $date = [];
        for ($i = 1; $i <= date('t', $time); $i++) {
            $date[$i] = date($format, strtotime('+' . $i - $week . ' days', $time));
        }
        return $date;
    }
}

if (!function_exists('set_month_format')) {
    /**
     * 设置 月份 的格式统一
     * @param $month
     * @return string
     */
    function set_month_format($month) {
        return (string)(strlen($month) == 1 ? '0' . $month : $month);
    }
}

if (!function_exists('get_mail_template_message')) {
    /**
     * 获取模板消息内容
     * @param $content
     * @param string $change 也可以是数组
     * @param string $code 对应数组
     * @return mixed
     */
    function get_mail_template_message($content, $change = '', $code = '{$code}') {
        return str_replace($code, $change, $content);
    }
}

/**
 * 获取当前host域名
 * @return string
 */
function get_host() {
    $scheme = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $url = $scheme . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . '/';
    return $url;
}

if (!function_exists('put_file_to_zip')) {
    /**
     * 把指定文件目录下的所有文件，打包压缩至压缩包内
     * @param $path
     * @param $zip
     * @param $old_filename
     * @param $limit_dir 限制压缩的文件目录
     */
    function put_file_to_zip($path, $zip, $old_filename, $limit_dir = []) {
        $handler = opendir($path); //打开当前文件夹由$path指定。
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归
                    if (!empty($limit_dir) && !in_array($filename, $limit_dir)) continue;
                    $old_filename = (empty($old_filename) ? '' : ($old_filename . '/'));
                    $zip->addEmptyDir($old_filename . $filename);
                    put_file_to_zip($path . "/" . $filename, $zip, $old_filename . $filename);
                } else { //将文件加入zip对象
                    $zip->addFile($path . "/" . $filename, (empty($old_filename) ? '' : ($old_filename . '/')) . $filename);
                }
            }
        }
        @closedir($path);
    }
}

if (!function_exists('get_dir_size')) {
    /**
     * 获取指定文件夹的大小
     * @param $path
     * @param int $fileseze
     * @param array $limit_dir
     * @return int
     */
    function get_dir_size($path, $fileseze = 0, $limit_dir = []) {
        header("content-type:text/html;charset=utf-8");
        $handler = opendir($path); //打开当前文件夹由$path指定。
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归
                    if (!empty($limit_dir) && !in_array($filename, $limit_dir)) continue;
                    $fileseze = get_dir_size($path . "/" . $filename, $fileseze);
                } else $fileseze += filesize($path . "/" . $filename);//文件大小
            }
        }
        @closedir($path);
        return $fileseze;
    }
}

if (!function_exists('check_http_file_exists')) {
    //判断远程文件是否存在
    function check_http_file_exists($url) {
        $curl = curl_init($url);
        // 不取回数据
        curl_setopt($curl, CURLOPT_NOBODY, true);
        // 发送请求
        $result = curl_exec($curl);
        $found = false;
        // 如果请求没有发送失败
        if ($result !== false) {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) $found = true;
        }
        curl_close($curl);
        return $found;
    }
}

function get_tree_list(array $array, int $id = 0, int $level = 0, string $parent_id = 'pid') {
    $list = array();
    foreach ($array as $k => $v) {
        if ($v[$parent_id] == $id) {
            $v['level'] = $level;
            $v['_child'] = get_tree_list($array, $v['id'], $level + 1);
            $list[] = $v;
        }
    }
    return $list;
}

if (!function_exists('auto_incluede_directory_files')) {
    /**
     * 自动引入指定文件夹下方所有的文件
     * @param $path
     */
    function auto_incluede_directory_files(string $path) {
        $handler = opendir($path); //打开当前文件夹由$path指定。
        while (($filename = readdir($handler)) !== false) {
            if ($filename != '.' && $filename != '..') {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                // 如果读取的某个对象是文件夹，则递归
                if (is_dir($dir_path = $path . '/' . $filename)) auto_incluede_directory_files($dir_path);
                else if (is_file($file_path = $path . '/' . $filename)) include_once $file_path;
            }
        }
        @closedir($path);
    }
}

if (!function_exists('get_uuid')) {
    function get_uuid(string $string = ''): string {
        $string = '' === $string ? uniqid(mt_rand(), true) : (0 === (int)preg_match('/[A-Z]/', $string) ? $string : mb_strtolower($string, 'UTF-8'));
        $code = hash('sha1', $string . ':UUID');
        $uuid = substr($code, 0, 10);
        $uuid .= substr($code, 10, 4);
        $uuid .= substr($code, 16, 4);
        $uuid .= substr($code, 22, 4);
        $uuid .= substr($code, 28, 12);
        $uuid = strtoupper($uuid);
        unset($string, $code);
        return $uuid;
    }
}

if (!function_exists('set_seo_config')) {
    /**
     * SEO配置渲染
     * @param int $page_type
     * @param array $data seo_title 优先使用的seo，title 默认的title
     */
    function set_seo_config($page_type = -1, $data = []) {
        $seo_config = [
            'seo_title' => '',
            'seo_keywords' => '',
            'seo_description' => '',
        ];

        switch ($page_type) {
            case "faq":
            case "faq_list":
            case "case":
            case "case_list":
            case "news":
            case "news_list":
            case "joins":
            case "joins_list":
            case "product":
            case "product_list":
            case "module":
            case "page":

                if (!is_array($data)) $data = $data->toArray();
                if (!isset($data["title"])) {
                    if (isset($data["name"])) {
                        $data["title"] = $data["name"];
                    }
                }
                //自动替换对应的seo title
                $seo_config['seo_title'] = str_replace("{title}", isset($data["title"]) ? $data["title"] : "", __E("seo_" . $page_type . "_title"));

                if (isset($data["seo_keywords"])) {
                    $seo_config['seo_keywords'] = $data["seo_keywords"];//优先自定义seo keywords
                } else {
                    //自动替换对应的seo keywords
                    $seo_config['seo_keywords'] = str_replace("{keywords}", isset($data["keywords"]) ? $data["keywords"] : "", __E("seo_" . $page_type . "_keywords"));
                }

                if (isset($data["seo_description"])) {
                    $seo_config['seo_description'] = $data["seo_description"];//优先自定义seo keywords
                } else {
                    //自动替换对应的seo keywords
                    $seo_config['seo_description'] = str_replace("{description}", isset($data["description"]) ? $data["description"] : "", __E("seo_" . $page_type . "_description"));
                }

                break;
            default://首页

                $seo_config['seo_title'] = __E('website_name');

                $seo_config['seo_keywords'] = __E('website_keys');

                $seo_config['seo_description'] = __E('website_desc');
                break;
        }

        //默认拿全局
        if (!$seo_config['seo_title']) {
            $seo_config['seo_title'] = __E("seo_all_title");
        }

        if (!$seo_config['seo_keywords']) {
            $seo_config['seo_keywords'] = __E("seo_all_keywords");
        }

        if (!$seo_config['seo_description']) {
            $seo_config['seo_description'] = __E("seo_all_description");
        }

        view()->share([
            'seo_title' => $seo_config['seo_title'],
            'seo_keywords' => $seo_config['seo_keywords'],
            'seo_description' => $seo_config['seo_description'],
        ]);
    }
}


/**
 * 切分SQL文件成多个可以单独执行的sql语句
 * @param        $file            string sql文件路径
 * @param        $tablePre        string 表前缀
 * @param string $charset 字符集
 * @param string $defaultTablePre 默认表前缀
 * @param string $defaultCharset 默认字符集
 * @return array
 */
function get_split_sql($file, $tablePre, $charset = 'utf8mb4', $defaultTablePre = '', $defaultCharset = 'utf8mb4') {
    if (file_exists($file)) {
        //读取SQL文件
        $sql = file_get_contents($file);
        $sql = str_replace("\r", "\n", $sql);
        $sql = str_replace("BEGIN;\n", '', $sql);//兼容 navicat 导出的 insert 语句
        $sql = str_replace("COMMIT;\n", '', $sql);//兼容 navicat 导出的 insert 语句
        $sql = str_replace("↵↵", '', $sql);//兼容 navicat 导出的 insert 语句
        $sql = str_replace("\n  ", '', $sql);//兼容 navicat 导出的 insert 语句
        // $sql = str_replace(" ", '', $sql);//兼容 navicat 导出的 insert 语句
        if ($defaultCharset == $charset) {
            $sql = str_replace($defaultCharset, $charset, $sql);
        }
        $sql = trim($sql);
        //替换表前缀
        $sql = str_replace(" `{$defaultTablePre}", " `{$tablePre}", $sql);
        // $sqls = explode("-- ----------------------------", $sql);
        $sqls = explode(";\n", $sql);
        return $sqls;
    }
    return [];
}

function is_install() {
    return App\Http\Controllers\Install\InstallController::checkInstall();
}

//获取系统信息
function w_getSysInfo() {
    global $env;
    $sysEnv = [];
    // Get content of phpinfo
    ob_start();
    phpinfo();
    $sysInfo = ob_get_contents();
    ob_end_clean();
    // Explode phpinfo content
    if ($env['php']['run_mode'] == 'cli') {
        $sysInfoList = explode('\n', $sysInfo);
    } else {
        $sysInfoList = explode('</tr>', $sysInfo);
    }
    foreach ($sysInfoList as $sysInfoItem) {
        if (preg_match('/thread safety/i', $sysInfoItem)) {
            $sysEnv['thread_safety'] = (preg_match('/(enabled|yes)/i', $sysInfoItem) != 0);
        }
        if (preg_match('/swoole_loader support/i', $sysInfoItem)) {
            $sysEnv['swoole_loader'] = (preg_match('/(enabled|yes)/i', $sysInfoItem) != 0);
        }
        if (preg_match('/swoole_loader version/i', $sysInfoItem)) {
            preg_match('/\d+.\d+.\d+/s', $sysInfoItem, $match);
            $sysEnv['swoole_loader_version'] = isset($match[0]) ? $match[0] : false;
        }
    }
    //var_dump($sysEnv);die();
    return $sysEnv;
}


//生成邀请码函数
// 注意这里生成的邀请码 不会超过 13位数 超过13 位函数递归
//后期业务量大可以重新改进
//参数id 为数据库自增id
//by andy update 2019-12-16
//数据库自增id 大于100 万请重新改进和使用其他方法
function createOnlyId($id) {

    //打乱字符串种子
    $code = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZksdjfksdjwieujqoznnqweurjajdjskjdkfjdsfkslcxvio');

    $rand = $code[rand(0, 25)]
        . strtoupper(dechex(date('m')))
        . date('d')
        . substr(time(), -5)
        . substr(microtime(), 2, 5)
        . sprintf('%02d', rand(0, 99));
    for (
        $a = md5($rand, true),
        $s = str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZaloqweoernxzmvnxmvmxcskafhksddqellmkjajdffd'),
        $d = '',
        $f = 0;
        $f < 4;
        $g = ord($a[$f]),
        $d .= $s[($g ^ ord($a[$f + 8])) - $g & 0x1F],
        $f++
    ) ;

    //将id 放入数组 这样可以放头部跟尾部，不一样
    $arr = [0 => rand(0, 10), 1 => $id, 2 => date('s'), 3 => date('i')];

    //将id 唯一值 $arr[1] 加入进去
    $re_str = $arr[rand(0, 3)] . $d . $arr[1];
    //位数大于13 重新生成 函数递归
    if (strlen($re_str) > 13) {
        return createOnlyId($id);
    } else {
        return $re_str;
    }

}

//判断是否是微信浏览器
function is_weixin() {

    if (strpos($_SERVER['HTTP_USER_AGENT'],
            'MicroMessenger') !== false) {
        return true;
    }
    return false;

}

/**
 * 判断是否支付宝内置浏览器访问
 * @return bool
 */
function isAliClient() {
    return strpos($_SERVER['HTTP_USER_AGENT'], 'Alipay') !== false;
}

/**
 * 是否移动端访问访问
 *
 * @return bool
 */
function isMobileClient() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }

//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }

//判断手机发送的客户端标志
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = [
            'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp',
            'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu',
            'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi',
            'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile', 'alipay'
        ];

// 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }

//协议法，因为有可能不准确，放到最后判断
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }

    return false;
}

// 循环创建目录
function mk_dir($dir, $mode = 0755) {
    if (is_dir($dir) || @mkdir($dir, $mode)) return true;
    if (!mk_dir(dirname($dir), $mode)) return false;
    return @mkdir($dir, $mode);
}

//解压zip文件
function get_zip_originalsize($filename, $path) {
    //先判断待解压的文件是否存在
    if (!file_exists($filename)) {
        throw new \Exception("文件 $filename 不存在！");
    }
    //将文件名和路径转成windows系统默认的gb2312编码，否则将会读取不到
    $filename = iconv("utf-8", "gb2312", $filename);
    $path = iconv("utf-8", "gb2312", $path) . "/";
    //打开压缩包
    $resource = zip_open($filename);
    $i = 1;
    //遍历读取压缩包里面的一个个文件
    while ($dir_resource = zip_read($resource)) {
        //如果能打开则继续
        if (zip_entry_open($resource, $dir_resource)) {
            //获取当前项目的名称,即压缩包里面当前对应的文件名
            $file_name = $path . zip_entry_name($dir_resource);
            //以最后一个“/”分割,再用字符串截取出路径部分
            $file_path = substr($file_name, 0, strrpos($file_name, "/"));
            //如果路径不存在，则创建一个目录，true表示可以创建多级目录
            if (!is_dir($file_path)) {
                mkdir($file_path, 0777, true);
            }
            //如果不是目录，则写入文件
            if (!is_dir($file_name)) {
                //读取这个文件
                $file_size = zip_entry_filesize($dir_resource);
                //最大读取6M，如果文件过大，跳过解压，继续下一个
                if ($file_size < (1024 * 1024 * 60)) {
                    $file_content = zip_entry_read($dir_resource, $file_size);
                    file_put_contents($file_name, $file_content);
                } else {
                    throw new \Exception($i++ . "此文件已被跳过，原因：文件过大" . iconv("gb2312", "utf-8", $file_name));
                }
            }
            //关闭当前
            zip_entry_close($dir_resource);
        }
    }
    //关闭压缩包
    zip_close($resource);
}

//请求类型
function getReqType() {
    return [
        'app' => 'APP端',
        'small' => '小程序',
        'public' => '公众号',
        'pc' => 'PC端',
    ];
}


function getDisplayPosition() {
    return [
        [
            'left-top' => '左上',
            'top' => '上',
            'right-top' => '右上',
        ],
        [
            'left-center' => '左中',
            'center' => '中',
            'right-center' => '右中',
        ],
        [
            'left-bottom' => '左下',
            'bottom' => '下',
            'right-bottom' => '右下',
        ]
    ];
}

function getDisplayPositionMsg($tig) {
    $info = getDisplayPosition();
    return $info[0][$tig] ?: ($info[1][$tig] ?: $info[2][$tig]);
}

function getFileType($url) {
    $one = explode('?', $url);
    $two = explode('.', $one[0]);
    $fix = strtolower($two[count($two) - 1]);
    if (in_array($fix, ['mp4', 'avi', ''])) {
        return '视频';
    } elseif (in_array($fix, ['png', 'jpeg', 'jpg', 'gif'])) {
        return '图片';
    } else {
        return '其他';
    }

}

//条数
function limit() {
    $len = intval($_REQUEST['pagesize']);
    $page = intval($_REQUEST['page']);
    if ($len <= 0) $len = 10;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $len;
    //偏移量，条数
    return [
        0 => $offset,
        1 => $len,
        'skip' => $offset,
        'take' => $len,
    ];
}