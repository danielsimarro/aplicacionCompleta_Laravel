@extends('layouts.app')
@section('content')


<div class="col-md-10" style="margin:0 auto">
<form method="POST" id="fuseredit" action="{{route('user.store')}}">
    @csrf
    <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="Password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

        <div class="col-md-6">
            <input id="Password" type="Password" minlenght="8" class="form-control @error('Password') is-invalid @enderror" name="Password" value="{{ old('Password')}}" required autocomplete="new Password">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">Role</label>

        <div class="col-md-6">
            <select id="rol"class="form-control" name="rol" required>
                    <option value="" @if(old('rol')=='') selected @endif disabled>&nbsp;</option>
                    @foreach($roles as $rol)
                        <option value="{{$rol}}" @if(old('rol')==$rol) selected @endif>{{$rol}}</option>
                    @endforeach
                </select>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    
    <div class="row mb-3">
        <label for="Verified" class="col-md-4 col-form-label text-md-end">Verified</label>

        <div class="col-md-6">
            <input id="Verified" type="checkbox" class="form-control" name="verified" value="true" @if(old('verified') != "") checked @endif>
        </div>
    </div>
   
    <div class="row mb-3">

        <div class="col-md-6">
           <button type="submit" id="userupdatebuton" class="btn btn-primary">
               Crear
           </button>
           <a href="{{ url('user') }}" class="btn btn-secondary" id="volver">Volver</a>
        </div>
    </div>
</form>
</div>
@endsection