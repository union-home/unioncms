<?php

namespace App\Events;

use App\Models\Modules;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GetModuleSetIndex
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     *
     *
     * 获取后台设定的 指定模块 作为 默认首页
     */
    public function __construct($request)
    {
        $module_name = Modules::where('is_index', 1)->where('status', 1)->first();
        $this->module_name = $module_name;
        $this->controller = '';
        $this->view = '';
        //模块名称存在
        if ($this->module_name) {
            //查找对应模块下方的Home里的Home控制器文件是否存在
            $path = app_path("Http/Controllers/Module/". $module_name->identification ."/Home/HomeController.php");
            if (file_exists($path)) {
                //查找对应模块下方的Home里的Home控制器
                $class_filename = '\App\Http\Controllers\Module\\' . $module_name->identification . '\Home\HomeController';
                $this->controller = new $class_filename($request);
                //加载home控制器的index方法进行调用
                $this->view = call_user_func([$this->controller, 'index']);
            }
        }
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
