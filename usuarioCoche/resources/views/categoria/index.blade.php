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
         <p>¿Seguro que quieres borrar <span id="deleteCategoria">XXX</span>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="modalDeleteResourceForm" action="" method="post">
            @method('delete')
            @csrf
            <input type="submit" class="btn btn-primary" value="Borrar categoria"/>
        </form>
      </div>
    </div>
  </div>
</div>

<h1>Tabla categoria</h1>
@if(Session::has('texto'))
    <div class="alert alert-{{ session()->get('tipo') }}" role="alert">
        {{ session()->get('texto') }}
    </div>
@endif

@if(auth()->user()->rol=='admin')
<a href="{{ url('categoria/create') }}" class="btn btn-primary">Crear una nueva categoria</a>
@endif

<table class="table table-striped table-dark mt-4">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Categoria</th>
            <th scope="col">Descripción</th>
            <th scope="col">Funciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $categoria)
            <tr>
                <td>
                    {{ $categoria->id }}
                </td>
                <td>
                    {{ $categoria->nombre }}
                </td>
                <td>
                    {{ $categoria->descripcion }}
                </td>
                <td>
                    <a href="{{ url('categoria/' . $categoria->id) }}" class="btn btn-light">Visualizar</a>
                    @if(auth()->user()->rol=='admin')
                    <a href="{{ url('categoria/' . $categoria->id . '/edit') }}" class="btn btnlef btn-dark">Editar</a>
                    
                    <a href="javascript: void(0);" 
                       data-name="{{ $categoria->nombre }}"
                       data-url="{{ url('categoria/' . $categoria->id) }}"
                       data-bs-toggle="modal"
                       data-bs-target="#modalDelete"
                        class="btn btnlef btn-danger">Borrar</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ url('home') }}" class="btn btn-secondary">Volver a la ventana principal</a>

<style>
    
    .btnlef{
        margin-left: 10px;
    }
    
    .btn{
        margin-top: 10px;
    }
    
</style>
@endsection



@section('js')
<script src="{{ url('assets/js/deleteCategoria.js') }}"></script>
@endsection