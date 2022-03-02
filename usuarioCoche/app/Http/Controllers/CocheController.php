<?php

namespace App\Http\Controllers;

use App\Models\Coche;
use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Tipocategoria;
use Illuminate\Http\Request;
use App\Http\Requests\CocheCreateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 

class CocheController extends Controller
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
     
     /*Con este metodo podemos obtener todos los campos del modelo*/
    private function getAllAttributes($model) {
        $columns = $model->getFillable();
        $attributes = $model->getAttributes();
        $add = array_merge(array_flip($columns), $attributes);
        $add['id'] = 0;
        return $add;
    }
    
    /*Este metodo es para obtener la paginación de la pagina*/
    private function getRecordsPerPageArray($array) {
        $result = [];
        $rpps = $this->getRpps();
        foreach($rpps as $rpp => $value) {
            $result['rpps'][] = array_merge($array, ['rpp' =>  $rpp]);
        }
        return $result;
    }

    /* Con este metodo ondenamos los campos segun el usuario haya especificado*/
    private function getOrderArrays($array) {
        $data = [];
        $orders = ['asc', 'desc'];
        $sorts = $this->getAllAttributes(new Coche());
        foreach($orders as $order){
            foreach($sorts as $sortindex => $sort){
                $data['order' . $sortindex . $order] = array_merge(['sort' => $sortindex, 'order' => $order], $array);
            }
        }
        return $data;
    }
    
    /*Obtenemos la paginación que desee el usuario*/
    private function getRpps() {
        return [2 => 1, 5 => 1, 10 => 1, 20 => 1, 50 => 1, 100 => 1,150 => 1,200 => 1];
    }

    /*Verificamos el orden que deseea que esten los campos*/
    private function verifyOrder($order) {
        if($order == null) {
            return $order;
        } elseif($order == 'desc'){
            return $order;
        }
        return 'asc';
    }
    
    /*Verificamos la paginción*/
    private function verifyRpp($rpp) {
        $rpps = $this->getRpps();
        if(isset($rpps[$rpp])) {
            return $rpp;
        }
        return 10;
    }
    
    //Verifica la ordenación que nos llega por parametro
    private function verifySort($sort) {
        /*$sorts = ['id' => 1, 'name' => 1, 'category' => 1, 'artist' => 1, 'budget' => 1];*/
        $sorts = $this->getAllAttributes(new Coche());
        if(isset($sorts[$sort])) {
            return $sort;
        }
        return null;
    }

    public function index(Request $request) {
        $data = [];
        $appendData = [];
        $filterData = [];
        $rppData = [];
        $sortData = [];
        $searchData = [];

        $page = $request->input('page');
        $search = $request ->input('search');
        $filter = $request->input('filter');
        $sort = $this->verifySort($request->input('sort'));
        $order = $this->verifyOrder($request->input('order'));
        $rpp = $this->verifyRpp($request->input('rpp'));

        if($sort != null && $order != null) {
            $sortData = ['sort' => $sort, 'order' => $order];
        }

        if($rpp != 10) {
            $rppData['rpp'] = $rpp;
        }
        
        if($search != null){
            $searchData['search'] = $search;
            //$data['search'] = $search;
        }

        //Son los datos que yo agrego para los enlazes que me genera autmaticamente
        $appendData = array_merge($appendData, $rppData);
        $appendData = array_merge($appendData, $sortData);
        $appendData = array_merge($appendData, $searchData);

        $data = array_merge($data, $this->getOrderArrays(array_merge($rppData,$searchData)));
        $data = array_merge($data, $this->getRecordsPerPageArray($appendData));
        $data['rpp'] = $rpp;

        $performance = new Coche();
        
        if($search != null){
            $performance = $performance->where('id', 'like', '%' . $search . '%')
                 ->orWhere('marca', 'like', '%' . $search . '%')
                 ->orWhere('modelo', 'like', '%' . $search . '%')
                 ->orWhere('color', 'like', '%' . $search . '%')
                 ->orWhere('precio', 'like', '%' . $search . '%');
        }
        
        if($sort != null && $order != null) {
            $performance = $performance->orderBy($sort, $order);
        }
        $data['appendData'] = $appendData;
        //dd([$appendData, $data]);
        $performance = $performance->orderBy('marca', 'asc')->paginate($rpp)->appends($appendData);
        $data['coches'] = $performance; //Performance::paginate(10);
        $data['rutaSearch'] = route('coche.index');
        
        
        //Consulta para obtener el precio del coche mas alto, junto con su id y el precio
        
        $precioAlto = DB::select('SELECT avg(precio) as pr FROM coche ');
        
        if(empty($precioAlto)){
            $precioAlto[0] = 0;
        }
        
        
        return view('coche.index', $data, ['precio'=>$precioAlto[0]->pr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Le enviamos a la ventana de create
        return view('coche.create', ['categorias' => Categoria::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CocheCreateRequest $request)
    {
        
        
        //Creamos un array de mensaje para que se almacene el mensaje que queremos 
        //mostrar indicando en todo momento al usuario si los datos han sido o no introducidos en la base de datos
        $mensaje = [];
        //Escribimos el mensaje a mostrar en caso de que haya salido todo correcto
        $mensaje['texto'] = 'El nuevo coche ha sido insertado correctamente';
        //Este especifica el tipo de mensaje
        $mensaje['tipo'] = 'success';
        /*$coche = array(
            "id" => $request->input('id'),
            "marca" => $request->input('marca'),
            "modelo" => $request->input('modelo'),
            "color" => $request->input('color'),
            "precio" => $request->input('precio'),
        );*/
        
        
        //Creamos un objeto coche donde almacenaremos todos los datos que provienen 
        //del request con el metodo request all
        $cocheGuardar = new Coche($request->all());
        //Creamos un try catch para que en caso de que salte una excepcion cuando
        //se almacene el nuevo puesto en la base de datos realize una cosa u otra
        try {
            
            $realizado = $cocheGuardar->save();
            //Como todavia no hemos guardado el nuevo coche por lo cual no sabemos el id de este
            //pues habra que obtenerlo una vez que se guarde
            /*$tipocategoria = array(
                "idcategoria" => $request->input('idcategoria'),
                "idcoche" => $cocheGuardar->id,
                );
            
            //Creamos tambien el objeto tipo categoria para que tenga relación
            $tipocategoriaGuardar = new Tipocategoria($tipocategoria);
            
            
            if($tipocategoriaGuardar->idcategoria!=null){
                $realizado = $tipocategoriaGuardar->save();
            }*/
            
        } catch(\Exception $e) {
            $mensaje['texto'] = 'La nueva categoria no se ha podido insertar';
            $mensaje['tipo'] = 'danger';
        }
        

        return redirect('coche')->with($mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coche  $coche
     * @return \Illuminate\Http\Response
     */
    public function show(Coche $coche)
    {
        
        //Consultamos todos los id de categoria que tiene ese coche y hacemos un blucle para almacenarlos en un nuevo array
        $consultaIdCategoria = DB::select('SELECT idcategoria FROM tipocategoria WHERE idcoche =' . $coche->id);
        //Crearemos un array donde realizaremos una consulta para obtener el tipo de id de tipocategoria para poder borrar o crear
        //relaciones
        $arrayTipoCategoria = array();
        $arrayIdCategoria = array();
        
        for ($i = 0;  $i <= (count($consultaIdCategoria)-1); $i++) {
            
            array_push($arrayIdCategoria, $consultaIdCategoria[$i]);
            
            $categoriaid = $arrayIdCategoria[$i];
            
            $consultaTipoCategoria = DB::select('SELECT id FROM tipocategoria WHERE idcoche =' . $coche->id . ' and idcategoria = ' .$categoriaid->idcategoria);
            
            array_push($arrayTipoCategoria, $consultaTipoCategoria[0]);
            
        }
        
        $arrayCategoria = array();
        
        for ($i = 0;  $i <= (count($arrayIdCategoria)-1); $i++) {
            
            $idcategoria = $arrayIdCategoria[$i];
            
            $consultaCategoria = DB::select('SELECT nombre FROM categoria WHERE id =' . $idcategoria->idcategoria);
            
            array_push($arrayCategoria, $consultaCategoria[0]);
            
        }
        
        /*Vamos a averigual el id de la imagen pasandole como parametro el id del coche, ya que es una relación 1 a 1*/
        
        $consultaImagen = DB::select('SELECT id FROM imagen WHERE idcoche =' . $coche->id);
        
        if(!empty($consultaImagen[0]->id)){
            $idimagen = $consultaImagen[0]->id;
        }else{
             $idimagen = null;
        }
        
        
        
        $arrayCategorias = [];
        $arrayCategorias = Categoria::all();
        
        
        
        return view('coche.show', ['categorias'=>$arrayCategorias,'coche' => $coche,'idtipo' => $arrayTipoCategoria,'nombre' => $arrayCategoria, 'idimagen' => $idimagen] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coche  $coche
     * @return \Illuminate\Http\Response
     */
    public function edit(Coche $coche)
    {
        return view('coche.edit', ['coche' => $coche]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coche  $coche
     * @return \Illuminate\Http\Response
     */
    public function update(CocheCreateRequest $request, Coche $coche)
    {
        $mensaje = [];
        //EScribimos el mensaje a mostrar
        $mensaje['texto'] = 'El ' . $coche->marca .' ' . $coche->modelo . ' ha sido modificado correctamente';
        //Este especifica el tipo de mensaje
        $mensaje['tipo'] = 'success';
        
        try {
                $realizado = $coche->update($request->all());
            } catch(\Exception $e) {
                $mensaje['texto'] = 'El coche no ha podido modificarse';
                $mensaje['tipo'] = 'danger';
            }
            
        return redirect('coche')->with($mensaje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coche  $coche
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coche $coche)
    {
        
        $mensaje = [];
        $mensaje['texto'] = 'El ' . $coche->marca .' ' . $coche->modelo . ' ha sido borrado correctamente';
        $mensaje['tipo'] = 'success';
        
        try {
             //Con este metodo eliminamos el puesto en concreto, que nos llega. 
             $coche->delete();
            } catch(\Exception $e) {
            $mensaje['texto'] = 'El ' . $coche->marca .' ' . $coche->modelo . ' no ha sido borrado correctamente';
            $mensaje['tipo'] = 'danger';
            }
            
            return redirect('coche')->with($mensaje);
    }
    
    //Nueva ruta que lo que hace es llevarte a un formulario y permitir subir una imagen
    function imagen(Coche $coche) {
        return view('imagen.create', ['coche' => $coche]);
    }
    
    function upload(Request $request, Coche $coche) {
        $input = 'photo';
        
        //Aqui vamos a comprobar si ese trabajador tiene una foto subida para borrar el registro
                 $exists = file_exists( 'upload/' . $coche->id);
                 
                 
                 
                 if($exists == true){
                     
                        File::delete('upload/' . $coche->id);
                        
                        $consultaImagen = DB::select('SELECT * FROM imagen WHERE idcoche  =' . $coche->id);

                        $imagenBorrar = new Imagen();
                        
                        $imagenBorrar->id = $consultaImagen[0]->id;
                        $imagenBorrar->idcoche = $consultaImagen[0]->idcoche;
                        $imagenBorrar->nombre = $consultaImagen[0]->nombre;
                        $imagenBorrar->tipo = $consultaImagen[0]->tipo;
                        
                        //Duda preguntar a carmelo
                        $imagenBorrar->delete();

                        
                 }
                 
                 
        
        if($request->hasFile($input) && $request->file($input)->isValid()) {
            
         $archivo = $request->file($input); // $request->file
         $tipoArchivo = $request->file($input)->getMimeType();
         $archivo->move('upload/', $coche->id);
         
         
         $imagenGuardar = new Imagen();
         $imagenGuardar->idcoche = $coche->id;
         $imagenGuardar->nombre = $request->nombre;
         $imagenGuardar->tipo = $tipoArchivo;
         
         
         //Creamos un try catch para que en caso de que salte una excepcion cuando
        //se almacene el nuevo puesto en la base de datos realize una cosa u otra
        try {
            $realizado = $imagenGuardar->save();
        } catch(\Exception $e) {
            $realizado = false;
        }
    }
    
    return back()->withInput();
    
    }
}
