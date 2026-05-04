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
        ProductAlias::updateOrCreate([
            ['alias' => 'TJ CURV PAJA FLAM', 'canonical_name' => 'TEJA CURVA AITANA', 'created_at' => now(), 'updated_at' => now()],
            ['alias' => 'ARLITA LIGHT PLUS 10-20MM', 'canonical_name' => 'ARLITA 10-10MM', 'created_at' => now(), 'updated_at' => now()],
            ['alias' => 'ESPUMA POLIURET 650ML MANUAL', 'canonical_name' => 'ESPUMA POLIURETANO EXPANDIBLE', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
