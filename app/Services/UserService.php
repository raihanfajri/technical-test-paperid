<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\TokenWhitelistRepositoryInterface as TokenWhitelistRepository;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserService
{
    protected $user;

    protected $tokenWhitelist;

	public function __construct(UserRepository $user, TokenWhitelistRepository $tokenWhitelist)
	{
        $this->user = $user;
        $this->tokenWhitelist = $tokenWhitelist;
    }
    
    public function create($params)
    {
        return $this->user->create(
            [
                'email' => $params['email'],
                'password' => bcrypt($params['password']),
            ]
        );
    }

    public function verify($params, $userInfo)
    {
        $email = $params['email'];
        $password = $params['password'];

        $user = $this->user->findOneByEmail($email);

        if (!$user)
        {
            throw new BadRequestHttpException(trans('auth.failed'));
        }

        if (!Hash::check($password, $user->password))
        {
            throw new BadRequestHttpException(trans('auth.failed'));
        }

        $jwtToken = $this->generateJWT($user->id, $user->email);

        $this->whitelistToken($user, $jwtToken, $userInfo);

        return $jwtToken;
    }

    public function logout($token)
    {
        $tokenWhitelist = $this->tokenWhitelist->findOneActiveByToken($token);

        if ($tokenWhitelist)
        {
            $tokenWhitelist->update(
                [
                    'expired_at' => date('Y-m-d H:i:s')
                ]
            );
        }
    }

    public function isTokenActive($token)
    {
        return !empty($this->tokenWhitelist->findOneActiveByToken($token));
    }

    protected function generateJWT($userID, $email)
    {
        $JWTPayload = [
            'iss' => "tech-test-paper", // Issuer of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + (60 * 60 * 1), // Expiration time 1 hour
            'user' => [
                'id' => $userID,
                'email' => $email,
            ],
            'lang' => $params['lang'] ?? null
        ];

        return JWT::encode($JWTPayload, config('auth.jwt'));
    }

    protected function whitelistToken($user, $token, $userInfo)
    {
        $this->tokenWhitelist->create(
            [
                'user_id' => $user->id,
                'token' => $token,
                'ip_address' => $userInfo['ip'],
                'user_agent' => $userInfo['user_agent'],
                'expired_at' => date('Y-m-d H:i:s', time() + (60 * 60 * 1))
            ]
        );
    }
}