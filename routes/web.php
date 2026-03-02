<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Colocation;
use App\Http\Controllers\ColocationController;

Route::view('/', 'welcome');

Route::get('dashboard', [ColocationController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('colocation/{colocation}', [ColocationController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('colocation.show');

Route::delete('colocation/{colocation}', [ColocationController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('colocation.destroy');

Route::post('dashboard', [ColocationController::class, 'store'])->name('colocation.store');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::post('logout', function (\App\Livewire\Actions\Logout $logout) {
    $logout();

    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';
