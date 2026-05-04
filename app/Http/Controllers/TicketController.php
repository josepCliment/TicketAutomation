<?php

namespace App\Http\Controllers;

use App\Enums\TicketCategoryEnum;
use App\Enums\TicketStatusEnum;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Jobs\ProcessTicket;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class TicketController extends Controller
{
    public function store(StoreTicketRequest $request): JsonResponse
    {
        $path = $request->file('image')->store('tickets', 'local');

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'store'        => $request->string('store'),
            'category'     => $request->input('category', TicketCategoryEnum::Otros->value),
            'purchased_at' => now()->toDateString(),
            'total'        => 0,
            'processor'    => 'pending',
            'status'       => TicketStatusEnum::Queued,
        ]);

        ProcessTicket::dispatch($ticket->id, $path);

        return response()->json([
            'id'     => $ticket->id,
            'status' => $ticket->status->value,
        ], 202);
    }

    public function show(Ticket $ticket): JsonResponse
    {
        $this->authorize('view', $ticket);

        return (new TicketResource($ticket->load('products')))->response();
    }
}
