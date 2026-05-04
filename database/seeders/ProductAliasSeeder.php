<?php

namespace Database\Seeders;

use App\Models\ProductAlias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAliasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aliases = [
            ['alias' => 'TJ CURV PAJA FLAM', 'canonical_name' => 'TEJA CURVA AITANA'],
            ['alias' => 'ARLITA LIGHT PLUS 10-20MM', 'canonical_name' => 'ARLITA 10-10MM'],
            ['alias' => 'ESPUMA POLIURET 650ML MANUAL', 'canonical_name' => 'ESPUMA POLIURETANO EXPANDIBLE'],
        ];

        foreach ($aliases as $row) {
            ProductAlias::updateOrCreate(
                ['alias' => $row['alias']],
                ['canonical_name' => $row['canonical_name']],
            );
        }
    }
}
