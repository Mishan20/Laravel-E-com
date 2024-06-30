<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\FacebookLoginController;
use App\Http\Controllers\UserManagememntController;
use App\Http\Controllers\ProductManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::resource('users', UserManagememntController::class);
    Route::post('/add-to-cart/{product}' , [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::get('/cart' , [CartController::class, 'cart'])->name('cart');
    Route::post('/cart/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

Route::group(['middleware' => [ 'auth', 'role:admin|seller']], function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductManagementController::class);
    Route::delete('/products/{product}/delete-image', [ProductManagementController::class, 'deleteImage'])->name('products.deleteImage');
    
});

Route::group(['middleware' => [ 'auth', 'role:admin']], function () {
    Route::resource('users', UserManagememntController::class);
});

Route::resource('banks', BankController::class);

//This is use for remove some action in the controller
// Route::resource('users', UserManagememntController::class)->except('index');


Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [FacebookLoginController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [FacebookLoginController::class, 'handleFacebookCallback']);


require __DIR__.'/auth.php';
