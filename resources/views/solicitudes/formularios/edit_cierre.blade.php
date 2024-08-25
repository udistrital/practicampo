<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                        <div class="card-header">{{ __('Registro Solicitud Práctica N° ') }}<?php echo $solicitud_practica->id?>
                        {{ __('') }}</div>
                    
                        <div class="card-body">
                            <form method="POST" action="{{ route('solic_cierre',[Crypt::encrypt($proyeccion_preliminar->id)]) }}">
                                @method('PUT')
                                @csrf

                                @if(Auth::user()->asistenteD() || Auth::user()->admin())
                                    @include('solicitudes.formularios.edit_asisDec',array($proyeccion_preliminar,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                    $all_programas_aca, $all_espacios_aca, $costos_proyeccion,
                                    $tipo_ruta))    
                                @endif 
                                <!-- 25 -->
                                <div class="form-group row mb-0">
                                    <div class="col-md-5 offset-md-5">
                                        <br>
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Guardar') }}
                                        </button>
                                    </div>
                                </div>
                                <!-- 25 -->
                            </form>
                        </div>
                    
                </div>
                <br>
            </div>
        </div>
        
    @endsection  