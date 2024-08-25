<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->

{{-- @if(Auth::user()->inactivo())
  @section('contenido')
    <div class="container-fluid">
      <h6> Usuario Inactivo</h6>
      
  @endsection

@else --}}
  @section('contenido')
  <div class="container-fluid">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>Larry</td>
          <td>the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>

  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <form method="POST" action="{{ route('import_doc_estudiante.img') }}"  enctype="multipart/form-data">
        @csrf
       
      <div class="row">
        <div class="form-group">
            <label for=""></label>
            <input type="file"  name="plan_contingencia" style="color: rgb(243, 3, 3)">
        </div>
        <div class="form-group">
          <button class="btn btn-success" name="import_proyecciones" title="Importar Archivo Excel"><i class="fas fa-file-import"></i>     CSV</button></a>
        </div>
      </div>

      <div>
        {{-- <input type="img"  name="plan_contingencia" style="color: rgb(243, 3, 3)" <php echo $imagen?>> --}}
        {{-- <img src="{{$img}}" alt=""> --}}
      </div>
      </form>
  </div>
    {{-- <div>
        <button class="btn btn-success" name="import_users" href="{{route('enviar_correo') }}">Enviar</button></a>
    </div> --}}
    
  @endsection

{{-- @endif --}}
