@extends('base')

@section('content')
<h1>Crear categoria</h1>
@if(Session::has('message'))
    <div class="alert alert-{{ session()->get('type') }}" role="alert">
        {{ session()->get('message') }}
    </div>
@endif

<form action="{{ url('categoria') }}" method="post">
    @csrf
     <div class="form-group row">
     <label for="nombre" class="col-sm-2 col-form-label">Nombre de la categoria</label>
    <div class="col-sm-2">
      <input value="{{ old('nombre') }}" type="text" name="nombre" placeholder="Introduce el nombre" id="nombre" minlength="2" maxlength="80" required class="form-control-plaintext">
    </div>
    @error('nombre')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <div class="form-group row">
     <label for="descripcion" class="col-sm-2 col-form-label">Descripcion de la categoria</label>
    <div class="col-sm-2">
      <textarea name="descripcion" id="descripcion" placeholder="Introduce la descripcion" minlength="2" maxlength="1000" required class="form-control-plaintext" rows="4" cols="400">{{ old('descripcion') }}</textarea> 
    </div>
    @error('descripcion')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    

    <input id="enviar" type="submit" value="Crear categoria" class="btn btn-success"/>
</form>

<a href="{{ url('categoria') }}" class="btn btn-secondary" id="volver">Volver</a>
@endsection