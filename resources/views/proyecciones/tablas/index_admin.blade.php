@if($filter == 'all')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 90px">Proy. Curricular</th>
            <th style="width: 95px">Esp. Académico</th> 
            <th style="width: 105px">Destino Ruta Principal</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 35px">Fecha Creación</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            <td>{{ $item->destino_rp }}</td>
            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
            <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td> 
            <td>{{ $item->ab_coor }}</td> 
            <td>{{ $item->ab_dec }}</td>
            <td style="text-align: center"> 
                <a href="{{route('proyeccion_edit',Crypt::encrypt($item->id))}}">
                <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                </a> 
            </td> 
            </tr>
        @endforeach 
    </table>
    {{$proyecciones->render()}}
@endif

@if($filter == 'inact')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 90px">Proy. Curricular</th>
            <th style="width: 95px">Esp. Académico</th> 
            <th style="width: 105px">Destino Ruta Principal</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 35px">Fecha Creación</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            <td>{{ $item->destino_rp }}</td>
            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
            <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
            <td>{{ $item->ab_coor }}</td> 
            <td>{{ $item->ab_dec }}</td>
            <td style="text-align: center"> 
                <a href="{{route('proyeccion_edit',Crypt::encrypt($item->id))}}">
                <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                </a> 
            </td> 
            </tr>
        @endforeach 
    </table>
    {{$proyecciones->render()}}
@endif

@if($filter == 'not_send_docente')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 90px">Proy. Curricular</th>
            <th style="width: 95px">Esp. Académico</th> 
            <th style="width: 105px">Destino Ruta Principal</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 35px">Fecha Creación</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            <td>{{ $item->destino_rp }}</td>
            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
            <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
            <td>{{ $item->ab_coor }}</td> 
            <td>{{ $item->ab_dec }}</td>
            <td style="text-align: center"> 
                <a href="{{route('proyeccion_edit',Crypt::encrypt($item->id))}}">
                <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                </a> 
            </td> 
            </tr>
        @endforeach 
    </table>
    {{$proyecciones->render()}}
@endif
