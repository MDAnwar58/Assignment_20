<?php
namespace App\Helper;
// require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken 
{
    public static function createToken($userEmail) {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Authentication_POS',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function createTokenForSetPassword($userEmail)
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Authentication_POS',
            'iat' => time(),
            'exp' => time() + 60 * 20,
            'userEmail' => $userEmail
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }
    public static function verifyToken($token)
    {
        try {
            $key = env('JWT_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode->userEmail;
        } catch (\Throwable $th) {
            return "Unauthenticated";
        }
    }
}