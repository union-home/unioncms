<?php

namespace App\Http\Controllers\Plugin\unionPay\Lib;

class Log {

    public static function mkDir($path) {
        $path_arr = array_filter(explode('/', $path));
        $public = '';
        foreach ($path_arr as $p) {
            if (strstr($p, '.')) continue;
            $public .= $p . '/';
            $dir_name = public_path($public);
            if ($dir_name) {
                if (!is_dir($dir_name)) {
                    mkdir($dir_name, 0777);
                    chmod($dir_name, 0777);
                }
            }
        }
    }

    //生成文件
    public static function getFileUrl() {
        $file_url = 'logs/' . date('Y-m') . '/' . date('Y-m-d') . '/' . date('Y-m-d-H') . '.log';
        return $file_url;
    }

    public static function write($header, $arr, $path = false) {
        $path = $path == false ? self::getFileUrl() : $path;
        self::mkDir($path);
        if (!is_array($arr)) {
            file_put_contents($path, 'write time : ' . var_export(date('H:i:s'), true) . PHP_EOL, FILE_APPEND);
            file_put_contents($path, var_export($header, true) . PHP_EOL, FILE_APPEND);
            file_put_contents($path, var_export($arr, true) . PHP_EOL, FILE_APPEND);
        } else {
            foreach ($arr as $k => $a) {
                file_put_contents($path, 'write time : ' . var_export(date('H:i:s'), true) . PHP_EOL, FILE_APPEND);
                file_put_contents($path, var_export($header, true) . PHP_EOL, FILE_APPEND);
                file_put_contents($path, $k . ' => ' . var_export($a, true) . PHP_EOL, FILE_APPEND);
            }
        }

    }
}

