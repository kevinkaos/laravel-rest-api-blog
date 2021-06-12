<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/categories', [CategoryController::class, 'index']);

//protected
Route::middleware('auth:api')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/category/{category}', [PostController::class, 'getPostsByCategoryId']);
    Route::get('/posts/user/{user}', [PostController::class, 'getPostsByUserId']);
    Route::post('/post', [PostController::class, 'store']);
    Route::get('/post/{post}', [PostController::class, 'show']);
    Route::post('/post/{post}', [PostController::class, 'update']);
    Route::delete('/post/{post}', [PostController::class, 'destroy']);
    Route::get('/users', [UserController::class, 'index']);
});
