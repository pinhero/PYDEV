<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    public function messages()
    {
        return [
            'email.unique' => 'Votre adresse mail  est déjà utilisée',
        ];
    }
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email'
        ];
    }
}
