<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductAliasController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TicketUIController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard & Tickets
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tickets/create', [TicketUIController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketUIController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketUIController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketUIController::class, 'edit'])->name('tickets.edit');
    Route::patch('/tickets/{ticket}', [TicketUIController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketUIController::class, 'destroy'])->name('tickets.destroy');
    Route::delete('/tickets/{ticket}/products/{product}', [TicketUIController::class, 'destroyProduct'])->name('products.destroy');

    // Product Aliases
    Route::get('/aliases', [ProductAliasController::class, 'index'])->name('aliases.index');
    Route::get('/aliases/create', [ProductAliasController::class, 'create'])->name('aliases.create');
    Route::post('/aliases', [ProductAliasController::class, 'store'])->name('aliases.store');
    Route::get('/aliases/{alias}/edit', [ProductAliasController::class, 'edit'])->name('aliases.edit');
    Route::patch('/aliases/{alias}', [ProductAliasController::class, 'update'])->name('aliases.update');
    Route::delete('/aliases/{alias}', [ProductAliasController::class, 'destroy'])->name('aliases.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Stores
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::patch('/stores/{store}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{store}', [StoreController::class, 'destroy'])->name('stores.destroy');
});

