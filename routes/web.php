<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SacredplaceController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Models\Sacredplace;


Route::get('/', [SacredplaceController::class, 'index'])->name('home');

Route::get('/api/sacredplaces', [SacredplaceController::class, 'apiIndex'])->name('api.sacredplaces');
Route::get('/api/tags', [TagController::class, 'apiIndex'])->name('api.tags');

// CRUD routes for sacred places
Route::resource('sacredplaces', SacredplaceController::class);

// CRUD routes for tags
Route::resource('tags', TagController::class);

// CRUD routes for reviews
Route::resource('reviews', ReviewController::class);

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
