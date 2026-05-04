<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        Store::updateOrCreate(['slug' => 'obramat'], [
            'name'           => 'Obramat',
            'match_keywords' => ['obramat'],
        ]);

        Store::updateOrCreate(['slug' => 'ibanez'], [
            'name'           => 'Ibañez',
            'match_keywords' => ['ibanez', 'ibañez'],
        ]);

        $categories = [
            'Tejado', 'Fontanería', 'Electricidad', 'Patio', 'Cuadra', 'Otros',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => \Str::slug($name)],
                ['name' => $name],
            );
        }
    }
}
