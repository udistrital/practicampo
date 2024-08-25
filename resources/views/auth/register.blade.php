<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Registro Usuario') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                        <!-- información personal -->
                            <br>
                            <h4>Información Personal</h4>
                            <hr class="divider">
                            <br>

                            <!-- 1 -->
                                <div class="form-group row">
                                    {{-- <div class="col-md-1"></div> --}}

                                    
                                    <div class="col-md-3">
                                        <label for="primer_nombre" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el primer nombre" style="font-size: 0.813rem"></i> {{ __('Primer Nombre') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input id="primer_nombre" type="text" class="form-control @error('primer_nombre') is-invalid @enderror" name="primer_nombre" value="{{ old('primer_nombre') }}" required autocomplete="primer_nombre" autofocus>
        
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
                                        <input id="segundo_nombre" type="text" class="form-control @error('segundo_nombre') is-invalid @enderror" name="segundo_nombre" value="{{ old('segundo_nombre') }}" autocomplete="segundo_nombre" autofocus>
        
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
                                        <input id="primer_apellido" type="text" class="form-control @error('primer_apellido') is-invalid @enderror" name="primer_apellido" value="{{ old('primer_apellido') }}" required autocomplete="primer_apellido" autofocus>
        
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
                                        <input id="segundo_apellido" type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" name="segundo_apellido" value="{{ old('segundo_apellido') }}" autocomplete="segundo_apellido" autofocus>
        
                                        @error('segundo_apellido')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-md-1"></div> --}}
                                </div>
                            <!-- 1 -->

                            <!-- 2 -->
                                <div class="form-group row">
                                    
                                    <div class="col-md-3">
                                        <label for="id_tipo_identificacion" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Seleccione el tipo de identificación" style="font-size: 0.813rem"></i> {{ __('Tipo Identificación') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <select name="id_tipo_identificacion" class="form-control" required>
                                            @foreach($tipos_identificaciones as $tip_ident)
                                                <option value="{{$tip_ident->id}}" selected>{{$tip_ident->tipo_identificacion}}</option>  
                                            @endforeach
                                        </select>
                                        @error('id_tipo_identificacion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="num_identificacion" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el número de identificación" style="font-size: 0.813rem"></i> {{ __('N° Identificación') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input id="num_identificacion"  class="form-control @error('num_identificacion') is-invalid @enderror" name="num_identificacion" value="{{ old('num_identificacion') }}" required autocomplete="off" autofocus>
        
                                        @error('num_identificacion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="expedicion_identificacion" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el lugar de expedición del documento de identificación" style="font-size: 0.813rem"></i> {{ __('Lugar Expedición') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input id="expedicion_identificacion"  class="form-control @error('expedicion_identificacion') is-invalid @enderror" name="expedicion_identificacion" 
                                        value="{{ old('expedicion_identificacion') }}" required autocomplete="off" autofocus>
        
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
                                        <label for="email" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el correo electrónico institucional" style="font-size: 0.813rem"></i> {{ __('Correo Electrónico Institucional') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off"
                                        onchange="obtenerUsuario(this.value);">
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
                                        <input id="telefono"  class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" autocomplete="off">
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
                                            data-title="Indique un número de celular" style="font-size: 0.813rem"></i> {{ __('Celular') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input id="celular" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required autocomplete="off">
                                        
                                        @error('celular')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-md-2">
                                        <input id="cr" style="color:transparent;display:none" class="form-control" name="cr" autocomplete="off">
                                        
                                    </div> --}}

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
                                        <input id="usuario" type="text" class="form-control @error('usuario') is-invalid @enderror" name="usuario" value="{{ old('usuario') }}" required autocomplete="name" autofocus 
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
                                        <select name="id_role" class="form-control" required onchange="progr_aca_coord(this.value)">
                                            @foreach($tipos_usuarios as $tip_user)
                                                <option value="{{$tip_user->id}}" selected>{{$tip_user->role}}</option>
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
                                        {{-- <span class="hs-form-required">*</span> --}}
                                        <select name="id_programa_academico_coord" class="form-control" required id="id_programa_academico_coord" readonly disabled>
                                            @foreach($programas_academicos as $pr_aca)
                                                <option value="{{$pr_aca->id}}" selected>{{$pr_aca->programa_academico}}</option>  
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
                                            data-title="Seleccione el tipo de vinculación" style="font-size: 0.813rem"></i> {{ __('Vinculación') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <select name="id_tipo_vinculacion" class="form-control" required>
                                            @foreach($tipos_vinculaciones as $tv)
                                                <option value="{{$tv->id}}" selected>{{$tv->tipo_vinculacion}}</option>
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
                                        <input id="c_espa_aca_user" type="number" max="6" min="1" pattern="^[1-6]+" class="form-control @error('c_espa_aca_user') is-invalid @enderror" name="c_espa_aca_user" 
                                        title="Número de espacios académicos"
                                        value="1" autocomplete="off" autofocus onchange="">
                                        
                                        @error('c_espa_aca_user')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- cant prog academico-->

                            <!-- 5 Academico_1 -->
                                <div class="form-group row" id="esp_aca_user_1">
                                    <div class="col-md-3">
                                        <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <select name="id_programa_academico_[]" class="form-control" required id="id_programa_academico_1" onchange="searchEspaAca_2(1)">
                                            @foreach($programas_academicos as $pr_aca)
                                                <option value="{{$pr_aca->id}}" selected>{{$pr_aca->programa_academico}}</option>  
                                            @endforeach
                                        </select>
                                        @error('id_programa_academico_[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                    <div class="col-md-3">
                                        <label for="cod_espacio_academico_1" id="cod_espacio_academico_1" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el código de la asignatura. Para N/A es el 0" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="" class="form-control" required
                                        onchange="searchEspaAca(this.value,1)"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="espacio_academico_1" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                        
                                        <input type="text" name="espacio_academico_1" id="espacio_academico_1" value="" class="form-control" 
                                        readonly>
                                    </div>
                                </div>
                                
                            <!-- 5 Academico_1 -->

                            <!-- 5 Academico_2 -->
                                <div class="form-group row" id="esp_aca_user_2">
                                    <div class="col-md-3">
                                        <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <select name="id_programa_academico_[]" class="form-control"  id="id_programa_academico_2" onchange="searchEspaAca_2(2)">
                                            @foreach($programas_academicos as $pr_aca)
                                                <option value="{{$pr_aca->id}}" selected>{{$pr_aca->programa_academico}}</option>  
                                            @endforeach
                                        </select>
                                        @error('id_programa_academico_[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                    <div class="col-md-3" id="">
                                        <label for="cod_espacio_academico_2" id="cod_espacio_academico_2" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el código de la asignatura. Para N/A es el 0" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]"  value="" class="form-control"
                                        onchange="searchEspaAca(this.value,2)"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="espacio_academico_2" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                        
                                        <input type="text" name="espacio_academico_2" id="espacio_academico_2" value="" class="form-control" 
                                        readonly>
                                    </div>
                                </div>
                            <!-- 5 Academico_2 -->

                            <!-- 5 Academico_3 -->
                                <div class="form-group row" id="esp_aca_user_3">
                                    <div class="col-md-3">
                                        <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <select name="id_programa_academico_[]" class="form-control" id="id_programa_academico_3" onchange="searchEspaAca_2(3)">
                                            @foreach($programas_academicos as $pr_aca)
                                                <option value="{{$pr_aca->id}}" selected>{{$pr_aca->programa_academico}}</option>  
                                            @endforeach
                                        </select>
                                        @error('id_programa_academico_[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                    <div class="col-md-3" id="">
                                        <label for="cod_espacio_academico_3" id="cod_espacio_academico_3" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el código de la asignatura. Para N/A es el 0" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="" class="form-control"
                                        onchange="searchEspaAca(this.value,3)"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="espacio_academico_3" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                        
                                        <input type="text" name="espacio_academico_3" id="espacio_academico_3" value="" class="form-control" 
                                        readonly>
                                    </div>
                                </div>
                            <!-- 5 Academico_3 -->

                            <!-- 5 Academico_4 -->
                                <div class="form-group row" id="esp_aca_user_4">
                                    <div class="col-md-3">
                                        <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <select name="id_programa_academico_[]" class="form-control"  id="id_programa_academico_4" onchange="searchEspaAca_2(4)">
                                            @foreach($programas_academicos as $pr_aca)
                                                <option value="{{$pr_aca->id}}" selected>{{$pr_aca->programa_academico}}</option>  
                                            @endforeach
                                        </select>
                                        @error('id_programa_academico_[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                    <div class="col-md-3" id="">
                                        <label for="cod_espacio_academico_4" id="cod_espacio_academico_4" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el código de la asignatura. Para N/A es el 0" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="" class="form-control"
                                        onchange="searchEspaAca(this.value,4)"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="espacio_academico_1" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                        
                                        <input type="text" name="espacio_academico_4" id="espacio_academico_4" value="" class="form-control" 
                                        readonly>
                                    </div>
                                </div>
                            <!-- 5 Academico_4 -->

                            <!-- 5 Academico_5 -->
                                <div class="form-group row" id="esp_aca_user_5">
                                    <div class="col-md-3">
                                        <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <select name="id_programa_academico_[]" class="form-control"  id="id_programa_academico_5" onchange="searchEspaAca_2(5)">
                                            @foreach($programas_academicos as $pr_aca)
                                                <option value="{{$pr_aca->id}}" selected>{{$pr_aca->programa_academico}}</option>  
                                            @endforeach
                                        </select>
                                        @error('id_programa_academico_[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                    <div class="col-md-3" id="">
                                        <label for="cod_espacio_academico_5" id="cod_espacio_academico_5" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el código de la asignatura. Para N/A es el 0" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="" class="form-control"
                                        onchange="searchEspaAca(this.value,5)"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="espacio_academico_1" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                        
                                        <input type="text" name="espacio_academico_5" id="espacio_academico_5" value="" class="form-control" 
                                        readonly>
                                    </div>
                                </div>
                            <!-- 5 Academico_5 -->

                            <!-- 5 Academico_6 -->
                                <div class="form-group row" id="esp_aca_user_6">
                                    <div class="col-md-3">
                                        <label for="id_programa_academico_[]" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Seleccione el programa académico" style="font-size: 0.813rem"></i> {{ __('Prog. Académico') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <select name="id_programa_academico_[]" class="form-control"  id="id_programa_academico_6" onchange="searchEspaAca_2(6)">
                                            @foreach($programas_academicos as $pr_aca)
                                                <option value="{{$pr_aca->id}}" selected>{{$pr_aca->programa_academico}}</option>  
                                            @endforeach
                                        </select>
                                        @error('id_programa_academico_[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                    <div class="col-md-3" id="">
                                        <label for="cod_espacio_academico_6" id="cod_espacio_academico_6" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique el código de la asignatura. Para N/A es el 0" style="font-size: 0.813rem"></i> {{ __('Cod. Académ.') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input type="text" name="cod_espacio_academico_[]" id="cod_espacio_academico_[]" value="" class="form-control"
                                        onchange="searchEspaAca(this.value,6)"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="espacio_academico_6" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                        
                                        <input type="text" id="espacio_academico_6" name="espacio_academico_6"  value="" class="form-control" 
                                        readonly>
                                    </div>
                                </div>
                            <!-- 5 Academico_6 -->

                            

                            <!-- 6 -->
                                <div class="form-group row">

                                    <div class="col-md-3">
                                        <label for="password" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Indique una contraseña segura, con mínimo 8 caracteres" style="font-size: 0.813rem"></i> {{ __('Contaseña') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="nope">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="password-confirm" class="col-form-label text-md-right">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Confirme la contraseña" style="font-size: 0.813rem"></i> {{ __('Confirmar Constraseña') }}</label>
                                        <span class="hs-form-required">*</span>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="nope">
                                    </div>

                                </div>
                            <!-- 6 -->
                        <!-- información cuenta -->

                        <!-- submit -->
                            <!-- 7 -->
                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-5">
                                    <br>
                                    <button type="submit" class="btn btn-success" name="submit_reg_user" id="submit_reg_user" >
                                        {{ __('Registrar') }}
                                    </button>
                                </div>
                            </div>
                            <!-- 7 -->
                        <!-- submit -->

                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
        
    @endsection   