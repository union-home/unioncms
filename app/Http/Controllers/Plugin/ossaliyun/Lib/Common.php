<?php
namespace App\Http\Controllers\Plugin\ossaliyun\Lib;
require_once __DIR__ . '/autoload.php';

use OSS\OssClient;
use OSS\Core\OssException;

/**
 * Class Common
 *
 * The Common class for 【Samples/*.php】 used to obtain OssClient instance and other common functions
 */
class Common {
    public $endpoint = '';
    public $accessKeyId = '';
    public $accessKeySecret = '';
    public $bucket = '';

    public function __construct() {
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
        $this->endpoint = $config['ossaliyun_domain'];
        $this->accessKeyId = $config['ossaliyun_access_key'];
        $this->accessKeySecret = $config['ossaliyun_secret_key'];
        $this->bucket = $config['ossaliyun_bucket'];
    }

    /**
     * Get an OSSClient instance according to config.
     *
     * @return OssClient An OssClient instance
     */
    public function getOssClient() {
        try {
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint, false);
        } catch (OssException $e) {
            printf(__FUNCTION__ . "creating OssClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        return $ossClient;
    }

    public function getBucketName() {
        return $this->bucket;
    }

    /**
     * A tool function which creates a bucket and exists the process if there are exceptions
     */
    public function createBucket() {
        $ossClient = $this->getOssClient();
        if (is_null($ossClient)) exit(1);
        $bucket = $this->getBucketName();
        $acl = OssClient::OSS_ACL_TYPE_PUBLIC_READ;
        try {
            $ossClient->createBucket($bucket, $acl);
        } catch (OssException $e) {

            $message = $e->getMessage();
            if (\OSS\Core\OssUtil::startsWith($message, 'http status: 403')) {
                echo "Please Check your AccessKeyId and AccessKeySecret" . "\n";
                exit(0);
            } elseif (strpos($message, "BucketAlreadyExists") !== false) {
                echo "Bucket already exists. Please check whether the bucket belongs to you, or it was visited with correct endpoint. " . "\n";
                exit(0);
            }
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        print(__FUNCTION__ . ": OK" . "\n");
    }

    public static function println($message) {
        if (!empty($message)) {
            echo strval($message) . "\n";
        }
    }
}

# Common::createBucket();
