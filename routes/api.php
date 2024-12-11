<?php


use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CarController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => ['api']], function (){

    Route::post('/auth', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'login'])->name('login');
    Route::get('/cars', [CarController::class, 'index'])->name('cars.list');
    Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');
    Route::get('/cars/similar/{id}', [CarController::class, 'similar'])->name('cars.similar');


    // Эндпоинты с подтвержденной авторизацией
    Route::group(['middleware' => ['auth:sanctum', 'two-factor']], function (){

        Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

    });



});
