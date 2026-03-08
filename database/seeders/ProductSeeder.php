<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Farmer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $farmer1   = Farmer::first();
        $farmer2   = Farmer::skip(1)->first();
        $cereales  = Category::where('slug', 'cereales')->first();
        $legumes   = Category::where('slug', 'legumes')->first();
        $fruits    = Category::where('slug', 'fruits')->first();
        $tubercules = Category::where('slug', 'tubercules')->first();

        $products = [
            [
                'farmer_id'          => $farmer1->id,
                'category_id'        => $cereales->id,
                'name'               => 'Riz blanc',
                'name_mg'            => 'Vary fotsy',
                'description'        => 'Riz de qualité supérieure, récolte 2026',
                'price'              => 2500,
                'unit'               => 'kg',
                'quantity_available' => 500,
                'status'             => 'available',
                'harvest_date'       => '2026-02-15',
            ],
            [
                'farmer_id'          => $farmer1->id,
                'category_id'        => $legumes->id,
                'name'               => 'Carottes',
                'name_mg'            => 'Karaoty',
                'description'        => 'Carottes fraîches cultivées sans pesticides',
                'price'              => 1500,
                'unit'               => 'kg',
                'quantity_available' => 200,
                'status'             => 'available',
                'harvest_date'       => '2026-03-01',
            ],
            [
                'farmer_id'          => $farmer2->id,
                'category_id'        => $fruits->id,
                'name'               => 'Mangues',
                'name_mg'            => 'Manga',
                'description'        => 'Mangues sucrées de la région Itasy',
                'price'              => 800,
                'unit'               => 'kg',
                'quantity_available' => 300,
                'status'             => 'available',
                'harvest_date'       => '2026-03-05',
            ],
            [
                'farmer_id'          => $farmer2->id,
                'category_id'        => $tubercules->id,
                'name'               => 'Pommes de terre',
                'name_mg'            => 'Patata',
                'description'        => 'Pommes de terre de montagne',
                'price'              => 1200,
                'unit'               => 'kg',
                'quantity_available' => 400,
                'status'             => 'available',
                'harvest_date'       => '2026-02-20',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}