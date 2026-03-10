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
        $farmers    = Farmer::all();
        $cereales   = Category::where('slug', 'cereales')->first();
        $legumes    = Category::where('slug', 'legumes')->first();
        $fruits     = Category::where('slug', 'fruits')->first();
        $tubercules = Category::where('slug', 'tubercules')->first();
        $legumineuses = Category::where('slug', 'legumineuses')->first();
        $epices     = Category::where('slug', 'epices')->first();
        $laitiers   = Category::where('slug', 'laitiers')->first();
        $volailles  = Category::where('slug', 'volailles')->first();

        $products = [
            // ── Céréales ──
            [
                'farmer_id'          => $farmers[0]->id,
                'category_id'        => $cereales->id,
                'name'               => 'Riz blanc premium',
                'name_mg'            => 'Vary fotsy',
                'description'        => 'Riz de qualité supérieure cultivé dans les rizières de Vakinankaratra. Grain long, parfumé, idéal pour le vary maina.',
                'price'              => 2500,
                'unit'               => 'kg',
                'quantity_available' => 500,
                'image'              => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-02-15',
            ],
            [
                'farmer_id'          => $farmers[2]->id,
                'category_id'        => $cereales->id,
                'name'               => 'Riz rouge',
                'name_mg'            => 'Vary mena',
                'description'        => 'Riz rouge de l\'Alaotra, riche en fibres et en fer. Goût unique et terroir authentique.',
                'price'              => 3500,
                'unit'               => 'kg',
                'quantity_available' => 300,
                'image'              => 'https://images.unsplash.com/photo-1536304993881-3e372d29dc4e?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-02-10',
            ],
            [
                'farmer_id'          => $farmers[2]->id,
                'category_id'        => $cereales->id,
                'name'               => 'Maïs sec',
                'name_mg'            => 'Katsaka maina',
                'description'        => 'Maïs séché au soleil, parfait pour la farine ou la consommation directe.',
                'price'              => 1800,
                'unit'               => 'kg',
                'quantity_available' => 600,
                'image'              => 'https://images.unsplash.com/photo-1551754655-cd27e38d2076?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-01-20',
            ],
            // ── Légumes ──
            [
                'farmer_id'          => $farmers[0]->id,
                'category_id'        => $legumes->id,
                'name'               => 'Carottes fraîches',
                'name_mg'            => 'Karaoty',
                'description'        => 'Carottes bio cultivées sans pesticides dans les hautes terres de Vakinankaratra.',
                'price'              => 1500,
                'unit'               => 'kg',
                'quantity_available' => 200,
                'image'              => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-03-01',
            ],
            [
                'farmer_id'          => $farmers[0]->id,
                'category_id'        => $legumes->id,
                'name'               => 'Tomates fraîches',
                'name_mg'            => 'Voatabia',
                'description'        => 'Tomates mûries sur pied, juteuses et parfumées. Culture raisonnée.',
                'price'              => 3000,
                'unit'               => 'kg',
                'quantity_available' => 150,
                'image'              => 'https://images.unsplash.com/photo-1592924357228-91a4daadce55?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-03-05',
            ],
            [
                'farmer_id'          => $farmers[0]->id,
                'category_id'        => $legumes->id,
                'name'               => 'Oignons',
                'name_mg'            => 'Tongolo',
                'description'        => 'Oignons secs de bonne conservation, cultivés à Antsirabe.',
                'price'              => 4200,
                'unit'               => 'kg',
                'quantity_available' => 250,
                'image'              => 'https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-02-25',
            ],
            // ── Fruits ──
            [
                'farmer_id'          => $farmers[1]->id,
                'category_id'        => $fruits->id,
                'name'               => 'Mangues mûres',
                'name_mg'            => 'Manga masaka',
                'description'        => 'Mangues sucrées de la région Itasy, variété locale très parfumée.',
                'price'              => 800,
                'unit'               => 'kg',
                'quantity_available' => 300,
                'image'              => 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-03-05',
            ],
            [
                'farmer_id'          => $farmers[4]->id,
                'category_id'        => $fruits->id,
                'name'               => 'Litchis frais',
                'name_mg'            => 'Letchi',
                'description'        => 'Litchis de la côte est, cueillis à maturité. Chair juteuse et parfumée.',
                'price'              => 5000,
                'unit'               => 'kg',
                'quantity_available' => 180,
                'image'              => 'https://images.unsplash.com/photo-1577234286642-fc512a5f8f11?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-01-15',
            ],
            [
                'farmer_id'          => $farmers[4]->id,
                'category_id'        => $fruits->id,
                'name'               => 'Bananes',
                'name_mg'            => 'Akondro',
                'description'        => 'Bananes dessert de Toamasina. Cultivées naturellement.',
                'price'              => 1500,
                'unit'               => 'kg',
                'quantity_available' => 400,
                'image'              => 'https://images.unsplash.com/photo-1603833665858-e61d17a86224?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-03-02',
            ],
            // ── Tubercules ──
            [
                'farmer_id'          => $farmers[1]->id,
                'category_id'        => $tubercules->id,
                'name'               => 'Pommes de terre',
                'name_mg'            => 'Ovy',
                'description'        => 'Pommes de terre de montagne, fermes et savoureuses. Idéales en ragoût.',
                'price'              => 2800,
                'unit'               => 'kg',
                'quantity_available' => 400,
                'image'              => 'https://images.unsplash.com/photo-1518977676601-b53f82ber633?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-02-20',
            ],
            [
                'farmer_id'          => $farmers[1]->id,
                'category_id'        => $tubercules->id,
                'name'               => 'Manioc frais',
                'name_mg'            => 'Mangahazo',
                'description'        => 'Manioc frais récolté le jour même. Base de l\'alimentation malgache.',
                'price'              => 800,
                'unit'               => 'kg',
                'quantity_available' => 700,
                'image'              => 'https://images.unsplash.com/photo-1590165482129-1b8b27698780?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-03-07',
            ],
            // ── Légumineuses ──
            [
                'farmer_id'          => $farmers[0]->id,
                'category_id'        => $legumineuses->id,
                'name'               => 'Haricots secs',
                'name_mg'            => 'Tsaramaso maina',
                'description'        => 'Haricots blancs secs de qualité, riches en protéines. Récoltés à Antsirabe.',
                'price'              => 4500,
                'unit'               => 'kg',
                'quantity_available' => 150,
                'image'              => 'https://images.unsplash.com/photo-1551462147-ff29053bfc14?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-02-01',
            ],
            [
                'farmer_id'          => $farmers[2]->id,
                'category_id'        => $legumineuses->id,
                'name'               => 'Arachides',
                'name_mg'            => 'Pistasy',
                'description'        => 'Arachides grillées ou crues, production locale de l\'Alaotra.',
                'price'              => 6000,
                'unit'               => 'kg',
                'quantity_available' => 100,
                'image'              => 'https://images.unsplash.com/photo-1567892320421-1c657571ea4a?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-01-25',
            ],
            // ── Épices ──
            [
                'farmer_id'          => $farmers[3]->id,
                'category_id'        => $epices->id,
                'name'               => 'Vanille bourbon',
                'name_mg'            => 'Lavanila',
                'description'        => 'Vanille bourbon de la SAVA, la meilleure au monde. Gousses de 16-18cm, taux de vanilline élevé.',
                'price'              => 450000,
                'unit'               => 'kg',
                'quantity_available' => 10,
                'image'              => 'https://images.unsplash.com/photo-1631209121750-a9f656d38a5d?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-01-10',
            ],
            [
                'farmer_id'          => $farmers[3]->id,
                'category_id'        => $epices->id,
                'name'               => 'Poivre noir',
                'name_mg'            => 'Dipoavatra mainty',
                'description'        => 'Poivre noir de Madagascar, arôme puissant et piquant. Séché naturellement.',
                'price'              => 85000,
                'unit'               => 'kg',
                'quantity_available' => 25,
                'image'              => 'https://images.unsplash.com/photo-1599909533601-2eb10ca1b28c?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-02-05',
            ],
            [
                'farmer_id'          => $farmers[3]->id,
                'category_id'        => $epices->id,
                'name'               => 'Girofle',
                'name_mg'            => 'Jirofo',
                'description'        => 'Clous de girofle de qualité export, récoltés à la main dans la SAVA.',
                'price'              => 65000,
                'unit'               => 'kg',
                'quantity_available' => 30,
                'image'              => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-01-30',
            ],
            // ── Produits laitiers ──
            [
                'farmer_id'          => $farmers[0]->id,
                'category_id'        => $laitiers->id,
                'name'               => 'Lait frais de vache',
                'name_mg'            => 'Ronono vaovao',
                'description'        => 'Lait frais de vache collecté chaque matin. Riche et crémeux.',
                'price'              => 2000,
                'unit'               => 'litre',
                'quantity_available' => 50,
                'image'              => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-03-08',
            ],
            // ── Volailles ──
            [
                'farmer_id'          => $farmers[1]->id,
                'category_id'        => $volailles->id,
                'name'               => 'Poulet fermier',
                'name_mg'            => 'Akoho gasy',
                'description'        => 'Poulet fermier élevé en plein air, nourri aux grains. Chair ferme et goûteuse.',
                'price'              => 18000,
                'unit'               => 'unité',
                'quantity_available' => 20,
                'image'              => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-03-06',
            ],
            [
                'farmer_id'          => $farmers[4]->id,
                'category_id'        => $volailles->id,
                'name'               => 'Œufs fermiers',
                'name_mg'            => 'Atody gasy',
                'description'        => 'Œufs de poules élevées en liberté. Lot de 30 œufs frais.',
                'price'              => 600,
                'unit'               => 'unité',
                'quantity_available' => 200,
                'image'              => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=800',
                'status'             => 'available',
                'harvest_date'       => '2026-03-08',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}