
<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                        <div class="card-header">{{ __('Informe No Conformidades Transporte Práctica Académica N° ') }}<?php echo $solicitud_practica->id?>
                        {{ __('') }}</div>
                    
                        <div class="card-body">
                            <form method="POST" action="{{route('encue_trans',[Crypt::encrypt($solicitud_practica->id)])}}">
                                @method('PUT')
                                @csrf
                                <!-- información proyección -->
                                    <!-- 1 -->
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="id_programa_academico" class="col-form-label text-md-right">{{ __('Programa Académico') }}</label>
                                                <select name="id_programa_academico" class="form-control" required disabled>
                                                    
                                                    @foreach($programas_usuario as $pro_aca)
                                                        <option <?php if($pro_aca['id']==$proyeccion_preliminar->id_programa_academico) echo 'selected'?> value="{{$pro_aca['id']}}">{{$pro_aca['programa_academico']}}</option>  
                                                    @endforeach
                                                </select>
                                                @error('id_programa_academico')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-5">
                                                <label for="id_espacio_academico" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                                                <select name="id_espacio_academico" class="form-control" required disabled>
                                                    @foreach($espacios_academicos as $esp_aca)
                                                        <option <?php if($esp_aca->id==$proyeccion_preliminar->id_espacio_academico) echo 'selected'?> value="{{$esp_aca->id}}">{{$esp_aca->espacio_academico}}</option>  
                                                        
                                                    @endforeach
                                                </select>
                                                @error('id_espacio_academico')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-1">
                                                <label for="id_periodo_academico" class="col-form-label text-md-right" title="Período Asignatura">{{ __('Per.') }}</label>
                                                <select name="id_periodo_academico" class="form-control" required disabled style="padding-left: 0.1rem;padding-right: 0.1rem;">
                                                    @foreach($periodos_academicos as $per_aca)
                                                        <option <?php if($per_aca->id==$proyeccion_preliminar->id_periodo_academico) echo 'selected'?> value="{{$per_aca->id}}">{{$per_aca->periodo_academico}}</option>  
                                                        
                                                    @endforeach
                                                </select>
                                                @error('id_periodo_academico')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                
                                            <div class="col-md-1">
                                                <label for="id_semestre_asignatura" class="col-form-label text-md-right">{{ __('Sem.') }}</label>
                                                <select name="id_semestre_asignatura" class="form-control" required disabled style="padding-left: 0.1rem;padding-right: 0.1rem;">
                                                    @foreach($semestres_asignaturas as $sem_asig)
                                                        <option <?php if($sem_asig->id==$proyeccion_preliminar->id_semestre_asignatura) echo 'selected' ?> value="{{$sem_asig->id}}">{{$sem_asig->semestre_asignatura}}</option>  
                                                        
                                                    @endforeach
                                                </select>
                                                @error('id_semestre_asignatura')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <!-- 1 -->

                                <!-- información proyección -->


                                @if($tipo_ruta == 1)
                                <br>
                                <h4>Ruta Principal (Destino para cumplir los objetivos de la práctica)</h4>
                                <hr class="divider">
                                <br>

                                <!-- ruta principal -->
                                    <!-- 3 -->
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="destino_rp" class="col-form-label text-md-left">{{ __('Destino Ruta Principal') }}</label>
                                                <input id="destino_rp" type="text" class="form-control @error('destino_rp') is-invalid @enderror" name="destino_rp" 
                                                value="{{$proyeccion_preliminar->destino_rp}}" required autocomplete="off" autofocus readonly>

                                                @error('destino_rp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Cant. URL -->
                                            <div class="col-md-2">
                                                <label for="cant_url_rp" class="col-form-label text-md-left">{{ __('Cant. URL') }}</label>
                                                <div class="input-group">
                                                    <input id="cant_url_rp" max="6" min="1" pattern="^[0-9]+" class="form-control @error('cant_url_rp') is-invalid @enderror" name="cant_url_rp" 
                                                    title="Cantidad de URL ruta principal"
                                                    value="{{$proyeccion_preliminar->cantidad_url_rp}}" autocomplete="off" autofocus readonly disabled>
                                                    
                                                    @error('cant_url_rp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                        
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success btn_ver" type="button" id="ver_rutas_rp" style="border: 1px solid #d1d3e2;border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                        onclick="ver_rp()"><i class="far fa-eye"></i></button>
                                                        <button class="btn btn-success btn_ver" type="button" id="ocul_rutas_rp" style="border: 1px solid #d1d3e2;border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                        onclick="ocul_rp()"><i class="far fa-eye-slash"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Cant. URL -->
                                        </div>
                                    <!-- 3 -->

                                    <!-- 4 -->
                                        <div class="form-group row" id="rp_url_edit">
                                            <div class="col-md-12" id="rp_url_1">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <label for="ruta_principal" class="col-form-label text-md-left">{{ __('URL Ruta') }}</label>
                                                                <div class="input-group">
                                                                    <input id="ruta_principal" type="text" class="form-control @error('ruta_principal') is-invalid @enderror" name="ruta_principal" 
                                                                    value="{{$proyeccion_preliminar->ruta_principal}}"  required autocomplete="off" autofocus readonly
                                                                    >
                                                            
                                                                    @error('ruta_principal')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_rp_1" name="btnVer_url_rp_1" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_rp(1)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="rp_url_2">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_principal_2" type="text" class="form-control @error('ruta_principal_2') is-invalid @enderror" name="ruta_principal_2" 
                                                                    value="{{$proyeccion_preliminar->ruta_principal_2}}"  required autocomplete="off" autofocus readonly
                                                                    >
                                                            
                                                                    @error('ruta_principal_2')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    
                                                                    <a id="btnVer_url_rp_2" name="btnVer_url_rp_2" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_rp(2)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="rp_url_3">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_principal_3" type="text" class="form-control @error('ruta_principal_3') is-invalid @enderror" name="ruta_principal_3" 
                                                                    value="{{$proyeccion_preliminar->ruta_principal_3}}"  required autocomplete="off" autofocus readonly
                                                                    >
                                                            
                                                                    @error('ruta_principal_3')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_rp_3" name="btnVer_url_rp_3" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_rp(3)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="rp_url_4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_principal_4" type="text" class="form-control @error('ruta_principal_4') is-invalid @enderror" name="ruta_principal_4" 
                                                                    value="{{$proyeccion_preliminar->ruta_principal_4}}"  required autocomplete="off" autofocus readonly
                                                                    >
                                                            
                                                                    @error('ruta_principal_4')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_rp_4" name="btnVer_url_rp_4" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_rp(4)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="rp_url_5">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_principal_5" type="text" class="form-control @error('ruta_principal_5') is-invalid @enderror" name="ruta_principal_5" 
                                                                    value="{{$proyeccion_preliminar->ruta_principal_5}}"  required autocomplete="off" autofocus readonly
                                                                    >
                                                            
                                                                    @error('ruta_principal_5')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_rp_5" name="btnVer_url_rp_5" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_rp(5)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="rp_url_6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_principal_6" type="text" class="form-control @error('ruta_principal_6') is-invalid @enderror" name="ruta_principal_6" 
                                                                    value="{{$proyeccion_preliminar->ruta_principal_6}}"  required autocomplete="off" autofocus readonly
                                                                    >
                                                            
                                                                    @error('ruta_principal_6')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_rp_6" name="btnVer_url_rp_6" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_rp(6)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- 4 -->

                                    <!-- 5 -->
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="det_recorrido_interno_rp" class="col-form-label text-md-left">{{ __('Detalle Recorrido') }}</label>
                                                <textarea id="det_recorrido_interno_rp" style="min-height:5rem;" type="text" class="form-control @error('det_recorrido_interno_rp') is-invalid @enderror" name="det_recorrido_interno_rp" 
                                                required autocomplete="off" autofocus readonly><?php echo $proyeccion_preliminar->det_recorrido_interno_rp?></textarea>
                                                
                                                @error('det_recorrido_interno_rp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <!-- 5 -->

                                    <!-- 6 -->
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="lugar_salida_rp" class="col-form-label text-md-left">{{ __('Punto Encuentro Salida') }}</label>
                                                <div class="input-group">
                                                    <select id="lugar_salida_rp" name="lugar_salida_rp" class="form-control" required disabled
                                                        title="Sedes Universidad" >
                                                        @foreach($sedes as $sede)
                                                            <option <?php if($sede->id==$proyeccion_preliminar->lugar_salida_rp) echo 'selected'?> value="{{$sede->id}}">{{$sede->sede}}</option>  
                                                        @endforeach
                                                    </select>
                                                    
                                                    @error('lugar_salida_rp')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="fecha_salida_aprox_rp" class="col-form-label text-md-left">{{ __('Fecha Salida') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                <input class="inputDate form-control datetimepicker" name="fecha_salida_aprox_rp" id="fecha_salida_aprox_rp" type="text" required
                                                value="{{$proyeccion_preliminar->fecha_salida_aprox_rp}}"  onchange="duracion_edit_RP(this.value)" readonly disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="lugar_regreso_rp" class="col-form-label text-md-left">{{ __('Punto Encuentro Regreso') }}</label>
                                                <div class="input-group">
                                                    <select id="lugar_regreso_rp" name="lugar_regreso_rp" class="form-control" required disabled
                                                        title="Sedes Universidad" >
                                                        @foreach($sedes as $sede)
                                                            <option <?php if($sede->id==$proyeccion_preliminar->lugar_regreso_rp) echo 'selected'?> value="{{$sede->id}}">{{$sede->sede}}</option>  
                                                        @endforeach
                                                    </select>
                                                    
                                                    @error('lugar_regreso_rp')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="fecha_regreso_aprox_rp" class="col-form-label text-md-left">{{ __('Fecha Regreso') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                <input class="inputDate form-control datetimepicker" name="fecha_regreso_aprox_rp" id="fecha_regreso_aprox_rp" type="text" required
                                                value="{{$proyeccion_preliminar->fecha_regreso_aprox_rp}}" onchange="duracion_edit_RP(this.value)" readonly disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="duracion_edit_rp" class="col-form-label text-md-left">{{ __('Duración Días') }}</label>
                                                <input id="duracion_edit_rp" type="text" class="form-control @error('duracion_edit_rp') is-invalid @enderror" name="duracion_edit_rp" 
                                                value="{{$proyeccion_preliminar->duracion_num_dias_rp}}" autocomplete="off" autofocus  readonly>
                                                
                                                @error('duracion_edit_rp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                    <!-- 6 -->

                                    @if($tipo_ruta == 1)

                                    <!-- 7 -->
                                        <div  class="form-group row">
                                            <div class="col-md-2">
                                                <label for="cant_transporte_rp_edit" class="col-form-label text-md-left">{{ __('Cant. Vehículos') }}</label>
                                                <div class="input-group">
                                                    <input id="cant_transporte_rp_edit" type="number" max="3" min="0" pattern="^[0-3]+"  class="form-control @error('cant_transporte_rp_edit') is-invalid @enderror" name="cant_transporte_rp_edit" 
                                                    title="Cantidad de vehiculos requeridos"
                                                    value="{{$transporte_proyeccion->cant_transporte_rp}}" required autocomplete="off" autofocus readonly disabled>
                                                    
                                                    @error('cant_transporte_rp_edit')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success btn_ver" type="button" id="ver_vehi" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                        onclick="ver_vehic()"><i class="far fa-eye"></i></button>
                                                        <button class="btn btn-success btn_ver" type="button" id="ocul_vehi" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                        onclick="ocul_vehic()"><i class="far fa-eye-slash"></i></button>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    <!-- 7 -->

                                    <!-- 8 transporte_rp_1 -->
                                        <div class="form-group row" id="transporte_rp_1_edit">
                                            <div class="col-md-12" id="transporte_rp">
                                                <div class="row" id="transporte_rp_children">
                                                    <div class="col-md-2">
                                                        <label for="id_tipo_transporte_rp_[]" class="col-form-label text-md-right">{{ __('Tipo Vehículo') }}</label>
                                                        <select name="id_tipo_transporte_rp_[]" class="form-control" required onchange="otroTransporte(this.value,1)" disabled>
                                                            @foreach($tipos_transportes as $tp_trans)
                                                                <option <?php if($tp_trans->id==$transporte_proyeccion->id_tipo_transporte_rp_1) echo 'selected'?> value="{{$tp_trans->id}}">{{$tp_trans->tipo_transporte}}</option>  

                                                            @endforeach
                                                        </select>
                                                        @error('id_tipo_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="capac_transporte_rp_[]" class="col-form-label text-md-left">{{ __('Cap. Vehíc.') }}</label>
                                                        <input id="capac_transporte_rp_[]" type="text" class="form-control @error('capac_transporte_rp_[]') is-invalid @enderror" name="capac_transporte_rp_[]" 
                                                        value="{{$transporte_proyeccion->capac_transporte_rp_1}}" required autocomplete="off" autofocus readonly>

                                                        @error('capac_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="det_tipo_transporte_rp_[]" class="col-form-label text-md-left">{{ __('Det. Vehíc.') }}</label>
                                                        <input id="det_tipo_transporte_rp_[]" type="text" class="form-control @error('det_tipo_transporte_rp_[]') is-invalid @enderror" name="det_tipo_transporte_rp_[]" 
                                                        value="{{$transporte_proyeccion->det_tipo_transporte_rp_1}}" autocomplete="off" autofocus readonly>

                                                        @error('det_tipo_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="exclusiv_tiempo_rp_1" class="col-form-label text-md-left">{{ __('Disponibilidad Permanente?') }}</label>
                                                            <div class="row">

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_1" value="1" 
                                                                    <?php if($transporte_proyeccion->exclusiv_tiempo_rp_1 == 1) echo 'checked'?> disabled>
                                                                    <label class="form-check-label" for="">Si</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_1"  value="0"
                                                                        <?php if($transporte_proyeccion->exclusiv_tiempo_rp_1 == 0) echo 'checked'?> disabled>
                                                                        <label class="form-check-label" for="">No</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="nombre_cond_vehi_1" class="col-form-label text-md-left">{{ __('Conductor Encargado 1') }}</label>
                                                        <input id="nombre_cond_vehi_1" type="text" class="form-control @error('nombre_cond_vehi_1') is-invalid @enderror" name="nombre_cond_vehi_1" 
                                                        title="Nombre 1er conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->nombre_conductor_vehi_1}}" required autocomplete="off" autofocus readonly>
                                                        
                                                        @error('nombre_cond_vehi_1')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="celular_cond_vehi_1" class="col-form-label text-md-left">{{ __('Cel. Conductor 1') }}</label>
                                                        <input id="celular_cond_vehi_1" type="text" class="form-control @error('celular_cond_vehi_1') is-invalid @enderror" name="celular_cond_vehi_1" 
                                                        title="Celular 1er conductor responsable del vehículo"
                                                        onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                        value="{{$solicitud_transporte->celular_conductor_vehi_1}}" required autocomplete="off" autofocus readonly>
                                                        
                                                        @error('celular_cond_vehi_1')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="email_cond_vehi_1" class="col-form-label text-md-left">{{ __('Email Conductor 1') }}</label>
                                                        <input id="email_cond_vehi_1" type="text" class="form-control @error('email_cond_vehi_1') is-invalid @enderror" name="email_cond_vehi_1" 
                                                        title="Email 1er conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->email_conductor_vehi_1}}" autocomplete="off" autofocus readonly>
                                                        
                                                        @error('email_cond_vehi_1')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="placa_vehi_1" class="col-form-label text-md-left">{{ __('Placa Vehí.') }}</label>
                                                        <input id="placa_vehi_1" type="text" class="form-control @error('placa_vehi_1') is-invalid @enderror" name="placa_vehi_1" 
                                                        title="Placa del vehículo"
                                                        value="{{$solicitud_transporte->placa_vehi_1}}" required autocomplete="off" autofocus readonly>
                                                        
                                                        @error('placa_vehi_1')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="nombre_cond_2_vehi_1" class="col-form-label text-md-left">{{ __('Conductor Encargado 2') }}</label>
                                                        <input id="nombre_cond_2_vehi_1" type="text" class="form-control @error('nombre_cond_2_vehi_1') is-invalid @enderror" name="nombre_cond_2_vehi_1" 
                                                        title="Nombre 2do conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->nombre_conductor_2_vehi_1}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('nombre_cond_2_vehi_1')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="celular_cond_2_vehi_1" class="col-form-label text-md-left">{{ __('Cel. Conductor 2') }}</label>
                                                        <input id="celular_cond_2_vehi_1" type="text" class="form-control @error('celular_cond_2_vehi_1') is-invalid @enderror" name="celular_cond_2_vehi_1" 
                                                        title="Celular 2do conductor responsable del vehículo"
                                                        onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                        value="{{$solicitud_transporte->celular_conductor_2_vehi_1}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('celular_cond_2_vehi_1')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="email_cond_2_vehi_1" class="col-form-label text-md-left">{{ __('Email Conductor 2') }}</label>
                                                        <input id="email_cond_2_vehi_1" type="text" class="form-control @error('email_cond_2_vehi_1') is-invalid @enderror" name="email_cond_2_vehi_1" 
                                                        title="Email 2do conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->email_conductor_2_vehi_1}}" required autocomplete="off" autofocus readonly>
                                                        
                                                        @error('email_cond_2_vehi_1')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <br>
                                                        <hr class="divider">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    <!-- 8 transporte_rp_1 -->

                                    <!-- 8 transporte_rp_2 -->
                                        <div class="form-group row" id="transporte_rp_2_edit">
                                            <div class="col-md-12" id="transporte_rp">
                                                <div class="row" id="transporte_rp_children">
                                                    <div class="col-md-2">
                                                        <label for="id_tipo_transporte_rp_[]" class="col-form-label text-md-right">{{ __('Tipo Vehículo') }}</label>
                                                        <select name="id_tipo_transporte_rp_[]" class="form-control" required onchange="otroTransporte(this.value,2)" disabled>
                                                            @foreach($tipos_transportes as $tp_trans)
                                                                <option <?php if($tp_trans->id==$transporte_proyeccion->id_tipo_transporte_rp_2) echo 'selected'?> value="{{$tp_trans->id}}">{{$tp_trans->tipo_transporte}}</option>  

                                                            @endforeach
                                                        </select>
                                                        @error('id_tipo_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="capac_transporte_rp_[]" class="col-form-label text-md-left">{{ __('Cap. Vehíc.') }}</label>
                                                        <input id="capac_transporte_rp_[]" type="text" class="form-control @error('capac_transporte_rp_[]') is-invalid @enderror" name="capac_transporte_rp_[]" 
                                                        value="{{$transporte_proyeccion->capac_transporte_rp_2}}" required autocomplete="off" autofocus readonly>

                                                        @error('capac_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="det_tipo_transporte_rp_[]" class="col-form-label text-md-left">{{ __('Det. Vehíc.') }}</label>
                                                        <input id="det_tipo_transporte_rp_[]" type="text" class="form-control @error('det_tipo_transporte_rp_[]') is-invalid @enderror" name="det_tipo_transporte_rp_[]" 
                                                        value="{{$transporte_proyeccion->det_tipo_transporte_rp_2}}" autocomplete="off" autofocus readonly>

                                                        @error('det_tipo_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="exclusiv_tiempo_rp_2" class="col-form-label text-md-left">{{ __('Disponibilidad Permanente?') }}</label>
                                                            <div class="row">

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_2" value="1" 
                                                                    <?php if($transporte_proyeccion->exclusiv_tiempo_rp_2 == 1) echo 'checked'?> disabled>
                                                                    <label class="form-check-label" for="">Si</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_2"  value="0"
                                                                        <?php if($transporte_proyeccion->exclusiv_tiempo_rp_2 == 0) echo 'checked'?> disabled>
                                                                        <label class="form-check-label" for="">No</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="nombre_cond_vehi_2" class="col-form-label text-md-left">{{ __('Conductor Encargado 1') }}</label>
                                                        <input id="nombre_cond_vehi_2" type="text" class="form-control @error('nombre_cond_vehi_2') is-invalid @enderror" name="nombre_cond_vehi_2" 
                                                        title="Nombre 1er conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->nombre_conductor_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('nombre_cond_vehi_2')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="celular_cond_vehi_2" class="col-form-label text-md-left">{{ __('Cel. Conductor 1') }}</label>
                                                        <input id="celular_cond_vehi_2" type="text" class="form-control @error('celular_cond_vehi_2') is-invalid @enderror" name="celular_cond_vehi_2" 
                                                        title="Celular 1er conductor responsable del vehículo"
                                                        onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                        value="{{$solicitud_transporte->celular_conductor_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('celular_cond_vehi_2')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="email_cond_vehi_2" class="col-form-label text-md-left">{{ __('Email Conductor 1') }}</label>
                                                        <input id="email_cond_vehi_2" type="text" class="form-control @error('email_cond_vehi_2') is-invalid @enderror" name="email_cond_vehi_2" 
                                                        title="Email 1er conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->email_conductor_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('email_cond_vehi_2')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="placa_vehi_2" class="col-form-label text-md-left">{{ __('Placa Vehí.') }}</label>
                                                        <input id="placa_vehi_2" type="text" class="form-control @error('placa_vehi_2') is-invalid @enderror" name="placa_vehi_2" 
                                                        title="Placa del vehículo"
                                                        value="{{$solicitud_transporte->placa_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('placa_vehi_2')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="nombre_cond_2_vehi_2" class="col-form-label text-md-left">{{ __('Conductor Encargado 2') }}</label>
                                                        <input id="nombre_cond_2_vehi_2" type="text" class="form-control @error('nombre_cond_2_vehi_2') is-invalid @enderror" name="nombre_cond_2_vehi_2" 
                                                        title="Nombre 2do conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->nombre_conductor_2_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('nombre_cond_2_vehi_2')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="celular_cond_2_vehi_2" class="col-form-label text-md-left">{{ __('Cel. Conductor 2') }}</label>
                                                        <input id="celular_cond_2_vehi_2" type="text" class="form-control @error('celular_cond_2_vehi_2') is-invalid @enderror" name="celular_cond_2_vehi_2" 
                                                        title="Celular 2do conductor responsable del vehículo"
                                                        onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                        value="{{$solicitud_transporte->celular_conductor_2_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('celular_cond_2_vehi_2')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="email_cond_2_vehi_2" class="col-form-label text-md-left">{{ __('Email Conductor 2') }}</label>
                                                        <input id="email_cond_2_vehi_2" type="text" class="form-control @error('email_cond_2_vehi_2') is-invalid @enderror" name="email_cond_2_vehi_2" 
                                                        title="Email 2do conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->email_conductor_2_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('email_cond_2_vehi_2')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <br>
                                                        <hr class="divider">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    <!-- 8 transporte_rp_2 -->

                                    <!-- 8 transporte_rp_3 -->
                                        <div class="form-group row" id="transporte_rp_3_edit">
                                            <div class="col-md-12" id="transporte_rp">
                                                <div class="row" id="transporte_rp_children">
                                                    <div class="col-md-2">
                                                        <label for="id_tipo_transporte_rp_[]" class="col-form-label text-md-right">{{ __('Tipo Vehículo') }}</label>
                                                        <select name="id_tipo_transporte_rp_[]" class="form-control" required onchange="otroTransporte(this.value,3)" disabled>
                                                            @foreach($tipos_transportes as $tp_trans)
                                                                <option <?php if($tp_trans->id==$transporte_proyeccion->id_tipo_transporte_rp_3) echo 'selected'?> value="{{$tp_trans->id}}">{{$tp_trans->tipo_transporte}}</option>  

                                                            @endforeach
                                                        </select>
                                                        @error('id_tipo_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="capac_transporte_rp_[]" class="col-form-label text-md-left">{{ __('Cap. Vehíc.') }}</label>
                                                        <input id="capac_transporte_rp_[]" type="text" class="form-control @error('capac_transporte_rp_[]') is-invalid @enderror" name="capac_transporte_rp_[]" 
                                                        value="{{$transporte_proyeccion->capac_transporte_rp_3}}" required autocomplete="off" autofocus readonly>

                                                        @error('capac_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="det_tipo_transporte_rp_[]" class="col-form-label text-md-left">{{ __('Det. Vehíc.') }}</label>
                                                        <input id="det_tipo_transporte_rp_[]" type="text" class="form-control @error('det_tipo_transporte_rp_[]') is-invalid @enderror" name="det_tipo_transporte_rp_[]" 
                                                        value="{{$transporte_proyeccion->det_tipo_transporte_rp_3}}" autocomplete="off" autofocus readonly>

                                                        @error('det_tipo_transporte_rp_[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="exclusiv_tiempo_rp_3" class="col-form-label text-md-left">{{ __('Disponibilidad Permanente?') }}</label>
                                                            <div class="row">

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_3" value="1" 
                                                                    <?php if($transporte_proyeccion->exclusiv_tiempo_rp_3 == 1) echo 'checked'?> disabled>
                                                                    <label class="form-check-label" for="">Si</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="exclusiv_tiempo_rp_3"  value="0"
                                                                        <?php if($transporte_proyeccion->exclusiv_tiempo_rp_3 == 0) echo 'checked'?> disabled>
                                                                        <label class="form-check-label" for="">No</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="nombre_cond_vehi_3" class="col-form-label text-md-left">{{ __('Conductor Encargado 1') }}</label>
                                                        <input id="nombre_cond_vehi_3" type="text" class="form-control @error('nombre_cond_vehi_3') is-invalid @enderror" name="nombre_cond_vehi_3" 
                                                        title="Nombre 1er conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->nombre_conductor_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('nombre_cond_vehi_3')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                            
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="celular_cond_vehi_3" class="col-form-label text-md-left">{{ __('Cel. Conductor 1') }}</label>
                                                        <input id="celular_cond_vehi_3" type="text" class="form-control @error('celular_cond_vehi_3') is-invalid @enderror" name="celular_cond_vehi_3" 
                                                        title="Celular 1er conductor responsable del vehículo"
                                                        onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                        value="{{$solicitud_transporte->celular_conductor_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('celular_cond_vehi_3')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                            
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="email_cond_vehi_3" class="col-form-label text-md-left">{{ __('Email Conductor 1') }}</label>
                                                        <input id="email_cond_vehi_3" type="text" class="form-control @error('email_cond_vehi_3') is-invalid @enderror" name="email_cond_vehi_3" 
                                                        title="Email 1er conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->email_conductor_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('nombre_cond_vehi_3')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                            
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="placa_vehi_3" class="col-form-label text-md-left">{{ __('Placa Vehí.') }}</label>
                                                        <input id="placa_vehi_3" type="text" class="form-control @error('placa_vehi_3') is-invalid @enderror" name="placa_vehi_3" 
                                                        title="Placa del vehículo"
                                                        value="{{$solicitud_transporte->placa_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('placa_vehi_3')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="nombre_cond_2_vehi_3" class="col-form-label text-md-left">{{ __('Conductor Encargado 2') }}</label>
                                                        <input id="nombre_cond_2_vehi_3" type="text" class="form-control @error('nombre_cond_2_vehi_3') is-invalid @enderror" name="nombre_cond_2_vehi_3" 
                                                        title="Nombre 2do conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->nombre_conductor_2_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('nombre_cond_2_vehi_3')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                            
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label for="celular_cond_2_vehi_3" class="col-form-label text-md-left">{{ __('Cel. Conductor 2') }}</label>
                                                        <input id="celular_cond_2_vehi_3" type="text" class="form-control @error('celular_cond_2_vehi_3') is-invalid @enderror" name="celular_cond_2_vehi_3" 
                                                        title="Celular 2do conductor responsable del vehículo"
                                                        onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                        value="{{$solicitud_transporte->celular_conductor_2_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('celular_cond_2_vehi_3')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                            
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label for="email_cond_2_vehi_3" class="col-form-label text-md-left">{{ __('Email Conductor 2') }}</label>
                                                        <input id="email_cond_2_vehi_3" type="text" class="form-control @error('email_cond_2_vehi_3') is-invalid @enderror" name="email_cond_2_vehi_3" 
                                                        title="Email 2do conductor responsable del vehículo"
                                                        value="{{$solicitud_transporte->email_conductor_2_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                        
                                                        @error('email_cond_2_vehi_3')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    <!-- 8 transporte_rp_3 -->
                                    @endif

                                <!-- ruta principal -->
                                @endif

                                @if($tipo_ruta == 2)
                                <br>
                                <h4>Ruta Contingencia (Destino para cumplir propósitos de práctica pero por fallas en la vía, clima o demás se adopta como ruta principal de destino)</h4>
                                <hr class="divider">
                                <br>

                                <!-- ruta alterna -->
                                    <!-- 9 -->
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="destino_ra" class="col-form-label text-md-left">{{ __('Destino Ruta Contingencia') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <input id="destino_ra" type="text" class="form-control @error('destino_ra') is-invalid @enderror" name="destino_ra" 
                                                value="{{$proyeccion_preliminar->destino_ra}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('destino_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Cant. URL -->
                                            <div class="col-md-2">
                                                <label for="cant_url_ra" class="col-form-label text-md-left">{{ __('Cant. URL') }}</label>
                                                <div class="input-group">
                                                    <input id="cant_url_ra" max="6" min="1" pattern="^[0-9]+" class="form-control @error('cant_url_ra') is-invalid @enderror" name="cant_url_ra" 
                                                    title="Cantidad de URL ruta principal"
                                                    value="1" autocomplete="off" autofocus required readonly disabled>
                                                    
                                                    @error('cant_url_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success btn_ver" type="button" id="ver_rutas_ra" style="border: 1px solid #d1d3e2;border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                        onclick="ver_ra()"><i class="far fa-eye"></i></button>
                                                        <button class="btn btn-success btn_ver" type="button" id="ocul_rutas_ra" style="border: 1px solid #d1d3e2;border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                        onclick="ocul_ra()"><i class="far fa-eye-slash"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Cant. URL -->
                                        </div>
                                    <!-- 9 -->
                                    
                                    <!-- 10 -->
                                        <div class="form-group row" id="ra_url_edit">
                                            <div class="col-md-12" id="ra_url_1">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <label for="ruta_alterna" class="col-form-label text-md-left">{{ __('URL Ruta') }}</label>
                                                                <div class="input-group">
                                                                    <input id="ruta_alterna" type="text" class="form-control @error('ruta_alterna') is-invalid @enderror" name="ruta_alterna" 
                                                                    title="URL tomada de google maps" onchange="verifUrl_ra(this)"
                                                                    value="{{$proyeccion_preliminar->ruta_alterna}}"  required autocomplete="off" autofocus readonly>
                                                            
                                                                    @error('ruta_alterna')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_ra_1" name="btnVer_url_ra_1" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_ra(1)">IR</a>
                                                                </div>
                                                            </div>
                                                        {{-- <div class="col-md-1"> --}}
                                                        {{-- </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="ra_url_2">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_alterna_2" type="text" class="form-control @error('ruta_alterna_2') is-invalid @enderror" name="ruta_alterna_2" 
                                                                    value="{{$proyeccion_preliminar->ruta_alterna_2}}"  required autocomplete="off" autofocus
                                                                    title="URL tomada de google maps" onchange="verifUrl_ra(this)"
                                                                    readonly>
                                                            
                                                                    @error('ruta_alterna_2')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_ra_2" name="btnVer_url_ra_2" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_ra(2)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="ra_url_3">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_alterna_3" type="text" class="form-control @error('ruta_alterna_3') is-invalid @enderror" name="ruta_alterna_3" 
                                                                    value="{{$proyeccion_preliminar->ruta_alterna_3}}"  required autocomplete="off" autofocus
                                                                    title="URL tomada de google maps" onchange="verifUrl_ra(this)"
                                                                    readonly>
                                                            
                                                                    @error('ruta_alterna_3')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_ra_3" name="btnVer_url_ra_3" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_ra(3)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="ra_url_4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_alterna_4" type="text" class="form-control @error('ruta_alterna_4') is-invalid @enderror" name="ruta_alterna_4" 
                                                                    value="{{$proyeccion_preliminar->ruta_alterna_4}}"  required autocomplete="off" autofocus
                                                                    title="URL tomada de google maps" onchange="verifUrl_ra(this)"
                                                                    readonly>
                                                            
                                                                    @error('ruta_alterna_4')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_ra_4" name="btnVer_url_ra_4" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_ra(4)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="ra_url_5">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_alterna_5" type="text" class="form-control @error('ruta_alterna_5') is-invalid @enderror" name="ruta_alterna_5" 
                                                                    value="{{$proyeccion_preliminar->ruta_alterna_5}}"  required autocomplete="off" autofocus
                                                                    title="URL tomada de google maps" onchange="verifUrl_ra(this)"
                                                                    readonly>
                                                            
                                                                    @error('ruta_alterna_5')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_ra_5" name="btnVer_url_ra_5" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_ra(5)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="ra_url_6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                                                                <div class="input-group">
                                                                    <input id="ruta_alterna_6" type="text" class="form-control @error('ruta_alterna_6') is-invalid @enderror" name="ruta_alterna_6" 
                                                                    value="{{$proyeccion_preliminar->ruta_alterna_6}}"  required autocomplete="off" autofocus
                                                                    title="URL tomada de google maps" onchange="verifUrl_ra(this)"
                                                                    readonly>
                                                            
                                                                    @error('ruta_alterna_6')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <a id="btnVer_url_ra_6" name="btnVer_url_ra_6" class="btn btn-success" style="color: #fff; border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                                    target="_blank"
                                                                    onclick="ir_ra(6)">IR</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- 10 -->

                                    <!-- 11 -->
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="det_recorrido_interno_ra" class="col-form-label text-md-left">{{ __('Detalle Recorrido') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="det_recorrido_interno_ra" style="min-height:5rem;" type="text" class="form-control @error('det_recorrido_interno_ra') is-invalid @enderror" name="det_recorrido_interno_ra" 
                                                required autocomplete="off" autofocus readonly><?php echo $proyeccion_preliminar->det_recorrido_interno_ra?></textarea>
                                                
                                                @error('det_recorrido_interno_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <!-- 11 -->

                                    <!-- 12 -->
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="lugar_salida_ra" class="col-form-label text-md-left">{{ __('Punto Encuentro Salida') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <div class="input-group">
                                                    <select id="lugar_salida_ra" name="lugar_salida_ra" class="form-control" required disabled
                                                        title="Sedes Universidad" >
                                                        @foreach($sedes as $sede)
                                                            <option <?php if($sede->id==$proyeccion_preliminar->lugar_salida_ra) echo 'selected'?> value="{{$sede->id}}">{{$sede->sede}}</option>  
                                                        @endforeach
                                                    </select>
                                                    
                                                    @error('lugar_salida_ra')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="fecha_salida_aprox_ra" class="col-form-label text-md-left">{{ __('Fecha Salida') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                <input class="inputDate form-control datetimepicker" name="fecha_salida_aprox_ra" id="fecha_salida_aprox_ra" type="text" required
                                                value="{{$proyeccion_preliminar->fecha_salida_aprox_ra}}" onchange="duracion_edit_RA(this.value)" readonly disabled> 
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="lugar_regreso_ra" class="col-form-label text-md-left">{{ __('Punto Encuentro Regreso') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <div class="input-group">
                                                    <select id="lugar_regreso_ra" name="lugar_regreso_ra" class="form-control" required disabled
                                                        title="Sedes Universidad" >
                                                        @foreach($sedes as $sede)
                                                            <option <?php if($sede->id==$proyeccion_preliminar->lugar_regreso_ra) echo 'selected'?> value="{{$sede->id}}">{{$sede->sede}}</option>  
                                                        @endforeach
                                                    </select>
                                                    
                                                    @error('lugar_regreso_ra')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="fecha_regreso_aprox_ra" class="col-form-label text-md-left">{{ __('Fecha Regreso') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                <input class="inputDate form-control datetimepicker" name="fecha_regreso_aprox_ra" id="fecha_regreso_aprox_ra" type="text" required
                                                value="{{$proyeccion_preliminar->fecha_regreso_aprox_ra}}" readonly  onchange="duracion_edit_RA(this.value)" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="duracion_edit_ra" class="col-form-label text-md-left">{{ __('Duración Días') }}</label>
                                                {{-- <span class="hs-form-required">*</span> --}}
                                                <input id="duracion_edit_ra" type="text" class="form-control @error('duracion_edit_ra') is-invalid @enderror" name="duracion_edit_ra" 
                                                value="{{$proyeccion_preliminar->duracion_num_dias_ra}}" autocomplete="off" autofocus  readonly>
                                                
                                                @error('duracion_edit_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                    <!-- 12 -->

                                    <!-- descripción actividades -->
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="desc_actividades_ra" class="col-form-label text-md-left">{{ __('Descripción de las actividades ejecutadas e identificación de resultados') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="desc_actividades_ra" style="min-height:5rem;" type="text" class="form-control @error('desc_actividades_ra') is-invalid @enderror" name="desc_actividades_ra" 
                                                required autocomplete="off" autofocus ></textarea>
                                                
                                                @error('desc_actividades_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <!-- descripción actividades -->

                                    <!-- recomendaciones -->
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="recomendaciones_ra" class="col-form-label text-md-left">{{ __('Recomendaciones') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="recomendaciones_ra" style="min-height:5rem;" type="text" class="form-control @error('recomendaciones_ra') is-invalid @enderror" name="recomendaciones_ra" 
                                                required autocomplete="off" autofocus ></textarea>
                                                
                                                @error('recomendaciones_ra')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <!-- recomendaciones -->

                                    @if($tipo_ruta == 2)

                                    <!-- 13 -->
                                        <div  class="form-group row">
                                            <div class="col-md-2">
                                                <label for="cant_transporte_ra_edit" class="col-form-label text-md-left">{{ __('Cant. Vehículos') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <div class="input-group">
                                                    <input id="cant_transporte_ra_edit" type="number" max="3" min="0" pattern="^[0-3]+"  class="form-control @error('cant_transporte_ra_edit') is-invalid @enderror" name="cant_transporte_ra_edit" 
                                                    title="Cantidad de vehiculos requeridos"
                                                    value="{{$transporte_proyeccion->cant_transporte_ra}}" required autocomplete="off" autofocus readonly disabled>
                                                    
                                                    @error('cant_transporte_ra_edit')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success btn_ver" type="button" id="ver_vehi_ra" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                        onclick="ver_vehic_ra()"><i class="far fa-eye"></i></button>
                                                        <button class="btn btn-success btn_ver" type="button" id="ocul_vehi_ra" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                                                        onclick="ocul_vehic_ra()"><i class="far fa-eye-slash"></i></button>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    <!-- 13 -->

                                    <!-- 14 transporte_ra_1 -->
                                        <div class="form-group row" id="transporte_ra_1_edit">
                                            <div class="col-md-2">
                                                <label for="id_tipo_transporte_ra_[]" class="col-form-label text-md-right">{{ __('Tipo Vehículo') }}</label>
                                                <select name="id_tipo_transporte_ra_[]" class="form-control" required disabled>
                                                    @foreach($tipos_transportes as $tp_trans)
                                                        <option <?php if ($tp_trans->id==$transporte_proyeccion->id_tipo_transporte_ra_1) echo 'selected'?> value="{{$tp_trans->id}}" >{{$tp_trans->tipo_transporte}}</option>  
                                                        
                                                    @endforeach
                                                </select>
                                                @error('id_tipo_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-2">
                                                <label for="capac_transporte_ra_[]" class="col-form-label text-md-left">{{ __('Cap. Vehíc.') }}</label>
                                                <input id="capac_transporte_ra_[]" type="text" class="form-control @error('capac_transporte_ra_[]') is-invalid @enderror" name="capac_transporte_ra_[]" 
                                                value="{{$transporte_proyeccion->capac_transporte_ra_1}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('capac_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="det_tipo_transporte_ra_[]" class="col-form-label text-md-left">{{ __('Det. Vehíc.') }}</label>
                                                <input id="det_tipo_transporte_ra_[]" type="text" class="form-control @error('det_tipo_transporte_ra_[]') is-invalid @enderror" name="det_tipo_transporte_ra_[]" 
                                                value="{{$transporte_proyeccion->det_tipo_transporte_ra_1}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('det_tipo_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exclusiv_tiempo_ra_1" class="col-form-label text-md-left">{{ __('Disponibilidad Permanente?') }}</label>
                                                    <div class="row">

                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_1" value="1" 
                                                            <?php if($transporte_proyeccion->exclusiv_tiempo_ra_1 == 1) echo 'checked'?> disabled>
                                                            <label class="form-check-label" for="">Si</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_1"  value="0"
                                                                <?php if($transporte_proyeccion->exclusiv_tiempo_ra_1 == 0) echo 'checked'?> disabled>
                                                                <label class="form-check-label" for="">No</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="nombre_cond_vehi_1" class="col-form-label text-md-left">{{ __('Conductor Encargado 1') }}</label>
                                                <input id="nombre_cond_vehi_1" type="text" class="form-control @error('nombre_cond_vehi_1') is-invalid @enderror" name="nombre_cond_vehi_1" 
                                                title="Nombre 1er conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->nombre_conductor_vehi_1}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('nombre_cond_vehi_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="celular_cond_vehi_1" class="col-form-label text-md-left">{{ __('Cel. Conductor 1') }}</label>
                                                <input id="celular_cond_vehi_1" type="text" class="form-control @error('celular_cond_vehi_1') is-invalid @enderror" name="celular_cond_vehi_1" 
                                                title="Celular 1er conductor responsable del vehículo"
                                                onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                value="{{$solicitud_transporte->celular_conductor_vehi_1}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('celular_cond_vehi_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="email_cond_vehi_1" class="col-form-label text-md-left">{{ __('Email Conductor 1') }}</label>
                                                <input id="email_cond_vehi_1" type="text" class="form-control @error('email_cond_vehi_1') is-invalid @enderror" name="email_cond_vehi_1" 
                                                title="Email 1er conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->email_conductor_vehi_1}}" autocomplete="off" autofocus readonly>
                                                
                                                @error('email_cond_vehi_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="placa_vehi_1" class="col-form-label text-md-left">{{ __('Placa Vehí.') }}</label>
                                                <input id="placa_vehi_1" type="text" class="form-control @error('placa_vehi_1') is-invalid @enderror" name="placa_vehi_1" 
                                                title="Placa del vehículo"
                                                value="{{$solicitud_transporte->placa_vehi_1}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('placa_vehi_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="nombre_cond_2_vehi_1" class="col-form-label text-md-left">{{ __('Conductor Encargado 2') }}</label>
                                                <input id="nombre_cond_2_vehi_1" type="text" class="form-control @error('nombre_cond_2_vehi_1') is-invalid @enderror" name="nombre_cond_2_vehi_1" 
                                                title="Nombre 2do conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->nombre_conductor_2_vehi_1}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('nombre_cond_2_vehi_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="celular_cond_2_vehi_1" class="col-form-label text-md-left">{{ __('Cel. Conductor 2') }}</label>
                                                <input id="celular_cond_2_vehi_1" type="text" class="form-control @error('celular_cond_2_vehi_1') is-invalid @enderror" name="celular_cond_2_vehi_1" 
                                                title="Celular 2do conductor responsable del vehículo"
                                                onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                value="{{$solicitud_transporte->celular_conductor_2_vehi_1}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('celular_cond_2_vehi_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="email_cond_2_vehi_1" class="col-form-label text-md-left">{{ __('Email Conductor 2') }}</label>
                                                <input id="email_cond_2_vehi_1" type="text" class="form-control @error('email_cond_2_vehi_1') is-invalid @enderror" name="email_cond_2_vehi_1" 
                                                title="Email 2do conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->email_conductor_2_vehi_1}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('email_cond_2_vehi_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <br>
                                                <hr class="divider">
                                            </div>
                                        </div>
                                    <!-- 14 transporte_ra_1 -->

                                    <!-- 14 transporte_ra_2 -->
                                        <div class="form-group row" id="transporte_ra_2_edit">
                                            <div class="col-md-2">
                                                <label for="id_tipo_transporte_ra_[]" class="col-form-label text-md-right">{{ __('Tipo Vehículo') }}</label>
                                                <select name="id_tipo_transporte_ra_[]" class="form-control" required disabled>
                                                    @foreach($tipos_transportes as $tp_trans)
                                                        <option <?php if ($tp_trans->id==$transporte_proyeccion->id_tipo_transporte_ra_2) echo 'selected'?> value="{{$tp_trans->id}}" >{{$tp_trans->tipo_transporte}}</option>  
                                                        
                                                    @endforeach
                                                </select>
                                                @error('id_tipo_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-2">
                                                <label for="capac_transporte_ra_[]" class="col-form-label text-md-left">{{ __('Cap. Vehíc.') }}</label>
                                                <input id="capac_transporte_ra_[]" type="text" class="form-control @error('capac_transporte_ra_[]') is-invalid @enderror" name="capac_transporte_ra_[]" 
                                                value="{{$transporte_proyeccion->capac_transporte_ra_2}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('capac_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="det_tipo_transporte_ra_[]" class="col-form-label text-md-left">{{ __('Det. Vehíc.') }}</label>
                                                <input id="det_tipo_transporte_ra_[]" type="text" class="form-control @error('det_tipo_transporte_ra_[]') is-invalid @enderror" name="det_tipo_transporte_ra_[]" 
                                                value="{{$transporte_proyeccion->det_tipo_transporte_ra_2}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('det_tipo_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exclusiv_tiempo_ra_2" class="col-form-label text-md-left">{{ __('Disponibilidad Permanente?') }}</label>
                                                    <div class="row">

                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_2" value="1" 
                                                            <?php if($transporte_proyeccion->exclusiv_tiempo_ra_2 == 1) echo 'checked'?> disabled>
                                                            <label class="form-check-label" for="">Si</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_2"  value="0"
                                                                <?php if($transporte_proyeccion->exclusiv_tiempo_ra_2 == 0) echo 'checked'?> disabled>
                                                                <label class="form-check-label" for="">No</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="nombre_cond_vehi_2" class="col-form-label text-md-left">{{ __('Conductor Encargado 1') }}</label>
                                                <input id="nombre_cond_vehi_2" type="text" class="form-control @error('nombre_cond_vehi_2') is-invalid @enderror" name="nombre_cond_vehi_2" 
                                                title="Nombre 1er conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->nombre_conductor_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('nombre_cond_vehi_2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="celular_cond_vehi_2" class="col-form-label text-md-left">{{ __('Cel. Conductor 1') }}</label>
                                                <input id="celular_cond_vehi_2" type="text" class="form-control @error('celular_cond_vehi_2') is-invalid @enderror" name="celular_cond_vehi_2" 
                                                title="Celular 1er conductor responsable del vehículo"
                                                onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                value="{{$solicitud_transporte->celular_conductor_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('celular_cond_vehi_2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="email_cond_vehi_2" class="col-form-label text-md-left">{{ __('Email Conductor 1') }}</label>
                                                <input id="email_cond_vehi_2" type="text" class="form-control @error('email_cond_vehi_2') is-invalid @enderror" name="email_cond_vehi_2" 
                                                title="Email 1er conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->email_conductor_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('email_cond_vehi_2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="placa_vehi_2" class="col-form-label text-md-left">{{ __('Placa Vehí.') }}</label>
                                                <input id="placa_vehi_2" type="text" class="form-control @error('placa_vehi_2') is-invalid @enderror" name="placa_vehi_2" 
                                                title="Placa del vehículo"
                                                value="{{$solicitud_transporte->placa_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('placa_vehi_2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="nombre_cond_2_vehi_2" class="col-form-label text-md-left">{{ __('Conductor Encargado 2') }}</label>
                                                <input id="nombre_cond_2_vehi_2" type="text" class="form-control @error('nombre_cond_2_vehi_2') is-invalid @enderror" name="nombre_cond_2_vehi_2" 
                                                title="Nombre 2do conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->nombre_conductor_2_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('nombre_cond_2_vehi_2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="celular_cond_2_vehi_2" class="col-form-label text-md-left">{{ __('Cel. Conductor 2') }}</label>
                                                <input id="celular_cond_2_vehi_2" type="text" class="form-control @error('celular_cond_2_vehi_2') is-invalid @enderror" name="celular_cond_2_vehi_2" 
                                                title="Celular 2do conductor responsable del vehículo"
                                                onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                value="{{$solicitud_transporte->celular_conductor_2_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('celular_cond_2_vehi_2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="email_cond_2_vehi_2" class="col-form-label text-md-left">{{ __('Email Conductor 2') }}</label>
                                                <input id="email_cond_2_vehi_2" type="text" class="form-control @error('email_cond_2_vehi_2') is-invalid @enderror" name="email_cond_2_vehi_2" 
                                                title="Email 2do conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->email_conductor_2_vehi_2}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('email_cond_2_vehi_2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <br>
                                                <hr class="divider">
                                            </div>
                                        </div>
                                    <!-- 14 transporte_ra_2 -->

                                    <!-- 14 transporte_ra_3 -->
                                        <div class="form-group row" id="transporte_ra_3_edit">
                                            <div class="col-md-2">
                                                <label for="id_tipo_transporte_ra_[]" class="col-form-label text-md-right">{{ __('Tipo Vehículo') }}</label>
                                                <select name="id_tipo_transporte_ra_[]" class="form-control" required disabled>
                                                    @foreach($tipos_transportes as $tp_trans)
                                                        <option <?php if ($tp_trans->id==$transporte_proyeccion->id_tipo_transporte_ra_3) echo 'selected'?> value="{{$tp_trans->id}}" >{{$tp_trans->tipo_transporte}}</option>  
                                                        
                                                    @endforeach
                                                </select>
                                                @error('id_tipo_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-2">
                                                <label for="capac_transporte_ra_[]" class="col-form-label text-md-left">{{ __('Cap. Vehíc.') }}</label>
                                                <input id="capac_transporte_ra_[]" type="text" class="form-control @error('capac_transporte_ra_[]') is-invalid @enderror" name="capac_transporte_ra_[]" 
                                                value="{{$transporte_proyeccion->capac_transporte_ra_3}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('capac_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="det_tipo_transporte_ra_[]" class="col-form-label text-md-left">{{ __('Det. Vehíc.') }}</label>
                                                <input id="det_tipo_transporte_ra_[]" type="text" class="form-control @error('det_tipo_transporte_ra_[]') is-invalid @enderror" name="det_tipo_transporte_ra_[]" 
                                                value="{{$transporte_proyeccion->det_tipo_transporte_ra_3}}" required autocomplete="off" autofocus readonly>
                                                
                                                @error('det_tipo_transporte_ra_[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exclusiv_tiempo_ra_3" class="col-form-label text-md-left">{{ __('Disponibilidad Permanente?') }}</label>
                                                    <div class="row">

                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_3" value="1" 
                                                            <?php if($transporte_proyeccion->exclusiv_tiempo_ra_3 == 1) echo 'checked'?> disabled>
                                                            <label class="form-check-label" for="">Si</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="exclusiv_tiempo_ra_3"  value="0"
                                                                <?php if($transporte_proyeccion->exclusiv_tiempo_ra_3 == 0) echo 'checked'?> disabled>
                                                                <label class="form-check-label" for="">No</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="nombre_cond_vehi_3" class="col-form-label text-md-left">{{ __('Conductor Encargado 1') }}</label>
                                                <input id="nombre_cond_vehi_3" type="text" class="form-control @error('nombre_cond_vehi_3') is-invalid @enderror" name="nombre_cond_vehi_3" 
                                                title="Nombre 1er conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->nombre_conductor_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('nombre_cond_vehi_3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="celular_cond_vehi_3" class="col-form-label text-md-left">{{ __('Cel. Conductor 1') }}</label>
                                                <input id="celular_cond_vehi_3" type="text" class="form-control @error('celular_cond_vehi_3') is-invalid @enderror" name="celular_cond_vehi_3" 
                                                title="Celular 1er conductor responsable del vehículo"
                                                onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                value="{{$solicitud_transporte->celular_conductor_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('celular_cond_vehi_3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="email_cond_vehi_3" class="col-form-label text-md-left">{{ __('Email Conductor 1') }}</label>
                                                <input id="email_cond_vehi_3" type="text" class="form-control @error('email_cond_vehi_3') is-invalid @enderror" name="email_cond_vehi_3" 
                                                title="Email 1er conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->email_conductor_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('nombre_cond_vehi_3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="placa_vehi_3" class="col-form-label text-md-left">{{ __('Placa Vehí.') }}</label>
                                                <input id="placa_vehi_3" type="text" class="form-control @error('placa_vehi_3') is-invalid @enderror" name="placa_vehi_3" 
                                                title="Placa del vehículo"
                                                value="{{$solicitud_transporte->placa_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('placa_vehi_3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="nombre_cond_2_vehi_3" class="col-form-label text-md-left">{{ __('Conductor Encargado 2') }}</label>
                                                <input id="nombre_cond_2_vehi_3" type="text" class="form-control @error('nombre_cond_2_vehi_3') is-invalid @enderror" name="nombre_cond_2_vehi_3" 
                                                title="Nombre 2do conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->nombre_conductor_2_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('nombre_cond_2_vehi_3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <label for="celular_cond_2_vehi_3" class="col-form-label text-md-left">{{ __('Cel. Conductor 2') }}</label>
                                                <input id="celular_cond_2_vehi_3" type="text" class="form-control @error('celular_cond_2_vehi_3') is-invalid @enderror" name="celular_cond_2_vehi_3" 
                                                title="Celular 2do conductor responsable del vehículo"
                                                onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                                value="{{$solicitud_transporte->celular_conductor_2_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('celular_cond_2_vehi_3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label for="email_cond_2_vehi_3" class="col-form-label text-md-left">{{ __('Email Conductor 2') }}</label>
                                                <input id="email_cond_2_vehi_3" type="text" class="form-control @error('email_cond_2_vehi_3') is-invalid @enderror" name="email_cond_2_vehi_3" 
                                                title="Email 2do conductor responsable del vehículo"
                                                value="{{$solicitud_transporte->email_conductor_2_vehi_3}}"  autocomplete="off" autofocus readonly>
                                                
                                                @error('email_cond_2_vehi_3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <!-- 14 transporte_ra_3 -->
                                    @endif

                                <!-- ruta alterna -->
                                @endif

                                <br>
                                <h4>Informe Servicio Transporte</h4>
                                <hr class="divider">
                                <br>

                                <!-- no conformidades transporte -->
                                <div class="form-group row">
                                    <!-- 1 -->
                                        <div class="col-md-11" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-bottom: 0rem;">
                                                <label for="cumplio_expect">{{ __('El servicio de transporte cumplió las expectativas de la salida de práctica académica de campo?') }}</label>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-1" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-right: 0.9375rem; margin-bottom: 0rem;">
                                                <label class="switch">
                                                    <input type="checkbox" name="cumplio_expect" id="cumplio_expect" onchange="no_conf_trans(this,1)" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    <!-- 1 -->

                                    <!-- 1.1 -->
                                        
                                        <div class="col-md-12" style="margin-bottom: 0rem;" id="no_conf_trans_1">
                                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                                <label for="no_cumplio_expect" class="col-form-label text-md-left">{{ __('Porqué no?') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="no_cumplio_expect" style="min-height:5rem;" type="text" class="form-control @error('no_cumplio_expect') is-invalid @enderror" name="no_cumplio_expect" 
                                                autocomplete="off" autofocus ></textarea>
                                                
                                                @error('no_cumplio_expect')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                    <!-- 1.1 -->
                        
                                    <!-- 2 -->
                                        <div class="col-md-11" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-bottom: 0rem;">
                                                <label for="ruta_prevista">{{ __('Se realizó el recorrido según la ruta prevista?') }}</label>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-1" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-right: 0.9375rem; margin-bottom: 0rem;">
                                                <label class="switch">
                                                    <input type="checkbox" name="ruta_prevista" id="ruta_prevista" onchange="no_conf_trans(this,2)" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    <!-- 2 -->

                                    <!-- 2.1 -->
                                        
                                        <div class="col-md-12" style="margin-bottom: 0rem;" id="no_conf_trans_2">
                                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                                <label for="no_ruta_prevista" class="col-form-label text-md-left">{{ __('Porqué no?') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="no_ruta_prevista" style="min-height:5rem;" type="text" class="form-control @error('no_ruta_prevista') is-invalid @enderror" name="no_ruta_prevista" 
                                                autocomplete="off" autofocus ></textarea>
                                                
                                                @error('no_ruta_prevista')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                    <!-- 2.1 -->
                        
                                    <!-- 3 -->
                                        <div class="col-md-11" style="margin-top: 1rem;">   
                                            <div class="form-group"  style="margin-bottom: 0px;">
                                                <label for="carac_solicitadas">{{ __('El/Los vehículo(s) contaba(n) con las características solicitadas?') }}</label>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-1" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-right: 0.9375rem; margin-bottom: 0rem;">
                                                <label class="switch">
                                                    <input type="checkbox" name="carac_solicitadas" id="carac_solicitadas" onchange="no_conf_trans(this,3)" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    <!-- 3 -->

                                    <!-- 3.1 -->
                                        
                                        <div class="col-md-12" style="margin-bottom: 0rem;" id="no_conf_trans_3">
                                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                                <label for="no_carac_solicitadas" class="col-form-label text-md-left">{{ __('Porqué no?') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="no_carac_solicitadas" style="min-height:5rem;" type="text" class="form-control @error('no_carac_solicitadas') is-invalid @enderror" name="no_carac_solicitadas" 
                                                autocomplete="off" autofocus ></textarea>
                                                
                                                @error('no_carac_solicitadas')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                    <!-- 3.1 -->
                        
                                    <!-- 4 -->
                                        <div class="col-md-11" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <label for="comport_adecuado">{{ __('El comportamiento del/los conductor(es) y/o ayudante(s) fue apropiado?') }}</label>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-1" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-right: 0.9375rem; margin-bottom: 0rem;">
                                                <label class="switch">
                                                    <input type="checkbox" name="comport_adecuado" id="comport_adecuado" onchange="no_conf_trans(this,4)" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    <!-- 4 -->

                                    <!-- 4.1 -->
                                        
                                        <div class="col-md-12" style="margin-bottom: 0rem;" id="no_conf_trans_4">
                                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                                <label for="no_comport_adecuado" class="col-form-label text-md-left">{{ __('Porqué no?') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="no_comport_adecuado" style="min-height:5rem;" type="text" class="form-control @error('no_comport_adecuado') is-invalid @enderror" name="no_comport_adecuado" 
                                                autocomplete="off" autofocus ></textarea>
                                                
                                                @error('no_comport_adecuado')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                    <!-- 4.1 -->

                                    <!-- 5 -->
                                        <div class="col-md-11" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <label for="horar_estab">{{ __('Se cumplió con los horarios establecidos?') }}</label>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-1" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-right: 0.9375rem; margin-bottom: 0rem;">
                                                <label class="switch">
                                                    <input type="checkbox" name="horar_estab" id="horar_estab" onchange="no_conf_trans(this,5)" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    <!-- 5 -->

                                    <!-- 5.1 -->
                                        
                                        <div class="col-md-12" style="margin-bottom: 0rem;" id="no_conf_trans_5">
                                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                                <label for="no_horar_estab" class="col-form-label text-md-left">{{ __('Porqué no?') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="no_horar_estab" style="min-height:5rem;" type="text" class="form-control @error('no_horar_estab') is-invalid @enderror" name="no_horar_estab" 
                                                autocomplete="off" autofocus ></textarea>
                                                
                                                @error('no_horar_estab')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                    <!-- 5.1 -->
                        
                                    <!-- 6 -->
                                        <div class="col-md-11" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <label for="nov_cron_ruta">{{ __('Alguna novedad en el cronograma de ruta?') }}</label>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-1" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-right: 0.9375rem; margin-bottom: 0rem;">
                                                <label class="switch">
                                                    <input type="checkbox" name="nov_cron_ruta" id="nov_cron_ruta" onchange="no_conf_trans(this,6)">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    <!-- 6 -->

                                    <!-- 6.1 -->
                                        
                                        <div class="col-md-12" style="margin-bottom: 0rem;" id="no_conf_trans_6">
                                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                                <label for="con_nov_cron_ruta" class="col-form-label text-md-left">{{ __('Cuál(es)?') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="con_nov_cron_ruta" style="min-height:5rem;" type="text" class="form-control @error('con_nov_cron_ruta') is-invalid @enderror" name="con_nov_cron_ruta" 
                                                autocomplete="off" autofocus ></textarea>
                                                
                                                @error('con_nov_cron_ruta')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                    <!-- 6.1 -->
                        
                                    <!-- 7 -->
                                        <div class="col-md-11" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <label for="adecuado_traslado">{{ __('El/Los vehículo(s) se encontraba(n) en buenas condiciones para el traslado de pasajeros?') }}</label>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-1" style="margin-top: 1rem;">
                                            <div class="form-group" style="margin-right: 0.9375rem; margin-bottom: 0rem;">
                                                <label class="switch">
                                                    <input type="checkbox" name="adecuado_traslado" id="adecuado_traslado" onchange="no_conf_trans(this,7)" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    <!-- 7 -->

                                    <!-- 7.1 -->
                                        
                                        <div class="col-md-12" style="margin-bottom: 0rem;" id="no_conf_trans_7">
                                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                                <label for="no_adecuado_traslado" class="col-form-label text-md-left">{{ __('Porqué no?') }}</label>
                                                <span class="hs-form-required">*</span>
                                                <textarea id="no_adecuado_traslado" style="min-height:5rem;" type="text" class="form-control @error('no_adecuado_traslado') is-invalid @enderror" name="no_adecuado_traslado" 
                                                autocomplete="off" autofocus ></textarea>
                                                
                                                @error('no_adecuado_traslado')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                    <!-- 7.1 -->
                        
                                </div>
                                <!-- no conformidades transporte -->

                                <!-- button -->
                                <div class="form-group row mb-0">
                                    <div class="col-md-5 offset-md-5">
                                        <br>
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Guardar') }}
                                        </button>
                                    </div>
                                </div>
                                <!-- button -->
                            </form>
                        </div>
                    
                </div>
                <br>
            </div>
        </div>
        
    @endsection 




