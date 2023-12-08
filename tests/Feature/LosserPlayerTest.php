<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Roll;
use Laravel\Passport\Passport;

class LosserPlayerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLosserPlayerSuccess(){
        
        $admin = User::factory()->create()->assignRole('Admin');
        $token = $admin->createToken('Personal Access Token')->accessToken;
    
        Passport::actingAs($admin);
    
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson("api/players/ranking/losser");
    
        $response->assertStatus(200);
    
    }
    
    public function testLosserPlayerUnauthorized(){
        
        $user = User::factory()->create()->assignRole('Player');
        $token = $user->createToken('Personal Access Token')->accessToken;
    
        Passport::actingAs($user);
    
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson("api/players/ranking/losser");
    
        $response->assertStatus(403);
    }
}
