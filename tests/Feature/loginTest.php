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
        
        User::factory()->create([
            'email' => 'testlogin10@example.com',
            'password' => 'TestUser123!']);
        
        $data = [
            'email' => 'testlogin10@example.com',
            'password' =>'TestUser123!'];
        
        $response = $this->post('api/login',$data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
     }
     
     public function testLoginFailure(){
        
        $data = [
            'email' => 'test3@example.com',
            'password' => 'wrongpassword'];
     
        $response = $this->post('api/login', $data);
     
        $response->assertStatus(401);
     
        $response->assertJson([
            'message' => 'Correo electrónico o contraseña incorrectos'
        ]);
     }
}
