<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')
<div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                <div class="card">
                    <div class="card col-md-5">
                        <div class="card-header"><h4>{{ __('Listar estudiantes por solicitud') }}</div>  
                        <div class="card-body">
                            <form id="formListarEstudiantes" method="POST" action="{{ route('listar_estudiantes') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-8">
                                    <label for="id_solicitud" class="col-form-label text-md-left" title=""><i class="" 
                                        data-toggle="tooltip" data-placement="left" 
                                        data-title="" style="font-size: 0.813rem"></i>Seleccionar Solicitud</label>
                                        <select id="id_solicitud" name="id_solicitud" class="form-control select2 col-md-12" required>
                                            <option value="" disabled selected>-- Seleccione --</option>
                                            @foreach($solicitudes as $solicitud)
                                                <option value="{{ $solicitud->id }}">
                                                    {{ $solicitud->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                   
                                </div>                            
                                <button id="btnListarEstudiantes" type="submit" class="btn btn-success"> {{ __('Confirmar') }} </button>
                            </form>
                        </div> 
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header"><h4>{{ __('Estudiantes') }}</h4></div>    
                        <div class="card-body">
                            <br>
                            <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table">
                                <thead>
                                    <th style="width: 40px">N° Identificación</th>
                                    <th style="width: 40px">Código Estudiante</th>                                
                                    <th style="width: 50px">Nombre Completo</th>
                                    <th style="width: 80px">Correo</th>   
                                    <th style="width: 35px">Fecha Nacimiento</th>  
                                    <th style="width: 35px">Celular</th>  
                                    <th style="width: 35px">EPS</th>  
                                    <th style="width: 30px">Acciones</th>
                                </thead>

                                @foreach ($estudiantes as $item)
                                <tr>
                                    <td>{{ $item->num_identificacion }}</td>
                                    <td>{{ $item->codigo_estudiante }}</td>
                                    <td>{{ $item->nombre_completo }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->fecha_nacimiento }}</td>
                                    <td>{{ $item->celular }}</td>
                                    <td>{{ $item->eps }}</td>
                                    <td style="text-align: center">
                                        <button 
                                            class="btn btn-success btnEditarEstudiante" 
                                            style="background-color: #447161; border:0"
                                            data-num_identificacion="{{ $item->num_identificacion }}"
                                            data-codigo_estudiante="{{ $item->codigo_estudiante }}"
                                            data-nombre_completo="{{ $item->nombre_completo }}"
                                            data-email="{{ $item->email }}"
                                            data-fecha_nacimiento="{{ $item->fecha_nacimiento }}"
                                            data-celular="{{ $item->celular }}"
                                            data-eps="{{ $item->eps }}"                                      
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
                                            
                                            <h5 class="modal-title">Editar Estudiante</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form id="formEditarEstudiante" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label>N° Identificación</label>
                                                        <input type="number" id="num_identificacion_edit" name="num_identificacion" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Código Estudiante</label>
                                                        <input type="number" id="codigo_estudiante_edit" name="codigo_estudiante" class="form-control">
                                                    </div>  
                                                    <div class="col-md-4">
                                                        <label>Nombre Completo</label>
                                                        <input type="text" id="nombre_completo_edit" name="nombre_completo" class="form-control">
                                                    </div>                                              
                                                </div>
                                                <div class="form-group row">                                                
                                                    <div class="col-md-4">
                                                        <label>Correo</label>
                                                        <input type="email" id="email_edit" name="email" class="form-control">
                                                    </div>   
                                                    <div class="col-md-4">
                                                        <label>Fecha de Nacimiento</label>
                                                        <input type="date" id="fecha_nacimiento_edit" name="fecha_nacimiento" class="form-control">
                                                    </div>                                             
                                                </div>
                                                <div class="form-group row">                                                
                                                    <div class="col-md-4">
                                                        <label>Celular</label>
                                                        <input type="number" id="celular_edit" name="celular" class="form-control">
                                                    </div>   
                                                    <div class="col-md-4">
                                                        <label>EPS</label>
                                                        <input type="text" id="eps_edit" name="eps" class="form-control">
                                                    </div>                                             
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="btnGuardarEstudiante" type="button" class="btn btn-success btnGuardarEstudiante" name="btnGuardarEstudiante">
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
                <br>
                <div class="card">
                    <div class="card-header"><h4>{{ __('Borrar Documentos de Estudiantes por Fechas') }}</div>  
                        <div class="card-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Advertencia:</strong> Tener mucho cuidado con las fechas que se ponen, ya que esta acción no se puede deshacer.
                            </div>
                            <form id="formBorrarDocsEstudiantes" method="POST" action="{{ route('estudiantes_delete_docs') }}" onsubmit="confirmarGuardar(event)">
                                @method('PUT')
                                @csrf
                                <div class="form-group row">                                              
                                    <div class="col-md-4">
                                        <label>Fecha Inicial:</label>
                                        <input type="date" id="fecha_inicial" name="fecha_inicial" class="form-control" required>
                                    </div>   
                                    <div class="col-md-4">
                                        <label>Fecha Final:</label>
                                        <input type="date" id="fecha_final" name="fecha_final" class="form-control" required>
                                    </div>                 
                                </div>                            
                                <button id="btnListarEstudiantes" type="submit" class="btn btn-success"> {{ __('Borrar') }} </button>
                            </form>
                        </div> 
                </div>
            </div>
        </div>
    @endsection   
