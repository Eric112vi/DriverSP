<?php

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\SyncController;
use App\Http\Controllers\Api\V1\SalesController;

Route::prefix('v1')->group(function () {
    Route::post('/login',[ AuthController::class, 'login']);
    // Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    //     ->middleware('guest')
    //     ->name('login');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/changepassword', [AuthController::class, 'changepassword']);
        Route::post('/resetuserpassword', [AuthController::class, 'resetuserpassword']);
        // Route::post('/deactivateuser', [AuthController::class, 'deactivateuser']);
        // Route::post('/activateuser', [AuthController::class, 'activateuser']);
        // Route::post('/updateuserpermission', [AuthController::class, 'updateuserpermission']);

        Route::post('/ngk/sync', [SyncController::class, 'syncNgk']);
        Route::post('/falken/sync', [SyncController::class, 'syncFalken']);
        Route::post('/philips/sync', [SyncController::class, 'syncPhilips']);
        Route::post('/mitsu/sync', [SyncController::class, 'syncMitsu']);
        Route::post('/partpku/sync', [SyncController::class, 'syncPku']);

        Route::get('/ngk/data', [SalesController::class, 'getNgkInvoice']);
        Route::get('/falken/data', [SalesController::class, 'getFalkenInvoice']);
        Route::get('/philips/data', [SalesController::class, 'getPhilipsInvoice']);
        Route::get('/mitsu/data', [SalesController::class, 'getMitsuInvoice']);
        Route::post('/sales/{invoice}/photos', [SalesController::class, 'uploadPhotos']);
        Route::post('/sales/{invoice}/delivery', [SalesController::class, 'startDelivery']);
        Route::post('/sales/{invoice}/confirm', [SalesController::class, 'confirm']);
        Route::resource('sales', SalesController::class);
    });
});
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        // 'permissions' => $request->user()->permissions()->pluck('name')->toArray(),
        // 'roles' => $request->user()->roles()->pluck('name')->toArray()
    ]);
});
