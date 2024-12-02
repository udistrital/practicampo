@include('layouts.partials.htmlhead')

<div id="content" style="position: relative;background-color: #ebf4ef; background-image: url('/img/descarga.png');background-repeat: no-repeat; background-size: 100% 100%;">
    
    <div class="container" style=" height:90vh;">
        <div>
        <!-- HEADER -->
            <div  class="row">
                @include('layouts.partials.headerEst')
            </div>
        </div>
        <!-- end HEADER -->
        <br><br>
        <h4>{{ __('Listado de Solicitudes Asociadas a: ') }}{{$estudiante->nombre_completo}}</h4>
        <div class="row" style="background-color: #f8f9fc">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="id_filtro_proyeccion">Seleccionar Filtro</label>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="id_filtro_estudiante"  @if(isset($filter) and ($filter == 'sol_estudiante')) checked="true" @endif onclick="filtrar_solicutudes_estudiante(this.value)" value="1">
                                <label class="form-check-label" for="">Solicitudes Estudiante</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="id_filtro_estudiante"  @if(isset($filter) and ($filter == 'sol_evaluacion')) checked="true" @endif onclick="filtrar_solicutudes_estudiante(this.value)" value="2">
                                <label class="form-check-label" for="">Evaluar Prácticas</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('estudiantes.index_filtros',$solic_asociadas)
        
    </div>
    <br>
    <br><br><br><br><br><br><br><br><br><br><br><br>
</div>
</div>

<!-- footer -->
@include('layouts.partials.footerLogout')

@include('layouts.partials.scripts')