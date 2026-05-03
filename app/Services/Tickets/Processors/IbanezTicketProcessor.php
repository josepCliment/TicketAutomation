<?php

namespace App\Services\Tickets\Processors;

use App\Services\Tickets\AbstractTicketProcessor;
use App\Services\Tickets\TicketDataDTO;
use Carbon\Carbon;

class IbanezTicketProcessor extends AbstractTicketProcessor
{
    protected function storeName(): string
    {
        return 'Ibañez';
    }

    public function supports(string $storeName): bool
    {
        return str_contains(strtolower($storeName), 'ibanez');
    }

    protected function parse(string $rawText): TicketDataDTO
    {
        return new TicketDataDTO(
            store: 'Ibañez',
            date: $this->extractDate($rawText),
            total: $this->extractTotal($rawText),
            products: $this->extractProducts($rawText),
            processor: static::class,
            rawText: $rawText,
        );
    }

    private function extractDate(string $text): Carbon
    {
        if (preg_match('/(\d{2}\/\d{2}\/\d{4})\s+\d{2}:\d{2}/', $text, $matches)) {
            return Carbon::createFromFormat('d/m/Y', $matches[1]);
        }

        return Carbon::now();
    }

    private function extractTotal(string $text): float
    {
        if (preg_match('/TOTAL\s*[(\[C]EUR[)\]]?\s*[-–]?\s*([\d,]+)/i', $text, $matches)) {
            return (float)str_replace(',', '.', $matches[1]);
        }

        return 0.0;
    }

    /**
     * @return array<int, array{name: string, price: float}>
     */
    private function extractProducts(string $text): array
    {
        $products = [];
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            if (preg_match('/^([A-ZÁÉÍÓÚÑ][A-ZÁÉÍÓÚÑ\s\d\/\-]+?)\s+[\d,]+\s+[Xx]\s+([\d,]+)\s+([\d,]+)\s*$/u', trim($line), $m)) {
                $name = trim($m[1]);

                if (in_array($name, ['MATERIALES', 'TOTAL', ''])) {
                    continue;
                }

                $products[] = [
                    'name' => $name,
                    'price' => (float)str_replace(',', '.', $m[3]),
                ];
            }
        }

        return $products;
    }
}
