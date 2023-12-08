<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;
use App\Models\Roll;

class SuccessPlayersTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSuccessPlayersSuccess(){
    
        $admin = User::factory()->create()->assignRole('Admin');
        $token = $admin->createToken('Personal Access Token')->accessToken;
    
        Passport::actingAs($admin);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson("api/players");

        $response->assertStatus(200);
        $response->assertJsonStructure(['success_rates']); 
    }
    public function testSuccessPlayersForbbiden(){
    
        $admin = User::factory()->create()->assignRole('Player');
        $token = $admin->createToken('Personal Access Token')->accessToken;
    
        Passport::actingAs($admin);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson("api/players");

        $response->assertStatus(403);
    }
    public function testSuccessWithoutToken(){
    
        User::factory()->create()->assignRole('Admin');
    
        $response = $this->getJson("api/players");

        $response->assertStatus(401);
    }
}
