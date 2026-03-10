<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@agri-marketplace.mg',
            'phone'    => '+261340000001',
            'role'     => 'admin',
            'password' => Hash::make('password'),
            'region'   => 'Analamanga',
        ]);

        // Agriculteurs
        User::create([
            'name'     => 'Rakoto Jean',
            'email'    => 'rakoto@example.mg',
            'phone'    => '+261340000002',
            'role'     => 'farmer',
            'password' => Hash::make('password'),
            'region'   => 'Vakinankaratra',
        ]);

        User::create([
            'name'     => 'Rasoa Marie',
            'email'    => 'rasoa@example.mg',
            'phone'    => '+261340000003',
            'role'     => 'farmer',
            'password' => Hash::make('password'),
            'region'   => 'Itasy',
        ]);

        User::create([
            'name'     => 'Andry Nirina',
            'email'    => 'andry@example.mg',
            'phone'    => '+261340000005',
            'role'     => 'farmer',
            'password' => Hash::make('password'),
            'region'   => 'Alaotra-Mangoro',
        ]);

        User::create([
            'name'     => 'Fara Lova',
            'email'    => 'fara@example.mg',
            'phone'    => '+261340000006',
            'role'     => 'farmer',
            'password' => Hash::make('password'),
            'region'   => 'SAVA',
        ]);

        User::create([
            'name'     => 'Solo Haja',
            'email'    => 'solo@example.mg',
            'phone'    => '+261340000007',
            'role'     => 'farmer',
            'password' => Hash::make('password'),
            'region'   => 'Atsinanana',
        ]);

        // Acheteurs
        User::create([
            'name'     => 'Restaurant Colbert',
            'email'    => 'colbert@example.mg',
            'phone'    => '+261340000004',
            'role'     => 'buyer',
            'password' => Hash::make('password'),
            'region'   => 'Analamanga',
        ]);

        User::create([
            'name'     => 'Hôtel Sakamanga',
            'email'    => 'sakamanga@example.mg',
            'phone'    => '+261340000008',
            'role'     => 'buyer',
            'password' => Hash::make('password'),
            'region'   => 'Analamanga',
        ]);
    }
}