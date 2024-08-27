@if($filter == 'all')    
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 90px">Proy. Curricular</th>
            <th style="width: 95px">Esp. Académico</th> 
            <th style="width: 105px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
        <tr>
            <td>{{ $item->id_solicitud }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            <td>{{ $item->destino_rp }}</td>
            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
            <td>{{ $item->ap_coor }}</td> 
            <td>{{ $item->ap_dec }}</td>
            <td style="text-align: center"> 
                <a href="{{route('solicitud_rutas',[Crypt::encrypt($item->id)])}}">
                    <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                </a> 
            </td>
        </tr>
        @endforeach 
    </table>
    {{$proyecciones->render()}}
@endif

@if($filter == 'inact')    
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 90px">Proy. Curricular</th>
            <th style="width: 95px">Esp. Académico</th> 
            <th style="width: 105px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
        <tr>
            <td>{{ $item->id_solicitud }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            <td>{{ $item->destino_rp }}</td>
            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
            <td>{{ $item->ap_coor }}</td> 
            <td>{{ $item->ap_dec }}</td>
            <td style="text-align: center"> 
                <a href="{{route('solicitud_rutas',[Crypt::encrypt($item->id)])}}">
                    <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                </a> 
            </td>
        </tr>
        @endforeach 
    </table>
    {{$proyecciones->render()}}
@endif
