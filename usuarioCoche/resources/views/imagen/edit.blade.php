
@extends('base')

@section('content')
<h1>Edit de la tabla: {{ $imagen->nombre }}</h1>
@if(Session::has('texto'))
    <div class="alert alert-{{ session()->get('tipo') }}" role="alert">
        {{ session()->get('texto') }}
    </div>
@endif
<form action="{{ url('imagen/' . $imagen->id) }}" method="post">
    @csrf
    @method('put')
    <div class="form-group row">
     <label for="nombre" class="col-sm-2 col-form-label">Nombre del archivo</label>
    <div class="col-sm-10">
      <input value="{{ old('nombre',$imagen->nombre) }}" type="text" name="nombre" placeholder="Introduce el nombre" id="nombre" minlength="2" maxlength="100" required class="form-control-plaintext">
    </div>
    @error('nombre')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    

    <input id="enviar" type="submit" value="Editar imagen" class="btn btn-success"/>
</form>



<a href="{{ url('imagen') }}" class="btn btn-secondary"  id="volver" >Volver</a>

@endsection