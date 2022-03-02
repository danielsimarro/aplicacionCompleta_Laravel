<div class="modal" id="modalUpload" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Subir archivo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Subir imagen</p>
        <p>
            <input type="file" name="photo" form="uploadForm" accept="image/*" class="form-control"/>
            </br>
            <input value="{{ old('nombre') }}" type="text" name="nombre" placeholder="Introduce el nombre" form="uploadForm" id="nombre" minlength="2" maxlength="100" required class="form-control-plaintext">
    
    
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form  id="uploadForm" action="{{ url('coche/' . $coche->id .  '/upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="submit" class="btn btn-primary" value="Subir"/>
            
        </form>
      </div>
    </div>
  </div>
</div>
@extends('base')

@section('content')
<h1>Subir imagen del coche</h1>
@if(Session::has('message'))
    <div class="alert alert-{{ session()->get('type') }}" role="alert">
        {{ session()->get('message') }}
    </div>
@endif
    
    <input  id="enviarimg" type="button" name="btUpdate" value="Subir imagen" class="btn btn-info"  data-bs-toggle="modal" data-bs-target="#modalUpload" required/>

<a href="{{ url('imagen') }}" class="btn btn-success" id="btnImgCreat">Tabla imagenes</a><br>

<a href="{{ url('coche/' . $coche->id) }}" class="btn btn-secondary" id="volver">Volver</a>
<style>
  #btnImgCreat, #volver{
    margin-top:25px;
    width:200px;

  }
</style>
@endsection


