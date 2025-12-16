
<!DOCTYPE HTML>


<title>FORMATO DECLARACIÓN RESPONSABILIDAD</title>
<style>
  P{font-family:"Arial, sans-serif";font-size:10pt}
  ol{font-family:"Arial, sans-serif";font-size:10pt}
  .tg  {border-collapse:collapse;border-spacing:0;}
  .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;
    overflow:hidden;padding:3px 3px;word-break:normal;}
  .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;
    font-weight:normal;overflow:hidden;padding:3px 3px;word-break:normal;}
  .tg .tg-9wq8{border-color:inherit;text-align:center;vertical-align:middle}
  .tg .tg-baqh{text-align:center;vertical-align:top}
  .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
  .tg .tg-7btt{border-color:inherit;font-weight:bold;text-align:center;vertical-align:top}
  .tg .tg-0lax{text-align:left;vertical-align:top}
  .tg .tg-nrix{text-align:center;vertical-align:middle}
  .tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
  .page-break {
  page-break-after: always;
  }

  footer{position:fixed;bottom:0cm;left:0cm;right:0cm;height:1cm;}
  .tb_th_piepagina{font-family:"Arial, sans-serif";font-size:4pt}
  .tb_piepagina{font-family:"Arial, sans-serif";font-size:4pt}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<!-- end: tool_blocks.sbi_html_head --></head>

<body>
<table width="97%" border="0" cellpadding="0" cellspacing="0" align="center">

  <div align="center">

    <table class="tg" style="table-layout: fixed; width: 699px">
      <colgroup>
        <col style="width: 150">
        <col style="width: 250">
        <col style="width: 100">
        <col style="width: 100">
      </colgroup>
      <thead>
        <tr>
          <th class="tg-0lax" rowspan="3"><p style="text-align: center; margin:0;" width="120"><img src="{{ public_path('img/logo_ud.png') }}" alt="" width="120" height="100"/></p></th>
          <th class="tg-baqh"><br><span style="font-weight:bold">FORMATO DECLARARACIÓN DE RESPONSABILIDAD EJECUCIÓN DE LA SALIDA DE CAMPO</span></th>
          <th class="tg-baqh"><br>Código: GRF-PR-009-FR-006</th>
          <th class="tg-0lax" rowspan="3"><p style="text-align: center; margin:0;padding-top: 38px;"><img src="{{ public_path('img/sigud2.jpg') }}" alt="" width="120" height="50"/></p></th>
        </tr>
        <tr>
          <td class="tg-baqh"><br>Macroproceso: Gestión Académica</td>
          <td class="tg-baqh"><br>Versión: 02</td>
        </tr>
        <tr>
          <td class="tg-nrix">Proceso: Gestión de Docencia</td>
          <td class="tg-baqh">Fecha de Aprobación:<br>04/10/2017</td>
        </tr>
      </thead>
    </table>

    <table width="95%" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td>
      <br>
      <p align="justify">
        Yo, {{mb_strtoupper($docente->nombre_completo)}} identificado(a) con documento de identidad No. {{ $docente->id }}, 
        expedido en {{$docente->expedicion_identificacion}} en mi calidad de Estudiante del Espacio Académico {{ $solicitud->espacio_academico }} de la Facultad de 
        Medio Ambiente y Recursos Naturales, de la Universidad Distrital Francisco José de Caldas, declaro que:
      </p>
      <p align="justify" class="ml-2">
        <ol style="text-align: justify;">
            <li>Asumo la <strong>responsabilidad total por la planificación, desarrollo y supervisión </strong> de la Salida de Campo a realizarse con los estudiantes 
                del Espacio Académico {{ $solicitud->espacio_academico }}, correspondiente al periodo académico {{ $solicitud->anio_periodo }}-{{ $solicitud->id_periodo_academico }}.</li>
            <li>Me comprometo a <strong>garantizar el cumplimiento de las normas de seguridad, bioseguridad y protocolos y normativas institucionales</strong> 
                asi como velar por el comportamiento ético y responsable de los estudiantes durante toda la ejecución de la práctica</li>
            <li>He informado a los estudiantes sobre los <strong>objetivos, riesgos, medidas de prevención, requerimientos y procedimientos </strong> correspondientes
                a la salida de campo, y me aseguro de que comprendan su rol y compromiso en la misma.</li>
            <li>Declaro que la actividad se encuentra enmarcada dentro de lo estipulado en el Syllabus del Espacio Académico y cuenta con los permisos
                requeridos por los entes correspondientes, en caso de ser necesario.</li>
            <li>Me responsabilizo por cualquier eventualidad que surja durante el desarrollo de la Salida de Campo en el marco de mis funciones como docente.</li>
        </ol>      
      </p>
      <p align="justify">
      En constancia de lo anterior, firmo la presente declaración en la ciudad de Bogotá D.C., a los {{ $dia }} días del mes de {{ $mes }} del año 
      {{ $anio }}.
      </p>
      <br>
      <p align="justify"><span class="larger"><strong>Firma del Docente:</strong></span></p>
      <br><br><br>
      <div  style="margin-bottom: -27px;">
        <img src="{{ $firma_litografica }}" alt="" style="width: 200px; height:45px;">
      </div>
      <p align="justify"><strong><span class="larger">___________________________________</strong></span></p>
      <p align="justify">
        Nombre completo: {{mb_strtoupper($docente->nombre_completo)}}<br>
        Cédula de ciudadania: {{$docente->id}}<br>
        Correo institucional: {{mb_strtolower($docente->email)}}<br>
        Teléfono de contacto: {{$docente->celular}}<br>
      </p>
    </table>
    
  </div>
</table>

</body>
</html>
