<?php

namespace App\Services\Tickets;

use App\Models\Store;

class StoreResolver
{
    public function resolve(string $storeName): Store
    {
        $stores = Store::where('active', true)->get();

        foreach ($stores as $store) {
            if ($store->matches($storeName)) {
                return $store;
            }
        }

        throw new \RuntimeException("No store found for: {$storeName}");
    }
}
