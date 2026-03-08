<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_utilisateur_peut_sinscrire(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Test User',
            'phone'                 => '+261340000099',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'buyer',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'user' => ['id', 'name', 'phone', 'role'],
                     'token',
                 ]);

        $this->assertDatabaseHas('users', ['phone' => '+261340000099']);
    }

    public function test_un_utilisateur_peut_se_connecter(): void
    {
        User::factory()->create([
            'phone'    => '+261340000088',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'phone'    => '+261340000088',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'user', 'token']);
    }

    public function test_connexion_echoue_avec_mauvais_mot_de_passe(): void
    {
        User::factory()->create([
            'phone'    => '+261340000077',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'phone'    => '+261340000077',
            'password' => 'mauvais_mdp',
        ]);

        $response->assertStatus(422);
    }

    public function test_utilisateur_connecte_peut_voir_son_profil(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->getJson('/api/auth/me');

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $user->id]);
    }

    public function test_utilisateur_peut_se_deconnecter(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->postJson('/api/auth/logout');

        $response->assertStatus(200);
    }
}