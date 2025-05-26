<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth','isAdmin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('tags', TagController::class)->except(['show']);
    Route::resource('posts', PostController::class)->except(['show']);


});
