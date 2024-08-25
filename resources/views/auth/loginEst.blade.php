@include('layouts.partials.htmlhead')
{{-- @include('layouts.partials.header1') --}}

{{-- <div style="background-image: url('img/fondo_bienvenida.jpg');background-repeat: no-repeat; background-size: 100% 100%; background-position: left top; width: 100%; height:100%; object-fit: cover;"> --}}
<div style='background: url("img/fondo_bienvenida.jpg") 50% fixed;background-size: cover;height: auto;float: center;position: absolute;overflow: auto;bottom: 9.25rem;width: 100%;top: 0.00rem;'>
        
    <div style="background-color: #10241670;">
        {{-- 102416de footer --}}
        <!-- HEADER -->
        @include('layouts.partials.header1')
        <!-- end HEADER -->

    </div>
    <div class="container" style=" height:90vh;">
        
        <br>
        <div style="padding: 0.7rem">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card" style="background-color: #f2ededb8;">
                        <div class="card-header" style="background-color: #f2eded9c;">
                            <img class="img-fluid" src="{{ asset('img/logoHeader.png') }}" alt="" style="display: flex;margin: auto;">
                        </div>
                        <div class="card-header" style="background-color: #f2eded9c;">{{ __('PractiCampoUD - Acceso Estudiante') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('loginEst') }}">
                                @csrf
        
                                <div class="form-group row">
                                    <label for="usuario" class="col-md-4 col-form-label text-md-right">
                                        <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Ingrese el correo institucional"
                                            style="font-size: 0.813rem">
                                        </i> {{ __('Correo Institucional') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="email" type="usuario" class="form-control @error('usuario') is-invalid @enderror" 
                                        name="email" value="{{ old('email') }}" required autocomplete="usuario" autofocus title="">
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">
                                        <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Ingrese el código estudiantil"
                                            style="font-size: 0.813rem">
                                        </i> {{ __('Código Estudiantil') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" 
                                        required autocomplete="current-password">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- <hr class="divider"> --}}
                        <div class="card-header"  style="background-color: #f2eded9c;">{{ __('¿Qué es PractiCampoUD?') }}</div>
                        <div class="card-body">
                            {{-- <div class="form-group row"> --}}

                                {{-- <div> --}}
                                    <p style="padding: 0.625rem;">PractiCampoUD es un sistema web enfocado en la planificación, gestión y seguimiento 
                                        de las prácticas académicas de campo asociadas a la Facultad del Medio Ambiente y Recursos Naturales
                                        de la Universidad Distrital Francisco José de Caldas.</p>
                                {{-- </div> --}}
                            {{-- </div> --}}
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>

<!-- start toggle top area -->
@include('layouts.partials.footerLogout')
   
<!-- start scripts -->
@include('layouts.partials.scripts')
<!-- end scripts -->
