<?php

namespace App\Http\Controllers\Plugin\qiniu\Controllers;

use App\Http\Controllers\Controller;
use App\Utils\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InitController extends Controller
{

    //构造函数
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }


    //处理函数
    static function upload($event){

        $disk = Storage::disk("qiniu");
        //先上传到服务器
        $filename = _upload($event->request,$event->field,$event->filename,$event->allowExt,"local",false);

        if(!$disk->exists($filename)){

            try{
                $disk->put($filename,file_get_contents(public_path("uploads/").$filename));
            }catch (Exception $exception){

            }

            unlink(public_path("uploads/").$filename);

            //添加到附件表
            addAttachment($filename,"qiniu");


        };

        return $filename;

    }

    static function get($event){
        $disk = Storage::disk("qiniu");

        if($disk->exists($event->filename)){

            //$info = ;    //($event->filename);
            return "http://".config("filesystems.disks.qiniu.domains.default")."/".$event->filename;

            ;

        };



    }



}



/**

$disk = \Storage::disk('qiniu');
$disk->exists('file.jpg');                      //文件是否存在
$disk->get('file.jpg');                         //获取文件内容
$disk->put('file.jpg',$contents);               //上传文件
$disk->prepend('file.log', 'Prepended Text');   //附加内容到文件开头
$disk->append('file.log', 'Appended Text');     //附加内容到文件结尾
$disk->delete('file.jpg');                      //删除文件
$disk->delete(['file1.jpg', 'file2.jpg']);
$disk->copy('old/file1.jpg', 'new/file1.jpg');  //复制文件到新的路径
$disk->move('old/file1.jpg', 'new/file1.jpg');  //移动文件到新的路径
$size = $disk->size('file1.jpg');               //取得文件大小
$time = $disk->lastModified('file1.jpg');       //取得最近修改时间 (UNIX)
$files = $disk->files($directory);              //取得目录下所有文件
$files = $disk->allFiles($directory);               //这个没实现。。。
$directories = $disk->directories($directory);      //这个也没实现。。。
$directories = $disk->allDirectories($directory);   //这个也没实现。。。
$disk->makeDirectory($directory);               //这个其实没有任何作用
$disk->deleteDirectory($directory);             //删除目录，包括目录下所有子文件子目录

$disk->getDriver()->uploadToken('file.jpg');                //获取上传Token
$disk->getDriver()->downloadUrl('file.jpg');                //获取下载地址
$disk->getDriver()->downloadUrl('file.jpg', 'https');       //获取HTTPS下载地址
$disk->getDriver()->privateDownloadUrl('file.jpg');         //获取私有bucket下载地址
$disk->getDriver()->privateDownloadUrl('file.jpg', 'https');//获取私有bucket的HTTPS下载地址
$disk->getDriver()->imageInfo('file.jpg');                  //获取图片信息
$disk->getDriver()->imageExif('file.jpg');                  //获取图片EXIF信息
$disk->getDriver()->imagePreviewUrl('file.jpg','imageView2/0/w/100/h/200');                         //获取图片预览URL
$disk->getDriver()->persistentFop('file.flv','avthumb/m3u8/segtime/40/vcodec/libx264/s/320x240');   //执行持久化数据处理
$disk->getDriver()->persistentFop('file.flv','fop','队列名');   //使用私有队列执行持久化数据处理
$disk->getDriver()->persistentStatus($persistent_fop_id);       //查看持久化数据处理的状态。


 **/