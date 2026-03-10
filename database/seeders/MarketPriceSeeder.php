<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MarketPrice;
use Illuminate\Database\Seeder;

class MarketPriceSeeder extends Seeder
{
    public function run(): void
    {
        $cereales     = Category::where('slug', 'cereales')->first();
        $legumes      = Category::where('slug', 'legumes')->first();
        $fruits       = Category::where('slug', 'fruits')->first();
        $tubercules   = Category::where('slug', 'tubercules')->first();
        $legumineuses = Category::where('slug', 'legumineuses')->first();
        $epices       = Category::where('slug', 'epices')->first();
        $laitiers     = Category::where('slug', 'laitiers')->first();
        $volailles    = Category::where('slug', 'volailles')->first();

        $prices = [
            // ── Céréales ──
            ['category_id' => $cereales->id, 'product_name' => 'Riz blanc', 'region' => 'Analamanga', 'min_price' => 2000, 'max_price' => 3000, 'avg_price' => 2500, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'Marché Analakely'],
            ['category_id' => $cereales->id, 'product_name' => 'Riz blanc', 'region' => 'Vakinankaratra', 'min_price' => 2200, 'max_price' => 2800, 'avg_price' => 2500, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'Marché Antsirabe'],
            ['category_id' => $cereales->id, 'product_name' => 'Riz blanc', 'region' => 'Alaotra-Mangoro', 'min_price' => 1800, 'max_price' => 2400, 'avg_price' => 2100, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'OdR'],
            ['category_id' => $cereales->id, 'product_name' => 'Riz rouge', 'region' => 'Vakinankaratra', 'min_price' => 3000, 'max_price' => 3800, 'avg_price' => 3400, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'OdR'],
            ['category_id' => $cereales->id, 'product_name' => 'Maïs sec', 'region' => 'Alaotra-Mangoro', 'min_price' => 1500, 'max_price' => 2100, 'avg_price' => 1800, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'MAEP'],
            // ── Légumes ──
            ['category_id' => $legumes->id, 'product_name' => 'Tomates', 'region' => 'Analamanga', 'min_price' => 2500, 'max_price' => 4000, 'avg_price' => 3000, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'Enquête terrain'],
            ['category_id' => $legumes->id, 'product_name' => 'Carottes', 'region' => 'Vakinankaratra', 'min_price' => 1000, 'max_price' => 2000, 'avg_price' => 1500, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'Marché Antsirabe'],
            ['category_id' => $legumes->id, 'product_name' => 'Oignons', 'region' => 'Vakinankaratra', 'min_price' => 3500, 'max_price' => 5000, 'avg_price' => 4200, 'unit' => 'kg', 'price_date' => '2026-03-07', 'source' => 'MAEP'],
            // ── Fruits ──
            ['category_id' => $fruits->id, 'product_name' => 'Mangues', 'region' => 'Itasy', 'min_price' => 600, 'max_price' => 1000, 'avg_price' => 800, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'Marché Miarinarivo'],
            ['category_id' => $fruits->id, 'product_name' => 'Litchis', 'region' => 'Atsinanana', 'min_price' => 4000, 'max_price' => 6500, 'avg_price' => 5000, 'unit' => 'kg', 'price_date' => '2026-03-06', 'source' => 'Enquête terrain'],
            ['category_id' => $fruits->id, 'product_name' => 'Bananes', 'region' => 'Atsinanana', 'min_price' => 1200, 'max_price' => 2000, 'avg_price' => 1500, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'MAEP'],
            // ── Tubercules ──
            ['category_id' => $tubercules->id, 'product_name' => 'Manioc', 'region' => 'Analamanga', 'min_price' => 600, 'max_price' => 1000, 'avg_price' => 800, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'MAEP'],
            ['category_id' => $tubercules->id, 'product_name' => 'Pommes de terre', 'region' => 'Vakinankaratra', 'min_price' => 2400, 'max_price' => 3200, 'avg_price' => 2800, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'MAEP'],
            // ── Légumineuses ──
            ['category_id' => $legumineuses->id, 'product_name' => 'Haricots secs', 'region' => 'Vakinankaratra', 'min_price' => 4000, 'max_price' => 5200, 'avg_price' => 4500, 'unit' => 'kg', 'price_date' => '2026-03-07', 'source' => 'OdR'],
            ['category_id' => $legumineuses->id, 'product_name' => 'Arachides', 'region' => 'Alaotra-Mangoro', 'min_price' => 5000, 'max_price' => 7000, 'avg_price' => 6000, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'Enquête terrain'],
            // ── Épices ──
            ['category_id' => $epices->id, 'product_name' => 'Vanille bourbon', 'region' => 'SAVA', 'min_price' => 400000, 'max_price' => 500000, 'avg_price' => 450000, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'Enquête terrain'],
            ['category_id' => $epices->id, 'product_name' => 'Poivre noir', 'region' => 'SAVA', 'min_price' => 75000, 'max_price' => 95000, 'avg_price' => 85000, 'unit' => 'kg', 'price_date' => '2026-03-07', 'source' => 'OdR'],
            ['category_id' => $epices->id, 'product_name' => 'Girofle', 'region' => 'SAVA', 'min_price' => 55000, 'max_price' => 75000, 'avg_price' => 65000, 'unit' => 'kg', 'price_date' => '2026-03-08', 'source' => 'MAEP'],
            // ── Laitiers ──
            ['category_id' => $laitiers->id, 'product_name' => 'Lait frais', 'region' => 'Vakinankaratra', 'min_price' => 1600, 'max_price' => 2400, 'avg_price' => 2000, 'unit' => 'litre', 'price_date' => '2026-03-08', 'source' => 'MAEP'],
            // ── Volailles ──
            ['category_id' => $volailles->id, 'product_name' => 'Poulet fermier', 'region' => 'Itasy', 'min_price' => 15000, 'max_price' => 22000, 'avg_price' => 18000, 'unit' => 'unité', 'price_date' => '2026-03-08', 'source' => 'Enquête terrain'],
            ['category_id' => $volailles->id, 'product_name' => 'Œufs fermiers', 'region' => 'Atsinanana', 'min_price' => 500, 'max_price' => 700, 'avg_price' => 600, 'unit' => 'unité', 'price_date' => '2026-03-08', 'source' => 'MAEP'],
        ];

        foreach ($prices as $price) {
            MarketPrice::create($price);
        }
    }
}