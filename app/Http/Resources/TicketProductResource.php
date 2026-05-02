<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'original_name' => $this->original_name,
            'quantity'      => $this->quantity,
            'unit_price'    => $this->unit_price,
            'price'         => $this->price,
        ];
    }
}
