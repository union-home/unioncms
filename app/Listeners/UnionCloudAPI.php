<?php

namespace App\Listeners;

class UnionCloudAPI
{

    /**
     * 为订阅者注册监听器.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\CheckVersionUpdate',
            'App\Libs\license\license@CheckVersionUpdate'
        );
    }

}