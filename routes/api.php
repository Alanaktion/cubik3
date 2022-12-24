<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/users/@{user:username}', [UserController::class, 'show']);
Route::get('/users/@{user:username}/posts', [PostController::class, 'showUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/@{user:username}/follow', [UserController::class, 'follow']);
    Route::post('/users/@{user:username}/unfollow', [UserController::class, 'unfollow']);
    Route::get('/users/@{user:username}/following', [UserController::class, 'following']);
    Route::get('/users/@{user:username}/followers', [UserController::class, 'followers']);

    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);

    Route::get('/notifications', [NotificationController::class, 'index']);
});
