@extends('base')

@section('content')
<h1>Crear coche</h1>
@if(Session::has('message'))
    <div class="alert alert-{{ session()->get('type') }}" role="alert">
        {{ session()->get('message') }}
    </div>
@endif

<form action="{{ url('coche') }}" method="post">
    @csrf
     <div class="form-group row">
     <label for="marca" class="col-sm-2 col-form-label">Marca</label>
    <div class="col-sm-2">
      <input value="{{ old('marca') }}" type="text" name="marca" placeholder="Introduce la marca" id="marca" minlength="2" maxlength="50" required class="form-control-plaintext">
    </div>
    @error('marca')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <div class="form-group row">
     <label for="modelo" class="col-sm-2 col-form-label">Modelo</label>
    <div class="col-sm-2">
      <input value="{{ old('modelo') }}" type="text" name="modelo" placeholder="Introduce el modelo" id="modelo" minlength="2" maxlength="70" required class="form-control-plaintext">
    </div>
    @error('modelo')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <div class="form-group row">
     <label for="color" class="col-sm-2 col-form-label">Color</label>
    <div class="col-sm-2">
      <input value="{{ old('color') }}" type="text" name="color" placeholder="Introduce el color" id="color" minlength="2" maxlength="30" required class="form-control-plaintext">
    </div>
    @error('color')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <div class="form-group row">
     <label for="precio" class="col-sm-2 col-form-label">Precio</label>
    <div class="col-sm-3">
      <input value="{{ old('precio') }}" type="number" name="precio" placeholder="Introduce el precio" id="precio" min="0.01" max="99999999.99" step="0.01" required class="form-control-plaintext">
    </div>
    @error('precio')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <!--<div class="form-group">
    <label for="categoria">Selecciona la categoria</label>
    <select name="idcategoria" id="categoria" class="form-control" >
        <option selected  value="">&nbsp</option>
         @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id}}">{{ $categoria->nombre }}</option>
        @endforeach
    </select>
    </div>
    @error('idcategoria')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror-->
    

    <input id="enviar" type="submit" value="Crear coche" class="btn btn-success"/>
</form>

<a href="{{ url('coche') }}" class="btn btn-secondary" id="volver">Volver</a>

@endsection