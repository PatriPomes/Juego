<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class loginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLoginSuccess(){
        // Crear un usuario de prueba
        User::factory()->create([
            'email' => 'testlogin10@example.com',
            'password' => 'TestUser123!'
        ]);
        // Crear los datos de entrada para el método login
        $data = [
            'email' => 'testlogin10@example.com',
            'password' =>'TestUser123!'
        ];
        // Enviar una solicitud POST al método login
        $response = $this->post('api/login',$data);
      
        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);
     
        // Verificar que se recibió un token de acceso
       $response->assertJsonStructure([
           'token'
       ]);
     }
     
     public function testLoginFailure(){
        
        // Crear los datos de entrada para el método login con credenciales incorrectas
        $data = [
            'email' => 'test3@example.com',
            'password' => 'wrongpassword'
        ];
     
        // Enviar una solicitud POST al método login
        $response = $this->post('api/login', $data);
     
        // Verificar que la solicitud no fue exitosa
        $response->assertStatus(401);
     
        // Verificar que se recibió un mensaje de error
        $response->assertJson([
            'message' => 'Correo electrónico o contraseña incorrectos'
        ]);
     }
}
