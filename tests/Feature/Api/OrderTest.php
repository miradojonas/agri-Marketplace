<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Farmer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private function createFarmerWithProduct(): array
    {
        $farmerUser = User::factory()->create(['role' => 'farmer']);
        $farmer     = Farmer::factory()->create(['user_id' => $farmerUser->id]);
        $category   = Category::factory()->create();
        $product    = Product::factory()->create([
            'farmer_id'          => $farmer->id,
            'category_id'        => $category->id,
            'price'              => 1000,
            'quantity_available' => 100,
            'status'             => 'available',
        ]);

        return compact('farmerUser', 'farmer', 'product');
    }

    public function test_acheteur_peut_passer_une_commande(): void
    {
        ['product' => $product] = $this->createFarmerWithProduct();
        $buyer = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($buyer)
                         ->postJson('/api/orders', [
                             'items'            => [
                                 ['product_id' => $product->id, 'quantity' => 5],
                             ],
                             'delivery_address' => 'Antananarivo',
                             'payment_method'   => 'mvola',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'order' => ['id', 'order_number', 'total_amount'],
                 ]);

        $this->assertDatabaseHas('orders', ['buyer_id' => $buyer->id]);
    }

    public function test_quantite_reduite_apres_commande(): void
    {
        ['product' => $product] = $this->createFarmerWithProduct();
        $buyer = User::factory()->create(['role' => 'buyer']);

        $this->actingAs($buyer)->postJson('/api/orders', [
            'items' => [['product_id' => $product->id, 'quantity' => 10]],
        ]);

        $this->assertDatabaseHas('products', [
            'id'                 => $product->id,
            'quantity_available' => 90,
        ]);
    }

    public function test_impossible_commander_plus_que_le_stock(): void
    {
        ['product' => $product] = $this->createFarmerWithProduct();
        $buyer = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($buyer)
                         ->postJson('/api/orders', [
                             'items' => [
                                 ['product_id' => $product->id, 'quantity' => 999],
                             ],
                         ]);

        $response->assertStatus(422);
    }

    public function test_acheteur_peut_annuler_commande_en_attente(): void
    {
        ['product' => $product] = $this->createFarmerWithProduct();
        $buyer = User::factory()->create(['role' => 'buyer']);

        $orderResponse = $this->actingAs($buyer)
                              ->postJson('/api/orders', [
                                  'items' => [
                                      ['product_id' => $product->id, 'quantity' => 5],
                                  ],
                              ]);

        $orderId = $orderResponse->json('order.id');

        $response = $this->actingAs($buyer)
                         ->deleteJson("/api/orders/{$orderId}");

        $response->assertStatus(200);
    }

    public function test_non_connecte_ne_peut_pas_voir_commandes(): void
    {
        $response = $this->getJson('/api/orders');
        $response->assertStatus(401);
    }
}