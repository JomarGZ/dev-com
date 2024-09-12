<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\LikeController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('users/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('users/{user}/{slug?}', [ProfileController::class, 'show'])->name('profile.show');

    Route::resource('posts', PostController::class)->only(['store', 'create']);
    Route::resource('posts.comments', CommentController::class)->shallow()->only(['store', 'destroy', 'update']);

    Route::post('/likes/{type}/{id}', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/likes/{type}/{id}', [LikeController::class, 'destroy'])->name('likes.destroy');
    
    Route::get('cities', [LocationController::class, 'getCities'])->name('get.cities');
});

Route::get('posts/{topic?}', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}/{slug?}', [PostController::class, 'show'])->name('posts.show');