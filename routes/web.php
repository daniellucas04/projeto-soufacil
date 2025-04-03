<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Private routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function() {
        return view('auth.dashboard');
    });

    Route::controller(CustomerController::class)->group(function () {
        // FORMS
        Route::get('/customers', 'index');
        Route::get('/customers/create', 'create');
        Route::get('/customers/{id}/edit', 'edit');

        // REQUESTS
        Route::post('/customers/create', 'store');
        Route::put('/customers/{id}/edit', 'update');
        Route::delete('/customers/{id}/destroy', 'destroy');
    });

    Route::controller(SaleController::class)->group(function () {
        // FORMS
        Route::get('/sales', 'index');
        Route::get('/sales/customers', 'customers');
        Route::get('/sales/{id}/create', 'create');
        
        // REQUESTS
        Route::post('/sales/{id}/create', 'store');
        Route::post('/sales/{id}/receive', 'store');
    });

    Route::controller(ReceiptController::class)->group(function () {
        // FORMS
        Route::get('/reciepts', 'index');
        Route::get('/reciepts/create', 'create');
        Route::get('/reciepts/{id}/edit', 'edit');

        // REQUESTS
        Route::post('/reciepts/create', 'store');
        Route::put('/reciepts/{id}/edit', 'update');
        Route::delete('/reciepts/{id}/destroy', 'destroy');
    });

    Route::controller(UserController::class)->group(function () {
        // FORMS
        Route::get('/users', 'index');
        Route::get('/users/create', 'create');
        Route::get('/users/{id}/edit', 'edit');

        // REQUESTS
        Route::post('/users/create', 'store');
        Route::put('/users/{id}/edit', 'update');
        Route::delete('/users/{id}/destroy', 'destroy');
    });
});
