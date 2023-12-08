<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class RollDiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRollDiceSucces(){
        
        $user = User::factory()->create()->assignRole('Player');
        $token = $user->createToken('Personal Access Token')->accessToken;
        Passport::actingAs($user);
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->postJson("api/players/{$user->id}/games");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'dice1',
            'dice2',
            'total',
            'winner',
            'user_id',
            'created_at',
            'updated_at',
        ]);

        $this->assertDatabaseHas('rolls', [
            'user_id' => $user->id,
        ]);
    }
    public function testRollDiceForbidden(){
        
        $user = User::factory()->create()->assignRole('Admin');
        $token = $user->createToken('Personal Access Token')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->postJson("api/players/{$user->id}/games");

        $response->assertStatus(403);
    }
    public function testRollDiceUnauthorized(){
        
        $user = User::factory()->create();
        $user->assignRole('Player');

        $response = $this->postJson("api/players/{$user->id}/games");

        $response->assertStatus(401);
    }
}

