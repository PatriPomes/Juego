<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;
use App\Models\Roll;

class RollsPlayerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRollsPlayerSucces(){
    
        $user = User::factory()->create()->assignRole('Player');
        $token = $user->createToken('Personal Access Token')->accessToken;

        Passport::actingAs($user);

        $rolls = Roll::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson("api/players/{$user->id}/games");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'success_rate',
            'rolls' => [
                '*' => [
                    'id',
                    'user_id',
                    'dice1',
                    'dice2',
                    'total',
                    'winner'
                ],
            ],
        ]);

        $winningRolls = $rolls->where('winner', true)->count();
        $successRate = $rolls->count() === 0 ? 0 : ($winningRolls / $rolls->count()) * 100;
        $response->assertJson(['success_rate' => $successRate]);

        foreach ($rolls as $roll) {
            $response->assertJsonFragment(['id' => $roll->id]);
        }
    }
    public function testRollsPlayerForbidden(){
    
        $user1 = User::factory()->create()->assignRole('Player');
        $user2 = User::factory()->create()->assignRole('Player');
        $token = $user1->createToken('Personal Access Token')->accessToken;

        Passport::actingAs($user1);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson("api/players/{$user2->id}/games");

        $response->assertStatus(403);
    }
    public function testRollsPlayerUnauthorized(){
    
        $user = User::factory()->create()->assignRole('Player');

        Roll::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->getJson("api/players/{$user->id}/games");

        $response->assertStatus(401);
    }
}
