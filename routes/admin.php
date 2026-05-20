<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Menu Management (Owner Only)
    Route::get('/dashboard/menu/search', [MenuController::class, 'search'])->name('admin.menu.search');
    Route::get('/dashboard/menu', [MenuController::class, 'index'])->name('admin.menu.index');
    Route::get('/dashboard/menu/create', [MenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/dashboard/menu', [MenuController::class, 'store'])->name('admin.menu.store');
    Route::get('/dashboard/menu/{product}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
    Route::put('/dashboard/menu/{product}', [MenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/dashboard/menu/{product}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
    Route::post('/dashboard/menu/{product}/restore', [MenuController::class, 'restore'])->withTrashed()->name('admin.menu.restore');
    Route::delete('/dashboard/menu/{product}/force', [MenuController::class, 'forceDelete'])->withTrashed()->name('admin.menu.forceDelete');
});

