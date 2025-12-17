@extends ('layouts.app')
@section ('contenido')  
    <br>  
    <br>
    
  <div class="container">

      @if(Auth::user()->coordinador() || Auth::user()->docente() || Auth::user()->admin())
      <div class="row justify-content-center">
        <div class="col-md-12">
            @if($estudiantes->isEmpty())
            <div class="card col-md-10">
              <div class="card-header">{{ __('Subir Listado de Estudiantes Solicitud Práctica N° ') }}<?php echo $id_solicitud?></div>

                <div class="card-body">
                  <form id="importEstudForm" method="POST" action="{{ route('import_list_estud.excel',[$id_solicitud]) }}"  enctype="multipart/form-data">
                        {{-- @method('PUT') --}}
                        @csrf

                    <!-- 1 -->
                    <div class="form-group row">
                        <label for="listado_estudiantes" class="col-md-4 col-form-label text-md-left">Importar Listado de Estudiantes</label>
                        <div class="col-md-6">
                            <input type="file"  name="listado_estudiantes" class="form-control" style="color: rgb(243, 3, 3)">
                        </div>
                        <div class="col-md-2">
                          <button class="btn btn-success" name="import_estudiantes" title="Importar Archivo Excel"><i class="fas fa-file-import"></i>     SUBIR</button></a>
                        </div>
                    </div>
                    <!-- 1 -->
                  </form>
                </div>
            </div>
            @endif
            @if(!$estudiantes->isEmpty())
            <br><br>
            <div class="card">
              <div class="card-header">{{ __('Ver documentos de Estudiantes Solicitud Práctica N° ') }}<?php echo $id_solicitud?></div>
                <div class="card-body">                  
                  <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
                      <button class="btn btn-success btnAbrilModalCrearEstudiante"
                              style="background-color: #447161; border:0"
                              data-toggle="modal"
                              data-target="#modalCrearEstudiante"
                              data-id_solicitud="{{ $id_solicitud }}">
                          Añadir Estudiante
                      </button>
                      <br><br>
                      <thead>                        
                          <th style="width: 50px">Cod.</th>
                          <th style="width: 80px">Nombre</th>
                          <th style="width: 85px">Correo</th> 
                          <th style="width: 110px">Asistencia (documentos subidos correctamente)</th> 
                          <th style="width: 150px">Acciones</th>
                      </thead> 
                      @foreach ($estudiantes as $estudiante)
                      <tr>
                          <td>{{ $estudiante->codigo_estudiante }}</td>
                          <td>{{ $estudiante->nombre_completo }}</td>
                          <td>{{ $estudiante->email }}</td>
                          <td style="text-align: center">
                            <input type="checkbox" id="asistencia" name="asistencia" value="1" disabled
                            <?php if(isset($estudiante) && $estudiante->verificacion_asistencia == 1) echo 'checked' ?>>
                            <button class="ml-3 btn btn-success btnVerificarAsistenciaEstudiante btnGuardarAsist"
                                      style="background-color: #447161; border:0"
                                      data-id_solicitud="{{ $id_solicitud }}"
                                      data-email="{{ $estudiante->email }}"
                                      data-valor = "1"
                                      <?php if(isset($estudiante) && $estudiante->verificacion_asistencia == 1) echo 'disabled' ?>>
                                  Guardar
                            </button>
                            <button class="ml-3 btn btn-success btnVerificarAsistenciaEstudiante btnQuitarAsist"
                                      style="background-color: #447161; border:0"
                                      data-id_solicitud="{{ $id_solicitud }}"
                                      data-email="{{ $estudiante->email }}"
                                      data-valor = "0"
                                      <?php if(isset($estudiante) && $estudiante->verificacion_asistencia == 0) echo 'disabled' ?>>
                                  Quitar
                            </button>
                          </td>
                          <td style="text-align: center"> 
                              <button class="btn btn-success btnVerDocumentos"
                                      style="background-color: #447161; border:0"
                                      data-toggle="modal"
                                      data-target="#modalVerDocs"
                                      data-id_solicitud="{{ $id_solicitud }}"
                                      data-email="{{ $estudiante->email }}"
                                      data-nombre="{{ $estudiante->nombre_completo }}">
                                  Ver Documentos
                              </button>
                              <button class="ml-3 btn btn-danger btnEliminarEstudiante"
                                      style="border:0"
                                      data-id_solicitud="{{ $id_solicitud }}"
                                      data-email="{{ $estudiante->email }}">
                                  Eliminar
                              </button>
                          </td>
                      </tr>
                      @endforeach
                  </table>
                  <br>                  
                </div>
              </div> 
              <br><br>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong class="text-danger">Advertencia:</strong> Verificar correctamente que los estudiantes cuenten con su asistencia, ya que una vez enviada
                    la solicitud, el sistema recalculará los viáticos de los estudiantes que tengan su asistencia marcada.
                </div> 
              <button class="ml-3 btn btn-success btnEnviarSolicitudRevision" style="border:0"
                      data-id_solicitud="{{ $id_solicitud }}">
                  Enviar Solicitud
              </button>    
            @endif      
            </div>
          </div>
            <br>
        </div>
    </div>
    @endif

<!-- modal -->
<div class="modal fade" id="modalVerDocs" tabindex="-1" role="dialog" aria-labelledby="modalVerDocsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background: #447161; color: white;">
                <h5 class="modal-title">
                    Documentos de <span id="nombreEstudianteDocs"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="documentosLoader" class="text-center my-4" style="display: none;">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando documentos...</p>
                </div>
                <div id="listaDocumentos">
                    <!-- Carga de documentos -->
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
<!-- modal -->

<!-- Modal: Crear Estudiante -->
<div class="modal fade" id="modalCrearEstudiante" tabindex="-1" role="dialog" aria-labelledby="modalCrearEstudianteLabel" aria-hidden="true">
    <br><br><br><br><br><br><br>
    <div class="modal-dialog mt-5" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Añadir Estudiante a Solicitud N° {{ $id_solicitud }}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
              <div class="modal-body">
                  <input type="hidden" id="id_solicitud_modal" name="id_solicitud">
                  <div class="form-group">
                      <label>Código del Estudiante</label>
                      <input type="number" id="codigo_estudiante" name="codigo_estudiante" class="form-control" required>
                  </div>
                  <div class="form-group mt-3">
                      <label>Nombre Completo</label>
                      <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required>
                  </div>
                  <div class="form-group mt-3">
                      <label>Correo Institucional</label>
                      <input type="email" id="email_estudiante" name="email" class="form-control" required>
                  </div>
                  <div class="form-group mt-3">
                      <label>Grupo</label>
                      <input type="text" id="grupo_estudiante" name="grupo" class="form-control">
                  </div>
              </div>

              <div class="modal-footer">
                  <button type="submit" class="btn btn-success" id="btnCrearEstudiante">
                      Guardar
                  </button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      Cerrar
                  </button>
              </div>
        </div>
    </div>
</div>
<!-- Modal: Crear Estudiante -->
@endsection