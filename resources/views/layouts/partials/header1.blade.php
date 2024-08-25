<div class="col-md-2 offset-md-10">
    <nav class="navbar navbar-expand-lg navbar-light bg-transp">
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav mr-auto">
            
            @if (Auth::guest())
                <li><a class="nav-link" href="{{ url('/login') }}" style="color: white"><i class="icon-user"></i> Usuario</a></li>
                <li><a class="nav-link" href="{{ url('/loginEst') }}" style="color: white"><i class="icon-user"></i> Estudiante</a></li>
            @else
                
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.1rem">
                <span class="hidden-xs">{{ Auth::user()->usuario }}</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                
                <a class="dropdown-item" href="{{ url('/logout') }}" style="color: #090808"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        <input type="submit" value="logout" style="display: none;">
                </form>
                </div>
            </li>
            @endif

            </ul>
        </div>
    </nav>
</div>