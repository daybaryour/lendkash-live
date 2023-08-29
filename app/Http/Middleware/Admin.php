<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Admin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin') {
         // dd('cghe');
         if (Auth::guard($guard)->check()) {
            $response = $next($request);
            $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate,')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', '0');
            return $response;
        }

        return redirect('admin/login');
    }

}
