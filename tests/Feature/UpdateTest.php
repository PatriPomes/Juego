<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class UpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUpdateSucces(){
       // Crear un usuario y autenticarlo
        $user = User::factory()->create();
        $token = $user->createToken('Personal Acces Token')->accessToken;

         // Llamar al método update
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json'])->putJson('api/players/'.$user->id, [
            'name' => 'Nuevo nombre15',
            'email' => 'nuevoemail15@example.com',
            'password'=>'newpass123']);
        // Verificar que la respuesta es correcta
        $response->assertStatus(200);

    }
    public function testUpdateWithDifferentId(){
    // Crear dos usuarios y autenticar al primero
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $token = $user1->createToken('Personal Access Token')->accessToken;

    // Intentar actualizar el usuario 2 desde el usuario 1 autenticado
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->putJson('api/players/' . $user2->id, [
        'name' => 'Nuevo nombre16',
        'email' => 'nuevoemail16@example.com',
        'password' => 'newpass123',
    ]);

    // Verificar que la respuesta es un error 403 (Prohibido)
    $response->assertStatus(403);
    }
    public function testUpdateValidationFailed(){
     // Crear un usuario y autenticarlo
        $user = User::factory()->create();
        $token = $user->createToken('Personal Acces Token')->accessToken;

        // Llamar al método update
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json'])->putJson('api/players/'.$user->id, [
            'name' => 'Nuevo nombre15',
            'email' => 'nuevoemail15@example.com',
            'password'=>'newpass123']);
        // Verificar que la respuesta es correcta
        $response->assertStatus(422);

    }
}
