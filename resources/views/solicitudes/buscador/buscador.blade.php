@extends ('layouts.app')
@section ('contenido')  

  
  <div class="container-fluid">
      <div class="card-header">{{ __('Resultado Búsqueda Solicitudes Práctica') }}</div>
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
            <div class="form-group">
                
            </div>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{route('export_list_solicit.excel')}}" method="GET" name="soli_buscador">
                    @csrf
                <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
                    <thead>
                        <th style="width: 25px">Sel. Todo <input type="checkbox" id="sel_soli" name="sel_soli" value="" onchange="sel_todo_nada_soli()"></th>
                        <th style="width: 35px">Cod.</th>
                        <th style="width: 90px">Proy. Curricular</th>
                        <th style="width: 95px">Esp. Académico</th> 
                        <th style="width: 95px">Destino</th>
                        <th style="width: 35px">Fecha Salida</th>
                        <th style="width: 35px">Fecha Regreso</th>
                        <th style="width: 25px">Coord.</th>
                        <th style="width: 25px">Decan.</th>
                    </thead> 
                    @foreach ($proyecciones as $item) 
                    <tr>
                       <td style="text-align:center;"><label>
                           <input type="checkbox" id="solicitud_list[]" name="solicitud_list[]" value="{{ $item->id_solicitud }}"></label></td> 
                       <td>{{ $item->id_solicitud }}</td>
                       <td>{{ $item->programa_academico }}</td>
                       <td>{{ $item->espacio_academico }}</td>
                       <td>{{ $item->destino_rp }}</td>
                       <td>{{ $item->fecha_salida_aprox_rp }}</td>
                       <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
                       <td>{{ $item->ap_coor }}</td> 
                       <td>{{ $item->ap_dec }}</td>
                </tr>
                @endforeach 
            </table>
            {{-- <a href="{{route('export_list_solicit.excel')}}"> --}}
            <button class="btn-success" style="background-color: #447161; border:0" name="export_solicitud" id="export_solicitud" disabled><i class="fas fa-download"></i>   XLS</button>
            {{-- </a>  --}}
            </div>
            </form>
            {{-- onclick="export_solicitud()" --}}
        </div>

  
@endsection