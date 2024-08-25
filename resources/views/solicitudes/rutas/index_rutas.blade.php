@extends ('layouts.app')
@section ('contenido')  

  
  <div class="container-fluid">
      <div class="card-header">{{ __('Listado de Rutas - Proyección Preliminar N° ') }}<?php echo $proyeccion_preliminar->id?></div>
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


      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          
        {{-- @if(Auth::user()->admin())
          @include('solicitudes.tablas.index_admin',$proyecciones)
        @endif  

        @if(Auth::user()->decano())
          @include('solicitudes.tablas.index_dec',$proyecciones)
        @endif 

        @if(Auth::user()->asistenteD())
          @include('solicitudes.tablas.index_asisDec',$proyecciones)
        @endif 

        @if(Auth::user()->coordinador())
          @include('solicitudes.tablas.index_coord',$proyecciones)
        @endif  --}}

        

        @if(Auth::user()->coordinador() || Auth::user()->docente() || Auth::user()->admin())
        

          {{-- @if($proyeccion_preliminar->listado_estudiantes == 0) --}}
          
            @if(Auth::user()->admin() ||Auth::user()->docente() || Auth::user()->id == $proyeccion_preliminar->id_docente_responsable)
              @include('solicitudes.rutas.rutas',$rutas)
            @endif
          @endif
        {{-- @endif --}}
          
      </div>
  
@endsection