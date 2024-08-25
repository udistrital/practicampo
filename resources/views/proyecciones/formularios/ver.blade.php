<!-- información proyección -->
    <!-- 1 -->
        <div class="form-group row">
            <div class="col-md-4">
                <label for="id_programa_academico" class="col-form-label text-md-right">{{ __('Programa Académico') }}</label>
                <select id="id_programa_academico" name="id_programa_academico" class="form-control" required readonly disabled>
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
                <label for="id_semestre_asignatura" class="col-form-label text-md-right">{{ __('Sem.') }}</label>
                <select id="id_semestre_asignatura" name="id_semestre_asignatura" class="form-control" required disabled style="padding-left: 0.1rem;padding-right: 0.1rem;">
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
            
            <div class="col-md-2">
                <div class="input-group">
                    <label for="id_periodo_academico" class="col-form-label text-md-right">{{ __('Año - Per.') }}</label>
                    <span class="hs-form-required" title="Período Asignatura">*</span>
                    <div class="row">
                        <div class="col-md-12" style="padding-left: 0;">
                            <div class="input-group">
                                <div class="col-md-5" style="padding-left: 0px;padding-right: 0px;">
                                    <input id="anio_periodo" type="text" maxlength="4" class="inputDate form-control datetimepickerHr @error('hora_salida_rp') is-invalid @enderror" name="anio_periodo" 
                                    style="padding-left: 0px;padding-right: 0px;border-top-right-radius: 0; border-bottom-right-radius: 0;"
                                    onchange="onlyNmb(this)" onkeyup="onlyNmb(this)"
                                    value="{{$proyeccion_preliminar->anio_periodo}}" autocomplete="off" autofocus required readonly>
                                </div>
                                <div class="col-md-7" style="padding-left: 0px;padding-right: 0px;">
                                    <select name="id_periodo_academico" class="form-control" required
                                    title="Período académico" disabled
                                    style="padding-left: 0.1rem;padding-right: 0.1rem;border-top-left-radius: 0; border-bottom-left-radius: 0;">
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- 1 -->

    <!-- 2 -->
        <div  class="form-group row">
            <div class="col-md-2">
                <label for="num_estudiantes_aprox" class="col-form-label text-md-left">{{ __('Estudiantes') }}</label>
                <span class="hs-form-required">*</span>
                <input id="num_estudiantes_aprox" type="text" pattern="[1-9][0-9]*" class="form-control @error('num_estudiantes_aprox') is-invalid @enderror" name="num_estudiantes_aprox" 
                title="Número de estudiantes"
                value="{{$proyeccion_preliminar->num_estudiantes_aprox}}" required autocomplete="off" autofocus readonly>
                
                @error('num_estudiantes_aprox')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-2">
                <label for="cant_grupos" class="col-form-label text-md-left">{{ __('Cant. Grupos') }}</label>
                <span class="hs-form-required">*</span>
                <div class="input-group">
                    <input id="cant_grupos"  max="4" min="1" pattern="^[1-4]" class="form-control @error('cant_grupos') is-invalid @enderror" name="cant_grupos" 
                    title="Cantidad de grupos" readonly
                    value="{{$proyeccion_preliminar->cantidad_grupos}}" autocomplete="off" autofocus readonly>
                    @error('cant_grupos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
            </div>

            {{-- <div class="col-md-2">
                <label for="num_acompaniantes" class="col-form-label text-md-left">{{ __('Acompañantes') }}</label>
                <div class="input-group">
                    <input id="num_acompaniantes" max="3" min="0" pattern="^[0-3]" class="form-control @error('num_acompaniantes') is-invalid @enderror" name="num_acompaniantes" 
                    title="Número de acompañantes"
                    value="{{$docentes_practica->total_docentes_apoyo}}" autocomplete="off" autofocus readonly>
                    
                    @error('num_acompaniantes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> --}}

            <div class="col-md-2">
                <label for="num_apoyo" class="col-form-label text-md-left">{{ __('Personal Apoyo') }}</label>
                <div class="input-group">
                    <input id="num_apoyo" max="3" min="0" pattern="^[0-9]+" class="form-control @error('num_apoyo') is-invalid @enderror" name="num_apoyo" 
                    title="Número de docentes de apoyo"
                    value="{{$docentes_practica->num_docentes_apoyo}}" autocomplete="off" autofocus readonly>
                    
                    @error('num_apoyo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- viaticos -->
            <div class="col-md-2">
                <input id="vlr_estud_max" type="text"  class="form-control @error('vlr_estud_max') is-invalid @enderror" name="vlr_estud_max" 
                value={{$vlr_viaticos->vlr_estud_max}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                
                <input id="vlr_estud_min" type="text"  class="form-control @error('vlr_estud_min') is-invalid @enderror" name="vlr_estud_min" 
                value={{$vlr_viaticos->vlr_estud_min}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                
            </div> 

            <div class="col-md-2">
                <input id="vlr_docen_max" type="text"  class="form-control @error('vlr_docen_max') is-invalid @enderror" name="vlr_docen_max" 
                value={{$vlr_viaticos->vlr_docen_max}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                
                <input id="vlr_docen_min" type="text"  class="form-control @error('vlr_docen_min') is-invalid @enderror" name="vlr_docen_min" 
                value={{$vlr_viaticos->vlr_docen_min}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                
            </div>

            <div class="col-md-1">
                <input id="pregrado" type="text"  class="form-control @error('pregrado') is-invalid @enderror" name="pregrado" 
                value="" autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                
            </div> 
            <!-- viaticos -->
        </div>
    <!-- 2 -->

<!-- información proyección -->

<br>
<h4>Ruta Principal (Destino para cumplir los objetivos de la práctica)</h4>
<hr class="divider">
<br>

<!-- ruta principal -->
    <!-- 3 -->
        <div class="form-group row">
            <div class="col-md-6">
                <label for="destino_rp" class="col-form-label text-md-left">{{ __('Destino Ruta Principal') }}</label>
                <span class="hs-form-required">*</span>
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
                <span class="hs-form-required">*</span>
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
                <span class="hs-form-required">*</span>
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
                <span class="hs-form-required">*</span>
                <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                    </div>
                <input class="inputDate form-control datetimepicker" name="fecha_salida_aprox_rp"  type="text" required
                value="{{$proyeccion_preliminar->fecha_salida_aprox_rp}}" readonly disabled>
                </div>
            </div>

            <div class="col-md-3">
                <label for="lugar_regreso_rp" class="col-form-label text-md-left">{{ __('Punto Encuentro Regreso') }}</label>
                <span class="hs-form-required">*</span>
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
                <span class="hs-form-required">*</span>
                <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                    </div>
                <input class="inputDate form-control datetimepicker" name="fecha_regreso_aprox_rp"  type="text" required
                value="{{$proyeccion_preliminar->fecha_regreso_aprox_rp}}" readonly disabled>
                </div>
            </div>

            <div class="col-md-2">
                <label for="duracion_rp" class="col-form-label text-md-left">{{ __('Duración Días') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="duracion_rp_" type="text" class="form-control @error('duracion_rp') is-invalid @enderror" name="duracion_rp" 
                value="{{ $proyeccion_preliminar->duracion_num_dias_rp}}" autocomplete="off" autofocus readonly>
                
                @error('duracion_rp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
    <!-- 6 -->

    <br>
    <h4>Transporte</h4>
    <hr class="divider">

    <!-- 7 -->
        <div  class="form-group row">
            <div class="col-md-2">
                <label for="cant_transporte_rp_edit" class="col-form-label text-md-left">{{ __('Cant. Vehículos') }}</label>
                <div class="input-group">
                    <input id="cant_transporte_rp_edit" max="3" min="0" pattern="^[0-3]+"  class="form-control @error('cant_transporte_rp_edit') is-invalid @enderror" name="cant_transporte_rp_edit" 
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

            

            <div class="col-md-5">
                <label for="docente_resp_transp_rp" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                <input id="docente_resp_transp_rp" type="text" class="form-control @error('docente_resp_transp_rp') is-invalid @enderror" name="docente_resp_transp_rp" 
                value="{{$nombre_usuario}}" required autocomplete="off" autofocus readonly>
                
                @error('docente_resp_transp_rp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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
                </div>

            </div>

        </div>
    <!-- 8 transporte_rp_3 -->

    <br>
    <h4>Otros</h4>
    <hr class="divider">

    <!-- materiales -->
        <div class="form-group row">
            <div class="col-md-8">
                <label for="det_materiales_rp" class="col-form-label text-md-left" title="Materiales">{{ __('Materiales') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="det_materiales_rp" type="text"  class="form-control @error('det_materiales_rp') is-invalid @enderror" name="det_materiales_rp" 
                value="{{$mater_herra_proyeccion->det_materiales_rp}}" autocomplete="off" autofocus disabled>
                
                @error('det_materiales_rp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="vlr_materiales_rp" class="col-form-label text-md-left" title="Valor Total Materiales">{{ __('Valor Total Materiales') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="vlr_materiales_rp" type="text"  class="form-control @error('vlr_materiales_rp') is-invalid @enderror" name="vlr_materiales_rp" 
                value="{{number_format($costos_proyeccion->vlr_materiales_rp,'0',',','.')}}" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)"
                disabled>
                
                @error('vlr_materiales_rp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    <!-- materiales -->

    <!-- guías -baquianos -->
        <div class="form-group row">
            <div class="col-md-8">
                <label for="det_guias_baquia_rp" class="col-form-label text-md-left" title="Guías y/o Baquianos">{{ __('Guías y/o Baquianos') }}</label>
                <input id="det_guias_baquia_rp" type="text"  class="form-control @error('det_guias_baquia_rp') is-invalid @enderror" name="det_guias_baquia_rp" 
                title="Guías y/o baquianos requeridos"
                value="{{$mater_herra_proyeccion->det_guias_baquianos_rp}}" autocomplete="off" autofocus disabled>
                
                @error('det_guias_baquia_rp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="vlr_guias_baquia_rp" class="col-form-label text-md-left" title="Valor Total Guías y/o Baquianos">{{ __('Valor Total Guías y/o Baquianos') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="vlr_guias_baquia_rp" type="text"  class="form-control @error('vlr_guias_baquias_rp') is-invalid @enderror" name="vlr_guias_baquia_rp" 
                title="Valor de los guías y/o baquianos" disabled
                value="{{number_format($costos_proyeccion->vlr_guias_baquianos_rp,'0',',','.')}}" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                
                @error('vlr_guias_baquia_rp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    <!-- guías -baquianos -->                        

    <!-- otros - boletas -->
        <div class="form-group row">
            <div class="col-md-8">
                <label for="det_otros_bolet_rp" class="col-form-label text-md-left" title="">{{ __('Boletas y/u Otros') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="det_otros_bolet_rp" type="text"  class="form-control @error('det_otros_bolet_rp') is-invalid @enderror" name="det_otros_bolet_rp" 
                title="Boletas y/u otros requeridos"
                value="{{$mater_herra_proyeccion->det_otros_boletas_rp}}" autocomplete="off" autofocus disabled>
                
                @error('det_otros_bolet_rp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="vlr_otros_bolet_rp" class="col-form-label text-md-left" title="Valor Total Boletas y/u Otros">{{ __('Valor Total Boletas y/u Otros') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="vlr_otros_bolet_rp" type="text"  class="form-control @error('vlr_otros_bolet_rp') is-invalid @enderror" name="vlr_otros_bolet_rp" 
                title="Valor de las boletas y/u otros" disabled
                value="{{number_format($costos_proyeccion->vlr_otros_boletas_rp,'0',',','.')}}" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                
                @error('vlr_otros_bolet_rp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    <!-- otros - boletas --> 

    <!-- preguntas -->
        <div class="form-group row">
            <!-- 1 -->
            <div class="col-md-11">
                <div class="form-group">
                    <label for="areas_acuaticas_rp">{{ __('Esta sálida desarrolla maniobras sobre áreas acuáticas(Ríos, lagos, lagunas, humedales, mares, etc...?)') }}</label>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group" style="margin-right: 15px;">
                    <label class="switch">
                        <input type="checkbox" name="areas_acuaticas_rp" 
                        <?php if($riesg_amen_practica->areas_acuaticas_rp == 1) echo 'checked'?> disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <!-- 1 -->

            <!-- 2 -->
            <div class="col-md-11">
                <div class="form-group">
                    <label for="alturas_rp">{{ __('Esta sálida desarrolla actividades de escalada o trabajo de alturas?)') }}</label>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group" style="margin-right: 15px;">
                    <label class="switch">
                        <input type="checkbox" name="alturas_rp"
                        <?php if($riesg_amen_practica->alturas_rp == 1) echo 'checked'?> disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <!-- 2 -->

            <!-- 3 -->
            <div class="col-md-11">
                <div class="form-group">
                    <label for="riesgo_biologico_rp">{{ __('Esta sálida desarrolla actividades al interior de bosques o lugares con riesgo biológico?)') }}</label>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group" style="margin-right: 15px;">
                    <label class="switch">
                        <input type="checkbox" name="riesgo_biologico_rp"
                        <?php if($riesg_amen_practica->riesgo_biologico_rp == 1) echo 'checked'?> disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <!-- 3 -->

            <!-- 4 -->
            <div class="col-md-11">
                <div class="form-group">
                    <label for="espacios_confinados_rp">{{ __('Esta sálida desarrolla actividades en espacios confinados?)') }}</label>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group" style="margin-right: 15px;">
                    <label class="switch">
                        <input type="checkbox" name="espacios_confinados_rp"
                        <?php if($riesg_amen_practica->espacios_confinados_rp == 1) echo 'checked'?> disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <!-- 4 -->

        </div>
    <!-- preguntas -->

<!-- ruta principal -->

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
                    value="{{$proyeccion_preliminar->cantidad_url_ra}}" autocomplete="off" autofocus required readonly disabled>
                    
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
                <input class="inputDate form-control datetimepicker" name="fecha_salida_aprox_ra"  type="text" required
                value="{{$proyeccion_preliminar->fecha_salida_aprox_ra}}" readonly disabled>
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
                <input class="inputDate form-control datetimepicker" name="fecha_regreso_aprox_ra"  type="text" required
                value="{{$proyeccion_preliminar->fecha_regreso_aprox_ra}}" readonly disabled>
                </div>
            </div>

            <div class="col-md-2">
                <label for="duracion_ra" class="col-form-label text-md-left">{{ __('Duración Días') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="duracion_ra_" type="text" class="form-control @error('duracion_ra') is-invalid @enderror" name="duracion_ra" 
                value="{{ $proyeccion_preliminar->duracion_num_dias_ra}}" autocomplete="off" autofocus readonly>
                
                @error('duracion_ra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
    <!-- 12 -->

    <br>
    <h4>Transporte</h4>
    <hr class="divider">
    
    <!-- 13 -->
        <div  class="form-group row">
            <div class="col-md-2">
                <label for="cant_transporte_ra_edit" class="col-form-label text-md-left">{{ __('Cant. Vehículos') }}</label>
                <div class="input-group">
                    <input id="cant_transporte_ra_edit"  max="3" min="0" pattern="^[0-3]+"  class="form-control @error('cant_transporte_ra_edit') is-invalid @enderror" name="cant_transporte_ra_edit" 
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

            <div class="col-md-5">
                <label for="docente_resp_transp_ra" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                <input id="docente_resp_transp_ra" type="text" class="form-control @error('docente_resp_transp_ra') is-invalid @enderror" name="docente_resp_transp_ra" 
                value="{{$nombre_usuario}}" required autocomplete="off" autofocus readonly>
                
                @error('docente_resp_transp_ra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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

                        {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
                    </div>
                </div>
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

                        {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
                    </div>
                </div>
            </div>
        </div>
    <!-- 14 transporte_ra_3 -->

    <br>
    <h4>Otros</h4>
    <hr class="divider">

    <!-- materiales -->
        <div class="form-group row">
            <div class="col-md-8">
                <label for="det_materiales_ra" class="col-form-label text-md-left" title="Materiales">{{ __('Materiales') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="det_materiales_ra" type="text"  class="form-control @error('det_materiales_ra') is-invalid @enderror" name="det_materiales_ra" 
                value="{{$mater_herra_proyeccion->det_materiales_ra}}" autocomplete="off" autofocus disabled>
                
                @error('det_materiales_ra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="vlr_materiales_ra" class="col-form-label text-md-left" title="Valor Total Materiales">{{ __('Valor Total Materiales') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="vlr_materiales_ra" type="text"  class="form-control @error('vlr_materiales_ra') is-invalid @enderror" name="vlr_materiales_ra" 
                value="{{number_format($costos_proyeccion->vlr_materiales_ra,'0',',','.')}}" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)"
                disabled>
                
                @error('vlr_materiales_ra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    <!-- materiales -->

    <!-- guías -baquianos -->
        <div class="form-group row">
            <div class="col-md-8">
                <label for="det_guias_baquia_ra" class="col-form-label text-md-left" title="Guías y/o Baquianos">{{ __('Guías y/o Baquianos') }}</label>
                <input id="det_guias_baquia_ra" type="text"  class="form-control @error('det_guias_baquia_ra') is-invalid @enderror" name="det_guias_baquia_ra" 
                title="Guías y/o baquianos requeridos" disabled
                value="{{$mater_herra_proyeccion->det_guias_baquianos_ra}}" autocomplete="off" autofocus>
                
                @error('det_guias_baquia_ra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="vlr_guias_baquia_ra" class="col-form-label text-md-left" title="Valor Total Guías y/o Baquianos">{{ __('Valor Total Guías y/o Baquianos') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="vlr_guias_baquia_ra" type="text"  class="form-control @error('vlr_guias_baquias_ra') is-invalid @enderror" name="vlr_guias_baquia_ra" 
                title="Valor de los guías y/o baquianos" disabled
                value="{{number_format($costos_proyeccion->vlr_guias_baquianos_ra,'0',',','.')}}" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                
                @error('vlr_guias_baquia_ra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    <!-- guías -baquianos -->                            

    <!-- otros - boletas -->
        <div class="form-group row">
            <div class="col-md-8">
                <label for="det_otros_bolet_ra" class="col-form-label text-md-left" title="">{{ __('Boletas y/u Otros') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="det_otros_bolet_ra" type="text"  class="form-control @error('det_otros_bolet_ra') is-invalid @enderror" name="det_otros_bolet_ra" 
                title="Boletas y/u otros requeridos" disabled
                value="{{$mater_herra_proyeccion->det_otros_boletas_ra}}" autocomplete="off" autofocus>
                
                @error('det_otros_bolet_ra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="vlr_otros_bolet_ra" class="col-form-label text-md-left" title="Valor Total Boletas y/u Otros">{{ __('Valor Total Boletas y/u Otros') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="vlr_otros_bolet_ra" type="text"  class="form-control @error('vlr_otros_bolet_ra') is-invalid @enderror" name="vlr_otros_bolet_ra" 
                title="Valor de las boletas y/u otros" disabled
                value="{{number_format($costos_proyeccion->vlr_otros_boletas_ra,'0',',','.')}}" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                
                @error('vlr_otros_bolet_ra')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    <!-- otros - boletas -->  

    <!-- preguntas -->
        <div class="form-group row">
            <!-- 1 -->
            <div class="col-md-11">
                <div class="form-group">
                    <label for="areas_acuaticas_ra">{{ __('Esta sálida desarrolla maniobras sobre áreas acuáticas(Ríos, lagos, lagunas, humedales, mares, etc...?)') }}</label>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group" style="margin-right: 15px;">
                    <label class="switch">
                        <input type="checkbox" name="areas_acuaticas_ra"
                        <?php if($riesg_amen_practica->areas_acuaticas_ra == 1) echo 'checked'?> disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <!-- 1 -->

            <!-- 2 -->
            <div class="col-md-11">
                <div class="form-group">
                    <label for="alturas_ra">{{ __('Esta sálida desarrolla actividades de escalada o trabajo de alturas?)') }}</label>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group" style="margin-right: 15px;">
                    <label class="switch">
                        <input type="checkbox" name="alturas_ra"
                        <?php if($riesg_amen_practica->alturas_ra == 1) echo 'checked'?> disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <!-- 2 -->

            <!-- 3 -->
            <div class="col-md-11">
                <div class="form-group">
                    <label for="riesgo_biologico_ra">{{ __('Esta sálida desarrolla actividades al interior de bosques o lugares con riesgo biológico?)') }}</label>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group" style="margin-right: 15px;">
                    <label class="switch">
                        <input type="checkbox" name="riesgo_biologico_ra"
                        <?php if($riesg_amen_practica->riesgo_biologico_ra == 1) echo 'checked'?> disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <!-- 3 -->

            <!-- 4 -->
            <div class="col-md-11">
                <div class="form-group">
                    <label for="espacios_confinados_ra">{{ __('Esta sálida desarrolla actividades en espacios confinados?)') }}</label>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group" style="margin-right: 15px;">
                    <label class="switch">
                        <input type="checkbox" name="espacios_confinados_ra"
                        <?php if($riesg_amen_practica->espacios_confinados_ra == 1) echo 'checked'?> disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <!-- 4 -->

        </div>
    <!-- preguntas -->

<!-- ruta alterna -->



