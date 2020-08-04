<?php

namespace App\Http\Controllers\Plugin\qiniu\Listeners;

use App\Interfaces\ListenterPlugins;

class GetPluginUploadConfig implements ListenterPlugins
{
	public static $url = '';
	public static $change_field = [
		[
			'name' => '七牛域名',
			'value' => 'qiniu_domain',
		],
        [
            'name' => 'HTTPS域名',
            'value' => 'qiniu_https_domain',
        ],
        [
            'name' => '自定义域名',
            'value' => 'qiniu_custom_domain',
        ],
        [
            'name' => 'AccessKey',
            'value' => 'qiniu_access_key',
        ],
        [
            'name' => 'SecretKey',
            'value' => 'qiniu_secret_key',
        ],
        [
            'name' => 'Bucket名字',
            'value' => 'qiniu_bucket',
        ],
        [
            'name' => '持久化处理回调地址',
            'value' => 'qiniu_notify_url',
        ],
	];

    public function callBack($event) {
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
        $config['url'] = self::$url;
        $config['change_field'] = self::$change_field;
        return $config;
    }
}