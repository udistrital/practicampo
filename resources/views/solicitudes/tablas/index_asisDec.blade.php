
@if($filter == 'pend-cierre')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 50px">Fecha Salida</th>
            <th style="width: 50px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px"></th>
            
        </thead> 
        @foreach ($programaciones as $item) 
        <tr>
            
            <td>{{ $item->id_solicitud }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            @if($item->id_estado_doc == 1)
                <td>{{ $item->full_name }}</td>
            @endif
            @if($item->id_estado_doc == 2)
                <td>Usuario Inactivo</td>
            @endif

	    @if($item->tipo_ruta == 1)
                <td>{{ $item->destino_rp }}</td>
            @elseif($item->tipo_ruta == 2)
                <td>{{ $item->destino_ra }}</td>
            @endif
            
            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td>
            <td>{{ $item->ap_coor }}</td>

            @if($filter == 'pend-cierre')
                <td style="text-align: center"> 
                    <a href="{{route('solic_legal',[Crypt::encrypt($item->id)])}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                    </a> 
                </td> 
            @endif
        </tr>
        @endforeach 
    </table>
@endif

@if($filter == 'pend-teso')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            {{-- @if($filter =='enc_trans')
            <th style="width: 25px">Sel. Todo <input type="checkbox" id="sel_soli" name="sel_soli" value="" onchange="sel_todo_nada_soli()"></th>
            @endif --}}
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 50px">Fecha Salida</th>
            <th style="width: 50px">Fecha Regreso</th>
            @if($filter != 'pend')
                <th style="width: 25px">Coord.</th>
                @if($filter == 'no-aprob-cons' || $filter == 'all')
                <th style="width: 25px">Decan.</th>
                @endif
            @endif
            @if($filter == 'sin_pres' || $filter == 'no-aprob-cons' || $filter == 'pend' || $filter == 'pend-teso' || $filter == 'pend-cierre')
            <th style="width: 35px"></th>
            @endif
            @if($filter == 'aprob')
            <th style="width: 25px">Acciones</th>
            @endif
            
        </thead> 
        @foreach ($programaciones as $item) 
        <tr>
            
        <td>{{ $item->id_solicitud }}</td>
        <td>{{ $item->programa_academico }}</td>
        <td>{{ $item->espacio_academico }}</td>
        @if($item->id_estado_doc == 1)
            <td>{{ $item->full_name }}</td>
        @endif
        @if($item->id_estado_doc == 2)
            <td>Usuario Inactivo</td>
        @endif

	@if($item->tipo_ruta == 1)
                <td>{{ $item->destino_rp }}</td>
        @elseif($item->tipo_ruta == 2)
                <td>{{ $item->destino_ra }}</td>
        @endif        

        <td>{{ $item->fecha_salida_aprox_rp }}</td>
        <td>{{ $item->fecha_regreso_aprox_rp }}</td>
        @if($filter != 'pend') 
            <td>{{ $item->ap_coor }}</td> 
                @if($filter == 'no-aprob-cons' || $filter == 'all')
                <td>{{ $item->ap_dec }}</td>
                @endif

        @endif
        
        @if($filter == 'sin_pres' || $filter == 'no-aprob-cons' || $filter == 'pend' || $filter == 'pend-teso')
                <td style="text-align: center"> 
                <a href="{{route('solicitud_edit',[Crypt::encrypt($item->id),Crypt::encrypt($item->tipo_ruta)])}}">
                <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                </a> 
                </td> 
            @endif
            @if($filter == 'pend-cierre')
                <td style="text-align: center"> 
                <a href="{{route('solic_legal',[Crypt::encrypt($item->id)])}}">
                <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                </a> 
                </td> 
            @endif
            @if($filter == 'aprob')
                <td style="text-align: center"> 
                    <a href="{{route('acciones.pdf',[Crypt::encrypt($item->id)])}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Ver</button>
                    </a> 
                </td> 
            @endif
        </tr>
        @endforeach 
    </table>
@endif

@if($filter == 'pend')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 50px">Fecha Salida</th>
            <th style="width: 50px">Fecha Regreso</th>
            <th style="width: 25px"></th>
            
        </thead> 
        @foreach ($programaciones as $item) 
        <tr>
            
            <td>{{ $item->id_solicitud }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            @if($item->id_estado_doc == 1)
                <td>{{ $item->full_name }}</td>
            @endif
            @if($item->id_estado_doc == 2)
                <td>Usuario Inactivo</td>
            @endif
            
            @if($item->tipo_ruta == 1)
                <td>{{ $item->destino_rp }}</td>
            @elseif($item->tipo_ruta == 2)
                <td>{{ $item->destino_ra }}</td>
            @endif

            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td>
            
            <td style="text-align: center"> 
                <a href="{{route('solicitud_edit',[Crypt::encrypt($item->id),Crypt::encrypt($item->tipo_ruta)])}}">
                    <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                </a> 
            </td> 
        </tr>
        @endforeach 
    </table>
@endif

@if($filter == 'aprob')
    @csrf

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

@if($filter == 'all')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 50px">Fecha Salida</th>
            <th style="width: 50px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px"></th>
            
        </thead> 
        @foreach ($programaciones as $item) 
        <tr>
            <td>{{ $item->id_solicitud }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            @if($item->id_estado_doc == 1)
                <td>{{ $item->full_name }}</td>
            @endif
            @if($item->id_estado_doc == 2)
                <td>Usuario Inactivo</td>
            @endif
            
	    @if($item->tipo_ruta == 1)
                <td>{{ $item->destino_rp }}</td>
            @elseif($item->tipo_ruta == 2)
                <td>{{ $item->destino_ra }}</td>
            @endif

            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td>
            <td>{{ $item->ap_coor }}</td> 
            <td>{{ $item->ap_dec }}</td>
            <td style="text-align: center"> 
                <a href="{{route('ver_solicitud',[Crypt::encrypt($item->id)])}}">
                    <button class="btn-success" style="background-color: #447161; border:0">Ver</button>
                </a> 
            </td>
        </tr>
        @endforeach 
    </table>
@endif

@if($filter == 'enc_trans')
    <form action="{{route('encues_trans')}}" method="GET" name="encuesta_trans">
        @csrf
        <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
            <thead>
               
                <th style="width: 25px">Sel. Todo <input type="checkbox" id="sel_encuesta" name="sel_encuesta" value="" onchange="total_sel_encuesta()"></th>
                <th style="width: 35px">Cod.</th>
                <th style="width: 80px">Proy. Curricular</th>
                <th style="width: 85px">Esp. Académico</th> 
                <th style="width: 75px">Docente</th> 
                <th style="width: 75px">Destino</th>
                <th style="width: 50px">Fecha Salida</th>
                <th style="width: 50px">Fecha Regreso</th>
                
            </thead> 
            @foreach ($programaciones as $item) 
            <tr>
                <td><input type="checkbox" id="encuesta_transporte[]" name="encuesta_transporte[]" value="{{ $item->id }}"></td>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                @if($item->id_estado_doc == 1)
                    <td>{{ $item->full_name }}</td>
                @endif
                @if($item->id_estado_doc == 2)
                    <td>Usuario Inactivo</td>
                @endif
                
		@if($item->tipo_ruta == 1)
                    <td>{{ $item->destino_rp }}</td>
                @elseif($item->tipo_ruta == 2)
                    <td>{{ $item->destino_ra }}</td>
                @endif

                <td>{{ $item->fecha_salida_aprox_rp }}</td>
                <td>{{ $item->fecha_regreso_aprox_rp }}</td>
               
            </tr>
            @endforeach 
        </table>

        <button class="btn-success" style="background-color: #447161; border:0" name="export_encusta" id="export_encusta" disabled><i class="fas fa-download"></i>   XLS</button>
    </form>
@endif

@if($filter == 'sol_realizadas')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 50px">Fecha Salida</th>
            <th style="width: 50px">Fecha Regreso</th>
            <th style="width: 50px">Estado</th>
            <th style="width: 25px"></th>
            
        </thead> 
        @foreach ($programaciones as $item) 
        <tr id="row-{{ $item->id_solicitud }}">
            
            <td>{{ $item->id_solicitud }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            @if($item->id_estado_doc == 1)
                <td>{{ $item->full_name }}</td>
            @endif
            @if($item->id_estado_doc == 2)
                <td>Usuario Inactivo</td>
            @endif
            
	    @if($item->tipo_ruta == 1)
                <td>{{ $item->destino_rp }}</td>
            @elseif($item->tipo_ruta == 2)
                <td>{{ $item->destino_ra }}</td>
            @endif

            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td>
            <td class="estado-{{ $item->id_solicitud }}">
                {{ $item->estado_practica == 1 ? 'Realizada' : ($item->estado_practica == 2 ? 'No Realizada' : 'No Validada') }}
            </td>
            
            
            <td style="text-align: center"> 
                <button class="btn btn-success btnEditarRealizada" style="background-color: #447161; border:0"
                    data-url="{{ route('practica_realizada_edit', [Crypt::encrypt($item->id_solicitud)]) }}">
                    Editar
                </button>
            </td> 
        </tr>
        @endforeach 
    </table>
@endif
<div class="modal fade" id="modalPracticaRealizada" tabindex="-1">
    <br><br><br><br><br><br><br>
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Información Solicitud</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent">
                <div class="text-center p-4">
                    <span class="spinner-border"></span>
                </div>
            </div>

        </div>
    </div>
</div>
{{$programaciones->render()}}
