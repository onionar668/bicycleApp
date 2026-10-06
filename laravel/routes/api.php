<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BicyclesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function() {
    Route::post('/auth/sign-up', [AuthController::class, 'register'])->name('register');
    Route::post('/auth/sign-in', [AuthController::class, 'login'])->name('login');
    Route::get('/bicycles', [BicyclesController::class, 'index'])->name('bicycles.index');
    Route::get('/bicycles/{id}/tariffs', [BicyclesController::class, 'tariffBicycle'])->name('tarifBicycle');
    Route::get('/bicycles/{bicycleId}/tariffs/{tariffId}/price', [BicyclesController::class, 'priceBicycle'])->name('priceBicycle');
    Route::get('/bicycles/{id}/rentals', [BicyclesController::class, 'rentalsBicycle'])->name('rentalsBicycle');
    Route::get('/bicycles/{id}', [BicyclesController::class, 'show'])->name('bicycles.show');
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/auth/sign-out', [AuthController::class, 'logout'])->name('logout');
        Route::get('/users/me', [AuthController::class, 'me'])->name('me');
        Route::get('/users/me/transactions', [AuthController::class, 'meHistory'])->name('history');
    });
});
