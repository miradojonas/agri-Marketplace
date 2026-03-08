<?php

namespace Tests\Feature\Ussd;

use App\Models\Category;
use App\Models\Farmer;
use App\Models\MarketPrice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UssdTest extends TestCase
{
    use RefreshDatabase;

    private function createFarmer(): Farmer
    {
        $user = User::factory()->create([
            'role'  => 'farmer',
            'phone' => '+261340000002',
        ]);

        return Farmer::factory()->create([
            'user_id' => $user->id,
            'phone'   => '+261340000002',
            'region'  => 'Vakinankaratra',
        ]);
    }

    public function test_menu_principal_saffiche(): void
    {
        $response = $this->postJson('/api/ussd', [
            'sessionId'   => 'sess001',
            'phoneNumber' => '+261340000002',
            'text'        => '',
        ]);

        $response->assertStatus(200);
        $this->assertStringContainsString('CON Bienvenue sur AgriMarketplace', $response->getContent());
    }

    public function test_option_1_demande_nom_produit(): void
    {
        $this->createFarmer();

        $response = $this->postJson('/api/ussd', [
            'sessionId'   => 'sess002',
            'phoneNumber' => '+261340000002',
            'text'        => '1',
        ]);

        $this->assertStringContainsString('CON Publier un produit', $response->getContent());
    }

    public function test_option_2_affiche_categories_prix(): void
    {
        $response = $this->postJson('/api/ussd', [
            'sessionId'   => 'sess003',
            'phoneNumber' => '+261340000002',
            'text'        => '2',
        ]);

        $this->assertStringContainsString('CON Prix du marche', $response->getContent());
        $this->assertStringContainsString('1. Riz', $response->getContent());
    }

    public function test_option_2_affiche_prix_riz(): void
    {
        $category = Category::factory()->create();
        MarketPrice::factory()->create([
            'category_id'  => $category->id,
            'product_name' => 'Riz blanc',
            'min_price'    => 2000,
            'max_price'    => 3000,
            'avg_price'    => 2500,
            'price_date'   => now()->toDateString(),
        ]);

        $response = $this->postJson('/api/ussd', [
            'sessionId'   => 'sess004',
            'phoneNumber' => '+261340000002',
            'text'        => '2*1',
        ]);

        $this->assertStringContainsString('END Prix: Riz blanc', $response->getContent());
    }

    public function test_option_4_affiche_compte(): void
    {
        $this->createFarmer();

        $response = $this->postJson('/api/ussd', [
            'sessionId'   => 'sess005',
            'phoneNumber' => '+261340000002',
            'text'        => '4',
        ]);

        $this->assertStringContainsString('END Mon compte', $response->getContent());
    }

    public function test_numero_inconnu_recoit_erreur(): void
    {
        $response = $this->postJson('/api/ussd', [
            'sessionId'   => 'sess006',
            'phoneNumber' => '+261340000099',
            'text'        => '1',
        ]);

        $this->assertStringContainsString('END', $response->getContent());
    }
}