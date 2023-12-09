<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class logoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLogoutSucces(){

       $user = User::factory()->create();
       $this->actingAs($user, 'api');

       $response = $this->postJson('api/logout');

       $response->assertStatus(200);
       $response->assertJson([
           'message' => 'Logout con exito!'
       ]);
   }
   public function testLogoutUnauthenticated(){
        $response = $this->postJson('api/logout');

        $response->assertStatus(401);
    }
}
