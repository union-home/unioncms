<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //读取模块的定时任务
        //获取已安装启用的module

        if (is_install()) {
            $modules = new \App\Models\Modules();
            $modules_install_datas = $modules->where('status', 1)
                ->where('cloud_type', 0)
                ->orderBy("created_at", "desc")
                ->get();

            //加载模块的路由
            foreach ($modules_install_datas as $modules_install_data) {
                //判断类库是否存在
                $class_name = 'App\Http\Controllers\Module\\' . $modules_install_data->identification . '\Console\Kernel';
                if (class_exists($class_name)) {
                    $ke = new $class_name;
                    $ke->schedule($schedule);
                }
//
            }
        }


        //读取CMS的
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
