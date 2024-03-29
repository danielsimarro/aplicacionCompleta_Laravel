<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Coche;
use Illuminate\Http\Request;
//Para poder borrar archivos utilizar esta libreria
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\DB;

class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //Middleware para que el usuario solo pueda visualizar y no modificar nada
     public function __construct(){
       $this->middleware('admin');
   }
     
    public function index()
    {
        //Creamos un array de imagenes 
        $arrayImagenes = [];
        //En este array de imagenes obtenemos todos las imagenes de la base de datos
        //mediante el uso de la sentencia Place:all() que recoge todos las imagenes
        $arrayImagenes['imagenes'] = Imagen::all();
        //Devolvemos la vista con el array de puestos
        return view('imagen.index', $arrayImagenes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Imagen $imagen)
    {
        //Para mostrar la imagen cogeremos el id de la imagen y el id del coche
        $idimagen = $imagen->id;
        $idcoche = $imagen->idcoche;
        
        $consultaNombre = DB::select('SELECT marca, modelo FROM coche WHERE id =' . $imagen->idcoche);
        $nombre = ($consultaNombre[0]-> marca . " " . $consultaNombre[0]-> modelo);
        
        
        
        
        
        //Le enviamos a la ventana de create
        return view('imagen.show', ['imagen' => $imagen], ['idimagen' => $idimagen, 'idcoche' => $idcoche, 'nombre' => $nombre]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Imagen $imagen)
    {
        //Le enviamos a la ventana de edit
        return view('imagen.edit', ['imagen' => $imagen]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Imagen $imagen)
    {
        //Validación del formulario 
        
        
        $request ->validate([
            'nombre' => 'required|min:2|max:100',
            
        ]);
        
        //Aqui almacenaremo si se ha realizado la insercción de los datos o no
        $realizado ='';
        //Creamos un array de mensaje para que se almacene el mensaje que queremos 
        //mostrar indicando en todo momento al usuario si los datos han sido o no introducidos en la base de datos
        $mensaje = [];
        //Escribimos el mensaje a mostrar en caso de que haya salido todo correcto
        $mensaje['texto'] = 'La nueva imagen ha sido modificada correctamente';
        //Este especifica el tipo de mensaje
        $mensaje['tipo'] = 'success';
        //Creamos un objeto imagen donde almacenaremos todos los datos que provienen 
        //del request con el metodo request all
       
        
        //Creamos un try catch para que en caso de que salte una excepcion cuando
        //se almacene el nuevo puesto en la base de datos realize una cosa u otra
        try {
            
            $realizado = $imagen->update($request->all());
            
        } catch(\Exception $e) {
            $realizado = false;
        }
        
        //En caso de que no se hayan insertado los datos en la base de datos, mostrara
        //un mensaje y lo redirigira a la ventana puesto
        if(!$realizado) {
            $mensaje['texto'] = 'La nueva imagen no se ha podido modificar';
            $mensaje['tipo'] = 'danger';
            return redirect('imagen')->with($mensaje);
        }
        return redirect('imagen')->with($mensaje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Imagen $imagen)
    {
        $mensaje = [];
        $mensaje['texto'] = 'La imagen ' . $imagen->nombre .  ' ha sido borrado correctamente';
        $mensaje['tipo'] = 'success';
        //Comprobamos si el usuario a subido algun archivo
        $exists = file_exists( 'upload/' . $imagen->idcoche );
        
         try {
             //Con este metodo eliminamos el trabajador en concreto, que nos llega. 
            $imagen->delete();
            
            if($exists == 1) {
                File::delete('upload/' . $imagen->idcoche);
            }
            
        } catch(\Exception $e) {
            
        $mensaje['texto'] = 'La imagen ' . $imagen->nombre .  ' no ha sido borrado correctamente';
        $mensaje['tipo'] = 'danger';
        }
        return back()->withInput()->with($mensaje);
    }
    
    function upload(Request $request, Imagen $imagen) {
        
        
        
        $input = 'photo';
        
        if($request->hasFile($input) && $request->file($input)->isValid()) {
            
         $archivo = $request->file($input); // $request->file
         $archivo->move('upload/', $imagen->id . "-" . $imagen->idcoche);
         
         
    }
    
    return redirect(('imagen/' . $imagen->id . '/edit'));
    
}
}
