<?php

namespace App\Services\Normalizer;

use App\Models\ProductAlias;

class ProductNormalizer
{
    public function normalize(array $products): array
    {
        $aliases = ProductAlias::whereIn('alias', array_column($products, 'name'))
            ->pluck('canonical_name', 'alias');

        return array_map(function (array $product) use ($aliases) {
            $product['original_name'] = $product['name'];
            $product['name'] = $aliases[$product['name']] ?? $product['name'];
            return $product;
        }, $products);
    }
}
