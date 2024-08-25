@if($filter=="apertura_proy")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Módulo de Proyección Preliminar Activo</title>
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
                        Módulo de Proyección Preliminar
                        <br>
                    </h3>
                </tr>
                <tr>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">El sistema web PractiCampoUD le informa que el módulo de proyección preliminar se encuentra 
                        habilitado desde el <?= $control_sistema->fecha_apert_proy ?> y hasta el <?= $control_sistema->fecha_cierre_proy ?>, fecha en la cual 
                        se inhabilitará nuevamente.</p>
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por favor <strong>NO</strong> responder 
                        a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        *** Antes de imprimir considere si es necesario, "El manejar adecuadamente los recursos es una responsabilidad de todos", reflexione sobre su 
                        compromiso ambiental. ***
                    </p>
                    <p style="font-size: 0.7rem;color:#9a9a9a">© Copyright 2021</p>
                </tr>
                <tr>

                </tr>
            </tbody>             
        </table>
        <br>
        
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
                        Módulo de Proyección Preliminar
                        <br>
                    </h3>
                </tr>
                <tr>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">El sistema web PractiCampoUD le informa que el módulo de proyección preliminar se encuentra 
                        inhabilitado desde el <?= $control_sistema->fecha_cierre_proy ?> y hasta el <?= $control_sistema->fecha_apert_proy ?>, fecha en la cual se habilitará nuevamente.</p>
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por favor <strong>NO</strong> responder a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        <small style="font-size: 0.5rem">***</small> Antes de imprimir considere si es necesario, "El manejar adecuadamente los recursos es una responsabilidad de todos", 
                        reflexione sobre su compromiso ambiental. <small style="font-size: 0.5rem">***</small>
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

@if($filter=="apertura_solic")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Módulo de Solicitud de Prácticas Activo</title>
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
                        Módulo de Solicitud de Práctica
                        <br>
                    </h3>
                </tr>
                <tr>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">El sistema web PractiCampoUD le informa que el módulo de solicitud de práctica se encuentra 
                        habilitado desde el <?= $control_sistema->fecha_apert_solic ?> y hasta el <?= $control_sistema->fecha_cierre_solic ?>, fecha en la cual se inhabilitará nuevamente.</p>
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por favor <strong>NO</strong> responder a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        *** Antes de imprimir considere si es necesario, "El manejar adecuadamente los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. ***
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

@if($filter=="cierre_solic")
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Módulo de Solicitud de Prácticas Inactivo</title>
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
                        Módulo de Solicitud de Práctica
                        <br>
                    </h3>
                </tr>
                <tr>
                    <p style="font-size: 0.875rem">Cordial Saludo,</p>
                    <p style="font-size: 0.875rem">El sistema web PractiCampoUD le informa que el módulo de solicitud de práctica se encuentra 
                        inhabilitado desde el <?= $control_sistema->fecha_cierre_solic ?> y hasta el <?= $control_sistema->fecha_apert_solic ?>, fecha en la cual se habilitará nuevamente.</p>
                    <p style="font-size: 0.875rem">Ingrese al siguiente link: http://practicampo.udistrital.edu.co para hacer seguimiento.</p>
                    <br>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        Este correo fue generado de manera automática por el software PractiCampoUD Versión 1.0 desarrollado por 
                        la Facultad del Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas. Por favor <strong>NO</strong> responder a este correo.
                    </p>
                    <p style="font-size: 0.875rem;color:#9a9a9a">
                        *** Antes de imprimir considere si es necesario, "El manejar adecuadamente los recursos es una responsabilidad de todos", reflexione sobre su compromiso ambiental. ***
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