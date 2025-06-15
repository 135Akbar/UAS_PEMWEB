<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;

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
    
    // News Routes
    Route::resource('news', NewsController::class)->except(['show']);
    Route::post('news/{news}/approve', [NewsController::class, 'approve'])->name('news.approve');
    
    // Categories Routes (admin only)
    Route::middleware('role:admin')->resource('categories', CategoryController::class);
});

require __DIR__.'/auth.php';
