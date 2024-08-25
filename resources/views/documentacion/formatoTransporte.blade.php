
<!DOCTYPE HTML>


<title>FORMATO</title>
<style>
  @page{
    margin-bottom: 0;
  }
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

/* table td, table th {
  page-break-inside: avoid;
} */
.page-break {
/* margin-top: 90;
margin-bottom: 0; */
page-break-after: always;
}
header{position:fixed;margin-bottom: 500px !important}

body{margin-bottom: 0 !important;
  page-break-inside: avoid;}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

</head>

<body>

  <header>
    <table class="tg" style="undefined;table-layout:fixed;width:100%;">
        <thead>
        <tr>
            <th class="tg-0lax" rowspan="3"><p style="text-align: center; margin:0;"><img src="{{ asset('img/logo_ud.png') }}" alt="" height="100"/></p></th>
            <th class="tg-nrix" colspan="2"><span style="font-weight:bold">FORMATO SOLICITUD TRANSPORTE TERRESTRE</span></th>
            <th class="tg-nrix">Código: GD-PR-010-FR-034</th>
            <th class="tg-0lax" rowspan="3"><p style="text-align: center; margin:0;padding-top: 10px;"><img src="{{ asset('img/SIGUD.png') }}" alt="" height="80"/></p></th>
        </tr>
        <tr>
            
            <td class="tg-nrix" colspan="2">Macroproceso: Gestión Administrativa y Contractual</td>
            <td class="tg-nrix">Versión: 01</td>
        </tr>
        <tr>
            <td class="tg-nrix" colspan="2">Proceso: Gestión de Contractual</td>
            <td class="tg-baqh">Fecha de Aprobación:<br>04/05/2017</td>
        </tr>
        </thead>
    </table>
  </header>

  <div style="text-align:center; margin-top: 90; margin-bottom: 0;">
    <table  border="0" cellpadding="0" cellspacing="0">
      <div style="margin: 0 auto;width: 94%">
        <p align="center"><strong><span class="larger">FORMATO SOLICITUD DE TRANSPORTE</strong></span></p>
        <table class="tg" style="margin: 0 auto;width: 90%;">
          <colgroup>
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706"> 
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">
            <col style="width: 2.706">

          </colgroup>
          <tbody>
            <tr>
              <td class="tg-9wq8" colspan="6">Fecha de solicitud de Servicio</th>
              <td class="tg-9wq8" colspan="12">{{$fecha_solicitud}}</th>
            </tr>
            <tr>
              <td class="tg-9wq8" colspan="6">Proyecto Curricular / <br>Dependencia solicitante</td>
              <td class="tg-9wq8" colspan="12">{{$solicitud_practica->programa_academico}}</td>
            </tr>
            <tr>
              <td class="tg-9wq8" colspan="6">Docente Responsable</td>
              <td class="tg-9wq8" colspan="6">
                @foreach ($doce_pract_int as $item) 
                  <p style="margin: 0rem;font-size: 10.5px"><?= $item['full_name']?></p>
                  {{-- <td class="tg-9wq8" colspan="2">{{$solicitud_practica->full_name}}</td> --}}
                @endforeach 
              </td>
              <td class="tg-9wq8" colspan="3">Dependencia Solicitante</td>
              <td class="tg-9wq8" colspan="3">FAMARENA</td>
            </tr>
            <tr>
              <td class="tg-9wq8" colspan="3">Teléfono de contacto Docente</td>
              <td class="tg-9wq8" colspan="3">
                @foreach ($doce_pract_int as $item) 
                  <p style="margin: 0rem;font-size: 10.5px"><?= $item['celular']?></p>
                @endforeach
              </td>
              <td class="tg-9wq8" colspan="3">Correo de Contacto Docente</td>
              <td class="tg-9wq8" colspan="9">
                {{-- <= $solicitud_practica->email?>@<= $solicitud_practica->dominio?> --}}
                @foreach ($doce_pract_int as $item) 
                  <p style="margin: 0rem;font-size: 10.5px"><?= $item['email']?></p>
                @endforeach
              </td>
              {{-- <td class="tg-9wq8" rowspan="2">{{substr($solicitud_practica->email,strpos ($solicitud_practica->email, '@'))}}</td> --}}
            </tr>
            <tr>
              <td class="tg-9wq8" colspan="6" >Nombre de la Asignatura</td>
              <td class="tg-9wq8" colspan="6">
                @foreach ($espa_pract_int as $item) 
                  <p style="margin: 0rem;font-size: 10.5px"><?= $item['espacio_academico']?></p>
                @endforeach
                {{-- {{$solicitud_practica->espacio_academico}} --}}
              </td>
              <td class="tg-9wq8" colspan="3">Código asignatura</td>
              <td class="tg-9wq8" colspan="3">
                {{-- {{$solicitud_practica->codigo_espacio_academico}} --}}
                @foreach ($espa_pract_int as $item) 
                  <p style="margin: 0rem;font-size: 10.5px"><?= $item['codigo_espacio_academico']?></p>
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="tg-9wq8" colspan="6">Periodo Académico</td>
              <td class="tg-9wq8" colspan="6">{{$solicitud_practica->anio_periodo}} - {{$solicitud_practica->periodo_academico}}</td>
              <td class="tg-9wq8" colspan="3">Semestre Asignatura</td>
              <td class="tg-9wq8" colspan="3">{{$solicitud_practica->semestre_asignatura}}</td>
            </tr>
            <tr>
              <td class="tg-9wq8" colspan="3">N° de Estudiantes</td>
              <td class="tg-9wq8" colspan="3">{{$solicitud_practica->num_estudiantes}}</td>
              <td class="tg-9wq8" colspan="3">N° de Grupos</td>
              <td class="tg-9wq8" colspan="3">{{$solicitud_practica->cantidad_grupos}}</td>
              <td class="tg-9wq8" colspan="3">N° de Docentes</td>
              <td class="tg-9wq8" colspan="3">{{ $practicas_integradas->cant_espa_aca + $docentes_practica->num_docentes_apoyo + 1}}</td>
            </tr>
            <tr>
              <td class="tg-9wq8" colspan="3">Fecha y Hora de Salida</td>
              <td class="tg-9wq8" colspan="3">{{$solicitud_practica->fecha_salida}} <br> {{$solicitud_practica->hora_salida}}</td>
              <td class="tg-9wq8" colspan="3">Fecha y Hora de Regreso</td>
              <td class="tg-9wq8" colspan="3">{{$solicitud_practica->fecha_regreso}} <br> {{$solicitud_practica->hora_regreso}}</td>
              <td class="tg-9wq8" colspan="3">Duración (días)</td>
              <td class="tg-9wq8" colspan="3">{{$solicitud_practica->duracion_num_dias}}</td>
            </tr>
            <tr>
              @if($solicitud_practica->tipo_ruta == 1)
              <td class="tg-9wq8" colspan="3">Lugar de Salida:</td>
              <td class="tg-9wq8" colspan="6">Universidad Distrital (Sede {{$solicitud_practica->sede_salida_rp}}, {{$solicitud_practica->direccion_salida_rp}}) </td>
              <td class="tg-9wq8" colspan="3">Lugar de Regreso:</td>
              <td class="tg-9wq8" colspan="6">Universidad Distrital (Sede {{$solicitud_practica->sede_regreso_rp}}, {{$solicitud_practica->direccion_regreso_rp}})</td>
              @endif
              @if($solicitud_practica->tipo_ruta == 2)
              <td class="tg-9wq8" colspan="3">Lugar de Salida:</td>
              <td class="tg-9wq8" colspan="6">Universidad Distrital (Sede {{$solicitud_practica->sede_salida_ra}}, {{$solicitud_practica->direccion_salida_ra}}) </td>
              <td class="tg-9wq8" colspan="3">Lugar de Regreso:</td>
              <td class="tg-9wq8" colspan="6">Universidad Distrital (Sede {{$solicitud_practica->sede_regreso_ra}}, {{$solicitud_practica->direccion_regreso_ra}})</td>
              @endif
            </tr>
            <tr>
              @if($solicitud_practica->tipo_ruta == 1)
              <td class="tg-9wq8" colspan="3">Número de Vehículos</td>
              <td class="tg-9wq8" colspan="6">{{$solicitud_practica->cant_transporte_rp}}</td>
              <td class="tg-9wq8" colspan="3" rowspan="2">Tipo de Vehículo</td>
              <td class="tg-9wq8" colspan="2" rowspan="2">{{$t_transporte->tp_1}}</td>
              <td class="tg-9wq8" colspan="2" rowspan="2">{{$t_transporte->tp_2}}</td>
              <td class="tg-9wq8" colspan="2" rowspan="2">{{$t_transporte->tp_3}}</td>
              @endif
              @if($solicitud_practica->tipo_ruta == 2)
              <td class="tg-9wq8" colspan="3">Número de Vehículos</td>
              <td class="tg-9wq8" colspan="6">{{$solicitud_practica->cant_transporte_ra}}</td>
              <td class="tg-9wq8" colspan="3" rowspan="2">Tipo de Vehículo</td>
              <td class="tg-9wq8" colspan="2" rowspan="2">{{$t_transporte->tp_1}}</td>
              <td class="tg-9wq8" colspan="2" rowspan="2">{{$t_transporte->tp_2}}</td>
              <td class="tg-9wq8" colspan="2" rowspan="2">{{$t_transporte->tp_3}}</td>
              @endif
            </tr>
            <tr>
              @if($solicitud_practica->tipo_ruta == 1)
              <td class="tg-9wq8" colspan="3">Capacidad de Vehículo</td>
              <td class="tg-9wq8" colspan="2">{{$t_transporte->cp_1}}</td>
              <td class="tg-9wq8" colspan="2">{{$t_transporte->cp_2}}</td>
              <td class="tg-9wq8" colspan="2">{{$t_transporte->cp_3}}</td>
              @endif
              @if($solicitud_practica->tipo_ruta == 2)
              <td class="tg-9wq8" colspan="3">Capacidad de Vehículo</td>
              <td class="tg-9wq8" colspan="2">{{$t_transporte->cp_1}}</td>
              <td class="tg-9wq8" colspan="2">{{$t_transporte->cp_2}}</td>
              <td class="tg-9wq8" colspan="2">{{$t_transporte->cp_3}}</td>
              @endif
            </tr>
            @if($num_carac_detalle + $num_carac_crono < 4500)
              <tr>
                <td class="tg-9wq8" colspan="3">Cronograma de Recorrido (Con Hora específica)</td>
                <td class="tg-0pky" colspan="15" >{{$solicitud_practica->cronograma}}</td>
              </tr>
              <tr>
                <td class="tg-9wq8" colspan="3">Ruta detallada del recorrido</td>
                <td class="tg-0pky" colspan="15" >{{$detalle_recorrido}}</td>
              </tr>
            </tbody>
          </table>
            @elseif($num_carac_detalle + $num_carac_crono >= 4500)
                @if($num_carac_crono  > 4500)
                      </tbody>
                    </table>
                    <div class="page-break"></div>
                    <table class="tg" style="margin: 90 auto 0;width: 90%;">
                      <colgroup>
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706"> 
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
                        <col style="width: 2.706">
            
                      </colgroup>
                      <tbody>
                        <tr>
                          <td class="tg-9wq8" colspan="3">Cronograma de Recorrido (Con Hora específica)</td>
                          <td class="tg-0pky" colspan="15" >{{$solicitud_practica->cronograma}}</td>
                        </tr>
                        <tr>
                          <td class="tg-9wq8" colspan="3">Ruta detallada del recorrido</td>
                          <td class="tg-0pky" colspan="15" >{{$detalle_recorrido}}</td>
                        </tr>
                      </tbody>
                    </table>
                @elseif(($num_carac_crono > 230 && $num_carac_crono  <= 4500 && $num_carac_detalle > 230))
                      <tr>
                        <td class="tg-9wq8" colspan="3">Cronograma de Recorrido (Con Hora específica)</td>
                        <td class="tg-0pky" colspan="15" >{{$solicitud_practica->cronograma}}</td>
                      </tr>
                    </tbody>
                  </table> 
                  <div class="page-break"></div>
                  <table class="tg" style="margin: 90 auto 0;width: 90%;">
                    <colgroup>
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706"> 
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
                      <col style="width: 2.706">
          
                    </colgroup>
                    <tbody>
                      <tr>
                        <td class="tg-9wq8" colspan="3">Ruta detallada del recorrido</td>
                        <td class="tg-0pky" colspan="15" >{{$detalle_recorrido}}</td>
                      </tr>
                    </tbody>
                  </table>
                @endif
            @endif
          
        {{-- <br>
        <br>
        <br> --}}
        <br>
        <div  align="center" style="margin-bottom: -27px;">
          <img src="{{ $firma_lito_decano }}" alt="" style="width: 200px; height:45px;">
        </div>
        <p align="CENTER"><strong><span class="larger">___________________________</strong></span></p>
        <p align="CENTER"><strong><span class="larger">Firma Ordenador del gasto</strong></span></p>
      </div>
    </table>
  </div>

</body>
</html>
