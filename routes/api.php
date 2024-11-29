<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PriceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('stocks')->group(function() {
    Route::controller(StockController::class)->group(function() {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });
});

Route::prefix('prices')->group(function() {
    Route::controller(PriceController::class)->group(function() {
        Route::get('/{id}', 'filter');
    });
});