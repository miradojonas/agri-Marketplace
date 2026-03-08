<?php

namespace Database\Factories;

use App\Models\Farmer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FarmerFactory extends Factory
{
    protected $model = Farmer::class;

    public function definition(): array
    {
        return [
            'user_id'      => User::factory()->state(['role' => 'farmer']),
            'farm_name'    => fake()->company() . ' Farm',
            'phone'        => '+261' . fake()->unique()->numerify('34#######'),
            'region'       => fake()->randomElement([
                'Analamanga', 'Vakinankaratra', 'Itasy', 'Bongolava',
                'Sofia', 'Boeny', 'Betsiboka', 'Melaky',
                'Alaotra-Mangoro', 'Atsinanana', 'Analanjirofo', 'Amoron\'i Mania',
                'Haute Matsiatra', 'Vatovavy-Fitovinany', 'Atsimo-Atsinanana',
                'Ihorombe', 'Menabe', 'Atsimo-Andrefana', 'Androy', 'Anosy',
                'DIANA', 'SAVA',
            ]),
            'district'     => fake()->city(),
            'description'  => fake()->optional()->sentence(),
            'latitude'     => fake()->latitude(-12, -25),
            'longitude'    => fake()->longitude(43, 50),
            'ussd_enabled' => true,
            'ussd_pin'     => fake()->optional()->numerify('####'),
        ];
    }

    public function withoutUssd(): static
    {
        return $this->state(fn(array $attributes) => [
            'ussd_enabled' => false,
            'ussd_pin'     => null,
        ]);
    }
}
