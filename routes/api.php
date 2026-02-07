<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\AuthController;

Route::get('/letsgo365', function () {
    return response()->json([
        'message' => 'Welcome to the API!'
    ], 200);
});

Route::post('/join', [MembershipController::class, 'store']);
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/membership-requests', [MembershipController::class, 'index']);
    Route::patch('/membership-requests/{id}/approve', [MembershipController::class, 'approve']);
    Route::patch('/membership-requests/{id}/reject', [MembershipController::class, 'reject']);
});
Route::post('/admin/login', [AuthController::class, 'login']);
