<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class Login
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request, $type = "admin_info")
    {

        $this->login_info = array(
            "uid"=>session($type)["uid"],
            "ip"=>$request->getClientIp(),
            "login_at"=> date("Y-m-d H:i:s"),                //session($type)["create_at"],
            "device_type"=>get_os(),
            "device_name"=>get_broswer(),
            "device_token"=>md5(uniqid())
        );
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
