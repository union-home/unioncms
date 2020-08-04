<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 获取插件中 Upload 上传文件 的配置文件
 * Class GetPluginUploadConfig
 * @package App\Events
 */
class GetPluginUploadConfig
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private static $url;
    private static $change_field;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request, $plugin_name = '')
    {
        $this->request = $request;
        $this->plugin_name = $plugin_name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
