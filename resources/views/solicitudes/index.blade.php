@extends ('layouts.app')
@section ('contenido')  

  <div class="container-fluid">
        <div class="row">
          <div class="col-md-5"></div>
          <div class="card-header">{{ __('Listado de Solicitudes') }}</div>
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
                  @include('solicitudes.buscador')
            </div>
          </div>
        @endif
      
      {{-- @if(Auth::user()->decano() || Auth::user()->asistenteD() || Auth::user()->admin() || Auth::user()->docente())
          
      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
        <div class="form-group">
          <label for=""></label>
          <div class="row">
            <a href="{{route('export_list_proyecc.excel')}}"><button class="btn btn-success" title="Exportar Archivo Excel"><i class="fas fa-download"></i>     XSL</button></a>
          </div>
        </div>
      </div>  --}}

      {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <form method="POST" action="{{ route('import_list_proyecc.excel') }}"  enctype="multipart/form-data">
          @csrf
         
          <div class="row">
          {{-- <div class="col-lg-7 col-md-7 col-sm-8 col-xs-12">    --}}
            {{-- <div class="form-group">
              <label for=""></label>
                  <input type="file"  name="poyecciones_preliminares" style="color: rgb(243, 3, 3)">
            </div> --}}
          {{-- </div>  --}}
          
          {{-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">  --}}
            {{-- <div class="form-group"> --}}
              {{-- <label for=""></label>
              <div class="row"> --}}
                {{-- <button class="btn btn-success" name="import_proyecciones" title="Importar Archivo Excel"><i class="fas fa-file-import"></i>     CSV</button></a> --}}
              {{-- </div> --}}
            {{-- </div>
          </div> 
        </form> --}}
    {{-- </div> 
      @endif --}}

      {{-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
          <div class="form-group">
            <label for=""></label>
            <div class="row">
              <a href="{{route('proyeccion_preliminar.pdf')}}"><button class="btn btn-success" ><i class="fas fa-download"></i>     PDF</button></a>
            </div>
        </div>
      </div> --}}

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          {{-- <table class="table table-bordered table-condensed table-hover table-sm" cellspacing="0" style="table-layout: fixed; width:100%; word-break: break-word; font-size: 12px"> --}}
            {{-- <form name="soli_buscador"> --}}
              <!-- filtro -->
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="id_filtro_proyeccion">Filtro</label>
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="id_filtro_solicitud"   @if(!isset($filter)) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="1" checked>
                                <label class="form-check-label" for="">Todos</label>
                              </div>
                            </div>

                            @if(Auth::user()->admin())
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'inact')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="23">
                                  <label class="form-check-label" for="">Inactivas</label>
                              </div>
                            </div>
                            @endif

                            @if(!Auth::user()->coordinador())
                              {{-- @if(!Auth::user()->asistenteD()) --}}
                                @if(!Auth::user()->decano() && !Auth::user()->transportador() && !Auth::user()->admin())
                                  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"   @if(isset($filter) and ($filter == 'aprob')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="9">
                                      <label class="form-check-label" for="">Aprob.</label>
                                    </div>
                                  </div>
                                @endif
                              {{-- @endif --}}
                            @endif  
                            
                            @if(!Auth::user()->decano())

                              @if(Auth::user()->docente())
                              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'ejec-sol')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="16">
                                      <label class="form-check-label" for="">Ejecución</label>
                                  </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'sol_recha')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="20">
                                      <label class="form-check-label" for="">Rechazadas</label>
                                  </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'transp')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="19">
                                      <label class="form-check-label" for="">Transp.</label>
                                  </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'estud')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="22">
                                      <label class="form-check-label" for="">Estud.</label>
                                  </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'proy-comp')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="15">
                                      <label class="form-check-label" for="">Solicitudes</label>
                                  </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'pre-proy')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="13">
                                      <label class="form-check-label" for="">Proyecciones</label>
                                  </div>
                                </div>
                              @endif 

                            @endif

                            @if(Auth::user()->coordinador() || Auth::user()->decano()  || Auth::user()->asistenteD())

                              @if(Auth::user()->coordinador() || Auth::user()->asistenteD())
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'pend')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="7">
                                      <label class="form-check-label" for="">Pendientes</label>
                                  </div>
                                </div>
                              
                                {{-- @if(Auth::user()->coordinador())
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'pre-proy')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="13">
                                        <label class="form-check-label" for="">Proyecciones</label>
                                    </div>
                                  </div>
                                @endif --}}

                                @if(Auth::user()->asistenteD())
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'pend-teso')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="17">
                                        <label class="form-check-label" for="">Tesorería</label>
                                    </div>
                                  </div>
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'pend-cierre')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="18">
                                        <label class="form-check-label" for="">Cierres</label>
                                    </div>
                                  </div>

                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'enc_trans')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="21">
                                        <label class="form-check-label" for="">Encuestas</label>
                                    </div>
                                  </div>
                                @endif

                              @endif

                              @if(Auth::user()->decano() )
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'aprob')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="9">
                                      <label class="form-check-label" for="">Aprob.</label>
                                  </div>
                                </div>
                              @endif
                            @endif

                            @if(Auth::user()->asistenteD() )
                            @endif

                            @if(Auth::user()->decano() )

                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="id_filtro_solicitud"  @if(isset($filter) and ($filter == 'pend')) checked="true" @endif onclick="filtrar_solicitudes(this.value)" value="7">
                                    <label class="form-check-label" for="">Pendientes</label>
                                </div>
                              </div>
                            @endif

                        </div>
                    </div>
                  </div>
              </div>
              <!-- filtro -->

              @if(Auth::user()->admin())
                @include('solicitudes.tablas.index_admin',$proyecciones)
              @endif  

              @if(Auth::user()->decano())
                @if($filter == 'aprob_solic')
                  @include('solicitudes.tablas.index_docpdf_descarga',$proyecciones)
                @else
                  @include('solicitudes.tablas.index_dec',$proyecciones)
                @endif
              @endif 

              @if(Auth::user()->asistenteD())
                @if($filter == 'aprob_solic')
                  @include('solicitudes.tablas.index_docpdf_descarga',$proyecciones)
                @else
                  @include('solicitudes.tablas.index_asisDec',$proyecciones)
                @endif 
              @endif 

              @if(Auth::user()->coordinador())
                @include('solicitudes.tablas.index_coord',$proyecciones)
              @endif 

              @if(Auth::user()->docente())
                @include('solicitudes.tablas.index_docen',$proyecciones)
              @endif

              @if(Auth::user()->transportador())
                @include('solicitudes.tablas.index_transp',$proyecciones)
              @endif
            {{-- </form> --}}
              <br>
        </div>
        
@endsection