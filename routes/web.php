<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Colocation;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExpenseController;

Route::view('/', 'welcome');

Route::post('colocation/{colocation}/expenses', [ExpenseController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('expenses.store');

Route::get('dashboard', [ColocationController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('colocation/{colocation}', [ColocationController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('colocation.show');

Route::delete('colocation/{colocation}', [ColocationController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('colocation.destroy');

Route::post('colocation/{colocation}/invite', [ColocationController::class, 'invite'])
    ->middleware(['auth', 'verified'])
    ->name('colocation.invite');

Route::post('dashboard', [ColocationController::class, 'store'])->name('colocation.store');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::post('logout', function (\App\Livewire\Actions\Logout $logout) {
    $logout();

    return redirect('/');
})->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/users/{user}/ban', [AdminController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unban'])->name('users.unban');
});

require __DIR__.'/auth.php';
