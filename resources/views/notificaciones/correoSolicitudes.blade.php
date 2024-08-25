@if($filter=="creacion_solic")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Nueva Solicitud de Práctica N°<?php echo $nueva_solicitud->id?></title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="http://practicampo.udistrital.edu.co/">
                        <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                        style="display: grid; top: 28px; margin: 0 auto;width:50%">
                        </a>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                </tr>
                <tr>
                    <h3 style="line-height: 120%;">
                        Nueva Solicitud de Práctica N°<?php echo $nueva_solicitud->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?>  se encuentra pendiente a proceso de 
                        revisión y aprobación. La solicitud cuenta con la siguiente información:</p>
                    <br>
                    <p style="font-size: 0.875rem">DETALLES </p>
                    <p style="font-size: 0.875rem">Programa Acádemico: <?php echo $nueva_solicitud->programa_academico?></p>
                    <p style="font-size: 0.875rem">Espacio Acádemico: <?php echo $nueva_solicitud->codigo_espacio_academico?> - <?php echo $nueva_solicitud->espacio_academico?></p>
                    <p style="font-size: 0.875rem">Período Acádemico: <?php echo $nueva_solicitud->anio_periodo?> - <?php echo $nueva_solicitud->periodo_academico?></p>
                    <p style="font-size: 0.875rem">Semestre Asignatura: <?php echo $nueva_solicitud->semestre_asignatura?></p>
                    <p style="font-size: 0.875rem">Tipo Ruta: <?php if($nueva_solicitud->tipo_ruta == 1) {echo 'Principal';} elseif($nueva_solicitud->tipo_ruta == 2){echo 'Contingencia';}?></p>
                    <p style="font-size: 0.875rem">Ruta Destino: <?php if($nueva_solicitud->tipo_ruta == 1) {echo $nueva_solicitud->destino_rp;} elseif($nueva_solicitud->tipo_ruta == 2){echo $nueva_solicitud->destino_ra;}?></p>
                    <p style="font-size: 0.875rem">Fecha Salida: <?php echo $nueva_solicitud->fecha_salida?></p>
                    <p style="font-size: 0.875rem">Fecha Regreso: <?php echo $nueva_solicitud->fecha_regreso?></p>
                    <p style="font-size: 0.875rem">N° Estudiantes: <?php echo $nueva_solicitud->num_estudiantes?></p>
                    <p style="font-size: 0.875rem">N° Personal Apoyo: <?php echo $nueva_solicitud->num_docentes_apoyo?></p>
                    
                    <p style="font-size: 0.875rem">Docente Responsable: <?php echo $nueva_solicitud->full_name?></p>
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. 
                        Por favor <strong>NO</strong> responder a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente los recursos es una responsabilidad de 
                        todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                    </p>
                    <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                </tr>
                <tr>

                </tr>
            </tbody>             
        </table>
    </body>
    </html>
@endif

@if($filter=="aprob_coord_solic")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Notificación Solicitud de Práctica</title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="http://practicampo.udistrital.edu.co/">
                        <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                        style="display: grid; top: 28px; margin: 0 auto;width:50%">
                        </a>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                </tr>
                <tr>
                    <h3 style="line-height: 120%;">
                        Visto Bueno Coordinación - Solicitud de Práctica N°<?php echo $nueva_solicitud->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    @if($email['role'] == 5)
                    <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?> cuenta con V.° B.° por 
                        parte de coordinación para la presentación y aprobación frente al plan de contratación a la vicerrectoría administrativa 
                        y financiera</p>
                    @endif
                    @if($email['role'] == 2)
                    <p style="font-size: 0.875rem">Decanatura FAMARENA</p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?> cuenta con V.° B.° por 
                        parte de coordinación para la consolidación en el plan de prácticas y presentación del plan de contratación a 
                        la vicerrectoría administrativa y financiera.</p>
                    @endif
                    @if($email['role'] == 3)
                    <p style="font-size: 0.875rem"><strong>Decanatura FAMARENA</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?> cuenta con V.° B.° por 
                        parte de coordinación para la consolidación en el plan de prácticas y presentación del plan de contratación a 
                        la vicerrectoría administrativa y financiera.</p>
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por favor <strong>NO</strong> responder a 
                        este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente los recursos es una responsabilidad 
                        de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                    </p>
                    <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                </tr>
                <tr>

                </tr>
            </tbody>             
        </table>
        
    </body>
    </html>
@endif

@if($filter=="rechazo_coord_solic")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Notificación Solicitud de Práctica</title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="http://practicampo.udistrital.edu.co/">
                        <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                        style="display: grid; top: 28px; margin: 0 auto;width:50%">
                        </a>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                </tr>
                <tr>
                    <h3 style="line-height: 120%;">
                        Rechazo Coordinación - Solicitud de Práctica N°<?php echo $nueva_solicitud->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    
                    @if($email['role'] == 5)
                    <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?> ha sido rechazada por coordinación, 
                        se le remiten las observaciones registradas.</p>
                    
                    <p style="font-size: 0.875rem"><strong>Observaciones: </strong><?php echo $nueva_solicitud->observ_coordinador?></p>
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por 
                        favor <strong>NO</strong> responder a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente 
                        los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                    </p>
                    <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                </tr>
                <tr>
                    

                </tr>
            </tbody>             
        </table>
    </body>
    </html>
@endif

@if($filter=="cierre_coord_solic")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Notificación Solicitud de Práctica</title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="http://practicampo.udistrital.edu.co/">
                        <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                        style="display: grid; top: 28px; margin: 0 auto;width:50%">
                        </a>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                </tr>
                <tr>
                    <h3 style="line-height: 120%;">
                        Cierre Solicitud de Práctica N°<?php echo $nueva_solicitud->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    
                    @if($email['role'] == 5)
                    <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?> ha sido cerrada por coordinación, 
                        se le remiten las observaciones registradas.</p>
                    
                    <p style="font-size: 0.875rem"><strong>Observaciones: </strong><?php echo $nueva_solicitud->observ_coordinador?></p>
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por 
                        favor <strong>NO</strong> responder a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente 
                        los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                    </p>
                    <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                </tr>
                <tr>
                    

                </tr>
            </tbody>             
        </table>
    </body>
    </html>
@endif

@if($filter=="aprob_ejec_solic")
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
            <title>Notificación Solicitud de Práctica</title>
        </head>
        <body>
            <table style="background-color: transparent; text-align:justify" align="center" width="60%">
                <tbody>
                    <tr>
                        <td>
                            <a href="http://practicampo.udistrital.edu.co/">
                            <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                            style="display: grid; top: 28px; margin: 0 auto;width:50%">
                            </a>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                    </tr>
                    <tr>
                        <h3 style="line-height: 120%;">
                            Visto Bueno Coordinación - Solicitud de Práctica N°<?php echo $nueva_solicitud->id?>>
                            <br>
                        </h3>
                    </tr>
                    <tr>
                        @if($email['role'] == 5)
                        <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                        <p style="font-size: 0.875rem">Cordial Saludo,</p>
                        <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?> cuenta con V.° B.° por 
                            parte de coordinación para la presentación y aprobación frente al plan de contratación a la vicerrectoría administrativa 
                            y financiera</p>
                        @endif
                        @if($email['role'] == 2)
                        <p style="font-size: 0.875rem">Decanatura FAMARENA</p>
                        <p style="font-size: 0.875rem">Cordial Saludo,</p>
                        <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?> cuenta con V.° B.° por 
                            parte de coordinación para la consolidación en el plan de prácticas y presentación del plan de contratación a 
                            la vicerrectoría administrativa y financiera.</p>
                        @endif
                        @if($email['role'] == 3)
                        <p style="font-size: 0.875rem"><strong>Decanatura FAMARENA</strong></p>
                        <p style="font-size: 0.875rem">Cordial Saludo,</p>
                        <p style="font-size: 0.875rem">La solicitud de práctica N°<?php echo $nueva_solicitud->id?> cuenta con V.° B.° por 
                            parte de coordinación para la consolidación en el plan de prácticas y presentación del plan de contratación a 
                            la vicerrectoría administrativa y financiera.</p>
                        @endif
                        <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                        <br>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                            la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por favor <strong>NO</strong> responder a 
                            este correo.
                        </p>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente los recursos es una responsabilidad 
                            de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                        </p>
                        <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                    </tr>
                    <tr>
    
                    </tr>
                </tbody>             
            </table>
            <p>Solicitud de Práctica N°<?php echo $nueva_solicitud->id?></p>
            <br>
            {{-- @if(Auth::user()->docente() || Auth::user()->coordinador()) --}}
            @if($email['role'] == 5 || $email['role'] == 4)
            <p>Mediante acta de consejo de facultad N°<?php echo $nueva_solicitud->num_acta_consejo_facultad?> su práctica ha sido aprobada para ejecución, 
                sirvase revisar la programación para realizar los 
                trámites administrativos respectivos para la solicitud del avance de dineros con antelación de 
                15 días a la fecha de salida programada.</p>
            <br>
            <p>Formatos a diligenciar :</p> 
            <p>- Solicitud Avance </p>
            <p>- Solicitud Práctica</p>
            <br>
            @endif
            @if($email['role'] == 2)
            <p>La solicitud de práctica N°<?php echo $nueva_solicitud->id?> cuenta con la información requerida para solicitar avance en el área de tesorería.</p>
            <br>
            <p>Formatos a diligenciar :</p> 
            <p>- Autorización de Giro </p>
            <p>- Oficio Prácticas </p>
            <p>- Resolución </p>
            <p>- Solicitud Avance </p>
            <p>- Solicitud Práctica</p>
            <p>- Solicitud de Transporte</p>
            <br>
            @endif
            {{-- @if(Auth::user()->asistenteD())
            <p>La solicitud de práctica N°<php ?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
            <p>presentación al consejo de facultad.</p>
            <br>
            @endif --}}
            <br>
            <p>Ingrese al sistema para hacer seguimiento.</p>
            <br>
            <br>
            <p>
                Este correo fue generado de manera automática por el software PractiCampo Versión 1. 0 desarrollado por 
                la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por favor <strong>NO</strong> responder a este correo.
            </p>
            <br>
            <p>
                Antes de imprimir considere si es necesario, "El manejar adecuadamente los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. 
            </p>
        </body>
    </html>
@endif

@if($filter=="radic_avance_tesor_solic")
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
            <title>Notificación Solicitud de Práctica</title>
        </head>
        <body> 
            <table style="background-color: transparent; text-align:justify" align="center" width="60%">
                <tbody>
                    <tr>
                        <td>
                            <a href="http://practicampo.udistrital.edu.co/">
                            <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                            style="display: grid; top: 28px; margin: 0 auto;width:50%">
                            </a>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                    </tr>
                    <tr>
                        <h3 style="line-height: 120%;">
                            Radicación Avance - Solicitud Práctica N°<?php echo $nueva_solicitud->id?>>
                            <br>
                        </h3>
                    </tr>
                    <tr>
                        
                        @if($email['role'] == 5)
                        <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                        <p style="font-size: 0.875rem">Cordial Saludo,</p>
                        <p style="font-size: 0.875rem">La solicitud de avance está radicada en tesorería bajo el N°<?php echo $nueva_solicitud->num_radicado_financiera?>, 
                            acérquese a la oficina de tesorería para 
                            el respectivo proceso de retiro de dinero según procedimiento establecido.</p>
                        @endif
                        <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                        <br>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                            la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por 
                            favor <strong>NO</strong> responder a este correo.
                        </p>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente 
                            los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                        </p>
                        <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                    </tr>
                    <tr>
                        
    
                    </tr>
                </tbody>             
            </table>
        </body>
    </html>
@endif

@if($filter=="info_solic_estudiantes")
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
            <title>Documentación Salida Práctica Académica</title>
        </head>
        <body>
            <table style="background-color: transparent; text-align:justify" align="center" width="60%">
                <tbody>
                    <tr>
                        <td>
                            <a href="http://practicampo.udistrital.edu.co/">
                            <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                            style="display: grid; top: 28px; margin: 0 auto;width:50%">
                            </a>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                    </tr>
                    <tr>
                        <h3 style="line-height: 120%;">
                            Práctica de Campo N°<?php echo $nueva_solicitud->id?>
                            <br>
                        </h3>
                    </tr>
                    <tr>
                        
                        @if($email['role'] == 8)
                        <p style="font-size: 0.875rem"><strong>Estudiante:</strong></p>
                        <p style="font-size: 0.875rem">Cordial Saludo,</p>
                        <p style="font-size: 0.875rem">La práctica de campo N°<?php echo $nueva_solicitud->id?> asociada a la 
                            asignatura: @foreach ($espa_pract_int as $item) 
                            {{-- <p style="margin: 0rem;font-family: Arial, sans-serif;font-size: 0.875rem"> --}}
                                <?= $item['espacio_academico']?>,
                            {{-- </p> --}}
                        @endforeach se encuentra aprobada para desarrollarse 
                            dentro de las fechas <?php echo $nueva_solicitud->fecha_salida?> al 
                            <?php echo $nueva_solicitud->fecha_regreso?>, 
                            por favor seguir las instrucciones y recomendaciones del docente.</p>
                        @endif
                        <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para registrar la información de 
                            contacto y subir la documentación solicitada.
                            El usuario corresponde al correo institucional, y la contraseña es el número del código estudiantil.</p>
                        <br>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                            la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por 
                            favor <strong>NO</strong> responder a este correo.
                        </p>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente 
                            los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                        </p>
                        <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                    </tr>
                    <tr>
                        
    
                    </tr>
                </tbody>             
            </table>
            
        </body>
    </html>
@endif

@if($filter=="noti_transp_solic")
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
            <title>Programación Transporte - Solicitud de Práctica de Campo N°<?php echo $nueva_solicitud->id?></title>
        </head>
        <body>
            <table style="background-color: transparent; text-align:justify" align="center" width="60%">
                <tbody>
                    <tr>
                        <td>
                            <a href="http://practicampo.udistrital.edu.co/">
                            <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                            style="display: grid; top: 28px; margin: 0 auto;width:50%">
                            </a>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                    </tr>
                    <tr>
                        <h3 style="line-height: 120%;">
                            Práctica de Campo N°<?php echo $nueva_solicitud->id?>
                            <br>
                        </h3>
                    </tr>
                    <tr>
                        <p style="font-size: 0.875rem">Cordial Saludo,</p>
                        <p style="font-size: 0.875rem">La práctica de campo N°<?php echo $nueva_solicitud->id?> se encuentra aprobada y es necesario programar el servicio de transporte 
                        con las siguientes especificaciones: </p>
                        <p style="font-size: 0.875rem">Fecha Salida: <?php echo $nueva_solicitud->fecha_salida?></p>
                        <p style="font-size: 0.875rem">Fecha Regreso: <?php echo $nueva_solicitud->fecha_regreso?></p>
                        <p style="font-size: 0.875rem">Lugar Salida: <?php if($nueva_solicitud->tipo_ruta == 1){echo $nueva_solicitud->sede_salida_rp .' - '. $nueva_solicitud->direccion_salida_rp;} 
                        elseif($nueva_solicitud->tipo_ruta == 2){echo $nueva_solicitud->sede_salida_ra - $nueva_solicitud->dirección_salida_ra;}?></p>
                        <p style="font-size: 0.875rem">Hora Salida: <?php echo $nueva_solicitud->hora_salida?></p>
                        <p style="font-size: 0.875rem">Lugar Regreso: <?php if($nueva_solicitud->tipo_ruta == 1){echo $nueva_solicitud->sede_regreso_rp .' - '. $nueva_solicitud->direccion_regreso_rp;} 
                        elseif($nueva_solicitud->tipo_ruta == 2){echo $nueva_solicitud->sede_regreso_ra - $nueva_solicitud->sede_regreso_ra;}?></p>
                        <p style="font-size: 0.875rem">Hora Regreso: <?php echo $nueva_solicitud->hora_regreso?></p>
                        <p style="font-size: 0.875rem">Ruta Destino: <?php if($nueva_solicitud->tipo_ruta == 1){echo $nueva_solicitud->destino_rp;} elseif($nueva_solicitud->tipo_ruta == 2){echo $nueva_solicitud->destino_ra;}?></p>
                        <p>Recorrido Mapa: 
                            @foreach($rutas_recorrido as $ruta)
                                @if($ruta['ruta_1'] != null)
                                    <p style="font-size: 0.875rem;text-align: initial;">-Ruta 1: <a target="_blank" href="<?php echo $ruta['ruta_1']?>">VER</a></p>
                                @endif
                                @if($ruta['ruta_2'] != null)
                                    <p style="font-size: 0.875rem;text-align: initial;">-Ruta 2: <a target="_blank" href="<?php echo $ruta['ruta_2']?>">VER</a></p>
                                @endif
                                @if($ruta['ruta_3'] != null)
                                    <p style="font-size: 0.875rem;text-align: initial;">-Ruta 3: <a target="_blank" href="<?php echo $ruta['ruta_3']?>">VER</a></p>
                                @endif
                                @if($ruta['ruta_4'] != null)
                                    <p style="font-size: 0.875rem;text-align: initial;">-Ruta 4: <a target="_blank" href="<?php echo $ruta['ruta_4']?>">VER</a></p>
                                @endif
                                @if($ruta['ruta_5'] != null)
                                    <p style="font-size: 0.875rem;text-align: initial;">-Ruta 5: <a target="_blank" href="<?php echo $ruta['ruta_5']?>">VER</a></p>
                                @endif
                                @if($ruta['ruta_6'] != null)
                                    <p style="font-size: 0.875rem;text-align: initial;">-Ruta 6: <a target="_blank" href="<?php echo $ruta['ruta_6']?>">VER</a></p>
                                @endif
                            @endforeach
                        </p>
                        <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para registrar la siguiente información de 
                            contacto: Número de placa del vehículo, nombre y celular del conductor a cargo y del conductor auxiliar de ser necesario.
                        <br>
                        <p style="font-size: 0.875rem"> Escriba  a los siguientes correos en caso de presentar anomalías frente al transporte solicitado:</p>
                        @foreach($correos_administrativos as $correo)
                            @if($correo['role'] == 6)
                                <p style="font-size: 0.875rem">-Vicerrectoria Administrativa: <?php echo $correo['email']?></p>
                            @endif
                            @if($correo['role'] == 3)
                                <p style="font-size: 0.875rem">-Asistencia Decanatura: <?php echo $correo['email']?></p>
                            @endif
                        @endforeach
                        <br>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                            la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por 
                            favor <strong>NO</strong> responder a este correo.
                        </p>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente 
                            los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                        </p>
                        <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                    </tr>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </body>
    </html>
@endif

@if($filter=="pre_salida")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Módulo de Proyección Preliminar Inactivo</title>
    </head>
    <body>
        <br>
        <p>El módulo deproyección preliminar se encuentra inactivo desde <?php ?>.</p>
        <p></p>
        <br>
        {{-- <p>Ingrese al sistema para hacer seguimiento.</p> --}}
        
    </body>
    </html>
@endif

@if($filter=="pos_salida")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Módulo de Proyección Preliminar Inactivo</title>
    </head>
    <body>
        <br>
        <p>El módulo deproyección preliminar se encuentra inactivo desde <?php ?>.</p>
        <p></p>
        <br>
        {{-- <p>Ingrese al sistema para hacer seguimiento.</p> --}}
        
    </body>
    </html>
@endif

@if($filter=="estud_15_dias")
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
            <title>Documentación Salida Práctica Académica</title>
        </head>
        <body>
            <table style="background-color: transparent; text-align:justify" align="center" width="60%">
                <tbody>
                    <tr>
                        <td>
                            <a href="http://practicampo.udistrital.edu.co/">
                            <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                            style="display: grid; top: 28px; margin: 0 auto;width:50%">
                            </a>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                    </tr>
                    <tr>
                        <h3 style="line-height: 120%;">
                            Práctica de Campo N°<?php echo $nueva_solicitud->id?>
                            <br>
                        </h3>
                    </tr>
                    <tr>
                        
                        @if($email['role'] == 8)
                        <p style="font-size: 0.875rem"><strong>Estudiante:</strong></p>
                        <p style="font-size: 0.875rem">Cordial Saludo,</p>
                        <p style="font-size: 0.875rem">Faltan 15 Días para la realización de la práctica de campo N°<?php echo $nueva_solicitud->id?>, recuerde que debe registrar la 
                            información de contacto y subir la documentación solicitada por el docente antes del <?php echo $dias_7?>, fecha en la cual se 
                            inhabilitará la carga de documentos.</p>
                        @endif
                        <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para registrar la información de 
                            contacto y subir la documentación solicitada.
                            El usuario corresponde al correo institucional, y la contraseña es el número del código estudiantil.</p>
                        <br>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                            la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por 
                            favor <strong>NO</strong> responder a este correo.
                        </p>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente 
                            los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                        </p>
                        <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                    </tr>
                    <tr>
                        
    
                    </tr>
                </tbody>             
            </table>
            
        </body>
    </html>
@endif

@if($filter=="estud_8_dias")
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
            <title>Documentación Salida Práctica Académica</title>
        </head>
        <body>
            <table style="background-color: transparent; text-align:justify" align="center" width="60%">
                <tbody>
                    <tr>
                        <td>
                            <a href="http://practicampo.udistrital.edu.co/">
                            <img src="https://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
                            style="display: grid; top: 28px; margin: 0 auto;width:50%">
                            </a>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom:2px solid #a1c2af;background:none;height:1px;width:100%;margin:0px;"></td>
                    </tr>
                    <tr>
                        <h3 style="line-height: 120%;">
                            Práctica de Campo N°<?php echo $nueva_solicitud->id?>
                            <br>
                        </h3>
                    </tr>
                    <tr>
                        
                        @if($email['role'] == 8)
                        <p style="font-size: 0.875rem"><strong>Estudiante:</strong></p>
                        <p style="font-size: 0.875rem">Cordial Saludo,</p>
                        <p style="font-size: 0.875rem">Faltan 8 Días para la realización de la práctica de campo N°<?php echo $nueva_solicitud->id?>, recuerde que debe registrar la 
                            información de contacto y subir la documentación solicitada por el docente antes del <?php echo $dias_7?>, fecha en la cual se 
                            inhabilitará la carga de documentos.</p>
                        @endif
                        <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para registrar la información de 
                            contacto y subir la documentación solicitada.
                            El usuario corresponde al correo institucional, y la contraseña es el número del código estudiantil.</p>
                        <br>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                            la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por 
                            favor <strong>NO</strong> responder a este correo.
                        </p>
                        <p style="font-size: 0.875rem;color:#9a9a9a">
                            <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente 
                            los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
                        </p>
                        <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                    </tr>
                    <tr>
                        
    
                    </tr>
                </tbody>             
            </table>
        </body>
    </html>
@endif