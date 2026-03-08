<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Riz', 'Maïs', 'Manioc', 'Légumes', 'Fruits',
            'Épices', 'Vanille', 'Café', 'Cacao', 'Litchi',
            'Haricots', 'Pommes de terre', 'Tomates', 'Oignons',
            'Arachides', 'Poivre', 'Girofle', 'Cannelle',
        ]);

        return [
            'name'        => $name,
            'name_mg'     => null,
            'slug'        => Str::slug($name),
            'description' => fake()->optional()->sentence(),
            'icon'        => null,
            'is_active'   => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
