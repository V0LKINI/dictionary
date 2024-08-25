<?php

use App\Http\Controllers\Site\AuthController;
use App\Http\Controllers\Site\DictionaryController;
use App\Http\Controllers\Site\ProfileController;
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
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/reset-password', [AuthController::class, 'recovery'])->name('password.recovery');
    Route::post('/set-new-password', [AuthController::class, 'setNewPassword'])->name('password.setNewPassword');
    Route::post('/reset-password/{token}', [AuthController::class, 'verifyToken'])->name('password.verifyToken');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::put('/', [ProfileController::class, 'save'])->name('save');
    });

    Route::prefix('dictionary')->name('dictionary.')->group(function () {
        Route::get('/list', [DictionaryController::class, 'list'])->name('list');
        Route::post('/save', [DictionaryController::class, 'save'])->name('save');
        Route::get('/translate', [DictionaryController::class, 'translate'])->name('translate');
        Route::get('/crawl', [DictionaryController::class, 'crawl'])->name('crawl');
        Route::delete('/{id}', [DictionaryController::class, 'delete'])->name('delete');
    });
});
