@extends ('layouts.app')
@section ('contenido')  
    <br>  
    <br>
    
  <div class="container">

      @if(Auth::user()->coordinador() || Auth::user()->docente() || Auth::user()->admin())
      <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
              <div class="card-header">{{ __('Listado de Estudiantes  solicitud Práctica N° ') }}<?php echo $id_solicitud?></div>

                <div class="card-body">
                  <form method="POST" action="{{ route('import_list_estud.excel',[$id_solicitud]) }}"  enctype="multipart/form-data">
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
            <br>
        </div>
    </div>
    @endif
  
@endsection