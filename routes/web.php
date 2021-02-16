<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

/**
 * Home Route
 */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trendin', [HomeController::class, 'index'])->name('trendin');
Route::get('/subscriptions', [HomeController::class, 'index'])->name('subscriptions');

Route::middleware(['web', 'auth'])->group(function () {
	/**
	 * Profile Routes
	 */
	Route::name('profile')->prefix('/profile')->group(function () {
		Route::get('/settings', [ProfileController::class, 'edit'])->name('.edit');
		Route::get('/{user:slug}', [ProfileController::class, 'index']);
		Route::post('/', [ProfileController::class, 'store'])->name('.store');
		Route::put('/{user:slug}/follow', [ProfileController::class, 'follow'])->name('.follow');
	});

	/**
	 * Post Routes
	 */
	Route::group([], function () {
		Route::name('post.')->prefix('/post')->group(function () {
			# post list
			Route::get('/list', [PostController::class, 'index'])->name('list');
			// # post actions [likes  comments tags cats]
			Route::put('/{post}/like', [PostController::class, 'like'])->name('like');
			Route::put('/{post}/comment', [PostController::class, 'comment'])->name('comment');
			Route::put('/{post}/category', [CategoryController::class, 'toggel_post'])->name('toggelCategory');
			Route::put('/{post}/tag', [TagController::class, 'toggel_post'])->name('toggelTag');
		});
		Route::resource('post', PostController::class)->scoped([
			// 'post' => 'slug',
			// remamber to change the post parameter to slug
			// and add the slug feeld to the post table
		]);
	});

	/**
	 * Categories Routes
	 */
	Route::name('cat')->prefix('/cat')->group(function () {
		Route::get('/', [CategoryController::class, 'index']);
		Route::post('/', [CategoryController::class, 'update'])->name('.update');
		Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('.delete');
	});
	/**
	 * Media Routes
	 */
	Route::name('media')->prefix('/media')->group(function () {
		Route::get('/', [MediaController::class, 'index']);
		Route::post('/', [MediaController::class, 'update'])->name('.update');
		Route::delete('/{image}', [MediaController::class, 'destroy'])->name('.delete');
	});
});
