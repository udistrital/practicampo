
<!DOCTYPE HTML>


<title>PRÁCTICA</title>
<style>
P{font-family:"Arial, sans-serif";font-size:10pt}
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;
        overflow:hidden;padding-top:4px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;
    font-weight:normal;overflow:hidden;padding-top:4px;word-break:normal;}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
.tg .tg-nrix{text-align:center;vertical-align:middle}
.tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
.tg .tg-wp8o{border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-mqa1{border-color:#000000;font-weight:bold;text-align:center;vertical-align:top}

.page-break {
page-break-after: always;
}
header{position:fixed;}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<!-- end: tool_blocks.sbi_html_head --></head>
<body>
    <header style="width:100%; margin: left 10px;">
        <table class="tg" style="table-layout:fixed;width:699px;">
            <thead>
            <tr>
                <th class="tg-0lax" rowspan="3"><p style="text-align: center; margin:0;" width="120"><img src="{{ public_path('img/logo_ud.png') }}" alt="" width="120" height="100"/></p></th>
                <th class="tg-nrix" colspan="2"><span style="font-weight:bold">FORMATO DE PRÁCTICAS ACADÉMICAS</span></th>
                <th class="tg-nrix">Código: GS-PR-010-FR-008</th>
                <th class="tg-0lax" rowspan="3"><p style="text-align: center; margin:0;padding-top: 10px;"><img src="{{ public_path('img/SIGUD.png') }}" alt="" height="80"/></p></th>
            </tr>
            <tr>
                
                <td class="tg-nrix" colspan="2">Macroproceso: Gestión Académica</td>
                <td class="tg-nrix">Versión: 02</td>
            </tr>
            <tr>
                <td class="tg-nrix" colspan="2">Proceso: Gestión de Docencia</td>
                <td class="tg-baqh">Fecha de Aprobación:<br> 04/10/2017</td>
            </tr>
            </thead>
        </table>
    </header>

    <div style="text-align:center; margin-top: 90;">
        <table>
            <div style="margin: 0 auto;width: 94%">
                <p align="center"><strong><span class="larger">FORMATO DE PRÁCTICAS ACADÉMICAS</strong></span></p>
                <p style="margin-left: 50px"><strong><span class="larger">1. Información básica práctica académica:
                    @foreach ($espa_pract_int as $item) 
                        <?= $item['espacio_academico']?>
                    @endforeach
                    </strong></span>
                </p>
                <table class="tg" style="margin: 0 auto;width: 90%;">
                    {{-- <colgroup>
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                        <col style="width: 4.431rem">
                    </colgroup> --}}
                    <thead>
                        <tr>
                            <th class="tg-0pky" colspan="">Fecha De Solicitud</th>
                            <th class="tg-0pky" colspan="20"><?= $fecha_solicitud?></th><br>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="tg-0pky" colspan="">Proyecto Curricular</td>
                        <td class="tg-0pky" colspan="20"><?= $solicitud_practica->programa_academico?></td><br>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="">Docente Responsable</td>
                        <td class="tg-0pky"  colspan="8">
                            @foreach ($doce_pract_int as $item) 
                                <p  style="margin: 0rem;font-size: 10.5px"><?= $item['full_name']?></p>
                            @endforeach 
                        </td>
                        <td class="tg-0pky" colspan="6">Tipo de Vinculación</td>
                        <td class="tg-0pky" colspan="6">
                            @foreach ($doce_pract_int as $item) 
                                <p  style="margin: 0rem;font-size: 10.5px"><?= $item['tipo_vinculacion']?></p>
                            @endforeach 
                        </td><br>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="">Teléfono de Contacto</td>
                        <td class="tg-0pky" colspan="6">
                            @foreach ($doce_pract_int as $item) 
                                <p style="margin: 0rem;font-size: 10.5px"><?= $item['celular']?></p>
                            @endforeach 
                        </td>
                        <td class="tg-0pky" colspan="6">Correo Docente</td>
                        <td class="tg-0pky" colspan="8">
                            @foreach ($doce_pract_int as $item) 
                                <p style="margin: 0rem;font-size: 10.5px"><?= $item['email']?></p>
                            @endforeach
                        </td><br>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="">Nombre de la asignatura</td>
                        <td class="tg-0pky" colspan="12">
                            @foreach ($espa_pract_int as $item) 
                                <p style="margin: 0rem;font-size: 10.5px"><?= $item['espacio_academico']?></p>
                            @endforeach
                        </td>
                        <td class="tg-0pky" colspan="4" style="padding-right: 0">Código Asignatura</td>
                        <td class="tg-0pky" colspan="4" style="width: 12%">
                            @foreach ($espa_pract_int as $item) 
                                <p style="margin: 0rem;font-size: 10.5px"><?= $item['codigo_espacio_academico']?></p>
                            @endforeach
                        </td><br>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="">Período Academico</td>
                        <td class="tg-0pky" colspan="12"><?= $solicitud_practica->anio_periodo?> - <?= $solicitud_practica->periodo_academico?></td>
                        <td class="tg-0pky" colspan="4">Semetre Asignatura</td>
                        <td class="tg-0pky" colspan="4"><?= $solicitud_practica->semestre_asignatura?></td><br>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="">Número de Estudiantes</td>
                        <td class="tg-0pky" colspan="2"><?= $solicitud_practica->num_estudiantes?></td>
                        <td class="tg-0pky" colspan="8">Número de Grupos:</td>
                        <td class="tg-0pky" colspan="2"><?= $solicitud_practica->cantidad_grupos?></td>
                        <td class="tg-0pky" colspan="4">Total Docentes</td>
                        <td class="tg-0pky" colspan="4">{{$practicas_integradas->cant_espa_aca + $docentes_practica->total_docentes_apoyo + 1}}</td><br>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="">Fecha y Hora de Salida</td>
                        <td class="tg-0pky" colspan="4"><?= $solicitud_practica->fecha_salida?> <br> <?= $solicitud_practica->hora_salida?></td>
                        <td class="tg-0pky" colspan="4">Fecha y Hora de Regreso</td>
                        <td class="tg-0pky" colspan="4"><?= $solicitud_practica->fecha_regreso?> <br> <?= $solicitud_practica->hora_regreso?></td>
                        <td class="tg-0pky" colspan="4">Duración (días)</td>
                        <td class="tg-0pky" colspan="4"><?= $solicitud_practica->duracion_num_dias?></td><br>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="">Número de Vehiculos</td>
                        <td class="tg-0pky" colspan="2"><?php if($solicitud_practica->tipo_ruta == 1) echo "$transporte_proyeccion->cant_transporte_rp"; 
                        elseif ($solicitud_practica->tipo_ruta == 2) {echo $transporte_proyeccion->cant_transporte_ra;}?></td>
                        <td class="tg-0pky" colspan="9">Tipo de Vehículo</td>
                        <td class="tg-0pky" colspan="3">{{$t_transporte->tp_1}}</td>
                        <td class="tg-0pky" colspan="3">{{$t_transporte->tp_2}}</td>
                        <td class="tg-0pky" colspan="3">{{$t_transporte->tp_3}}</td><br>
                    </tr>
    
                    <tr>
                        <td class="tg-0pky" colspan="">CRONOGRAMA</td>
                        <td class="tg-0pky" colspan="20" ><?= $solicitud_practica->cronograma?>
                        <br></td>
                        <br>
                    </tr>
                    </tbody>
                </table>
                <div class="page-break">
                </div>
                {{-- <br> --}}
                <p style="margin-left: 50px; margin-top: 130px"><strong><span class="larger">2. Detalle del Presupuesto</strong></span></p>
                <table class="tg" style="margin: 0 auto;width: 90%;">
                    <colgroup>
                    <col style="width: 159px">
                    <col style="width: 211px">
                    <col style="width: 101px">
                    <col style="width: 187px">
                    <col style="width: 153px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="tg-0lax">Concepto</th>
                            <th class="tg-0lax">No. _De Docentes / Estudiantes</th>
                            <th class="tg-0lax">Valor Diario</th>
                            <th class="tg-0lax">No. De Días Pernoctados</th>
                            <th class="tg-baqh">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tg-0lax">Viáticos Docentes:</td>
                            <td class="tg-0lax" style="text-align: center"><?= $practicas_integradas->cant_espa_aca + $docentes_practica->total_docentes_apoyo + 1?></td>
                            <td class="tg-0lax" style="text-align: center">$ <?php if($solicitud_practica->duracion_num_dias > 1) echo $valor_diario->vlr_docen_max; 
                                elseif ($solicitud_practica->duracion_num_dias <= 1) {echo $valor_diario->vlr_docen_min;}?></td>
                            <td class="tg-0lax" style="text-align: center"><?= $solicitud_practica->duracion_num_dias?></td>
                            <td class="tg-0lax" style="text-align: center">$ <?= number_format($viaticos_docente, 0, ',','.')?></td>
                        </tr>
                        <tr>
                            <td class="tg-0lax">Viáticos Estudiantes:</td>
                            <td class="tg-0lax" style="text-align: center"><?= $solicitud_practica->num_estudiantes?></td>
                            <td class="tg-0lax" style="text-align: center">$ <?php if($solicitud_practica->duracion_num_dias > 1) echo $valor_diario->vlr_estud_max; 
                            elseif($solicitud_practica->duracion_num_dias <= 1) {echo $valor_diario->vlr_estud_min;}?></td>
                            <td class="tg-0lax" style="text-align: center"><?= $solicitud_practica->duracion_num_dias?></td>
                            <td class="tg-0lax" style="text-align: center">$ <?= number_format($viaticos_estudiante, 0, ',','.')?></td>
                        </tr>
                        <tr>
                            <td class="tg-cly1">Otros</td>
                            <td class="tg-0lax" colspan="3">Nota: valor sujeto a los materiales, guías/baquianos, boletas/otros.</td>
                            <td class="tg-0lax" style="text-align: center">$ <?= number_format($total_otros, 0, ',','.')?></td>
                        </tr>
                        <tr>
                            <td class="tg-cly1">Servicios de Transporte</td>
                            <td class="tg-0lax" colspan="3">Nota: valor sujeto al transporte que se contrata en sitio por parte del docente responsable.</td>
                            <td class="tg-0lax" style="text-align: center">$ <?= number_format($transporte_menor, 0, ',','.')?></td>
                        </tr>
                        <tr>
                            <td class="tg-baqh" colspan="4">Total presupuesto práctica académica:</td>
                            <td class="tg-0lax" style="text-align: center">$ {{ number_format($presupuesto, 0, ',','.') }}</td>
                        </tr>
                        <tr>
                            <th class="tg-0lax" colspan="5"><strong>Observaciones:</strong> <br><?= $solicitud_practica->observaciones?></th>
                        </tr>
                    </tbody>
                </table>
                {{-- <br>  --}}
                {{-- <br> --}}

                

                <p style="margin-left: 50;margin-top: 20;"><strong><span class="larger">3. Presentación Práctica Académica</strong></span></p>
                <table class="tg" style="margin: 0 auto;width: 90%;">
                    <colgroup>
                        <col style="width: 699px">
                    </colgroup>
                        <tr>
                            <th class="tg-0lax"><strong>Justificación:</strong><br><?= $solicitud_practica->justificacion?></th>
                        </tr>
                    
                        <tr>
                            <td class="tg-0lax"><strong>Objetivo General:</strong> <br><?= $solicitud_practica->objetivo_general?></td>
                        </tr>
                        <tr>
                            <td class="tg-0lax"><strong>Metodología de trabajo y evaluación:</strong><br><?= $solicitud_practica->metodologia_evaluacion?></td>
                        </tr>
                </table>
    
                <p style="margin-left: 50px"><strong><span class="larger">4. Firmas</strong></span></p>
    
                {{-- <br> --}}
                {{-- <br> --}}
                <div style="margin: 0 auto;width: 100%">
                    <table style="margin: 0 auto;width: 100%;">
          
                        <tr>
                          <td>
                            <div  style="margin-bottom: -27px;text-align: center; height:45px;">
                                @if($docente_responsable->tiene_firma == 1)
                                <img src="{{ $firma_lito_docente }}" alt="" style="width: 150px; height:45px;">
                                @endif
                            </div>
                            <p align="CENTER" style="font-size: 10px"><strong><span class="larger">_______________________________</strong></span></p>
                            <p align="CENTER" style="font-size: 10px"><strong><span class="larger">Docente Responsable:</span></strong></p>
                            <p align="CENTER" style="margin-top: 0;font-size: 10px"><strong><span class="larger">CC:{{$solicitud_practica->id_docente_responsable}}</span></strong></p>
                          </td>
                          <td>
                            <div  style="margin-bottom: -27px;text-align: center; height:45px;">
                              <img src="{{ $firma_lito_coord }}" alt="" style="width: 150px; height:45px;">
                            </div>
                            <p align="JUSTIFY" style="text-align: center;font-size: 10px"><strong><span class="larger">_______________________________</strong></span></p>
                            <p align="JUSTIFY" style="text-align: center;font-size: 10px"><strong><span class="larger">V°B° Consejo de carrera:</span></strong></p>
                            <p align="JUSTIFY" style="text-align: center;font-size: 10px"><strong><span class="larger">Coordinador Proyecto Curricular</span></strong></p>
                          </td>
                          <td>
                            <div  style="margin-bottom: -27px;text-align: center; height:45px;">
                              <img src="{{ $firma_lito_decano }}" alt="" style="width: 150px; height:45px;">
                            </div>
                            <p align="JUSTIFY" style="text-align: center;font-size: 10px"><strong><span class="larger">_______________________________</strong></span></p>
                            <p align="JUSTIFY" style="text-align: center;font-size: 10px"><strong><span class="larger">V°B° Ordenador del gasto:</span></strong></p>
                            <p align="JUSTIFY" style="text-align: center;font-size: 10px"><strong><span class="larger">Decano de la facultad</span></strong></p>
                          </td>
                        </tr>
                      </table>
                </div> 

                <div class="page-break"></div>
                <p style="margin-top: 100; text-align: center"><strong><span class="larger">FORMATO PARA PRESENTAR LISTAS DE ESTUDIANTES</strong></span></p>

                @if($num_apoyo > 0)
                    <p align="JUSTIFY"><strong><span class="larger">PERSONAL DE APOYO</strong></span></p>
                    <table class="tg" style="margin: 0 auto;width: 94%">
                        <colgroup>
                            <col style="width: 10px">
                            <col style="width: 453px">
                            <col style="width: 233px">
                            <col style="width: 203px">
                        </colgroup>
                        <thead>
                            <tr>
                            <th class="tg-amwm">N°.</th>
                            <th class="tg-amwm">Nombres y Apellidos</th>
                            <th class="tg-amwm">Doc. De Identidad</th>
                            <th class="tg-amwm">Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $x = 1 ?>
                            @foreach ($acompaniantes as $acompa)
                                            
                                <tr>
                                <td class="tg-0lax">{{$x}}</td>
                                <td class="tg-0lax">{{$acompa["nombre"]}}</td>
                                <td class="tg-0lax">{{$acompa["identificacion"]}}</td>
                                <td class="tg-0lax">{{$acompa["tipo"]}}</td>
                                </tr>
                                <?= $x = $x+1 ?>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <p align="center"><strong><span class="larger">Práctica de 
                    @foreach ($espa_pract_int as $item) 
                        <?= $item['espacio_academico']?>
                    @endforeach
                    </strong></span>
                </p>

                <table class="tg" style="margin: 0 auto;width: 90%">
                    <colgroup>
                        <col style="width: 10px">
                        <col style="width: 303px">
                        <col style="width: 143px">
                        <col style="width: 143px">
                        <col style="width: 114px">
                        <col style="width: 105px">
                        <col style="width: 110px">
                        <col style="width: 64px">
                        <col style="width: 52px">
                    </colgroup>
                    <tr>
                    <th class="tg-amwm">N°.</th>
                    <th class="tg-amwm">Nombres y Apellidos</th>
                    <th class="tg-amwm">Doc. De Identidad</th>
                    <th class="tg-amwm">Código</th>
                    <th class="tg-amwm">EPS</th>
                    <th class="tg-amwm">Celular</th>
                    <th class="tg-amwm">Estado</th>
                    <th class="tg-amwm">Grupo</th>
                    </tr>
                    <tbody>
                    <?= $x = 1 ?>
                        @foreach ($estudiantes as $est)
                                
                            <tr>
                            <td class="tg-0lax">{{$x}}</td>
                            <td class="tg-0lax">{{$est->nombre_completo}}</td>
                            <td class="tg-0lax">{{$est->num_identificacion}}</td>
                            <td class="tg-0lax">{{$est->num_identificacion}}</td>
                            <td class="tg-0lax">{{$est->eps}}</td>
                            <td class="tg-0lax">{{$est->celular}}</td>
                            <td class="tg-0lax"></td>
                            <td class="tg-0lax">{{$est->grupo}}
                            @if($loop->iteration % 43 == 0)
                                <div class="page-break" style="border: 0px;"></div>	
                            @endif                            	
                            </td>
                            
                            </tr>
                            <?= $x = $x+1 ?>
                            @if($loop->iteration == 43)
                                <div style="border: 0px; margin-top: 130px;"></div>	
                                <tr>
                    <th class="tg-amwm">N°.</th>
                    <th class="tg-amwm">Nombres y Apellidos</th>
                    <th class="tg-amwm">Doc. De Identidad</th>
                    <th class="tg-amwm">Código</th>
                    <th class="tg-amwm">EPS</th>
                    <th class="tg-amwm">Celular</th>
                    <th class="tg-amwm">Estado</th>
                    <th class="tg-amwm">Grupo</th>
                    </tr>
                            @endif	
                        @endforeach
                    </tbody>                    
                </table>


                {{-- <p align="JUSTIFY"><strong><span class="larger">Observaciones</strong></span></p>
                <p align="JUSTIFY"><span class="larger">1.	La lista de estudiantes debe estar conforme a la presentación de los documentos soporte 
                    de cada estudiante que participara en la Práctica académica.</span></p>
                <p align="JUSTIFY"><span class="larger">2.	La presentación de los documentos soportes de cada estudiante se debe realizar en una sola hoja por ambas caras.</span></p> --}}
            </div>
        </table>
    </div>

</body>
</html>
