<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Roll;
use Laravel\Passport\Passport;

class DestroyAllRollDiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testDestroyAllRollDiceSuccess()
    {
        
        $user = User::factory()->create()->assignRole('Player');
        $token = $user->createToken('Personal Access Token')->accessToken;
        Passport::actingAs($user);
        
        $rolls = Roll::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->deleteJson("api/players/{$user->id}/games");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Tus tiradas han sido eliminadas.']);

        foreach ($rolls as $roll) {
            $this->assertDatabaseMissing('rolls', ['id' => $roll->id]);
        }
    }
    public function testDestroyAllRollDiceForbidden(){
    
        $user = User::factory()->create();
        $token = $user->createToken('Personal Access Token')->accessToken;
    
        Roll::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->deleteJson("api/players/{$user->id}/games");

        $response->assertStatus(403);

    }
    public function testDestroyAllRollDiceWhithoutToken(){
    
        $user = User::factory()->create()->assignRole('Player');

        Roll::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->deleteJson("api/players/{$user->id}/games");

        $response->assertStatus(401);
    }
}
