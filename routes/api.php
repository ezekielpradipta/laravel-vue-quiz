<?php

use App\Http\Controllers\Api\Admin\UserAdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\UtilityController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/cobaaa',[QuizQuestionController::class,'cobaa']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/cek/email',[UtilityController::class,'cekEmail']);
    Route::prefix('admin')->group(function(){
        Route::get('/users',[UserAdminController::class,'index']);
        Route::post('/users/search',[UserAdminController::class,'search']);
    });
});