@if($proyeccion_preliminar->aprobacion_consejo_facultad == 3 && $estado_doc_respon == 2)
<h6>El usuario <strong>{{$nombre_usuario}}</strong> se encuentra <strong>Inactivo</strong></h4>
    
    <!-- información docente -->   
        <!-- 1 -->
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="docentes_activos" class="col-form-label text-md-right">{{ __('Docentes Activos') }}</label>
                    <span class="hs-form-required">*</span>
                    <select name="docentes_activos" id="docentes_activos" class="form-control" required>
                        @foreach($docentes_activos as $doc_act)
                            <option value="{{$doc_act->id}}" selected>{{$doc_act->full_name}} </option>  
                        @endforeach
                    </select>
                    @error('id_programa_academico')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>
        <!-- 1 -->
    <!-- información docente -->
    <hr class="divider">
@endif

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
                    <span class="hs-form-required" title="">*</span>
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
                                    title="" disabled
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

    <!-- Integradas -->
        <div  class="form-group row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="integrada" class="col-form-label text-md-left">{{ __('Práctica Integrada?') }}</label>
                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="integrada" id="integrada" value="1" 
                            title=""
                            <?php if($proyeccion_preliminar->practicas_integradas == 1) echo 'checked'?> disabled>
                            <label class="form-check-label" for="">Si</label>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="integrada" id="integrada"  value="0"
                                title=""
                                <?php if($proyeccion_preliminar->practicas_integradas == 0) echo 'checked'?> disabled>
                                <label class="form-check-label" for="">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2" id="c_espa_aca">
                <label for="cant_espa_aca" class="col-form-label text-md-left">{{ __('Cant. Esp. Aca.') }}</label>
                <div class="input-group">
                    <input id="cant_espa_aca" type="number" max="7" min="1" pattern="^[1-7]+" class="form-control @error('cant_espa_aca') is-invalid @enderror" name="cant_espa_aca" 
                    title=""
                    value="{{$practicas_integradas->cant_espa_aca}}" autocomplete="off" autofocus onchange="" readonly disabled>
                    
                    @error('cant_espa_aca')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <span class="input-group-btn">
                        <button class="btn btn-success btn_ver" type="button" id="ver_integ" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                        onclick="ver_intg()"><i class="far fa-eye"></i></button>
                        <button class="btn btn-success btn_ver" type="button" id="ocul_integ" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                        onclick="ocul_intg()"><i class="far fa-eye-slash"></i></button>
                    </span>
                </div>
            </div>

            
            <!-- viaticos -->
                <div class="col-md-1" style="height: 1rem;">
                    <input id="vlr_estud_max" type="text"  class="form-control @error('vlr_estud_max') is-invalid @enderror" name="vlr_estud_max" 
                    value={{$vlr_viaticos->vlr_estud_max}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                    
                    <input id="vlr_estud_min" type="text"  class="form-control @error('vlr_estud_min') is-invalid @enderror" name="vlr_estud_min" 
                    value={{$vlr_viaticos->vlr_estud_min}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                    
                {{-- </div> 

                <div class="col-md-1"> --}}
                    <input id="vlr_docen_max" type="text"  class="form-control @error('vlr_docen_max') is-invalid @enderror" name="vlr_docen_max" 
                    value={{$vlr_viaticos->vlr_docen_max}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                    
                    <input id="vlr_docen_min" type="text"  class="form-control @error('vlr_docen_min') is-invalid @enderror" name="vlr_docen_min" 
                    value={{$vlr_viaticos->vlr_docen_min}} autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                    
                {{-- </div>

                <div class="col-md-1"> --}}
                    <input id="pregrado" type="text"  class="form-control @error('pregrado') is-invalid @enderror" name="pregrado" 
                    value="" autocomplete="off" autofocus readonly style="background-color:transparent; border-color:transparent; color:transparent !important">
                    
                </div> 
            <!-- viaticos -->
        </div>

        <div class="form-group row" id="esp_aca_1">
            <div class="col-md-12" id="">
                <br>
                <h4>Espacios Académicos Prácticas Integradas</h4>
                <hr class="divider">
            </div>

            <div class="col-md-5" id="">
                <label for="id_espa_aca_1" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                <select id="id_espa_aca_1" name="id_espa_aca_1" class="form-control" required
                title=""
                onchange="recargarDocenEspaAca(this.value, 1)"
                readonly disabled>
                    @foreach($espa_aca_integradas as $esp_aca)
                        <option <?php if($esp_aca->id==$practicas_integradas->id_espa_aca_1) echo 'selected'?> value="{{$esp_aca->id}}">{{$esp_aca->espacio_academico}}</option>  
                    @endforeach
                </select>
                
                @error('id_espa_aca_1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-5" id="">
                <label for="id_docen_espa_aca_1" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                
                <select id="id_docen_espa_aca_1" name="id_docen_espa_aca_1" class="form-control" required
                title=""
                readonly disabled>
                    @foreach($d_int_espa_aca_1 as $d_i_1)
                        <option <?php if($d_i_1['id']==$practicas_integradas->id_docen_espa_aca_1) echo 'selected'?> value="{{$d_i_1['id']}}">{{$d_i_1['full_name']}}</option>
                    @endforeach
                </select>
                
                @error('id_docen_espa_aca_1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row" id="esp_aca_2">
            <div class="col-md-5" id="">
                <label for="id_espa_aca_2" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                <select id="id_espa_aca_2" name="id_espa_aca_2" class="form-control" required
                title=""
                onchange="recargarDocenEspaAca(this.value, 2)"
                readonly disabled>
                    @foreach($espa_aca_integradas as $esp_aca)
                        <option <?php if($esp_aca->id==$practicas_integradas->id_espa_aca_2) echo 'selected'?> value="{{$esp_aca->id}}">{{$esp_aca->espacio_academico}}</option>  
                    @endforeach
                </select>
                
                @error('id_espa_aca_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-5" id="">
                <label for="id_docen_espa_aca_2" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                <select id="id_docen_espa_aca_2" name="id_docen_espa_aca_2" class="form-control" required
                title=""
                readonly disabled>
                    @foreach($d_int_espa_aca_2 as $d_i_2)
                        <option <?php if($d_i_2['id']==$practicas_integradas->id_docen_espa_aca_2) echo 'selected'?> value="{{$d_i_2['id']}}">{{$d_i_2['full_name']}}</option>
                    @endforeach
                </select>
                
                @error('id_docen_espa_aca_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row" id="esp_aca_3">
            <div class="col-md-5" id="">
                <label for="id_espa_aca_3" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                <select id="id_espa_aca_3" name="id_espa_aca_3" class="form-control" required
                title=""
                onchange="recargarDocenEspaAca(this.value, 3)"
                readonly disabled>
                    @foreach($espa_aca_integradas as $esp_aca)
                        <option <?php if($esp_aca->id==$practicas_integradas->id_espa_aca_3) echo 'selected'?> value="{{$esp_aca->id}}">{{$esp_aca->espacio_academico}}</option>  
                    @endforeach
                </select>
                
                @error('id_espa_aca_3')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-5" id="">
                <label for="id_docen_espa_aca_3" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                <select id="id_docen_espa_aca_3" name="id_docen_espa_aca_3" class="form-control" required
                title=""
                readonly disabled>
                    @foreach($d_int_espa_aca_3 as $d_i_3)
                        <option <?php if($d_i_3['id']==$practicas_integradas->id_docen_espa_aca_3) echo 'selected'?> value="{{$d_i_3['id']}}">{{$d_i_3['full_name']}}</option>
                    @endforeach
                </select>
                
                @error('id_docen_espa_aca_3')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row" id="esp_aca_4">
            <div class="col-md-5" id="">
                <label for="id_espa_aca_4" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                <select id="id_espa_aca_4" name="id_espa_aca_4" class="form-control" required
                title=""
                onchange="recargarDocenEspaAca(this.value, 4)"
                readonly disabled>
                    @foreach($espa_aca_integradas as $esp_aca)
                        <option <?php if($esp_aca->id==$practicas_integradas->id_espa_aca_4) echo 'selected'?> value="{{$esp_aca->id}}">{{$esp_aca->espacio_academico}}</option>  
                    @endforeach
                </select>
                
                @error('id_espa_aca_4')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-5" id="">
                <label for="id_docen_espa_aca_4" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                <select id="id_docen_espa_aca_4" name="id_docen_espa_aca_4" class="form-control" required
                title=""
                readonly disabled>
                    @foreach($d_int_espa_aca_4 as $d_i_4)
                        <option <?php if($d_i_4['id']==$practicas_integradas->id_docen_espa_aca_4) echo 'selected'?> value="{{$d_i_4['id']}}">{{$d_i_4['full_name']}}</option>
                    @endforeach
                </select>
                
                @error('id_docen_espa_aca_4')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row" id="esp_aca_5">
            <div class="col-md-5" id="">
                <label for="id_espa_aca_5" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                <select id="id_espa_aca_5" name="id_espa_aca_5" class="form-control" required
                title=""
                onchange="recargarDocenEspaAca(this.value, 5)"
                readonly disabled>
                    @foreach($espa_aca_integradas as $esp_aca)
                        <option <?php if($esp_aca->id==$practicas_integradas->id_espa_aca_5) echo 'selected'?> value="{{$esp_aca->id}}">{{$esp_aca->espacio_academico}}</option>  
                    @endforeach
                </select>
                
                @error('id_espa_aca_5')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-5" id="">
                <label for="id_docen_espa_aca_5" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                <select id="id_docen_espa_aca_5" name="id_docen_espa_aca_5" class="form-control" required
                title=""
                readonly disabled>
                    @foreach($d_int_espa_aca_5 as $d_i_5)
                        <option <?php if($d_i_5['id']==$practicas_integradas->id_docen_espa_aca_5) echo 'selected'?> value="{{$d_i_5['id']}}">{{$d_i_5['full_name']}}</option>
                    @endforeach
                </select>
                
                @error('id_docen_espa_aca_5')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row" id="esp_aca_6">
            <div class="col-md-5" id="">
                <label for="id_espa_aca_6" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                <select id="id_espa_aca_6" name="id_espa_aca_6" class="form-control" required
                title="Espacio académico"
                onchange="recargarDocenEspaAca(this.value, 6)"
                readonly disabled>
                    @foreach($espa_aca_integradas as $esp_aca)
                        <option <?php if($esp_aca->id==$practicas_integradas->id_espa_aca_6) echo 'selected'?> value="{{$esp_aca->id}}">{{$esp_aca->espacio_academico}}</option>  
                    @endforeach
                </select>
                
                @error('id_espa_aca_6')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-5" id="">
                <label for="id_docen_espa_aca_6" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                <select id="id_docen_espa_aca_6" name="id_docen_espa_aca_6" class="form-control" required
                title=""
                readonly disabled>
                    @foreach($d_int_espa_aca_6 as $d_i_6)
                        <option <?php if($d_i_6['id']==$practicas_integradas->id_docen_espa_aca_6) echo 'selected'?> value="{{$d_i_6['id']}}">{{$d_i_6['full_name']}}</option>
                    @endforeach
                </select>
                
                @error('id_docen_espa_aca_6')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row" id="esp_aca_7">
            <div class="col-md-5" id="">
                <label for="id_espa_aca_7" class="col-form-label text-md-right">{{ __('Espacio Académico') }}</label>
                <select id="id_espa_aca_7" name="id_espa_aca_7" class="form-control" required
                title="Espacio académico"
                onchange="recargarDocenEspaAca(this.value, 7)"
                readonly disabled>
                    @foreach($espa_aca_integradas as $esp_aca)
                        <option <?php if($esp_aca->id==$practicas_integradas->id_espa_aca_7) echo 'selected'?> value="{{$esp_aca->id}}">{{$esp_aca->espacio_academico}}</option>  
                    @endforeach
                </select>
                
                @error('id_espa_aca_7')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-5" id="">
                <label for="id_docen_espa_aca_7" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                <select id="id_docen_espa_aca_7" name="id_docen_espa_aca_7" class="form-control" required
                title=""
                readonly disabled>
                    @foreach($d_int_espa_aca_7 as $d_i_7)
                        <option <?php if($d_i_7['id']==$practicas_integradas->id_docen_espa_aca_7) echo 'selected'?> value="{{$d_i_7['id']}}">{{$d_i_7['full_name']}}</option>
                    @endforeach
                </select>
                
                @error('id_docen_espa_aca_7')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="col-md-2" id="">
            </div>

            <div class="col-md-12" id="">
                <br>
                <hr class="divider">
            </div>
        </div>

    <!-- Integradas -->

    <!-- 2 -->
        <div  class="form-group row">
            <div class="col-md-2">
                <label for="num_estudiantes_aprox" class="col-form-label text-md-left">{{ __('Estudiantes') }}</label>
                <input id="num_estudiantes_aprox" type="text" pattern="[1-9][0-9]*" class="form-control @error('num_estudiantes_aprox') is-invalid @enderror" name="num_estudiantes_aprox" 
                title=""
                value="{{$solicitud_practica->num_estudiantes}}" required autocomplete="off" autofocus readonly>
                
                @error('num_estudiantes_aprox')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-2">
                <label for="cant_grupos" class="col-form-label text-md-left">{{ __('Cant. Grupos') }}</label>
                <div class="input-group">
                    <input id="cant_grupos"  max="4" min="1" pattern="^[1-4]" class="form-control @error('cant_grupos') is-invalid @enderror" name="cant_grupos" 
                    title="" readonly
                    value="{{$proyeccion_preliminar->cantidad_grupos}}" autocomplete="off" autofocus readonly>
                    @error('cant_grupos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
            </div>

            <div class="col-md-2">
                <label for="num_apoyo" class="col-form-label text-md-left">{{ __('Personal Apoyo') }}</label>
                <div class="input-group">
                    <input id="num_apoyo" max="3" min="0" pattern="^[0-9]+" class="form-control @error('num_apoyo') is-invalid @enderror" name="num_apoyo" 
                    title=""
                    value="{{$docentes_practica->num_docentes_apoyo}}" autocomplete="off" autofocus readonly disabled>
                    
                    @error('num_apoyo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="input-group-btn">
                        <button class="btn btn-success btn_ver" type="button" id="ver_apoyo" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                        onclick="ver_apoy()"><i class="far fa-eye"></i></button>
                        <button class="btn btn-success btn_ver" type="button" id="ocul_apoyo" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                        onclick="ocul_apoy()"><i class="far fa-eye-slash"></i></button>
                    </span>
                    {{-- <span class="input-group-btn">
                        <button class="btn btn-success btn_ver" type="button" id="ver_sop_per" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                        onclick="ver_soporte()"><i class="far fa-eye"></i>  <i class="fa fa-arrow-right"></i>  <i class="fa fa-file"></i></button>
                        <button class="btn btn-success btn_ver" type="button" id="ocul_sop_per" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                        onclick="ocul_soporte()"><i class="far fa-eye-slash"></i>  <i class="fa fa-arrow-right"></i>  <i class="fa fa-file"></i></button>
                    </span> --}}
                </div>
            </div>

            <div class="col-md-2" id="cant_docen_apoyo">
                <label for="total_docentes_apoyo" class="col-form-label text-md-left" title="">
                    <i class="fas fa-question-circle" 
                        data-toggle="tooltip" data-placement="left" 
                        data-title="Indique el número aproximado de docentes que hacen parte del personal de apoyo que participará en la salida de práctica académica"
                        style="font-size: 0.813rem">
                    </i> {{ __('Cant. Docentes') }}</label>
                <div class="input-group">
                    <input id="total_docentes_apoyo" type="number" max="10" min="0" pattern="^[0-9]+" class="form-control @error('total_docentes_apoyo') is-invalid @enderror" name="total_docentes_apoyo" 
                    title=""
                    value="{{$docentes_practica->total_docentes_apoyo}}" autocomplete="off" autofocus readonly onchange="calc_viaticos_RP()">
                    
                    @error('total_docentes_apoyo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>    
            </div>

        </div>

        {{-- <div class="form-group row" id="soporte_pers_apoyo">
            <div class="col-md-12">
                <br>
                <embed src="{{$img_sop_pers_apoyo}}" alt="" width=100% height=600>            
            </div>
        </div> --}}
    <!-- 2 -->

    <!-- 2.1 -->
        <div  class="form-group row"  id="Grupos_edit">
            <div class="col-md-2" id="gp_1_edit">
                <label for="grupo_1" class="col-form-label text-md-left">{{ __('Gp 1') }}</label>
                <span class="hs-form-required">*</span>
                <input id="grupo_1" type="text" class="form-control @error('grupo_1') is-invalid @enderror" name="grupo_1" 
                title="" onkeyup="onlyNmb(this)" 
                value="{{$proyeccion_preliminar->grupo_1}}" required autocomplete="off" autofocus>
                
                @error('grupo_1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2" id="gp_2_edit">
                <label for="grupo_2" class="col-form-label text-md-left">{{ __('Gp 2') }}</label>
                <input id="grupo_2" type="text" class="form-control @error('grupo_2') is-invalid @enderror" name="grupo_2" 
                title="" onkeyup="onlyNmb(this)" 
                value="{{$proyeccion_preliminar->grupo_2}}" autocomplete="off" autofocus>
                @error('grupo_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2" id="gp_3_edit">
                <label for="grupo_3" class="col-form-label text-md-left">{{ __('Gp 3') }}</label>
                <input id="grupo_3" type="text" class="form-control @error('grupo_3') is-invalid @enderror" name="grupo_3" 
                title="" onkeyup="onlyNmb(this)" 
                value="{{$proyeccion_preliminar->grupo_3}}" autocomplete="off" autofocus>
                @error('grupo_3')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2" id="gp_4_edit">
                <label for="grupo_4" class="col-form-label text-md-left">{{ __('Gp 4') }}</label>
                <input id="grupo_4" type="text" class="form-control @error('grupo_4') is-invalid @enderror" name="grupo_4" 
                title="" onkeyup="onlyNmb(this)" 
                value="{{$proyeccion_preliminar->grupo_4}}" autocomplete="off" autofocus>
                @error('grupo_4')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
                
        </div>
    <!-- 2.1 -->

    <!-- 2.3 -->
        <div  class="form-group row"  id="apoyo">
            
            <div class="col-md-4" id="ap_1">
                <label for="apoyo_1" class="col-form-label text-md-left">{{ __('Personal Apoyo 1') }}</label>
                {{-- <span class="hs-form-required">*</span> --}}
                <input id="apoyo_1" type="text" class="form-control @error('apoyo_1') is-invalid @enderror" name="apoyo_1" 
                title=""
                value="{{$docentes_practica->docente_apoyo_1}}" autocomplete="off" autofocus readonly>
                
                @error('apoyo_1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-4" id="ap_2">
                <label for="apoyo_2" class="col-form-label text-md-left">{{ __('Personal Apoyo 2') }}</label>
                <input id="apoyo_2" type="text" class="form-control @error('apoyo_2') is-invalid @enderror" name="apoyo_2" 
                title=""
                value="{{$docentes_practica->docente_apoyo_2}}" autocomplete="off" autofocus readonly>
                @error('apoyo_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4" id="ap_3">
                <label for="apoyo_3" class="col-form-label text-md-left">{{ __('Personal Apoyo 3') }}</label>
                <input id="apoyo_3" type="text" class="form-control @error('apoyo_3') is-invalid @enderror" name="apoyo_3" 
                title=""
                value="{{$docentes_practica->docente_apoyo_3}}" autocomplete="off" autofocus readonly>
                @error('apoyo_3')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4" id="ap_4">
                <label for="apoyo_4" class="col-form-label text-md-left">{{ __('Personal Apoyo 4') }}</label>
                <input id="apoyo_4" type="text" class="form-control @error('apoyo_4') is-invalid @enderror" name="apoyo_4" 
                title=""
                value="{{$docentes_practica->docente_apoyo_4}}"  autocomplete="off" autofocus readonly>
                
                @error('apoyo_4')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4" id="ap_5">
                    <label for="apoyo_5" class="col-form-label text-md-left">{{ __('Personal Apoyo 5') }}</label>
                    <input id="apoyo_5" type="text" class="form-control @error('apoyo_5') is-invalid @enderror" name="apoyo_5" 
                    title=""
                    value="{{$docentes_practica->docente_apoyo_5}}" autocomplete="off" autofocus readonly>
                    @error('apoyo_5')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="col-md-4" id="ap_6">
                    <label for="apoyo_6" class="col-form-label text-md-left">{{ __('Personal Apoyo 6') }}</label>
                    <input id="apoyo_6" type="text" class="form-control @error('apoyo_6') is-invalid @enderror" name="apoyo_6" 
                    title=""
                    value="{{$docentes_practica->docente_apoyo_6}}" autocomplete="off" autofocus readonly>
                    @error('apoyo_6')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="col-md-4" id="ap_7">
                    <label for="apoyo_7" class="col-form-label text-md-left">{{ __('Personal Apoyo 7') }}</label>
                    <input id="apoyo_7" type="text" class="form-control @error('apoyo_7') is-invalid @enderror" name="apoyo_7" 
                    title=""
                    value="{{$docentes_practica->docente_apoyo_7}}"  autocomplete="off" autofocus readonly>
                    
                    @error('apoyo_7')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="col-md-4" id="ap_8">
                    <label for="apoyo_8" class="col-form-label text-md-left">{{ __('Personal Apoyo 8') }}</label>
                    <input id="apoyo_8" type="text" class="form-control @error('apoyo_8') is-invalid @enderror" name="apoyo_8" 
                    title=""
                    value="{{$docentes_practica->docente_apoyo_8}}" autocomplete="off" autofocus readonly>
                    @error('apoyo_8')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="col-md-4" id="ap_9">
                    <label for="apoyo_9" class="col-form-label text-md-left">{{ __('Personal Apoyo 9') }}</label>
                    <input id="apoyo_9" type="text" class="form-control @error('apoyo_9') is-invalid @enderror" name="apoyo_9" 
                    title=""
                    value="{{$docentes_practica->docente_apoyo_9}}" autocomplete="off" autofocu readonly>
                    @error('apoyo_9')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="col-md-4" id="ap_10">
                    <label for="apoyo_10" class="col-form-label text-md-left">{{ __('Personal Apoyo 10') }}</label>
                    <input id="apoyo_10" type="text" class="form-control @error('apoyo_10') is-invalid @enderror" name="apoyo_10" 
                    title=""
                    value="{{$docentes_practica->docente_apoyo_10}}" autocomplete="off" autofocus readonly>
                    @error('apoyo_10')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            
        </div>
    <!-- 2.3 -->

<!-- información proyección -->

<br>
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
                        title=""
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
                <div class="col-md-2">
                    <label for="lugar_salida_rp" class="col-form-label text-md-left">{{ __('Sede Salida') }}</label>
                    <div class="input-group">
                        <select id="lugar_salida_rp" name="lugar_salida_rp" class="form-control" required disabled
                            title="" >
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

                <div class="col-md-3">
                    <div class="input-group">
                        <label for="fecha_salida_aprox_rp" class="col-form-label text-md-left">{{ __('Fecha/Hora Salida') }}</label>
                        <span class="hs-form-required">*</span>
                        <div class="row">
                            <div class="col-md-12" style="padding-right: 0;">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                        <input class="inputDate form-control datetimepicker" name="fecha_salida_aprox_rp" id="fecha_salida_aprox_rp" type="text" required
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0"
                                        value="{{$solicitud_practica->fecha_salida}}" onchange="duracion_edit_RP(this.value)" readonly disabled> 
                                    </div>
                                    <div class="col-md-5" style="padding-left: 0px;padding-right: 0px;">
                                        <input id="hora_salida_rp" type="text" class="form-control  @error('hora_salida_rp') is-invalid @enderror" name="hora_salida_rp" 
                                        style="padding-left: 0.5rem;padding-right: 0rem;border-top-left-radius: 0; border-bottom-left-radius: 0;margin-top: 1px;"
                                        value="{{$solicitud_practica->hora_salida}}" autocomplete="off" autofocus required readonly>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="lugar_regreso_rp" class="col-form-label text-md-left">{{ __('Sede Regreso') }}</label>
                    <div class="col-md-12" style="padding-right: 0;">
                        <div class="input-group">
                            <select id="lugar_regreso_rp" name="lugar_regreso_rp" class="form-control" required disabled
                                title="" >
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
                </div>

                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                    <div class="input-group">
                        <label for="fecha_regreso_aprox_rp" class="col-form-label text-md-left">{{ __('Fecha Regreso') }}</label>
                        <span class="hs-form-required">*</span>
                        <div class="row">
                            <div class="col-md-12" style="padding-right: 0;">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                        <input class="inputDate form-control datetimepicker" name="fecha_regreso_aprox_rp" id="fecha_regreso_aprox_rp" type="text" required
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0"
                                        value="{{$solicitud_practica->fecha_regreso}}" onchange="duracion_edit_RP(this.value)" readonly disabled>
                                    </div>
                                    <div class="col-md-5" style="padding-left: 0px;padding-right: 0px;">
                                        <input id="hora_regreso_rp" type="text" class="form-control  @error('hora_salida_rp') is-invalid @enderror" name="hora_regreso_rp" 
                                        style="padding-left: 0.5rem;padding-right: 0rem;border-top-left-radius: 0; border-bottom-left-radius: 0;margin-top: 1px;"
                                        value="{{$solicitud_practica->hora_regreso}}" autocomplete="off" autofocus required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-1">
                    <label for="duracion_edit_rp" class="col-form-label text-md-left">{{ __('Días') }}</label>
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
                    value="{{$transporte_proyeccion->docen_respo_trasnporte_rp}}" required autocomplete="off" autofocus readonly>
                    
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
                            value="{{$transporte_proyeccion->capac_transporte_rp_1}}"  autocomplete="off" autofocus readonly>

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

                                    {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
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

                                    {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
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

                                    {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 transporte_rp_3 -->
        @endif

        <br>
        <h4>Transporte Menor - Local</h4>
        <hr class="divider">

        <!-- cant t. menor -->
            <div  class="form-group row">
                <div class="col-md-2">
                    <label for="cant_trans_menor_rp" class="col-form-label text-md-left">{{ __('Cant. Vehículos') }}</label>
                    <div class="input-group">
                        <input id="cant_trans_menor_rp" type="number" max="4" min="0" pattern="^[1-4]+"  class="form-control @error('cant_trans_menor_rp') is-invalid @enderror" name="cant_trans_menor_rp" 
                        title=""
                        value="{{$transporte_menor->cant_trans_menor_rp}}" required autocomplete="off" autofocus readonly disabled>
                        
                        @error('cant_trans_menor_rp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <span class="input-group-btn">
                            <button class="btn btn-success btn_ver" type="button" id="ver_trans_menor_rp" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                            onclick="ver_t_menor_rp()"><i class="far fa-eye"></i></button>
                            <button class="btn btn-success btn_ver" type="button" id="ocul_trans_menor_rp" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                            onclick="ocul_t_menor_rp()"><i class="far fa-eye-slash"></i></button>
                        </span>
                    </div>
                </div>

                <div class="col-md-5" id="docente_trans_menor_rp">
                    <label for="docente_resp_t_menor_rp" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                    <input id="docente_resp_t_menor_rp" type="text" class="form-control @error('docente_resp_t_menor_rp') is-invalid @enderror" name="docente_resp_t_menor_rp" 
                    title=""
                    value="{{ $nombre_usuario }}" required autocomplete="off" autofocus readonly>
                    
                    @error('docente_resp_t_menor_rp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>
        <!-- cant t. menor -->

        <!-- 8 trans_menor_rp_1 -->
            <div class="form-group row" id="t_menor_rp_1">
                <div class="col-md-12" id="trans_menor_rp">
                    <div class="row" id="trans_menor_rp_children">

                        <div class="col-md-5">
                            <label for="trans_menor_rp_1" class="col-form-label text-md-left">{{ __('Transporte Menor 1') }}</label>
                            <input id="trans_menor_rp_1" type="text" class="form-control @error('trans_menor_rp_1') is-invalid @enderror" name="trans_menor_rp_1" 
                            title="" readonly
                            value="{{$transporte_menor->trans_menor_rp_1}}"  autocomplete="off" autofocus>
                
                            @error('trans_menor_rp_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="vlr_trans_menor_rp_1" class="col-form-label text-md-left">{{ __('Valor Transp.') }}</label>
                            <input id="vlr_trans_menor_rp_1" type="text" class="form-control @error('vlr_trans_menor_rp_1') is-invalid @enderror" name="vlr_trans_menor_rp_1" 
                            title="" readonly
                            value="{{number_format($transporte_menor->vlr_trans_menor_rp_1,'0',',','.')}}"  autocomplete="off" autofocus  onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                            @error('vlr_trans_menor_rp_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 trans_menor_rp_1 -->

        <!-- 8 trans_menor_rp_2 -->
            <div class="form-group row" id="t_menor_rp_2">
                <div class="col-md-12" id="trans_menor_rp">
                    <div class="row" id="trans_menor_rp_children">

                        <div class="col-md-5">
                            <label for="trans_menor_rp_2" class="col-form-label text-md-left">{{ __('Transporte Menor 2') }}</label>
                            <input id="trans_menor_rp_2" type="text" class="form-control @error('trans_menor_rp_2') is-invalid @enderror" name="trans_menor_rp_2" 
                            title="" readonly
                            value="{{$transporte_menor->trans_menor_rp_2}}"  autocomplete="off" autofocus>
                
                            @error('trans_menor_rp_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-2">
                            <label for="vlr_trans_menor_rp_2" class="col-form-label text-md-left">{{ __('Valor Transp.') }}</label>
                            <input id="vlr_trans_menor_rp_2" type="text" class="form-control @error('vlr_trans_menor_rp_2') is-invalid @enderror" name="vlr_trans_menor_rp_2" 
                            title="" readonly
                            value="{{number_format($transporte_menor->vlr_trans_menor_rp_2,'0',',','.')}}"  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" redonly>

                            @error('vlr_trans_menor_rp_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 trans_menor_rp_2 -->

        <!-- 8 trans_menor_rp_3 -->
            <div class="form-group row" id="t_menor_rp_3">
                <div class="col-md-12" id="trans_menor_rp">
                    <div class="row" id="trans_menor_rp_children">
                        
                        <div class="col-md-5">
                            <label for="trans_menor_rp_3" class="col-form-label text-md-left">{{ __('Transporte Menor 3') }}</label>
                            <input id="trans_menor_rp_3" type="text" class="form-control @error('trans_menor_rp_3') is-invalid @enderror" name="trans_menor_rp_3" 
                            title="" readonly
                            value="{{$transporte_menor->trans_menor_rp_3}}"  autocomplete="off" autofocus>
                
                            @error('trans_menor_rp_3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="vlr_trans_menor_rp_3" class="col-form-label text-md-left">{{ __('Valor Transp.') }}</label>
                            <input id="vlr_trans_menor_rp_3" type="text" class="form-control @error('vlr_trans_menor_rp_3') is-invalid @enderror" name="vlr_trans_menor_rp_3" 
                            title="" readonly
                            value="{{number_format($transporte_menor->vlr_trans_menor_rp_3,'0',',','.')}}"  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                            @error('vlr_trans_menor_rp_3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 trans_menor_rp_3 -->

        <!-- 8 trans_menor_rp_4 -->
            <div class="form-group row" id="t_menor_rp_4">
                <div class="col-md-12" id="trans_menor_rp">
                    <div class="row" id="trans_menor_rp_children">

                        <div class="col-md-5">
                            <label for="trans_menor_rp_4" class="col-form-label text-md-left">{{ __('Transporte Menor 4') }}</label>
                            <input id="trans_menor_rp_4" type="text" class="form-control @error('trans_menor_rp_4') is-invalid @enderror" name="trans_menor_rp_4" 
                            title="" readonly
                            value="{{$transporte_menor->trans_menor_rp_4}}"  autocomplete="off" autofocus>
                
                            @error('trans_menor_rp_4')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="vlr_trans_menor_rp_4" class="col-form-label text-md-left">{{ __('Valor Transp.') }}</label>
                            <input id="vlr_trans_menor_rp_4" type="text" class="form-control @error('vlr_trans_menor_rp_4') is-invalid @enderror" name="vlr_trans_menor_rp_4" 
                            title="" readonly
                            value="{{number_format($transporte_menor->vlr_trans_menor_rp_4,'0',',','.')}}"  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                            @error('vlr_trans_menor_rp_4')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 trans_menor_rp_4 --> 
        
        <br>
        <h4>Otros</h4>
        <hr class="divider">

        <!-- materiales -->
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="det_materiales_rp" class="col-form-label text-md-left" title="Materiales">{{ __('Materiales') }}</label>
                    {{-- <span class="hs-form-required">*</span> --}}
                    <input id="det_materiales_rp" type="text"  class="form-control @error('det_materiales_rp') is-invalid @enderror" name="det_materiales_rp" 
                    value="{{$mate_herra_proyeccion->det_materiales_rp}}" autocomplete="off" autofocus readonly>
                    
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
                    readonly>
                    
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
                    value="{{$mate_herra_proyeccion->det_guias_baquianos_rp}}" autocomplete="off" autofocus disabled>
                    
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
                    value="{{$mate_herra_proyeccion->det_otros_boletas_rp}}" autocomplete="off" autofocus disabled>
                    
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

        <br>
        <h4>Actividades de Riesgo</h4>
        <hr class="divider">

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

        <!-- viaticos -->
            {{-- <div class="form-group row">
                <div class="col-md-3">
                    <label for="vlr_apoyo_docentes_rp" class="col-form-label text-md-left" >{{ __('Valor Viáticos Docentes') }}</label>
                    <input id="vlr_apoyo_docentes_rp" type="text"  class="form-control @error('vlr_apoyo_docentes_rp') is-invalid @enderror" name="vlr_apoyo_docentes_rp" 
                    title="Valor de los viáticos a los docentes, equivalen a la duración de la práctica menos el 0.5"
                    value="$ {{number_format($costos_proyeccion->viaticos_docente_rp, 0, ',','.')}}" autocomplete="off" autofocus readonly>
                    
                    @error('vlr_apoyo_docentes_rp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="vlr_apoyo_estudiantes_rp" class="col-form-label text-md-left">{{ __('Valor Auxilio Estudiantes') }}</label>
                    <input id="vlr_apoyo_estudiantes_rp" type="text"  class="form-control @error('vlr_apoyo_estudiantes_rp') is-invalid @enderror" name="vlr_apoyo_estudiantes_rp" 
                    title="Valor de auxilio económico a estudiantes"
                    value="$ {{number_format($costos_proyeccion->viaticos_estudiantes_rp, 0, ',','.')}}" autocomplete="off" autofocus readonly>
                    
                    @error('vlr_apoyo_estudiantes_rp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                {{-- <div class="col-md-3">
                    <label for="trasnp_menor_rp" class="col-form-label text-md-left" title="Valor total del transporte menor">{{ __('Total Transporte Menor') }}</label>
                    <input id="trasnp_menor_rp" type="text"  class="form-control @error('trasnp_menor_rp') is-invalid @enderror" name="trasnp_menor_rp" 
                    value="" autocomplete="off" autofocus readonly>
                    
                    @error('trasnp_menor_rp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> 
            </div>--}}
        <!-- viaticos -->


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
                <div class="col-md-2">
                    <label for="lugar_salida_ra" class="col-form-label text-md-left">{{ __('Sede Salida') }}</label>
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

                <div class="col-md-3">
                    <div class="input-group">
                        <label for="fecha_salida_aprox_ra" class="col-form-label text-md-left">{{ __('Fecha/Hora Salida') }}</label>
                        <span class="hs-form-required">*</span>
                        <div class="row">
                            <div class="col-md-12" style="padding-right: 0;">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                        <input class="inputDate form-control datetimepicker" name="fecha_salida_aprox_ra" id="fecha_salida_aprox_ra" type="text" required
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0"
                                        value="{{$solicitud_practica->fecha_salida}}" onchange="duracion_edit_RA(this.value)" readonly disabled> 
                                    </div>
                                    <div class="col-md-5" style="padding-left: 0px;padding-right: 0px;">
                                        <input id="hora_salida_ra" type="text" class="form-control  @error('hora_salida_rp') is-invalid @enderror" name="hora_salida_ra" 
                                        style="padding-left: 0.5rem;padding-right: 0rem;border-top-left-radius: 0; border-bottom-left-radius: 0;margin-top: 1px;"
                                        value="{{$solicitud_practica->hora_salida}}" autocomplete="off" autofocus required readonly>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="lugar_regreso_ra" class="col-form-label text-md-left">{{ __('Sede Regreso') }}</label>
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

                <div class="col-md-3">
                    <div class="input-group">
                        <label for="fecha_regreso_aprox_ra" class="col-form-label text-md-left">{{ __('Fecha/Hora Regreso') }}</label>
                        <span class="hs-form-required">*</span>
                        <div class="row">
                            <div class="col-md-12" style="padding-right: 0;">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                        <input class="inputDate form-control datetimepicker" name="fecha_regreso_aprox_ra" id="fecha_regreso_aprox_ra" type="text" required
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0"
                                        value="{{$solicitud_practica->fecha_regreso}}" onchange="duracion_edit_RA(this.value)" readonly disabled> 
                                    </div>
                                    <div class="col-md-5" style="padding-left: 0px;padding-right: 0px;">
                                        <input id="hora_regreso_ra" type="text" class="form-control  @error('hora_regreso_ra') is-invalid @enderror" name="hora_regreso_ra" 
                                        style="padding-left: 0.5rem;padding-right: 0rem;border-top-left-radius: 0; border-bottom-left-radius: 0;margin-top: 1px;"
                                        value="{{$solicitud_practica->hora_regreso}}" autocomplete="off" autofocus required readonly>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                
                <div class="col-md-1">
                    <label for="duracion_edit_ra" class="col-form-label text-md-left">{{ __('Días') }}</label>
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

        @if($tipo_ruta == 2)

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
                    value="{{$transporte_proyeccion->docen_respo_trasnporte_ra}}" required autocomplete="off" autofocus readonly>
                    
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
                    value="{{$transporte_proyeccion->capac_transporte_ra_1}}"  autocomplete="off" autofocus readonly>
                    
                    @error('capac_transporte_ra_[]')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="det_tipo_transporte_ra_[]" class="col-form-label text-md-left">{{ __('Det. Vehíc.') }}</label>
                    <input id="det_tipo_transporte_ra_[]" type="text" class="form-control @error('det_tipo_transporte_ra_[]') is-invalid @enderror" name="det_tipo_transporte_ra_[]" 
                    value="{{$transporte_proyeccion->det_tipo_transporte_ra_1}}"  autocomplete="off" autofocus readonly>
                    
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

                            {{-- <a class="add_transp_rp imgButton" id="add_transp_rp" title="Add field"><img src="{{asset('img/add-icon.png')}}"/></a> --}}
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
        @endif

        <br>
        <h4>Transporte Menor - Local</h4>
        <hr class="divider">

        <!-- cant t. menor -->
            <div  class="form-group row">
                <div class="col-md-2">
                    <label for="cant_trans_menor_ra" class="col-form-label text-md-left">{{ __('Cant. Vehículos') }}</label>
                    <div class="input-group">
                        <input id="cant_trans_menor_ra" type="number" max="4" min="0" pattern="^[1-4]+"  class="form-control @error('cant_trans_menor_ra') is-invalid @enderror" name="cant_trans_menor_ra" 
                        title=""
                        value="{{$transporte_menor->cant_trans_menor_ra}}" required autocomplete="off" autofocus readonly disabled>
                        
                        @error('cant_trans_menor_ra')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <span class="input-group-btn">
                            <button class="btn btn-success btn_ver" type="button" id="ver_trans_menor_ra" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                            onclick="ver_t_menor_ra()"><i class="far fa-eye"></i></button>
                            <button class="btn btn-success btn_ver" type="button" id="ocul_trans_menor_ra" style="border: 1px solid #d1d3e2; border-top-left-radius: 0; border-bottom-left-radius: 0"
                            onclick="ocul_t_menor_ra()"><i class="far fa-eye-slash"></i></button>
                        </span>
                    </div>
                </div>

                <div class="col-md-5" id="docente_trans_menor_ra">
                    <label for="docente_resp_t_menor_ra" class="col-form-label text-md-left">{{ __('Docente Responsable') }}</label>
                    <input id="docente_resp_t_menor_ra" type="text" class="form-control @error('docente_resp_t_menor_ra') is-invalid @enderror" name="docente_resp_t_menor_ra" 
                    title=""
                    value="{{ $nombre_usuario }}" required autocomplete="off" autofocus readonly>
                    
                    @error('docente_resp_t_menor_ra')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

            </div>
        <!-- cant t. menor -->                         

        <!-- 8 trans_menor_ra_1 -->
            <div class="form-group row" id="t_menor_ra_1">
                <div class="col-md-12" id="trans_menor_ra">
                    <div class="row" id="trans_menor_ra_children">

                        <div class="col-md-5">
                            <label for="trans_menor_ra_1" class="col-form-label text-md-left">{{ __('Transporte Menor 1') }}</label>
                            <input id="trans_menor_ra_1" type="text" class="form-control @error('trans_menor_ra_1') is-invalid @enderror" name="trans_menor_ra_1" 
                            title="" readonly
                            value="{{$transporte_menor->trans_menor_ra_1}}"  autocomplete="off" autofocus>
                
                            @error('trans_menor_ra_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="vlr_trans_menor_ra_1" class="col-form-label text-md-left">{{ __('Valor Transp.') }}</label>
                            <input id="vlr_trans_menor_ra_1" type="text" class="form-control @error('vlr_trans_menor_ra_1') is-invalid @enderror" name="vlr_trans_menor_ra_1" 
                            title="" readonly
                            value="{{number_format($transporte_menor->vlr_trans_menor_ra_1,'0',',','.')}}"  autocomplete="off" autofocus  onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                            @error('vlr_trans_menor_ra_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 trans_menor_ra_1 -->                        

        <!-- 8 trans_menor_ra_2 -->
            <div class="form-group row" id="t_menor_ra_2">
                <div class="col-md-12" id="trans_menor_ra">
                    <div class="row" id="trans_menor_ra_children">

                        <div class="col-md-5">
                            <label for="trans_menor_ra_2" class="col-form-label text-md-left">{{ __('Transporte Menor 2') }}</label>
                            <input id="trans_menor_ra_2" type="text" class="form-control @error('trans_menor_ra_2') is-invalid @enderror" name="trans_menor_ra_2" 
                            title="" readonly
                            value="{{$transporte_menor->trans_menor_ra_2}}"  autocomplete="off" autofocus>
                
                            @error('trans_menor_ra_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-2">
                            <label for="vlr_trans_menor_ra_2" class="col-form-label text-md-left">{{ __('Valor Transp.') }}</label>
                                <input id="vlr_trans_menor_ra_2" type="text" class="form-control @error('vlr_trans_menor_ra_2') is-invalid @enderror" name="vlr_trans_menor_ra_2" 
                            title="" readonly
                            value="{{number_format($transporte_menor->vlr_trans_menor_ra_2,'0',',','.')}}"  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" redonly>

                            @error('vlr_trans_menor_ra_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 trans_menor_ra_2 -->                        

        <!-- 8 trans_menor_ra_3 -->
            <div class="form-group row" id="t_menor_ra_3">
                <div class="col-md-12" id="trans_menor_ra">
                    <div class="row" id="trans_menor_ra_children">
                        
                        <div class="col-md-5">
                            <label for="trans_menor_ra_3" class="col-form-label text-md-left">{{ __('Transporte Menor 3') }}</label>
                            <input id="trans_menor_ra_3" type="text" class="form-control @error('trans_menor_ra_3') is-invalid @enderror" name="trans_menor_ra_3" 
                            title=""
                            value="{{$transporte_menor->trans_menor_ra_3}}"  autocomplete="off" autofocus readonly>
                
                            @error('trans_menor_ra_3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="vlr_trans_menor_ra_3" class="col-form-label text-md-left">{{ __('Valor Transp.') }}</label>
                            <input id="vlr_trans_menor_ra_3" type="text" class="form-control @error('vlr_trans_menor_ra_3') is-invalid @enderror" name="vlr_trans_menor_ra_3" 
                            title="" readonly
                            value="{{number_format($transporte_menor->vlr_trans_menor_ra_3,'0',',','.')}}"  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                            @error('vlr_trans_menor_ra_3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 trans_menor_ra_3 -->                        

        <!-- 8 trans_menor_ra_4 -->
            <div class="form-group row" id="t_menor_ra_4">
                <div class="col-md-12" id="trans_menor_ra">
                    <div class="row" id="trans_menor_ra_children">

                        <div class="col-md-5">
                            <label for="trans_menor_ra_4" class="col-form-label text-md-left">{{ __('Transporte Menor 4') }}</label>
                            <input id="trans_menor_ra_4" type="text" class="form-control @error('trans_menor_ra_4') is-invalid @enderror" name="trans_menor_ra_4" 
                            title=""
                            value="{{$transporte_menor->trans_menor_ra_4}}"  autocomplete="off" autofocus readonly>
                
                            @error('trans_menor_ra_4')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="vlr_trans_menor_ra_4" class="col-form-label text-md-left">{{ __('Valor Transp.') }}</label>
                            <input id="vlr_trans_menor_ra_4" type="text" class="form-control @error('vlr_trans_menor_ra_4') is-invalid @enderror" name="vlr_trans_menor_ra_4" 
                            title="" readonly
                            value="{{number_format($transporte_menor->vlr_trans_menor_ra_4,'0',',','.')}}"  autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)" >

                            @error('vlr_trans_menor_ra_4')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        <!-- 8 trans_menor_ra_4 --> 

        <br>
        <h4>Otros</h4>
        <hr class="divider">

        <!-- materiales -->
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="det_materiales_ra" class="col-form-label text-md-left" title="">{{ __('Materiales') }}</label>
                    {{-- <span class="hs-form-required">*</span> --}}
                    <input id="det_materiales_ra" type="text"  class="form-control @error('det_materiales_ra') is-invalid @enderror" name="det_materiales_ra" 
                    value="{{$mate_herra_proyeccion->det_materiales_ra}}" autocomplete="off" autofocus readonly>
                    
                    @error('det_materiales_ra')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="vlr_materiales_ra" class="col-form-label text-md-left" title="">{{ __('Valor Total Materiales') }}</label>
                    {{-- <span class="hs-form-required">*</span> --}}
                    <input id="vlr_materiales_ra" type="text"  class="form-control @error('vlr_materiales_ra') is-invalid @enderror" name="vlr_materiales_ra" 
                    value="$ {{number_format($costos_proyeccion->vlr_materiales_ra,'0',',','.')}}" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)"
                    readonly>
                    
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
                    <label for="det_guias_baquia_ra" class="col-form-label text-md-left" title="">{{ __('Guías y/o Baquianos') }}</label>
                    <input id="det_guias_baquia_ra" type="text"  class="form-control @error('det_guias_baquia_ra') is-invalid @enderror" name="det_guias_baquia_rp" 
                    title=""
                    value="{{$mate_herra_proyeccion->det_guias_baquianos_ra}}" autocomplete="off" autofocus disabled>
                    
                    @error('det_guias_baquia_rp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="vlr_guias_baquia_ra" class="col-form-label text-md-left" title="">{{ __('Valor Total Guías y/o Baquianos') }}</label>
                    {{-- <span class="hs-form-required">*</span> --}}
                    <input id="vlr_guias_baquia_ra" type="text"  class="form-control @error('vlr_guias_baquias_ra') is-invalid @enderror" name="vlr_guias_baquia_ra" 
                    title="" disabled
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
                    title=""
                    value="{{$mate_herra_proyeccion->det_otros_boletas_ra}}" autocomplete="off" autofocus disabled>
                    
                    @error('det_otros_bolet_ra')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="vlr_otros_bolet_ra" class="col-form-label text-md-left" title="">{{ __('Valor Total Boletas y/u Otros') }}</label>
                    {{-- <span class="hs-form-required">*</span> --}}
                    <input id="vlr_otros_bolet_ra" type="text"  class="form-control @error('vlr_otros_bolet_ra') is-invalid @enderror" name="vlr_otros_bolet_ra" 
                    title="" disabled
                    value="{{number_format($costos_proyeccion->vlr_otros_boletas_ra,'0',',','.')}}" autocomplete="off" autofocus onkeyup="formatVlr(this)" onchange="formatVlr(this)">
                    
                    @error('vlr_otros_bolet_ra')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        <!-- otros - boletas --> 

        <br>
        <h4>Actividades de Riesgo</h4>
        <hr class="divider">

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
                            <input type="checkbox" name="areas_acuaticas_ra" id="areas_acuaticas_ra" 
                            <?php if($riesg_amen_practica->areas_acuaticas_ra == 1) echo 'checked'?> 
                            onchange="customAlerts(this, 2,1)" disabled>
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
                            <input type="checkbox" name="alturas_ra" id="alturas_ra" 
                            <?php if($riesg_amen_practica->alturas_ra == 1) echo 'checked'?> 
                            onchange="customAlerts(this, 2,2)" disabled>
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
                            <input type="checkbox" name="riesgo_biologico_ra" id="riesgo_biologico_ra" <?php if($riesg_amen_practica->riesgo_biologico_ra == 1) echo 'checked'?> 
                            onchange="customAlerts(this, 2,3)" disabled>
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
                            <input type="checkbox" name="espacios_confinados_ra" id="espacios_confinados_ra" <?php if($riesg_amen_practica->espacios_confinados_ra == 1) echo 'checked'?> 
                            onchange="customAlerts(this, 2,4)" disabled>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <!-- 4 -->

            </div>
        <!-- preguntas -->

        <!-- viaticos -->
            {{-- <div class="form-group row">
                <div class="col-md-3">
                    <label for="vlr_apoyo_docentes_ra" class="col-form-label text-md-left" >{{ __('Valor Viáticos Docentes') }}</label>
                    <input id="vlr_apoyo_docentes_ra" type="text"  class="form-control @error('vlr_apoyo_docentes_ra') is-invalid @enderror" name="vlr_apoyo_docentes_ra" 
                    title="Valor de los viáticos a los docentes, equivalen a la duración de la práctica menos el 0.5"
                    value="$ {{number_format($costos_proyeccion->viaticos_docente_ra, 0, ',','.')}}" autocomplete="off" autofocus readonly>
                    
                    @error('vlr_apoyo_docentes_ra')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="vlr_apoyo_estudiantes_ra" class="col-form-label text-md-left" >{{ __('Valor Auxilio Estudiantes') }}</label>
                    <input id="vlr_apoyo_estudiantes_ra" type="text"  class="form-control @error('vlr_apoyo_estudiantes_ra') is-invalid @enderror" name="vlr_apoyo_estudiantes_ra" 
                    title="Valor de auxilio económico a estudiantes"
                    value="$ {{number_format($costos_proyeccion->viaticos_estudiantes_ra, 0, ',','.')}}" autocomplete="off" autofocus readonly>
                    
                    @error('vlr_apoyo_estudiantes_ra')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                {{-- <div class="col-md-3">
                    <label for="trasnp_menor_rp" class="col-form-label text-md-left" title="Valor total del transporte menor">{{ __('Total Transporte Menor') }}</label>
                    <input id="trasnp_menor_rp" type="text"  class="form-control @error('trasnp_menor_rp') is-invalid @enderror" name="trasnp_menor_rp" 
                    value="" autocomplete="off" autofocus readonly>
                    
                    @error('trasnp_menor_rp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> --}}
        <!-- viaticos -->

    <!-- ruta alterna -->
@endif

<br>
<h4>Detalle Presupuesto</h4>
<hr class="divider">
<br>

@if($tipo_ruta == 1)
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 50px">Concepto</th>
            <th style="width: 60px">N° Docen. / N° Estud.</th>
            <th style="width: 45px">Valor Diario</th>
            <th style="width: 30px">N° Días Pern.</th>
            <th style="width: 70px">Total</th>
        </thead> 
    
        <tr>
        <td>Viáticos Docentes: </td>
        <td>{{ $practicas_integradas->cant_espa_aca + $docentes_practica->num_docentes_apoyo + 1 }}</td>
            <td>135.400</td>
        <td>{{ $proyeccion_preliminar->duracion_num_dias_rp }}</td>
        <td>{{ number_format($costos_proyeccion->viaticos_docente_rp, 0, ',','.') }}</td>
        
        </tr>

        <tr>
            <td>Viáticos Estudiantes: </td>
            <td>{{ $solicitud_practica->num_estudiantes }}</td>
            <td>52.600</td>
            <td>{{ $proyeccion_preliminar->duracion_num_dias_rp }}</td>
            <td>{{ number_format($costos_proyeccion->viaticos_estudiantes_rp, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Materiales: </td>
            <td colspan="3">{{$mate_herra_proyeccion->det_materiales_rp}}</td>
            <td>{{ number_format($costos_proyeccion->vlr_materiales_rp, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Guías - Baquianos: </td>
            <td colspan="3">{{$mate_herra_proyeccion->det_guias_baquianos_rp}}</td>
            <td>{{ number_format($costos_proyeccion->vlr_guias_baquianos_rp, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Boletas - Otros: </td>
            <td colspan="3">{{$mate_herra_proyeccion->det_otros_boletas_rp}}</td>
            <td>{{ number_format($costos_proyeccion->vlr_otros_boletas_rp, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Transporte Menor: </td>
            <td colspan="3">Nota: valor sujeto al transporte que se contrata en sitio por parte del docente responsable. </td>
            <td>{{ number_format($costos_proyeccion->costo_total_transporte_menor_rp, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Servicio Transporte: </td>
            <td colspan="3">Nota: valor sujeto a contrato suscrito entre la facultad y las empresas de transporte. Se recomienda solicitar concepto en la decanatura para establecer costos del recorrido.</td>
            <td>{{ number_format($costos_proyeccion->valor_estimado_transporte_rp, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td colspan="4">Total Presupuesto: </td>
            <td>{{ number_format($costos_proyeccion->viaticos_estudiantes_rp + $costos_proyeccion->viaticos_docente_rp + $costos_proyeccion->valor_estimado_transporte_rp + $costos_proyeccion->vlr_materiales_rp + $costos_proyeccion->vlr_guias_baquianos_rp + $costos_proyeccion->vlr_otros_boletas_rp + $costos_proyeccion->costo_total_transporte_menor_rp, 0, ',','.') }}</td>
            
        </tr>
    </table>
@endif

@if($tipo_ruta == 2)
    <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
        <thead>
            <th style="width: 50px">Concepto</th>
            <th style="width: 60px">N° Docen. / N° Estud.</th>
            <th style="width: 45px">Valor Diario</th>
            <th style="width: 30px">N° Días Pern.</th>
            <th style="width: 70px">Total</th>
        </thead> 
    
        <tr>
        <td>Viáticos Docentes: </td>
        <td>{{ $practicas_integradas->cant_espa_aca + $docentes_practica->num_docentes_apoyo + 1 }}</td>
        <td>135.400</td>
        <td>{{ $proyeccion_preliminar->duracion_num_dias_ra }}</td>
        <td>{{ number_format($costos_proyeccion->viaticos_docente_ra, 0, ',','.') }}</td>
        
        </tr>

        <tr>
            <td>Viáticos Estudiantes: </td>
            <td>{{ $solicitud_practica->num_estudiantes }}</td>
            <td>52.600</td>
            <td>{{ $proyeccion_preliminar->duracion_num_dias_ra }}</td>
            <td>{{ number_format($costos_proyeccion->viaticos_estudiantes_ra, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Materiales: </td>
            <td colspan="3">{{$mate_herra_proyeccion->det_materiales_ra}}</td>
            <td>{{ number_format($costos_proyeccion->vlr_materiales_ra, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Guías - Baquianos: </td>
            <td colspan="3">{{$mate_herra_proyeccion->det_guias_baquianos_ra}}</td>
            <td>{{ number_format($costos_proyeccion->vlr_guias_baquianos_ra, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Boletas - Otros: </td>
            <td colspan="3">{{$mate_herra_proyeccion->det_otros_boletas_ra}}</td>
            <td>{{ number_format($costos_proyeccion->vlr_otros_boletas_ra, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Transporte Menor: </td>
            <td colspan="3">Nota: valor sujeto al transporte que se contrata en sitio por parte del docente responsable.</td>
            <td>{{ number_format($costos_proyeccion->costo_total_transporte_menor_ra, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td>Servicio Transporte: </td>
            <td colspan="3">Nota: valor sujeto a contrato suscrito entre la facultad y las empresas de transporte. Se recomienda solicitar concepto en la decanatura para establecer costos del recorrido.</td>
            <td>{{ number_format($costos_proyeccion->valor_estimado_transporte_ra, 0, ',','.') }}</td>
            
        </tr>

        <tr>
            <td colspan="4">Total Presupuesto: </td>
            <td>{{ number_format($costos_proyeccion->viaticos_estudiantes_ra + $costos_proyeccion->viaticos_docente_ra + $costos_proyeccion->valor_estimado_transporte_ra + $costos_proyeccion->vlr_materiales_ra + $costos_proyeccion->vlr_guias_baquianos_ra + $costos_proyeccion->vlr_otros_boletas_ra + $costos_proyeccion->costo_total_transporte_menor_ra, 0, ',','.') }}</td>
            
        </tr>
    </table>
@endif

<!-- estado dec-->
    <!-- 0 -->
        <div class="form-group row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="id_estado">
                        <i class="fas fa-question-circle" 
                        data-toggle="tooltip" data-placement="left" 
                        data-title="Asigne uno de los estados a la salida de práctica académica" style="font-size: 0.813rem"></i> Estado Área de Decanatura</label>
                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="aprobacion_decano" value="5"
                            <?php if($solicitud_practica->aprobacion_decano == 5) echo 'checked'?>>
                            <label class="form-check-label" for="">Pendiente</label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id=v_b_dec_solic>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="aprobacion_decano" value="7"
                            <?php if($solicitud_practica->aprobacion_decano == 7) echo 'checked'?>>
                            <label class="form-check-label" for="">Visto Bueno</label>
                            </div>
                        </div>

                        {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="aprobacion_decano"  value="4" 
                                <php if($solicitud_practica->aprobacion_decano == 4) echo 'checked'?>>
                                <label class="form-check-label" for="">Rechazado</label>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    <!-- 0 -->
<!-- estado dec-->

{{-- @if($tipo_ruta == 3) --}}
@if($proyeccion_preliminar->aprobacion_consejo_facultad != 3)
    <br>
    <h4>Observaciones</h4>
    <hr class="divider">
    <br>

    <!-- Coordinador-->
        <!-- 18 -->
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="observ_coordinador" class="col-form-label text-md-left">{{ __('Observaciones Coordinador') }}</label>
                    <textarea id="observ_coordinador" style="min-height:5rem;" type="text" class="form-control @error('observ_coordinador') is-invalid @enderror" name="observ_coordinador" 
                    autocomplete="off" autofocus readonly><?php echo $proyeccion_preliminar->observ_coordinador?></textarea>

                    @error('observ_coordinador')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        <!-- 18 -->

        <!-- 19 -->
            <!-- estado coord-->
            <!-- 0 -->
            <div class="form-group row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="id_estado">Estado Área de Coordinación</label>
                    <div class="row">

                        {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="id_estado" value="1"
                            <php if($proyeccion_preliminar->aprobacion_coordinador == 5) echo 'checked'?>  disabled>
                            <label class="form-check-label" for="">Pendiente</label>
                            </div>
                        </div> --}}

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="id_estado" value="7"
                            <?php if($solicitud_practica->aprobacion_coordinador == 7) echo 'checked'?>  disabled>
                            <label class="form-check-label" for="">Visto Bueno</label>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
            <!-- 0 -->
            <!-- estado coord-->
        <!-- 19 -->

    <!-- Coordinador-->


    <!-- Decano -->
        <!-- 20 -->
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="observ_decano" class="col-form-label text-md-left">
                        <i class="fas fa-question-circle" 
                        data-toggle="tooltip" data-placement="left" 
                        data-title="Indique las observaciones asociadas a la salida de práctica académica" style="font-size: 0.813rem"></i> {{ __('Observaciones Decano') }}</label>
                    <textarea id="observ_decano" style="min-height:5rem;" type="text" class="form-control @error('observ_decano') is-invalid @enderror" name="observ_decano" value="{{ old('observ_decano') }}" 
                    autocomplete="off" autofocus></textarea>

                    @error('observ_decano')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        <!-- 20 -->

        <!-- 21 -->
    
            <!-- estado dec-->
                <!-- 0 -->
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="id_estado">Estado Área de Decanatura</label>
                                <div class="row">

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="aprobacion_decano" value="5"
                                        <?php if($solicitud_practica->aprobacion_decano == 5) echo 'checked'?>
                                        <?php if($proyeccion_preliminar->aprobacion_consejo_facultad == 3) echo 'disabled'?>>
                                        <label class="form-check-label" for="">Pendiente</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="aprobacion_decano" value="7"
                                        <?php if($solicitud_practica->aprobacion_decano == 7) echo 'checked'?>
                                        <?php if($proyeccion_preliminar->aprobacion_consejo_facultad == 3) echo 'disabled'?>>
                                        <label class="form-check-label" for="">Visto bueno</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="aprobacion_decano"  value="4" 
                                            <?php if($solicitud_practica->aprobacion_decano == 4) echo 'checked'?>
                                            <?php if($proyeccion_preliminar->aprobacion_consejo_facultad == 3) echo 'disabled'?>>
                                            <label class="form-check-label" for="">Rechazado</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <!-- 0 -->
            <!-- estado dec-->
            {{-- @endif --}}

            {{-- @if($proyeccion_preliminar->aprobacion_consejo_facultad == 3)

                <br>
                <h4>Estado</h4>
                <hr class="divider">
                <br>
                <!-- estado proyección-->
                        <!-- 1 -->
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="estado_proyeccion">Estado Proyección Preliminar</label>
                                        <div class="row">

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="estado_proyeccion" value="1"
                                                <php if($proyeccion_preliminar->id_estado == 1) echo 'checked'?>>
                                                <label class="form-check-label" for="">Activo</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="estado_proyeccion" value="2"
                                                <php if($proyeccion_preliminar->id_estado == 2) echo 'checked'?>>
                                                <label class="form-check-label" for="">Inactivo</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>        
                    <!-- 1 -->
                <!-- estado proyección-->    
            @endif --}}
        <!-- 21 -->

    <!-- Decano -->
@endif
