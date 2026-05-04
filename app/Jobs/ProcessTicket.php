<?php

namespace App\Jobs;

use App\Enums\TicketStatusEnum;
use App\Models\Ticket;
use App\Services\Tickets\StoreResolver;
use App\Services\Tickets\TicketPersister;
use App\Services\Tickets\TicketProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProcessTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;
    public int $tries = 2;

    public function __construct(
        public readonly int    $ticketId,
        public readonly string $imagePath,
    )
    {
    }

    public function handle(
        StoreResolver $storeResolver,
        TicketProcessor $processor,
        TicketPersister $persister,
    ): void {
        $ticket = Ticket::findOrFail($this->ticketId);
        $ticket->update(['status' => TicketStatusEnum::Processing]);

        $absolutePath = Storage::disk('local')->path($this->imagePath);

        $store = $storeResolver->resolve($ticket->store);
        $data  = $processor->process($absolutePath, $store);

        $persister->persist($ticket, $data);

        Storage::disk('local')->delete($this->imagePath);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Ticket processing failed', [
            'ticket_id' => $this->ticketId,
            'error' => $exception->getMessage(),
        ]);

        Ticket::where('id', $this->ticketId)
            ->update(['status' => TicketStatusEnum::Failed]);

        Storage::disk('local')->delete($this->imagePath);
    }
}
