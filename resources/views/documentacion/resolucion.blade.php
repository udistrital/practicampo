@extends ('layouts.app')
@section ('contenido')  
  
  <div class="container-fluid">
      <div class="card-header">{{ __('Resolución Avance Prácticas Académicas') }}</div>
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
              <div class="form-group">
                {{-- <a href="{{url('persona_natural/create') }}"><button class="btn btn-success" >Nuevo</button></a> --}}
              </div>
            </div>
            
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  {{-- @include('persona.natural.search') --}}
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

	<form method="POST" action="">
		@method('PUT')
		@csrf

		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			</div>

			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="border-style: solid;padding: 20px;">
				
				<div class="WordSection1 margenGral">

					<p align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					
					<p class="margenParrCent" align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">FACULTAD
						DEL MEDIO AMBIENTE Y RECURSOS NATURALES<o:p></o:p></span></b>
					</p>
					
					<p align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					
					<p class="margenParrCent" align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">RESOLUCIÓN
						NÚMERO XXXX DE XXXX<o:p></o:p></span></b>
					</p>
					
					<p align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					
					<p class="margenParrCent" align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">“</span></b>
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">Por
						la cual se autoriza un avance a un Docente para el desarrollo de una actividad
						académica”<o:p></o:p></span>
					</p>
					
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<p class="margenParrJust">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
						La Decana de la Facultad del Medio Ambiente y Recursos Naturales de la Universidad
						Distrital Francisco José de Caldas, en uso de sus atributos legales,
						estatutarias, y<o:p></o:p></span>
					</p>
					
					<p ><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					
					<p class="margenParrCent" align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">CONSIDERANDO<o:p></o:p></span></b>
					</p>
					
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					
					<!-- 1er parrafo -->
					<p class="margenParrJust">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
						<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_1?>
						</textarea>
						<o:p></o:p></span>
					</p>
					<!-- 1er parrafo -->
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<!-- 2do parrafo -->
					<p class="margenParrJust">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_2?>
							</textarea>
						<o:p></o:p></span>
					</p>
					<!-- 2do parrafo -->
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<!-- 3er parrafo -->
					<p class="margenParrJust">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_3?>
							</textarea>
						<o:p></o:p></span>
					</p>
					<!-- 3er parrafo -->
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<!-- 4to parrafo -->
					<p class="margenParrJust">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_4?>
							</textarea>
						<o:p></o:p></span>
					</p>
					<!-- 4to parrafo -->
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<!-- 5to parrafo -->
					<p class="margenParrJust">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_5?>
							</textarea>
						<o:p></o:p></span>
					</p>
					<!-- 5to parrafo -->
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					<!-- 6to parrafo -->
					<p class="margenParrJust" style="mso-layout-grid-align:none;text-autospace:none">
						<span style="font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_6?>
							</textarea>
						</span><i>
						<!-- 6to.1 parrafo -->
						<span style="font-size:9.0pt;mso-fareast-font-family:Calibri;mso-ansi-language:ES-CO">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_6_1?>
							</textarea>
						<o:p></o:p></span></i>
						<!-- 6to.1 parrafo -->
					</p>
					<!-- 6to parrafo -->
					
					<!-- 7to parrafo -->
					<p class="margenParrJust"><i>
						<span style="font-size:9.0pt;mso-fareast-font-family:Calibri;mso-ansi-language:ES-CO">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_7?>
							</textarea></span></i>
						<span style="font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p></o:p></span>
					</p>
					<!-- 7to parrafo -->
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					<!-- 8vo parrafo -->
					<p class="margenParrJust">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_8?>
							</textarea><o:p></o:p></span>
					</p>
					<!-- 8vo parrafo -->
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					<!-- 9no parrafo -->
					<p class="margenParrJust" >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							Que los planes de prácticas de los diferentes Proyectos Curriculares adscritos a la
							Facultad del Medio Ambiente y Recursos Naturales se aprobaron por el Consejo de
							Facultad mediante sesión del (día) de (mes) Acta No (XXX) de (año).<o:p></o:p></span>
					</p>
					<!-- 9no parrafo -->
					<p >
						<span style="font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<div align="center" style="margin-top:0cm;margin-bottom:0cm;margin-bottom:.0001pt;margin-left: -30px;margin-right: -30px;">
					<table style="border: solid;">
						<tr>
							<th style="border: solid; font-size: 6.5pt;text-align: center;width:57pt">ASIGNATURA</th>
							<th style="border: solid; font-size: 6.5pt;text-align: center;width:64pt">DOCENTES</th>
							<th style="border: solid; font-size: 6.5pt;text-align: center;width:124pt">SITIO DE DESARROLLO</th>
							<th style="border: solid; font-size: 6.5pt;text-align: center;width:42pt">FECHA</th>
							<th style="border: solid; font-size: 6.5pt;text-align: center;width:25pt">No. DÍAS</th>
							<th style="border: solid; font-size: 6.5pt;text-align: center;width:67.5pt">VIATICOS DOCENTES</th>
							<th style="border: solid; font-size: 6.5pt;text-align: center;width:67.5pt">AUXILIO ESTUDIANTES</th>
							<th style="border: solid; font-size: 6.5pt;text-align: center;width:35pt">TOTAL DISPONIBILIDAD</th>
						</tr>
						{{-- @foreach ($solicitudes_practica as $item)  --}}
						<tr>
							<td rowspan="2" style="border: solid;font-size: 5.5pt;text-align:center"></td>
							<td style="border: solid;">
								<p class="MsoNormal" style="text-align:center;margin-top: 4px;margin-bottom: 0px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
										<o:p></o:p></span></p>
								<p class="MsoNormal" style="text-align:center;margin-top: 4px;margin-bottom: 0px;height:5px" align="center">
									<span ><o:p>&nbsp;</o:p></span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 4px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
										<o:p></o:p>	
									</span>
								</p>
							</td>
							<td style="border: solid;padding: 0cm 3pt 0cm 3pt;">
								<p class="MsoNormal" style="text-align:center;margin-bottom: 8px;margin-top: 8px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
										<o:p></o:p></span>
								</p>
							</td>
							<td style="border: solid;font-size: 5.5pt;text-align:center">
								<p class="MsoNormal" style="text-align:center;margin-bottom: 8px;margin-top: 8px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
									</span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 8px;margin-top: 8px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
										
									</span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 8px;margin-top: 8px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">
									
									</span>
								</p>
							</td>
							<td style="border: solid;font-size: 5.5pt;text-align:center"></td>
							<td style="border: solid;">
								<p class="MsoNormal" style="text-align:center;margin-top: 10px;margin-bottom: 2.5px" align="center">
									<span style="text-align:center;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"> 
									</span>
								</p>
								{{-- <p class="MsoNormal" style="text-align:center;margin-bottom: 0px;" align="center">
									<span style="mso-spacerun:yes;font-size:7.7pt;font-family:&quot;Arial&quot;,sans-serif"> = </span><o:p></o:p>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 10px;margin-top: 2.5px;" align="center">
									<span style="mso-spacerun:yes;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif">&nbsp; $406.200</span><o:p></o:p>
								</p> --}}
							</td>
							<td style="border: solid;">
								<p class="MsoNormal" style="text-align:center;margin-top: 10px;margin-bottom: 2.5px" align="center">
									<span style="text-align:center;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"> 
									</span>
								</p>
								{{-- <p class="MsoNormal" style="text-align:center;margin-bottom: 0px;" align="center">
									<span style="mso-spacerun:yes;font-size:7.7pt;font-family:&quot;Arial&quot;,sans-serif"> = </span><o:p></o:p>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 10px;margin-top: 2.5px;" align="center">
									<span style="mso-spacerun:yes;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif">&nbsp; $3.576.800</span><o:p></o:p>
								</p> --}}
							</td>
							<td rowspan="2" style="border: solid;font-size: 7pt;text-align:center"></td>
							
						</tr>
						{{-- @endforeach  --}}
						{{-- <tr>
							
							<td style="border: solid;">
								<p class="MsoNormal" style="text-align:center;margin-top: 4px;margin-bottom: 0px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">MARTHA
									ISABEL MEJIA DE ALBA<o:p></o:p></span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-top: 4px;margin-bottom: 0px;height:5px" align="center">
									<span ><o:p>&nbsp;</o:p></span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 4px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">ALVARO
									MARTÍN GUTIÉRREZ<o:p></o:p></span>
								</p>
							</td>
							<td style="border: solid;">
								<p class="MsoNormal" style="text-align:center;margin-bottom: 8px;margin-top: 8px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">BOGOTÁ
									– NOBSA-SOGAMOSO, ( DIA 1: <span style="mso-spacerun:yes">&nbsp;</span>VISITA
									INALVERSOG,<span style="mso-spacerun:yes">&nbsp; </span>DIA 2:VISITA SIDENAL) –
									TIBASOSA-BOGOTA<o:p></o:p></span>
								</p>
							</td>
							<td style="border: solid;font-size: 5.5pt;text-align:center">
								<p class="MsoNormal" style="text-align:center;margin-bottom: 8px;margin-top: 8px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">19 Y 20
									</span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 8px;margin-top: 8px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">DE
										<span style="mso-spacerun:yes">&nbsp; </span>MARZO
									</span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 8px;margin-top: 8px;" align="center">
									<span style="font-size:5.5pt;font-family:&quot;Arial&quot;,sans-serif;mso-ansi-language:PT-BR" lang="PT-BR">DE
										<span style="mso-spacerun:yes">&nbsp; </span>2020<o:p></o:p>
									</span>
								</p>
							</td>
							<td style="border: solid;font-size: 5.5pt;text-align:center">2</td>
							<td style="border: solid;">
								<p class="MsoNormal" style="text-align:center;margin-top: 10px;margin-bottom: 2.5px" align="center">
									<span style="text-align:center;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">$135.400*2*1.5
									</span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 0px;" align="center">
									<span style="mso-spacerun:yes;text-align:center;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif">  días  </span><o:p></o:p>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 0px;" align="center">
									<span style="mso-spacerun:yes;text-align:center;font-size:7.7pt;font-family:&quot;Arial&quot;,sans-serif"> = </span><o:p></o:p>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 10px;margin-top: 2.5px;" align="center">
									<span style="mso-spacerun:yes;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif">&nbsp; $406.200</span><o:p></o:p>
								</p>
							</td>
							<td style="border: solid;">
								<p class="MsoNormal" style="text-align:center;margin-top: 10px;margin-bottom: 2.5px" align="center">
									<span style="text-align:center;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">$52.600*31*2 días
									</span>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 0px;" align="center">
									<span style="mso-spacerun:yes;font-size:7.7pt;font-family:&quot;Arial&quot;,sans-serif"> = </span><o:p></o:p>
								</p>
								<p class="MsoNormal" style="text-align:center;margin-bottom: 10px;margin-top: 2.5px;" align="center">
									<span style="mso-spacerun:yes;font-size:6.5pt;font-family:&quot;Arial&quot;,sans-serif">&nbsp; $3.261.200</span><o:p></o:p>
								</p>
							</td>
							
						</tr> --}}
					</table>
					
					</div>
					
					<p >
						<span style="font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<p class="margenParrCent" align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">RESUELVE<o:p></o:p></span></b>
					</p>
					
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<!-- 10mo parrafo -->
					<p class="margenParrJust"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">ARTÍCULO PRIMERO</span></b>
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">:
						Autorizar el trámite y pago de un avance a nombre del (la) docente <b style="mso-bidi-font-weight:normal">(NOMBRE DOCENTE) </b>identificado(a)
						con (tipo identificación) No.(XXXXXXXX) para cubrir los gastos de la práctica
						académica del Proyecto Curricular (Programa Académico) del presupuesto descrito
						en el siguiente cuadro, con Disponibilidad Presupuestal (XXX)</span>
						<span style="font-size:10.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">:<o:p></o:p></span>
					</p>
					<!-- 10mo parrafo -->
					<p >
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<!-- 11vo parrafo -->
					<p class="margenParrJust">
						<span style="font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_11?>
							</textarea><o:p></o:p></span>
					</p>
					<!-- 11vo parrafo -->
					
					<!-- 12vo parrafo -->
					<p class="margenParrJust" style="text-indent:0cm;mso-list:l0 level1 lfo2;tab-stops:list 36.0pt"><!--[if !supportLists]-->
						<span style="font-size:9.0pt;font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol" lang="ES">
							<span style="mso-list:Ignore">·<span style="font:7.0pt &quot;Times New Roman&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span>
						</span><!--[endif]--><span style="font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
						<span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_12?>
						</textarea><o:p></o:p></span>
					</p>
					<!-- 12vo parrafo -->
					
					<!-- 13vo parrafo -->
					<p class="margenParrJust" style="text-indent:0cm;mso-list:l0 level1 lfo2;tab-stops:list 36.0pt"><!--[if !supportLists]-->
						<span style="font-size:9.0pt;font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol" lang="ES">
							<span style="mso-list:Ignore">·<span style="font:7.0pt &quot;Times New Roman&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span>
						</span><!--[endif]-->
						<span style="font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_13?>
						</textarea><o:p></o:p></span>
					</p>
					<!-- 13vo parrafo -->
					
					<p >
						<b style="mso-bidi-font-weight:normal"><span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					<!-- 14vo parrafo -->
					<p class="margenParrJust"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">ARTICULO SEGUNDO:</span></b><span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
						<span style="color:black">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_14?>
							</textarea></span><o:p></o:p></span>
					</p>
					<!-- 14vo parrafo -->
					<p >
						<b style="mso-bidi-font-weight:normal"><span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					
					{{-- <p >
						<b style="mso-bidi-font-weight:normal"><span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p> --}}
					<!-- 15vo parrafo -->
					<p class="margenParrJust"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">ARTICULO TERCERO: </span></b>
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_15?>
							</textarea><o:p></o:p></span>
					</p>
					<!-- 15vo parrafo -->
					
					<p ><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					
					<!-- 16vo parrafo -->
					<p class="margenParrJust"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">ARTICULO CUARTO: </span></b>
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
							<textarea style="font-size:9.0pt;line-height:115%;font-family:Arial,sans-serif;width: 100%"><?php echo $parrafos_modificables->parr_16?>
							</textarea><o:p></o:p></span>
					</p>
					<!-- 16vo parrafo -->
					<p ><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					
					<p class="margenParrCent" align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES">COMUNÍQUESE
						Y CÚMPLASE<o:p></o:p></span></b>
					</p>
					
					<p >
						<span style="font-size:6.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<p class="MsoNormal" style="margin-top:0cm;margin-right:107.45pt;
					margin-bottom:0cm;margin-left:127.6pt;margin-bottom:.0001pt;text-align:center;
					line-height:115%" align="center"><span style="font-size:9.0pt;line-height:115%;
					font-family:&quot;Arial&quot;,sans-serif" lang="ES">Dada en la Decanatura de la Facultad del Medio
					Ambiente y Recursos Naturales a los (palabras días) (XX) días del mes de (nombre mes) de (XXXX).<o:p></o:p></span></p>
					
					<p ><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;line-height:115%;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span></b>
					</p>
					
					<p class="margenParrCent" align="center">
						
								{{-- <hr class="divider" style="width: 244.5pt;"> --}}
						<span style="width: 244.5pt;font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">________________________________________________<o:p></o:p></span>
					</p>
					
					<p class="margenParrCent" align="center"><b style="mso-bidi-font-weight:normal">
						<span style="font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">(NOMBRE DECANO ACTUAL)<o:p></o:p></span></b>
					</p>
					
					<p class="margenParrCent" align="center">
						<span style="font-size:9.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">Decano Facultad
						del Medio Ambiente y Recursos Naturales<o:p></o:p></span>
					</p>
					
					{{-- <p >
						<span style="font-size:6.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p> --}}
					
					{{-- <p >
						<span style="font-size:6.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<p >
						<span style="font-size:6.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p>
					
					<p >
						<span style="font-size:6.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES"><o:p>&nbsp;</o:p></span>
					</p> --}}
					
					{{-- <p style="tab-stops:161.25pt"><span style="font-size:6.0pt;font-family:&quot;Arial&quot;,sans-serif" lang="ES">
						<span style="mso-tab-count:1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						</span><o:p></o:p></span>
					</p> --}}
					
				</div>
			
			</div>

			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			</div>
		</div>
		<br>
		<div class="form-group row mb-0">
			
			<div class="col-md-6 offset-md-6" style="left: -4%;">
				<br>
				<button type="submit" class="btn btn-primary">
					{{ __('Guardar') }}
				</button>
			</div>
		</div>
		<br>
	</form>
    </div>

@endsection