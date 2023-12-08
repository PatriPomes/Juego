<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerRegisterTest extends TestCase
{

  public function testPlayerRegisterSucces(){
    $response = $this->json('POST', 'api/players', [
        'name' => 'lucas',
        'email' => 'lucas@example.com',
        'password' => '123aBc/*-',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Tu usuario ha sido creado! Adelante!']);

    $this->assertDatabaseHas('users', [
        'name' => 'lucas',
        'email' => 'lucas@example.com']);
  }
  
  public function testPlayerRegisterFailureMissingData(){
    $response = $this->json('POST', 'api/players', [
        'name' => '',
        'email' => '',
        'password' => '']);

      $response->assertStatus(422);
  }
  public function testPlayerRegisterFailureWeakPassword(){
    $response = $this->json('POST', 'api/players', [
      'name' => 'lucas',
      'email' => 'lucas@example.com',
      'password' => '123456',
    ]);

    $response->assertStatus(422);
  }

  public function testPlayerRegisterFailureDuplicate(){
     
    User::create([
      'name' => 'luca',
      'email' => 'luca@example.com',
      'password' => bcrypt('123aBc/*-')]);
 
    $response = $this->json('POST', 'api/players', [
      'name' => 'luca',
      'email' => 'luca@example.com',
      'password' => '123aBc/*-']);

    $response->assertStatus(422);
  }

}
