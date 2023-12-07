<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class RollDiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRollDiceSucces(){
        // Crear un usuario y autenticarlo
        $user = User::factory()->create()->assignRole('Player');
        $token = $user->createToken('Personal Access Token')->accessToken;
        Passport::actingAs($user);
        // Llamar al método rollDice
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->postJson("api/players/{$user->id}/games");

        // Verificar que la respuesta es correcta
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'dice1',
            'dice2',
            'total',
            'winner',
            'user_id',
            'created_at',
            'updated_at',
        ]);

        // Verificar que se ha creado un registro en la tabla Roll
        $this->assertDatabaseHas('rolls', [
            'user_id' => $user->id,
        ]);
    }
    public function testRollDiceUnauthorized(){
        // Crear un usuario sin asignar el rol 'Player'
        $user = User::factory()->create();
        $token = $user->createToken('Personal Access Token')->accessToken;

        // Intentar llamar al método rollDice con el usuario no autorizado
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->postJson("api/players/{$user->id}/games");

        // Verificar que la respuesta es un error 403
        $response->assertStatus(403);
    }
    public function testRollDiceWithoutToken(){
        // Crear un usuario y asignar el rol 'Player'
        $user = User::factory()->create();
        $user->assignRole('Player');

        // Intentar llamar al método rollDice sin proporcionar un token de autorización
        $response = $this->postJson("api/players/{$user->id}/games");

        // Verificar que la respuesta es un error 401
        $response->assertStatus(401);
    }
}

