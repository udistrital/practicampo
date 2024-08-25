
@if($filter == 'proy_legal')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 70px">Proy. Curricular</th>
            <th style="width: 70px">Esp. Académico</th> 
            <th style="width: 70px">Destino Ruta Principal</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 35px">Fecha Creación</th>
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
            <td style="text-align: center"> 
                <a href="{{route('proy_legalizadas',Crypt::encrypt($item->id))}}">
                    <button class="btn-success" style="background-color: #447161; border:0">Ver</button>
                </a> 
            </td> 
        </tr>
    @endforeach 

    </table>
@endif

@if($filter == 'proy_recha')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 70px">Proy. Curricular</th>
            <th style="width: 70px">Esp. Académico</th> 
            <th style="width: 70px">Destino Ruta Principal</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 35px">Fecha Creación</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px">Consj.</th>
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
                <td>{{ $item->es_consj }}</td> 
                <td style="text-align: center"> 
                    <a href="{{route('proyeccion_edit',Crypt::encrypt($item->id))}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                    </a>  
                </td> 
            </tr>
        @endforeach 

    </table>
@endif

@if($filter == 'not_send')
    <form  name="proy_not_send">
        @csrf
        <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
            <thead>
                <th style="width: 30px">Sel. Todo <input type="checkbox" id="sel_proy_not_send" name="sel_proy_not_send" value="" onchange="total_sel_not_send()"></th>
                <th style="width: 35px">Cod.</th>
                <th style="width: 70px">Proy. Curricular</th>
                <th style="width: 70px">Esp. Académico</th> 
                <th style="width: 70px">Destino Ruta Principal</th>
                <th style="width: 35px">Fecha Salida</th>
                <th style="width: 35px">Fecha Regreso</th>
                <th style="width: 35px">Fecha Creación</th>
                <th style="width: 25px"></th>
            </thead> 
            @foreach ($proyecciones as $item)
                <tr>
                    <td><input type="checkbox" id="{{ $item->id }}" name="confirm_list[]" value="{{ $item->id }}"  <?php if($filter != 'not_send') echo 'disabled'?>></td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->programa_academico }}</td>
                    <td>{{ $item->espacio_academico }}</td>
                    <td>{{ $item->destino_rp }}</td>
                    <td>{{ $item->fecha_salida_aprox_rp }}</td>
                    <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
                    <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
                    <td style="text-align: center"> 
                        <a href="{{route('proyeccion_edit',Crypt::encrypt($item->id))}}" class="btn btn-success" style="background-color: #447161;border: 0rem; border-radius:0px !important;
                        height: 70%;padding: 0.063rem 0.25rem 0.063rem 0.25rem; font-size:inherit; " >Editar
                        </a> 
                        
                    </td>
                </tr>
            @endforeach 

        </table>
    </form>
@endif

@if($filter == 'send')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 70px">Proy. Curricular</th>
            <th style="width: 70px">Esp. Académico</th> 
            <th style="width: 70px">Destino Ruta Principal</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 35px">Fecha Creación</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px">Consj.</th>
        </thead> 
        <tr>
        @foreach ($proyecciones as $item) 
        <td>{{ $item->id }}</td>
        <td>{{ $item->programa_academico }}</td>
        <td>{{ $item->espacio_academico }}</td>
        <td>{{ $item->destino_rp }}</td>
        <td>{{ $item->fecha_salida_aprox_rp }}</td>
        <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
        <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
        <td>{{ $item->ab_coor }}</td> 
        <td>{{ $item->ab_dec }}</td>
        <td>{{ $item->es_consj }}</td> 
    </tr>
    @endforeach 

    </table>
@endif

@if($filter == 'all')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 70px">Proy. Curricular</th>
            <th style="width: 70px">Esp. Académico</th> 
            <th style="width: 70px">Destino Ruta Principal</th>
            <th style="width: 35px">Fecha Salida</th>
            <th style="width: 35px">Fecha Regreso</th>
            <th style="width: 35px">Fecha Creación</th>
            <th style="width: 25px">Coord.</th>
            <th style="width: 25px">Decan.</th>
            <th style="width: 25px">Consj.</th>
        </thead> 
        <tr>
        @foreach ($proyecciones as $item) 
            <td>{{ $item->id }}</td>
            <td>{{ $item->programa_academico }}</td>
            <td>{{ $item->espacio_academico }}</td>
            <td>{{ $item->destino_rp }}</td>
            <td>{{ $item->fecha_salida_aprox_rp }}</td>
            <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
            <td>{{ date_format(new \DateTime($item->f_creacion),'Y-m-d')}}</td>
            <td>{{ $item->ab_coor }}</td> 
            <td>{{ $item->ab_dec }}</td>
            <td>{{ $item->es_consj }}</td> 
        </tr>
    @endforeach 

    </table>
@endif

@if($filter == 'not_send')
    <button class="btn-success" style="background-color: #447161; border:0" name="confirmar_proyecc" id="confirmar_proyecc" onclick="confirm_proy()">Confirmar</button>
    <br>
    <br>
    <br>
@endif

{{$proyecciones->render()}}




