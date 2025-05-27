<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;






Route::controller(PostController::class)->as('frontend.')->group(function () {
    Route::get('/','index')->name('posts.index');
    Route::get('/posts/{slug}','show')->name('posts.show');
    Route::post('/posts','posts')->name('posts.load-more');

    Route::middleware('auth')->group(function () {
        Route::get('/posts-list', 'myPosts')->name('posts.list');
        Route::get('/posts-create', 'create')->name('posts.create');
        Route::post('/posts-store', 'store')->name('posts.store');

    });

});







require __DIR__.'/auth.php';
