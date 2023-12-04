<?php

namespace App\Http\Controllers;

use App\Http\Requests\adminRegisterRequest;
use App\Http\Requests\playerRegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;


class UserController extends Controller
{
    public function login(Request $request){
       
        $data=[
            'email'=>$request->email,
            'password'=>$request->password
        ];
        
        if(auth()->attempt($data)){

            $token= $request->user()->createToken('Personal Acces Token')->accessToken;
            return response()->json(['token'=>$token],200);

        }else{

            return response()->json(['error'=>'Correo electrónico o contraseña incorrectos'],401); 
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
        
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ])->assignRole('Admin');

        if ($user){
            return response()->json(['message'=>'Your user has been created succesfully']);

        }else{
            return response()->json(['message'=>'Sorry this user cant been generated']);
        }
    }
    public function logout(Request $request){
            $user=Auth::user();
       // $token=Auth::user()->token();
       $user->tokens->each->revoke();
       // $token->revoke();
        return response()->json(['message'=>'Succesfully logged out']);
    }
    public function update(Request $request, $id){
    //faltan validaciones por realizar en request form;

        $user = User::find($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }
}
