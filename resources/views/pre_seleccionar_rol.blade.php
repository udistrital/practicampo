@include('layouts.partials.htmlhead')

<div id="content" style="position: relative;background-color: #ebf4ef; background-image: url('/img/descarga.png');background-repeat: no-repeat; background-size: 100% 100%;">
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="modal fade show" id="rolModal2" tabindex="-1" aria-labelledby="rolModalLabel" aria-hidden="true" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered" style="margin-top: -5vh;"> <!-- Ajuste de margen superior -->
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgb(0, 56, 36); border-color: rgb(0, 56, 36); color: white;">
                    <h5 class="modal-title" id="rolModalLabel">Selecciona un rol</h5>
                </div>
                <div class="modal-body">
                    <form id="rolForm" action="{{ route('seleccionar_rol') }}" method="POST">
                        @csrf
                        @php
                            $roles = session('roles_disponibles', []);
                        @endphp
                        <select name="rol" id="rol" class="form-control" required>
                            @foreach($roles as $id => $nombre)
                                <option value="{{ $id }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success mt-3">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>  
@include('layouts.partials.footer')

