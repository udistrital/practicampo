
<!DOCTYPE HTML>

<title>SOLICITUD DE AVANCE</title>
<style>
P{font-family:"Arial, sans-serif";font-size:10pt}
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
</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<!-- end: tool_blocks.sbi_html_head -->
{{-- </head> --}}

<body>
  <div style="text-align:center;">
    <table  border="0" cellpadding="0" cellspacing="0">
      <div style="text-align:center;">
        <table class="tg" style="undefined;table-layout:fixed;width:100%;">
          <colgroup>
          <col style="width: 150">
          <col style="width: 250">
          <col style="width: 100">
          <col style="width: 100">
          </colgroup>
          <thead>
            <tr>
              <th class="tg-0lax" rowspan="3"><p style="text-align: center; margin:0;" width="120"><img src="{{ public_path('img/logo_ud.png') }}" alt="" width="120" height="100"/></p></th>
              <th class="tg-baqh"><span style="font-weight:bold"><br>SOLICITUD DE AVANCE</span></th>
              <th class="tg-baqh"><br>Código: GRF-PR-012-FR-014</th>
              <th class="tg-0lax" rowspan="3"><p style="text-align: center; margin:0;padding-top: 10px;"><img src="{{ public_path('img/SIGUD.png') }}" alt="" width="120" height="80"/></p></th>
            </tr>
            <tr>
              <td class="tg-baqh"><br>Macroproceso: Gestión de Recursos</td>
              <td class="tg-baqh"><br>Versión: 01</td>
            </tr>
            <tr>
              <td class="tg-nrix">Proceso: Gestión de Recursos Financieros</td>
              <td class="tg-baqh"><br>Fecha de Aprobación:<br> 10/02/2017</td>
            </tr>
          </thead>
        </table>
        <br>
        <table class="tg" style="margin: 0 auto;width: 94%">
          <colgroup>
            <col style="width: 4%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 8%">
            <col style="width: 8%">
          </colgroup>
          <thead>
            <tr>
              <th class="tg-0pky" colspan="2">Fecha de Solicitud:</th>
              <th class="tg-0pky" colspan="3">{{$hoy['num']}} de {{ucfirst($hoy['mes'])}} de {{$hoy['anio']}}</th>
              <th class="tg-0pky" colspan="6" style="border-right:0px;border-top: 0px"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-7btt" colspan="11">DATOS DEL FUNCIONARIO ADMINISTRATIVO O DOCENTE</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="2" style="border-right:0px;">Nombres y Apellidos:</td>
              <td class="tg-0pky" colspan="9" style="border-left:0px;">{{$solicitud_practica[0]->full_name}}</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="2" style="border-right:0px;">Cédula de ciudadanía:</td>
              <td class="tg-0pky" colspan="4" style="border-left:0px;">{{$solicitud_practica[0]->id_docente_responsable}}</td>
              <td class="tg-0pky" colspan="1" style="border-right:0px;">Expedida en:</td>
              <td class="tg-0pky" colspan="4" style="border-left:0px;">{{$solicitud_practica[0]->expedicion_identificacion}}</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="2"  style="border-right:0px;">Dirección:</td>
              <td class="tg-0pky" colspan="4"  style="border-left:0px;"></td>
              <td class="tg-0pky" colspan="1"  style="border-right:0px;">Correo Electrónico:</td>
              <td class="tg-0pky" colspan="4"  style="border-left:0px;">{{$solicitud_practica[0]->email}}</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="2"  style="border-right:0px;">Teléfono fijo:</td>
              <td class="tg-0pky" colspan="4"  style="border-left:0px;">{{$solicitud_practica[0]->telefono}}</td>
              <td class="tg-0pky" colspan="1"  style="border-right:0px;">Teléfono móvil:</td>
              <td class="tg-0pky" colspan="4"  style="border-left:0px;">{{$solicitud_practica[0]->celular}}</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="2" style="border-right:0px;">Ordenador del Gasto:</td>
              <td class="tg-0pky" colspan="9" style="border-left:0px;">{{$decano->full_name}}</td>
            </tr>
            <tr>
              <td class="tg-7btt" colspan="11">TIPO DE AVANCE SOLICITADO</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="5" style="text-align: center">Modalidad (de acuerdo a la Resolución 652 de 2015 de Rectoría)</td>
              <td class="tg-9wq8" colspan="4" style="text-align: center">Especificación</td>
              <td class="tg-0pky" colspan="2" style="text-align: center">Valor Solicitado</td>
            </tr>
            {{-- <tr>
              <td class="tg-0pky"></td>
              <td class="tg-9wq8"  colspan="3">Transporte Menor/Local</td>
              <td class="tg-0pky" style="text-align: center">@if($transporte_menor >0)$  {{ number_format($transporte_menor, 0, ',','.')}}@endif</td>
            </tr> --}}
            <tr>
              <td class="tg-0pky" colspan="1" rowspan="3"></td>
              <td class="tg-9wq8" colspan="4" rowspan="3">Viáticos profesores</td>
              <td class="tg-0pky" colspan="4">Transporte</td>
              <td class="tg-0pky" colspan="2">$ </td>
            </tr>
            <tr>
              {{-- <td class="tg-0pky"></td> --}}
              <td class="tg-0pky" colspan="4">Hospedaje (alojamiento y alimentación)</td>
              <td class="tg-0pky" colspan="2">$ @if($viaticos_docente >0){{ number_format($viaticos_docente, 0, ',','.')}}@endif</td>
            </tr>
            <tr>
              {{-- <td class="tg-0pky"></td> --}}
              <td class="tg-0pky" colspan="1" style="border-right: 0px">Otros ¿cuáles?:</td>
              <td class="tg-0pky" colspan="3" style="border-left: 0px"> Ayudas de viaje</td>
              <td class="tg-0pky" colspan="2">$ </td>
            </tr>
            {{-- 
              <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky" colspan="2">Otros ¿cuáles?</td>
              <td class="tg-0pky" style="text-align: center">@if($valor_materiales >0)$  {{ number_format($valor_materiales, 0, ',','.')}}@endif</td>
            </tr>
              <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky" colspan="2">Otros. Cuáles? Guías/Baquianos</td>
              <td class="tg-0pky" style="text-align: center">@if($valor_baquianos >0)$  {{ number_format($valor_baquianos, 0, ',','.')}}@endif</td>
            </tr>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky" colspan="2">Otros. Cuáles? Boletas</td>
              <td class="tg-0pky" style="text-align: center">@if($valor_boletas >0)$  {{ number_format($valor_boletas, 0, ',','.')}}@endif</td>
            </tr> --}}
            <tr>
              <td class="tg-0pky" colspan="1" rowspan="3"></td>
              <td class="tg-9wq8" colspan="4" rowspan="3">Viáticos a estudiantes</td>
              <td class="tg-0pky" colspan="4">Transporte</td>
              <td class="tg-0pky" colspan="2" >$  </td>
            </tr>
            <tr>
              {{-- <td class="tg-0pky"></td> --}}
              <td class="tg-0pky" colspan="4">Hospedaje (alojamiento y alimentación)</td>
              <td class="tg-0pky" colspan="2">$  {{ number_format($viaticos_estudiante, 0, ',','.')}}</td>
            </tr>
            <tr>
              {{-- <td class="tg-0pky"></td> --}}
              <td class="tg-0pky" colspan="1" style="border-right: 0px">Otros ¿cuáles?:</td>
              <td class="tg-0pky" colspan="3" style="border-left: 0px"> Ayudas de viaje</td>
              <td class="tg-0pky" colspan="2">$  </td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="1"></td>
              <td class="tg-9wq8" colspan="4">Trámites ante Entidades Públicas</td>
              <td class="tg-0pky" colspan="1" style="border-right: 0px">Descripción:</td>
              <td class="tg-0pky" colspan="3" style="border-left: 0px"></td>
              <td class="tg-0pky" colspan="2">$  </td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="1"></td>
              <td class="tg-9wq8" colspan="4">Pago de gastos de defensa juficial</td>
              <td class="tg-0pky" colspan="1" style="border-right: 0px">Descripción:</td>
              <td class="tg-0pky" colspan="3" style="border-left: 0px"></td>
              <td class="tg-0pky" colspan="2">$  </td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="1"></td>
              <td class="tg-9wq8" colspan="4">Gastos de transporte y alojamiento de invitados</td>
              <td class="tg-0pky" colspan="1" style="border-right: 0px">Descripción:</td>
              <td class="tg-0pky" colspan="3" style="border-left: 0px"></td>
              <td class="tg-0pky" colspan="2">$  </td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="1" rowspan="3"></td>
              <td class="tg-9wq8" colspan="4" rowspan="3">Pago a conferencistas nacionales e internacionales</td>
              <td class="tg-0pky" colspan="4">Transporte:</td>
              <td class="tg-0pky" colspan="2">$  </td>
            </tr>
            <tr>
              {{-- <td class="tg-0pky"></td> --}}
              <td class="tg-0pky" colspan="4">Hospedaje (alojamiento y alimentación)</td>
              <td class="tg-0pky" colspan="2">$  </td>
            </tr>
            <tr>
              {{-- <td class="tg-0pky"></td> --}}
              <td class="tg-0pky" colspan="4">Otros ¿cuáles?:</td>
              <td class="tg-0pky" colspan="2">$  </td>
            </tr>
            <tr>
             {{--  @if($transporte_menor >0)$  {{ number_format($transporte_menor, 0, ',','.')}}@endif
              @if($valor_materiales >0)$  {{ number_format($valor_materiales, 0, ',','.')}}@endif
              @if($valor_baquianos >0)$  {{ number_format($valor_baquianos, 0, ',','.')}}@endif
              @if($valor_boletas >0)$  {{ number_format($valor_boletas, 0, ',','.')}}@endif --}}
              <td class="tg-0lax" colspan="1"></td>
              <td class="tg-nrix" colspan="4">Pago de Servicios especiales y compra de materiales e insumos</td>
              <td class="tg-0pky" colspan="1" style="border-right: 0px">Descripción:</td>
              <td class="tg-0lax" colspan="3" style="border-left: 0px">
                {{-- @if($transporte_menor >0) --}}
                Transporte Menor,
                {{-- @endif --}}
                 {{-- @if($valor_materiales >0)  --}}
                 Materiales, 
                 {{-- @endif
                 @if($valor_baquianos >0)  --}}
                   Guías/Baquianos, 
                 {{-- @endif
                 @if($valor_boletas >0)  --}}
                   Boletas 
                 {{-- @endif --}}
              </td>
              <td class="tg-0lax" colspan="2">$  
                @if($transporte_menor + $valor_materiales + $valor_baquianos + $valor_boletas > 0)
                  {{ number_format($transporte_menor + $valor_materiales + $valor_baquianos + $valor_boletas, 0, ',','.')}}
                @endif
              </td>
            </tr>
            <tr>
              <td class="tg-0lax" colspan="1"></td>
              <td class="tg-nrix" colspan="4">Compra de tiquetes aéreos y terrestre</td>
              <td class="tg-0pky" colspan="1" style="border-right: 0px">Descripción:</td>
              <td class="tg-0lax" colspan="3" style="border-left: 0px"></td>
              <td class="tg-0lax" colspan="2">$  </td>
            </tr>
            <tr>
              <td class="tg-amwm" colspan="9" style="text-align: right;"><strong style=" margin-right:10px">TOTAL AVANCE SOLICITADO:</strong></td>
              <td class="tg-0lax" colspan="2">$  {{ number_format($total_avance, 0, ',','.')}}</td>
            </tr>
            <tr>
              <td class="tg-nrix" colspan="11">
                <p style="text-align: left; font-size: 8pt"><strong>Justificación del avance y Cronograma (de acuerdo a la resolución de solicitud de avance):</strong></p>
                <p style="text-align: justify; font-size: 8pt">@php setlocale(LC_TIME, "spanish"); @endphpEl avance cubre el auxilio de estudiantes, viáticos docentes, materiales, etc. de las prácticas académicas de @foreach ($solicitud_practica as $sol)
{{ $sol->espacio_academico }} que se llevará a cabo del día {!! substr($sol->fecha_salida,-2) !!} al día {{ substr($sol->fecha_regreso,-2) }} del mes de {!! strftime('%B', strtotime($sol->fecha_regreso)) !!} de {!! substr($sol->fecha_salida,0,4) !!} del proyecto curricular de {{ $sol->programa_academico }}, 
@endforeach</p>
              </td>
              
            </tr>
          </tbody>
        </table>

        {{-- <div class="page-break"></div> --}}
        <br>

        <table style="margin: 0 auto;width: 80%;">
          
          <tr>
            <td>
              @if($docente_responsable->tiene_firma == 1)
                <div  style="margin-bottom: -27px;text-align: center">
                  <img src="{{ $firma_lito_docente }}" alt="" style="width: 200px; height:45px;">
                </div>
              @endif
              <p align="JUSTIFY" style="text-align: center;"><strong><span class="larger">_______________________________</strong></span></p>
              <p align="JUSTIFY" style="text-align: center;"><span class="larger">Firma del Solicitante</span></p>
            </td>
            <td>
              <div  style="margin-bottom: -27px;text-align: center">
                <img src="{{ $firma_lito_decano }}" alt="" style="width: 200px; height:45px;">
              </div>
              <p align="JUSTIFY" style="text-align: center;"><strong><span class="larger">_______________________________</strong></span></p>
              <p align="JUSTIFY" style="text-align: center;"><span class="larger">Visto bueno del Ordenador del Gasto</span></p>
            </td>
            <td>
              <br>
              <p align="JUSTIFY" style="text-align: center; margin-top: 11.9px"><strong><span class="larger">_______________________________</strong></span></p>
              <p align="JUSTIFY" style="text-align: center;"><span class="larger">Visto bueno de Tesorería</span></p>
            </td>
          </tr>
        </table>
        <br>
      </div>
    </table>
  </div>

  <footer>
    <p style="font-size:8pt;text-align:center">Este documento es propiedad de la 
      Universidad Distrital Francisco José de Caldas. Prohibida su reprodicción por cualquier medio, sin previa autorización.
    </p>
  </footer>


</body>
</body>
</html>
