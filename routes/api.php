<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Post routes
Route::apiResource ( 'posts', PostController::class);

//Authentication routes
Route::post ('/register', [AuthController::class, 'register']);
Route::post ('/login', [AuthController::class, 'login']);
Route::post ('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//User routes
Route::apiResource('users', UserController::class);




