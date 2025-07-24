<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Authentication routes
Route::post('register',
        [AuthenticationController::class, 'register'])->name('register');

Route::post('/login',
        [AuthenticationController::class, 'login'])->name('login');

// Product routes
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', ProductController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy'])
        ->names([
            'index' => 'products.index',
            'store' => 'products.store',
            'show' => 'products.show',
            'update' => 'products.update',
            'destroy' => 'products.destroy'
        ]);
});



