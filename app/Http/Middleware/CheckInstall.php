<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Install\InstallController;
use Closure;

class CheckInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!InstallController::checkInstall()) return redirect('/install');
        return $next($request);
    }
}
