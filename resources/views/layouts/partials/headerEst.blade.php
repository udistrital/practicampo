
    <div class="col-md-3">
        <a href="{{ url('/home') }}"><img src="{{ asset('img/logoHeader.png') }}" alt="" class="logo img-fluid" 
        style="display: inline-block; width: 255px; top: 28px; margin: 1rem 0 0 1.29rem"/></a>
    </div>
    <div class="col-md-7">
    </div>
    <div class="col-md-2">
        <nav class="navbar navbar-expand-lg navbar-light bg-transp" style="margin: 1.9rem 1.3rem 0 -1.3rem;">
        
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <ul class="navbar-nav pull-right" style="float: right;margin: 0 15px 0 auto;">
                    
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.1rem">
                    </a>
                    <div class="dropdown-menu ml-auto" aria-labelledby="navbarDropdown">
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

                </ul>
            </div>
        </nav>
    </div>
{{-- </div> --}}