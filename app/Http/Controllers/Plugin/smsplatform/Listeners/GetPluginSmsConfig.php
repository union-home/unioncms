<?php

namespace App\Http\Controllers\Plugin\smsplatform\Listeners;

use App\Interfaces\ListenterPlugins;

class GetPluginSmsConfig implements ListenterPlugins
{
	//官网/文档链接
	public static $url = '';

	//变更的字段
	public static $change_field = [
		[
			'name' => '账户',
			'value' => 'account',
		],
		[
			'name' => '密码',
			'value' => 'pswd',
		],
	];

    /**
     * 事件.
     */
    public function callBack($event) {
        $config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
        $config['url'] = self::$url;
        $config['change_field'] = self::$change_field;
        return $config;
    }
}