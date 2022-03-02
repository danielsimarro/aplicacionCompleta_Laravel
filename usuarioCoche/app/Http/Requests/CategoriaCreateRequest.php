<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaCreateRequest extends FormRequest
{
    
    
    function attributes() {
        return [
            'nombre'  => 'nombre de la categoria',
            'descripcion'    => 'descripcion de la categoria',
            
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
            'nombre.max'          => $max,
            'nombre.min'          => $min,
            'nombre.required'     => $required,
            'nombre.unique'       => $unique,
            'descripcion.max'          => $max,
            'descripcion.min'          => $min,
            'descripcion.required'     => $required,
            'descripcion.unique'       => $unique,
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
            'nombre' => 'required|min:2|max:80|unique:categoria,nombre',
            'descripcion' => 'required|min:2|max:1000',
        ];
    }
}
