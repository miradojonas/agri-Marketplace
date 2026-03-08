<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MarketPrice;
use Illuminate\Database\Seeder;

class MarketPriceSeeder extends Seeder
{
    public function run(): void
    {
        $cereales = Category::where('slug', 'cereales')->first();
        $legumes  = Category::where('slug', 'legumes')->first();
        $fruits   = Category::where('slug', 'fruits')->first();

        $prices = [
            [
                'category_id'  => $cereales->id,
                'product_name' => 'Riz blanc',
                'region'       => 'Analamanga',
                'min_price'    => 2000,
                'max_price'    => 3000,
                'avg_price'    => 2500,
                'unit'         => 'kg',
                'price_date'   => '2026-03-08',
                'source'       => 'Marché Analakely',
            ],
            [
                'category_id'  => $legumes->id,
                'product_name' => 'Carottes',
                'region'       => 'Vakinankaratra',
                'min_price'    => 1000,
                'max_price'    => 2000,
                'avg_price'    => 1500,
                'unit'         => 'kg',
                'price_date'   => '2026-03-08',
                'source'       => 'Marché Antsirabe',
            ],
            [
                'category_id'  => $fruits->id,
                'product_name' => 'Mangues',
                'region'       => 'Itasy',
                'min_price'    => 600,
                'max_price'    => 1000,
                'avg_price'    => 800,
                'unit'         => 'kg',
                'price_date'   => '2026-03-08',
                'source'       => 'Marché Miarinarivo',
            ],
        ];

        foreach ($prices as $price) {
            MarketPrice::create($price);
        }
    }
}