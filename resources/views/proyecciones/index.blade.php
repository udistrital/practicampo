@extends ('layouts.app')
@section ('contenido')  

  <div class="container-fluid" >
    {{-- <img src="{{ asset('img/descarga.jpg') }}" width="100%" height="100%"> --}}
    <div class="row">
      <div class="col-md-5"></div>
      <div class="card-header">{{ __('Listado de Proyecciones Preliminares') }}</div>
      {{-- <div class="col-md-4"></div> --}}
    </div>
    <div class="row">
      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
          <div class="form-group">
            {{-- <a href="{{url('persona_natural/create') }}"><button class="btn btn-success" >Nuevo</button></a> --}}
          </div>
        </div>
        
        
    </div>
    @if(Auth::user()->admin() || Auth::user()->decano() || Auth::user()->coordinador() || Auth::user()->asistenteD())
      <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
              @include('proyecciones.buscador')
        </div>

        @if(Auth::user()->coordinador() || Auth::user()->asistenteD())
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
        </div>

        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
          <form method="POST" action="{{ route('import_list_proyecc.excel') }}"  enctype="multipart/form-data">
            @csrf
                
            <div class="row">
              <div class="form-group">
                    <input type="file"  name="proyecciones_preliminares" class="form-control" required style="color: rgb(243, 3, 3)">
              </div>
              <div class="form-group">
                <label for=""></label>
                  <button class="btn btn-success" name="import_proyecciones" title="Importar Archivo Excel"><i class="fas fa-file-import"></i>     SUBIR</button>
              </div>
            </div> 
          </form>
        </div>

      @endif
      </div>
    @endif

      <!-- 0 -->
      {{-- <div class="row">

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            </div>
            
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
              <div class="form-group">
                <label for=""></label>
                <div class="row">
                  <a href="{{route('proyeccion_preliminar.pdf')}}"><button class="btn btn-success" ><i class="fas fa-download"></i>     PDF</button></a>
                </div>
            </div>
          </div>
      </div> --}}
      <!-- 0 -->
      
    @if(Auth::user()->decano() || Auth::user()->asistenteD() || Auth::user()->admin())
          
      {{-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
        <div class="form-group">
          <label for=""></label>
          <div class="row">
            <a href="{{route('export_list_proyecc.excel')}}"><button class="btn btn-success" title="Exportar Archivo Excel"><i class="fas fa-download"></i>     XSL</button></a>
          </div>
        </div>
      </div>  --}}

      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <form method="POST" action="{{ route('import_list_proyecc.excel') }}" enctype="multipart/form-data">
          @csrf
         
          <div class="row">
          {{-- <div class="col-lg-7 col-md-7 col-sm-8 col-xs-12">    --}}
            <div class="form-group">
              <label for=""></label>
                  {{-- <input type="file"  name="poyecciones_preliminares" style="color: rgb(243, 3, 3)"> --}}
            </div>
          {{-- </div>  --}}
          
          {{-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">  --}}
            <div class="form-group">
              {{-- <label for=""></label>
              <div class="row"> --}}
                {{-- <button class="btn btn-success" name="import_proyecciones" title="Importar Archivo Excel"><i class="fas fa-file-import"></i>     CSV</button></a> --}}
              {{-- </div> --}}
            </div>
          </div> 
        </form>
      </div>
    @endif

    

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {{-- <table class="table table-bordered table-condensed table-hover table-sm" cellspacing="0" style="table-layout: fixed; width:100%; word-break: break-word; font-size: 12px"> --}}
            {{-- <form name="proy_buscador"> --}}
              <!-- filtro -->
              <div class="row" >
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="id_filtro_proyeccion">Filtro</label>
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="id_filtro_proyeccion"   @if(!isset($filter)) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="1" checked>
                                <label class="form-check-label" for="">Todos</label>
                              </div>
                            </div>
                            
                            @if(Auth::user()->admin())
                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'inact')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="16">
                                  <label class="form-check-label" for="">Inactivas</label>
                                </div>
                              </div>

                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'not_send_docente')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="15">
                                  <label class="form-check-label" for="">Sin Enviar - Docente</label>
                                </div>
                              </div>
                            @endif

                            @if(!Auth::user()->decano() && !Auth::user()->admin())
                            
                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'send')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="2">
                                  <label class="form-check-label" for="">Enviados</label>
                                </div>
                              </div>
            
                              
                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'not_send')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="3">
                                    <label class="form-check-label" for="">Sin Enviar</label>
                                </div>
                              </div>
                            @endif

                            @if(Auth::user()->coordinador() || Auth::user()->decano() || Auth::user()->asistenteD())

                              @if(Auth::user()->coordinador())
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'pend')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="7">
                                      <label class="form-check-label" for="">Pendientes</label>
                                  </div>
                                </div>

                              @endif

                              @if(Auth::user()->decano())
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'aprob')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="9">
                                      <label class="form-check-label" for="">Aprob.</label>
                                  </div>
                                </div>

                                {{-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'elect')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="6">
                                      <label class="form-check-label" for="">Electivas</label>
                                  </div>
                                </div> --}}
                            
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'no-elect')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="10">
                                      <label class="form-check-label" for="">Oblig. Sin Proyección</label>
                                  </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'pend')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="7">
                                      <label class="form-check-label" for="">Pendientes</label>
                                  </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'aprob-cons')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="11">
                                      <label class="form-check-label" for="">Aprob. Consejo Facultad</label>
                                  </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'edit_proy')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="17">
                                      <label class="form-check-label" for="">Editar Proyección</label>
                                  </div>
                                </div>
                              @endif

                              @if(Auth::user()->asistenteD())
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'sin_pres')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="5">
                                      <label class="form-check-label" for="">Sin Presupuesto</label>
                                  </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'no-aprob-cons')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="12">
                                      <label class="form-check-label" for="">Sin Aprob. Consejo Facultad</label>
                                  </div>
                                </div>
                              @endif
                            @endif

                            @if(Auth::user()->docente())
                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'proy_recha')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="14">
                                  <label class="form-check-label" for="">Rechazadas</label>
                                </div>
                              </div>

                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="id_filtro_proyeccion"  @if(isset($filter) and ($filter == 'proy_legal')) checked="true" @endif onclick="filtrar_proyecciones(this.value)" value="13">
                                  <label class="form-check-label" for="">Legalizadas</label>
                                </div>
                              </div>
                            @endif

                        </div>
                    </div>
                  </div>
              </div>
              <!-- filtro -->

              @if(Auth::user()->admin())
                @include('proyecciones.tablas.index_admin',$proyecciones)
              @endif  

              @if(Auth::user()->decano())
                @include('proyecciones.tablas.index_dec',$proyecciones)
              @endif 

              @if(Auth::user()->asistenteD())
                @include('proyecciones.tablas.index_asisDec',$proyecciones)
              @endif 

              @if(Auth::user()->coordinador())
                @include('proyecciones.tablas.index_coord',$proyecciones)
              @endif 

              @if(Auth::user()->docente())
                @include('proyecciones.tablas.index_docen',$proyecciones)
              @endif
            {{-- </form> --}}
          <br>
    </div>
            
  
@endsection