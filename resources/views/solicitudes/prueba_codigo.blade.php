@extends ('layouts.app')
@section ('contenido')  

  
  <div class="container-fluid">
    <div class="card-header">{{ __('Código Graduación') }}</div>
    <form method="POST" action="{{ route('consulta_codigo') }}">
        @csrf

    <div class="row">
        <div class="col-md-2">
            <label for="cod_consulta" class="col-form-label text-md-left">{{ __('Código Alfanumérico') }}</label>
            <span class="hs-form-required" title="Código a consultar">*</span>
            <input id="cod_consulta" type="text" class="form-control @error('cod_consulta') is-invalid @enderror" name="cod_consulta" 
            value="" required autocomplete="off" autofocus>

            @error('cod_consulta')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- 19 -->
            <div class="col-md-2">
                <br>
                <button type="submit" class="btn btn-primary" id="consulta_cod">
                    {{ __('Buscar') }}
                </button>
            </div>
        
        <!-- 19 -->
    </div>

    <div class="row">
        <div class="col-md-10">
            <label for="resp_consulta" class="col-form-label text-md-left">{{ __('Respuesta') }}</label>
            <input id="resp_consulta" type="text" class="form-control @error('resp_consulta') is-invalid @enderror" name="resp_consulta" 
            autocomplete="off" autofocus  readonly value="{{$respuesta}}">

            @error('resp_consulta')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

@endsection