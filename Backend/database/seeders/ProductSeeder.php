<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Вода питьевая 0.5L', 'description' => 'Негазированная', 'price' => 150],
            ['name' => 'Coca-Cola 0.5L', 'description' => 'Газированный напиток', 'price' => 200],
            ['name' => 'Чипсы Lays', 'description' => 'Сыр', 'price' => 250],
            ['name' => 'Шоколадный батончик', 'description' => 'Молочный шоколад', 'price' => 180],
            ['name' => 'Сок J7 яблоко', 'description' => 'Прямой отжим', 'price' => 220],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['name' => $product['name']], $product);
        }
    }
}