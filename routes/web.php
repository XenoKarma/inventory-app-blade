<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// AI
Route::get('/test-admin', function () {
    return 'OK ADMIN';
})->middleware(['auth','role:admin']);

// web.php
Route::middleware(['auth','can:manage-users'])->group(function() {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});




// admin route
Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/add-stock',[ProductController::class, 'addStock'])->name('products.addStock');
    Route::post('products/{product}/reduce-stock',[ProductController::class, 'reduceStock'])->name('products.reduceStock');
    Route::post('products/{product}/archive', [ProductController::class, 'archive'])->name('products.archive');
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::get('products-archived',
    [ProductController::class, 'archived']
)->name('products.archived');

});

require __DIR__.'/auth.php';
