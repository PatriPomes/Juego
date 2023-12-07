<?php

namespace App\Http\Controllers;

use App\Http\Requests\adminRegisterRequest;
use App\Http\Requests\loginRequest;
use App\Http\Requests\playerRegisterRequest;
use App\Http\Requests\updateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(loginRequest $request){

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::guard('api')->setUser($user);
            $token= $request->user()->createToken('Personal Acces Token')->accessToken;
             return response()->json(['token'=>$token]);
        } else {
            return response()->json(['message'=>'Correo electrónico o contraseña incorrectos'],401);
        }

    }
    public function playerRegister(playerRegisterRequest $request){

        User::create([
            'name'=>$request->name ? $request->name : 'Anonimo',
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ])->assignRole('Player');


        return response()->json(['message'=>'Tu usuario ha sido creado! Adelante!']);

    }
    public function adminRegister(adminRegisterRequest $request){

        if (Auth::guard('api')->check()) {

            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password)
            ])->assignRole('Admin');

            return response()->json(['message'=>'Tu usuario administrador ha sido creado! Adelante!']);
        } else {

            return response()->json(['message'=>'Debes ser administrador para realizar esta acción.']);
        }
     }
    public function logout(){
            $user=Auth::user();
            $user->tokens->each->revoke();
        return response()->json(['message'=>'Succesfully logged out']);
    }
    public function update(updateRequest $request, $id){
       // $this->authorize('author', $id);
        // $user = User::find($id);
        // $user->update($request->all());

        // return response()->json($user, 200);

       if (Auth::guard('api')->check()) {
            $user = User::find($id);
            $this->authorize('update', $user);
        
            $user->update($request->all());

            return response()->json(['message'=>'Tu usuario ha sido actualizado! Adelante!', 200]);
        } else {

            return response()->json(['message'=>'Lo siento, este usuario no te pertenece'],403);
        }
       
    }
}
