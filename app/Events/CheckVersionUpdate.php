<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CheckVersionUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $arr['host'] = $request->server('HTTP_HOST');
        $arr["url"] = $request->server('REQUEST_URI');
        $arr["time"] = date("Y-m-d H:i:s");
        $arr["timezone"] = config("app.timezone");
        $arr['version'] = env('APP_VERSION');//新增本地的版本号
        $this->data = $arr;
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
