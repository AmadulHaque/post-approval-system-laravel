<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;






Route::get('/',[HomePageController::class, 'index'])->name('home');
Route::get('/post/{slug}',[HomePageController::class, 'postDetail'])->name('post.detail');
Route::post('/posts',[HomePageController::class, 'posts'])->name('posts.load-more');


Route::middleware('auth')->group(function () {
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

});





require __DIR__.'/auth.php';
