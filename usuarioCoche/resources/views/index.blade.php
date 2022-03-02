@php
    use App\Http\Controllers\IndexController;
@endphp

@extends('base')

@section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Creacion de cohes</h1>
        <br>
        <p class="col-md-8 fs-4">
          <a href="{{ url('categoria') }}" class="btn btn-secondary">Crear Categoria</a>
        </p>
        
        <p class="col-md-8 fs-4">
          <a href="{{ url('coche') }}" class="btn btn-secondary">Crear Coche</a>
        </p>
        
      </div>
    </div>
    
@endsection

