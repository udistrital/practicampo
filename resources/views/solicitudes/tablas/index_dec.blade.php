@if($filter=='pend')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 30px">Cod.</th>
            <th style="width: 55px">Proy. Curricular</th>
            <th style="width: 55px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th> 
            <th style="width: 65px">Destino</th>
            <th style="width: 35px">Viat. Est.</th>
            <th style="width: 35px">Viat. Doc.</th>
            <th style="width: 35px">Mater./Otros</th>
            <th style="width: 35px">Transp. Local</th>
            <th style="width: 35px">Transporte</th>
            <th style="width: 45px">Total</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                <td>{{ $item->full_name }}</td>
                @if($item->tipo_ruta == 1)
                    <td>{{ $item->destino_rp }}</td>
                    <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
                    <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->costo_total_transporte_menor_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                    <td>{{ number_format($item->total_presupuesto_rp + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td> 
                    {{-- <td>{{ number_format($item->total_presupuesto_rp, 0, ',','.') }}</td>  --}}
                @endif
                @if($item->tipo_ruta == 2)
                    <td>{{ $item->destino_ra }}</td>
                    <td>{{ number_format($item->viaticos_estudiantes_ra, 0, ',','.') }}</td>
                    <td>{{ number_format($item->viaticos_docente_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->vlr_materiales_ra + $item->vlr_guias_baquianos_ra + $item->vlr_otros_boletas_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->costo_total_transporte_menor_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->valor_estimado_transporte_ra, 0, ',','.') }}</td>
                    <td>{{ number_format($item->total_presupuesto_ra + $item->valor_estimado_transporte_ra, 0, ',','.') }}</td> 
                    {{-- <td>{{ number_format($item->total_presupuesto_ra, 0, ',','.') }}</td>  --}}
                @endif
                <td style="text-align: center"> 
                    <a href="{{route('solicitud_edit',[Crypt::encrypt($item->id),Crypt::encrypt($item->tipo_ruta)])}}">
                    <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                    </a> 
                </td> 
            </tr>
        @endforeach 
    </table>
@endif

@if($filter=='aprobb')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 30px">Cod.</th>
            <th style="width: 55px">Proy. Curricular</th>
            <th style="width: 55px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th>
            <th style="width: 65px">Destino</th>
            <th style="width: 35px">Viat. Est.</th>
            <th style="width: 35px">Viat. Doc.</th>
            <th style="width: 35px">Mater./Otros</th>
            <th style="width: 35px">Transp. Local</th>
            <th style="width: 35px">Transporte</th>
            <th style="width: 45px">Total</th>
            <th style="width: 20px">Acciones</th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                <td>{{ $item->full_name }}</td>
                @if($item->tipo_ruta == 1)
                    <td>{{ $item->destino_rp }}</td>
                    <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
                    <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->costo_total_transporte_menor_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                    <td>{{ number_format($item->total_presupuesto_rp + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td> 
                    {{-- <td>{{ number_format($item->total_presupuesto_rp, 0, ',','.') }}</td>  --}}
                @endif
                @if($item->tipo_ruta == 2)
                    <td>{{ $item->destino_ra }}</td>
                    <td>{{ number_format($item->viaticos_estudiantes_ra, 0, ',','.') }}</td>
                    <td>{{ number_format($item->viaticos_docente_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->vlr_materiales_ra + $item->vlr_guias_baquianos_ra + $item->vlr_otros_boletas_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->costo_total_transporte_menor_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->valor_estimado_transporte_ra, 0, ',','.') }}</td>
                    <td>{{ number_format($item->total_presupuesto_ra + $item->valor_estimado_transporte_ra, 0, ',','.') }}</td> 
                    {{-- <td>{{ number_format($item->total_presupuesto_ra, 0, ',','.') }}</td>  --}}
                @endif
                <td style="text-align: center"> 
                    <a href="{{route('acciones.pdf',[Crypt::encrypt($item->id_solicitud)])}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Ver</button>
                    </a> 
                </td> 
            </tr>
        @endforeach 
    </table>
@endif

@if($filter=='aprob')
<table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
    <thead>
        <th style="width: 75px">Docente</th>
        <th style="width: 75px">N° Identificación</th>
        <th style="width: 25px"></th>

    </thead>
    @foreach ($docentes_aprob as $item)
    <tr>

        <td>{{ $item['full_name'] }}</td>
        <td>{{ $item['id_doc_resp'] }}</td>

        <td style="text-align: center">
            <a href="{{route('list_sol_aprob',Crypt::encrypt($item))}}">
                <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
            </a>
        </td>
    </tr>
    @endforeach
</table>
@endif

@if($filter=='all')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 30px">Cod.</th>
            <th style="width: 55px">Proy. Curricular</th>
            <th style="width: 55px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th>
            <th style="width: 65px">Destino</th>
            <th style="width: 35px">Viat. Est.</th>
            <th style="width: 35px">Viat. Doc.</th>
            <th style="width: 35px">Mater./Otros</th>
            <th style="width: 35px">Transp. Local</th>
            <th style="width: 35px">Transporte</th>
            <th style="width: 45px">Total</th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                <td>{{ $item->full_name }}</td>
                @if($item->tipo_ruta == 1)
                    <td>{{ $item->destino_rp }}</td>
                    <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
                    <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->costo_total_transporte_menor_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                    <td>{{ number_format($item->total_presupuesto_rp + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td> 
                    {{-- <td>{{ number_format($item->total_presupuesto_rp, 0, ',','.') }}</td>  --}}
                @endif
                @if($item->tipo_ruta == 2)
                    <td>{{ $item->destino_ra }}</td>
                    <td>{{ number_format($item->viaticos_estudiantes_ra, 0, ',','.') }}</td>
                    <td>{{ number_format($item->viaticos_docente_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->vlr_materiales_ra + $item->vlr_guias_baquianos_ra + $item->vlr_otros_boletas_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->costo_total_transporte_menor_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->valor_estimado_transporte_ra, 0, ',','.') }}</td>
                    <td>{{ number_format($item->total_presupuesto_ra + $item->valor_estimado_transporte_ra, 0, ',','.') }}</td>  
                    {{-- <td>{{ number_format($item->total_presupuesto_ra, 0, ',','.') }}</td>  --}}
                @endif
            </tr>
        @endforeach 
    </table>
@endif

@if($filter=='edit_sol')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 30px">Cod.</th>
            <th style="width: 55px">Proy. Curricular</th>
            <th style="width: 55px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th>
            <th style="width: 65px">Destino</th>
            <th style="width: 35px">Viat. Est.</th>
            <th style="width: 35px">Viat. Doc.</th>
            <th style="width: 35px">Mater./Otros</th>
            <th style="width: 35px">Transp. Local</th>
            <th style="width: 35px">Transporte</th>
            <th style="width: 45px">Total</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                <td>{{ $item->full_name }}</td>
                @if($item->tipo_ruta == 1)
                    <td>{{ $item->destino_rp }}</td>
                    <td>{{ number_format($item->viaticos_estudiantes_rp, 0, ',','.') }}</td>
                    <td>{{ number_format($item->viaticos_docente_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->vlr_materiales_rp + $item->vlr_guias_baquianos_rp + $item->vlr_otros_boletas_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->costo_total_transporte_menor_rp, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->valor_estimado_transporte_rp, 0, ',','.') }}</td>
                    <td>{{ number_format($item->total_presupuesto_rp + $item->valor_estimado_transporte_rp, 0, ',','.') }}</td> 
                    {{-- <td>{{ number_format($item->total_presupuesto_rp, 0, ',','.') }}</td>  --}}
                @endif
                @if($item->tipo_ruta == 2)
                    <td>{{ $item->destino_ra }}</td>
                    <td>{{ number_format($item->viaticos_estudiantes_ra, 0, ',','.') }}</td>
                    <td>{{ number_format($item->viaticos_docente_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->vlr_materiales_ra + $item->vlr_guias_baquianos_ra + $item->vlr_otros_boletas_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->costo_total_transporte_menor_ra, 0, ',','.') }}</td> 
                    <td>{{ number_format($item->valor_estimado_transporte_ra, 0, ',','.') }}</td>
                    <td>{{ number_format($item->total_presupuesto_ra + $item->valor_estimado_transporte_ra, 0, ',','.') }}</td>  
                    {{-- <td>{{ number_format($item->total_presupuesto_ra, 0, ',','.') }}</td>  --}}
                @endif
                <td style="text-align: center"> 
                    <a href="{{route('sol_hab_cambios',Crypt::encrypt($item->id))}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                    </a> 
                </td> 
            </tr>
        @endforeach 
    </table>
@endif

{{$proyecciones->render()}}
