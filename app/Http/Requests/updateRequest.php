<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
    }
    public function messages():Array
    {
        return[
            'name.nullable'=>'Vaya, veo que ahora no me dices como te llamas... Te llamare Anonimo!',
            'email.required'=>'Necesitas un mail para registrarte',
            'password.required'=>'Necesitas un password para registrarte',
            'password.min'=>'Ups, parece que tu password es demasiado corto. Pon uno mas largo',
            
        ];
    }
}
