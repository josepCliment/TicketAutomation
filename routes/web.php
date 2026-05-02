<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductAliasController;
use App\Http\Controllers\TicketUIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard & Tickets
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/tickets/create', [TicketUIController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketUIController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{ticket}', [TicketUIController::class, 'show'])->name('tickets.show');
Route::get('/tickets/{ticket}/edit', [TicketUIController::class, 'edit'])->name('tickets.edit');
Route::patch('/tickets/{ticket}', [TicketUIController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{ticket}', [TicketUIController::class, 'destroy'])->name('tickets.destroy');

// Product Aliases
Route::get('/aliases', [ProductAliasController::class, 'index'])->name('aliases.index');
Route::get('/aliases/create', [ProductAliasController::class, 'create'])->name('aliases.create');
Route::post('/aliases', [ProductAliasController::class, 'store'])->name('aliases.store');
Route::get('/aliases/{alias}/edit', [ProductAliasController::class, 'edit'])->name('aliases.edit');
Route::patch('/aliases/{alias}', [ProductAliasController::class, 'update'])->name('aliases.update');
Route::delete('/aliases/{alias}', [ProductAliasController::class, 'destroy'])->name('aliases.destroy');

