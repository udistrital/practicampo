@extends ('layouts.app')
@section ('contenido')  

  
  <div class="container-fluid" id="sel_proy_buscador">
      <div class="card-header">{{ __('Resultado Búsqueda Usuarios') }}</div>
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
            <div class="form-group">
                
            </div>
            </div>
            
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
                  @foreach ($resultadoUsuarios as $item) 
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
                              <button class="btn-success" style="background-color: #447161; border:0">Editar</button></a> 
                           </td>
                         </tr>
                  @endforeach 
                </table>
                {{$resultadoUsuarios->render()}}
                  
            </div>
        </div>

  
@endsection