<!DOCTYPE HTML>

<html  lang="es"> 
<head>
	<style>
	P{font-family:"Arial, sans-serif";font-size:9pt}
	li{font-family:"Arial, sans-serif";font-size:9pt}
	.page-break {
    page-break-after: always;
	}
	ul {
        list-style-type: none;
        font-family:"Arial, sans-serif";
        font-size:9pt;
    }
    ul > li:before {
        content: "–";
        position: absolute;
        margin-left: -1.1em; 
    }

    footer{position:fixed;bottom:0cm;left:0cm;right:0cm;height:2.5cm;}
    .tb_th_piepagina{font-family:"Arial, sans-serif";font-size:4pt}
    .tb_piepagina{font-family:"Arial, sans-serif";font-size:4pt}
	</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>

<body>
	
	<table width="85%" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr><td>
		<img src="{{ public_path('img/logoHeader.png') }}" alt="" style="display: inline-block; width: 255px; top: 28px; margin: 0"/>
		<table width="60%">
			<tr>
				<td style="font-weight:bolder;text-align:left">
					<p>
						<strong><span class="larger"><?= $parrafos_modificables->parr_1?>{{$solicitud_practica[0]->consec_dfamarena}}-{{$hoy['anio']}}</span></strong>
					</p>
				</td>
				<td style="font-weight:bolder;text-align:right">
					<p><strong><span class="larger">{{$solicitud_practica[0]->consec_cordis}}</span></strong></p>
				</td>
			</tr>
		</table>

		{{-- <br><br> --}}
		<p>Bogotá, {{$hoy['num']}} de {{ucfirst($hoy['mes'])}} de {{$hoy['anio']}}</p>
		{{-- <br>	 --}}
			
		<p align="justify">Doctor <br>
		<strong>{{$parrafos_modificables->parr_2}}</strong><br>
		{{$parrafos_modificables->parr_3}}<br>
		Universidad Distrital Francisco José de Caldas <br>
		Ciudad <br>
		</p>

		<p align="justify">{{$parrafos_modificables->parr_4}}</p>

		<p align="justify">Comedidamente me dirijo a usted con el fin de solicitarle se sirva expedir Registro Presupuestal y tramitar 
			avance académico a nombre del docente {{$solicitud_practica[0]->full_name}} {{$solicitud_practica[0]->tipo_identificacion}} 
			con No.{{$solicitud_practica[0]->id_docente_responsable}} por valor de ${{ number_format($presupuesto,0,',','.')}} con cargo 
			al rubro PRÁCTICAS ACADÉMICAS de la Facultad del Medio Ambiente y Recursos Naturales, discriminado así: 
			@if($viaticos_docente >0)Viático docente: ${{number_format($viaticos_docente,0,',','.')}},@endif 
			Auxilio estudiantes: ${{number_format($viaticos_estudiante,0,',','.')}}
			@if($vlr_materiales >0), Materiales: ${{number_format($vlr_materiales,0,',','.')}}@endif
			@if($vlr_baquianos >0), Baquianos/Guías: ${{number_format($vlr_baquianos,0,',','.')}}@endif
			@if($vlr_boletas >0), Boletas/Otros: ${{number_format($vlr_boletas,0,',','.')}}@endif
			@if($transporte_menor >0) y Transporte Menor/Local: ${{number_format($transporte_menor,0,',','.')}}@endif
			; lo anterior, para garantizar el desarrollo de la práctica académica 
			@foreach($espa_pract_int as $item)
				@if($item['fecha_salida']['num'] == $item['fecha_regreso']['num'])
					<?php echo $item['espacio_academico'].', a realizarse el '.$item['fecha_salida']['num'].' de '.$item['fecha_regreso']['mes'].' del '.$item['fecha_regreso']['anio'].
					' del Proyecto Curricular de '.$item['programa_academico'].'. '?>
				@else
					<?php echo $item['espacio_academico'].', a realizarse del '.$item['fecha_salida']['num'].' al '.$item['fecha_regreso']['num'].' de '.$item['fecha_regreso']['mes'].' del '.$item['fecha_regreso']['anio'].
					' del Proyecto Curricular de '.$item['programa_academico'].'. '?>
				@endif
			@endforeach 
			La(s) práctica(s) objeto del presente oficio hace(n) parte del Plan de Prácticas del año {{$f_plan_prac['anio']}}, el cual fue aprobado por el 
			Consejo de Facultad en sesión del {{$f_plan_prac['num']}} de {{ucfirst($f_plan_prac['mes'])}} Acta No {{$solicitud_practica[0]->num_acta_consejo_facultad}}; por lo cual me permito anexar la documentación soporte 
			correspondiente. </p>

		<p align="justify">Adjunto.</p>
		{{-- <br>	 --}}

		<ul>
			<li>Oficio {{$parrafos_modificables->parr_1}}{{$solicitud_practica[0]->consec_dfamarena}}-{{$hoy['anio']}}, 
				Resolución N° <?php if($solicitud_practica[0]->num_resolucion == NULL) {echo '____';}else{echo $solicitud_practica[0]->num_resolucion;} ?> de {{$f_resol['num']}} de {{ucfirst($f_resol['mes'])}} de {{$f_resol['anio']}}, 
				Autorización de Giro, 
				Solicitud de Avance y Formato de Solicitud de las prácticas, consolidados en un archivo pdf.</li>
                        @php
                           $arr_necesidad = array();
                           $arr_cdp = array();
                           foreach($solicitud_practica as $sol){
                           	$arr_necesidad[] = $sol->num_solicitud_necesidad;
                                $arr_cdp[] = $sol->num_cdp;
                           }
                           $new_necesidad = array_unique($arr_necesidad,SORT_REGULAR);
                           $new_cdp = array_unique($arr_cdp, SORT_REGULAR);
                        @endphp
			<li>Solicitud de Necesidad @foreach($new_necesidad as $nec) No.{{$nec}}, @endforeach</li>
			<li>Disponibilidad Presupuestal @foreach($new_cdp as $cdp) No.{{$cdp}}, @endforeach</li>
			<li>Copia correo aval trámite del avance expedido por la sección de tesorería</li>
		</ul> 

		<br>
		<p align="justify">Agradeciendo la colaboración prestada.</p>

		<p align="justify">Cordialmente,</p>

		<br>

		<div  style="margin-bottom: -27px;">
			<img src="{{ $firma_lito }}" alt="" style="width: 200px; height:45px;">
		</div>
		{{-- <p align="justify"><strong><span class="larger">_________________________</strong></span></p> --}}
		<p align="justify" style="font-size: 10pt"><strong>{{$decano->full_name}}</strong><br>
		<strong>{{$parrafos_modificables->parr_1}}{{$solicitud_practica[0]->consec_dfamarena}}-{{$hoy['anio']}}</strong><br>
			Decano Facultad del Medio Ambiente y Recursos Naturales<br>
			Universidad Distrital Francisco José de Caldas <br>
			{{$parrafos_modificables->parr_5}}<br>
			dmedioa@udistrital.edu.co<br>
		</p>
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
                <td style="border: 1px solid;text-align: center" class="tb_piepagina" colspan="2"><strong>AOG</strong></td>
              </tr>
              <tr>
                <td style="border: 1px solid;" class="tb_piepagina"><strong> Aprobó:</strong></td>
                <td style="border: 1px solid;" class="tb_piepagina"> {{$decano->full_name}}</td>
                <td style="border: 1px solid;" class="tb_piepagina"> Decano FAMARENA</td>
                <td style="border: 1px solid;" colspan="2"></td>
              </tr>
        </table>

		<hr style="width:85%;text-align:center;border:1px solid">
		<div class="row">
			<div class="col-8"><p style="float: left; margin-left:8%;font-size:6pt;">PBX 57(1)3239300 Ext.4000<br>
				Carrera 5 este No. 15 - 82, Av. Circunvalar, Bogotá D.C,-Colombia<br>
				Acreditación Institucional de Alta Calidad. Resolución No. 23096 del 15 de diciembre de 2016</p></div>
			<div class="col-4"><p style="float: right;margin-right:8%;font-size:6pt;">Línea de atención gratuita<br>
				01 800 091 44 10<br>
				www.udistrital.edu.co<br>
				dmedioa@udiistrital.edu.co<br></div>
		</div>
	</footer>

</body>
</html>
