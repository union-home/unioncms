<?php

namespace App\Listeners;


use App\Libs\license\license;

class Plugin
{
    /**
     * 为订阅者注册监听器.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        license::ListenersPlugin($events);
    }
}