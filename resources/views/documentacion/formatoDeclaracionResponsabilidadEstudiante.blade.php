
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
        Yo, {{mb_strtoupper($estudiante->nombre_completo)}} identificado(a) con documento de identidad No. {{ $estudiante->num_identificacion }}, 
        expedido en ___________________ en mi calidad de Estudiante del Espacio Académico {{ $solicitud->espacio_academico }} de la Facultad de 
        Medio Ambiente y Recursos Naturales, de la Universidad Distrital Francisco José de Caldas, declaro que:
      </p>
      <p align="justify" class="ml-2">
        <ol">
            <li>Me comprometo a <strong>participar activamente, de manera responsable y ética</strong> en la Salida de Campo correspondiente al Espacio Académico 
                {{ $solicitud->espacio_academico }}, a desarrollarse durante el periodo académico {{ $solicitud->anio_periodo }}-{{ $solicitud->id_periodo_academico }}.</li>
            <li>Asumo la <strong>responsabilidad de cumplir con las instrucciones, protocolos de seguridad y bioseguridad, y normativas institucionales</strong> 
                establecidas para la ejecución de la Salida de Campo.</li>
            <li>Reconozco que he sido debidamente informado(a) sobre los objetivos, actividades, riesgos, requerimientos y procedimientos inherentes a la
                Salida de Campo, y me comprometo a acatarlos de manera estricta.</li>
            <li>Me comprometo a <strong>respetar los espacios, equipos, materiales y normas del lugar donde se desarrollará la Salida de Campo, así como 
                a actuar de forma colaborativa y respetuosa con los demás participantes</strong>.</li>
            <li>Eximo a la Universidad y al docente responsable de la práctica de toda responsabilidad derivada de un <strong>incumplimiento de mis deberes 
                o una conducta negligente</strong> por mi parte durante el desarrollo de esta.</li>
        </ol>      
      </p>
      <p align="justify">
      En constancia de lo anterior, firmo la presente declaración en la ciudad de Bogotá D.C, a los {{ $dia }} días del mes de {{ $mes }} del año 
      {{ $anio }}.
      </p>
      <br>
      <p align="justify"><span class="larger"><strong>Firma del Estudiante:</strong></span></p>
      <br><br><br>
      <p align="justify"><strong><span class="larger">___________________________________</strong></span></p>
      <p align="justify">
        Nombre completo: {{mb_strtoupper($estudiante->nombre_completo)}}<br>
        Cédula de ciudadania: {{$estudiante->num_identificacion}}<br>
        Correo institucional: {{mb_strtolower($estudiante->email)}}<br>
        Teléfono de contacto: {{$estudiante->celular}}<br>
      </p>
    </table>
    
  </div>
</table>

</body>
</html>
