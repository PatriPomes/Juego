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
        
        $admin = User::factory()->create(['email' => 'intento2@example.com']);     
        $admin->assignRole('Admin');
       
        $token = $admin->createToken('Personal Acces Token')->accessToken;
        
        Passport::actingAs($admin);
        
        $data = [
            'name' => 'Test Admin2',
            'email' => 'testadmin2@example.com',
            'password' => 'TestAdmin123!'];
   
        $response = $this->withToken($token)->post('api/adminRegister', $data);
        
        $response->assertStatus(200);
        
        $this->assertCredentials($data);  
    }

    public function testAdminRegisterForbidden(){
        
        $user = User::factory()->create(['email' => 'testuser5@example.com']);
        $user->assignRole('Player');
        
        $token = $user->createToken('Personal Acces Token')->accessToken;
     
        Passport::actingAs($user);
     
        $data = [
            'name' => 'Testser5',
            'email' => 'test5@example.com',
            'password' => 'TestUser123!'
        ];
        
        $response = $this->withToken($token)->post('api/adminRegister', $data);
     
        $response->assertStatus(403);
     }
     public function testAdminRegisterValidationErrors(){
        
        $admin = User::factory()->create(['email' => 'intento14@example.com']);
        $admin->assignRole('Admin');
     
        $token = $admin->createToken('Personal Acces Token')->accessToken;
        Passport::actingAs($admin);
     
        $data = [
            'name' => '', // nombre vacío
            'email' => 'testuser5@example.com', // email ya registrado
            'password' => 'short' // password demasiado corto
        ];
     
        $response = $this->withToken($token)->json('POST', 'api/adminRegister',$data );
        $response->assertStatus(422);
    }
}
