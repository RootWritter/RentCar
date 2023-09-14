<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'dashboard']);
});

Route::get('auth/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('auth/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('auth/register', [\App\Http\Controllers\AuthController::class, 'store']);
Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);



// Route for admin 
Route::prefix('admin')->group(function () {
    Route::middleware('adminauth')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);
    });

    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('adminLogin');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'authenticate']);
});
