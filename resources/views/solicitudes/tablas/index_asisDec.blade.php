
@if($filter == 'pend-cierre')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
        @foreach ($proyecciones as $item) 
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
            <td>{{ $item->destino_rp }}</td>
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
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
        @foreach ($proyecciones as $item) 
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
        <td>{{ $item->destino_rp }}</td>
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
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
        @foreach ($proyecciones as $item) 
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
            <td>{{ $item->destino_rp }}</td>
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

    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
            
        </thead> 
        @foreach ($proyecciones as $item) 
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
            <td>{{ $item->destino_rp }}</td>
            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td>
            <td>{{ $item->ap_coor }}</td> 
            <td>{{ $item->ap_dec }}</td>
        </tr>
        @endforeach 
    </table>
@endif

@if($filter == 'enc_trans')
    <form action="{{route('encues_trans')}}" method="GET" name="encuesta_trans">
        @csrf
        <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
            @foreach ($proyecciones as $item) 
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
                <td>{{ $item->destino_rp }}</td>
                <td>{{ $item->fecha_salida_aprox_rp }}</td>
                <td>{{ $item->fecha_regreso_aprox_rp }}</td>
               
            </tr>
            @endforeach 
        </table>

        <button class="btn-success" style="background-color: #447161; border:0" name="export_encusta" id="export_encusta" disabled><i class="fas fa-download"></i>   XLS</button>
    </form>
@endif

{{$proyecciones->render()}}
