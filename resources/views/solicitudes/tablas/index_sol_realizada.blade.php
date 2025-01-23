@if($filter == 'sol_realizada')
@foreach($proyecciones as $item)
<br>
<hr class="divider">
<h4>Información de la práctica</h4>
<hr class="divider">
<form action="{{route('practica_realizada_update',[Crypt::encrypt($item->id)])}}" method="post">
@csrf
@method('PUT')
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 35px">Cod.</th>
            <th style="width: 80px">Proy. Curricular</th>
            <th style="width: 85px">Esp. Académico</th> 
            <th style="width: 75px">Docente</th> 
            <th style="width: 75px">Destino</th>    
            <th style="width: 50px">Fecha Salida</th>
            <th style="width: 50px">Fecha Regreso</th>
            <th style="width: 50px">Estado</th>
        </thead>     
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
            @if($item->estado_practica == 3)
            <td>No Validada</td>
            @else
            <td>{{ $item->estado_practica == 2 ? 'No Realizada' : 'Realizada' }}</td>
            @endif

        </tr>
    </table> 
    <!-- estado práctica -->
    <div class="form-group row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <h4>Guardar estado de la práctica</h4>
                <hr class="divider">
                <div class="row">
                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-8">
                        <div class="form-check form-check-inline">
                        <input id="practica_realizada" class="form-check-input" type="radio" name="practica_realizada" value="1"
                        <?php if($item->estado_practica == 1) echo 'checked'?>>
                        <label class="form-check-label" for="">Realizada</label>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
                        <div class="form-check form-check-inline">
                        <input id="practica_realizada" class="form-check-input" type="radio" name="practica_realizada" value="2"
                        <?php if($item->estado_practica == 2) echo 'checked'?>>
                        <label class="form-check-label" for="">No realizada</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn-success" style="background-color: #447161; border:0">Guardar</button>
    <!-- estado práctica -->
</form>
@endforeach
@endif