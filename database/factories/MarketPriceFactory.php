<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\MarketPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketPriceFactory extends Factory
{
    protected $model = MarketPrice::class;

    public function definition(): array
    {
        $minPrice = fake()->randomFloat(2, 500, 10000);
        $maxPrice = $minPrice + fake()->randomFloat(2, 200, 5000);

        return [
            'category_id'  => Category::factory(),
            'product_name' => fake()->randomElement([
                'Riz blanc', 'Riz rouge', 'Maïs', 'Manioc',
                'Tomates', 'Oignons', 'Haricots', 'Pommes de terre',
                'Vanille', 'Poivre', 'Café', 'Litchi',
            ]),
            'region'       => fake()->randomElement([
                'Analamanga', 'Vakinankaratra', 'Itasy', 'Bongolava',
                'Sofia', 'Boeny', 'Betsiboka', 'Alaotra-Mangoro',
                'Atsinanana', 'Haute Matsiatra', 'Menabe',
                'Atsimo-Andrefana', 'DIANA', 'SAVA',
            ]),
            'min_price'    => $minPrice,
            'max_price'    => $maxPrice,
            'avg_price'    => round(($minPrice + $maxPrice) / 2, 2),
            'unit'         => fake()->randomElement(['kg', 'litre', 'unité']),
            'price_date'   => fake()->dateTimeBetween('-1 week', 'now'),
            'source'       => fake()->optional()->randomElement(['OdR', 'MAEP', 'Enquête terrain']),
        ];
    }
}
