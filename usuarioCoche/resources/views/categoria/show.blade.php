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
        <p>Confirmar borrar {{ $categoria->nombre }}?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="modalDeleteResourceForm" action="{{ url('categoria/' . $categoria->id) }}" method="post">
            @method('delete')
            @csrf
            <input type="submit" class="btn btn-primary" value="Borrar puesto"/>
        </form>
      </div>
    </div>
  </div>
</div>

<h1>Vista de la tabla: {{ $categoria->nombre }}</h1>
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
            <td>{{ $categoria->id }}</td>
        </tr>
        <tr>
            <td>Nombre</td>
            <td>{{ $categoria->nombre }}</td>
        </tr>
        <tr>
            <td>Descripción</td>
            <td>{{ $categoria->descripcion }}</td>
        </tr>

    </tbody>
</table>

@if(auth()->user()->rol=='admin')
<a href="{{ url('categoria/' . $categoria->id . '/edit') }}" class="btn btn-dark">Editar</a>

<a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#modalDelete" class="btn btn-danger">Borar</a>

@endif

<a href="{{ url('categoria') }}" class="btn btn-secondary" >Volver</a>

@endsection