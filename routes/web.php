<?php

use App\Events\NewUserRegisterEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\FacebookLoginController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Api\TestFakeApiController;

Route::get('/', function () {
    return view('welcome');
});

//Test Fake API products
Route::get('/fake-api-products', [TestFakeApiController::class, 'index'])->name('fake.products');


Route::get('products/export/', [ProductManagementController::class, 'export']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('isAdmin');// we can use verify middleware

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

Route::get('lang/{lang}', [LocalizationController::class, 'switchLang'])->name('lang.switch');

use App\Http\Controllers\UserManagememntController;
use App\Http\Controllers\ProductManagementController;

Route::get('/test-broadcast', function () {
    event(new NewUserRegisterEvent());
    return 'Event has been sent!';
});

Route::controller(StripePaymentController::class)->group(function(){
    Route::get('/stripe', 'stripe');
    Route::post('/stripe', 'stripePost')->name('stripe.post');
});


require __DIR__.'/auth.php';
