<?php

namespace App\Http\Controllers\Plugin\ossaliyun\Listeners;

use App\Interfaces\ListenterPlugins;

class GetPluginUploadConfig implements ListenterPlugins
{
	public static $url = '';
	public static $change_field = [
		[
			'name' => '七牛域名',
			'value' => 'ossaliyun_domain',
		],
        [
            'name' => 'HTTPS域名',
            'value' => 'ossaliyun_https_domain',
        ],
        [
            'name' => '自定义域名',
            'value' => 'ossaliyun_custom_domain',
        ],
        [
            'name' => 'AccessKey',
            'value' => 'ossaliyun_access_key',
        ],
        [
            'name' => 'SecretKey',
            'value' => 'ossaliyun_secret_key',
        ],
        [
            'name' => 'Bucket名字',
            'value' => 'ossaliyun_bucket',
        ],
        [
            'name' => '持久化处理回调地址',
            'value' => 'ossaliyun_notify_url',
        ],
	];

    public function callBack($event) {
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
        $config['url'] = self::$url;
        $config['change_field'] = self::$change_field;
        return $config;
    }
}