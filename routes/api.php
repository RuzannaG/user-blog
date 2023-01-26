<?php

use App\Http\Controllers\APIs\Auth\LoginController;
use App\Http\Controllers\APIs\Auth\RegisterController;
use App\Http\Controllers\APIs\PostController;
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

Route::prefix('auth')->group(function(){
    Route::post('register', [RegisterController::class, 'register'])->name('register.api');
    Route::post('login', [LoginController::class, 'login'])->name('login.api');
    Route::middleware('auth:api')->group( function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout.api');
           
    });
   
});
 Route::middleware('auth:api')->group(function () {
    Route::resource('posts', PostController::class);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'delete']);
        Route::get('posts/{search}', [PostController::class, 'search']);
    });


