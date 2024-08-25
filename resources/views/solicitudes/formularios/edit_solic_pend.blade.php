<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-lg-11 col-md-11">
                <div class="card">
                        <div class="card-header" name="">{{ __('Edición Solicitudes N°') }}
                        <?php foreach($list_solic_pend as $item)
                            echo $item.' | '
                        ?>
                        {{ __('') }}</div>
                    
                        <div class="card-body">
                            <form method="POST" action="{{ route('up_solic_asistD',[Crypt::encrypt($proyecciones)]) }}" id="up_solicitud_asistD">
                                @method('PUT')
                                @csrf

                                <br>
                                <h4>Información Solicitud</h4>
                                <hr class="divider">
                                <br>

                                <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
                                    <thead>
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

                                <br>
                                {{-- <h4></h4> --}}
                                <hr class="divider">
                                <br>

                                <!-- Resolución - CDP - SiCapital-->
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="row" >
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="si_capital">
                                                            <i class="fas fa-question-circle" 
                                                            data-toggle="tooltip" data-placement="left" 
                                                            data-title="Indique si cuenta con SiCapital" style="font-size: 0.813rem"></i> SiCapital</label>
                                                        <span class="hs-form-required">*</span>
                                                        <div class="row">

                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="si_capital" value="0">
                                                                <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-64 col-xs-12">
                                                                <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="si_capital" value="1" checked>
                                                                <label class="form-check-label" for="">Si</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="num_solicitud_necesidad" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique el número de solicitud de necesidad asociado a la 
                                                        salida de práctica académica. Ej. 7658-2021" style="font-size: 0.813rem"></i> {{ __('N° Sol. Necesidad') }}</label>
                                                    <!-- <span class="hs-form-required">*</span> -->
                                                    <input id="num_solicitud_necesidad" type="text" class="form-control @error('num_solicitud_necesidad') is-invalid @enderror" name="num_solicitud_necesidad" 
                                                    value="" pattern="[0-9\-]+" autocomplete="off" autofocus>

                                                    @error('num_solicitud_necesidad')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <label for="num_resolucion" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique el número de resolución asociado a la 
                                                        salida de práctica académica. Ej. 1234" style="font-size: 0.813rem"></i> {{ __('N° Resolución') }}</label>
                                                    <!-- <span class="hs-form-required">*</span> -->
                                                    <input id="num_resolucion" type="text" class="form-control @error('num_resolucion') is-invalid @enderror" name="num_resolucion" 
                                                    value="" autocomplete="off" autofocus pattern="[0-9]+"
                                                    onchange="onlyNmb(this)" onkeyup="onlyNmb(this)">

                                                    @error('num_resolucion')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <label for="fecha_resolucion" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Seleccione la fecha de la resolución asociada a la 
                                                        salida de práctica académica" style="font-size: 0.813rem"></i> {{ __('F. Resolución') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                        </div>
                                                    <input class="inputDate form-control datetimepicker" name="fecha_resolucion"  type="text" required
                                                    value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <label for="num_cdp_resolucion" class="col-form-label text-md-left">
                                                        <i class="fas fa-question-circle" 
                                                        data-toggle="tooltip" data-placement="left" 
                                                        data-title="Indique el número de CDP asociado a la 
                                                        salida de práctica académica. Ej. 8536" style="font-size: 0.813rem"></i> {{ __('N° CDP') }}</label>
                                                    <span class="hs-form-required">*</span>
                                                    <input id="num_cdp" type="text" class="form-control @error('num_cdp') is-invalid @enderror" name="num_cdp" 
                                                    value="" required autocomplete="off" autofocus pattern="[0-9]+"
                                                    onchange="onlyNmb(this)" onkeyup="onlyNmb(this)">

                                                    @error('num_cdp')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                
                                            </div>
                                        </div>   
                                        
                                    </div>

                                <!-- Resolución - CDP - SiCapital-->    

                                <!-- 25 -->
                                    <div class="form-group row mb-0">
                                        <div class="col-md-5 offset-md-5">
                                            <br>
                                            <button type="submit" class="btn btn-success">
                                                {{ __('Guardar') }}
                                            </button>
                                        </div>
                                    </div>
                                <!-- 25 -->
                            </form>
                        </div>
                    
                </div>
                <br>
            </div>
        </div>
        
    @endsection  
