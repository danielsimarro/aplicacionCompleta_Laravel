@extends('base')

@section('content')

<div class="modal" id="modalDelete" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar borrado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Confirmar borrar {{ $coche->marca . ' ' . $coche->modelo }}?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="modalDeleteResourceForm" action="{{ url('coche/' . $coche->id) }}" method="post">
            @method('delete')
            @csrf
            <input type="submit" class="btn btn-primary" value="Borrar coche"/>
        </form>
      </div>
    </div>
  </div>
</div>

<h1>Vista de la tabla: {{ $coche->marca . ' ' . $coche->modelo }}</h1>
@if(Session::has('texto'))
    <div class="alert alert-{{ session()->get('tipo') }}" role="alert">
        {{ session()->get('texto') }}
    </div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <td>
                Atributos
            </td>
            <td>
                Valores
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Id</td>
            <td>{{ $coche->id }}</td>
        </tr>
        <tr>
            <td>Marca</td>
            <td>{{ $coche->marca }}</td>
        </tr>
        <tr>
            <td>Modelo</td>
            <td>{{ $coche->modelo }}</td>
        </tr>
        <tr>
            <td>Color</td>
            <td>{{ $coche->color }}</td>
        </tr>
        <tr>
            <td>Precio</td>
            <td>{{ $coche->precio }} €</td>
         
        <tr>
            <td>Categorias:</td>
            @foreach ($nombre as $nom)
                <td>{{ $nom->nombre }}</td>
            @endforeach
        </tr>
        @if(auth()->user()->rol=='admin')
        <tr>
            <td>Eliminar categoria:</td>
            @foreach ($idtipo as $idtip)
                
                    <td>
                    <form action="{{ url('tipocategoria/' . $idtip->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <input type="submit" class="btn btn-danger" value="Borrar"/>
                    </form>
        
                    </td>
            @endforeach
        </tr>
        @endif
    </tbody>
</table>

@if(auth()->user()->rol=='admin')
<!--Formulario para asignar nueva categoria-->
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
    
    <input name="idcoche" type="hidden" value="{{ $coche->id }}">
    

    <input id="enviar" type="submit" value="Asignar categoria" class="btn btn-success"/>
</form>
@endif

<br>

<?php $exists = file_exists( 'upload/' . $coche->id );?>

@if($exists == 1)
<!--Mostrar imagen en el html-->
<div class="contIMG">
    <img src="{{ url('upload/' . $coche->id) }}">
</div>

@if(auth()->user()->rol=='admin')
<form action="{{ url('imagen/' . $idimagen) }}}" method="post">
                        @method('delete')
                        @csrf
                        
                        <input type="submit" class="btn btn-danger" value="Borrar" id="flotarBtn"/>
</form>
@endif
@endif
<div class="contBtn">
    @if(auth()->user()->rol=='admin')
<a href="{{ url('coche/' . $coche->id .  '/imagen') }}" class="btn btn-success" id="flotarBtn1">Subir imagen</a>
    @endif

<a href="{{ url('coche') }}" class="btn btn-secondary" id="flotarBtn">Volver</a>
</div>
<style>
    #flotarBtn{
        float:left;
        margin: 0 20px;
        
    }
    
    #flotarBtn1{
        float:left;
        margin-right:20px
        
    }
    
    .contBtn{
        height:40px;
    }
</style>

@endsection

@section('js')
<script src="{{ url('assets/js/deleteTipo.js') }}"></script>
@endsection