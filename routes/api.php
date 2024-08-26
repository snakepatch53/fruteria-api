<?php

use App\Http\Controllers\ComboController;
use App\Http\Controllers\ComboProductController;
use App\Http\Controllers\ComboSaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSaleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'v1'], function () {

    Route::middleware('auth:sanctum')->group(function () {
        // users
        Route::resource('users', UserController::class);
        Route::post('logout', [UserController::class, 'logout']);
        Route::post('exist-session', [UserController::class, 'existSession']);

        // customers
        Route::resource('customers', CustomerController::class)->except(['index', 'store', 'update']);

        // sales
        Route::resource('sales', SaleController::class)->except(['store', 'show']);

        // products
        Route::resource('products', ProductController::class)->except(['index', 'update']);
        Route::post('products/{id}', [ProductController::class, 'update']);

        // product-sales
        Route::resource('product-sales', ProductSaleController::class)->except(['store']);

        // combos
        Route::resource('combos', ComboController::class)->except(['show']);

        // combo-products
        Route::resource('combo-products', ComboProductController::class);

        // combo-sales
        Route::resource('combo-sales', ComboSaleController::class)->except(['store']);
    });

    // users
    Route::post('login', [UserController::class, 'login']);

    // customers
    Route::resource('customers', CustomerController::class)->only(['index', 'store', 'update']);

    // sales
    Route::resource('sales', SaleController::class)->only(['store', 'show']);

    // products
    Route::resource('products', ProductController::class)->only(['index']);

    // product-sales
    Route::resource('product-sales', ProductSaleController::class)->only(['store']);

    // combos
    Route::resource('combos', ComboController::class)->only(['show']);

    // combo-sales
    Route::resource('combo-sales', ComboSaleController::class)->only(['store']);
});
