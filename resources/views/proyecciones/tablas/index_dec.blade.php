@if($filter=='aprob-cons')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 70px">Proy. Curricular</th>
            <th style="width: 70px">Esp. Académico</th> 
            <th style="width: 70px">Docente</th> 
            <th style="width: 70px">Destino Ruta Principal</th>
            <th style="width: 40px">Viat. Est.</th>
            <th style="width: 40px">Viat. Doc.</th>
            <th style="width: 35px">Mater./Otros</th>
            <th style="width: 35px">Transp. Local</th>
            <th style="width: 40px">Transporte</th>
            <th style="width: 45px">Total</th>
            <th style="width: 25px">Consj.</th>
            <th style="width: 35px">Fecha Creación.</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                @if($item->id_estado_doc == 2)
                    <td>Usuario Inactivo</td>
                @endif
                @if($item->id_estado_doc == 1)
                    <td>{{ $item->full_name }}</td>
                @endif
                <td>{{ $item->destino_rp }}</td>
                <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
                <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
                <td>{{ number_format($item->costo_total_transporte_menor_rp , 0, ',','.') }}</td> 
                <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->total_presupuesto_rp + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td> 
                <td>{{ $item->es_consj }}</td>
                <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
                {{-- @if($item->id_estado_doc == 2 || $item->es_consj == 3) --}}
                    <td style="text-align: center"> 
                        <a href="{{route('proyeccion_edit',Crypt::encrypt($item->id))}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                        </a> 
                    </td> 
                {{-- @elseif($item->id_estado_doc == 1)
                    <td style="text-align: center">No Editable</td>
                @endif --}}
            </tr>
        @endforeach 
    </table>
    {{$proyecciones->render()}}
@endif

@if($filter=='pend')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 70px">Proy. Curricular</th>
            <th style="width: 70px">Esp. Académico</th> 
            <th style="width: 70px">Docente</th> 
            <th style="width: 70px">Destino Ruta Principal</th>
            <th style="width: 40px">Viat. Est.</th>
            <th style="width: 40px">Viat. Doc.</th>
            <th style="width: 35px">Mater./Otros</th>
            <th style="width: 35px">Transp. Local</th>
            <th style="width: 40px">Transporte</th>
            <th style="width: 45px">Total</th>
            <th style="width: 25px">Consj.</th>
            <th style="width: 35px">Fecha Creación</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                @if($item->id_estado_doc == 2)
                    <td>Usuario Inactivo</td>
                @endif
                @if($item->id_estado_doc == 1)
                    <td>{{ $item->full_name }}</td>
                @endif
                <td>{{ $item->destino_rp }}</td>
                <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
                <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
                <td>{{ number_format($item->costo_total_transporte_menor_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->total_presupuesto_rp  + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                <td>{{ $item->es_consj }}</td>
                <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
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

@if($filter=='elect')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th> 
            <th style="width: 75px">Destino Ruta Principal</th>
            <th style="width: 40px">Viat. Est.</th>
            <th style="width: 40px">Viat. Doc.</th>
            <th style="width: 40px">Mater./Otros</th>
            <th style="width: 40px">Transp. Local</th>
            <th style="width: 40px">Transporte</th>
            <th style="width: 45px">Total</th>
            <th style="width: 25px">Consj.</th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            @if($item->id_estado_doc == 2)
                <td>Usuario Inactivo</td>
            @endif
            @if($item->id_estado_doc == 1)
                <td>{{ $item->full_name }}</td>
            @endif
            <td>{{ $item->destino_rp }}</td>
            <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
            <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
            <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
            <td>{{ number_format($item->costo_total_transporte_menor_rp, 0, ',','.') }}</td>
            <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
            <td>{{ number_format($item->total_presupuesto_rp + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td> 
            <td>{{ $item->es_consj }}</td>
            </tr>
        @endforeach 
    </table>

    {{$proyecciones->render()}}
@endif

@if($filter=='aprob')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 30px">Cod.</th>
            <th style="width: 70px">Proy. Curricular</th>
            <th style="width: 70px">Esp. Académico</th> 
            <th style="width: 70px">Docente</th> 
            <th style="width: 70px">Destino Ruta Principal</th>
            <th style="width: 40px">Viat. Est.</th>
            <th style="width: 40px">Viat. Doc.</th>
            <th style="width: 40px">Mater./Otros</th>
            <th style="width: 40px">Transp. Local</th>
            <th style="width: 40px">Transporte</th>
            <th style="width: 45px">Total</th>
            <th style="width: 25px">Consj.</th>
            <th style="width: 35px">Fecha Creación</th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                @if($item->id_estado_doc == 2)
                    <td>Usuario Inactivo</td>
                @endif
                @if($item->id_estado_doc == 1)
                    <td>{{ $item->full_name }}</td>
                @endif
                <td>{{ $item->destino_rp }}</td>
                <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
                <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
                <td>{{ number_format($item->costo_total_transporte_menor_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->total_presupuesto_rp + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td> 
                <td>{{ $item->es_consj }}</td>
                <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
            </tr>
        @endforeach 
    </table>

    {{$proyecciones->render()}}
@endif

@if($filter=='all')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 30px">Cod.</th>
            <th style="width: 70px">Proy. Curricular</th>
            <th style="width: 70px">Esp. Académico</th> 
            <th style="width: 70px">Docente</th> 
            <th style="width: 70px">Destino Ruta Principal</th>
            <th style="width: 40px">Viat. Est.</th>
            <th style="width: 40px">Viat. Doc.</th>
            <th style="width: 38px">Mater./Otros</th>
            <th style="width: 38px">Transp. Local</th>
            <th style="width: 40px">Transporte</th>
            <th style="width: 45px">Total</th>
            <th style="width: 25px">Consj.</th>
            <th style="width: 40px">Fecha Creación</th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                @if($item->id_estado_doc == 2)
                    <td>Usuario Inactivo</td>
                @endif
                @if($item->id_estado_doc == 1)
                    <td>{{ $item->full_name }}</td>
                @endif
                <td>{{ $item->destino_rp }}</td>
                <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
                <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
                <td>{{ number_format($item->costo_total_transporte_menor_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                <td>{{ number_format($item->total_presupuesto_rp + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td> 
                <td>{{ $item->es_consj }}</td>
                <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
            </tr>
        @endforeach 
    </table>

    {{$proyecciones->render()}}
@endif

@if($filter=='no-elect')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0" style="width: 60%">
        
        <thead style="text-align: center" style="margin-right: 20%;margin-left: 20%; width: 60%;">
            {{-- <th style="width: 425pxpx"> --}}
            ESPACIOS ACADÉMICOS NO ELECTIVOS SIN PROYECCIONES PRELIMINARES REGISTRADAS
            {{-- </th> --}}
        </thead> 
        <thead>
            <th style="width: 35px">ID.</th>
            <th style="width: 90px">Proy. Curricular</th>
            <th style="width: 95px">Esp. Académico</th> 
            @if($filter == 'pend')
            <th style="width: 37px"></th>
            @endif
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            
            </tr>
        @endforeach 
    </table>
@endif
