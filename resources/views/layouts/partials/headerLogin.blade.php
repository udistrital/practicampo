<div  class="form-group row" style="position: absolute;z-index: 1; width:100%">
    <div class="col-md-3">
    <a href="{{ url('/home') }}"><img src="{{ asset('img/logoHeader.png') }}" alt="" class="logo img-fluid" 
        style="display: inline-block; width: 255px; top: 28px; margin: 1rem 0 0 1.29rem"/></a>
    </div>
    <div class="col-md-7">
    </div>
    <div class="col-md-2">
        <nav class="navbar navbar-expand-lg navbar-light bg-transp" style="margin: 1.9rem 1.3rem 0 -1.3rem;">
        
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <ul class="navbar-nav mr-auto">
                
                @if (Auth::guest())
                    <li><a class="nav-link" href="{{ url('/login') }}" ><i class="icon-user"></i> Ingresar</a></li>
                    <li><a class="nav-link" href="{{ url('/loginEst') }}" ><i class="icon-user"></i> Estudiante</a></li>
                @else
                    
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.1rem">
                    <span class="hidden-xs">{{ Auth::user()->usuario }}</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('users_perfil',Crypt::encrypt(Auth::user()->id)) }}">Perfil</a>
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
</div>