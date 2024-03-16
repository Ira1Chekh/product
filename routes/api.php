<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CodeCheckController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('login', [AuthController::class, 'loginShow'])->name('login');
Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.verify');
Route::post('forgot-password',  ForgotPasswordController::class);
Route::post('reset-password', PasswordResetController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
});
