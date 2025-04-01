<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Private routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function() {
        return view('auth.dashboard');
    });

    Route::get('/customers', function() {
        return view('auth.customers.list');
    });

    Route::get('/sales', function() {
        return view('auth.sales.list');
    });

    Route::get('/reciepts', function() {
        return view('auth.reciepts.list');
    });

    Route::get('/users', function() {
        return view('auth.users.list');
    });
});

// Public routes
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);