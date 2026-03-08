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
    }
}