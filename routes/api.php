<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\PostController;
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

Route::post('/user/login', [AuthController::class, 'login']);

// Authenticated API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/user/logout', [AuthController::class, 'logout']);

    Route::controller(MeController::class)->group(function () {
        Route::get('me/profile', 'profile');
        Route::get('me/body_info_histories', 'bodyInfoHistories');
        Route::get('me/exercise_histories', 'exerciseHistories');
        Route::get('me/meals', 'meals');
        Route::get('me/diaries', 'diaries');
    });
});

// Public APIs
Route::controller(PostController::class)->group(function () {
    Route::get('/public/posts', 'index');
    Route::get('/public/posts/{id}', 'show');
});
