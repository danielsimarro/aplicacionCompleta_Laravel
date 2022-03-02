@extends('layouts.app')
@section('content')
<div class="col-md-10" style="margin:0 auto">
  @if(Session::has('texto'))
    <div class="alert alert-{{ session()->get('tipo') }}" role="alert">
        {{ session()->get('texto') }}
    </div>
@endif
  <a class="btn btn-primary" href="{{url('user/create')}}">Nuevo usuario</a><a href="{{ url('home') }}" class="btn btn-secondary" id="btnIndexUser">Volver a la ventana principal</a><br><br>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Numero</th>
        <th scope="col">#id</th>
        <th scope="col">Nombre</th>
        <th scope="col">Email</th>
        <th scope="col">Verificación</th>
        <th scope="col">Rol</th>
        <th scope="col">Editar</th>
        <th scope="col">Borrar</th>
      </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->email_verified_at}}</td>
            <td>{{$user->rol}}</td>
            <td><a class="btn btn-warning" href="{{url('user/'.$user->id.'/edit')}}">Editar</a></td>
            <td>
              @if(auth()->user()->id != $user->id)
                <form action="{{ url('user/' . $user->id) }}}" method="post">
                        @method('delete')
                        @csrf
                        
                        <input type="submit" class="btn btn-danger" value="Borrar" id="flotarBtn"/>
                </form>
              @endif
            </td>
          </tr>  
        @endforeach
      
    </tbody>
  </table>
</div>

<style>
  #btnIndexUser{
    margin-left:10px;
  }
</style>

@endsection