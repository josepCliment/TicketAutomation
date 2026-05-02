<?php

namespace App\Services\Tickets;

class TicketProcessorRegistry
{

    /**
     * @param iterable<AbstractTicketProcessor> $processors
     */
    public function __construct(
        private readonly iterable $processors,
    ) {}

    public function resolve(string $storeName): AbstractTicketProcessor
    {
        foreach ($this->processors as $processor) {
            if ($processor->supports($storeName)) {
                return $processor;
            }
        }

        throw new \RuntimeException("No processor found for store: {$storeName}");
    }
}
