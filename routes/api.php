<?php


use App\Http\Controllers\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => ['api']], function (){

    Route::post('/auth', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'login'])->name('login');


    // Эндпоинты с подтвержденной авторизацией
    Route::group(['middleware' => ['auth:sanctum', 'two-factor']], function (){

        Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

    });



});
