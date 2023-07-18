<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use App\Http\Middleware\TokenVerify;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// view routes
Route::get('/home', [ViewController::class, 'home'])->name('home')->middleware([TokenVerify::class]);
Route::get('/login', [ViewController::class, 'loginPage'])->name('login');
Route::get('/register', [ViewController::class, 'registerPage'])->name(name: 'register');
Route::get('/forget-password', [ViewController::class, 'forgetPage'])->name('forget.password');
Route::get('/verify-otp', [ViewController::class, 'verifyOTPPage'])->name('verify.otp');
Route::get('/reset-password', [ViewController::class, 'resetPassword'])->name('reset.password');

// api routes
Route::post('/register' , [AuthController::class, 'register']);
Route::post('/login' , [AuthController::class, 'login']);
Route::post('/send-otp' , [AuthController::class, 'sendOTP']);
Route::post('/verify-otp' , [AuthController::class, 'verifyOTP']);
Route::post('/reset-password' , [AuthController::class, 'resetPassword']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware([TokenVerify::class]);


