<?php

namespace App\Http\Controllers\Plugin\qiniu\Listeners;

use App\Interfaces\ListenterPlugins;

class SetPluginUploadConfig implements ListenterPlugins
{
    /**
     * 事件.
     */
    public function callBack($event) {
        $config_file = dirname(__DIR__) . '/config.json';
        $config = json_decode(file_get_contents($config_file), true);
        if(empty($config)) return;
        $params = $event->params;
        foreach(GetPluginUploadConfig::$change_field as &$v) $config[trim($v['value'])] = empty($params[trim($v['value'])]) ? '' : $params[trim($v['value'])];

        file_put_contents($config_file, json_encode($config));
    }
}