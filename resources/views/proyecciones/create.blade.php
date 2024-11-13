<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" id="num_docen" name="{{$usuario->id}}">{{ __('Registro Proyección Preliminar') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('proyeccion_store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- información proyección -->
                                <!-- 1 -->
                                    <div class="form-group row">
                                        <div class="col-md-4" id=programa_academico>
                                            <label for="id_programa_academico" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el programa académico asociado a la 
                                                salida de práctica académica" style="font-size: 0.813rem"></i> {{ __('Programa Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_programa_academico" name="id_programa_academico" class="form-control" required
                                            title=""  onchange="recargarEspacios_aca(this.value,'<?php echo $usuario->id?>',1)"
                                            >
                                                @foreach($programas_usuario as $prog_aca)
                                                    <option value="{{$prog_aca['id']}}" selected>{{$prog_aca['programa_academico']}}</option>  
                                                @endforeach
                                            </select>
                                            @error('id_programa_academico')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5" id=espacio_academico>
                                            <label for="id_espacio_academico" class="col-form-label text-md-right"><i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" data-title="Seleccione el espacio académico asociado a la 
                                                salida de práctica académica" style="font-size: 0.813rem"></i> {{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_espacio_academico" name="id_espacio_academico" class="form-control" required
                                            title=""
                                            >
                                            </select>
                                            
                                            @error('id_espacio_academico')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <label for="id_periodo_academico" class="col-form-label text-md-right"><i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" data-title="Indique el semestre de la asignatura, año y 
                                                    período académico asociados a la salida de práctica académica. Ej. V - 2022 - I"  
                                                    style="font-size: 0.813rem"></i> {{ __('Sem. - Año - Per.') }}</label>
                                                <span class="hs-form-required" title="Período Asignatura">*</span>
                                                <div class="row">
                                                    <div class="col-md-12" style="padding-left: 0;">
                                                        <div class="input-group">
                                                            <div class="col-md-4">
                                                                <select name="id_semestre_asignatura" class="form-control" required
                                                                title=""
                                                                style="padding-left: 0.1rem;padding-right: 0.1rem;">
                                                                    @foreach($semestres_asignaturas as $sem_asig)
                                                                        <option value="{{$sem_asig->id}}" selected>{{$sem_asig->semestre_asignatura}}</option>  
                                                                        
                                                                    @endforeach
                                                                </select>
                                                                @error('id_semestre_asignatura')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                                                <input id="anio_periodo" type="text" maxlength="4" class="inputDate form-control datetimepickerHr @error('anio_periodo') is-invalid @enderror" name="anio_periodo" 
                                                                style="padding-left: 0px;padding-right: 0px;border-top-right-radius: 0; border-bottom-right-radius: 0;"
                                                                onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                                value="" autocomplete="off" autofocus required>
                                                            </div>
                                                            <div class="col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                                                <select name="id_periodo_academico" class="form-control" required
                                                                title=""
                                                                style="padding-left: 0.1rem;padding-right: 0.1rem;border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                                    @foreach($periodos_academicos as $per_aca)
                                                                        <option value="{{$per_aca->id}}" selected>{{$per_aca->periodo_academico}}</option>  
                                                                        
                                                                    @endforeach
                                                                </select>
                                                                @error('id_periodo_academico')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <!-- 1 -->

                                <!-- Integradas -->
                                    <div  class="form-group row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="form-group">
                                                <label for="integrada" class="col-form-label text-md-left">
                                                    <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique si la salida de práctica académica es una práctica integrada con más de 
                                                    un espacio académico asociado" style="font-size: 0.813rem"></i> {{ __('Práctica Integrada?') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <div class="row">

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="integrada" id="integrada" value="1" 
                                                        title="">
                                                        <label class="form-check-label" for="">Si</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="integrada" id="integrada"  value="0" checked
                                                            title="">
                                                            <label class="form-check-label" for="">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2" id="c_espa_aca">
                                            <label for="cant_espa_aca" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la cantidad de espacios académicos asociados a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cant. Esp. Aca.') }}</label>
                                            <div class="input-group">
                                                <input id="cant_espa_aca" type="number" max="7" min="1" pattern="^[1-7]+" class="form-control @error('cant_espa_aca') is-invalid @enderror" name="cant_espa_aca" 
                                                title="Número de espacios académicos"
                                                value="1" autocomplete="off" autofocus onchange="">
                                                
                                                @error('cant_espa_aca')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        
                                        <!-- viaticos -->
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <div class="col-md-5">
                                                    <input id="vlr_estud_max" type="text"  class="form-control @error('vlr_estud_max') is-invalid @enderror" name="vlr_estud_max" 
                                                    value={{$vlr_viaticos->vlr_estud_max}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                                                    
                                                    <input id="vlr_estud_min" type="text"  class="form-control @error('vlr_estud_min') is-invalid @enderror" name="vlr_estud_min" 
                                                    value={{$vlr_viaticos->vlr_estud_min}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                                                    
                                                </div> 

                                                <div class="col-md-5">
                                                    <input id="vlr_docen_max" type="text"  class="form-control @error('vlr_docen_max') is-invalid @enderror" name="vlr_docen_max" 
                                                    value={{$vlr_viaticos->vlr_docen_max}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                                                    
                                                    <input id="vlr_docen_min" type="text"  class="form-control @error('vlr_docen_min') is-invalid @enderror" name="vlr_docen_min" 
                                                    value={{$vlr_viaticos->vlr_docen_min}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                                                    
                                                </div> 

                                                <div class="col-md-2">
                                                    <input id="pregrado" type="text"  class="form-control @error('pregrado') is-invalid @enderror" name="pregrado" 
                                                    value="" autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                                                    
                                                </div> 
                                            </div> 
                                        </div> 
                                    <!-- viaticos -->
                                    </div>

                                    <div class="form-group row" id="esp_aca_1">
                                        <div class="col-md-12" id="">
                                            <br>
                                            <h4>Espacios Académicos Prácticas Integradas</h4>
                                            <hr class="divider">
                                        </div>

                                        <div class="col-md-5" id="">
                                            <label for="id_espa_aca_1" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_espa_aca_1" name="id_espa_aca_1" class="form-control" required
                                            title=""
                                            onchange="recargarDocenEspaAca(this.value, 1)">
                                            </select>
                                            
                                            @error('id_espa_aca_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5" id="">
                                            <label for="id_docen_espa_aca_1" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el docente a cargo del espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Docente Responsable') }}</label>
                                            
                                            <select id="id_docen_espa_aca_1" name="id_docen_espa_aca_1" class="form-control" required
                                            title="">
                                            </select>
                                            
                                            @error('id_docen_espa_aca_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row" id="esp_aca_2">
                                        <div class="col-md-5" id="">
                                            <label for="id_espa_aca_2" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_espa_aca_2" name="id_espa_aca_2" class="form-control" required
                                            title=""
                                            onchange="recargarDocenEspaAca(this.value, 2)">
                                                @foreach($espacios_academicos as $esp_aca)
                                                    <option value="{{$esp_aca->id}}" selected>{{$esp_aca->espacio_academico}}</option>  
                                                @endforeach
                                            </select>
                                            
                                            @error('id_espa_aca_2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5" id="">
                                            <label for="id_docen_espa_aca_2" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el docente a cargo del espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Docente Responsable') }}</label>
                                            <select id="id_docen_espa_aca_2" name="id_docen_espa_aca_2" class="form-control" required
                                            title="">
                                            </select>
                                            
                                            @error('id_docen_espa_aca_2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row" id="esp_aca_3">
                                        <div class="col-md-5" id="">
                                            <label for="id_espa_aca_3" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_espa_aca_3" name="id_espa_aca_3" class="form-control" required
                                            title=""
                                            onchange="recargarDocenEspaAca(this.value, 3)">
                                                @foreach($espacios_academicos as $esp_aca)
                                                    <option value="{{$esp_aca->id}}" selected>{{$esp_aca->espacio_academico}}</option>  
                                                @endforeach
                                            </select>
                                            
                                            @error('id_espa_aca_3')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5" id="">
                                            <label for="id_docen_espa_aca_3" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el docente a cargo del espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Docente Responsable') }}</label>
                                            <select id="id_docen_espa_aca_3" name="id_docen_espa_aca_3" class="form-control" required
                                            title="">
                                            </select>
                                            
                                            @error('id_docen_espa_aca_3')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row" id="esp_aca_4">
                                        <div class="col-md-5" id="">
                                            <label for="id_espa_aca_4" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_espa_aca_4" name="id_espa_aca_4" class="form-control" required
                                            title=""
                                            onchange="recargarDocenEspaAca(this.value, 4)">
                                                @foreach($espacios_academicos as $esp_aca)
                                                    <option value="{{$esp_aca->id}}" selected>{{$esp_aca->espacio_academico}}</option>  
                                                @endforeach
                                            </select>
                                            
                                            @error('id_espa_aca_4')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5" id="">
                                            <label for="id_docen_espa_aca_4" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el docente a cargo del espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Docente Responsable') }}</label>
                                            <select id="id_docen_espa_aca_4" name="id_docen_espa_aca_4" class="form-control" required
                                            title="">
                                            </select>
                                            
                                            @error('id_docen_espa_aca_4')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row" id="esp_aca_5">
                                        <div class="col-md-5" id="">
                                            <label for="id_espa_aca_5" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_espa_aca_5" name="id_espa_aca_5" class="form-control" required
                                            title=""
                                            onchange="recargarDocenEspaAca(this.value, 5)">
                                                @foreach($espacios_academicos as $esp_aca)
                                                    <option value="{{$esp_aca->id}}" selected>{{$esp_aca->espacio_academico}}</option>  
                                                @endforeach
                                            </select>
                                            
                                            @error('id_espa_aca_5')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5" id="">
                                            <label for="id_docen_espa_aca_5" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el docente a cargo del espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Docente Responsable') }}</label>
                                            <select id="id_docen_espa_aca_5" name="id_docen_espa_aca_5" class="form-control" required
                                            title="">
                                            </select>
                                            
                                            @error('id_docen_espa_aca_5')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row" id="esp_aca_6">
                                        <div class="col-md-5" id="">
                                            <label for="id_espa_aca_6" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_espa_aca_6" name="id_espa_aca_6" class="form-control" required
                                            title=""
                                            onchange="recargarDocenEspaAca(this.value, 6)">
                                                @foreach($espacios_academicos as $esp_aca)
                                                    <option value="{{$esp_aca->id}}" selected>{{$esp_aca->espacio_academico}}</option>  
                                                @endforeach
                                            </select>
                                            
                                            @error('id_espa_aca_6')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5" id="">
                                            <label for="id_docen_espa_aca_6" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el docente a cargo del espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Docente Responsable') }}</label>
                                            <select id="id_docen_espa_aca_6" name="id_docen_espa_aca_6" class="form-control" required
                                            title="">
                                            </select>
                                            
                                            @error('id_docen_espa_aca_6')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row" id="esp_aca_7">
                                        <div class="col-md-5" id="">
                                            <label for="id_espa_aca_7" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select id="id_espa_aca_7" name="id_espa_aca_7" class="form-control" required
                                            title=""
                                            onchange="recargarDocenEspaAca(this.value, 7)">
                                                @foreach($espacios_academicos as $esp_aca)
                                                    <option value="{{$esp_aca->id}}" selected>{{$esp_aca->espacio_academico}}</option>  
                                                @endforeach
                                            </select>
                                            
                                            @error('id_espa_aca_7')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-5" id="">
                                            <label for="id_docen_espa_aca_7" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el docente a cargo del espacio académico asociado a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Docente Responsable') }}</label>
                                            <select id="id_docen_espa_aca_7" name="id_docen_espa_aca_7" class="form-control" required
                                            title="">
                                            </select>
                                            
                                            @error('id_docen_espa_aca_7')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-2" id="">
                                        </div>

                                        <div class="col-md-12" id="">
                                            <br>
                                            <hr class="divider">
                                        </div>
                                    </div>

                                <!-- Integradas -->

                                <!-- 2 -->
                                    <div  class="form-group row">
                                        <div class="col-md-2">
                                            <label for="num_estudiantes_aprox" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el número aproximado de estudiantes que participarán de la salida de práctica académica incluido el monitor"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Estudiantes') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="num_estudiantes_aprox" type="text" class="form-control @error('num_estudiantes_aprox') is-invalid @enderror" name="num_estudiantes_aprox" 
                                            value="" required pattern="[0-9]{1,3}" title="" onkeyup="onlyNmb(this)" 
                                            autocomplete="off" autofocus onchange="calc_viaticos_RP()">
                                            
                                            @error('num_estudiantes_aprox')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="cant_grupos" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la cantidad aproximada de grupos asociados a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cant. Grupos') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="cant_grupos" type="number" max="4" min="1" pattern="^[0-9]+" class="form-control @error('cant_grupos') is-invalid @enderror" name="cant_grupos" 
                                            title=""
                                            value="1" autocomplete="off" autofocus required>
                                            
                                            @error('cant_grupos')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="num_apoyo" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el número aproximado del personal de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo') }}</label>
                                            <div class="input-group">
                                                <input id="num_apoyo" type="number" max="10" min="0" pattern="^[0-9]+" class="form-control @error('num_apoyo') is-invalid @enderror" name="num_apoyo" 
                                                title=""
                                                value="0" autocomplete="off" autofocus onchange="calc_viaticos_RP()">
                                                
                                                @error('num_apoyo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-2" id="cant_docen_apoyo">
                                            <label for="total_docentes_apoyo" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el número aproximado de docentes que hacen parte del personal de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cant. Docentes') }}</label>
                                            <div class="input-group">
                                                <input id="total_docentes_apoyo" type="number" max="10" min="0" pattern="^[0-9]+" class="form-control @error('total_docentes_apoyo') is-invalid @enderror" name="total_docentes_apoyo" 
                                                title=""
                                                value="0" autocomplete="off" autofocus onchange="calc_viaticos_RP()">
                                                
                                                @error('total_docentes_apoyo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>    
                                        </div>

                                        <div class="col-md-4" id="soporte_apoyo">
                                            <label for="sop_pers_apoyo" class="col-form-label text-md-left" >
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Busque en su computador el soporte de autorización para el personal de apoyo que participará en 
                                                    la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Soporte Personal Apoyo') }}</label>
                                            <input id="sop_pers_apoyo" type="file" class="form-control @error('sop_pers_apoyo') is-invalid @enderror" name="sop_pers_apoyo" 
                                            style="color: rgb(243, 3, 3)" accept="application/pdf"
                                            title="Soporte autorización personal de apoyo">
                                        </div>

                                    </div>
                                <!-- 2 -->

                                <!-- 2.1 -->
                                    <div  class="form-group row"  id="Grupos">
                                        <div class="col-md-2" id="gp_1">
                                            <label for="grupo_1" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el número del grupo que tiene a cargo"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Gp 1') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="grupo_1" type="text" class="form-control @error('grupo_1') is-invalid @enderror" name="grupo_1" 
                                            title="" onkeyup="onlyNmb(this)" required
                                            value="" autocomplete="off" pattern="[0-9]{1,5}"  autofocus>
                                            
                                            @error('grupo_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2" id="gp_2">
                                            <label for="grupo_2" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el número del grupo que tiene a cargo"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Gp 2') }}</label>
                                            <input id="grupo_2" type="text" class="form-control @error('grupo_2') is-invalid @enderror" name="grupo_2" 
                                            title=""  onkeyup="onlyNmb(this)"
                                            value="" autocomplete="off" pattern="[0-9]{1,5}"  autofocus>
                                            @error('grupo_2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2" id="gp_3">
                                            <label for="grupo_3" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el número del grupo que tiene a cargo"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Gp 3') }}</label>
                                            <input id="grupo_3" type="text" class="form-control @error('grupo_3') is-invalid @enderror" name="grupo_3" 
                                            title=""  onkeyup="onlyNmb(this)"
                                            value="" autocomplete="off" pattern="[0-9]{1,5}"  autofocus>
                                            @error('grupo_3')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2" id="gp_4">
                                            <label for="grupo_4" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el número del grupo que tiene a cargo"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Gp 4') }}</label>
                                            <input id="grupo_4" type="text" class="form-control @error('grupo_4') is-invalid @enderror" name="grupo_4" 
                                            title=""  onkeyup="onlyNmb(this)"
                                            value="" autocomplete="off" pattern="[0-9]{1,5}" autofocus>
                                            @error('grupo_4')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                    </div>

                                <!-- 2.1 -->

                                <!-- 2.2 -->
                                {{-- <div  class="form-group row" id="cant_docen_apoyo">
                                    <div class="col-md-2">
                                        <label for="num_docentes_apoyo" class="col-form-label text-md-left" title="">
                                            <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el número aproximado de docentes que hacen parte del personal de apoyo que participará en la salida de práctica académica"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Cant. Docentes') }}</label>
                                        <div class="input-group">
                                            <input id="num_docentes_apoyo" type="number" max="10" min="1" pattern="^[1-9]+" class="form-control @error('num_docentes_apoyo') is-invalid @enderror" name="num_docentes_apoyo" 
                                            title=""
                                            value="" autocomplete="off" autofocus onchange="calc_viaticos_RP()">
                                            
                                            @error('num_docentes_apoyo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>    
                                    </div> 
                                </div>--}}
                                <!-- 2.2 -->

                                <!-- 2.3 -->
                                    <div  class="form-group row"  id="apoyo">
                                        <div class="col-md-4" id="ap_1">
                                            <label for="apoyo_1" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 1') }}</label>
                                            <input id="apoyo_1" type="text" class="form-control @error('apoyo_1') is-invalid @enderror" name="apoyo_1" 
                                            title="Nombre de docente de apoyo 1"
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('apoyo_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_2">
                                            <label for="apoyo_2" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 2') }}</label>
                                            <input id="apoyo_2" type="text" class="form-control @error('apoyo_2') is-invalid @enderror" name="apoyo_2" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            @error('apoyo_2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_3">
                                            <label for="apoyo_3" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 3') }}</label>
                                            <input id="apoyo_3" type="text" class="form-control @error('apoyo_3') is-invalid @enderror" name="apoyo_3" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            @error('apoyo_3')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_4">
                                            <label for="apoyo_4" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 4') }}</label>
                                            <input id="apoyo_4" type="text" class="form-control @error('apoyo_4') is-invalid @enderror" name="apoyo_4" 
                                            title=""
                                            value=""  autocomplete="off" autofocus>
                                            
                                            @error('apoyo_4')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_5">
                                            <label for="apoyo_5" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 5') }}</label>
                                            <input id="apoyo_5" type="text" class="form-control @error('apoyo_5') is-invalid @enderror" name="apoyo_5" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            @error('apoyo_5')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_6">
                                            <label for="apoyo_6" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 6') }}</label>
                                            <input id="apoyo_6" type="text" class="form-control @error('apoyo_6') is-invalid @enderror" name="apoyo_6" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            @error('apoyo_6')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_7">
                                            <label for="apoyo_7" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en al salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 7') }}</label>
                                            <input id="apoyo_7" type="text" class="form-control @error('apoyo_7') is-invalid @enderror" name="apoyo_7" 
                                            title=""
                                            value=""  autocomplete="off" autofocus>
                                            
                                            @error('apoyo_7')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_8">
                                            <label for="apoyo_8" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 8') }}</label>
                                            <input id="apoyo_8" type="text" class="form-control @error('apoyo_8') is-invalid @enderror" name="apoyo_8" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            @error('apoyo_8')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_9">
                                            <label for="apoyo_9" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 9') }}</label>
                                            <input id="apoyo_9" type="text" class="form-control @error('apoyo_9') is-invalid @enderror" name="apoyo_9" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            @error('apoyo_9')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4" id="ap_10">
                                            <label for="apoyo_10" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre de la persona de apoyo que participará en la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Personal Apoyo 10') }}</label>
                                            <input id="apoyo_10" type="text" class="form-control @error('apoyo_10') is-invalid @enderror" name="apoyo_10" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            @error('apoyo_10')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                <!-- 2.3 -->

                            <!-- información proyección -->

                            <br>
                            <h4>Ruta Principal (Destino para cumplir los objetivos de la práctica)</h4>
                            <hr class="divider">

                            <div  class="form-group row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <div class="form-group">
                                        <label for="realizada_bogota_rp" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            style="font-size: 0.813rem"></i> {{ __('¿La práctica se realizará en Bogotá?') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <div class="row">

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="realizada_bogota_rp" id="realizada_bogota_rp" value="1"
                                                title="" onchange="duracionRP(this.value)"> 
                                                <label class="form-check-label" for="">Si</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="realizada_bogota_rp" id="realizada_bogota_rp"  value="0"
                                                    title="" onchange="duracionRP(this.value)">
                                                    <label class="form-check-label" for="">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ruta principal -->
                                <!-- 3 -->
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="destino_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre del destino de la ruta principal asociada a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Destino Ruta Principal') }}</label>
                                            <span class="hs-form-required" title="Nombre Asociado A La Ruta">*</span>
                                            <input id="destino_rp" type="text" class="form-control @error('destino_rp') is-invalid @enderror" name="destino_rp" 
                                            title="" placeholder="ejemplo: (Bogotá - Medellín - Bogotá)"
                                            value="" required autocomplete="off" autofocus>

                                            @error('destino_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Cant. URL -->
                                            <div class="col-md-2">
                                                <label for="cant_url_rp" class="col-form-label text-md-left">
                                                    <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique la cantidad de URL que se requieren en la ruta principal asociada a la salida de práctica académica"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Cant. URL') }}</label>
                                                <input id="cant_url_rp" type="number" max="6" min="1" pattern="^[0-9]+" class="form-control @error('cant_url_rp') is-invalid @enderror" name="cant_url_rp" 
                                                title=""
                                                value="1" autocomplete="off" autofocus >
                                                
                                                @error('cant_url_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        <!-- Cant. URL -->
                                    </div>
                                <!-- 3 -->

                                <!-- 4 -->
                                    <div class="form-group row" id="rp_url">
                                        <div class="col-md-12" id="rp_url_1">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <label for="ruta_principal" class="col-form-label text-md-left" >
                                                                <i class="fas fa-question-circle" 
                                                                    data-toggle="tooltip" data-placement="left" 
                                                                    data-title="Ingrese la(s) URL obtenida(s) de Google Maps"
                                                                    style="font-size: 0.813rem">
                                                                </i> {{ __('URL Ruta') }}</label>

                                                            <div class="input-group">
                                                                <input id="ruta_principal" type="text" class="form-control @error('ruta_principal') is-invalid @enderror" name="ruta_principal" 
                                                                title=""
                                                                value=""  required autocomplete="off" autofocus onchange="verifUrl_rp(this)">
                                                        
                                                                @error('ruta_principal')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_rp_1" name="btnVer_url_rp_1" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_rp(1)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="rp_url_2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_principal_2" type="text" class="form-control @error('ruta_principal_2') is-invalid @enderror" name="ruta_principal_2" 
                                                                title=""
                                                                value="" autocomplete="off" autofocus 
                                                                onchange="verifUrl_rp(this)">
                                                        
                                                                @error('ruta_principal_2')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                
                                                                <a id="btnVer_url_rp_2" name="btnVer_url_rp_2" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_rp(2)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="rp_url_3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_principal_3" type="text" class="form-control @error('ruta_principal_3') is-invalid @enderror" name="ruta_principal_3" 
                                                                value="" autocomplete="off" autofocus 
                                                                title=""
                                                                onchange="verifUrl_rp(this)">
                                                        
                                                                @error('ruta_principal_3')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_rp_3" name="btnVer_url_rp_3" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_rp(3)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="rp_url_4">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_principal_4" type="text" class="form-control @error('ruta_principal_4') is-invalid @enderror" name="ruta_principal_4" 
                                                                value="" autocomplete="off" autofocus title=""
                                                                onchange="verifUrl_rp(this)">
                                                        
                                                                @error('ruta_principal_4')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_rp_4" name="btnVer_url_rp_4" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_rp(4)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="rp_url_5">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_principal_5" type="text" class="form-control @error('ruta_principal_5') is-invalid @enderror" name="ruta_principal_5" 
                                                                value="" autocomplete="off" autofocus  title=""
                                                                onchange="verifUrl_rp(this)">
                                                        
                                                                @error('ruta_principal_5')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_rp_5" name="btnVer_url_rp_5" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_rp(5)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="rp_url_6">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_principal_6" type="text" class="form-control @error('ruta_principal_6') is-invalid @enderror" name="ruta_principal_6" 
                                                                value="" autocomplete="off" autofocus title=""
                                                                onchange="verifUrl_rp(this)">
                                                        
                                                                @error('ruta_principal_6')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_rp_6" name="btnVer_url_rp_6" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_rp(6)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- 4 -->

                                <!-- Modal -->
                                    <div class="modal fade" id="modal_rp" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"></button>
                                                <h4 class="modal-title">Ventana de Alerta</h4>
                                                </div>
                                                <div class="modal-body">
                                                <p id="msg_modal_rp_t"></p>
                                                <p id="msg_modal_rp_c"></p>
                                                <br>
                                                <a class="collapse-item" href="{{route('dwn_man_user') }}">Manual Usuario</a>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- Modal -->

                                <!-- 5 -->
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="det_recorrido_interno_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Ingrese el detalle del recorrido para la ruta principal"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Detalle Recorrido') }}</label>
                                            <span class="hs-form-required" title="Detalle Diario De La Práctica">*</span>
                                            <textarea id="det_recorrido_interno_rp" style="min-height:5rem;" type="text" class="form-control @error('det_recorrido_interno_rp') is-invalid @enderror" name="det_recorrido_interno_rp" 
                                            title=""
                                            value="" required autocomplete="off" autofocus></textarea>
                                            
                                            @error('det_recorrido_interno_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- 5 -->

                                <!-- 6 -->
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="lugar_salida_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione la sede para el punto de encuentro de salida"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Punto Encuentro Salida') }}</label>
                                            <span class="hs-form-required" title="URL Google">*</span>
                                            <div class="input-group">
                                                {{-- <input id="lugar_salida_rp" type="text" class="form-control @error('lugar_salida_rp') is-invalid @enderror" name="lugar_salida_rp" 
                                                title="URL lugar salida"
                                                value="" required autocomplete="off" autofocus onchange="verf_rp(this,1)"> --}}

                                                <select name="lugar_salida_rp" class="form-control" required
                                                title=""
                                                style="padding-left: 0.1rem;padding-right: 0.1rem;">
                                                    @foreach($sedes as $sede)
                                                        <option value="{{$sede->id}}" selected>{{$sede->sede}}</option>  
                                                        
                                                    @endforeach
                                                </select>

                                                @error('lugar_salida_rp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label for="fecha_salida_aprox_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione la fecha de salida para la ruta principal"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Fecha Salida') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                            <input class="inputDate form-control datetimepicker data-create" id="fecha_salida_aprox_rp" name="fecha_salida_aprox_rp" type="text" required
                                            title="Fecha de salida"
                                            onchange="duracionRP2(this.value)">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="lugar_regreso_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione la sede para el punto de encuentro de regreso"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Punto Encuentro Regreso') }}</label>
                                            <span class="hs-form-required" title="URL Google">*</span>
                                            <div class="input-group">
                                                {{-- <input id="lugar_regreso_rp" type="text" class="form-control @error('lugar_regreso_rp') is-invalid @enderror" name="lugar_regreso_rp" 
                                                title="URL lugar regreso"
                                                value="" required autocomplete="off" autofocus onchange="verf_rp(this,2)"> --}}

                                                <select name="lugar_regreso_rp" class="form-control" required
                                                title=""
                                                style="padding-left: 0.1rem;padding-right: 0.1rem;">
                                                    @foreach($sedes as $sede)
                                                        <option value="{{$sede->id}}" selected>{{$sede->sede}}</option>  
                                                        
                                                    @endforeach
                                                </select>

                                                @error('lugar_regreso_rp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label for="fecha_regreso_aprox_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione la fecha de regreso para la ruta principal"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Fecha Regreso') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                            <input class="inputDate form-control datetimepicker" id="fecha_regreso_aprox_rp" name="fecha_regreso_aprox_rp" type="text" required
                                            title=""
                                            onchange="duracionRP(this.value)">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="duracion_rp" class="col-form-label text-md-left">{{ __('Duración Días') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="duracion_rp" type="text" class="form-control @error('duracion_rp') is-invalid @enderror" name="duracion_rp" 
                                            title="Número de días de duración"
                                            value="" autocomplete="off" autofocus  readonly>
                                            
                                            @error('duracion_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                <!-- 6 -->

                                <br>
                                <h4>Transporte</h4>
                                <hr class="divider">

                                <!-- 7 -->
                                    <div  class="form-group row">
                                        <div class="col-md-2">
                                            <label for="cant_transporte_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la cantidad de vehículos requeridos para la ruta principal"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cant. Vehículos') }}</label>
                                            <div class="input-group">
                                                <input id="cant_transporte_rp" type="number" max="3" min="0" pattern="^[0-3]+"  class="form-control @error('cant_transporte_rp') is-invalid @enderror" name="cant_transporte_rp" 
                                                title=""
                                                value="1" required autocomplete="off" autofocus>
                                                
                                                @error('cant_transporte_rp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-5" id="docente_transp_rp">
                                            <label for="docente_resp_transp_rp" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                            <input id="docente_resp_transp_rp" type="text" class="form-control @error('docente_resp_transp_rp') is-invalid @enderror" name="docente_resp_transp_rp" 
                                            title="Docente responsable de la práctica"
                                            value="{{ $nombre_usuario }}" required autocomplete="off" autofocus readonly>
                                            
                                            @error('docente_resp_transp_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                <!-- 7 -->

                                <!-- 8 transporte_rp_1 -->
                                    <div class="form-group row" id="transporte_rp_1">
                                        <div class="col-md-12" id="transporte_rp">
                                            <div class="row" id="transporte_rp_children">
                                                <div class="col-md-2">
                                                    <label for="id_tipo_transporte_rp_[]" class="col-form-label text-md-right">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Seleccione el tipo de vehículo requerido para la ruta principal"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Tipo Vehículo') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <select name="id_tipo_transporte_rp_[]" class="form-control" required onchange="otroTransporte(this.value,1)"
                                                    title=""
                                                    >
                                                        @foreach($tipos_transportes as $tp_trans)
                                                            <option value="{{$tp_trans->id}}">{{$tp_trans->tipo_transporte}}</option>  

                                                        @endforeach
                                                    </select>
                                                    @error('id_tipo_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2" id="capac_transp_rp_1">
                                                    <label for="capac_transporte_rp_[]" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique la capacidad de asientos requeridos para el tipo de vehículo previamente seleccionado"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Cap. Vehíc.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="capac_transporte_rp_[]" type="text" class="form-control @error('capac_transporte_rp_[]') is-invalid @enderror" name="capac_transporte_rp_[]" 
                                                    title="Capacidad requerida del vehículo" onkeyup="onlyNmb(this)" onchange="onlyNmb(this)"
                                                    value="" required autocomplete="off" autofocus>

                                                    @error('capac_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="det_tipo_transporte_rp_[]" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique los detalles o especificaciones que debe tener el vehículo"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Det. Vehíc.') }}</label>
                                                    {{-- <span class="hs-form-required">*</span> --}}
                                                    <input id="det_tipo_transporte_rp_[]" type="text" class="form-control @error('det_tipo_transporte_rp_[]') is-invalid @enderror" name="det_tipo_transporte_rp_[]" 
                                                    title="Detalle asociado al vehículo"
                                                    value="" autocomplete="off" autofocus>

                                                    @error('det_tipo_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exclusiv_tiempo_rp_1" class="col-form-label text-md-left">
                                                            <i class="fas fa-question-circle" 
                                                                data-toggle="tooltip" data-placement="left" 
                                                                data-title="Indique si requiere disponibilidad permanente del vehículo"
                                                                style="font-size: 0.813rem">
                                                            </i> {{ __('Disponibilidad Permanente?') }}</label>
                                                        <span class="hs-form-required" title="Disponibilidad Permanente?">*</span>
                                                        <div class="row">

                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_1" value="1" checked
                                                                title=""
                                                                >
                                                                <label class="form-check-label" for="">Si</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_1"  value="0"
                                                                    title=""
                                                                    >
                                                                    <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>

                                                            {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 transporte_rp_1 -->

                                <!-- 8 transporte_rp_2 -->
                                    <div class="form-group row" id="transporte_rp_2">
                                        <div class="col-md-12" id="transporte_rp">
                                            <div class="row" id="transporte_rp_children">
                                                <div class="col-md-2">
                                                    <label for="id_tipo_transporte_rp_[]" class="col-form-label text-md-right">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Seleccione el tipo de vehículo requerido para la ruta principal"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Tipo Vehículo') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <select name="id_tipo_transporte_rp_[]" class="form-control" required onchange="otroTransporte(this.value,2)"
                                                    title=""
                                                    >
                                                        @foreach($tipos_transportes as $tp_trans)
                                                            <option  value="{{$tp_trans->id}}">{{$tp_trans->tipo_transporte}}</option>  

                                                        @endforeach
                                                    </select>
                                                    @error('id_tipo_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2" id="capac_transp_rp_2">
                                                    <label for="capac_transporte_rp_[]" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique la capacidad de asientos requeridos para el tipo de vehículo previamente seleccionado"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Cap. Vehíc.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="capac_transporte_rp_[]" type="text" class="form-control @error('capac_transporte_rp_[]') is-invalid @enderror" name="capac_transporte_rp_[]" 
                                                    title="" onkeyup="onlyNmb(this)" onchange="onlyNmb(this)"
                                                    value="" autocomplete="off" autofocus>

                                                    @error('capac_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="det_tipo_transporte_rp_[]" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique los detalles o especificaciones que debe tener el vehículo"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Det. Vehíc.') }}</label>
                                                    {{-- <span class="hs-form-required">*</span> --}}
                                                    <input id="det_tipo_transporte_rp_[]" type="text" class="form-control @error('det_tipo_transporte_rp_[]') is-invalid @enderror" name="det_tipo_transporte_rp_[]" 
                                                    title=""
                                                    value="" autocomplete="off" autofocus>

                                                    @error('det_tipo_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exclusiv_tiempo_rp_2" class="col-form-label text-md-left">
                                                            <i class="fas fa-question-circle" 
                                                                data-toggle="tooltip" data-placement="left" 
                                                                data-title="Indique si requiere disponibilidad permanente del vehículo"
                                                                style="font-size: 0.813rem">
                                                            </i> {{ __('Disponibilidad Permanente?') }}</label>
                                                        <span class="hs-form-required" title="Disponibilidad Permanente?">*</span>
                                                        <div class="row">

                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_2" value="1" checked
                                                                title=""
                                                                >
                                                                <label class="form-check-label" for="">Si</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_2"  value="0"
                                                                    title=""
                                                                    >
                                                                    <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>

                                                            {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 transporte_rp_2 -->

                                <!-- 8 transporte_rp_3 -->
                                    <div class="form-group row" id="transporte_rp_3">
                                        <div class="col-md-12" id="transporte_rp">
                                            <div class="row" id="transporte_rp_children">
                                                <div class="col-md-2">
                                                    <label for="id_tipo_transporte_rp_[]" class="col-form-label text-md-right">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Seleccione el tipo de vehículo requerido para la ruta principal"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Tipo Vehículo') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <select name="id_tipo_transporte_rp_[]" class="form-control" required onchange="otroTransporte(this.value,3)"
                                                    title=""
                                                    >
                                                        @foreach($tipos_transportes as $tp_trans)
                                                            <option  value="{{$tp_trans->id}}">{{$tp_trans->tipo_transporte}}</option>  

                                                        @endforeach
                                                    </select>
                                                    @error('id_tipo_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2" id="capac_transp_rp_3">
                                                    <label for="capac_transporte_rp_[]" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique la capacidad de asientos requeridos para el tipo de vehículo previamente seleccionado"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Cap. Vehíc.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="capac_transporte_rp_[]" type="text" class="form-control @error('capac_transporte_rp_[]') is-invalid @enderror" name="capac_transporte_rp_[]" 
                                                    title="" onkeyup="onlyNmb(this)" onchange="onlyNmb(this)"
                                                    value="" autocomplete="off" autofocus>

                                                    @error('capac_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="det_tipo_transporte_rp_[]" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique los detalles o especificaciones que debe tener el vehículo"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Det. Vehíc.') }}</label>
                                                    {{-- <span class="hs-form-required">*</span> --}}
                                                    <input id="det_tipo_transporte_rp_[]" type="text" class="form-control @error('det_tipo_transporte_rp_[]') is-invalid @enderror" name="det_tipo_transporte_rp_[]" 
                                                    title=""
                                                    value="" autocomplete="off" autofocus>

                                                    @error('det_tipo_transporte_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exclusiv_tiempo_rp_3" class="col-form-label text-md-left">
                                                            <i class="fas fa-question-circle" 
                                                                data-toggle="tooltip" data-placement="left" 
                                                                data-title="Indique si requiere disponibilidad permanente del vehículo"
                                                                style="font-size: 0.813rem">
                                                            </i> {{ __('Disponibilidad Permanente?') }}</label>
                                                        <span class="hs-form-required" title="Disponibilidad Permanente?">*</span>
                                                        <div class="row">

                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_3" value="1" checked
                                                                title=""
                                                                >
                                                                <label class="form-check-label" for="">Si</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_3"  value="0"
                                                                    title=""
                                                                    >
                                                                    <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>

                                                            {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 transporte_rp_3 -->

                                <br>
                                <h4>Transporte Menor - Local</h4>
                                <hr class="divider">

                                <!-- cant t. menor -->
                                    <div  class="form-group row">
                                        <div class="col-md-2">
                                            <label for="cant_trans_menor_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la cantidad de vehículos locales requeridos"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cant. Vehículos') }}</label>
                                            <div class="input-group">
                                                <input id="cant_trans_menor_rp" type="number" max="4" min="0" pattern="^[1-4]+"  class="form-control @error('cant_trans_menor_rp') is-invalid @enderror" name="cant_trans_menor_rp" 
                                                title=""
                                                value="0" required autocomplete="off" autofocus>
                                                
                                                @error('cant_trans_menor_rp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-5" id="docente_trans_menor_rp">
                                            <label for="docente_resp_t_menor_rp" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                            <input id="docente_resp_t_menor_rp" type="text" class="form-control @error('docente_resp_t_menor_rp') is-invalid @enderror" name="docente_resp_t_menor_rp" 
                                            title="Docente responsable de la práctica"
                                            value="{{ $nombre_usuario }}" required autocomplete="off" autofocus readonly>
                                            
                                            @error('docente_resp_t_menor_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                <!-- cant t. menor -->

                                <!-- 8 trans_menor_rp_1 -->
                                    <div class="form-group row" id="t_menor_rp_1">
                                        <div class="col-md-12" id="trans_menor_rp">
                                            <div class="row" id="trans_menor_rp_children">

                                                <div class="col-md-5">
                                                    <label for="trans_menor_rp_1" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique el tipo de vehículo para el transporte menor o local requerido"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Transporte Menor 1') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="trans_menor_rp_1" type="text" class="form-control @error('trans_menor_rp_1') is-invalid @enderror" name="trans_menor_rp_1" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>
                                        
                                                    @error('trans_menor_rp_1')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="vlr_trans_menor_rp_1" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique valor aproximado del transporte menor o local requerido"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Valor Transp.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="vlr_trans_menor_rp_1" type="text" class="form-control @error('vlr_trans_menor_rp_1') is-invalid @enderror" name="vlr_trans_menor_rp_1" 
                                                    title="Valor transporte menor o local"
                                                    value=""  autocomplete="off" autofocus  onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                                                    @error('vlr_trans_menor_rp_1')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 trans_menor_rp_1 -->

                                <!-- 8 trans_menor_rp_2 -->
                                    <div class="form-group row" id="t_menor_rp_2">
                                        <div class="col-md-12" id="trans_menor_rp">
                                            <div class="row" id="trans_menor_rp_children">

                                                <div class="col-md-5">
                                                    <label for="trans_menor_rp_2" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique el tipo de vehículo para el transporte menor o local requerido"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Transporte Menor 2') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="trans_menor_rp_2" type="text" class="form-control @error('trans_menor_rp_2') is-invalid @enderror" name="trans_menor_rp_2" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>
                                        
                                                    @error('trans_menor_rp_2')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <label for="vlr_trans_menor_rp_2" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique valor aproximado del transporte menor o local requerido"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Valor Transp.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="vlr_trans_menor_rp_2" type="text" class="form-control @error('vlr_trans_menor_rp_2') is-invalid @enderror" name="vlr_trans_menor_rp_2" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" redonly>

                                                    @error('vlr_trans_menor_rp_2')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- <div class="col-md-5" id="docente_transp_rp_2">
                                                    <label for="docente_resp_t_menor_rp_[]" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                                    <input id="docente_resp_t_menor_rp_[]" type="text" class="form-control @error('docente_resp_t_menor_rp_[]') is-invalid @enderror" name="docente_resp_t_menor_rp_[]" 
                                                    title="Docente responsable de la práctica"
                                                    value="{{ $nombre_usuario }}" autocomplete="off" autofocus readonly>
                                                    
                                                    @error('docente_resp_t_menor_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div> --}}
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 trans_menor_rp_2 -->

                                <!-- 8 trans_menor_rp_3 -->
                                    <div class="form-group row" id="t_menor_rp_3">
                                        <div class="col-md-12" id="trans_menor_rp">
                                            <div class="row" id="trans_menor_rp_children">
                                                
                                                <div class="col-md-5">
                                                    <label for="trans_menor_rp_3" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique el tipo de vehículo para el transporte menor o local requerido"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Transporte Menor 3') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="trans_menor_rp_3" type="text" class="form-control @error('trans_menor_rp_3') is-invalid @enderror" name="trans_menor_rp_3" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>
                                        
                                                    @error('trans_menor_rp_3')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="vlr_trans_menor_rp_3" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique valor aproximado del transporte menor o local requerido"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Valor Transp.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="vlr_trans_menor_rp_3" type="text" class="form-control @error('vlr_trans_menor_rp_3') is-invalid @enderror" name="vlr_trans_menor_rp_3" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                                                    @error('vlr_trans_menor_rp_3')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- <div class="col-md-5" id="docente_transp_rp_3">
                                                    <label for="docente_resp_t_menor_rp_[]" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                                    <input id="docente_resp_t_menor_rp_[]" type="text" class="form-control @error('docente_resp_t_menor_rp_[]') is-invalid @enderror" name="docente_resp_t_menor_rp_[]" 
                                                    title="Docente responsable de la práctica"
                                                    value="{{ $nombre_usuario }}" autocomplete="off" autofocus readonly>
                                                    
                                                    @error('docente_resp_t_menor_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div> --}}
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 trans_menor_rp_3 -->

                                <!-- 8 trans_menor_rp_4 -->
                                    <div class="form-group row" id="t_menor_rp_4">
                                        <div class="col-md-12" id="trans_menor_rp">
                                            <div class="row" id="trans_menor_rp_children">

                                                <div class="col-md-5">
                                                    <label for="trans_menor_rp_4" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique el tipo de vehículo para el transporte menor o local requerido"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Transporte Menor 4') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="trans_menor_rp_4" type="text" class="form-control @error('trans_menor_rp_4') is-invalid @enderror" name="trans_menor_rp_4" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>
                                        
                                                    @error('trans_menor_rp_4')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="vlr_trans_menor_rp_4" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique valor aproximado del transporte menor o local requerido"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Valor Transp.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="vlr_trans_menor_rp_4" type="text" class="form-control @error('vlr_trans_menor_rp_4') is-invalid @enderror" name="vlr_trans_menor_rp_4" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                                                    @error('vlr_trans_menor_rp_4')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- <div class="col-md-5" id="docente_transp_rp_3">
                                                    <label for="docente_resp_t_menor_rp_[]" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                                    <input id="docente_resp_t_menor_rp_[]" type="text" class="form-control @error('docente_resp_t_menor_rp_[]') is-invalid @enderror" name="docente_resp_t_menor_rp_[]" 
                                                    title="Docente responsable de la práctica"
                                                    value="{{ $nombre_usuario }}" autocomplete="off" autofocus readonly>
                                                    
                                                    @error('docente_resp_t_menor_rp_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div> --}}
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 trans_menor_rp_4 -->

                                <br>
                                <h4>Otros</h4>
                                <hr class="divider">

                                <!-- materiales -->
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <label for="det_materiales_rp" class="col-form-label text-md-left" title="" hidden>
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique los materiales requeridos para la realización de la práctica académica"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Materiales') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="det_materiales_rp" type="text"  class="form-control @error('det_materiales_rp') is-invalid @enderror" name="det_materiales_rp" 
                                            title="" hidden
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('det_materiales_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="vlr_materiales_rp" class="col-form-label text-md-left" title="" hidden>
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique valor aproximado de los materiales requeridos"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Valor Total Materiales') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="vlr_materiales_rp" type="text"  class="form-control @error('vlr_materiales_rp') is-invalid @enderror" name="vlr_materiales_rp" 
                                            title="" hidden
                                            value="" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                                            
                                            @error('vlr_materiales_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- materiales -->

                                <!-- guías -baquianos -->
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <label for="det_guias_baquia_rp" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique las guías y/o baquianos requeridos para la realización de la práctica académica"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Guías y/o Baquianos') }}</label>
                                            <input id="det_guias_baquia_rp" type="text"  class="form-control @error('det_guias_baquia_rp') is-invalid @enderror" name="det_guias_baquia_rp" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('det_guias_baquia_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="vlr_guias_baquia_rp" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique valor aproximado de las guías y/o baquianos requeridos"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Valor Total Guías y/o Baquianos') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="vlr_guias_baquia_rp" type="text"  class="form-control @error('vlr_guias_baquias_rp') is-invalid @enderror" name="vlr_guias_baquia_rp" 
                                            title=""
                                            value="" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                                            
                                            @error('vlr_guias_baquia_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- guías -baquianos -->

                                <!-- otros - boletas -->
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <label for="det_otros_bolet_rp" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique las boletas y/u otros requeridos para la realización de la práctica académica"
                                                style="font-size: 0.813rem">
                                                </i> {{ __('Boletas y/u Otros') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="det_otros_bolet_rp" type="text"  class="form-control @error('det_otros_bolet_rp') is-invalid @enderror" name="det_otros_bolet_rp" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('det_otros_bolet_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="vlr_otros_bolet_rp" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique valor aproximado de las boletas y/u otros requeridos"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Valor Total Boletas y/u Otros') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="vlr_otros_bolet_rp" type="text"  class="form-control @error('vlr_otros_bolet_rp') is-invalid @enderror" name="vlr_otros_bolet_rp" 
                                            title=""
                                            value="" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                                            
                                            @error('vlr_otros_bolet_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- otros - boletas -->

                                <br>
                                <h4>Actividades de Riesgo</h4>
                                <hr class="divider">

                                <!-- preguntas -->
                                    <div class="form-group row">    
                                        <!-- 1 -->
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="areas_acuaticas_rp">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique Si o No según el caso"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Esta sálida desarrolla maniobras sobre áreas acuáticas(Ríos, lagos, lagunas, humedales, mares, etc...?)') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-right: 15px;">
                                                    <label class="switch">
                                                        <input type="checkbox" name="areas_acuaticas_rp" id="areas_acuaticas_rp" onchange="customAlerts(this, 1,1)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- 1 -->

                                        <!-- 2 -->
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="alturas_rp">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique Si o No según el caso"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Esta sálida desarrolla actividades de escalada o trabajo de alturas?)') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-right: 15px;">
                                                    <label class="switch">
                                                        <input type="checkbox" name="alturas_rp" id="alturas_rp" onchange="customAlerts(this, 1,2)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- 2 -->

                                        <!-- 3 -->
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="riesgo_biologico_rp">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique Si o No según el caso"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Esta sálida desarrolla actividades al interior de bosques o lugares con riesgo biológico?)') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-right: 15px;">
                                                    <label class="switch">
                                                        <input type="checkbox" name="riesgo_biologico_rp" id="riesgo_biologico_rp" onchange="customAlerts(this,1, 3)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- 3 -->

                                        <!-- 4 -->
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="espacios_confinados_rp">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique Si o No según el caso"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Esta sálida desarrolla actividades en espacios confinados?)') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-right: 15px;">
                                                    <label class="switch">
                                                        <input type="checkbox" name="espacios_confinados_rp" id="espacios_confinados_rp" onchange="customAlerts(this,1,4)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- 4 -->

                                    </div>
                                <!-- preguntas -->

                                <!-- viaticos -->
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="vlr_apoyo_docentes_rp" class="col-form-label text-md-left" >
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Valor de los viáticos para los docentes equivalentes a la duración de la práctica menos el 0.5" style="font-size: 0.813rem"></i> {{ __('Valor Viáticos Docentes') }}</label>
                                            <input id="vlr_apoyo_docentes_rp" type="text"  class="form-control @error('vlr_apoyo_docentes_rp') is-invalid @enderror" name="vlr_apoyo_docentes_rp" 
                                            title=""
                                            value="" autocomplete="off" autofocus readonly>
                                            
                                            @error('vlr_apoyo_docentes_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="vlr_apoyo_estudiantes_rp" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Valor de auxilio económico a estudiantes" style="font-size: 0.813rem"></i> {{ __('Valor Auxilio Estudiantes') }}</label>
                                            <input id="vlr_apoyo_estudiantes_rp" type="text"  class="form-control @error('vlr_apoyo_estudiantes_rp') is-invalid @enderror" name="vlr_apoyo_estudiantes_rp" 
                                            title=""
                                            value="" autocomplete="off" autofocus readonly>
                                            
                                            @error('vlr_apoyo_estudiantes_rp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- viaticos -->

                            <!-- ruta principal -->

                            <br>
                            <h4>Ruta Contingencia (Destino para cumplir propósitos de práctica pero por fallas en la vía, clima o demás se adopta como ruta principal de destino)</h4>
                            <hr class="divider">
                            
                            <div  class="form-group row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <div class="form-group">
                                        <label for="realizada_bogota_ra" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            style="font-size: 0.813rem"></i> {{ __('¿La práctica se realizará en Bogotá?') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <div class="row">

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="realizada_bogota_ra" id="realizada_bogota_ra" value="1"
                                                title="" onchange="duracionRP(this.value)">
                                                <label class="form-check-label" for="">Si</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="realizada_bogota_ra" id="realizada_bogota_ra"  value="0"
                                                    title="" onchange="duracionRP(this.value)">
                                                    <label class="form-check-label" for="">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ruta alterna -->
                                <!-- 9 -->
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="destino_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique el nombre del destino de la ruta de contingencia asociada a la salida de práctica académica"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Destino Ruta Contingencia') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="destino_ra" type="text" class="form-control @error('destino_ra') is-invalid @enderror" name="destino_ra" 
                                            title="" placeholder="ejemplo: (Bogotá - Medellín - Bogotá)"
                                            value="" required autocomplete="off" autofocus>
                                            
                                            @error('destino_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        
                                        <!-- Cant. URL -->
                                            <div class="col-md-2">
                                                <label for="cant_url_ra" class="col-form-label text-md-left">
                                                    <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique la cantidad de URL que se requieren en la ruta de contingencia asociada a la salida de práctica académica"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Cant. URL') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <input id="cant_url_ra" type="number" max="6" min="1" pattern="^[0-9]+" class="form-control @error('cant_url_ra') is-invalid @enderror" name="cant_url_ra" 
                                                title=""
                                                value="1" autocomplete="off" autofocus required>
                                                
                                                @error('cant_url_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        <!-- Cant. URL -->
                                    </div>
                                <!-- 9 -->
                                
                                <!-- 10 -->
                                    <div class="form-group row" id="ra_url">
                                        <div class="col-md-12" id="ra_url_1">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            
                                                            <label for="ruta_alterna" class="col-form-label text-md-left" >
                                                                <i class="fas fa-question-circle" 
                                                                    data-toggle="tooltip" data-placement="left" 
                                                                    data-title="Ingrese la(s) URL obtenida(s) de Google Maps"
                                                                    style="font-size: 0.813rem">
                                                                </i> {{ __('URL Ruta') }}</label>
                                                            <div class="input-group">
                                                                <input id="ruta_alterna" type="text" class="form-control @error('ruta_alterna') is-invalid @enderror" name="ruta_alterna" 
                                                                value=""  required autocomplete="off" autofocus onchange="verifUrl_ra(this)">
                                                        
                                                                @error('ruta_alterna')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_ra_1" name="btnVer_url_ra_1" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_ra(1)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="ra_url_2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_alterna_2" type="text" class="form-control @error('ruta_alterna_2') is-invalid @enderror" name="ruta_alterna_2" 
                                                                value="" autocomplete="off" autofocus 
                                                                onchange="verifUrl_ra(this)">
                                                        
                                                                @error('ruta_alterna_2')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                
                                                                <a id="btnVer_url_ra_2" name="btnVer_url_ra_2" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_ra(2)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="ra_url_3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_alterna_3" type="text" class="form-control @error('ruta_alterna_3') is-invalid @enderror" name="ruta_alterna_3" 
                                                                value="" autocomplete="off" autofocus 
                                                                onchange="verifUrl_ra(this)">
                                                        
                                                                @error('ruta_alterna_3')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_ra_3" name="btnVer_url_ra_3" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_ra(3)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="ra_url_4">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_alterna_4" type="text" class="form-control @error('ruta_alterna_4') is-invalid @enderror" name="ruta_alterna_4" 
                                                                value="" autocomplete="off" autofocus 
                                                                onchange="verifUrl_ra(this)">
                                                        
                                                                @error('ruta_alterna_4')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_ra_4" name="btnVer_url_ra_4" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_ra(4)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="ra_url_5">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_alterna_5" type="text" class="form-control @error('ruta_alterna_5') is-invalid @enderror" name="ruta_alterna_5" 
                                                                value="" autocomplete="off" autofocus 
                                                                onchange="verifUrl_ra(this)">
                                                        
                                                                @error('ruta_alterna_5')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_ra_5" name="btnVer_url_ra_5" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_ra(5)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="ra_url_6">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                            <div class="input-group">
                                                                <input id="ruta_alterna_6" type="text" class="form-control @error('ruta_alterna_6') is-invalid @enderror" name="ruta_alterna_6" 
                                                                value="" autocomplete="off" autofocus 
                                                                onchange="verifUrl_ra(this)">
                                                        
                                                                @error('ruta_alterna_6')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <a id="btnVer_url_ra_6" name="btnVer_url_ra_6" class="btn btn-success" style="color: #fff; pointer-events: none; background-color:  #447161; border: 1px solid  #447161; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                target="_blank"
                                                                onclick="ir_ra(6)">IR</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- 10 -->

                                <!-- Modal -->
                                    <div class="modal fade" id="modal_ra" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"></button>
                                                <h4 class="modal-title">Ventana de Alerta</h4>
                                                </div>
                                                <div class="modal-body">
                                                <p id="msg_modal_ra_t"></p>
                                                <p id="msg_modal_ra_c"></p>
                                                <br>
                                                <a class="collapse-item" href="{{route('dwn_man_user') }}">Manual Usuario</a>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- Modal -->

                                <!-- 11 -->
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="det_recorrido_interno_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Ingrese el detalle del recorrido para la ruta de contingencia"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Detalle Recorrido') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <textarea id="det_recorrido_interno_ra" style="min-height:5rem;" type="text" class="form-control @error('det_recorrido_interno_ra') is-invalid @enderror" name="det_recorrido_interno_ra" 
                                            title=""
                                            value="" required autocomplete="off" autofocus></textarea>
                                            
                                            @error('det_recorrido_interno_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- 11 -->

                                <!-- 12 -->
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="lugar_salida_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione la sede para el punto de encuentro de salida"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Punto Encuentro Salida') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <div class="input-group">

                                                <select name="lugar_salida_ra" class="form-control" required
                                                title=""
                                                style="padding-left: 0.1rem;padding-right: 0.1rem;">
                                                    @foreach($sedes as $sede)
                                                        <option value="{{$sede->id}}" selected>{{$sede->sede}}</option>  
                                                        
                                                    @endforeach
                                                </select>
                                                
                                                @error('lugar_salida_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label for="fecha_salida_aprox_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione la fecha de salida para la ruta de contingencia"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Fecha Salida') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                            <input class="inputDate form-control datetimepicker data-create" id="fecha_salida_aprox_ra" name="fecha_salida_aprox_ra" type="text" required
                                            onchange="duracionRA2(this.value)"
                                            title="">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="lugar_regreso_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione la sede para el punto de encuentro de regreso"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Punto Encuentro Regreso') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <div class="input-group">

                                                <select name="lugar_regreso_ra" class="form-control" required
                                                title=""
                                                style="padding-left: 0.1rem;padding-right: 0.1rem;">
                                                    @foreach($sedes as $sede)
                                                        <option value="{{$sede->id}}" selected>{{$sede->sede}}</option>  
                                                        
                                                    @endforeach
                                                </select>

                                                @error('lugar_regreso_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label for="fecha_regreso_aprox_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione la fecha de regreso para la ruta de contingencia"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Fecha Regreso') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                            <input class="inputDate form-control datetimepicker" id="fecha_regreso_aprox_ra" name="fecha_regreso_aprox_ra" type="text" required
                                            onchange="duracionRA(this.value)"
                                            title="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="duracion_ra" class="col-form-label text-md-left">{{ __('Duración Días') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="duracion_ra" type="text" class="form-control @error('duracion_ra') is-invalid @enderror" name="duracion_ra" 
                                            title="Número de días de duración"
                                            value="" autocomplete="off" autofocus readonly>
                                            
                                            @error('duracion_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                <!-- 12 -->

                                <br>
                                <h4>Transporte</h4>
                                <hr class="divider">

                                <!-- 13 -->
                                    <div  class="form-group row">
                                        <div class="col-md-2">
                                            <label for="cant_transporte_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la cantidad de vehículos requeridos para la ruta de contingencia"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cant. Vehículos') }}</label>
                                            <div class="input-group">
                                                <input id="cant_transporte_ra" type="number" max="3" min="0" pattern="^[0-3]+"  class="form-control @error('cant_transporte_ra') is-invalid @enderror" name="cant_transporte_ra" 
                                                title=""
                                                value="1" required autocomplete="off" autofocus>
                                                
                                                @error('cant_transporte_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-5" id="docente_transp_ra">
                                            <label for="docente_resp_transp_ra" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                            <input id="docente_resp_transp_ra" type="text" class="form-control @error('docente_resp_transp_ra') is-invalid @enderror" name="docente_resp_transp_ra" 
                                            title="Docente responsable de la práctica"
                                            value="{{ $nombre_usuario }}" required autocomplete="off" autofocus readonly>
                                            
                                            @error('docente_resp_transp_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                <!-- 13 -->

                                <!-- 14 transporte_ra_1 -->
                                    <div class="form-group row" id="transporte_ra_1">
                                        <div class="col-md-12" id="transporte_ra">
                                            <div class="row" id="transporte_ra_children">
                                                <div class="col-md-2">
                                                    <label for="id_tipo_transporte_ra_[]" class="col-form-label text-md-right">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Seleccione el tipo de vehículo requerido para la ruta de contingencia"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Tipo Vehículo') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <select name="id_tipo_transporte_ra_[]" class="form-control" required onchange="otroTransporte2(this.value,1)"
                                                    title="">
                                                        @foreach($tipos_transportes as $tp_trans)
                                                        <option value="{{$tp_trans->id}}">{{$tp_trans->tipo_transporte}}</option></option>  
                                                        @endforeach
                                                    </select>
                                                    @error('id_tipo_transporte_ra_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2" id="capac_transp_ra_1">
                                                    <label for="capac_transporte_ra_[]" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique la capacidad de asientos requeridos para el tipo de vehículo previamente seleccionado"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Cap. Vehíc.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="capac_transporte_ra_[]" type="text" class="form-control @error('capac_transporte_ra_[]') is-invalid @enderror" name="capac_transporte_ra_[]" 
                                                    title=""
                                                    value="" required autocomplete="off" autofocus onkeyup="onlyNmb(this)" onchange="onlyNmb(this)">
                                                    
                                                    @error('capac_transporte_ra_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="det_tipo_transporte_ra_[]" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique los detalles o especificaciones que debe tener el vehículo"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Det. Vehíc.') }}</label>
                                                    <input id="det_tipo_transporte_ra_[]" type="text" class="form-control @error('det_tipo_transporte_ra_[]') is-invalid @enderror" name="det_tipo_transporte_ra_[]" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>

                                                    @error('det_tipo_transporte_ra_[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exclusiv_tiempo_ra_1" class="col-form-label text-md-left">
                                                            <i class="fas fa-question-circle" 
                                                                data-toggle="tooltip" data-placement="left" 
                                                                data-title="Indique si requiere disponibilidad permanente del vehículo"
                                                                style="font-size: 0.813rem">
                                                            </i> {{ __('Disponibilidad Permanente') }}</label>
                                                        <span class="hs-form-required">*</span>
                                                        <div class="row">
                                                        
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_1" id="exclusiv_tiempo_ra_1" value="1" checked
                                                                title="">
                                                                <label class="form-check-label" for="">Si</label>
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_1" id="exclusiv_tiempo_ra_1" value="0"
                                                                    title="">
                                                                    <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- 14 transporte_ra_1 -->

                                <!-- 14 transporte_ra_2 -->
                                    <div class="form-group row" id="transporte_ra_2">
                                        <div class="col-md-2">
                                            <label for="id_tipo_transporte_ra_[]" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el tipo de vehículo requerido para la ruta de contingencia"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Tipo Vehículo') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_tipo_transporte_ra_[]" class="form-control" required onchange="otroTransporte2(this.value,2)"
                                            title=""> 
                                                @foreach($tipos_transportes as $tp_trans)
                                                    <option value="{{$tp_trans->id}}" >{{$tp_trans->tipo_transporte}}</option>  
                                                    
                                                @endforeach
                                            </select>
                                            @error('id_tipo_transporte_ra_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-2" id="capac_transp_ra_2">
                                            <label for="capac_transporte_ra_[]" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la capacidad de asientos requeridos para el tipo de vehículo previamente seleccionado"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cap. Vehíc.') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="capac_transporte_ra_[]" type="text" class="form-control @error('capac_transporte_ra_[]') is-invalid @enderror" name="capac_transporte_ra_[]" 
                                            title="" onkeyup="onlyNmb(this)" onchange="onlyNmb(this)"
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('capac_transporte_ra_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="det_tipo_transporte_ra_[]" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique los detalles o especificaciones que debe tener el vehículo"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Det. Vehíc.') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="det_tipo_transporte_ra_[]" type="text" class="form-control @error('det_tipo_transporte_ra_[]') is-invalid @enderror" name="det_tipo_transporte_ra_[]" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('det_tipo_transporte_ra_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="col-md-5" id="docente_transp_ra_2">
                                            <label for="docente_resp_transp_ra_[]" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                            <span class="hs-form-required" title="">*</span>
                                            <input id="docente_resp_transp_ra_[]" type="text" class="form-control @error('docente_resp_transp_ra_[]') is-invalid @enderror" name="docente_resp_transp_ra_[]" 
                                            title="Docente responsable de la práctica"
                                            value="{{ $nombre_usuario }}" autocomplete="off" autofocus readonly>
                                            
                                            @error('docente_resp_transp_ra_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="exclusiv_tiempo_ra_2" class="col-form-label text-md-left">
                                                    <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique si requiere disponibilidad permanente del vehículo"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Disponibilidad Permanente?') }}</label>
                                                <span class="hs-form-required" title="Disponibilidad Permanente?">*</span>
                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_2" value="1" checked
                                                        title="">
                                                        <label class="form-check-label" for="">Si</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_2"  value="0"
                                                            title="">
                                                            <label class="form-check-label" for="">No</label>
                                                        </div>
                                                    </div>

                                                    {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- 14 transporte_ra_2 -->

                                <!-- 14 transporte_ra_3 -->
                                    <div class="form-group row" id="transporte_ra_3">
                                        <div class="col-md-2">
                                            <label for="id_tipo_transporte_ra_[]" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Seleccione el tipo de vehículo requerido para la ruta de contingencia"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Tipo Vehículo') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_tipo_transporte_ra_[]" class="form-control" required onchange="otroTransporte2(this.value,3)"
                                            title="">
                                                @foreach($tipos_transportes as $tp_trans)
                                                    <option value="{{$tp_trans->id}}" >{{$tp_trans->tipo_transporte}}</option>  
                                                    
                                                @endforeach
                                            </select>
                                            @error('id_tipo_transporte_ra_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-2" id="capac_transp_ra_3">
                                            <label for="capac_transporte_ra_[]" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la capacidad de asientos requeridos para el tipo de vehículo previamente seleccionado"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cap. Vehíc.') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="capac_transporte_ra_[]" type="text" class="form-control @error('capac_transporte_ra_[]') is-invalid @enderror" name="capac_transporte_ra_[]" 
                                            title="" onkeyup="onlyNmb(this)" onchange="onlyNmb(this)"
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('capac_transporte_ra_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="det_tipo_transporte_ra_[]" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique los detalles o especificaciones que debe tener el vehículo"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Det. Vehíc.') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="det_tipo_transporte_ra_[]" type="text" class="form-control @error('det_tipo_transporte_ra_[]') is-invalid @enderror" name="det_tipo_transporte_ra_[]" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('det_tipo_transporte_ra_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="col-md-5" id="docente_transp_ra_3">
                                            <label for="docente_resp_transp_ra_[]" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                            <span class="hs-form-required" title="">*</span>
                                            <input id="docente_resp_transp_ra_[]" type="text" class="form-control @error('docente_resp_transp_ra_[]') is-invalid @enderror" name="docente_resp_transp_ra_[]" 
                                            title="Docente responsable de la práctica"
                                            value="{{ $nombre_usuario }}" autocomplete="off" autofocus readonly>
                                            
                                            @error('docente_resp_transp_ra_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="exclusiv_tiempo_ra_3" class="col-form-label text-md-left">
                                                    <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique si requiere disponibilidad permanente del vehículo"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Disponibilidad Permanente?') }}</label>
                                                <span class="hs-form-required" title="Disponibilidad Permanente?">*</span>
                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_3" value="1" checked
                                                        title="">
                                                        <label class="form-check-label" for="">Si</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_3"  value="0"
                                                            title="">
                                                            <label class="form-check-label" for="">No</label>
                                                        </div>
                                                    </div>

                                                    {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- 14 transporte_ra_3 -->

                                <br>
                                <h4>Transporte Menor - Local</h4>
                                <hr class="divider">

                                <!-- cant t. menor -->
                                    <div  class="form-group row">
                                        <div class="col-md-2">
                                            <label for="cant_trans_menor_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la cantidad de vehículos locales requeridos"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cant. Vehículos') }}</label>
                                            <div class="input-group">
                                                <input id="cant_trans_menor_ra" type="number" max="4" min="0" pattern="^[1-4]+"  class="form-control @error('cant_trans_menor_ra') is-invalid @enderror" name="cant_trans_menor_ra" 
                                                title=""
                                                value="0" required autocomplete="off" autofocus>
                                                
                                                @error('cant_trans_menor_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-5" id="docente_trans_menor_ra">
                                            <label for="docente_resp_t_menor_ra" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                                            <input id="docente_resp_t_menor_ra" type="text" class="form-control @error('docente_resp_t_menor_ra') is-invalid @enderror" name="docente_resp_t_menor_ra" 
                                            title="Docente responsable de la práctica"
                                            value="{{ $nombre_usuario }}" required autocomplete="off" autofocus readonly>
                                            
                                            @error('docente_resp_t_menor_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                <!-- cant t. menor -->

                                <!-- 8 trans_menor_rp_1 -->
                                    <div class="form-group row" id="t_menor_ra_1">
                                        <div class="col-md-12" id="trans_menor_ra">
                                            <div class="row" id="trans_menor_ra_children">

                                                <div class="col-md-5">
                                                    <label for="trans_menor_ra_1" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique el tipo de vehículo para el transporte menor o local requerido"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Transporte Menor 1') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="trans_menor_ra_1" type="text" class="form-control @error('trans_menor_ra_1') is-invalid @enderror" name="trans_menor_ra_1" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>
                                        
                                                    @error('trans_menor_ra_1')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="vlr_trans_menor_ra_1" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique valor aproximado del transporte menor o local requerido"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Valor Transp.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="vlr_trans_menor_ra_1" type="text" class="form-control @error('vlr_trans_menor_ra_1') is-invalid @enderror" name="vlr_trans_menor_ra_1" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus  onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                                                    @error('vlr_trans_menor_ra_1')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 trans_menor_rp_1 -->

                                <!-- 8 trans_menor_rp_3 -->
                                    <div class="form-group row" id="t_menor_ra_2">
                                        <div class="col-md-12" id="trans_menor_ra">
                                            <div class="row" id="trans_menor_ra_children">

                                                <div class="col-md-5">
                                                    <label for="trans_menor_ra_2" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique el tipo de vehículo para el transporte menor o local requerido"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Transporte Menor 2') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="trans_menor_ra_2" type="text" class="form-control @error('trans_menor_ra_2') is-invalid @enderror" name="trans_menor_ra_2" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>
                                        
                                                    @error('trans_menor_ra_2')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <label for="vlr_trans_menor_ra_2" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique valor aproximado del transporte menor o local requerido"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Valor Transp.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="vlr_trans_menor_ra_2" type="text" class="form-control @error('vlr_trans_menor_ra_2') is-invalid @enderror" name="vlr_trans_menor_ra_2" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" redonly>

                                                    @error('vlr_trans_menor_ra_2')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 trans_menor_rp_2 -->

                                <!-- 8 trans_menor_rp_3 -->
                                    <div class="form-group row" id="t_menor_ra_3">
                                        <div class="col-md-12" id="trans_menor_ra">
                                            <div class="row" id="trans_menor_ra_children">
                                                
                                                <div class="col-md-5">
                                                    <label for="trans_menor_ra_3" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique el tipo de vehículo para el transporte menor o local requerido"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Transporte Menor 3') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="trans_menor_ra_3" type="text" class="form-control @error('trans_menor_ra_3') is-invalid @enderror" name="trans_menor_ra_3" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>
                                        
                                                    @error('trans_menor_ra_3')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="vlr_trans_menor_ra_3" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique valor aproximado del transporte menor o local requerido"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Valor Transp.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="vlr_trans_menor_ra_3" type="text" class="form-control @error('vlr_trans_menor_ra_3') is-invalid @enderror" name="vlr_trans_menor_ra_3" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                                                    @error('vlr_trans_menor_ra_3')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 trans_menor_rp_3 -->

                                <!-- 8 trans_menor_rp_4 -->
                                    <div class="form-group row" id="t_menor_ra_4">
                                        <div class="col-md-12" id="trans_menor_ra">
                                            <div class="row" id="trans_menor_ra_children">

                                                <div class="col-md-5">
                                                    <label for="trans_menor_ra_4" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique el tipo de vehículo para el transporte menor o local requerido"
                                                            style="font-size: 0.813rem">
                                                        </i> {{ __('Transporte Menor 4') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="trans_menor_ra_4" type="text" class="form-control @error('trans_menor_ra_4') is-invalid @enderror" name="trans_menor_ra_4" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus>
                                        
                                                    @error('trans_menor_ra_4')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="vlr_trans_menor_ra_4" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique valor aproximado del transporte menor o local requerido"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Valor Transp.') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="vlr_trans_menor_ra_4" type="text" class="form-control @error('vlr_trans_menor_ra_4') is-invalid @enderror" name="vlr_trans_menor_ra_4" 
                                                    title=""
                                                    value=""  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                                                    @error('vlr_trans_menor_ra_4')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <!-- 8 trans_menor_rp_4 -->

                                <br>
                                <h4>Otros</h4>
                                <hr class="divider">

                                <!-- materiales -->
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <label for="det_materiales_ra" class="col-form-label text-md-left" title="" hidden>
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique los materiales requeridos para la realización de la práctica académica"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Materiales') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="det_materiales_ra" type="text"  class="form-control @error('det_materiales_ra') is-invalid @enderror" name="det_materiales_ra" 
                                            title="" hidden
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('det_materiales_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="vlr_materiales_ra" class="col-form-label text-md-left" title="" hidden>
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique valor aproximado de los materiales requeridos"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Valor Total Materiales') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="vlr_materiales_ra" type="text"  class="form-control @error('vlr_materiales_ra') is-invalid @enderror" name="vlr_materiales_ra" 
                                            title="" hidden
                                            value="" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                                            
                                            @error('vlr_materiales_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- materiales -->

                                <!-- guías -baquianos -->
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <label for="det_guias_baquia_ra" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique las guías y/o baquianos requeridos para la realización de la práctica académica"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Guías y/o Baquianos') }}</label>
                                            <input id="det_guias_baquia_ra" type="text"  class="form-control @error('det_guias_baquia_ra') is-invalid @enderror" name="det_guias_baquia_ra" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('det_guias_baquia_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="vlr_guias_baquia_ra" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique valor aproximado de las guías y/o baquianos requeridos"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Valor Total Guías y/o Baquianos') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="vlr_guias_baquia_ra" type="text"  class="form-control @error('vlr_guias_baquias_ra') is-invalid @enderror" name="vlr_guias_baquia_ra" 
                                            title=""
                                            value="" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                                            
                                            @error('vlr_guias_baquia_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- guías -baquianos -->

                                <!-- otros - boletas -->
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <label for="det_otros_bolet_ra" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique las boletas y/u otros requeridos para la realización de la práctica académica"
                                                style="font-size: 0.813rem">
                                                </i> {{ __('Boletas y/u Otros') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="det_otros_bolet_ra" type="text"  class="form-control @error('det_otros_bolet_ra') is-invalid @enderror" name="det_otros_bolet_ra" 
                                            title=""
                                            value="" autocomplete="off" autofocus>
                                            
                                            @error('det_otros_bolet_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="vlr_otros_bolet_ra" class="col-form-label text-md-left" title="">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique valor aproximado de las boletas y/u otros requeridos"
                                                style="font-size: 0.813rem">
                                            </i> {{ __('Valor Total Boletas y/u Otros') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="vlr_otros_bolet_ra" type="text"  class="form-control @error('vlr_otros_bolet_ra') is-invalid @enderror" name="vlr_otros_bolet_ra" 
                                            title=""
                                            value="" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                                            
                                            @error('vlr_otros_bolet_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- otros - boletas -->

                                <br>
                                <h4>Actividades de Riesgo</h4>
                                <hr class="divider">

                                <!-- preguntas -->
                                    <div class="form-group row">
                                        <!-- 1 -->
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="areas_acuaticas_ra">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique Si o No según el caso"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Esta sálida desarrolla maniobras sobre áreas acuáticas(Ríos, lagos, lagunas, humedales, mares, etc...?)') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-right: 15px;">
                                                    <label class="switch">
                                                        <input type="checkbox" name="areas_acuaticas_ra" id="areas_acuaticas_ra" onchange="customAlerts(this, 2, 1)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- 1 -->

                                        <!-- 2 -->
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="alturas_ra">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique Si o No según el caso"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Esta sálida desarrolla actividades de escalada o trabajo de alturas?)') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-right: 15px;">
                                                    <label class="switch">
                                                        <input type="checkbox" name="alturas_ra" id="alturas_ra" onchange="customAlerts(this, 2,2)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- 2 -->

                                        <!-- 3 -->
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="riesgo_biologico_ra">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique Si o No según el caso"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Esta sálida desarrolla actividades al interior de bosques o lugares con riesgo biológico?)') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-right: 15px;">
                                                    <label class="switch">
                                                        <input type="checkbox" name="riesgo_biologico_ra" id="riesgo_biologico_ra" onchange="customAlerts(this, 2,3)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- 3 -->

                                        <!-- 4 -->
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="espacios_confinados_ra">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique Si o No según el caso"
                                                        style="font-size: 0.813rem">
                                                    </i> {{ __('Esta sálida desarrolla actividades en espacios confinados?)') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-right: 15px;">
                                                    <label class="switch">
                                                        <input type="checkbox" name="espacios_confinados_ra" id="espacios_confinados_ra" onchange="customAlerts(this, 2,4)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- 4 -->

                                    </div>
                                <!-- preguntas -->

                                <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog">
                                        
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                                            <h4 class="modal-title">Ventana Confirmación</h4>
                                            </div>
                                            <div class="modal-body">
                                            <p id="textModal"></p>
                                            <p id="textModalConfirm"></p>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="text" id="type" name="type" value="" disabled readonly style="width:15px;color:transparent; border-color: transparent; background-color:transparent">
                                                <input type="text" id="resp" name="resp" value="" disabled readonly style="width:15px;color:transparent; border-color: transparent; background-color:transparent">
                                                <button type="button" class="btn btn-success" id="modal-btn-si">Si</button>
                                                <button type="button" class="btn btn-secondary" id="modal-btn-no">No</button>
                                            </div>
                                        </div>
                                        
                                        </div>
                                    </div>

                                <!-- Modal -->

                                <!-- viaticos -->
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="vlr_apoyo_docentes_ra" class="col-form-label text-md-left" >
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Valor de los viáticos para los docentes equivalentes a la duración de la práctica menos el 0.5" style="font-size: 0.813rem"></i> {{ __('Valor Viáticos Docentes') }}</label>
                                            <input id="vlr_apoyo_docentes_ra" type="text"  class="form-control @error('vlr_apoyo_docentes_ra') is-invalid @enderror" name="vlr_apoyo_docentes_ra" 
                                            title=""
                                            value="" autocomplete="off" autofocus readonly>
                                            
                                            @error('vlr_apoyo_docentes_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="vlr_apoyo_estudiantes_ra" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Valor de auxilio económico a estudiantes" style="font-size: 0.813rem"></i> {{ __('Valor Auxilio Estudiantes') }}</label>
                                            <input id="vlr_apoyo_estudiantes_ra" type="text"  class="form-control @error('vlr_apoyo_estudiantes_ra') is-invalid @enderror" name="vlr_apoyo_estudiantes_ra" 
                                            title=""

                                            value="" autocomplete="off" autofocus readonly>
                                            
                                            @error('vlr_apoyo_estudiantes_ra')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        
                                    </div>
                                <!-- viaticos -->

                            <!-- ruta alterna -->

                            
                            <!-- 19 -->
                                <div class="form-group row mb-0">
                                    <div class="col-md-5 offset-md-5">
                                        <br>
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Crear') }}
                                        </button>
                                    </div>
                                </div>
                            <!-- 19 -->
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
        
    @endsection  

    