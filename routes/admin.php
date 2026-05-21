<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\StockController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    
    // DASHBOARD (Accessible by Owner, Kasir, and Customer - Block Inactive)
    Route::middleware(['role:owner,kasir,customer'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // ==========================================
    // OWNER & KASIR ROUTES (Operational POS)
    // ==========================================
    Route::middleware(['role:owner,kasir'])->group(function () {
        // Stock Overview
        Route::get('/dashboard/stock', [StockController::class, 'index'])->name('admin.stock.index');
        Route::put('/dashboard/stock/{product}', [StockController::class, 'update'])->name('admin.stock.update');

        // POS Cashier
        Route::get('/dashboard/pos', [\App\Http\Controllers\Admin\PosController::class, 'index'])->name('admin.pos.index');
        Route::post('/dashboard/pos/checkout', [\App\Http\Controllers\Admin\PosController::class, 'store'])->name('admin.pos.store');
        Route::get('/dashboard/pos/receipt/{order}', [\App\Http\Controllers\Admin\PosController::class, 'receipt'])->name('admin.pos.receipt');
    });

    // ==========================================
    // OWNER ONLY ROUTES (Admin & Management)
    // ==========================================
    Route::middleware(['role:owner'])->group(function () {
        // Category Management
        Route::get('/dashboard/category/search', [CategoryController::class, 'search'])->name('admin.category.search');
        Route::get('/dashboard/category', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/dashboard/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/dashboard/category', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/dashboard/category/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/dashboard/category/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/dashboard/category/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        Route::post('/dashboard/category/{category}/restore', [CategoryController::class, 'restore'])->withTrashed()->name('admin.category.restore');
        Route::delete('/dashboard/category/{category}/force', [CategoryController::class, 'forceDelete'])->withTrashed()->name('admin.category.forceDelete');

        // Menu Management
        Route::get('/dashboard/menu/search', [MenuController::class, 'search'])->name('admin.menu.search');
        Route::get('/dashboard/menu', [MenuController::class, 'index'])->name('admin.menu.index');
        Route::get('/dashboard/menu/create', [MenuController::class, 'create'])->name('admin.menu.create');
        Route::post('/dashboard/menu', [MenuController::class, 'store'])->name('admin.menu.store');
        Route::get('/dashboard/menu/{product}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
        Route::put('/dashboard/menu/{product}', [MenuController::class, 'update'])->name('admin.menu.update');
        Route::delete('/dashboard/menu/{product}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
        Route::post('/dashboard/menu/{product}/restore', [MenuController::class, 'restore'])->withTrashed()->name('admin.menu.restore');
        Route::delete('/dashboard/menu/{product}/force', [MenuController::class, 'forceDelete'])->withTrashed()->name('admin.menu.forceDelete');

        // Staff Management
        Route::get('/dashboard/staff', [\App\Http\Controllers\Admin\StaffController::class, 'index'])->name('admin.staff.index');
        Route::post('/dashboard/staff', [\App\Http\Controllers\Admin\StaffController::class, 'store'])->name('admin.staff.store');
        Route::put('/dashboard/staff/{id}', [\App\Http\Controllers\Admin\StaffController::class, 'update'])->name('admin.staff.update');
        Route::delete('/dashboard/staff/{id}', [\App\Http\Controllers\Admin\StaffController::class, 'destroy'])->name('admin.staff.destroy');
    });
});
