    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-map-marked-alt"></i>
          </div>
          <div class="sidebar-brand-text mx-3">Prácticas de Campo</div>
        </a>
  
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
  
        <!-- Nav Item - Dashboard -->
       
        @if(Auth::user()->adminPerm())
          <li class="nav-item">
            <a class="nav-link collapsed" href="#collapseOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Admin</span></a>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
              <div class="bg-nav py-2 collapse-inner rounded">
                  <a class="collapse-item" href="{{url('users/filtrar/all') }}">Listar Usuarios</a>
                  <a class="collapse-item" href="{{url('register') }}">Nuevo Usuario</a>
                  <a class="collapse-item" href="{{url('ver/documento') }}">Listar Documentos</a>
                  <a class="collapse-item" href="{{url('sistema') }}">Sistema</a>
                  <a class="collapse-item" href="{{url('presupuesto') }}">Presupuestos</a>
                  {{-- <a class="collapse-item" href="{{url('edicion/documento') }}">Edición Documentos</a> --}}
              </div>
            </div>
          </li>
        
        <!-- Divider -->
          <hr class="sidebar-divider"> 
        
        @endif

        @if(Auth::user()->otrosPerm())
        <!-- Heading -->
          <div class="sidebar-heading">
            MÓDULOS
          </div>
  
          @if($usuario->tiene_firma == 1 || Auth::user()->admin() || Auth::user()->asistenteD() || Auth::user()->transportador())
            @if($control_sistema->estado_proy == 1 && $usuario->id_role != 7)
            <!-- Nav Item - Pages Collapse Menu  proyecciones-->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#collapseTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <i class="fas fa-fw fa-business-time"></i>
                  <span>PROYECCIONES</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-nav py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{url('proyecciones/filtrar/all') }}">Listar Proyecciones</a>
                    @if(Auth::user()->docente())
                    <a class="collapse-item" href="{{route('proyeccion_create')}}">Nueva Proyección</a>
                    @endif
                  </div>
                </div>
              </li>
            <!-- Nav Item - Pages Collapse Menu proyecciones -->
            @endif

            @if($control_sistema->estado_solic == 1)
            <!-- Nav Item - Pages Collapse Menu solicitudes -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#collapseThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                  <i class="fas fa-fw fa-clipboard-check"></i>
                  <span>SOLICITUDES</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                  <div class="bg-nav py-2 collapse-inner rounded">
                    {{-- @if(Auth::user()->admin() || Auth::user()->decano() || Auth::user()->asistenteD() || Auth::user()->coordinador() || Auth::user()->docente() || Auth::user()->transportador()) --}}
                    <a class="collapse-item" href="{{url('solicitudes/filtrar/all') }}">Listar Solicitudes </a>
                    {{-- @endif --}}
                  </div>
                </div>
              </li>
              <!-- Nav Item - Pages Collapse Menu solicitudes -->
            @endif
          
          @endif
          <!-- Nav Item - Pages Collapse Menu Firma litográfica -->
          @if( Auth::user()->decano() || Auth::user()->coordinador() || Auth::user()->docente())
            <li class="nav-item">
              <a class="nav-link collapsed" href="#collapseFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <i class="fas fa-fw fa-edit"></i>
                <span>FIRMA LITOGRÁFICA</span>
              </a>
              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-nav py-2 collapse-inner rounded">
                  <a class="collapse-item" href="{{route('firma_lito') }}">Agregar Firma</a>
                  {{--  --}}
                </div>
              </div>
            </li>
          @endif
          <!-- Nav Item - Pages Collapse Menu Firma litográfica -->

          <!-- Nav Item - Pages Collapse Menu Documentación Sistema -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="#collapseFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
              <i class="fas fa-fw fa-file-pdf"></i>
              <span>DOCUMENTOS</span>
            </a>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionSidebar">
              <div class="bg-nav py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('dwn_man_user') }}">Manual Usuario</a>
                <a class="collapse-item" href="{{route('dwn_resol_pract_pre') }}">Resolución 090</a>
                <a class="collapse-item" href="{{route('exp_formato_users') }}">Formato Usuarios</a>
                <a class="collapse-item" href="{{route('exp_formato_proy') }}">Formato Proyecciones</a>
                <a class="collapse-item" href="{{route('exp_formato_estud') }}">Formato Estudiantes</a>
                <a class="collapse-item" href="{{route('dwn_infor_final') }}">Formato Informe Final</a>
              </div>
            </div>
          </li>
          <!-- Nav Item - Pages Collapse Menu Documentación Sistema -->

          <!-- Nav Item - Pages Collapse Menu Soporte Sistema -->
          {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#collapseSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
              <i class="fas fa-fw fa-question-circle"></i>
              <span>AYUDA</span>
            </a>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionSidebar">
              <div class="bg-nav py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('ayuda') }}">Preguntas Frecuentes</a>
                
              </div>
            </div>
          </li> --}}
          <!-- Nav Item - Pages Collapse Menu Soporte Sistema-->
          
        
        
        @endif

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
  
    </ul>
    <!-- End of Sidebar -->