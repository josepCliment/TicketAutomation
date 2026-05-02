<?php

namespace App\Http\Controllers;

use App\Enums\TicketCategoryEnum;
use App\Enums\TicketStatusEnum;
use App\Http\Requests\StoreTicketRequest;
use App\Jobs\ProcessTicket;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class TicketUIController extends Controller
{
    public function create(): View
    {
        return view('tickets.create', [
            'categories' => TicketCategoryEnum::cases(),
        ]);
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $path = $request->file('image')->store('tickets', 'local');

        $ticket = Ticket::create([
            'store'        => $request->string('store'),
            'category'     => $request->input('category', TicketCategoryEnum::Otros->value),
            'purchased_at' => now()->toDateString(),
            'total'        => 0,
            'processor'    => 'pending',
            'status'       => TicketStatusEnum::Queued,
        ]);

        ProcessTicket::dispatch($ticket->id, $path);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket uploaded successfully! Processing will begin shortly.');
    }

    public function show(Ticket $ticket): View
    {
        $ticket->load('products');
        return view('tickets.show', [
            'ticket' => $ticket,
            'categories' => TicketCategoryEnum::cases(),
        ]);
    }

    public function edit(Ticket $ticket): View
    {
        $ticket->load('products');
        return view('tickets.edit', [
            'ticket' => $ticket,
            'categories' => TicketCategoryEnum::cases(),
        ]);
    }

    public function update(Ticket $ticket): RedirectResponse
    {
        $validated = request()->validate([
            'store' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string'],
            'total' => ['required', 'numeric', 'min:0'],
            'purchased_at' => ['required', 'date'],
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Ticket deleted successfully.');
    }
}
