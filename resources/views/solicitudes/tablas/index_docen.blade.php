@if($filter == 'pre-proy')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px"></th>
        </thead> 
        @foreach ($programaciones as $item) 
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
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px">Resolución</th>
            <th style="width: 50px">Declaración Responsabilidad</th>
        </thead> 
        @foreach ($programaciones as $item) 
            <tr>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                <td>{{ $item->destino_rp }}</td>
                <td>{{ $item->fecha_salida_aprox_rp }}</td>
                <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
                @if($item->tiene_resolucion == 1)
                <td style="text-align: center"> 
                    <a href="{{route('resolucion.pdf',$item->id_solicitud)}}">
                        <button class="btn-success" >Descargar</button>
                    </a>
                </td> 
                @elseif ($item->tiene_resolucion != 1)
                <td style="text-align: center">Sin Resolución</td> 
                @endif
                <td style="text-align: center"> 
                    <a href="{{route('declaracion_resp_docente.pdf',$item->id_solicitud)}}">
                        <button class="btn-success" >Descargar</button>
                    </a>
                </td>             
            </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'transp')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 20px">Ver</th>
        </thead> 
        @foreach ($programaciones as $item) 
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
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 20px">Ver</th>
        </thead> 
        @foreach ($programaciones as $item) 
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
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
        @foreach ($programaciones as $item) 
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
@endif

@if($filter == 'ejec-sol')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 20px">Ver</th>
        </thead> 
        @foreach ($programaciones as $item) 
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
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
        @foreach ($programaciones as $item) 
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
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
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
        @foreach ($programaciones as $item) 
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
                <a href="{{route('ver_solicitud',[Crypt::encrypt($item->id)])}}">
                    <button class="btn-success" style="background-color: #447161; border:0">Ver</button>
                </a> 
            </td>
        
        </tr>
        @endforeach 
    </table>
@endif

@if($filter == 'not_send')
    <button class="btn-success" style="background-color: #447161; border:0" name="confirmar_proyecc" id="confirmar_proyecc" onclick="confirm_proy()">Confirmar</button>
@endif

@if($filter == 'traspasar')
    <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Destino</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Dec.</th>
            <th style="width: 50px"></th>
        </thead> 
        @foreach ($programaciones as $item) 
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
                <button class="btn btn-success btnTraspasarSolicitud" 
                        style="background-color: #447161; border:0" 
                        data-toggle="modal"
                        data-target="#modalEditar"
                        data-id="{{ $item->id }}">
                    Editar
                </button>
            </td>
        </tr>
        @endforeach 

    </table>
@endif
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <br><br><br><br><br><br><br>
    <div class="modal-dialog mt-5" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Traspasar Programación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTraspasarSolicitud" method="POST" onsubmit="return confirmarGuardar(event)">
                @csrf
                @method('PUT')        
                <div class="form-group">
                    <label>Docentes disponibles</label>
                    <select name="id_docente" id="selectDocentes" class="form-control">
                        <option value="">Cargando...</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnGuardarCambios" class="btn btn-success">Guardar cambios</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
            </div>            
        </div>
    </div>
</div>

{{$programaciones->render()}}



