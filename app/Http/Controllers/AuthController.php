<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    function register(Request $request)
    {
        try {
            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed!'
            ]);
        }
    }

    function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', '=', $email)->first();
        $count = User::where('email', '=', $email)->count();

        $checkPassword = Hash::check($password, $user->password);
        if ($checkPassword) {
            if ($count == 1) {
                $token = JWTToken::createToken($email);

                return response()->json([
                    'status' => 'success',
                    'message' => 'User Login Successfully!',
                ], 200)->cookie('token', $token, 60 * 24 * 30);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Unauthorized!'
                ], 401);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Your Password is Not Vaild!'
            ], 401);
        }
    }
    function sendOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(10000, 99999);
        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));

            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => '5 digit OTP Code has been send to your email!',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized!'
            ], 401);
        }
    }
    function verifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();

        if ($count == 1) {
            User::where('email', '=', $email)->update(['otp' => '0']);

            $token = JWTToken::createTokenForSetPassword($email);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification Successfully!',
            ], 200)->cookie('otp', $token, 60 * 20);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized!'
            ], 401);
        }
    }

    function resetPassword(Request $request): JsonResponse
    {
        try {
            $email = $request->input('email');
            $password = $request->input(key: 'password');

            User::where('email', '=', $email)->update(['password' => Hash::make($password)]);
            
            $cookieTokenName = 'otp';
            $cookie = Cookie::forget($cookieTokenName);

            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset Successfully!'
            ], 200)->withCookie($cookie);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Something Went Wrong!'
            ]);
        }
    }

    function logout()
    {
        $cookieTokenName = 'token';

        $cookie = Cookie::forget($cookieTokenName);

        return response()->json([
            'message' => 'Cookie has been removed'
        ], 200)->withCookie($cookie);
    }
}
