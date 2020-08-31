<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException(implode(" | ", $validator->errors()->all()));
        }

        $user = $this->userService->create($request->all());

        return response([
            'message' => "Successfully register a user"
        ], 201);
    }

    /**
     * Return JWT token after email and password check.
     *
     * @param  array  $data
     * @return string
     */
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException(implode(" | ", $validator->errors()->all()));
        }

        $userInfo = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ];

        $token = $this->userService->verify($request->all(), $userInfo);

        return response([
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $this->userService->logout($request->token);

        return response('', 204);
    }
}
