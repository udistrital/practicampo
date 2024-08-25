@if($filter == 'pre-proy')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
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
                @if($item->listado_estudiantes == 0 && $item->confirm_docente == 0)
                    <td style="text-align: center"> 
                        <a href="{{route('solicitud_rutas',[Crypt::encrypt($item->id)])}}">
                            <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                        </a> 
                    </td> 
                @endif
                @if($item->listado_estudiantes == 0 && $item->confirm_docente == 1)
                    <td style="text-align: center"> 
                        <a href="{{route('solic_lista_estud',[Crypt::encrypt($item->id)])}}">
                            <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                        </a> 
                    </td> 
                @endif
                
            </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'proy-comp')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Dec.</th>
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
            
            </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'transp')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 20px">Ver</th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                <td>{{ $item->destino_rp }}</td>
                <td>{{ $item->fecha_salida_aprox_rp }}</td>
                <td>{{ $item->fecha_regreso_aprox_rp }}</td>
                <td style="text-align: center"> 
                    <a href="{{route('show_transp',[Crypt::encrypt($item->id),Crypt::encrypt($item->tipo_ruta)])}}">
                        <button class="btn-success" >Ver</button>
                    </a>
                </td> 
            
            </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'estud')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 20px">Ver</th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                <td>{{ $item->destino_rp }}</td>
                <td>{{ $item->fecha_salida_aprox_rp }}</td>
                <td>{{ $item->fecha_regreso_aprox_rp }}</td>
                <td style="text-align: center"> 
                    <a href="{{route('estud_doc',[Crypt::encrypt($item->id_solicitud)])}}">
                        <button class="btn-success" >Ver</button>
                    </a>
                </td> 
            
            </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'sol_recha')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Dec.</th>
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
                    <a href="{{route('solicitud_edit',[Crypt::encrypt($item->id),Crypt::encrypt($item->tipo_ruta)])}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                    </a> 
                </td>
            
            </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'ejec-sol')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 20px">Ver</th>
        </thead> 
        @foreach ($proyecciones as $item) 
            <tr>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                <td>{{ $item->destino_rp }}</td>
                <td>{{ $item->fecha_salida_aprox_rp }}</td>
                <td>{{ $item->fecha_regreso_aprox_rp }}</td>
                <td style="text-align: center"> 
                    <a href="{{route('info_trans',[Crypt::encrypt($item->id)])}}">
                        <button class="btn-success" >Ver</button>
                    </a>
                </td> 
            
            </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'aprob')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Dec.</th>
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
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Dec.</th>
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
        
        </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'not_send')
    <button class="btn-success" style="background-color: #447161; border:0" name="confirmar_proyecc" id="confirmar_proyecc" onclick="confirm_proy()">Confirmar</button>
@endif

{{$proyecciones->render()}}



