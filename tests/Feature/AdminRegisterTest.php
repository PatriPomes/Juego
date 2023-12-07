<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminRegisterTest extends TestCase
{
    //use RefreshDatabase;

    public function testAdminRegisterSuccess(){
        // Crear un usuario administrador de prueba
        $admin = User::factory()->create(['email' => 'intento2@example.com']);     
        $admin->assignRole('Admin');
       
        // Crear un token para el usuario administrador de prueba
        $token = $admin->createToken('Personal Acces Token')->accessToken;
        
         Passport::actingAs($admin);
        
        // Crear los datos de entrada para el método adminRegister
        $data = [
            'name' => 'Test Admin2',
            'email' => 'testadmin2@example.com',
            'password' => 'TestAdmin123!'
        ];
   
        // Enviar una solicitud POST al método adminRegister

     $response = $this->withToken($token)->post('api/adminRegister', $data);
        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);
        
        // Verifica que las credenciales del usuario estén en la base de datos
    $this->assertCredentials($data);  
    }

    public function testAdminRegisterUnauthorized(){
        // Crear un usuario de prueba
        $user = User::factory()->create(['email' => 'testuser5@example.com']);
        $user->assignRole('Player');
        // Crear un token para el usuario de prueba
        $token = $user->createToken('Personal Acces Token')->accessToken;
     
        Passport::actingAs($user);
     
        // Crear los datos de entrada para el método adminRegister
        $data = [
            'name' => 'Testser5',
            'email' => 'test5@example.com',
            'password' => 'TestUser123!'
        ];
        // Enviar una solicitud POST al método adminRegister
        $response = $this->withToken($token)->post('api/adminRegister', $data);
     
        // Verificar que la solicitud fue exitosa
        $response->assertStatus(403);
     }
     public function testAdminRegisterValidationErrors(){
        // Crear un usuario administrador de prueba
        $admin = User::factory()->create(['email' => 'intento14@example.com']);
        $admin->assignRole('Admin');
     
        // Crear un token para el usuario administrador de prueba
        $token = $admin->createToken('Personal Acces Token')->accessToken;
        Passport::actingAs($admin);
     
        // Crear los datos de entrada para el método adminRegister con valores inválidos
        $data = [
            'name' => '', // nombre vacío
            'email' => 'testuser5@example.com', // email ya registrado
            'password' => 'short' // password demasiado corto
        ];
     
        // Enviar una solicitud POST al método adminRegister
        $response = $this->withToken($token)->json('POST', 'api/adminRegister',$data );
        
        // Verificar que la solicitud fue exitosa
        $response->assertStatus(422);
     
     }
}
