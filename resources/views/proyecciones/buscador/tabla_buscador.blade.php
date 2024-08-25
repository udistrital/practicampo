@extends ('layouts.app')
@section ('contenido')  

  
  <div class="container-fluid" id="sel_proy_buscador">
      <div class="card-header">{{ __('Resultado Búsqueda Proyecciones Preliminares:'.$cant_resul.' Resultados Obtenidos') }}</div>
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
            <div class="form-group">
                
            </div>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{route('export_list_proyecc.excel')}}" method="GET" name="proy_buscador">
                    @csrf
                    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
                        <thead>
                            <th style="width: 25px">Sel. Todo <input type="checkbox" id="sel_proy" name="sel_proy" value="" onchange="sel_todo_nada_proy()"></th>
                            <th style="width: 35px">Cod.</th>
                            <th style="width: 90px">Proy. Curricular</th>
                            <th style="width: 95px">Esp. Académico</th> 
                            <th style="width: 95px">Destino</th>
                            <th style="width: 35px">Fecha Salida</th>
                            <th style="width: 35px">Fecha Regreso</th>
                            <th style="width: 25px">Coord.</th>
                            <th style="width: 25px">Decan.</th>
                        </thead> 
                        @foreach ($proyecciones as $item) 
                            <tr>
                            <td style="text-align:center;">
                                <input type="checkbox" id="proyeccion_list[]" name="proyeccion_list[]" value="{{ $item->id }}">
                            </td> 
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->programa_academico }}</td>
                            <td>{{ $item->espacio_academico }}</td>
                            <td>{{ $item->destino_rp }}</td>
                            <td>{{ $item->fecha_salida_aprox_rp }}</td>
                            <td>{{ $item->fecha_regreso_aprox_rp }}</td> 
                            <td>{{ $item->ab_coor }}</td> 
                            <td>{{ $item->ab_dec }}</td>
                            </tr>
                        @endforeach 
                    </table>

                    <div>
                        <label class="col-form-label text-md-right">
                            <i class="fas fa-question-circle" 
                            data-toggle="tooltip" data-placement="left" 
                            data-title="El número máximo de proyecciones releccionadas es de 300" style="font-size: 0.813rem"></i>
                             {{ __('Proyecciones Seleccionadas:') }}
                        </label>
                        <label id="cant_sel" name="cant_sel" class="col-form-label text-md-right">0
                        </label>
                    </div>
                    <a href="{{route('export_list_proyecc.excel')}}">
                        <button class="btn-success" style="background-color: #447161; border:0" name="export_proyeccion" id="export_proyeccion"    disabled><i class="fas fa-download" ></i>   XLS</button>
                    </a> 
                </form>
                <br>
            </div>
            {{-- <php $ddd =$_POST['data']; ?> --}}
            {{-- {{$ddd}} --}}
            {{$proyecciones->render()}}
            {{-- {{$proyecciones->appends(['sort' => "input[name='proyeccion_list[]']"])->links()}} --}}
        </div>

  
@endsection