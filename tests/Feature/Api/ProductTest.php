<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Farmer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private function createFarmer(): User
    {
        $user = User::factory()->create(['role' => 'farmer']);
        Farmer::factory()->create(['user_id' => $user->id]);
        return $user;
    }

    public function test_tout_le_monde_peut_voir_les_produits(): void
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'total']);
    }

    public function test_tout_le_monde_peut_voir_les_categories(): void
    {
        Category::factory()->count(3)->create();
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);
    }

    public function test_agriculteur_peut_creer_un_produit(): void
    {
        $user     = $this->createFarmer();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                         ->postJson('/api/products', [
                             'category_id'        => $category->id,
                             'name'               => 'Tomates fraiches',
                             'price'              => 1200,
                             'unit'               => 'kg',
                             'quantity_available' => 100,
                         ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', ['name' => 'Tomates fraiches']);
    }

    public function test_acheteur_ne_peut_pas_creer_un_produit(): void
    {
        $user     = User::factory()->create(['role' => 'buyer']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                         ->postJson('/api/products', [
                             'category_id'        => $category->id,
                             'name'               => 'Produit test',
                             'price'              => 1000,
                             'unit'               => 'kg',
                             'quantity_available' => 50,
                         ]);

        $response->assertStatus(403);
    }

    public function test_agriculteur_peut_modifier_son_produit(): void
    {
        $user    = $this->createFarmer();
        $product = Product::factory()->create([
            'farmer_id' => $user->farmer->id,
        ]);

        $response = $this->actingAs($user)
                         ->putJson("/api/products/{$product->id}", [
                             'price' => 1500,
                         ]);

        $response->assertStatus(200);
    }

    public function test_agriculteur_ne_peut_pas_modifier_produit_dautrui(): void
    {
        $user1   = $this->createFarmer();
        $user2   = $this->createFarmer();
        $product = Product::factory()->create([
            'farmer_id' => $user2->farmer->id,
        ]);

        $response = $this->actingAs($user1)
                         ->putJson("/api/products/{$product->id}", [
                             'price' => 500,
                         ]);

        $response->assertStatus(403);
    }
}