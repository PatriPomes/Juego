<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportController extends Controller
{
    public function login(Request $request){

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
            'password'=>$request->bcrypt($request->password)
        ]);

        $token=$user->createToken('PersonalToken')->accesToken;

        return response()->json(['token'=>$token],200);
    }
    public function logout(Request $request){

    }
}
