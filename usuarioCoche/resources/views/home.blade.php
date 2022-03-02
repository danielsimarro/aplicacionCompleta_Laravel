@extends('layouts.app')

@section('content')
<div class="container">

    <div class="p-2 mb-2 bg-light rounded-3" id="fondoCrear">
        @if(Session::has('texto'))
            <div class="alert alert-{{ session()->get('tipo') }}" role="alert">
                {{ session()->get('texto') }}
            </div>
        @endif
      <div class="container-fluid py-5">
          
        <h1 class="display-5 fw-bold">Gestionar Coches</h1>
        <br>
        <p class="col-md-8 fs-4">
          <a href="{{ url('categoria') }}" class="btn btn-dark">Crear Categoria</a>
        </p>
        
        <p class="col-md-8 fs-4">
          <a href="{{ url('coche') }}" class="btn btn-dark">Crear Coche</a>
        </p>
        
        @if(auth()->user()->rol=='admin')
        <p class="col-md-8 fs-4">
            <a href="{{url('user')}}" class="btn btn-primary">Gestionar usuarios</a>
        </p>
        @endif

        
      </div>
    </div>
    
    <div class="card m-4" id="edicion">
                <div class="card-header">Edicion del usuario</div>
                <div class="card-body">
                    @include('auth.useredit')
                </div>
    </div>
</div>

@endsection

<style>
    body{
            background: url(fondo.jpg) no-repeat center center fixed;
            background-size: cover;
        
        }
    
    #fondoCrear{
        background: url(marmol.jpg) no-repeat center top fixed;
        background-size: cover;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        border-radius:4px;
    }
    
</style>

@section('script')
    <script type="text/javascript" src="{{url('assets/js/useredit.js')}}">
    </script>
@endsection
