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
       // Crear un usuario y autenticarlo
       $user = User::factory()->create();
       $this->actingAs($user, 'api');

       // Llamar al método logout
       $response = $this->postJson('api/logout');

       // Verificar que la respuesta es correcta
       $response->assertStatus(200);
       $response->assertJson([
           'message' => 'Succesfully logged out'
       ]);
   }
   public function testLogoutUnauthenticated(){
   // Intentar llamar al método logout sin autenticar al usuario
        $response = $this->postJson('api/logout');

   // Verificar que la respuesta tiene el código de estado correcto
        $response->assertStatus(401);
    }
}
