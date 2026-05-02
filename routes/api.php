<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::post('/tickets', [TicketController::class, 'store']);
Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
