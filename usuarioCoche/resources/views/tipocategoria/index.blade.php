@extends('base')

@section('content')



<h1>Relacionar tablas de categoria y coche</h1>
@if(Session::has('texto'))
    <div class="alert alert-{{ session()->get('tipo') }}" role="alert">
        {{ session()->get('texto') }}
    </div>
@endif


<a href="{{ url('tipocategoria/create') }}" class="btn btn-primary">Crear nueva relación</a>

<a href="{{ url('/') }}" class="btn btn-secondary" >Volver</a>

@endsection