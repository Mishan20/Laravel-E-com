<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
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
});

Route::group(['middleware' => [ 'auth', 'role:admin|seller']], function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductManagementController::class);
    
});

Route::group(['middleware' => [ 'auth', 'role:admin']], function () {
    Route::resource('users', UserManagememntController::class);
});

Route::resource('banks', BankController::class);

//This is use for remove some action in the controller
// Route::resource('users', UserManagememntController::class)->except('index');



require __DIR__.'/auth.php';
