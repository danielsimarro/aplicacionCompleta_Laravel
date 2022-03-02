<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipocategoria extends Model
{
    use HasFactory;
    
    protected $table = 'tipocategoria';
    
    //Especificamos los campos de la tabla que esperamos recibir 
    //cuando vallamos a dar de alta a un performance
    protected $fillable = ['idcoche', 'idcategoria',];
    
    //Declaramos un metodo que se llama empleados, mediante este metodo 
    //vamos a obtener todos los trabajadores 
    //que pertenecen al puesto que le mandemos
    
    //Con el app escribimos su espacio de nombres
    public function categoria (){
        return $this->belongsTo ('App\Models\Categoria', 'idcategoria');
    }
    
    //Con este metodo podemos acceder a los elmentos de trabajadore a traves del idempleadojefe
    public function coche () {
        return $this->belongsTo ('App\Models\Coche', 'idcoche');
    }
    
    

}
