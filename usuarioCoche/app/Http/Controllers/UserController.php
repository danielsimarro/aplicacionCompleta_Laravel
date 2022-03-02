<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller{
   
   public function __construct(){
       $this->middleware('verified')->only('userupdate');
       $this->middleware('admin')->except('userupdate');
       /*$this->middleware('editUser')->only('edit');*/
   }
   
    public function index(){
        //paginacion
        
        //ordenacion
        
        //filtrado de datos
        
        //registros por pagina
        return view('user.index',['users' => User::all()]);
    }

    
    public function create(){
        return view('user.create',['roles'=>['admin','user']]);
    }

   
    public function store(Request $request){
        $user=new User($request->all());
        $user->password = Hash::make($request->input('password'));
        
        if($request->verified=='true'){
            $user->email_verified_at=Carbon::now();
        }
        
        try{
            $user->save();
            if($request->verified!='true'){
                $user->sendEmailVerificationNotification();
            }
        }catch(\Exception $e){
            return back()->withInput();
        }
        return redirect('home');
        
    }

   
    public function show(User $user){
        
    }

   
    public function edit(User $user){
        return view('user.edit',['roles'=>['admin','user'],'user'=>$user]);
    }

    public function userupdate(UserEditRequest $request){
        
        $mensaje = [];
        
        if($request->password !=null && $request->oldpassword !=null){
            //Cambiar clave
            $r= Hash::check($request->oldpassword, auth()->user()->password);
            if($r){
                $result = $this->userSave($request,true);
            }else{
                //Error
                return back()->withInput()->withErrors(['oldpassword' => 'La clave de acceso anterior no es correcta.']);
            }
        }elseif($request->password ==null && $request->oldpassword ==null){
            $result = $this->userSave($request,false);
        }else{
            //Error
            return back()->withInput()->withErrors(['generic' => 'Se han de introducir las claves de acceso o no.']);
        }
        if($result){
            $mensaje['texto'] = 'La modificacion ha sido correcta';
            $mensaje['tipo'] = 'success';
        }else{
            $mensaje['texto'] = 'Algo ha salido mal';
            $mensaje['tipo'] = 'danger';
        }
        return redirect('home')->with($mensaje);
    }
    
    
    public function userSave(Request $request, $isNewPassword){
        $result=true;
        $user = auth()->user();
        $user->name = $request->input('name'); //$request->name
        if($user->email != $request->input('email')){
            $user->email = $request->input('email');
            //Anular la fecha de verificacion
            //Enviar un correo electronico
            $user->email_verified_at =null;
        }
        
        if($isNewPassword){
             $user->password = Hash::make($request->input('password'));
        }
        try{
            $user->save();
            $user->sendEmailVerificationNotification();
        }catch(\Exception $e){
            $result = false;
        }
        return $result;
    }
    
    public function update(Request $request, User $user){
        //$user->update($request->all());
        if($request->password==null){
            $data=$request->except(['password']);
        }else{
            $data=$request->all();
            $data['password']=Hash::make($request->input('password'));
        }
        try{
            $user->update($data);
            $mensaje['texto'] = 'Las modificaciones han sido realizadas correctamente';
            $mensaje['tipo'] = 'success';
        }catch(\Exception $e){
            $mensaje['texto'] = 'Algo ha salido mal';
            $mensaje['tipo'] = 'danger';
        }
         
        return redirect('user')->with($mensaje);
    }


    public function destroy(User $user){
        
        
        $mensaje = [];
        $mensaje['texto'] =  $user->name . ' ha sido borrado correctamente';
        $mensaje['tipo'] = 'success';
        
        try {
             //Con este metodo eliminamos el puesto en concreto, que nos llega. 
             $user->delete();
            } catch(\Exception $e) {
            $mensaje['texto'] = $user->name . ' no ha sido borrado correctamente';
            $mensaje['tipo'] = 'danger';
            }
            
            return redirect('user')->with($mensaje);
    }
}
