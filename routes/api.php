<?php

use App\Http\Controllers\Api;
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
    Route::post('/login', [Api\AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [Api\AuthController::class, 'register'])->name('auth.register');
    Route::post('/reset-password', [Api\AuthController::class, 'recovery'])->name('password.recovery');
    Route::post('/set-new-password', [Api\AuthController::class, 'setNewPassword'])->name('password.setNewPassword');
    Route::post('/reset-password/{token}', [Api\AuthController::class, 'verifyToken'])->name('password.verifyToken');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::put('/', [Api\ProfileController::class, 'save'])->name('save');
    });

    Route::prefix('dictionary')->name('dictionary.')->group(function () {
        Route::get('/list', [Api\DictionaryController::class, 'list'])->name('list');
        Route::post('/save', [Api\DictionaryController::class, 'save'])->name('save');
        Route::get('/translate', [Api\DictionaryController::class, 'translate'])->name('translate');
        Route::get('/{id}', [Api\DictionaryController::class, 'show'])->name('show');
        Route::delete('/{id}', [Api\DictionaryController::class, 'delete'])->name('delete');
    });

    Route::prefix('exercises')->name('exercises.')->group(function () {
        Route::get('/getData', [Api\ExercisesController::class, 'getData'])->name('getData');
        Route::post('/saveAnswer', [Api\ExercisesController::class, 'saveAnswer'])->name('saveAnswer');
    });
});
