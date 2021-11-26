<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
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

Route::resource('posts', PostsController::class);

// Route::prefix('/posts')
//     ->name('posts.')
//     ->group(function () use ($posts) {

//         Route::get('', function (Request $request) use ($posts) {
//             return view('posts.index', ['posts' => $posts]);
//         })->name('index');

//         Route::get("/{id}", function ($id) use ($posts) {
//             abort_if(!isset($posts[$id]), 404);

//             return view('posts.show', ['post' => $posts[$id]]);
//         })->name("show");

//         Route::get('/recent/{days_ago?}', function ($days_ago = 20) {
//             return "We may have $days_ago";
//         })->where([
//             'days_ago' => '[0-9]+',
//         ])->name("recent.index");

//     });

// Route::prefix('/fun')->name('fun.')->group(function () use ($posts) {

//     Route::get('/responses', function () use ($posts) {
//         return response($posts, 201)
//             ->header('Content-Type', 'application/json')
//             ->cookie('MY_COOKIE', 'lschulzes', 1440);
//     })->name('responses');

//     Route::get('/redirect', function () {
//         return redirect('/contact');
//     })->name('redirect');

//     Route::get('/back', function () {
//         return back();
//     })->name('back');

//     Route::get('/named-route', function () {
//         return redirect()->route('posts.show', ['id' => 1]);
//     })->name('named-route');

//     Route::get('/away', function () {
//         return redirect()->away('https://google.com');
//     })->name('away');

//     Route::get('/json', function () use ($posts) {
//         return response()->json($posts);
//     })->name('json');

//     Route::get('/download', function () use ($posts) {
//         return response()->download(public_path('/assets/images/MonkeyKing_0.jpg'), 'Monkey_King.jpg');
//     })->name('download');
// });
