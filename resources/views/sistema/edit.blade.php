<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Editar Valores Sistema') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('sistema_update') }}">
                            @method('PUT')
                            @csrf

                        <br>
                        <h4>Apoyo Viáticos</h4>
                        <hr class="divider">
                        <br>

                        <!-- 5 -->
                        <div class="form-group row">
                            <div class="col-md-3">
                            <label for="vlr_docen_min" class="col-form-label text-md-left" title="Estudiantes (1 Día)"><i class="fas fa-question-circle" 
                                data-toggle="tooltip" data-placement="left" 
                                data-title="Indique valor para viáticos de los docentes 
                                asociado a una salida de práctica académica de 1 día" style="font-size: 0.813rem"></i> {{ __('Docentes (1 Día)') }}</label>
                                <input id="vlr_docen_min" type="text"  class="form-control @error('vlr_docen_min') is-invalid @enderror" name="vlr_docen_min" 
                                value="{{$control_sistema->vlr_docen_min}}" autocomplete="off" autofocus title="Ingresar Valor Estudiantes (1 Día)">

                                @error('vlr_docen_min')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                            <label for="vlr_docen_max" class="col-form-label text-md-left" title="Estudiantes (Más de 1 Día)"><i class="fas fa-question-circle" 
                                data-toggle="tooltip" data-placement="left" 
                                data-title="Indique valor para viáticos de los docentes 
                                asociado a una salida de práctica académica de más de 1 día" style="font-size: 0.813rem"></i> {{ __('Docentes (Varios Días)') }}</label>
                                <input id="vlr_docen_max" type="text"  class="form-control @error('vlr_docen_max') is-invalid @enderror" name="vlr_docen_max" 
                                value="{{$control_sistema->vlr_docen_max}}" autocomplete="off" autofocus title="Ingresar Valor Estudiantes (Más de 1 Día)">
                                
                                @error('vlr_docen_max')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                            <div class="col-md-3">
                            <label for="vlr_estud_min" class="col-form-label text-md-left" title="Docentes (1 Día)"><i class="fas fa-question-circle" 
                                data-toggle="tooltip" data-placement="left" 
                                data-title="Indique valor para auxilio de los estudiantes 
                                asociado a una salida de práctica académica de 1 día" style="font-size: 0.813rem"></i> {{ __('Estudiantes (1 Día)') }}</label>
                                <input id="vlr_estud_min" type="text"  class="form-control @error('vlr_estud_min') is-invalid @enderror" name="vlr_estud_min" 
                                value="{{$control_sistema->vlr_estud_min}}" autocomplete="off" autofocus title="Ingresar Valor Docentes (1 Día)">
                                
                                @error('vlr_estud_min')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                            <label for="vlr_estud_max" class="col-form-label text-md-left" title="Docentes (Más de 1 Día)"><i class="fas fa-question-circle" 
                                data-toggle="tooltip" data-placement="left" 
                                data-title="Indique valor para auxilio de los estudiantes 
                                asociado a una salida de práctica académica de más de 1 día" style="font-size: 0.813rem"></i> {{ __('Estudiantes (Varios Días)') }}</label>
                                <input id="vlr_estud_max" type="text"  class="form-control @error('vlr_estud_max') is-invalid @enderror" name="vlr_estud_max" 
                                value="{{$control_sistema->vlr_estud_max}}" autocomplete="off" autofocus title="Ingresar Valor Docentes (Más de 1 Día)">
                                
                                @error('vlr_estud_max')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 

                        </div>
                        <!-- 5 -->

                        <br>
                        <h4>Proyección Preliminar</h4>
                        <hr class="divider">
                        <br>

                        <!-- 6 -->
                        <div class="form-group row">
                            <div class="col-lg-2 col-md-2"></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="fecha_apert_proy" class="col-form-label text-md-left"><i class="fas fa-question-circle" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="Seleccione la fecha de apertura del módulo de proyecciones" style="font-size: 0.813rem"></i> {{ __('Fecha Apertura Proyección') }}</label>
                                <span class="hs-form-required">*</span>
                                  <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                  <input class="inputDate form-control datetimepicker" id="fecha_apert_proy" name="fecha_apert_proy" type="text" required
                                  value="{{$control_sistema->fecha_apert_proy}}">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="fecha_cierre_proy" class="col-form-label text-md-left"><i class="fas fa-question-circle" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="Seleccione la fecha de cierre del módulo de proyecciones" style="font-size: 0.813rem"></i> {{ __('Fecha Cierre Proyección') }}</label>
                                <span class="hs-form-required">*</span>
                                  <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                  <input class="inputDate form-control datetimepicker" id="fecha_cierre_proy" name="fecha_cierre_proy" type="text" required
                                  value="{{$control_sistema->fecha_cierre_proy}}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2"></div>

                        </div>
                        <!-- 6 -->

                        <br>
                        <h4>Solicitud Práctica</h4>
                        <hr class="divider">
                        <br>

                        <!-- 7-->
                        <div class="form-group row">
                            
                            <div class="col-lg-2 col-md-2"></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="fecha_apert_solic" class="col-form-label text-md-left"><i class="fas fa-question-circle" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="Seleccione la fecha de apertura del módulo de solicitudes" style="font-size: 0.813rem"></i> {{ __('Fecha Apertura Solicitud') }}</label>
                                <span class="hs-form-required">*</span>
                                  <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="inputDate form-control datetimepicker" id="fecha_apert_solic" name="fecha_apert_solic" type="text" required
                                    value="{{$control_sistema->fecha_apert_solic}}">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="fecha_cierre_solic" class="col-form-label text-md-left"><i class="fas fa-question-circle" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="Seleccione la fecha de cierre del módulo de solicitudes" style="font-size: 0.813rem"></i> {{ __('Fecha Cierre Solicitud') }}</label>
                                <span class="hs-form-required">*</span>
                                  <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                  <input class="inputDate form-control datetimepicker" id="fecha_cierre_solic" name="fecha_cierre_solic" type="text" required
                                  value="{{$control_sistema->fecha_cierre_solic}}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2"></div>

                        </div>
                        <!-- 7 -->
                        

                        <!-- submit -->
                            <!-- 8 -->
                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-5">
                                    <br>
                                    <button type="submit" class="btn btn-success" name="submit">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </div>
                            <!-- 8 -->
                        <!-- submit -->
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
        
    @endsection   