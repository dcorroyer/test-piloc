<?php

use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\LoginController;
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

Route::middleware('auth:api')->group(function(){
    Route::get('/me', [LoginController::class,'authenticatedUserDetails']);
});

Route::middleware('auth:api')->group(function() {
    Route::apiResource("properties", PropertyController::class);
});

Route::middleware('auth:api')->group(function() {
    Route::apiResource("users", UserController::class);
});

Route::post('/login', 'App\Http\Controllers\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\LoginController@logout');
Route::post('/register', 'App\Http\Controllers\RegisterController@register');
