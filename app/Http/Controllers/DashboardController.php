<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tickets = Ticket::with('products')
            ->latest()
            ->paginate(10);

        return view('dashboard.index', [
            'tickets' => $tickets,
        ]);
    }
}
