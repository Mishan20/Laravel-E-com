<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagememntController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('banks', BankController::class);

//This is use for remove some action in the controller
// Route::resource('users', UserManagememntController::class)->except('index');
Route::resource('users', UserManagememntController::class);
Route::resource('products', ProductManagementController::class);


require __DIR__.'/auth.php';
