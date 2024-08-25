@extends ('layouts.app')
@section ('contenido')  
  
  <div class="container-fluid">
      <div class="card-header">{{ __('Oficio Prácticas Académicas') }}</div>
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

                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                        normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;
                        font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></b></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                        normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;
                        font-family:"Arial",sans-serif'>DFAMARENA-2028-19<o:p></o:p></span></b></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'>Bogotá,
                        XX de XXXX de XXXX<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-size:10.0pt;font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                        normal'><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>Doctor<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                        style='font-size:12.0pt;font-family:"Arial",sans-serif'>FRANKLIN WILCHES REYES<o:p></o:p></span></b></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>Jefe
                        Sección Presupuesto<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>Universidad
                        Distrital Francisco José de Caldas<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>Ciudad<b
                        style='mso-bidi-font-weight:normal'><o:p></o:p></b></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-size:12.0pt;font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-size:12.0pt;font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>Respetado
                        Doctor Wilches:<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif;
                        mso-fareast-font-family:Calibri'>Comedidamente me dirijo a usted con el fin de
                        solicitarle se sirva expedir Registro Presupuestal y <b style='mso-bidi-font-weight:
                        normal'><u>tramitar avance académico</u></b> a nombre del (la) docente <b
                        style='mso-bidi-font-weight:normal'>(NOMBRE DOCENTE) identificado(a) con </b>(tipo identificación) No (XXXXXXX).</span> 
                        <span style='font-family:"Arial",sans-serif;
                        mso-fareast-font-family:Calibri'>por valor de<b style='mso-bidi-font-weight:
                        normal'> $(XX.XXX.XXX) </b>con</span><b style='mso-bidi-font-weight:normal'><span
                        style='font-family:"Arial",sans-serif;mso-fareast-font-family:"Times New Roman";
                        mso-fareast-language:ES'> </span></b><span style='font-family:"Arial",sans-serif;
                        mso-fareast-font-family:Calibri'>cargo al rubro <b style='mso-bidi-font-weight:
                        normal'>PRÁCTICAS ACADEMICAS </b>de la Facultad del Medio Ambiente y Recursos
                        Naturales, discriminado así: Viático docente: <b style='mso-bidi-font-weight:
                        normal'>$(X.XXX.XXX), </b>Auxilio estudiantes: <b style='mso-bidi-font-weight:
                        normal'>$(X.XXX.XXX) </b>y Materiales: <b style='mso-bidi-font-weight:normal'>$(XXX.XXX)</b>;
                        lo anterior, para garantizar el desarrollo de la práctica académica (Nombre Asignatura) 
                        a realizarse del (día) de (mes) al (día) de (mes) de (año) del Proyecto
                        Curricular de (Programa Académico). La práctica objeto del presente oficio hace
                        parte del Plan de Practicas del año (año), el cual fue aprobado por el Consejo
                        de Facultad en sesión del (día) de (mes) Acta No(XXX); por lo cual me permito anexar
                        la documentación soporte correspondiente. <o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>Adjunto:
                        <o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
                        margin-left:36.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:-18.0pt;
                        line-height:normal;mso-list:l0 level1 lfo1;tab-stops:list 36.0pt'><![if !supportLists]><span
                        style='font-family:"Times New Roman",serif;mso-fareast-font-family:"Times New Roman"'><span
                        style='mso-list:Ignore'>-<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span></span></span><![endif]><span style='font-family:"Arial",sans-serif'>Resolución
                        No. de 2019<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
                        margin-left:36.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:-18.0pt;
                        line-height:normal;mso-list:l0 level1 lfo1;tab-stops:list 36.0pt'><![if !supportLists]><span
                        style='font-family:"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";
                        color:red'><span style='mso-list:Ignore'>-<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span></span></span><![endif]><span style='font-family:"Arial",sans-serif;
                        color:red'>Solicitud de Necesidad No.6467<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
                        margin-left:36.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:-18.0pt;
                        line-height:normal;mso-list:l0 level1 lfo1;tab-stops:list 36.0pt'><![if !supportLists]><span
                        style='font-family:"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";
                        color:red'><span style='mso-list:Ignore'>-<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span></span></span><![endif]><span style='font-family:"Arial",sans-serif;
                        color:red'>Disponibilidad Presupuestal No.3956<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
                        margin-left:36.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:-18.0pt;
                        line-height:normal;mso-list:l0 level1 lfo1;tab-stops:list 36.0pt'><![if !supportLists]><span
                        style='font-family:"Times New Roman",serif;mso-fareast-font-family:"Times New Roman"'><span
                        style='mso-list:Ignore'>-<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span></span></span><![endif]><span style='font-family:"Arial",sans-serif'>Autorización
                        de Giro<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
                        margin-left:36.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:-18.0pt;
                        line-height:normal;mso-list:l0 level1 lfo1;tab-stops:list 36.0pt'><![if !supportLists]><span
                        style='font-family:"Times New Roman",serif;mso-fareast-font-family:"Times New Roman"'><span
                        style='mso-list:Ignore'>-<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span></span></span><![endif]><span style='font-family:"Arial",sans-serif'>Formato
                        solicitud de avance<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'>Agradeciendo
                        la colaboración prestada.<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'>Cordialmente,<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
                        justify;line-height:normal'><span style='font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                        normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt'>JAIME
                        EDDY USSA GARZON</span></b><b style='mso-bidi-font-weight:normal'><i
                        style='mso-bidi-font-style:normal'><span style='font-family:"Arial",sans-serif'><o:p></o:p></span></i></b></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                        normal'><span style='font-family:"Arial",sans-serif'>Decano <o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                        normal'><span style='font-family:"Arial",sans-serif'>Facultad del Medio
                        Ambiente y Recursos Naturales<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                        normal'><span style='font-family:"Arial",sans-serif'>Universidad Distrital
                        Francisco José de Caldas<o:p></o:p></span></p>
                        
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                        normal'><span style='font-family:"Arial",sans-serif'>PBX 57(1)3239300 EXT.4000<o:p></o:p></span></p>
                        
                        <p class=MsoNormal><o:p>&nbsp;</o:p></p>
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