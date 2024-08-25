<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Registro Proyección Preliminar N° ') }}<?php echo $proyeccion_preliminar->id?><?php echo "\t -"?>
                        {{ __('') }}</div>
                        {{-- <php if($estado_doc_respon == 1){ echo $nombre_doc_resp;} elseif ($estado_doc_respon == 2){ echo "Usuario Inactivo";}?> --}}
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('proy_duplicar',Crypt::encrypt($proyeccion_preliminar->id)) }}" id="edit_proyeccion">
                            {{-- @method('PUT') --}}
                            @csrf

                            @if(Auth::user()->admin())
                                @include('proyecciones.formularios.edit_admin',array($proyeccion_preliminar,$programas_usuario, 
                                $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                $all_programas_aca, $all_espacios_aca))
                            @endif

                            @if(Auth::user()->decano())
                                @include('proyecciones.formularios.edit_dec',array($proyeccion_preliminar,$programas_usuario, 
                                $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                            @endif

                            @if(Auth::user()->asistenteD())
                                @include('proyecciones.formularios.edit_asisDec',array($proyeccion_preliminar,$programas_usuario, 
                                $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes, 
                                $all_programas_aca, $all_espacios_aca))    
                            @endif 

                            @if(Auth::user()->coordinador())
                                <!-- usuario != al responsable de la proyección -->
                                @if($usuario_log->id != $proyeccion_preliminar->id_docente_responsable)
                                    @include('proyecciones.formularios.edit_coord',array($proyeccion_preliminar,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                                @endif
                                <!-- usuario != al responsable de la proyección -->

                                <!-- usuario == al responsable de la proyección -->
                                @if($usuario_log->id == $proyeccion_preliminar->id_docente_responsable)
                                    @include('proyecciones.formularios.edit_coord_creador',array($proyeccion_preliminar,$programas_usuario, 
                                    $espacios_academicos,$periodos_academicos,$semestres_asignaturas, $tipos_transportes))
                                @endif
                                <!-- usuario == al responsable de la proyección -->
                            @endif


                            @if(Auth::user()->docente())
                                @include('proyecciones.formularios.ver',array($proyeccion_preliminar,$programas_usuario, 
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