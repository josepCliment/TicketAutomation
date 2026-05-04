<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'slug', 'match_keywords', 'active'];

    protected $casts = [
        'match_keywords' => 'array',
        'active'         => 'bool',
    ];

    public function matches(string $storeName): bool
    {
        $haystack = strtolower($storeName);

        foreach ($this->match_keywords as $keyword) {
            if (str_contains($haystack, strtolower($keyword))) {
                return true;
            }
        }

        return false;
    }
}
