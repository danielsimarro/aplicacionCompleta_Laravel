@extends('admin.base')

@section('content')


<div class="modal" id="modalDelete" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar borrado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <p>¿Seguro que quieres borrar <span id="deleteCoche">XXX</span>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="modalDeleteResourceForm" action="" method="post">
            @method('delete')
            @csrf
            <input type="submit" class="btn btn-primary" value="Borrar coche"/>
        </form>
      </div>
    </div>
  </div>
</div>

<h1>Tabla coches</h1>
@if(Session::has('texto'))
    <div class="alert alert-{{ session()->get('tipo') }}" role="alert">
        {{ session()->get('texto') }}
    </div>
@endif
@if(auth()->user()->rol=='admin')
<a href="{{ url('coche/create') }}" class="btn btn-primary">Crear un nuevo coche</a>
@endif
<a href="{{ url('home') }}" class="btn btn-secondary">Volver a la ventana principal</a>
<div id="contMedia">
    <p>La media de los precios es de : <span><?php echo round($precio, 2)?> €</span></p>
</div>
<table class="table table-striped table-dark">
    <thead>
        <tr>
            <th scope="col">
                <a href="{{ route('coche.index', $orderidasc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg></a>
                 id
                <a href="{{ route('coche.index', $orderiddesc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg></a></a>
            </th>
            <th scope="col">
                 <a href="{{ route('coche.index', $ordermarcaasc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg></a>
                Marca
                <a href="{{ route('coche.index', $ordermarcadesc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg></a>
            </th>
            <th scope="col">
                <a href="{{ route('coche.index', $ordermodeloasc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg></a>
                Modelo
                <a href="{{ route('coche.index', $ordermodelodesc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg></a>
            </th>
            <th scope="col">
                <a href="{{ route('coche.index', $ordercolorasc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg></a>
                Color
                <a href="{{ route('coche.index', $ordercolordesc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg></a>
            </th>
            <th scope="col">
                <a href="{{ route('coche.index', $orderprecioasc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg></i></a>
                Precio
                <a href="{{ route('coche.index', $orderpreciodesc) }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg></a>
            </th>
            <th scope="col" colspan="3">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($coches as $coche)
            <tr>
                <td>
                    {{ $coche->id }}
                </td>
                <td>
                    {{ $coche->marca }}
                </td>
                <td>
                    {{ $coche->modelo }}
                </td>
                <td>
                    {{ $coche->color }}
                </td>
                <td>
                    {{ $coche->precio }} €
                </td>
                <td>
                    <a href="{{ url('coche/' . $coche->id) }}" class="btn btn-success">Asignar Categoria</a>
                
                @if(auth()->user()->rol=='admin')
                    <a href="{{ url('coche/' . $coche->id . '/edit') }}" class="btnlef btn btn-dark">Editar</a>
                
                    <a href="javascript: void(0);" 
                       data-name="{{ $coche->nombre }}"
                       data-url="{{ url('coche/' . $coche->id) }}"
                       data-bs-toggle="modal"
                       data-bs-target="#modalDelete"
                        class=" btnlef btn btn-danger">Borrar</a>
                @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- $performances->appends(['sort' => 'name'])->onEachSide(2)->links() --}}

{{ $coches->onEachSide(1)->links() }}

<nav>
    <ul class="pagination">
        @foreach ($rpps as $linkData)
            <li class="page-item @if($rpp == $linkData['rpp']) active @endif">
                <a href="{{ route('coche.index', $linkData) }}" class="page-link">{{ $linkData['rpp'] }}</a>
            </li>
        @endforeach
        <li class="page-item">
            <a href="#" class="page-link">Paginar por filas</a>
        </li>
    </ul>
</nav>

<style>
    

    .table{
        margin-top:30px;
        width:100%;
    }
    
    .btnlef{
        margin-left: 10px;
    }
    .w-5, h-5{
        height:40px;
        width:40px;
        color:#3E85DA;
    }
    
    .flex > .justify-between{
        display:none;
    }
    
    .bi{
        margin:0 5px;
    }
    
    .pagination{
        margin-top:20px;
    }
    
    #contMedia{
        height:40px;
        margin-top:20px;
        display: flex;
        align-items:center;
        width: 400px;
    }
    
    #contMedia > p{

        line-height:50px;
        height:100%;
        font-size: 1.2em;
        color:black;
        
    }
    
    #contMedia > p > span{
        color: gray;
        font-size: 1.3em;
    }
    
    
</style>
@endsection


@section('js')
<script src="{{ url('assets/js/deleteCoche.js') }}"></script>
@endsection