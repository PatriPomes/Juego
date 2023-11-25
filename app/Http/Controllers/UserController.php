<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request){
        $this->validate ($request, [
            'email'=> 'required | email',
            'password'=>'required | min:8'
        ]);
        $data=[
            'email'=>$request->email,
            'password'=>$request->password
        ];
        
        if(auth()->attempt($data)){

            $token= $request->user()->createToken('PersonalToken')->accessToken;
            return response()->json(['token'=>$token],200);

        }else{

            return response()->json(['error'=>'Unauthorized'],401); 
        }
        
    }
    public function register(Request $request){
        $this->validate ($request, [
            'name'=> 'required | min:4',
            'email'=> 'required | email',
            'password'=>'required | min:8'
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);

        $token=$user->createToken('PersonalToken')->accessToken;

        return response()->json(['token'=>$token],200); //no devuelve token sino una vista, hay que encontrar el error en ruta
    }
    public function logout(Request $request){

    }
}
