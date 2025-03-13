<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SacredplaceController;
use App\Models\Sacredplace;


Route::get('/', [SacredplaceController::class, 'index'])->name('home');

Route::get('/api/sacredplaces', [SacredplaceController::class, 'apiIndex'])->name('api.sacredplaces');

Route::get('/sacredplaces/{sacredplace}', [SacredplaceController::class, 'show'])->name('sacredplaces.show');
