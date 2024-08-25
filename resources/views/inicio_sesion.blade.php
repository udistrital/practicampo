
<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- HTML HEAD incluye las Hojas de Estilo, El titulo, El CSRF,  -->
    @include('layouts.partials.htmlhead')
    <!-- end HTML HEAD -->
    <html lang="es">

<body>
    <div style="background-image: url('img/fondo_bienvenida.jpg');background-repeat: no-repeat; background-size: 100% 100%; background-position: left top; width: 100%; height:100%; object-fit: cover;">
        
        <div style="background-color: #10241670;">
            {{-- 102416de footer --}}
            <!-- HEADER -->
            @include('layouts.partials.header1')
            <!-- end HEADER -->

        </div>

        <div class="container">
            {{-- <div class="col-md-2">
               
            </div> --}}
            <div style="background-color: #E4E4E4F0; height:90vh; padding: 0.7rem">
                <div style="background-color: #BB9D8B6B; marging:0.7rem">
                    {{-- dfd2c8 --}}
ads
                </div>
            </div>
            {{-- <div class="col-md-2">
                
            </div> --}}
        </div>
       
         
        <!-- start toggle top area -->
        @include('layouts.partials.footer')
    </div>
       
    <!-- start scripts -->
    @include('layouts.partials.scripts')
    <!-- end scripts -->
</body>
</html>
