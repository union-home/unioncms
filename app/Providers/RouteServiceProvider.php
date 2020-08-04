<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $home_namespace = 'App\Http\Controllers\Home';
    protected $admin_namespace = 'App\Http\Controllers\Admin';
    protected $plugin_namespace = 'App\Http\Controllers\Plugin';//插件
    protected $module_namespace = 'App\Http\Controllers\Module';//模块


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        //
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->ModuleRoutes();

        $this->pluginRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() {

        //前台路由，for home
        Route::middleware(["web", "HomeLanguage", 'home.visitlog', "checkInstall"])
            ->namespace($this->home_namespace)
            ->group(base_path('routes/home.php'));

        //安装流程路由
        Route::group(["prefix" => "install", "middleware" => ["web"]], function () {
            Route::any("/", "\App\Http\Controllers\Install\InstallController@index");
            Route::any("/start", "\App\Http\Controllers\Install\InstallController@start");
            Route::any("/testDbPwd", "\App\Http\Controllers\Install\InstallController@testDbPwd");
            Route::any("/setDbConfig", "\App\Http\Controllers\Install\InstallController@setDbConfig");
            Route::any("/setSite", "\App\Http\Controllers\Install\InstallController@setSite");
        });

        //  后台路由，for admin
        Route::prefix("admin")
            ->middleware(["web", "AdminLanguage", "checkInstall"])
            ->namespace($this->admin_namespace)
            ->group(base_path('routes/admin.php'));

    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes() {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function pluginRoutes() {
//        Route::prefix("plugin")
//            ->namespace($this->plugin_namespace)
//            ->group(base_path('routes/plugin.php'));
        if (file_exists(app_path("Http/Controllers/Plugin/admin.php"))) {
            Route::prefix("plugin")
                ->middleware(["web", "CheckAdmin"])
                ->namespace($this->plugin_namespace)
                ->group(app_path("Http/Controllers/Plugin/admin.php"));
        }

        if (file_exists(app_path("Http/Controllers/Plugin/home.php"))) {
            Route::prefix("plugin")
                ->middleware(["web", 'home.visitlog'])
                ->namespace($this->plugin_namespace)
                ->group(app_path("Http/Controllers/Plugin/home.php"));
        }

        if (file_exists(app_path("Http/Controllers/Plugin/api.php"))) {
            Route::prefix("plugin")
                ->middleware(["api"])
                ->namespace($this->plugin_namespace)
                ->group(app_path("Http/Controllers/Plugin/api.php"));
        }
    }

    protected function ModuleRoutes() {

        if(is_install()){
            $modules = new \App\Models\Modules();
            //$modules_install_datas = $modules->where('status', 1)->orderBy("created_at","desc")->get();
            $modules_install_datas = $modules->orderBy("created_at","desc")->get();
            define("MODULE_INSTALL_ALL",$modules_install_datas);
        }

        if (file_exists(app_path("Http/Controllers/Module/admin.php"))) {
            Route::prefix("module")
                ->middleware(["web", "CheckAdmin"])
                ->namespace($this->module_namespace)
                ->group(app_path("Http/Controllers/Module/admin.php"));
        }

        if (file_exists(app_path("Http/Controllers/Module/home.php"))) {

            Route::prefix("module")
                ->middleware(["web", 'home.visitlog'])
                ->namespace($this->module_namespace)
                ->group(app_path("Http/Controllers/Module/home.php"));

        }

        if (file_exists(app_path("Http/Controllers/Module/api.php"))) {
            Route::prefix("module")
                ->middleware(["api"])
                ->namespace($this->module_namespace)
                ->group(app_path("Http/Controllers/Module/api.php"));
        }
    }





}
