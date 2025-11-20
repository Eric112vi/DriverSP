<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', function () {
            return view('auth-login',[
                'title' => 'Login'
            ]);
        })->name('login');
        Route::post('/login', [AuthController::class, 'adminLogin'])
            ->name('login.attempt');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'adminLogout'])
            ->name('logout');
    });
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        // 'permissions' => $request->user()->permissions()->pluck('name')->toArray(),
        // 'roles' => $request->user()->roles()->pluck('name')->toArray()
    ]);
});