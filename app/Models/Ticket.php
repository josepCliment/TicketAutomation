<?php

namespace App\Models;

use App\Enums\TicketCategoryEnum;
use App\Enums\TicketStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'store',
        'category',
        'purchased_at',
        'total',
        'processor',
        'raw_text',
        'status',
    ];

    protected $casts = [
        'category'     => TicketCategoryEnum::class,
        'status'       => TicketStatusEnum::class,
        'purchased_at' => 'date',
        'total'        => 'decimal:2',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(TicketProduct::class);
    }
}
