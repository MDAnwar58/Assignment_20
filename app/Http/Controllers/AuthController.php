<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
        return $password = $request->input('password');
        $user = User::where('email', '=', $email)->first();
        // $checkPassword = Hash::check($password, $user->password);
        // if ($checkPassword) {
        if ($user->count() == 1) {
            $token = JWTToken::createToken($email);

            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successfully!',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized!'
            ], 401);
        }
    }
    function sendOTP(Request $request): JsonResponse
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
    function verifyOTP(Request $request): JsonResponse
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
                'token' => $token
            ], 200)->cookie($token);
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

            User::where('email', '=', $email)->update(['password' => $password]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset Successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Something Went Wrong!'
            ]);
        }
    }
}
