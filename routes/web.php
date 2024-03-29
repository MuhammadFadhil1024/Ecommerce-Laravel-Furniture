<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyTransactionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/costcourier', [FrontendController::class, 'checkCourierCost']);

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/details/{slug}', [FrontendController::class, 'details'])->name('details');
Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
Route::get('/checkout/success', [FrontendController::class, 'success'])->name('checkout-success');



Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
    Route::post('/cart/{id}', [FrontendController::class, 'cartAdd'])->name('cart-add');
    Route::delete('/cart/{id}', [FrontendController::class, 'cartDelete'])->name('cart-delete');
    Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
    Route::post('/finalization', [FrontendController::class, 'finalization'])->name('finalization');
    Route::get('/checkout/success', [FrontendController::class, 'success'])->name('checkout-success');
    Route::put('/cart/incrasequantity', [FrontendController::class, 'incraseQuantity'])->name('incrase-quantity');
    Route::put('/cart/decrasequantity', [FrontendController::class, 'decraseQuantity'])->name('decrase-quantity');
});

Route::middleware(['auth:sanctum', 'verified'])->name('dashboard.')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::resource('my-transaction', MyTransactionsController::class)->only([
        'index', 'show'
    ]);
    Route::resource('my-address', AddressController::class);
    Route::put('/my-address/activate/{address_id}', [AddressController::class, 'activateAddress']);

    Route::middleware(['admin'])->group(function () {
        Route::resource('product', ProductController::class);
        Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
            'index', 'create', 'store', 'destroy'
        ]);
        Route::resource('transaction', TransactionController::class)->only([
            'index', 'show', 'edit', 'update'
        ]);
        Route::resource('user', UserController::class)->only([
            'index', 'show', 'edit', 'update', 'destroy'
        ]);
    });
});
