<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JWTAuthMiddleware
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //check the header
        if (empty($token)) {
            $token = trim(str_replace('Bearer', '', $request->header('Authorization')));
        }

        if (!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'message' => trans('auth.missing_token')
            ], 401);
        }

        try 
        {
            $credentials = JWT::decode($token, config('auth.jwt'), ['HS256']);

            if (!$this->userService->isTokenActive($token))
            {
                return response()->json([
                    'message' => trans('auth.expired_token')
                ], 401);
            }
            
            $request->user = $credentials->user;
            $request->token = $token;
        }
        catch (ExpiredException $e) 
        {
            return response()->json([
                'message' => trans('auth.expired_token')
            ], 401);
        } 
        catch (Exception $e) 
        {
            dd($e);
            return response()->json([
                'message' => trans('auth.error_token')
            ], 400);
        }

        return $next($request);
    }
}
