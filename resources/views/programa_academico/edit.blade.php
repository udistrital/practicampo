<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')
<div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Crear nuevo programa académico') }}</div>  
                    <div class="card-body">
                        <form id="formCrearProgramaAcademico" method="POST" action="{{ route('create_programa_academico') }}" onsubmit="return confirmarGuardar(event)">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-3">
                                <label for="id_programa_academico" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Cod. programa académico</label>
                                    <input id="id_programa_academico" type="number" class="form-control col-md-12"
                                    name="id_programa_academico" autocomplete="off" autofocus title="" required>
                                </div> 
                                <div class="col-md-7">
                                <label for="nombre_programa_academico" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Nombre programa académico</label>
                                    <input id="nombre_programa_academico" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-8"
                                    name="nombre_programa_academico" autocomplete="off" autofocus title="" required>
                                </div>                    
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-md-4">
                                    <label class="col-form-label text-md-left">¿Es pregrado?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pregrado" id="pregrado_si" value="1" checked>
                                        <label class="form-check-label" for="pregrado_si">Sí</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pregrado" id="pregrado_no" value="0">
                                        <label class="form-check-label" for="pregrado_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <button id="btnCrearProgramaAcademico" type="submit" class="btn btn-success"> {{ __('Crear') }} </button>
                        </form>
                    </div> 
                </div>
                <br>
                <div class="card">
                    <div class="card-header"><h4>{{ __('Programas Académicos') }}</h4></div>    
                    <div class="card-body">
                        <br>
                        <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table">
                            <thead>
                                <th style="width: 35px">Cod.</th>
                                <th style="width: 70px">Programa Académico</th>
                                <th style="width: 50px">Acciones</th>
                            </thead>

                            @foreach ($programas_academicos as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->programa_academico }}</td>
                                <td style="text-align: center">
                                    <button 
                                        class="btn btn-success btnEditarProgramaAcademico" 
                                        style="background-color: #447161; border:0"
                                        data-id="{{ $item->id }}"
                                        data-programa_academico="{{ $item->programa_academico }}"
                                        data-pregrado="{{ $item->pregrado }}"
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
                                        
                                        <h5 class="modal-title">Editar Programa Académico</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form id="formEditarProgramaAcademico" method="POST" onsubmit="return confirmarGuardar(event)">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nombre del Programa</label>
                                                <input type="text" id="nombre_programa_academico_edit" name="nombre_programa_academico" class="form-control">
                                            </div>
                                            <div class="form-group mt-3">
                                                <label>¿Es pregrado?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pregrado" id="pregrado_edit_si" value="1">
                                                    <label class="form-check-label" for="pregrado_edit_si">Sí</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pregrado" id="pregrado_edit_no" value="0">
                                                    <label class="form-check-label" for="pregrado_edit_no">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btnGuardarProgramaAcademico" type="submit" class="btn btn-success" name="btnGuardarProgramaAcademico">
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
