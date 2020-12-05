<?php

namespace App\Http\Controllers\Plugin\ossaliyun\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Plugin\ossaliyun\Lib\Common;
use Exception;
use Illuminate\Http\Request;

class InitController extends Controller {

    //构造函数
    public function __construct(Request $request) {
        parent::__construct($request);
    }


    //处理函数
    public static function upload($event) {
        $common = new Common();
        $bucketName = $common->getBucketName();
        $ossClient = $common->getOssClient();
        //先上传到服务器
        $filename = _upload($event->request, $event->field, $event->filename, $event->allowExt, "local", false);
        if (!is_file(public_path("uploads/") . $filename)) {
            throw new Exception('本地上传失败', 40000);
        };

        try {
            $ossClient->uploadFile($bucketName, $filename, public_path("uploads/") . $filename);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 400001);
        }

        unlink(public_path("uploads/") . $filename);

        //添加到附件表
        addAttachment($filename, "ossaliyun");

        return $filename;

    }

    public static function get($event) {
        $common = new Common();
        $bucketName = $common->getBucketName();
        $ossClient = $common->getOssClient();
        try {
            $timeout = 3600;
            $options = array(
                //$ossClient::OSS_PROCESS => "image/resize,m_lfit,h_100,w_100",
            );
            return $ossClient->signUrl($bucketName, $event->filename, $timeout, "GET", $options);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 400001);
        }

    }


}