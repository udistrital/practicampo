<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-lg-11 col-md-11">
                <div class="card">
                    {{-- <div class="card-header">{{ __('Registro Solicitud Práctica N° ') }}<php echo $solicitud_practica->id_proyeccion_preliminar?> <php echo "\t -"?> --}}
                        <div class="card-header" id="num_docen" name="{{$proyeccion_preliminar->id_docente_responsable}}">{{ __('Registro Solicitud Práctica N° ') }}<?php echo $solicitud_practica->id?>
                        {{ __('') }}</div>
                        {{-- <php if($estado_doc_respon == 1){ echo $nombre_doc_resp;} elseif ($estado_doc_respon == 2){ echo "Usuario Inactivo";}?> --}}
                    
                        <div class="card-body">
                            <form method="POST" action="{{ route('solicitud_update',[Crypt::encrypt($proyeccion_preliminar->id), Crypt::encrypt($tipo_ruta)]) }}" id="edit_solicitud">
                                @method('PUT')
                                @csrf

                                @if(Auth::user()->admin())
                                    @include('solicitudes.formularios.edit_admin',array($proyeccion_preliminar,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                    $all_programas_aca, $all_espacios_aca))
                                @endif

                                @if(Auth::user()->decano())
                                    @include('solicitudes.formularios.edit_dec',array($proyeccion_preliminar,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, $costos_proyeccion,))
                                @endif

                                @if(Auth::user()->asistenteD())
                                    @include('solicitudes.formularios.edit_asisDec',array($proyeccion_preliminar,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                    $all_programas_aca, $all_espacios_aca, $costos_proyeccion,
                                    $tipo_ruta))    
                                @endif 

                                @if(Auth::user()->coordinador())

                                    <!-- usuario != al responsable de la proyección -->
                                    @if($usuario_log->id != $proyeccion_preliminar->id_docente_responsable)
                                        @include('solicitudes.formularios.edit_coord',array($proyeccion_preliminar,$programas_usuario, 
                                        $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                                    @endif
                                    <!-- usuario != al responsable de la proyección -->

                                    <!-- usuario == al responsable de la proyección -->
                                    @if($usuario_log->id == $proyeccion_preliminar->id_docente_responsable)
                                        @include('solicitudes.formularios.edit_coord_creador',array($proyeccion_preliminar,$programas_usuario, 
                                        $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                                    @endif
                                    <!-- usuario == al responsable de la proyección -->
                                @endif


                                @if(Auth::user()->docente())
                                    @include('solicitudes.formularios.edit_docen',array($proyeccion_preliminar, $programas_academicos, $programas_usuario, 
                                    $espacios_academicos, $periodos_academicos, $semestres_asignaturas, $tipos_transportes, $nombre_usuario, $estado_doc_respon,
                                    $solicitud_practica, $costos_proyeccion, $docentes_practica, $mate_herra_proyeccion, $riesg_amen_practica, $transporte_proyeccion,
                                    $tipo_ruta))
                                @endif

                                @if(Auth::user()->transportador())
                                    @include('solicitudes.formularios.edit_transp',array($proyeccion_preliminar, $programas_academicos, $programas_usuario, 
                                    $espacios_academicos, $periodos_academicos, $semestres_asignaturas, $tipos_transportes, $nombre_usuario, $estado_doc_respon,
                                    $solicitud_practica, $transporte_proyeccion,
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