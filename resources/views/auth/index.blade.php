@extends ('layouts.app')
@section ('contenido')  

  
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5"></div>
      <div class="card-header">{{ __('Listado de Usuarios') }}</div>
    </div>
    @if(Auth::user()->decano() || Auth::user()->asistenteD() || Auth::user()->admin() )
      <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
              @include('auth.buscador')
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            
          <form method="POST" action="{{ route('import_list_users.excel') }}"  enctype="multipart/form-data">
            @csrf
           
            <div class="row">
              <div class="form-group">
                    <input type="file"  name="usuarios" class="form-control" required style="color: rgb(243, 3, 3)">
              </div>
              <div class="form-group">
                <label for=""></label>
                  <button class="btn btn-success" name="import_users"><i class="fas fa-file-import"></i>     SUBIR</button>
              </div>
            </div> 
          </form>
        </div>


        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
          <div class="form-group">
              <a href="{{route('export_list_users.excel')}}"><button class="btn btn-success" ><i class="fas fa-download"></i>     BAJAR</button></a>
          </div>
        </div>
      </div>
    @endif

      <!-- 0 -->
      <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="id_estado_usuario"   @if(!isset($filter)) checked="true" @endif onclick="filterUser(this.value)" value="3" checked>
                        <label class="form-check-label" for="">Todos</label>
                      </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="id_estado_usuario"  @if(isset($filter) and ($filter == 'act')) checked="true" @endif onclick="filterUser(this.value)" value="1">
                        <label class="form-check-label" for="">Activos</label>
                      </div>
                    </div>
  
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="id_estado_usuario"  @if(isset($filter) and ($filter == 'inac')) checked="true" @endif onclick="filterUser(this.value)" value="2">
                          <label class="form-check-label" for="">Inactivos</label>
                      </div>
                    </div>

                </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
          </div>
      </div>
      <!-- 0 -->

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          <table class="table table-bordered table-condensed table-hover table-sm" cellspacing="0" style="table-layout: fixed; width:100%; word-break: break-word; font-size: 12px">
           <thead>
            <th style="width: 22px">TI</th>
            <th style="width: 60px">Identificación</th>
            <th style="width: 75px">Nombres</th> 
            <th style="width: 75px">Apellidos</th>
            <th style="width: 50px">Usuario</th>
            <th style="width: 120px">E-Mail</th>
            <th style="width: 65px">Rol</th>
            <th style="width: 39px">Acción</th>
           </thead> 
            @foreach ($usuarios as $item) 
                   <tr>
                     <td>{{ $item->sigla}}</td>
                     <td>{{ $item->id }}</td>
                     <td>{{ $item->primer_nombre }} {{$item->segundo_nombre}}</td>
                     <td>{{ $item->primer_apellido }} {{$item->segundo_apellido}}</td>
                     <td>{{ $item->usuario }}</td>
                     <td>{{ $item->email }}</td>
                     <td>{{ $item->role }}</td> 
                     <td> 
                      <a href="{{URL::action('Users\UsersController@edit',Crypt::encrypt($item->id))}}">
                          {{-- <a href="{{route('users_edit')}}"> --}}
                        <button class="btn-success" style="background-color: #447161; border:0">Editar</button></a> 
                     </td>
                   </tr>
            @endforeach 
          </table>
          {{$usuarios->render()}}
            
      </div>
        
    {{-- </div>
  </div> --}}
            
  
@endsection