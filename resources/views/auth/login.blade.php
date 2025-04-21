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
    {{-- @section('content') --}}
    <div class="container" style=" height:90vh;">
        
        <br>
        <div style="padding: 0.7rem">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card"  style="background-color: #f2ededb8;">
                        <div class="card-header" style="background-color: #f2eded9c;">
                            <img class="img-fluid" src="{{ asset('img/logoHeader.png') }}" alt="" style="display: flex;margin: auto;">
                        </div>
                        <div class="card-header"  style="background-color: #f2eded9c;">{{ __('PractiCampoUD - Acceso Usuario') }}</div>

                            <div class="card-body ">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="form-group row justify-content-center">
                                <div class="">
                                    <a href="{{ route('wso2.login') }}" class="btn btn-primary">
                                        Iniciar sesión con Microsoft
                                    </a>
                                </div>                        
                            </div>
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
    {{-- @endsection --}}

</div>

<!-- footer -->
@include('layouts.partials.footerLogout')
   
<!-- start scripts -->
@include('layouts.partials.scripts')
<!-- end scripts -->
