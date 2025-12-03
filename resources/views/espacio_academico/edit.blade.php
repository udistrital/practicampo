<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')
<div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card col-md-10 mx-auto">
                    <div class="card-header"><h4>{{ __('Crear nuevo espacio académico') }}</div>  
                    <div class="card-body">
                        <form id="formCrearEspacioAcademico" method="POST" action="{{ route('create_espacio_academico') }}" onsubmit="return confirmarGuardar(event)">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-4">
                                <label for="id_espacio_academico" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Cod. espacio académico</label>
                                    <input id="codigo_espacio_academico" type="number" class="form-control col-md-12"
                                    name="codigo_espacio_academico" autocomplete="off" autofocus title="" required>
                                </div> 
                                <div class="col-md-6">
                                <label for="nombre_espacio_academico" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Nombre espacio académico</label>
                                    <input id="nombre_espacio_academico" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-8"
                                    name="nombre_espacio_academico" autocomplete="off" autofocus title="" required>
                                </div>                    
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8">
                                <label for="id_programa_academico" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Seleccionar Programa Académico</label>
                                    <select id="id_programa_academico" name="id_programa_academico" class="form-control col-md-12" required>
                                        <option value="" disabled selected>-- Seleccione --</option>
                                        @foreach($programas_academicos as $programa)
                                            <option value="{{ $programa->id }}">
                                                {{ $programa->programa_academico }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>                   
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                <label for="plan_estudios_1" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Plan de estudios 1</label>
                                    <input id="plan_estudios_1" type="number" class="form-control"
                                    name="plan_estudios_1" autocomplete="off" autofocus title="" required>
                                </div> 
                                <div class="col-md-4">
                                <label for="plan_estudios_2" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Plan de estudios 2</label>
                                    <input id="plan_estudios_2" type="number" class="form-control"
                                    name="plan_estudios_2" autocomplete="off" autofocus title="">
                                </div>  
                                <div class="col-md-4">
                                <label for="tipo_espacio" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Tipo de espacio académico</label>
                                    <input id="tipo_espacio" type="text" class="form-control"
                                    name="tipo_espacio" autocomplete="off" autofocus title="" placeholder="T/P" value="T/P" required>
                                </div>                    
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-md-4">
                                    <label class="col-form-label text-md-left">¿Es electiva?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="electiva" id="electiva_si" value="1" >
                                        <label class="form-check-label" for="electiva_si">Sí</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="electiva" id="electiva_no" value="0" checked>
                                        <label class="form-check-label" for="electiva_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <button id="btnCrearEspacioAcademico" type="submit" class="btn btn-success"> {{ __('Crear') }} </button>
                        </form>
                    </div> 
                </div>
                <br>
                <div class="card">
                    <div class="card-header"><h4>{{ __('Espacios Académicos') }}</h4></div>    
                    <div class="card-body">
                        <br>
                        <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table">
                            <thead>
                                <th style="width: 70px">Programa Académico</th>
                                <th style="width: 35px">Cod. Esp.</th>                                
                                <th style="width: 70px">Espacio Académico</th>
                                <th style="width: 35px">Plan de estudios 1</th>   
                                <th style="width: 35px">Plan de estudios 2</th>  
                                <th style="width: 35px">Tipo espacio</th>  
                                <th style="width: 35px">Electiva</th>  
                                <th style="width: 50px">Acciones</th>
                            </thead>

                            @foreach ($espacios_academicos as $item)
                            <tr>
                                <td>{{ $item->nombre_programa_academico }}</td>
                                <td>{{ $item->codigo_espacio_academico }}</td>
                                <td>{{ $item->espacio_academico }}</td>
                                <td>{{ $item->plan_estudios_1 }}</td>
                                <td>{{ $item->plan_estudios_2 }}</td>
                                <td>{{ $item->tipo_espacio }}</td>
                                @if($item->electiva == 1)
                                    <td>Si</td>
                                @else
                                    <td>No</td>
                                @endif
                                <td style="text-align: center">
                                    <button 
                                        class="btn btn-success btnEditarEspacioAcademico" 
                                        style="background-color: #447161; border:0"
                                        data-id="{{ $item->id }}"
                                        data-id_programa_academico="{{ $item->id_programa_academico }}"
                                        data-codigo_espacio_academico="{{ $item->codigo_espacio_academico }}"
                                        data-nombre_espacio_academico="{{ $item->espacio_academico }}"
                                        data-plan_estudios_1="{{ $item->plan_estudios_1 }}"
                                        data-plan_estudios_2="{{ $item->plan_estudios_2 }}"
                                        data-tipo_espacio="{{ $item->tipo_espacio }}"
                                        data-electiva="{{ $item->electiva }}"                                        
                                        data-toggle="modal"
                                        data-target="#editModal">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                            <br><br><br><br><br><br><br>
                            <div class="modal-dialog mt-5" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        
                                        <h5 class="modal-title">Editar Espacio Académico</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form id="formEditarEspacioAcademico" method="POST" onsubmit="return confirmarGuardar(event)">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Código del Espacio</label>
                                                    <input type="number" id="codigo_espacio_academico_edit" name="codigo_espacio_academico" class="form-control">
                                                </div>
                                                <div class="col-md-8">
                                                    <label>Nombre del Espacio</label>
                                                    <input type="text" id="nombre_espacio_academico_edit" name="nombre_espacio_academico" class="form-control">
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Programa Académico</label>
                                                    <select id="id_programa_academico_edit" 
                                                            name="id_programa_academico" 
                                                            class="form-control" required>                                                        
                                                        @foreach($programas_academicos as $programa)
                                                            <option value="{{ $programa->id }}">
                                                                {{ $programa->programa_academico }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>                                           
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Plan de estudios 1</label>
                                                    <input type="number" id="plan_estudios_1_edit" name="plan_estudios_1" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Plan de estudios 2</label>
                                                    <input type="number" id="plan_estudios_2_edit" name="plan_estudios_2" class="form-control">
                                                </div>   
                                                <div class="col-md-4">
                                                    <label>Tipo de Espacio</label>
                                                    <input type="text" id="tipo_espacio_edit" name="tipo_espacio" class="form-control">
                                                </div>                                             
                                            </div>
                                            <div class="form-group mt-3">
                                                <label>¿Es electiva?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="electiva" id="electiva_edit_si" value="1">
                                                    <label class="form-check-label" for="electiva_edit_si">Sí</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="electiva" id="electiva_edit_no" value="0">
                                                    <label class="form-check-label" for="electiva_edit_si">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btnGuardarEspacioAcademico" type="submit" class="btn btn-success" name="btnGuardarEspacioAcademico">
                                            {{ __('Guardar') }}
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->             
                    </div>
                </div>
            </div>
        </div>
    @endsection   
