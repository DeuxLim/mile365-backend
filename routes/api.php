<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MembershipController;

Route::get('/letsgo365', function () {
    return response()->json([
        'message' => 'Welcome to the API!'
    ], 200);
});

Route::post('/join', [MembershipController::class, 'store']);
