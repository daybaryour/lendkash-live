<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use JWTAuth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        // PLEASE ADD THIS LINES
        if ($exception->getMessage() === 'Token not provided') {
            return response()->json(['success' => false, 'error' => ['message' => __("api.token_not_provided")]], $exception->getStatusCode());
        }
        if ($exception instanceof UnauthorizedHttpException) {
            if ($exception->getPrevious() instanceof TokenExpiredException) {
                return response()->json(['success' => false, 'error' => ['message' => __("api.token_expired")]], $exception->getStatusCode());
                //     return response()->json(['error' => 'TOKEN_EXPIRED'], $exception->getStatusCode());
            } else if ($exception->getPrevious() instanceof TokenInvalidException) {
                return response()->json(['success' => false, 'error' => ['message' => __("api.token_invalid")]], $exception->getStatusCode());
            } else if ($exception->getPrevious() instanceof TokenBlacklistedException) {
                return response()->json(['success' => false, 'error' => ['message' => __("api.token_blacklisted")]], $exception->getStatusCode());
            } else {
                return response()->json(['success' => false, 'error' => ['message' => __("api.unauthorized_request")]], $exception->getStatusCode());
            }
        }
        // $user = JWTAuth::toUser($request->header('Authorization'));
        // $request['user'] = $user;
      //  dd(2);
        return parent::render($request, $exception);
    }
}
