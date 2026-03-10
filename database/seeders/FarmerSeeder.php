<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\User;
use Illuminate\Database\Seeder;

class FarmerSeeder extends Seeder
{
    public function run(): void
    {
        $rakoto = User::where('phone', '+261340000002')->first();
        $rasoa  = User::where('phone', '+261340000003')->first();
        $andry  = User::where('phone', '+261340000005')->first();
        $fara   = User::where('phone', '+261340000006')->first();
        $solo   = User::where('phone', '+261340000007')->first();

        Farmer::create([
            'user_id'      => $rakoto->id,
            'farm_name'    => 'Ferme Rakoto',
            'phone'        => '+261340000002',
            'region'       => 'Vakinankaratra',
            'district'     => 'Antsirabe I',
            'description'  => 'Producteur de riz et légumes depuis 10 ans',
            'latitude'     => -19.8659,
            'longitude'    => 47.0333,
            'ussd_enabled' => true,
            'ussd_pin'     => '1234',
        ]);

        Farmer::create([
            'user_id'      => $rasoa->id,
            'farm_name'    => 'Jardin Rasoa',
            'phone'        => '+261340000003',
            'region'       => 'Itasy',
            'district'     => 'Miarinarivo',
            'description'  => 'Spécialiste en fruits et tubercules',
            'latitude'     => -19.0000,
            'longitude'    => 46.7333,
            'ussd_enabled' => true,
            'ussd_pin'     => '5678',
        ]);

        Farmer::create([
            'user_id'      => $andry->id,
            'farm_name'    => 'Rizière Andry',
            'phone'        => '+261340000005',
            'region'       => 'Alaotra-Mangoro',
            'district'     => 'Ambatondrazaka',
            'description'  => 'Le grenier à riz de Madagascar, production familiale depuis 3 générations',
            'latitude'     => -17.8333,
            'longitude'    => 48.4167,
            'ussd_enabled' => true,
            'ussd_pin'     => '9012',
        ]);

        Farmer::create([
            'user_id'      => $fara->id,
            'farm_name'    => 'Plantation Fara',
            'phone'        => '+261340000006',
            'region'       => 'SAVA',
            'district'     => 'Antalaha',
            'description'  => 'Productrice de vanille et épices premium de la SAVA',
            'latitude'     => -14.9000,
            'longitude'    => 50.2833,
            'ussd_enabled' => true,
            'ussd_pin'     => '3456',
        ]);

        Farmer::create([
            'user_id'      => $solo->id,
            'farm_name'    => 'Ferme Côte Est',
            'phone'        => '+261340000007',
            'region'       => 'Atsinanana',
            'district'     => 'Toamasina II',
            'description'  => 'Fruits tropicaux et cultures de rente de la côte est',
            'latitude'     => -18.1443,
            'longitude'    => 49.3958,
            'ussd_enabled' => true,
            'ussd_pin'     => '7890',
        ]);
    }
}