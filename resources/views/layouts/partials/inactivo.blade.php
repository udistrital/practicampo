@extends('layouts.app')
<!-- end HTML HEAD -->
@section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Editar Usuario') }}</div>
    
                    <div class="card-body">
                        {{-- <form method="POST" action="{{ url('users',$usuario->id) }}">
                            @method('PUT')
                            @csrf

                        </form> --}}
                        <h6>Usuario Inactivo</h6>
                    </div>
                </div>
                <br>
            </div>
        </div>
        
    @endsection 