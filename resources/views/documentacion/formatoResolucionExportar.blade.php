
<!DOCTYPE HTML>

<html  lang="es"> 
<head>
    <style>

        P{font-family:"Arial, sans-serif";font-size:10pt}
        .page-break {
        /* page-break-before: none; */
        page-break-after: always;
        position:fixed;bottom:0cm;left:0cm;right:0cm;height:110px;
        }
		.page-break-before {
        page-break-before: always;
        position:fixed;bottom:0cm;left:0cm;right:0cm;height:110px;
        }
        textarea{font-family:"Arial, sans-serif";font-size:10pt;
        border:none}

        footer{position:fixed;bottom:0cm;left:0cm;right:0cm;height:1cm;}
        .tb_th_piepagina{font-family:"Arial, sans-serif";font-size:4pt}
        .tb_piepagina{font-family:"Arial, sans-serif";font-size:4pt}
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>

<body>  
        
    <table width="85%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr><td>
        <div align="center" style="margin-top: -35px;"> <img src="{{ public_path('img/logo_ud.png') }}" alt="" width="180" height="150"/></div>
        <p align="center"><span class="larger"><strong>FACULTAD DEL MEDIO AMBIENTE Y RECURSOS NATURALES</strong> </span><br><br>
        <strong>RESOLUCIÓN NÚMERO <?=$solicitud_practica[0]->num_resolucion?> DE {{$f_resolucion['num']}} DE 
            {{mb_strtoupper($f_resolucion['mes'])}} DE {{$f_resolucion['anio']}}</strong>
        <br><br>
        “Por la cual se autoriza un avance a un Docente para el desarrollo de una actividad académica”</p>
        <p align="justify">La Decana de la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas, 
        en uso de sus atributos legales, estatutarias, y</p>
        
        <p align="center"><strong>CONSIDERANDO</strong></p>
       
        <p align="justify"><?= $parrafos_modificables->parr_1?></p>
        <p align="justify"><?= $parrafos_modificables->parr_2?></p>
        <p align="justify"><?= $parrafos_modificables->parr_3?></p>
        <p align="justify"><?= $parrafos_modificables->parr_4?></p>
        <p align="justify"><?= $parrafos_modificables->parr_5?></p>
        <p align="justify"><?= $parrafos_modificables->parr_6?></p>
        <p align="justify"><i><?= $parrafos_modificables->parr_6_1?></i></p>
        <p align="justify"><?= $parrafos_modificables->parr_7?></p>
        <p align="justify"><?= $parrafos_modificables->parr_9?> {{$f_plan_prac['num']}} de {{$f_plan_prac['mes']}} Acta No <?= $solicitud_practica[0]->num_acta_consejo_facultad?> de {{$f_plan_prac['anio']}}.</p>
        
        <div class="page-break">
            <br><br><br><br>
        <table class="table table-bordered" width="80%" style="border-collapse: collapse;margin-left: auto;margin-right: auto;">
            <tr>
                <th style="border: 1px solid; width: 10%"></th>
                <th style="border: 1px solid; width: 30%" class="tb_th_piepagina"><strong>NOMBRE</strong></th>
                <th style="border: 1px solid; width: 30%" class="tb_th_piepagina"><strong>CARGO</strong></th>
                <th style="border: 1px solid; width: 30%" class="tb_th_piepagina" colspan="2"><strong>FIRMA</strong></th>
              </tr>
              <tr>
                <td style="border: 1px solid;" class="tb_piepagina"><strong> Revisó</strong></td>
                <td style="border: 1px solid;" class="tb_piepagina"> Angélica Osorio Gaviria</td>
                <td style="border: 1px solid;" class="tb_piepagina"> Asistente CPS</td>
                <td style="border: 1px solid;text-align: center" class="tb_piepagina" colspan="2"><strong> AOG</strong></td>
              </tr>
              <tr>
                <td style="border: 1px solid;" class="tb_piepagina"><strong> Aprobó:</strong></td>
                <td style="border: 1px solid;" class="tb_piepagina"> {{$decano->full_name}}</td>
                <td style="border: 1px solid;" class="tb_piepagina"> Decano FAMARENA</td>
                <td style="border: 1px solid;" colspan="2"></td>
              </tr>
        </table>
        </div>
        <p align="center"><strong>RESUELVE</strong></p>
        
        <p align="justify"> <strong>ARTÍCULO PRIMERO:</strong>
            Autorizar el trámite y pago de un avance a nombre del(la) docente <?php echo mb_strtoupper($solicitud_practica[0]->full_name)?> identificado(a) con 
            <?= $solicitud_practica[0]->tipo_identificacion?> No.<?= $solicitud_practica[0]->id_docente_responsable?> para cubrir los gastos de la práctica académica de los Proyectos Curriculares de 
                          @php
                           $arr_proyecto = array();
                           $arr_cdp = array();
                           foreach($solicitud_practica as $sol){
                                $arr_proyecto[] = $sol->programa_academico;
                                $arr_cdp[] = $sol->num_cdp;
                           }
                           $new_proy = array_unique($arr_proyecto,SORT_REGULAR);
                           $new_cdp = array_unique($arr_cdp, SORT_REGULAR);
                        @endphp
            @foreach($new_proy as $proy)
                <?php echo mb_strtoupper($proy).', '?> 
            @endforeach
            del presupuesto descrito en el siguiente cuadro, con Disponibilidad Presupuestal
            @foreach($new_cdp as $cdp) 
            	<?php if(!empty($cdp) || $sol->num_cdp != $cdp){echo $cdp;} else {echo '____';}?>,
	    @endforeach
            :<br>
        </p>
        <div align="center" style="margin-top:0cm;margin-bottom:0cm;margin-left: -5px;margin-right: -5px;">
            <table class="table table-bordered" width="85%" style="border-collapse: collapse;">                
				<tr>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:70pt">ASIGNATURA</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:55pt">DOCENTES</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:50pt">SITIO DE DESARROLLO</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:42pt">FECHA</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:25pt">No. DÍAS</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:52.5pt">VIATICOS DOCENTES</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:52.5pt">AUXILIO ESTUDIANTES</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:52.5pt">TRANSPORTE MENOR/LOCAL</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:57.5pt">OTROS</th>
                    <th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:35pt">TOTAL DISPONIBILIDAD</th>
				</tr>               
                
                @foreach($solicitud_practica as $sol)							
                    <tr>				
                        <td style="border: 1px solid;">													
                            <!--<p class="MsoNormal" style="text-align:center;margin-top: 4px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>-->
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                    @foreach ($espa_pract_int as $item)
                                        <?php if($sol->id == $item['id_proy']) echo $item['espacio_academico'] ?>
                                    @endforeach</span>
                            </p>
                            <!--<p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>-->
                        </td>
                        <td style="border: 1px solid;">
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                    @foreach ($doce_pract_int as $item) 
                                        @foreach ($espa_pract_int as $esp_pr) 
                                                <?php if($esp_pr['id_docente'] == $item['id'] && $sol->id == $esp_pr['id_proy'])echo $item['full_name'];?>
                                            {{-- <br> --}}
                                            {{-- <br> --}}
                                            {{--  --}}
                                        @endforeach
                                        <br><br>
                                    @endforeach
                                    @if(!is_null($sol->docente_apoyo_1))
					{{ ucwords(strtolower($sol->docente_apoyo_1)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_2))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_2)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_3))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_3)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_4))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_4)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_5))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_5)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_6))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_6)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_7))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_7)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_8))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_8)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_9))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_9)) }}
                                    @endif
                                    @if(!is_null($sol->docente_apoyo_10))
                                        <br><br>
                                        {{ ucwords(strtolower($sol->docente_apoyo_10)) }}
                                    @endif
                                    </span>
                                </span>
                            </p>
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>
                        </td>
                        <td style="border: 1px solid;">
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                    <?php if($sol->tipo_ruta == 1) echo $sol->destino_rp; 
                                    elseif($sol->tipo_ruta == 2){echo $sol->destino_ra;}?></span>
                            </p>
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>
                        </td>
                        <td style="border: 1px solid;font-size: 5.5pt;text-align:center">
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                    {{-- @foreach($f_sal_reg as $fechas) --}}
                                        <?php echo $sol->fecha_salida?><br>al<br><?php echo $sol->fecha_regreso?> 
                                    {{-- @endforeach  --}}
                                </span>
                            </p>
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>
                        </td>
                        <td style="border: 1px solid;font-size: 5.5pt;text-align:center">
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                            <span >&nbsp;</span>
                            </p>
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                    <?= $sol->duracion_num_dias?></span>
                            </p>
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                            </p>
                        </td>
                        <td style="border: 1px solid;">
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                                </p>
                                <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                    <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                         @foreach($total_asistentes as $t_asi)
                                            @if($sol->id == $t_asi['id_proy'])
                                                
                                                @php
                                                   $cadena = "";
                                                   if($sol->duracion_num_dias > 1){
                                                      $cadena = strval(number_format($control_sistema->vlr_docen_max,0,',','.'));
                                                   } else 
                                                      if($sol->duracion_num_dias == 1) {
                                                         $cadena = strval(number_format($control_sistema->vlr_docen_min,0,',','.'));
                                                      }
						   $cadena = $cadena . ' * ' . ((int)$t_asi['num_docentes']) . ' * ';
                                                   if($sol->duracion_num_dias > 1){
                                                      $cadena = $cadena . strval($sol->duracion_num_dias-0.5);
                                                   } else if($sol->duracion_num_dias == 1){
                                                      $cadena = $cadena . strval($sol->duracion_num_dias);
                                                   }
                                                   
                                                   foreach($viaticos_docente as $item){
                                                      if($sol->id == $item['id_proy']){
                                                         if($item['vlr_viaticos_docente'] <> 0){
                                                            echo $cadena . '<br>';
                                                         }
                                                         echo '= $'.number_format($item['vlr_viaticos_docente'],0,',','.');   
                                                      }
                                                   }
						   
                                                @endphp
                                            @endif
                                        @endforeach
                                        </span>
                                </p>
                                <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                    <span >&nbsp;</span>
                                </p>
                        </td>
                        <td style="border: 1px solid;">
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                                </p>
                                <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                    <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                        @foreach($total_asistentes as $t_asi)
                                            @if($sol->id == $t_asi['id_proy'])
                                                @php
                                                   $cadena = "";
                                                   if($sol->duracion_num_dias > 1){
                                                      $cadena = strval(number_format($control_sistema->vlr_estud_max,0,',','.'));
                                                   } else 
                                                      if ($sol->duracion_num_dias == 1) {
                                                         $cadena = strval(number_format($control_sistema->vlr_estud_min,0,',','.'));
                                                      }
                                                   $cadena = $cadena . ' * ' . $t_asi['num_estudiantes'] . ' * ' . strval($sol->duracion_num_dias);
                                                   foreach($viaticos_estudiante as $item){
                                                      if($sol->id == $item['id_proy']){
                                                         if($item['vlr_viaticos_estudiantes'] <> 0){
                                                           echo $cadena . '<br>'; 
                                                         }
                                                         echo '= $'. strval(number_format($item['vlr_viaticos_estudiantes'],0,',','.'));
                                                      }
                                                   }
                                                @endphp 
                                            @endif
                                        @endforeach
                                        </span>
                                </p>
                                <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                    <span >&nbsp;</span>
                                </p>
                        </td>

                        <td style="border: 1px solid;">
                            
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                    @foreach($vlr_trans_menor as $item)
                                        <?php if($sol->id == $item['id_proy']) echo '$'.number_format($item['vlr_total_transporte_menor'],0,',','.')?>
                                    @endforeach
                                </span>
                                
                            </p>
                        </td>

                        <td style="border: 1px solid;">
                            @foreach($vlr_materiales as $item)
                                @if($sol->id == $item['id_proy'])
                                    <p class="MsoNormal" style="text-align:center;margin-top:0px;margin-bottom: 0px;" align="center">
                                        <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                            <strong>MATERIALES:</strong> ${{number_format($item['vlr_materiales'],0,',','.')}}</span>
                                        <!-- <br> -->
                                        <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                            <strong>GUÍAS/BAQUIANOS:</strong> ${{number_format($item['vlr_guias_baquianos'],0,',','.')}}</span>
                                        <!-- <br>     -->
                                        <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                            <strong>BOLETAS/OTROS:</strong> ${{number_format($item['vlr_otros_boletas'],0,',','.')}}</span>
                                    </p>
                                    <hr class="divider">
                                    <p class="MsoNormal" style="text-align:center;margin-top: 0px;margin-bottom: 0px;" align="center">
                                        <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                            <strong>TOTAL OTROS</strong></span>
                                        <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                        ${{number_format($item['vlr_materiales'] + $item['vlr_guias_baquianos'] + $item['vlr_otros_boletas'],0,',','.')}}</span>
                                        <!-- <br> -->
                                    </p>
                                @endif
                            @endforeach
                        </td>

                        <td style="border: 1px solid;">
                            
                            <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                <span >&nbsp;</span>
                                </p>
                                <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
                                    <span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
                                        @foreach($presupuesto as $item)
                                            @if($sol->id == $item['id_proy'])
						<strong>CDP {{$sol->num_cdp}}</strong><br><br>
                                                ${{number_format($item['total_presupuesto'],0,',','.')}}
                                            @endif
                                        @endforeach
                                        </span>
                                </p>
                                <!-- <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
                                    <span >&nbsp;</span>
                                </p> -->
								@if($loop->last)
									<tr>
										<td colspan="9" style="border: 1px solid;">
											<!-- <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
												<span >&nbsp;</span>
											</p> -->
											<p class="MsoNormal" style="text-align:left;margin-top: 3px;margin-bottom: 0px;margin-left: 12px;" align="center">
												<span style="font-size:6.3pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
												<strong>TOTAL</strong>
												<!-- <br><br> -->
												</span>
											</p>
											<!-- <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
												<span >&nbsp;</span>
											</p> -->
										</td>
										<td colspan="1" style="border: 1px solid;">
											
											<!-- <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
												<span >&nbsp;</span>
											</p> -->
											<p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;" align="center">
												<span style="font-size:6.3pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
												<?php echo '$'.number_format($sumatoria_presupuesto,0,',','.')?>
												<!-- <br><br> -->
												</span>
											</p>
											<!-- <p class="MsoNormal" style="text-align:center;margin-top: 3px;margin-bottom: 0px;height:5px" align="center">
												<span >&nbsp;</span>
											</p> -->
										</td>
									</tr>
									<tr>
									<td colspan="10">
									<ul style="margin-top: 0px;margin-bottom: 0px;">
									  <li><p align="justify"><?= $parrafos_modificables->parr_11?> {{ number_format($vlr_viaticos->vlr_docen_max,0,',','.')}}</p></li>
									  <li><p align="justify"><?= $parrafos_modificables->parr_12?> {{ number_format($vlr_viaticos->vlr_estud_min,0,',','.')}}</p></li>
									  <li><p align="justify"><?= $parrafos_modificables->parr_13?> {{ number_format($vlr_viaticos->vlr_estud_max,0,',','.')}}</p></li>
									</ul> 
									<div class="page-break"></div>
									</td>
									</tr>						
								@endif
							
								@if($loop->iteration % 5 == 0)
									<div class="page-break" style="border: 0px;"></div>	
								@endif															
                        </td>  					
                    </tr>
					@if($loop->iteration == 5 && $loop->count > 5)
					<tr>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:70pt">ASIGNATURA</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:55pt">DOCENTES</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:50pt">SITIO DE DESARROLLO</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:42pt">FECHA</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:25pt">No. DÍAS</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:52.5pt">VIATICOS DOCENTES</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:52.5pt">AUXILIO ESTUDIANTES</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:52.5pt">TRANSPORTE MENOR/LOCAL</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:57.5pt">OTROS</th>
						<th style="border: 1px solid; font-size: 6.3pt;text-align: center;width:35pt">TOTAL DISPONIBILIDAD</th>
					</tr>    
					@endif	
				
                @endforeach
				@foreach($solicitud_practica as $sol)
				
				@endforeach
            </table>                    
        </div>
        <!--<ul>
          <li><p align="justify"><?= $parrafos_modificables->parr_11?> {{ number_format($vlr_viaticos->vlr_docen_max,0,',','.')}}</p></li>
          <li><p align="justify"><?= $parrafos_modificables->parr_12?> {{ number_format($vlr_viaticos->vlr_estud_min,0,',','.')}}</p></li>
          <li><p align="justify"><?= $parrafos_modificables->parr_13?> {{ number_format($vlr_viaticos->vlr_estud_max,0,',','.')}}</p></li>
        </ul>-->
		
        <p align="justify"> <strong>ARTÍCULO SEGUNDO:</strong>
            <?= $parrafos_modificables->parr_14?></p>
        <p align="justify"> <strong>ARTÍCULO TERCERO:</strong>
            <?= $parrafos_modificables->parr_15?></p>
        <p align="justify"> <strong>ARTÍCULO CUARTO:</strong>
            <?= $parrafos_modificables->parr_16?></p>
        <p align="justify"> <strong>ARTÍCULO QUINTO:</strong>
            <?= $parrafos_modificables->parr_17?></p>
        <p align="justify"> <strong>ARTÍCULO SEXTO:</strong>
            <?= $parrafos_modificables->parr_8?></p>
        
        <p align="center"><strong>COMUNÍQUESE Y CÚMPLASE</strong></p>
        <p>Dada en la Decanatura de la Facultad del Medio Ambiente y Recursos Naturales a los 
        {{strtolower(ucfirst($hoy_letras->format($f_resolucion['num'])))}} ({{$f_resolucion['num']}}) días del mes de {{$f_resolucion['mes']}} de {{$f_resolucion['anio']}}.</p>
        <br>
        
        <div align="center" style="margin-bottom: -27px;">
            <img src="{{ $firma_lito }}" alt="" style="width: 200px; height:45px;" >
        </div> 
        <p align="CENTER"><strong><span class="larger">________________________________________________</strong></span></p>
        <p align="CENTER"><strong><span class="larger">{{$decano->full_name}}<br>
        Decano Facultad del Medio Ambiente y Recursos Naturales</strong></span></p>
        
        </td></tr>
    </table>  
    <footer>
        <table class="table table-bordered" width="80%" style="border-collapse: collapse;margin-left: auto;margin-right: auto;">
            <tr>
                <th style="border: 1px solid; width: 10%"></th>
                <th style="border: 1px solid; width: 30%" class="tb_th_piepagina"><strong>NOMBRE</strong></th>
                <th style="border: 1px solid; width: 30%" class="tb_th_piepagina"><strong>CARGO</strong></th>
                <th style="border: 1px solid; width: 30%" class="tb_th_piepagina" colspan="2"><strong>FIRMA</strong></th>
              </tr>
              <tr>
                <td style="border: 1px solid;" class="tb_piepagina"><strong> Revisó</strong></td>
                <td style="border: 1px solid;" class="tb_piepagina"> Angélica Osorio Gaviria</td>
                <td style="border: 1px solid;" class="tb_piepagina"> Asistente CPS</td>
                <td style="border: 1px solid;text-align: center" class="tb_piepagina" colspan="2"><strong> AOG</strong></td>
              </tr>
              <tr>
                <td style="border: 1px solid;" class="tb_piepagina"><strong> Aprobó:</strong></td>
                <td style="border: 1px solid;" class="tb_piepagina"> {{$decano->full_name}}</td>
                <td style="border: 1px solid;" class="tb_piepagina"> Decano FAMARENA</td>
                <td style="border: 1px solid;" colspan="2"></td>
              </tr>
        </table>
    </footer>
</body>
</html>
        
