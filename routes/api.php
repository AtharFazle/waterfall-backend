<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\SensorController;
use App\Http\Controllers\Api\SensorLogController;
use App\Http\Controllers\Api\VisitorLogController;
use App\Http\Middleware\VerifyIotToken;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('/me', [AuthController::class, 'me']);
    Route::get('/images', [ImageController::class, 'index']);
    Route::post('/images', [ImageController::class, 'upload']);
    Route::put('/images/ordering', [ImageController::class, 'ordering']);
    Route::post('/images/patch/{image}', [ImageController::class, 'update']);
    Route::delete('/images/{image}', [ImageController::class, 'destroy']);


    Route::get('/visitor-logs', [VisitorLogController::class, 'index']);
    Route::get('/visitor-logs/daily', [VisitorLogController::class, 'daily']);
    Route::post('/visitor-logs', [VisitorLogController::class, 'store']);
    Route::patch('/visitor-logs/{visitorLog}', [VisitorLogController::class, 'update']);
    Route::post('/visitor-logs/checkout-time/{visitorLog}', [VisitorLogController::class, 'checkoutTime']);
    
});

Route::get('/visitor-logs/hourly', [VisitorLogController::class, 'hourly']);
Route::get('/visitor-logs/daily-in', [VisitorLogController::class, 'dailyIn']);
Route::get('/visitor-logs/daily-out', [VisitorLogController::class, 'dailyOut']);


Route::get('/sensor-logs/latest', [SensorLogController::class, 'latest']);
Route::get('/sensor-logs', [SensorLogController::class, 'byDate']);
Route::get('/sensor-logs/hourly', [SensorLogController::class, 'groupedByHour']);

Route::prefix('iot')->middleware(VerifyIotToken::class)->group(function () {
    Route::post('data-sensors', [SensorController::class, 'store']);
    Route::post('/sensor-logs', [SensorLogController::class, 'storeFromIot']);
});

// Endpoint publik / frontend polling
