<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Colocation;
use App\Http\Controllers\ColocationController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('dashboard', [ColocationController::class, 'store'])->name('colocation.store');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');



require __DIR__.'/auth.php';
