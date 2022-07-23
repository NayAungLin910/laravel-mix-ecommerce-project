<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', [App\Http\Controllers\Api\HomeApi::class, "home"]);
Route::get('/product/{slug}', [App\Http\Controllers\Api\ProductApi::class, "detail"]);
Route::post('/make-review/{slug}', [App\Http\Controllers\Api\ReviewApi::class, "makeReview"]);
Route::post('/add-to-cart/{slug}', [App\Http\Controllers\Api\CartApi::class, "addToCart"]);
Route::post('/get-cart', [App\Http\Controllers\Api\CartApi::class, "getCart"]);
Route::post('/update-cart-qty', [App\Http\Controllers\Api\CartApi::class, "updateQty"]);
Route::post('/remove-cart', [App\Http\Controllers\Api\CartApi::class, "removeCart"]);
Route::post('/checkout', [App\Http\Controllers\Api\CartApi::class, "checkout"]);
Route::get('/order', [App\Http\Controllers\Api\CartApi::class, "order"]);
Route::post('/change-password', [App\Http\Controllers\Api\AuthApi::class, "changePassword"]);

