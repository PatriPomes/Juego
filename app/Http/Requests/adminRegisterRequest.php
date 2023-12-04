<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class adminRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ];
    }
     public function messages():Array
    {
        return[
            'name.unique'=>'Lo siento, este nombre ya esta registrado. Prueba con otro',
            'email.required'=>'Necesitas un mail para registrarte',
            'email.unique'=>'Lo siento, este mail ya esta registrado. Prueba con otro',
            'password.required'=>'Necesitas un password para registrarte',
            'password.min'=>'Ups, parece que tu password es demasiado corto. Pon uno mas largo',
            'password.regex'=>'Tu password debe contener al menos una letra minúscula, una letra mayúscula, un número y un símbolo especial.'
        ];
    }    
}

