<?php

use App\Http\Controllers\Api\PageAController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('{hash}/play', [PageAController::class, 'play'])->name('play');
    Route::post('{hash}/history', [PageAController::class, 'history'])->name('history');
});
