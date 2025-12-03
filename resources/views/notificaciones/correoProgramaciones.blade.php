@if($filter=="creacion_proy")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Nueva Programación Práctica N°<?php echo $nueva_programacion->id?></title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="https://practicampo.udistrital.edu.co/">
                        <img src="httpss://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
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
                        Nueva Programación Práctica N°<?php echo $nueva_programacion->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    @if($email['role'] == 4)
                        <p style="font-size: 0.875rem"><strong>Señor(a) Coordinador(a):</strong></p>
                    @elseif($email['role'] == 5)
                        <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                    @endif
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">Se ha creado una nueva Programación Práctica de práctica acádemica
                    N°<?php echo $nueva_programacion->id?> con la siguiente información:</p>
                    <br>
                    <p style="font-size: 0.875rem">DETALLES </p>
                    <p style="font-size: 0.875rem">Programa Acádemico: 
                        <?php echo $nueva_programacion->programa_academico?>
                    </p>
                    <p style="font-size: 0.875rem">Espacio Acádemico:</p> 
                        
                        <p style="margin: 0rem;font-family: Arial, sans-serif;font-size: 0.875rem"><?php echo $nueva_programacion->codigo_espacio_academico?> - <?php echo $nueva_programacion->espacio_academico?></p>
                        <span>
                            @foreach ($espa_pract_int as $item) 
                                <p style="margin: 0rem;font-family: Arial, sans-serif;font-size: 0.875rem">
                                    <?= $item['codigo_espacio_academico']?> - <?= $item['espacio_academico']?>
                                </p>
                            @endforeach 
                        </span>
                    <p style="font-size: 0.875rem">Período Acádemico: <?php echo $nueva_programacion->anio_periodo?> - <?php echo $nueva_programacion->periodo_academico?></p>
                    <p style="font-size: 0.875rem">Semestre Asignatura: <?php echo $nueva_programacion->semestre_asignatura?></p>
                    <p style="font-size: 0.875rem">Destino Ruta Principal: <?php echo $nueva_programacion->destino_rp?></p>
                    <p style="font-size: 0.875rem">Destino Ruta Contingencia: <?php echo $nueva_programacion->destino_ra?></p>
                    {{-- @if(Auth::user()->coordinador()) --}}
                    @if($email['role'] == 4)
                    <p style="font-size: 0.875rem">Docente Responsable: <?php echo $nueva_programacion->full_name?></p>
                    <p style="font-size: 0.875rem">La Programación Práctica se encuentra pendiente a aprobación por la 
                        dependencia de su cargo en el aplicativo PractiCampo. LINK:</p>  
                    @endif
                    @if($email['role'] == 5)
                    <p style="font-size: 0.875rem">Docente Responsable: <?php echo $nueva_programacion->full_name?></p>
                    <p style="font-size: 0.875rem">La Programación Práctica se encuentra pendiente al visto bueno por coordinación y la aprobación 
                        del consejo de carreras.</p>  
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: https://practicampo.udistrital.edu.co para hacer seguimiento.</p>
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

@if($filter=="aprob_coord_proy")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Notificación Programación Práctica</title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="https://practicampo.udistrital.edu.co/">
                        <img src="httpss://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
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
                        Visto Bueno Coordinación - Programación Práctica N°<?php echo $nueva_programacion->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    @if($email['role'] == 5)
                    <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La Programación Práctica N°<?php echo $nueva_programacion->id?> cuenta con V.° B.° por 
                        parte de coordinación para la consolidación en el plan de prácticas y presentación al Consejo de Factuldad para 
                        el debido trámite.</p>
                    @endif
                    @if($email['role'] == 2)
                    <p style="font-size: 0.875rem">Decanatura FAMARENA</p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La Programación Práctica N°<?php echo $nueva_programacion->id?> cuenta con V.° B.° por 
                        parte de coordinación para 
                        la consolidación en el plan de prácticas y presentación al Consejo de Factuldad para 
                        el debido trámite.</p>
                    @endif
                    @if($email['role'] == 3)
                    <p style="font-size: 0.875rem"><strong>Decanatura FAMARENA</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La Programación Práctica N°<?php echo $nueva_programacion->id?> cuenta con V.° B.° por 
                        parte de coordinación para la consolidación 
                        en el plan de prácticas y posterior registro del presupuesto para el transporte a contratar.</p>
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: https://practicampo.udistrital.edu.co para hacer seguimiento.</p>
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

@if($filter=="rechazo_coord_proy")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Notificación Programación Práctica</title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="https://practicampo.udistrital.edu.co/">
                        <img src="httpss://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
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
                        Rechazo Coordinación - Programación Práctica N°<?php echo $nueva_programacion->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    
                    @if($email['role'] == 5)
                    <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La Programación Práctica N°<?php echo $nueva_programacion->id?> ha sido rechazada 
                        por parte de coordinación, se le remiten las observaciones registradas.</p>
                    
                    <p style="font-size: 0.875rem"><strong>Observaciones: </strong><?php echo $nueva_programacion->observ_coordinador?></p>
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: https://practicampo.udistrital.edu.co para hacer seguimiento.</p>
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

@if($filter=="aprob_decano_proy")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Notificación Programación Práctica</title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="https://practicampo.udistrital.edu.co/">
                        <img src="httpss://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
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
                        Visto Bueno Decanatura - Programación Práctica N°<?php echo $nueva_programacion->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    @if($email['role'] == 3)
                    <p style="font-size: 0.875rem"><strong>Decanatura FAMARENA</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La Programación Práctica N°<?php echo $nueva_programacion->id?> cuenta con V.° B.° por 
                        parte de la decanatura FAMARENA para la consolidación 
                        en el plan de prácticas y presentación al Consejo de Factuldad para 
                        el debido trámite.</p>
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: https://practicampo.udistrital.edu.co para hacer seguimiento.</p>
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

@if($filter=="rechazo_decano_proy")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Notificación Programación Práctica</title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="https://practicampo.udistrital.edu.co/">
                        <img src="httpss://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
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
                        Rechazo Decanatura - Programación Práctica N°<?php echo $nueva_programacion->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    
                    @if($email['role'] == 4)
                    <p style="font-size: 0.875rem"><strong>Coordinador(a):</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La Programación Práctica N°<?php echo $nueva_programacion->id?> ha sido rechazada por parte de
                        la decanatura FAMARENA, 
                        se le remiten las observaciones registradas.</p>
                    
                    <br>
                    <p style="font-size: 0.875rem"><strong>Observaciones: </strong><?php echo $nueva_programacion->observ_decano?></p>
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: https://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. 
                        Por favor <strong>NO</strong> responder a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar 
                        adecuadamente los recursos es una responsabilidad de todos", reflexione sobre su compromiso 
                        ambiental. <small style="font-size: 0.5rem">***</small>
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

@if($filter=="cierre_coord_proy")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Notificación Programación Práctica</title>
    </head>
    <body>
        <table style="background-color: transparent; text-align:justify" align="center" width="60%">
            <tbody>
                <tr>
                    <td>
                        <a href="https://practicampo.udistrital.edu.co/">
                        <img src="httpss://www.udistrital.edu.co/themes/custom/versh/logo.png" alt=""
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
                        Cierre Programación Práctica N°<?php echo $nueva_programacion->id?>
                        <br>
                    </h3>
                </tr>
                <tr>
                    
                    @if($email['role'] == 5)
                    <p style="font-size: 0.875rem"><strong>Docente:</strong></p>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">La Programación Práctica N°<?php echo $nueva_programacion->id?> ha sido cerrada por parte de
                        la coordinación, 
                        se le remiten las observaciones registradas.</p>
                    
                    <br>
                    <p style="font-size: 0.875rem"><strong>Observaciones: </strong><?php echo $nueva_programacion->observ_coordinador?></p>
                    @endif
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: https://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad de l Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. 
                        Por favor <strong>NO</strong> responder a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar 
                        adecuadamente los recursos es una responsabilidad de todos", reflexione sobre su compromiso 
                        ambiental. <small style="font-size: 0.5rem">***</small>
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