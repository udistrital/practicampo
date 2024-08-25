<table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
    <thead>
        <th style="width: 30px">Tipo Ruta</th>
        <th style="width: 90px">Proy. Curricular</th>
        {{-- <th style="width: 30px">Cod. Esp. Académico</th> --}}
        <th style="width: 95px">Esp. Académico</th> 
        <th style="width: 105px">Destino Ruta</th>
        <th style="width: 35px">Fecha Salida</th>
        <th style="width: 35px">Fecha Regreso</th>
        <th style="width: 37px"></th>
    </thead> 
    @foreach ($rutas as $item) 
    <tr>
    <td><?php if($item->tipo_ruta==1) {echo 'Principal';}elseif($item->tipo_ruta==2){echo 'Contingencia';}?></td>
       <td>{{ $item->programa_academico }}</td>
       {{-- <td>{{ $proyeccion_preliminar->codigo_espacio_academico }}</td> --}}
       <td>{{ $proyeccion_preliminar->codigo_espacio_academico }}<?php echo "\t "?>{{ $item->espacio_academico }}</td>
       <td>{{ $item->destino }}</td>
       <td>{{ $item->fecha_salida }}</td>
       <td>{{ $item->fecha_regreso }}</td> 
       <td> 
           
           <a href="{{route('solicitud_edit',[Crypt::encrypt($proyeccion_preliminar->id),Crypt::encrypt($item->tipo_ruta)])}}">
           <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
           </a> 
       </td> 
    </tr>
    @endforeach 
</table>