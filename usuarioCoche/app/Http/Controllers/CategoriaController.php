<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaCreateRequest;
use App\Http\Requests\CategoriaEditRequest;
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     //Middleware para que el usuario solo pueda visualizar y no modificar nada
     public function __construct(){
       $this->middleware('admin')->except('index', 'show');
   }
     
     
    public function index()
    {
        //Creamos un array de categorias 
        $arrayCategorias = [];
        //En este array de categorias obtenemos todos las categorias de la base de datos
        //mediante el uso de la sentencia Categoria:all() que recoge todos las categorias
        $arrayCategorias['categorias'] = Categoria::all();
        //Devolvemos la vista con el array de puestos
        return view('categoria.index', $arrayCategorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware('admin');
        //Le enviamos a la ventana de create
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaCreateRequest $request)
    {
        
        //Aqui almacenaremo si se ha realizado la insercción de los datos o no
        $realizado ='';
        //Creamos un array de mensaje para que se almacene el mensaje que queremos 
        //mostrar indicando en todo momento al usuario si los datos han sido o no introducidos en la base de datos
        $mensaje = [];
        //Escribimos el mensaje a mostrar en caso de que haya salido todo correcto
        $mensaje['texto'] = 'La nueva categoria ha sido insertado correctamente';
        //Este especifica el tipo de mensaje
        $mensaje['tipo'] = 'success';
        //Creamos un objeto categoria donde almacenaremos todos los datos que provienen 
        //del request con el metodo request all
        $categoriaGuardar = new Categoria($request->all());
        //Creamos un try catch para que en caso de que salte una excepcion cuando
        //se almacene el nuevo puesto en la base de datos realize una cosa u otra
        
        try {
            $realizado = $categoriaGuardar->save();
        } catch(\Exception $e) {
            $realizado = false;
        }
        
        //En caso de que no se hayan insertado los datos en la base de datos, mostrara
        //un mensaje y lo redirigira a la ventana puesto
        if(!$realizado) {
            $mensaje['texto'] = 'La nueva categoria no se ha podido insertar';
            $mensaje['tipo'] = 'danger';
            return redirect('categoria')->with($mensaje);
        }
        return redirect('categoria')->with($mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        //Realizamos un find por id ya que la categoria que obtiene no sirve
        $categoria = Categoria::find($id);
        
        //Realizamos un if por si el id no existe lo mandaremos a la ventana principal
        
        //Lo enviamos a la ventana vista con los datos de la categoria seleccionado
        if($categoria!=null){
        return view('categoria.show', ['categoria' => $categoria]);
        }else{
            $mensaje['texto'] = 'La categoria no existe';
            $mensaje['tipo'] = 'danger';
            return redirect('categoria')->with($mensaje);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //Realizamos un find por id ya que la categoria que obtiene no sirve
        $categoria = Categoria::find($id);
        
        if($categoria!=null){
        return view('categoria.edit', ['categoria' => $categoria]);
        }else{
            $mensaje['texto'] = 'La categoria no existe';
            $mensaje['tipo'] = 'danger';
            return redirect('categoria')->with($mensaje);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaEditRequest $request,  $id)
    {

        
        //Realizamos un find por id ya que la categoria que obtiene no sirve
        $categoria = Categoria::find($id);
        
        //Creamos un array de mensaje para que se almacene el mensaje que queremos 
        //mostrar indicando en todo momento al usuario si los datos han sido o no introducidos en la base de datos
        $mensaje = [];
        //EScribimos el mensaje a mostrar
        $mensaje['texto'] = 'La categoria ' . $categoria->nombre .  ' ha sido modificado correctamente';
        //Este especifica el tipo de mensaje
        $mensaje['tipo'] = 'success';
        
        if($categoria!=null){
        
        //Creamos un try catch para que en caso de que salte una excepcion cuando
        //se modifique el  puesto en la base de datos realize una cosa u otra
            try {
                $realizado = $categoria->update($request->all());
            } catch(\Exception $e) {
                $mensaje['texto'] = 'La categoria no ha podido modificarse';
                $mensaje['tipo'] = 'danger';
            }
            
        
        }else{
            $mensaje['texto'] = 'La categoria no ha podido modificarse';
            $mensaje['tipo'] = 'danger';
        }
        return redirect('categoria')->with($mensaje); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id); //Tenemos que buscar con find el id porque en el r:l me saca el parmetro mal con el nombre de categorium en lugar de categoria
        
        $mensaje = [];
        $mensaje['texto'] = 'La categoria ' . $categoria->nombre .  ' ha sido borrado correctamente';
        $mensaje['tipo'] = 'success';
        //Aqui tenemos que crear un if que si id es diferente de null me haga el codigo y si no me haga otra cosa 
        //Por ejemplo redirigir al categoria con el mensaje de que ese id no existe
        if($categoria!=null){
            
            try {
             //Con este metodo eliminamos el puesto en concreto, que nos llega. 
             $categoria->delete();
            } catch(\Exception $e) {
            $mensaje['texto'] = 'La categoria ' . $categoria->nombre .  ' no ha sido borrado correctamente';
            $mensaje['tipo'] = 'danger';
            }
            
        }else{
            $mensaje['texto'] = 'La categoria ' . $categoria->nombre .  ' no ha sido borrado correctamente';
            $mensaje['tipo'] = 'danger';
        }
        
        return redirect('categoria')->with($mensaje);
    }
}
