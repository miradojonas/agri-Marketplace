<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Farmer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'farmer_id'          => Farmer::factory(),
            'category_id'        => Category::factory(),
            'name'               => fake()->randomElement([
                'Riz blanc', 'Riz rouge', 'Maïs sec', 'Manioc frais',
                'Tomates', 'Oignons', 'Haricots secs', 'Pommes de terre',
                'Vanille', 'Poivre noir', 'Café vert', 'Litchi',
                'Bananes', 'Carottes', 'Arachides', 'Girofle',
            ]),
            'name_mg'            => null,
            'description'        => fake()->optional()->sentence(),
            'price'              => fake()->randomFloat(2, 500, 50000),
            'unit'               => fake()->randomElement(['kg', 'litre', 'unité']),
            'quantity_available' => fake()->randomFloat(2, 1, 1000),
            'image'              => null,
            'status'             => 'available',
            'harvest_date'       => fake()->optional()->dateTimeBetween('-1 month', '+1 month'),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'status'             => 'out_of_stock',
            'quantity_available' => 0,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'pending',
        ]);
    }
}
