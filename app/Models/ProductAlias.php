<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAlias extends Model
{
    protected $fillable = ['alias', 'canonical_name'];
}
