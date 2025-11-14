<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Registro Programación Preliminar N° ') }}<?php echo $programacion_practica->id?><?php echo "\t -"?>
                        {{ __('') }}</div>
                        {{-- <php if($estado_doc_respon == 1){ echo $nombre_doc_resp;} elseif ($estado_doc_respon == 2){ echo "Usuario Inactivo";}?> --}}
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('proy_duplicar',Crypt::encrypt($programacion_practica->id)) }}" id="edit_programacion">
                            {{-- @method('PUT') --}}
                            @csrf

                            @if(Auth::user()->admin())
                                @include('programaciones.formularios.edit_admin',array($programacion_practica,$programas_usuario, 
                                $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                $all_programas_aca, $all_espacios_aca))
                            @endif

                            @if(Auth::user()->decano())
                                @include('programaciones.formularios.edit_dec',array($programacion_practica,$programas_usuario, 
                                $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                            @endif

                            @if(Auth::user()->asistenteD())
                                @include('programaciones.formularios.edit_asisDec',array($programacion_practica,$programas_usuario, 
                                $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                $all_programas_aca, $all_espacios_aca))    
                            @endif 

                            @if(Auth::user()->coordinador())
                                <!-- usuario != al responsable de la Programación -->
                                @if($usuario_log->id != $programacion_practica->id_docente_responsable)
                                    @include('programaciones.formularios.edit_coord',array($programacion_practica,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                                @endif
                                <!-- usuario != al responsable de la Programación -->

                                <!-- usuario == al responsable de la Programación -->
                                @if($usuario_log->id == $programacion_practica->id_docente_responsable)
                                    @include('programaciones.formularios.edit_coord_creador',array($programacion_practica,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                                @endif
                                <!-- usuario == al responsable de la Programación -->
                            @endif


                            @if(Auth::user()->docente())
                                @include('programaciones.formularios.ver',array($programacion_practica,$programas_usuario, 
                                $espacios_academicos, $periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                            @endif

                            <!-- 25 -->
                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-5">
                                    <br>
                                    <button type="submit" class="btn btn-success" id="edit_proy" name="edit_proy" onclick="valid_edit_proy()">
                                        {{ __('Duplicar') }}
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