<?php

use App\Http\Controllers\Api\CheckinController;
use App\Http\Controllers\Api\UploadController;

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
Route::resource('store', CheckinController::class);
Route::resource('upload', UploadController::class);
Route::post('checkout', [CheckinController::class, 'checkout']);
Route::post('otin', [CheckinController::class, 'otin']);
Route::post('otout', [CheckinController::class, 'otout']);