<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Editar Presupuesto de los programas académicos') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('presupuesto_update') }}" onsubmit="return confirmarGuardarPresupuesto(event)">
                            @method('PUT')
                            @csrf

                        <br>

                        @php
                            $tipo_anterior = '';
                        @endphp
                        <!-- 5 -->
                        @foreach ($programa_academico as $pa)
                        @php
                            $tipo_actual = '';
                            if (str_starts_with(strtolower($pa->programa_academico), 'tec')) {
                                $tipo_actual = 'Programas Académicos de Tecnología';
                            } elseif (str_starts_with(strtolower($pa->programa_academico), 'ing')) {
                                $tipo_actual = 'Programas Académicos de Ingeniería';
                            } elseif (str_starts_with(strtolower($pa->programa_academico), 'esp')) {
                                $tipo_actual = 'Programas Académicos de Especialización';
                            } elseif (str_starts_with(strtolower($pa->programa_academico), 'maes')) {
                                $tipo_actual = 'Programas Académicos de Maestría';
                            } elseif (str_starts_with(strtolower($pa->programa_academico), 'admin')) {
                                $tipo_actual = 'Programas Académicos de Administración';
                            }
                        @endphp
                        @if (!$loop->last)    
                            @php
                                $presupuesto = null;
                                $presupuesto_act = null;
                                foreach ($presupuesto_programa_academico as $presu_pa) {
                                    if ($presu_pa->id_programa_academico == $pa->id) {
                                        $presupuesto = $presu_pa->presupuesto_inicial;
                                        $presupuesto_act = $presu_pa->presupuesto_actual;
                                        break;
                                    }
                                }
                            @endphp
                            @if ($tipo_actual !== $tipo_anterior)
                                <hr class="divider border-primary">
                                <h4 class="">{{ $tipo_actual }}</h4>
                                <hr class="divider border-primary">
                                @php
                                    $tipo_anterior = $tipo_actual;
                                @endphp
                            @endif
                            <div class="card border-secondary">
                                <div class="form-group row ml-1">
                                    <div class="col-md-8">
                                    <label for="presupuesto" class="col-form-label text-md-left col-md-12" title=""><i class="" 
                                        data-toggle="tooltip" data-placement="left" 
                                        data-title="" style="font-size: 0.813rem"></i>Presupuesto dado a {{ $pa->programa_academico }}</label>
                                        <input id="presupuesto" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-12" name="presupuesto" 
                                        value="$ {{number_format($presupuesto,'0',',','.')}}" autocomplete="off" autofocus title="" disabled>
                                    </div> 
                                    <div class="col-md-4">
                                    <label for="presupuesto_restante" class="col-form-label text-md-left col-md-12" title=""><i class="" 
                                        data-toggle="tooltip" data-placement="left" 
                                        data-title="" style="font-size: 0.813rem"></i> Presupuesto restante</label>
                                        <input id="presupuesto_restante" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-8" name="presupuesto_restante" 
                                        value="$ {{number_format($presupuesto_act,'0',',','.')}}" autocomplete="off" autofocus title="" disabled>

                                        @error('vlr_docen_min')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>                                 
                                </div>  
                                <div class="form-group row ml-1">
                                    <div class="col-md-8">
                                    <label for="{{ $pa->id }}" class="col-form-label text-md-left col-md-12" title=""><i class="" 
                                        data-toggle="tooltip" data-placement="left" 
                                        data-title="" style="font-size: 0.813rem"></i> Asignar Nuevo Presupuesto {{ $pa->programa_academico }}</label>
                                        <input id="{{ $pa->id }}" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-12" name="{{ $pa->id }}" 
                                        value="0" autocomplete="off" autofocus title="" onchange="formatVlr(this)" oninput="checkEmptyInput(this)"
                                        onfocus="clearDefaultValue(this)" onblur="restoreDefaultValue(this)" >
                                    </div>                               
                                </div>
                            </div>  
                            <hr class="divider">             
                        @endif
                        @endforeach
                        <!-- 5 -->

                        

                        <!-- submit -->
                            <!-- 8 -->
                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-5">
                                    <br>
                                    <button id="btnGuardarPresupuesto" type="submit" class="btn btn-success" name="submit">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </div>
                            <!-- 8 -->
                        <!-- submit -->
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    @endsection   