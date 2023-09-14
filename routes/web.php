<?php

use Illuminate\Support\Facades\Auth;
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
    Route::get('rent', [\App\Http\Controllers\DashboardController::class, 'rentData']);
    Route::prefix('data')->group(function () {
        Route::post('get-model', [\App\Http\Controllers\DataController::class, 'getModel']);
        Route::get('rent-data', [\App\Http\Controllers\DataController::class, 'rentData']);
        Route::post('get-history-rent', [\App\Http\Controllers\DataController::class, 'rentDataHistory']);
    });
    Route::prefix('ajax')->group(function () {
        Route::post('rent', [\App\Http\Controllers\AjaxController::class, 'rentCar']);
        Route::post('return-car', [\App\Http\Controllers\AjaxController::class, 'returnCar']);
    });
    Route::get('logout', function () {
        Auth::logout();
        return redirect('auth/login');
    });
});

Route::get('auth/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('auth/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('auth/register', [\App\Http\Controllers\AuthController::class, 'store']);
Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);



// Route for admin 
Route::prefix('admin')->group(function () {
    Route::middleware('adminauth')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);
        Route::get('car', [\App\Http\Controllers\Admin\DashboardController::class, 'car']);
        Route::get('rent', [\App\Http\Controllers\Admin\DashboardController::class, 'rent']);



        Route::prefix('data')->group(function () {
            Route::get('car', [\App\Http\Controllers\Admin\DataController::class, 'car']);
            Route::post('get-car', [\App\Http\Controllers\Admin\DataController::class, 'getCar']);
            Route::get('rent-data', [\App\Http\Controllers\Admin\DataController::class, 'rentData']);
        });
        Route::prefix('ajax')->group(function () {
            Route::post('car', [\App\Http\Controllers\Admin\AjaxController::class, 'car']);
        });
    });

    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('adminLogin');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'authenticate']);
    Route::get('logout', function () {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    });
});
