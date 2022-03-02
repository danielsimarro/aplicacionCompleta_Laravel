<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coche extends Model
{
    use HasFactory;
    
    protected $table = 'coche';
    
    public $timestamps = false;
    
    //Especificamos los campos de la tabla que esperamos recibir 
    //cuando vallamos a dar de alta a una categoria
    protected $fillable = ['marca', 'modelo','color', 'precio' ];
    
    //Podemos darle a determinados campos su valor determinado si no se reciben esos datos
    protected $attributes = ['precio' => 0, ];
    
    //Declaramos un metodo que se llama tipoCategoria, mediante este metodo 
    //vamos a obtener todas los coches 
    //que pertenecen a la categoria que le mandemos
    
    //Con el app escribimos su espacio de nombres
    public function tipoCategoria () {
        return $this->hasMany ('App\Models\TipoCategoria', 'idcoche');
    }
    
    public function obtenerId () {
        return $this->belongsTo ('App\Models\TipoCategoria', 'idcoche');
    }
    
    
}
