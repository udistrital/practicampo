@if($filter=="")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificación PractiCampoUD</title>
</head>
<body>
    <p>Proyección N°<?php ?></p>
    <br>
    <p>La proyección preliminar N°<?php ?> ha sido aprobada por coordinación, remitida para presentación y aprobación frente al plan de contratación a las </p>
    <p>áreas de vicerrectoría administrativa y financiera.</p>
    <br>
    <p>Ingrese al sistema para hacer seguimiento.</p>
    
</body>
</html>
@endif

@if($filter=="apertura_proy")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Módulo de Proyección Preliminar Activo</title>
</head>
<body>
    <br>
    <p>El módulo de proyección preliminar se encuentra activo desde <?php ?> hasta <?php?>.</p>
    <p></p>
    <br>
    <p>Ingrese al sistema para hacer seguimiento.</p>
    
</body>
</html>
@endif

@if($filter=="cierre_proy")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Módulo de Proyección Preliminar Inactivo</title>
</head>
<body>
    <br>
    <p>El módulo de proyección preliminar se encuentra inactivo desde <?php ?>.</p>
    <p></p>
    <br>
    {{-- <p>Ingrese al sistema para hacer seguimiento.</p> --}}
    
</body>
</html>
@endif

@if($filter=="apertura_solic")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Módulo de Solicitud de Prácticas Activo</title>
</head>
<body>
    <br>
    <p>El módulo de proyección preliminar se encuentra activo desde <?php ?> hasta <?php?>.</p>
    <p></p>
    <br>
    {{-- <p>Ingrese al sistema para hacer seguimiento.</p> --}}
    
</body>
</html>
@endif

@if($filter=="cierre_solic")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Módulo de Solicitud de Prácticas Inactivo</title>
</head>
<body>
    <br>
    <p>El módulo de solicitud de prácticas se encuentra inactivo desde <?php ?>.</p>
    <p></p>
    <br>
    {{-- <p>Ingrese al sistema para hacer seguimiento.</p> --}}
    
</body>
</html>
@endif

@if($filter=="creacion_proy")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Nueva Proyección Preliminar N°<?php echo $nueva_proyeccion->id?></title>
</head>
<body>
    <p>Se ha creado una nueva proyección preliminar N°<?php echo $nueva_proyeccion->id?></p>
    <br>
    <p>DETALLES </p>
    <p>Programa Acádemico: <?php echo $nueva_proyeccion->programa_academico?></p>
    <p>Espacio Acádemico: <?php echo $nueva_proyeccion->codigo_espacio_academico?> - <?php echo $nueva_proyeccion->espacio_academico?></p>
    <p>Período Acádemico: <?php echo $nueva_proyeccion->periodo_academico?></p>
    <p>Semestre Asignatura: <?php echo $nueva_proyeccion->semestre_asignatura?></p>
    <p>Ruta 1: <?php echo $nueva_proyeccion->destino_rp?></p>
    <p>Ruta 2: <?php echo $nueva_proyeccion->destino_ra?></p>
    {{-- @if(Auth::user()->coordinador()) --}}
    @if($email['role'] == 4)
    <p>Docente Responsable: <?php echo $nueva_proyeccion->full_name?></p>
    <br>
    @endif
    <br>
    <p>La proyección preliminar se encuentra pendiente a proceso de revisión y aprobación.</p>  
    <br>
    <p>Ingrese al sistema para hacer seguimiento.</p>
    
</body>
</html>
@endif

@if($filter=="creacion_solic")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Nueva Solicitud de Práctica N°<?php echo $nueva_solicitud->id?></title>
</head>
<body>
    <br>
    <p>Se ha creado una nueva solicitud de práctica N°<?php echo $nueva_solicitud->id?>.</p>
    <br>
    <p>DETALLES </p>
    <p>Programa Acádemico: <?php echo $nueva_solicitud->programa_academico?></p>
    <p>Espacio Acádemico: <?php echo $nueva_solicitud->codigo_espacio_academico?> - <?php echo $nueva_solicitud->espacio_academico?></p>
    <p>Período Acádemico: <?php echo $nueva_solicitud->periodo_academico?></p>
    <p>Semestre Asignatura: <?php echo $nueva_solicitud->semestre_asignatura?></p>
    <p>Tipo Ruta: <?php echo $nueva_solicitud->tipo_ruta?></p>
    <p>Destino Ruta: <?php if($nueva_solicitud->tipo_ruta == 1) {echo $nueva_solicitud->destino_rp;} elseif($nueva_solicitud->tipo_ruta == 2){echo $nueva_solicitud->destino_ra;}?></p>
    <p>Fecha Salida: <?php echo $nueva_solicitud->fecha_salida?></p>
    <p>Fecha Regreso: <?php echo $nueva_solicitud->fecha_regreso?></p>
    <p>N° Estudiantes: <?php echo $nueva_solicitud->num_estudiantes?></p>
    <p>N° Docentes Apoyo: <?php echo $nueva_solicitud->num_acompaniantes?></p>
    <p>N° Acompañantes: <?php echo $nueva_solicitud->num_acompaniantes_apoyo?></p>
    <br>
    {{-- @if(Auth::user()->coordinador()) --}}
    @if($email['role'] == 4)
    <p>Docente Responsable: <?php echo $nueva_solicitud->full_name?></p>
    <br>
    @endif
    <br>
    <p>La solicitud de práctica se encuentra pendiente a proceso de revisión y aprobación.</p>  
    <br>
    <p>Ingrese al sistema para hacer seguimiento.</p>
    
</body>
</html>
@endif

@if($filter=="aprob_coord_proy")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificación Proyección Preliminar</title>
</head>
<body>
    <p>Aprobación Coordinación - Proyección Preliminar N°<?php echo $nueva_proyeccion->id?></p>
    <br>
    {{-- @foreach ($email as $item) --}}
    {{-- @if(Auth::user()->docente()) --}}
    @if($email['role'] == 5)
    <p>La proyección preliminar N°<?php echo $nueva_proyeccion->id?> ha sido aprobada por coordinación, remitida para presentación y aprobación frente al plan de contratación a las áreas de </p>
    <p>vicerrectoría administrativa y financiera.</p>
    <p>Docente</p>
    <br>
    @endif
    @if($email['role'] == 2)
    <p>La proyección preliminar N°<?php echo $nueva_proyeccion->id?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y presentación del plan de contratación a las áreas de </p>
    <p>vicerrectoría administrativa y financiera.</p>
    <p>Decano</p>
    <br>
    @endif
    @if($email['role'] == 3)
    <p>La proyección preliminar N°<?php echo $nueva_proyeccion->id?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y presentación del plan de contratación a las áreas de </p>
    <p>vicerrectoría administrativa y financiera.</p>
    <p>asistente Decanatura</p>
    <br>
    @endif
    {{-- @endforeach --}}
    <br>
    <p>Ingrese al sistema para hacer seguimiento.</p>
    
</body>
</html>
@endif

@if($filter=="aprob_coord_solic")
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <p>Aprobación Coordinación - Solicitud Práctica N°<?php ?></p>
</head>
<body>
    <p>Solicitud de Práctica N°<?php echo $nueva_solicitud->id?></p>
    <br>
    {{-- @if(Auth::user()->docente()) --}}
    @if($email['role'] == 5)
    <p>La solicitud de práctica N°<?php echo $nueva_solicitud->id?> ha sido aprobada por coordinación, remitida al Consejo de Factuldad para el</p>
    <p>debido trámite.</p>
    <br>
    @endif
    {{-- @if(Auth::user()->decano()) --}}
    @if($email['role'] == 2)
    <p>La solicitud de práctica N°<?php echo $nueva_solicitud->id?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
    <p>presentación al consejo de facultad.</p>
    <br>
    @endif
    {{-- @if(Auth::user()->asistenteD()) --}}
    @if($email['role'] == 3)
    <p>La solicitud de práctica N°<?php echo $nueva_solicitud->id?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
    <p>presentación al consejo de facultad.</p>
    <br>
    @endif
    <br>
    <p>Ingrese al sistema para hacer seguimiento.</p>
    
</body>
</html>
@endif

@if($filter=="aprob_ejec_solic")
<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <p>Aprobación para Ejecución - Solicitud Práctica N°<?php ?></p>
    </head>
    <body>
        <p>Solicitud de Práctica N°<?php ?></p>
        <br>
        @if(Auth::user()->docente() || Auth::user()->coordinador())
        <p>Mediante acta de consejo de facultad N°<?php ?> su práctica ha sido aprobada para ejecución, sirvase revisar la programación </p>
        <p>pra realizar los trámites administrativos respectivos para la solicitud del avance de dineros con antelación de </p>
        <p>15 días a la fecha de salida programada (formatos de solicitud avance y solicitud práctica).</p>
        <br>
        @endif
        {{-- @if(Auth::user()->decano())
        <p>La solicitud de práctica N°<?php ?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
        <p>presentación al consejo de facultad.</p>
        <br>
        @endif
        @if(Auth::user()->asistenteD())
        <p>La solicitud de práctica N°<?php ?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
        <p>presentación al consejo de facultad.</p>
        <br>
        @endif --}}
        <br>
        <p>Ingrese al sistema para hacer seguimiento.</p>
        
    </body>
</html>
@endif

@if($filter=="radic_avance_tesor_solic")
<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <p>Radicación Avance - Solicitud Práctica N°<?php ?></p>
    </head>
    <body>
        <p>Solicitud de Práctica N°<?php ?></p>
        <br>
        @if(Auth::user()->docente() || Auth::user()->coordinador())
        <p>La solicitud de avance está radicada en tesorería bajo el N°<?php ?>, acérquese a la oficina de tesorería para </p>
        <p>el respectivo proceso de retiro de dinero según procedimiento establecido.</p>
        <br>
        @endif
        {{-- @if(Auth::user()->decano())
        <p>La solicitud de práctica N°<?php ?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
        <p>presentación al consejo de facultad.</p>
        <br>
        @endif
        @if(Auth::user()->asistenteD())
        <p>La solicitud de práctica N°<?php ?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
        <p>presentación al consejo de facultad.</p>
        <br>
        @endif --}}
        <br>
        <p>Ingrese al sistema para hacer seguimiento.</p>
        
    </body>
</html>
@endif

@if($filter=="info_solic_estudiantes")
<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <p>Documentación Práctica de Campo N°<?php ?></p>
    </head>
    <body>
        <p>Práctica de Campo N°<?php ?></p>
        <br>
        {{-- @if(Auth::user()->docente() || Auth::user()->coordinador()) --}}
        <p>La práctica de campo N°<?php ?> se encuentra aprobada para desarrollarse dentro de las fechas <?php ?> - <?php ?>, </p>
        <p>por favor seguir las instrucciones y recomendaciones del docente.</p>
        <br>
        <p>Ingrese al siguiente link: <?php ?> para registrar la información de contacto y subir la documentación solicitada.</p>
        <p>El usuario corresponde al código estudiantil, y la contraseña es el número del documento de identificación.</p>
        <br>
        {{-- @endif --}}
        {{-- @if(Auth::user()->decano())
        <p>La solicitud de práctica N°<?php ?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
        <p>presentación al consejo de facultad.</p>
        <br>
        @endif
        @if(Auth::user()->asistenteD())
        <p>La solicitud de práctica N°<?php ?> ha sido aprobada por coordinación para la consolidación en el plan de prácticas y </p>
        <p>presentación al consejo de facultad.</p>
        <br>
        @endif --}}
        <br>
        <p>La plataforma estará habilitada hasta el día <?php ?> hasta las <?php ?>.</p>
        
    </body>
</html>
@endif

@if($filter=="info_transp_vice")
<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <p>Programación Transporte - Solicitud de Práctica de Campo N°<?php ?></p>
    </head>
    <body>
        <p>Solicitud de Práctica de Campo N°<?php ?></p>
        <br>
        {{-- @if(Auth::user()->docente() || Auth::user()->coordinador()) --}}
        <p>La práctica de campo N°<?php ?> se encuentra aprobada y es necesario programar el servicio de transporte </p>
        <p>las siguientes especificaciones: </p>
        <p>Fecha Salida: <?php ?></p>
        <p>Fecha Regreso: <?php ?></p>
        <p>Lugar Salida: <?php ?></p>
        <p>Hora Salida: <?php ?></p>
        <p>Lugar Regreso: <?php ?></p>
        <p>Destino Ruta: <?php ?></p>
        <p>Recorrido Mapa: <?php ?></p>
        <br>
        <p>Por favor informar el número de placa del vehículo, el nombre y celular del transportador a cargo y el número de orden.</p>
        <br>
        
    </body>
</html>
@endif

@if($filter=="noti_transp_solic")
<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <p>Programación Transporte - Solicitud de Práctica de Campo N°<?php ?></p>
    </head>
    <body>
        <p>Solicitud de Práctica de Campo N°<?php ?></p>
        <br>
        {{-- @if(Auth::user()->docente() || Auth::user()->coordinador()) --}}
        <p>La práctica de campo N°<?php ?> se encuentra aprobada y es necesario programar el servicio de transporte </p>
        <p>las siguientes especificaciones: </p>
        <p>Fecha Salida: <?php ?></p>
        <p>Fecha Regreso: <?php ?></p>
        <p>Lugar Salida: <?php ?></p>
        <p>Hora Salida: <?php ?></p>
        <p>Lugar Regreso: <?php ?></p>
        <p>Destino Ruta: <?php ?></p>
        <p>Recorrido Mapa: <?php ?></p>
        <br>
        
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


