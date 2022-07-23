<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

/* Auth Routes */

Route::middleware(['RedirectIfAuth'])->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'postLogin']);

    Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister']);
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'postRegister']);
});

Route::middleware(['RedirectIfNotAuth'])->group(function () {
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/profile', [App\Http\Controllers\PageController::class, 'showProfile']);
});


/* Auth Routes */

Route::get('/', [App\Http\Controllers\PageController::class, 'home']);
Route::get('/products', [App\Http\Controllers\PageController::class, 'allProduct']);
Route::get('/product/{slug}', [App\Http\Controllers\ProductController::class, 'detail']);

Route::get('/auth', function () {
    $user = User::find(1);
    auth()->login($user);
    return auth()->user();
});

/* Admin Routes */
Route::get('/admin/login', [App\Http\Controllers\Admin\PageController::class, "showLogin"]);
Route::post('/admin/login', [App\Http\Controllers\Admin\PageController::class, "login"]);
Route::prefix('admin')->middleware(['Admin'])->namespace("Admin")->group(function () {
    Route::post("/logout", [App\Http\Controllers\Admin\PageController::class, "logout"]);
    Route::get("/", [App\Http\Controllers\Admin\PageController::class, "showDashbord"]);
    Route::resource('category', '\App\Http\Controllers\Admin\CategoryController');
    Route::resource('color', '\App\Http\Controllers\Admin\ColorController');
    Route::resource('brand', '\App\Http\Controllers\Admin\BrandController');
    Route::resource('income', '\App\Http\Controllers\Admin\IncomeController');
    Route::resource('outcome', '\App\Http\Controllers\Admin\OutcomeController');
    // product routes
    Route::resource('product', '\App\Http\Controllers\Admin\ProductController');
    Route::get('/create-product-add/{slug}', [App\Http\Controllers\Admin\ProductController::class, 'createProductAdd']);
    Route::post('/create-product-add/{slug}', [App\Http\Controllers\Admin\ProductController::class, 'storeProductAdd']);
    Route::get('/create-product-remove/{slug}', [App\Http\Controllers\Admin\ProductController::class, 'createProductRemove']);
    Route::post('/create-product-remove/{slug}', [App\Http\Controllers\Admin\ProductController::class, 'storeProductRemove']);
    Route::get('/product-add-transaction', [App\Http\Controllers\Admin\ProductController::class, 'productAddTransaction']);
    Route::get('/product-remove-transaction', [App\Http\Controllers\Admin\ProductController::class, 'productRemoveTransaction']);
    Route::post('product-upload', [App\Http\Controllers\Admin\ProductController::class, "imageUpload"]);

    Route::get('/order', [App\Http\Controllers\Admin\OrderController::class, "all"]);
    Route::get('/change-order', [\App\Http\Controllers\Admin\OrderController::class, "changeOrderStatus"]);
});

Route::get('/locale/{locale}', function($locale){
    session()->put('locale', $locale);//mm or en
    return redirect()->back()->with('success', "Language is switched!");
});

