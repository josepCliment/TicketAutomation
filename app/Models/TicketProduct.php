<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketProduct extends Model
{
    protected $fillable = ['ticket_id', 'name', 'original_name', 'quantity', 'unit_price', 'price'];

}
