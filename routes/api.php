<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductGalleriesController;
use App\Http\Controllers\API\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('midtrans/callback', [MidtransController::class, 'callback']);

Route::prefix('/v1')->group(function () {

    Route::post('/register', [AuthController::class, 'registration']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(['auth:sanctum', 'verified'])->prefix('/dashboard')->group(function () {

        // Route for product
        Route::get('/product', [ProductController::class, 'index']);
        Route::post('/product', [ProductController::class, 'store']);
        Route::get('/product/{id}', [ProductController::class, 'edit']);
        Route::put('/product/{id}', [ProductController::class, 'update']);
        Route::delete('/product/{id}', [ProductController::class, 'delete']);

        // route for product galleries
        Route::get('/product/galleries/{product_id}', [ProductGalleriesController::class, 'index']);
        Route::post('/product/galleries/{product_id}', [ProductGalleriesController::class, 'store']);
        Route::put('/product/galleries/{photo_id}', [ProductGalleriesController::class, 'status']);
        Route::delete('/product/galleries/{photo_id}', [ProductGalleriesController::class, 'delete']);

        // route for transaction
        Route::get('/transaction', [TransactionController::class, 'index']);
        Route::put('/transaction/{id}', [TransactionController::class, 'update']);
        Route::get('/transaction/{id}', [TransactionController::class, 'show']);
    });
});
