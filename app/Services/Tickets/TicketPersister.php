<?php

namespace App\Services\Tickets;

use App\Enums\TicketStatusEnum;
use App\Models\Ticket;
use App\Services\Normalizer\ProductNormalizer;

class TicketPersister
{
    public function __construct(
        private readonly ProductNormalizer $normalizer,
    ) {}

    public function persist(Ticket $ticket, TicketDataDTO $data): void
    {
        $ticket->update([
            'store'        => $data->store,
            'purchased_at' => $data->date,
            'total'        => $data->total,
            'processor'    => $data->processor,
            'raw_text'     => $data->rawText,
            'status'       => TicketStatusEnum::Processed,
        ]);

        $ticket->products()->createMany(
            $this->normalizer->normalize($data->products)
        );
    }
}
