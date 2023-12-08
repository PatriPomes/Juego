<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Roll;
use Laravel\Passport\Passport;

class RankingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRankingSuccess(){
        $user = User::factory()->create();
        $token = $user->createToken('Personal Access Token')->accessToken;
    
        Passport::actingAs($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson("api/players/ranking");
    
        $response->assertStatus(200);
    
        $response->assertJsonStructure([
            'rankings' => [
                '*' => [
                    'name',
                    'success_rate',
                    'total_rolls',
                ],
            ],
        ]);
    }
    public function testRankingUnauthorized(){
        User::factory()->create();
            
        $response = $this->getJson("api/players/ranking");
    
        $response->assertStatus(401);
    }
    
}
