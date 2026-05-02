<?php

namespace App\Services\Tickets;

use Carbon\Carbon;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Laravel\Facades\Gemini;

abstract class AbstractTicketProcessor
{

    public function process(string $imagePath): TicketDataDTO
    {
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = MimeType::from(mime_content_type($imagePath));

        $response = Gemini::generativeModel(model: 'models/gemini-2.5-flash')
            ->generateContent([
                new Blob(mimeType: $mimeType, data: $imageData),
                $this->prompt(),
            ]);

        $rawText = $this->stripMarkdown($response->text());
        $json    = json_decode($rawText, true);

        return new TicketDataDTO(
            store: $this->storeName(),
            date: !empty($json['date']) ? Carbon::parse($json['date']) : Carbon::today(),
            total: (float)$json['total'],
            products: $json['products'],
            processor: static::class,
            rawText: $response->text(),
        );
    }

    private function stripMarkdown(string $text): string
    {
        return trim(preg_replace('/^```json\s*|\s*```$/m', '', trim($text)));
    }
    abstract public function supports(string $storeName): bool;

    protected function prompt(): string
    {
        return <<<PROMPT
        Extract the following fields from this receipt image and return ONLY a valid JSON object, no explanation, no markdown:
        {
              "date": "<date from the receipt in YYYY-MM-DD format, or null if not found>",
              "total": "<total amount as a number>",
              "products": [
                { "name": "<product name>", "quantity": "<quantity as integer>", "unit_price": "<unit price as number>", "price": "<line total as number>" }
              ]
            }
        PROMPT;
    }

    abstract protected function storeName(): string;
}
