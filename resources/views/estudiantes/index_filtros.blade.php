@if ($filter == 'sol_estudiante')
<div>
    <div class="row justify-content-center">
        <div class="col-md-12 card-header">{{ __('Solicitudes de prácticas para subir documentos')}}</div>
        <div class="col-md-12 card-body" style="background-color: #f8f9fc">
            <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
                <thead>
                    <th style="width: 30px">Cod.</th>
                    <th style="width: 70px">Proy. Curricular</th>
                    <th style="width: 70px">Esp. Académico</th> 
                    <th style="width: 70px">Docente</th>
                    <th style="width: 70px">Destino</th>
                    <th style="width: 35px">Fecha Salida</th>
                    <th style="width: 20px">Ver</th>
                </thead>
                @foreach($solic_asociadas as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->programa_academico}}</td>
                    <td>{{$item->espacio_academico}}</td>
                    <td>{{$item->full_name}}</td>
                    <td><?php if($item->tipo_ruta == 1){echo $item->destino_rp;} elseif($item->tipo_ruta == 2){echo $item->destino_ra;}?></td>
                    <td>{{$item->fecha_salida}}</td>
                    <td>
                        <a href="{{route('doc_est_edit',[Crypt::encrypt($item->id),Crypt::encrypt($estudiante->email)])}}">
                            <button class="btn-success" style="background-color: #447161; border:0">Ir</button>
                        </a> 
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endif

@if ($filter == 'sol_evaluacion')
<div>
</div>
@endif