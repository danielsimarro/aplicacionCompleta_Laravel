<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CocheCreateRequest extends FormRequest
{
    
    function attributes() {
        return [
            'marca'  => 'marca del coche',
            'modelo'    => 'modelo del coche',
            'color'  => 'color del coche',
            'precio'    => 'precio del coche',
            
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    function messages() {
        $gte = 'El campo :attribute debe ser mayor o igual que :value';
        $integer = 'El campo :attribute ha de ser un número entero';
        $lte = 'El campo :attribute debe ser menor o igual que :value';
        $max = 'El campo :attribute no puede tener más de :max caracteres';
        $min = 'El campo :attribute no puede tener menos de :min caracteres';
        $numeric = 'El campo :attribute debe ser numérico';
        $required = 'El campo :attribute es obligatorio';
        $unique   = 'El campo :attribute debe ser único en la tabla de lugares';

        return [
            'marca.max'          => $max,
            'marca.min'          => $min,
            'marca.required'     => $required,
            'marca.unique'       => $unique,
            'modelo.max'          => $max,
            'modelo.min'          => $min,
            'modelo.required'     => $required,
            'modelo.unique'       => $unique,
            'color.max'          => $max,
            'color.min'          => $min,
            'color.required'     => $required,
            'color.unique'       => $unique,
            'precio.gte'        => $gte,
            'precio.lte'        => $lte,
            'precio.numeric'    => $numeric,
            'precio.required'   => $required,
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'marca' => 'required|min:2|max:50',
            'modelo' => 'required|min:2|max:70',
            'color' => 'required|min:2|max:30',
            'precio'   => 'required|numeric|gte:0.01|lte:99999999.99',
        ];
    }
}
