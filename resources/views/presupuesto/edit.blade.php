<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Editar Presupuesto de los programas académicos') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('presupuesto_update') }}" onsubmit="return confirmarGuardarPresupuesto(event)">
                            @method('PUT')
                            @csrf

                        <br>

                        <!-- 5 -->
                        @foreach ($programa_academico as $pa)
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
                            <div class="form-group row">
                                <div class="col-md-8">
                                <label for="{{ $pa->id }}" class="col-form-label text-md-left col-md-12" title=""><i class="fas fa-question-circle" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i> Presupuesto inicial para {{ $pa->programa_academico }}</label>
                                    <input id="{{ $pa->id }}" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-12" name="{{ $pa->id }}" 
                                    value="{{$presupuesto}}" autocomplete="off" autofocus title="">

                                    @error('vlr_docen_min')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> 
                                <div class="col-md-4">
                                <label for="{{ $pa->id }}" class="col-form-label text-md-left col-md-12" title=""><i class="fas fa-question-circle" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i> Presupuesto actual</label>
                                    <input id="{{ $pa->id }}" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-8" name="{{ $pa->id }}" 
                                    value="{{$presupuesto_act}}" autocomplete="off" autofocus title="" disabled>

                                    @error('vlr_docen_min')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
    @endsection   