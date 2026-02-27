<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReviewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login'); 
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/user', [LoginController::class, 'user'])->name('user');

Route::middleware('auth')->group(function () {
    Route::get('/reviews', function () { return view('app'); });
    Route::get('/settings', function () { return view('app'); });
});

Route::middleware('auth')->group(function () {
    Route::get('/settings/yandex', [SettingsController::class, 'getYandexUrl']);
    Route::post('/settings/yandex', [SettingsController::class, 'saveYandexUrl']);
});

Route::middleware('auth')->get('/reviews/data', [ReviewsController::class, 'getReviewsTest']);