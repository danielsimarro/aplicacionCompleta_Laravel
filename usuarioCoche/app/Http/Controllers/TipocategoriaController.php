<?php

namespace App\Http\Controllers;

use App\Models\Tipocategoria;
use App\Models\Categoria;
use App\Models\Coche;
use Illuminate\Http\Request;

class TipocategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tipocategoria.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrayCategorias = [];
        $arrayCoches = [];
        
        $arrayCategorias['categorias'] = Categoria::all();
        $arrayCoches['coches'] = Coche::all();
        return view('tipocategoria.create', $arrayCategorias, $arrayCoches);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Aqui almacenaremo si se ha realizado la insercción de los datos o no
        $realizado ='';
        //Creamos un array de mensaje para que se almacene el mensaje que queremos 
        //mostrar indicando en todo momento al usuario si los datos han sido o no introducidos en la base de datos
        $mensaje = [];
        //Escribimos el mensaje a mostrar en caso de que haya salido todo correcto
        $mensaje['texto'] = 'La categoria a sido asignada correctamente';
        //Este especifica el tipo de mensaje
        $mensaje['tipo'] = 'success';
        //Creamos un objeto categoria donde almacenaremos todos los datos que provienen 
        //del request con el metodo request all
        
        $tipocategoriaGuardar = new Tipocategoria($request->all());
        //Creamos un try catch para que en caso de que salte una excepcion cuando
        //se almacene el nuevo puesto en la base de datos realize una cosa u otra
        
        try {
            $realizado = $tipocategoriaGuardar->save();
        } catch(\Exception $e) {
            $mensaje['texto'] = 'No se a podido asignar la categoria';
            $mensaje['tipo'] = 'danger';
        }
        

        return back()->withInput()->with($mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tipocategoria  $tipocategoria
     * @return \Illuminate\Http\Response
     */
    public function show(Tipocategoria $tipocategoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tipocategoria  $tipocategoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipocategoria $tipocategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tipocategoria  $tipocategoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipocategoria $tipocategoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tipocategoria  $tipocategoria
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $tipocategoria = TipoCategoria::find($id); //Tenemos que buscar con find el id porque en el r:l me saca el parmetro mal con el nombre de categorium en lugar de categoria
        
        $mensaje = [];
        $mensaje['texto'] = 'La categoria a sido borrada';
        $mensaje['tipo'] = 'success';
        //Aqui tenemos que crear un if que si id es diferente de null me haga el codigo y si no me haga otra cosa 
        //Por ejemplo redirigir al categoria con el mensaje de que ese id no existe
        if($tipocategoria!=null){
            
            try {
             //Con este metodo eliminamos el puesto en concreto, que nos llega. 
             $tipocategoria->delete();
            } catch(\Exception $e) {
            $mensaje['texto'] = 'La categoria no ha podido borrarse';
            $mensaje['tipo'] = 'danger';
            }
            
        }else{
            $mensaje['texto'] = 'La categoria no ha podido borrarse';
            $mensaje['tipo'] = 'danger';
        }
         return back()->withInput()->with($mensaje);
    }
}
