<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
// use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\LangController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::get('/dashboard', function () {

    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user-logout', [AuthenticatedSessionController::class, 'logout'])->name('userlogout');
});



// Users
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::post('changeStatus/{id}', [UserController::class, 'ChangeUserStatus'])->name('changeStatus');
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
});

Route::post('language-change/', [LangController::class, 'languageChange'])->name('language.change');
require __DIR__.'/auth.php';
// Route::resource('users',UserController::class);