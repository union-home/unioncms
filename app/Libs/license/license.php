<?php

    if(!extension_loaded('swoole_loader')){
        header("Location: ".url("/swoole-compiler.php"));
    }

    /**
     * 根据开发者的开发版本，加载指定不同版本的类库
     */

    $php_version = substr(PHP_VERSION,0,3);
    $limit_versions = ['5.6', '7.0', '7.1', '7.2', '7.3'];

    if(!in_array($php_version, $limit_versions)) throw new \Exception('不支持当前版本');
    if(is_file($file = __DIR__ . '/license-' . $php_version . '.php')) include_once $file;
    else throw new \Exception('PHP版本为：' . $php_version . '，该版本类库不存在！');
    



