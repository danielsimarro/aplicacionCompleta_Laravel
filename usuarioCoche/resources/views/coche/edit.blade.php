@extends('base')

@section('content')
<h1>Editar la tabla: {{ $coche->marca .' '.   $coche->modelo}}</h1>
@if(Session::has('texto'))
    <div class="alert alert-{{ session()->get('tipo') }}" role="alert">
        {{ session()->get('texto') }}
    </div>
@endif
<form action="{{ url('coche/' . $coche->id) }}" method="post">
    @csrf
    @method('put')
    <div class="form-group row">
     <label for="marca" class="col-sm-2 col-form-label">Marca</label>
    <div class="col-sm-2">
      <input value="{{ old('marca',$coche->marca) }}" type="text" name="marca" placeholder="Introduce la marca" id="marca" minlength="2" maxlength="50" required class="form-control-plaintext">
    </div>
    @error('marca')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <div class="form-group row">
     <label for="modelo" class="col-sm-2 col-form-label">Modelo</label>
    <div class="col-sm-2">
      <input value="{{ old('modelo',$coche->modelo) }}" type="text" name="modelo" placeholder="Introduce el modelo" id="modelo" minlength="2" maxlength="70" required class="form-control-plaintext">
    </div>
    @error('modelo')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <div class="form-group row">
     <label for="color" class="col-sm-2 col-form-label">Color</label>
    <div class="col-sm-2">
      <input value="{{ old('color',$coche->color) }}" type="text" name="color" placeholder="Introduce el color" id="color" minlength="2" maxlength="30" required class="form-control-plaintext">
    </div>
    @error('color')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <div class="form-group row">
     <label for="precio" class="col-sm-2 col-form-label">Precio</label>
    <div class="col-sm-3">
      <input value="{{ old('precio',$coche->precio) }}" type="number" name="precio" placeholder="Introduce el precio" id="precio" min="0.01" max="99999999.99" step="0.01" required class="form-control-plaintext">
    </div>
    @error('precio')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <input id="enviar" type="submit" value="Editar coche" class="btn btn-success"/>
</form>

<a href="{{ url('coche') }}" class="btn btn-secondary"  id="volver" >Volver</a>

@endsection