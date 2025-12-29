<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

// Home/Welcome
Route::get('/', [BlogController::class, 'index']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Blog Routes
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

// Protected Blog Routes (Auth Required)
Route::middleware('auth')->group(function () {
    // Blogs
    Route::get('/blogs/create/new', [BlogController::class, 'create'])->name('blogs.create');
    Route::get('/my-blogs', [BlogController::class, 'myBlogs'])->name('blogs.my');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::post('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::get('/blogs/{id}/delete', [BlogController::class, 'destroy'])->name('blogs.destroy');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/delete', [ProfileController::class, 'destroy']);

    Route::get('/admin/users', [UserController::class, 'index']);
    Route::get('/admin/users/{id}', [UserController::class, 'show']);
    Route::get('/admin/users/{id}/delete', [UserController::class, 'destroy']);

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});