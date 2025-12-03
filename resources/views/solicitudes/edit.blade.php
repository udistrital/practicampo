<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-lg-11 col-md-11">
                <div class="card">
                    {{-- <div class="card-header">{{ __('Registro Solicitud Práctica N° ') }}<php echo $solicitud_practica->id_programacion_practica?> <php echo "\t -"?> --}}
                        <div class="card-header" id="num_docen" name="{{$programacion_practica->id_docente_responsable}}">{{ __('Registro Solicitud Práctica N° ') }}<?php echo $solicitud_practica->id?>
                        {{ __('') }}</div>
                        {{-- <php if($estado_doc_respon == 1){ echo $nombre_doc_resp;} elseif ($estado_doc_respon == 2){ echo "Usuario Inactivo";}?> --}}
                    
                        <div class="card-body">
                            <form method="POST" action="{{ route('solicitud_update',[Crypt::encrypt($programacion_practica->id), Crypt::encrypt($tipo_ruta)]) }}" id="edit_solicitud" onsubmit="return confirmarGuardar(event)">
                                @method('PUT')
                                @csrf

                                @if(Auth::user()->admin())
                                    @include('solicitudes.formularios.edit_admin',array($programacion_practica,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                    $all_programas_aca, $all_espacios_aca))
                                @endif

                                @if(Auth::user()->decano())
                                    @include('solicitudes.formularios.edit_dec',array($programacion_practica,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, $costos_programacion,))
                                @endif

                                @if(Auth::user()->asistenteD())
                                    @include('solicitudes.formularios.edit_asisDec',array($programacion_practica,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                    $all_programas_aca, $all_espacios_aca, $costos_programacion,
                                    $tipo_ruta))    
                                @endif 

                                @if(Auth::user()->coordinador())

                                    <!-- usuario != al responsable de la Programación -->
                                    @if($usuario_log->id != $programacion_practica->id_docente_responsable)
                                        @include('solicitudes.formularios.edit_coord',array($programacion_practica,$programas_usuario, 
                                        $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                                    @endif
                                    <!-- usuario != al responsable de la Programación -->

                                    <!-- usuario == al responsable de la Programación -->
                                    @if($usuario_log->id == $programacion_practica->id_docente_responsable)
                                        @include('solicitudes.formularios.edit_coord_creador',array($programacion_practica,$programas_usuario, 
                                        $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                                    @endif
                                    <!-- usuario == al responsable de la Programación -->
                                @endif


                                @if(Auth::user()->docente())
                                    @include('solicitudes.formularios.edit_docen',array($programacion_practica, $programas_academicos, $programas_usuario, 
                                    $espacios_academicos, $periodos_academicos, $semestres_asignaturas, $tipos_transportes, $nombre_usuario, $estado_doc_respon,
                                    $solicitud_practica, $costos_programacion, $docentes_practica, $mate_herra_programacion, $riesg_amen_practica, $transporte_programacion,
                                    $tipo_ruta))
                                @endif

                                @if(Auth::user()->transportador())
                                    @include('solicitudes.formularios.edit_transp',array($programacion_practica, $programas_academicos, $programas_usuario, 
                                    $espacios_academicos, $periodos_academicos, $semestres_asignaturas, $tipos_transportes, $nombre_usuario, $estado_doc_respon,
                                    $solicitud_practica, $transporte_programacion,
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