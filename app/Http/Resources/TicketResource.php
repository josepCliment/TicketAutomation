<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'store'        => $this->store,
            'category'     => $this->category->value,
            'purchased_at' => $this->purchased_at->toDateString(),
            'total'        => $this->total,
            'status'       => $this->status->value,
            'products'     => TicketProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
