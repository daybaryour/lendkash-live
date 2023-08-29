<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use JWTAuth;
use App\Models\UserDevice;

class ApiUserDetail {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected function user()
    {
        return JWTAuth::parseToken()->authenticate();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $token = $request->header('authorization');
        $user = $this->user();

        $request->request->add(['user' => $user]); //add logger in user detail in request
        $token = str_replace('Bearer ', '', $token);
        $check = UserDevice::where(['user_id' => $user->id, 'authorization' => $token])->first();

        if(empty($check)){
            return response()->json(['success' => false, 'error' => ['message' => __('api.token_expired')]], 401);
        }
        // print_r($check);die;
        // $user = JWTAuth::toUser($request->header('Authorization'));
        // $request['user'] = $user;
        return $next($request);

    }

}
