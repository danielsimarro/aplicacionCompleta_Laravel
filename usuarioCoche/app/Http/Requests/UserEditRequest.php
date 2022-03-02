<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    function attributes() {
        return [
            'name'  => 'nombre de usuario',
            'email'    => 'correo de usuario',
            'password'      => 'clave de acceso',
            'oldpassword' => 'clave de acceso anterior'
        ];
    }
    
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   =>'required|min:2|max:255|', 
            'email'     => 'required|email|min:5|max:255|unique:users,email,' . auth()->user()->id, //|unique:place,name
            'password' => 'nullable|min:8|confirmed|',
            
        ];
    }
}
