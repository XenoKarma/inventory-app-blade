<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;

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

// AI
Route::get('/test-admin', function () {
    return 'OK ADMIN';
})->middleware(['auth','role:admin']);

// admin route
Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/add-stock',[ProductController::class, 'addStock'])->name('products.addStock');
    Route::post('products/{product}/reduce-stock',[ProductController::class, 'reduceStock'])->name('products.reduceStock');
});

require __DIR__.'/auth.php';
