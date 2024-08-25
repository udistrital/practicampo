
<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- HTML HEAD incluye las Hojas de Estilo, El titulo, El CSRF,  -->
    @include('layouts.partials.htmlhead')
    <!-- end HTML HEAD -->
    <html lang="es">

<body>

    @include('loader')
    <div id="wrapper">
        
        @if (Auth::user())
        <!-- start sidebar -->
        @include('layouts.partials.sidebar')
        <!-- end sidebar -->
        
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="position: relative">
                
            @if (Auth::user())
                <!-- start header -->
                @include('layouts.partials.headerLogin')
                <!-- end header -->

            @else
                <!-- start header logout-->
                @include('layouts.partials.header1')
                <!-- end header logout-->
            @endif

           
                <div class="container-fluid" style="margin:0; padding:0">
                    <br>
                    <br>
                    <br>
                    <br>

                     <!-- errores -->
                    @if (session('message'))
                        <br>
                        <div class="alert alert-info">{{ session('message') }}</div>
                    @endif
                    @if (session('error'))
                        <br>
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <!-- errores -->

                    @yield('contenido') 
                    
                </div>
            </div>
             
        </div>
        <!-- start toggle top area -->
        @include('layouts.partials.footer')
        <!-- end toggle top area -->

    </div>
    
        @endif
    <!-- start scripts -->
    @include('layouts.partials.scripts')
    <!-- end scripts -->
</body>
</html>
