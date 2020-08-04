<?php

namespace App\Http\Middleware;

use Closure;

class CheckIpBlacklist
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
        $blacklist = __E('blacklist_ip');
        if(!empty($blacklist) && in_array(get_ip(), explode('，', $blacklist))) return redirect('admin/blacklist');
        return $next($request);
    }
}
