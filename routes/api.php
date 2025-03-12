<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Post routes
// Route::apiResource ( 'posts', PostController::class);

//Authentication routes
Route::post ('/register', [AuthController::class, 'register']);
Route::post ('/login', [AuthController::class, 'login']);
Route::post ('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//User routes
Route::apiResource('users', UserController::class);

// Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Route::apiResource('/posts', PostController::class);

Route::get('/posts', [PostController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function() {     
    Route::get('/posts/{post}', [PostController::class, 'show'])->middleware('role:admin|brother');   
    Route::post('/posts', [PostController::class, 'store'])->middleware('role:admin|brother');
    Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('role:admin');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('role:admin, brother');
});




