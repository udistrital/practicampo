<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Editar Usuario') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ url('users', Crypt::encrypt($usuario->id)) }}">
                            @method('PUT')
                            @csrf
                        
                            <!-- estado -->
                                <!-- 0 -->
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="id_estado">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Asigne uno de los estados al usuario" style="font-size: 0.813rem"></i> Estado
                                                {{-- <a ><i class="fas fa-question-circle"></i></a> --}}
                                            </label>

                                            <div class="row">

                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="id_estado" value="1"
                                                    <?php if($usuario->id_estado == 1) echo 'checked'?>>
                                                    <label class="form-check-label" for="">Activo</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="id_estado"  value="2" 
                                                        <?php if($usuario->id_estado == 2) echo 'checked'?>>
                                                        <label class="form-check-label" for="">Inactivo</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                <!-- 0 -->
                            <!-- estado -->

                            <!-- información personal -->
                                <br>
                                <h4>Información Personal</h4>
                                <hr class="divider">
                                <br>

                                <!-- 1 -->
                                    <div class="form-group row">
                                        
                                        <div class="col-md-3">
                                            <label for="primer_nombre" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el primer nombre" style="font-size: 0.813rem"></i> {{ __('Primer Nombre') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="primer_nombre" type="text" class="form-control @error('primer_nombre') is-invalid @enderror" name="primer_nombre" value="{{ $usuario->primer_nombre }}" required autocomplete="primer_nombre" autofocus>
            
                                            @error('primer_nombre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        
                                        <div class="col-md-3">
                                            <label for="segundo_nombre" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el segundo nombre" style="font-size: 0.813rem"></i> {{ __('Segundo Nombre') }}</label>
                                            <input id="segundo_nombre" type="text" class="form-control @error('segundo_nombre') is-invalid @enderror" name="segundo_nombre" value="{{ $usuario->segundo_nombre }}" autocomplete="segundo_nombre" autofocus>
            
                                            @error('segundo_nombre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        
                                        <div class="col-md-3">
                                            <label for="primer_apellido" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el primer apellido" style="font-size: 0.813rem"></i> {{ __('Primer Apellido') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="primer_apellido" type="text" class="form-control @error('primer_apellido') is-invalid @enderror" name="primer_apellido" value="{{ $usuario->primer_apellido }}" required autocomplete="primer_apellido" autofocus>
            
                                            @error('primer_apellido')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        
                                        <div class="col-md-3">
                                            <label for="segundo_apellido" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el segundo apellido" style="font-size: 0.813rem"></i> {{ __('Segundo Apellido') }}</label>
                                            <input id="segundo_apellido" type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" name="segundo_apellido" value="{{ $usuario->segundo_apellido }}" autocomplete="segundo_apellido" autofocus
                                            >
            
                                            @error('segundo_apellido')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- 1 -->

                                <!-- 2 -->
                                    <div class="form-group row">
                                        
                                        <div class="col-md-3">
                                            <label for="id_tipo_identificacion" class="col-form-label text-md-right">{{ __('Tipo Identificación') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_tipo_identificacion" class="form-control" required readonly disabled>
                                                @foreach($tipos_identificaciones as $tip_ident)
                                                <option <?php if($tip_ident->id==$usuario->id_tipo_identificacion) echo 'selected'?> value="{{$tip_ident->id}}">{{$tip_ident->sigla}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_tipo_identificacion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="num_identificacion" class="col-form-label text-md-right">{{ __('N° Identificación') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="num_identificacion"  class="form-control @error('num_identificacion') is-invalid @enderror" name="num_identificacion" value="{{ $usuario->id }}"
                                            required autocomplete="off" autofocus readonly>
            
                                            @error('num_identificacion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="expedicion_identificacion" class="col-form-label text-md-right">{{ __('Lugar Expedición') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="expedicion_identificacion"  class="form-control @error('expedicion_identificacion') is-invalid @enderror" name="expedicion_identificacion" 
                                            value="{{ $usuario->expedicion_identificacion }}" required autocomplete="off" autofocus readonly>
            
                                            @error('expedicion_identificacion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                <!-- 2 -->

                                <!-- 3 -->
                                    <div class="form-group row">

                                        <div class="col-md-6">
                                            <label for="email" class="col-form-label text-md-right">{{ __('Correo Electrónico Institucional') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $usuario->email }}" required autocomplete="off"
                                            readonly>
                                            {{-- onchange="obtenerUsuario(this.value);" --}}
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="telefono" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique un número de teléfono" style="font-size: 0.813rem"></i> {{ __('Teléfono') }}</label>
                                            <input id="telefono"  class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ $usuario->telefono }}" autocomplete="off">
                                            @error('telefono')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label for="celular" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique un número de celular
                                                " style="font-size: 0.813rem"></i> {{ __('Celular') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="celular" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ $usuario->celular }}" required autocomplete="off">
                                            
                                            @error('celular')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <input id="cr" style="color:transparent !important;display:none" class="form-control" name="cr" autocomplete="off">
                                            
                                        </div>

                                    </div>
                                <!-- 3 -->

                            <!-- información personal -->

                            <!-- información cuenta -->
                                <br>
                                <h4>Información Cuenta</h4>
                                <hr class="divider">
                                <br>

                                <!-- 4 -->
                                    <div class="form-group row">

                                        {{-- <div class="col-md-1"></div> --}}
                                        
                                        <div class="col-md-3">
                                            <label for="usuario" class="col-form-label text-md-left">{{ __('Usuario') }}</label>
                                            {{-- <span class="hs-form-required">*</span> --}}
                                            <input id="usuario" type="text" class="form-control @error('usuario') is-invalid @enderror" name="usuario" value="{{ $usuario->usuario }}" required autocomplete="name" autofocus 
                                            readonly>
            
                                            @error('usuario')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="col-md-3">
                                            <label for="id_role" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el tipo de usuario" style="font-size: 0.813rem"></i> {{ __('Tipo Usuario') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_role" class="form-control" required>
                                                @foreach($tipos_usuarios as $tip_user)
                                                    <option <?php if($tip_user->id==$usuario->id_role) echo 'selected'?> value="{{$tip_user->id}}">{{$tip_user->role}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_role')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="id_programa_academico_coord" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el programa académico de coordinación" style="font-size: 0.813rem"></i> {{ __('Prog. Académico Coord.') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_programa_academico_coord" class="form-control" required id="id_programa_academico_coord">
                                                @foreach($programas_academicos as $pr_aca)
                                                    <option <?php if($pr_aca->id==$usuario->id_programa_academico_coord) echo 'selected'?> value="{{$pr_aca->id}}">{{$pr_aca->programa_academico}}</option>  
                                                @endforeach
                                            </select>
                                            @error('id_programa_academico_coord')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 

                                        <div class="col-md-3">
                                            <label for="id_tipo_vinculacion" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el tipo de vinculación
                                                " style="font-size: 0.813rem"></i> {{ __('Vinculación') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_tipo_vinculacion" class="form-control" required>
                                                @foreach($tipos_vinculaciones as $tv)
                                                <option <?php if($tv->id==$usuario->id_tipo_vinculacion) echo 'selected'?> value="{{$tv->id}}">{{$tv->tipo_vinculacion}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_tipo_vinculacion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        

                                    </div>
                                <!-- 4 -->

                                <!-- cant prog academico-->
                                    <div class="form-group row">
                                        <div class="col-md-2" >
                                            <label for="c_espa_aca_user" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                    data-toggle="tooltip" data-placement="left" 
                                                    data-title="Indique la cantidad de espacios académicos asociados al usuario"
                                                    style="font-size: 0.813rem">
                                                </i> {{ __('Cant. Espa. Aca.') }}</label>
                                            <div class="input-group">
                                                <input id="c_espa_aca_user_edit" type="number" max="6" min="1" pattern="^[1-6]+" class="form-control @error('c_espa_aca_user_edit') is-invalid @enderror" name="c_espa_aca_user_edit" 
                                                title="Número de espacios académicos"
                                                value="{{$usuario->cant_espacio_academico}}" autocomplete="off" autofocus onchange="">
                                                
                                                @error('c_espa_aca_user_edit')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success btn_ver" type="button" id="ver_esp_user" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                    onclick="ver_esp()"><i class="far fa-eye"></i></button>
                                                    <button class="btn btn-success btn_ver" type="button" id="ocul_esp_user" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                    onclick="ocul_esp()"><i class="far fa-eye-slash"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <!-- cant prog academico-->

                                <!-- 6 Academico_1 -->
                                    <div class="form-group row" id="esp_aca_user_1_edit">
                                        <div class="col-md-3">
                                            <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_programa_academico_[]" id="id_programa_academico_1" class="form-control" required onchange="searchEspaAca_2(1)">
                                                @foreach($programas_academicos as $pr_aca)
                                                    <option <?php if($pr_aca->id==$espacios_usuario[0]['id_programa_academico']) echo 'selected'?> value="{{$pr_aca->id}}">{{$pr_aca->programa_academico}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_programa_academico_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="cod_espacio_academico_1" id="cod_espacio_academico_1" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el código de la asignatura. Para N/A es el 0" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="{{$espacios_usuario[0]['codigo_espacio_academico']}}"class="form-control"
                                            onchange="searchEspaAca(this.value,1)"/>
                                        </div>
                                        <div class="col-md-7">
                                            <label for="espacio_academico_1" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input type="text" name="espacio_academico_1" id="espacio_academico_1" value="{{$espacios_usuario[0]['espacio_academico']}}" class="form-control" 
                                            readonly/>
                                        </div>
                                    </div>

                                <!-- 6 Academico_1 -->
<!-- 6 Academico_2 -->
                                    {{-- @if($usuario->id_espacio_academico_2 != null) --}}
                                    <div class="form-group row"  id="esp_aca_user_2_edit">
                                        <div class="col-md-3">
                                            <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                            <select name="id_programa_academico_[]"  id="id_programa_academico_2" class="form-control" onchange="searchEspaAca_2(2)">
                                                @foreach($programas_academicos as $pr_aca)
                                                    <option <?php if($pr_aca->id==$espacios_usuario[1]['id_programa_academico']) echo 'selected'?> value="{{$pr_aca->id}}">{{$pr_aca->programa_academico}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_programa_academico_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="cod_espacio_academico_2" id="cod_espacio_academico_2" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el código de la asignatura" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                        <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="{{$espacios_usuario[1]['codigo_espacio_academico']}}" class="form-control"
                                            onchange="searchEspaAca(this.value,2)"/>
                                        </div>
                                        <div class="col-md-7">
                                            <label for="espacio_academico_2" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                            
                                            <input type="text" name="espacio_academico_2" id="espacio_academico_2" value="{{$espacios_usuario[1]['espacio_academico']}}" class="form-control" 
                                            readonly/>
                                        </div>        
                                    </div>
                                    {{-- @endif --}}

                                <!-- 6 Academico_2 -->

<!-- 6 Academico_3 -->
                                    {{-- @if($usuario->id_espacio_academico_3 != null) --}}
                                    <div class="form-group row"  id="esp_aca_user_3_edit">
                                        <div class="col-md-3">
                                            <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                            <select name="id_programa_academico_[]"  id="id_programa_academico_3" class="form-control"onchange="searchEspaAca_2(3)">
                                                @foreach($programas_academicos as $pr_aca)
                                                    <option <?php if($pr_aca->id==$espacios_usuario[2]['id_programa_academico']) echo 'selected'?> value="{{$pr_aca->id}}">{{$pr_aca->programa_academico}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_programa_academico_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="cod_espacio_academico_3" id="cod_espacio_academico_3" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el código de la asignatura" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                            <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="{{$espacios_usuario[2]['codigo_espacio_academico']}}" class="form-control"
                                            onchange="searchEspaAca(this.value,3)"/>
                                        </div>
                                        <div class="col-md-7">
                                            <label for="espacio_academico_3" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                            
                                                <input type="text" name="espacio_academico_3" id="espacio_academico_3" value="{{$espacios_usuario[2]['espacio_academico']}}" class="form-control"
                                                readonly/>
                                        </div>
                                    </div>
                                    {{-- @endif        --}}

                                <!-- 6 Academico_3 -->

                                <!-- 6 Academico_4 -->
                                    {{-- @if($usuario->id_espacio_academico_4 != null) --}}
                                    <div class="form-group row" id="esp_aca_user_4_edit">
                                        <div class="col-md-3">
                                            <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_programa_academico_[]" id="id_programa_academico_4"  class="form-control" required onchange="searchEspaAca_2(4)">
                                                @foreach($programas_academicos as $pr_aca)
                                                <option <?php if($pr_aca->id==$espacios_usuario[3]['id_programa_academico']) echo 'selected'?> value="{{$pr_aca->id}}">{{$pr_aca->programa_academico}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_programa_academico_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="cod_espacio_academico_4" id="cod_espacio_academico_4" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el código de la asignatura" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="{{$espacios_usuario[3]['codigo_espacio_academico']}}" class="form-control"
                                            onchange="searchEspaAca(this.value,1)"/>
                                        </div>
                                        <div class="col-md-7">
                                            <label for="espacio_academico_1" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                                <input type="text" name="espacio_academico_4" id="espacio_academico_4" value="{{$espacios_usuario[3]['espacio_academico']}}" class="form-control" 
                                                readonly/>
                                        </div>
                                    </div>
                                    {{-- @endif       --}}

                                <!-- 6 Academico_4 -->
                                        
                                <!-- 6 Academico_5 -->
                                    {{-- @if($usuario->id_espacio_academico_5 != null) --}}
                                    <div class="form-group row"  id="esp_aca_user_5_edit">
                                        <div class="col-md-3">
                                            <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_programa_academico_[]" id="id_programa_academico_5"  class="form-control" required onchange="searchEspaAca_2(5)">
                                                @foreach($programas_academicos as $pr_aca)
                                                <option <?php if($pr_aca->id==$espacios_usuario[4]['id_programa_academico']) echo 'selected'?> value="{{$pr_aca->id}}">{{$pr_aca->programa_academico}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_programa_academico_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="cod_espacio_academico_5" id="cod_espacio_academico_5" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el código de la asignatura" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="{{$espacios_usuario[4]['codigo_espacio_academico']}}" class="form-control"
                                            onchange="searchEspaAca(this.value,1)"/>
                                        </div>
                                        <div class="col-md-7">
                                            <label for="espacio_academico_1" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                                <input type="text" name="espacio_academico_5" id="espacio_academico_5" value="{{$espacios_usuario[4]['espacio_academico']}}" class="form-control"
                                                readonly/>
                                        </div>
                                    </div>
                                    {{-- @endif      --}}
                                        
                                <!-- 6 Academico_5 -->

                                <!-- 6 Academico_6 -->
                                    {{-- @if($usuario->id_espacio_academico_6 != null) --}}
                                    <div class="form-group row"  id="esp_aca_user_6_edit">
                                        <div class="col-md-3">
                                            <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_programa_academico_[]" id="id_programa_academico_6"  class="form-control" required onchange="searchEspaAca_2(6)">
                                                @foreach($programas_academicos as $pr_aca)
                                                <option <?php if($pr_aca->id==$espacios_usuario[5]['id_programa_academico']) echo 'selected'?> value="{{$pr_aca->id}}">{{$pr_aca->programa_academico}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_programa_academico_[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="cod_espacio_academico_6" id="cod_espacio_academico_6" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el código de la asignatura" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="{{$espacios_usuario[5]['codigo_espacio_academico']}}" class="form-control"
                                            onchange="searchEspaAca(this.value,1)"/>
                                        </div>
                                        <div class="col-md-7">
                                            <label for="espacio_academico_1" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                            <span class="hs-form-required">*</span>
                                                <input type="text" name="espacio_academico_6" id="espacio_academico_6" value="{{$espacios_usuario[5]['espacio_academico']}}" class="form-control" 
                                                readonly/>
                                        </div>
                                    </div>
                                    {{-- @endif                --}}

                                <!-- 6 Academico_6 -->
                                
                                

                                <!-- 7 -->
                                    <div class="form-group row">

                                        <div class="col-md-3">
                                            <label for="password" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique una contraseña segura, con mínimo de 8 caracteres" style="font-size: 0.813rem"></i> {{ __('Contaseña') }}</label>
                                            <input id="password" type="password" title="teamo" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="nope">
            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                <!-- 7 -->

                            <!-- información cuenta -->

                            <!-- submit -->
                                <!-- 8 -->
                                    <div class="form-group row mb-0">
                                        <div class="col-md-5 offset-md-5">
                                            <br>
                                            <button type="submit" class="btn btn-success"  name="submit_reg_user" id="submit_reg_user">
                                                {{ __('Guardar') }}
                                            </button>
                                        </div>
                                    </div>
                                <!-- 8 -->
                            <!-- submit -->
                        </form>
                    </div>
                </div>

                            
            </div>
        </div>
         <br>
    </div>
</div>
        
@endsection   