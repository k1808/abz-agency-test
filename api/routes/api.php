<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'one']);

Route::get('/token', [\App\Http\Controllers\Api\TokenController::class, 'index']);
Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'all']);
Route::get('/positions', [\App\Http\Controllers\Api\PositionController::class, 'index']);

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
