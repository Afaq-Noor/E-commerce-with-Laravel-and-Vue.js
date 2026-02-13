<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiMainController;
use App\Http\Controllers\FrontendUser\CategoryPageController;
use App\Http\Controllers\FrontendUser\HomeController;

// Default test route (optional)
Route::get('/test', function () {
    return response()->json(['message' => 'API is working ✅']);
});


    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);


  
// ===============================
// 🛡️ Protected Routes (Sanctum)
// ===============================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']); // get current user
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/update' , [AuthController::class , 'update']) ;
    Route::delete('/user/delete' , [AuthController::class , 'destroy']) ;
});
// Frontend User Home Data 
Route::get('/front-home-data' , [HomeController::class , 'index']) ;
// Main Categories Data for home navbar
Route::get('/categories', [HomeController::class , 'navBarCategory']) ;

// After clicking main category in navbar then categories data
Route::get('/category/{slug?}' , [CategoryPageController::class , 'getCategoryData']) ;