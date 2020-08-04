<?php

namespace App\Listeners;

use App\Models\MembersLoginLogs;

class AdminLogin
{

    /**
     * 为订阅者注册监听器.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        //监听检查更新事件
        $events->listen(
            'App\Events\Login',
            'App\Listeners\AdminLogin@LoginDo'
        );


    }

    /**
     * 登录事件.
     */
    public function LoginDo($event) {

        //录入登录记录
        $logs = new MembersLoginLogs();

        $logs->InsertArr($event->login_info);

    }

}