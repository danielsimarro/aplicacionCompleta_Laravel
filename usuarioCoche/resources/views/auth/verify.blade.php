@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Antes de entrar en tu sesión tendras que verificar tu correo.') }}
                    {{ __('Si no has recibido el correo, pulsa en el boton') }}.
                    </br>
                    </br>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('Enviar correo') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
