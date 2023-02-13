<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'cabinet'])->name('home');
    Route::any('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/page-a/{hash}', [UserController::class, 'pageA'])->name('page-a');
    Route::get('/page-a/{hash}/new', [UserController::class, 'newLink'])->name('new-link');
    Route::get('/page-a/{hash}/deactivate', [UserController::class, 'deactivateLink'])->name('deactivate-link');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'showRegisterForm'])->middleware('guest')->name('register');
    Route::post('/register', [UserController::class, 'processRegister'])->middleware('guest');
});
