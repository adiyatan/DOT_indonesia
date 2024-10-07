<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\PetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Route untuk login
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 401,
            'message' => 'Invalid credentials',
            'data' => null
        ], 401);
    }

    return response()->json([
        'status' => 200,
        'message' => 'Login successful',
        'data' => [
            'token' => $user->createToken('token-name')->plainTextToken,
        ]
    ], 200);
});

// Route untuk mendapatkan informasi user yang sedang login
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'status' => 200,
        'message' => 'User details retrieved successfully',
        'data' => $request->user()
    ], 200);
});

// Route untuk logout
Route::post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'status' => 200,
        'message' => 'Logged out successfully',
        'data' => null
    ], 200);
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum', 'force.json')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Route untuk resource controller ProductController
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});
