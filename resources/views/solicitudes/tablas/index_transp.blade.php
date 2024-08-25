
<table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
<thead>
    <th style="width: 30px">Cod.</th>
    <th style="width: 55px">Proy. Curricular</th>
    <th style="width: 55px">Esp. Académico</th> 
    <th style="width: 75px">Docente</th> 
    <th style="width: 65px">Destino</th>
    <th style="width: 35px">Fecha Salida</th>
    <th style="width: 35px">Fecha Regreso</th>
    <th style="width: 20px">Acciones</th>
    
</thead> 
@foreach ($proyecciones as $item) 
<tr>
    {{-- <form name="proy_buscador"> --}}
   <td>{{ $item->id_solicitud }}</td>
   <td>{{ $item->programa_academico }}</td>
   <td>{{ $item->espacio_academico }}</td>
   <td>{{ $item->full_name }}</td>
   
    @if($item->tipo_ruta == 1)
    <td>{{ $item->destino_rp }}</td>
    @endif
    @if($item->tipo_ruta == 2)
    <td>{{ $item->destino_ra }}</td>
    @endif
    
    <td>{{ $item->fecha_salida }}</td>
    <td>{{ $item->fecha_regreso }}</td> 
    <td style="text-align: center"> 
        <a href="{{route('solicitud_edit',[Crypt::encrypt($item->id),Crypt::encrypt($item->tipo_ruta)])}}">
            <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
        </a> 
    </td> 
</tr>
@endforeach 
</table>

{{$proyecciones->render()}}
