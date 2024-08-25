@extends ('layouts.app')
@section ('contenido')  

  
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5"></div>
            <div class="card-header">{{ __('Acciones Solicitud N°') }}{{$solicitud->id}}</div>
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                    <div class="form-group">
                        {{-- <a href="{{url('persona_natural/create') }}"><button class="btn btn-success" >Nuevo</button></a> --}}
                    </div>
                </div>
                
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    {{-- @include('persona.natural.search') --}}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                </div>
        
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        
                    <table class="table table-bordered table-condensed table-hover table-sm" cellspacing="0" style="table-layout: fixed; width:100%; word-break: break-word; font-size: 12px">
                    
                        <thead>
                            <th style="width: 33px">Cod.</th>
                            <th style="width: 90px">Tipo Documento</th>
                            <th style="width: 95px">Abrev.</th>
                            <th style="width: 45px" style="text-align:center;">Descargar</th>
                            {{-- <th style="width: 37px">Importar</th> --}}
                        </thead> 

                        @if(Auth::user()->decano() || Auth::user()->asistenteD())
                            @foreach ($documentos_sistema as $item) 
                                <tr>
                                    @if($item->id == 1 || $item->id == 3 || $item->id == 4 || $item->id == 2 || $item->id == 5 || $item->id == 6)
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->tipo_documentacion }}</td>
                                        <td>{{ $item->abrev }}</td>
                                        
                                        @if($item->id == 1)
                                        <td style="text-align:center;"> 
                                            @if($docente_responsable->id_estado == 1)
                                                <a href="{{route('giro.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}">
                                                <button class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>  PDF</button>
                                                </a>
                                            @else
                                                Docen. Inactivo
                                            @endif
                                        </td>
                                        @endif

                                        @if($item->id == 2)
                                        <td style="text-align:center;"> 
                                            @if($docente_responsable->id_estado == 1)
                                                <a href="{{route('oficio.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}">
                                                <button class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                                </a>
                                            @else
                                                Docen. Inactivo
                                            @endif
                                        </td>
                                        @endif

                                        @if($item->id == 3)
                                        <td style="text-align:center;"> 
                                            @if($docente_responsable->id_estado == 1)
                                                <a href="{{route('resolucion.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}">
                                                <button class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                                </a>
                                            @else
                                                Docen. Inactivo
                                            @endif
                                        </td>
                                        @endif

                                        @if($item->id == 6)
                                        <td style="text-align:center;"> 
                                            @if($docente_responsable->id_estado == 1)
                                                <a href="{{route('transporte.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}">
                                                <button class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                                </a>
                                            @else
                                                Docen. Inactivo
                                            @endif
                                        </td>
                                        @endif

                                        @if($item->id == 4)
                                            <td style="text-align:center;"> 
                                                @if($docente_responsable->id_estado == 1)
                                                    <a href="{{route('avance.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}">
                                                        <button class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                                    </a>
                                                @else
                                                    Docen. Inactivo
                                                @endif
                                            </td>
                                        @endif

                                        @if($item->id == 5)
                                            <td style="text-align:center;">
                                                @if($docente_responsable->id_estado == 1)
                                                    <a href="{{route('formatoPractica.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}">
                                                        <button class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                                    </a>
                                                @else
                                                    Docen. Inactivo
                                                @endif
                                            </td>
                                        @endif

                                        @endif
                                        

                                </tr>
                            @endforeach
                        @endif
                    
                    </table>
                </div>
        
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                </div>
        
            </div> 
            
            

    </div>     
      
    <form method="POST" action="{{ route('consec_solic',[Crypt::encrypt($solicitud->id)]) }}">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group row">
                    <div class="col-md-5" id="c_dfamarena">
                        <label for="consec_dfamarena" class="col-form-label text-md-left">
                            <i class="fas fa-question-circle" 
                                data-toggle="tooltip" data-placement="left" 
                                data-title="Indique el consecutivo DFAMARENA"
                                style="font-size: 0.813rem">
                            </i> {{ __('Consecutivo DFAMARENA') }}</label>
                        <span class="hs-form-required">*</span>
                        <input id="consec_dfamarena" type="text" class="form-control @error('consec_dfamarena') is-invalid @enderror" name="consec_dfamarena" 
                        value="{{$solicitud->consec_dfamarena}}" autocomplete="off" autofocus required onkeyup="onlyNmb(this)" onchange="onlyNmb(this)">
                        @error('consec_dfamarena')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-5" id="c_cordis">
                        <label for="consec_cordis" class="col-form-label text-md-left">
                            <i class="fas fa-question-circle" 
                                data-toggle="tooltip" data-placement="left" 
                                data-title="Indique el consecutivo CORDIS"
                                style="font-size: 0.813rem">
                            </i> {{ __('Consecutivo CORDIS') }}</label>
                        <span class="hs-form-required">*</span>
                        <input id="consec_cordis" type="text" class="form-control @error('consec_cordis') is-invalid @enderror" name="consec_cordis" 
                        value="{{$solicitud->consec_cordis}}" autocomplete="off" autofocus required>
                        @error('consec_cordis')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- guardar -->
                        <div class="col-md-2" style="display: grid;align-items: end;">
                            <br>
                            <button type="submit" class="btn btn-success">
                                {{ __('Guardar') }}
                            </button>
                        </div>
                    <!-- guardar -->
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            </div>
        </div>

        

    </form>

@endsection