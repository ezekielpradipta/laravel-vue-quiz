<?php

use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\AuthController;
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
Route::post('/sentToken',[AuthController::class,'sentToken']);
Route::post('/validateToken',[AuthController::class,'validateToken']);
Route::post('/resetPassword',[AuthController::class,'resetPassword']);
Route::post('/cek/email',[UtilityController::class,'cekEmail']);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::prefix('admin')->group(function(){
        Route::get('/users',[UserAdminController::class,'index']);
        Route::post('/users/search',[UserAdminController::class,'search']);
        Route::post('/users/save',[UserAdminController::class,'save']);
        Route::post("/users/edit/{id}",[UserAdminController::class,'detail']);
        Route::post("/users/delete/{id}",[UserAdminController::class,'delete']);
    });
});