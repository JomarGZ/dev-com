<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\User\FriendController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ProfileController;
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


    Route::prefix('profiles')->name('profiles.')->group(function () {
        Route::get('', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::get('/{user}/{slug?}', [ProfileController::class, 'show'])->name('show');
    });
    Route::prefix('friends')->name('friends.')->group(function () {
        Route::get('', [FriendController::class, 'index'])->name('index');
        Route::post('{user}/add', [FriendController::class, 'store'])->name('store');
        Route::put('{user}/accept', [FriendController::class, 'update'])->name('update');
        Route::delete('{user}/delete', [FriendController::class, 'destroy'])->name('destroy');
        Route::delete('{user}/deny', [FriendController::class, 'deny'])->name('deny');
    });
       
    Route::resource('/posts', PostController::class)->only(['store', 'edit', 'update', 'destroy']);
    
    Route::get('cities', [LocationController::class, 'getCities'])->name('get.cities');

    Route::prefix('notifications')->group(function () {
        Route::put('/{id}', [NotificationController::class, 'update'])->name('notifications.update');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
});
