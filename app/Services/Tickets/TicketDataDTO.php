<?php

namespace App\Services\Tickets;

use App\Enums\TicketCategoryEnum;
use Carbon\Carbon;

final class TicketDataDTO
{
    /**
     * @param array<int, array{name: string, price: float}> $products
     */
    public function __construct(
        public readonly string             $store,
        public readonly Carbon             $date,
        public readonly float              $total,
        public readonly array              $products,
        public readonly string             $processor,
        public readonly ?string            $rawText = null,
    ) {}
}
