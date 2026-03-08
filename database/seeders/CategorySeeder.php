<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Céréales',       'name_mg' => 'Vary sy Katsaka',  'slug' => 'cereales',      'icon' => '🌾'],
            ['name' => 'Légumes',         'name_mg' => 'Anana',            'slug' => 'legumes',        'icon' => '🥬'],
            ['name' => 'Fruits',          'name_mg' => 'Voankazo',         'slug' => 'fruits',         'icon' => '🍉'],
            ['name' => 'Tubercules',      'name_mg' => 'Vary amin-doha',   'slug' => 'tubercules',     'icon' => '🥔'],
            ['name' => 'Légumineuses',    'name_mg' => 'Karaoty sy Tsaramaso', 'slug' => 'legumineuses', 'icon' => '🫘'],
            ['name' => 'Épices',          'name_mg' => 'Lafarinina',       'slug' => 'epices',         'icon' => '🌶️'],
            ['name' => 'Produits laitiers', 'name_mg' => 'Ronono',         'slug' => 'laitiers',       'icon' => '🥛'],
            ['name' => 'Volailles',       'name_mg' => 'Akoho',            'slug' => 'volailles',      'icon' => '🐔'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}