<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    /* Profile Routes (Breeze) */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* Admin Routes */
    Route::prefix('admin')->middleware('role:ADMIN')->controller(AdminController::class)->as('admin.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/{user}/ban', 'ban')->name('ban');
        Route::put('/{user}/unban', 'unban')->name('unban');
        Route::put('/{user}/activate', 'activate')->name('activate');
        Route::put('/{user}/deactivate', 'deactivate')->name('deactivate');
    });

    /* Dashboard */
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    /* Colocation */
    Route::prefix('colocation')->middleware('ensureColocationIsActive')->controller(ColocationController::class)->as('colocation.')->group(function () {
        Route::withoutMiddleware('ensureColocationIsActive')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{colocation}', 'show')->name('show');
        });
        Route::delete('/leave/{colocation}', 'leave')->name('leave')->middleware('colocation:Member');
        Route::delete('/{colocation}', 'destroy')->name('destroy')->middleware('colocation:Owner');

        /* Colocation Category */
        Route::prefix('category')->middleware('colocation:Owner')->controller(CategoryController::class)->as('category.')->group(function () {
            Route::get('/{colocationId}', 'index')->name('index')->withoutMiddleware('ensureColocationIsActive');
            Route::post('/{colocationId}', 'store')->name('store');
            Route::put("/{category}", 'update')->name('update');
            Route::delete('/{category}', 'destroy')->name('destroy');
        });

        /* Members */
        Route::get('/{colocation}/members', 'members')->name('members')->withoutMiddleware('ensureColocationIsActive');
        Route::post('/{colocation}/{colocationMember}/remove', 'removeMember')->name('removeMember')->middleware('colocation:Owner');

        /* Expense Detail */
        Route::put('/{colocation}/{expenseDetail}', 'markPaid')->name('detail.mark-paid');
    });

    /* Invitation Routes */
    Route::prefix('invitation')->controller(InvitationController::class)->as('invite.')->group(function () {
        Route::get('/validate/{tokenValue}', 'validateToken')->name('validateToken'); // Renamed slightly to avoid clash if needed
        Route::get('/invalid', 'invalid')->name('invalid');
        Route::get('/reject', 'reject')->name('reject');
        Route::get('/conflict', 'conflict')->name('conflict');
        Route::post('/refuse', 'refuse')->name('refuse');
        Route::middleware('ensureColocationIsActive')->group(function () {
            Route::get('/accept/{colocationId}', 'accept')->name('accept');
            Route::get('/success/{colocationId}', 'success')->name('success');
            Route::post('/invite/{colocationId}', 'invite')->name('invite')->middleware('colocation:Owner');
            Route::post('/confirm/{colocationId}', 'confirm')->name('confirm');
        });
    });

    /* Expense Routes */
    Route::prefix('expense')->controller(ExpenseController::class)->as( 'expense.')->group(function () {
        Route::post('/', 'store')->name('store');
        Route::put('/{expense}', 'update')->name('update');
        Route::delete('/{expense}', 'destroy')->name('destroy');
    });
});

require __DIR__.'/auth.php';
