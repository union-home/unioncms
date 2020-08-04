<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],*/


    ];

    /**
     * 要注册的订阅者类.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\UnionCloudAPI',
        "App\Listeners\AdminLogin",
        "App\Listeners\LanguageUpdate",
        "App\Listeners\Plugin",

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
