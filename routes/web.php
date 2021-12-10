<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [HomeController::class, 'home'])->name('home.index');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/single', AboutController::class);
Route::get('/secret', [HomeController::class, 'secret'])
  ->name('secret')
  ->middleware('can:home.secret');

// POSTS
Route::resource('posts', BlogPostController::class);

Route::get('/posts/tag/{id}', [PostTagController::class, 'index'])
  ->name('posts.tags.index');

Route::resource('posts.comments', PostCommentController::class)
  ->only(['store']);
// AUTH
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);
Route::resource('login', LoginController::class)->only('index', 'store');
Route::resource('register', RegisterController::class)->only('index', 'store');

Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::prefix('/password')->middleware('auth')->name('password.')->group(function () {
  Route::get('/reset', [ResetPasswordController::class, 'request'])->name('request');
  Route::get('/reset/{token}', [ResetPasswordController::class, 'reset'])->name('reset');
  Route::post('/reset', [ResetPasswordController::class, 'update'])->name('update');
  Route::post('/email', [ResetPasswordController::class, 'email'])->name('email');
});
