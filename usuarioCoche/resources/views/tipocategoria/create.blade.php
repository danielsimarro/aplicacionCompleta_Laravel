@extends('base')

@section('content')
<h1>Relacionar categorias con coches</h1>
@if(Session::has('message'))
    <div class="alert alert-{{ session()->get('type') }}" role="alert">
        {{ session()->get('message') }}
    </div>
@endif

<form action="{{ url('tipocategoria') }}" method="post">
    @csrf
    
     <div class="form-group">
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
    @enderror
    
    <div class="form-group">
    <label for="coche">Selecciona un coche</label>
    <select name="idcoche" id="coche" class="form-control" >
        <option selected  value="">&nbsp</option>
         @foreach ($coches as $coche)
            <option value="{{ $coche->id}}">{{ $coche->marca . ' ' . $coche->modelo }}</option>
        @endforeach
    </select>
    </div>
    @error('idcoche')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    

    <input id="enviar" type="submit" value="Relaciona categoria" class="btn btn-success"/>
</form>

<a href="{{ url('tipocategoria') }}" class="btn btn-secondary" id="volver">Volver</a>

@endsection