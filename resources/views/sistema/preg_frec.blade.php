<!-- HTML HEAD -->
@extends('layouts.app2')
<!-- end HTML HEAD -->

@if(Auth::user()->inactivo())
  @section('contenido')
    <div class="container-fluid">
      <h6> Usuario Inactivo</h6>
      
  @endsection

@else
  @section('contenido')
  <div class="container-fluid" style="position: relative;">
    <br>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 card-header">{{ __('Preguntas Frecuentes') }}</div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10" style="padding-left:0;padding-right:0">
                <button class="accPregFrec" name="accPregFrec">¿Qué son las proyecciones de las prácticas académicas de campo?</button>
                <div class="panelPregFrec">
                    <p>RESOLUCIÓN N° 090 (Octubre 16 de 2018) ART.3 - DE LA PLANEACIÓN: a) Los consejos curriculares o quien haga sus veces de los diferentes programas académicos, a más tardar en la última 
                       semana del mes de julio proyectarán las posibles prácticas académicas a realizarse en el siguiente año lectivo,
                       acorde con la estructura curricular y en consonancia con los respectivos syllabus; y las presentará a la Oficina de 
                       Planeación. Esto constituye un insumo en la planeación presupuestal de la facultad.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Qué son las solicitudes de las prácticas académicas de campo?</button>
                <div class="panelPregFrec">
                    <p>Una vez el consejo de facultad brinde la aprobación a las proyecciones de las prácticas académicas, estas deberán contar con
                        la información completa para proceder con los trámites administrativos ya estipulados por la universidad.
                    </p>
                    <p>RESOLUCIÓN N° 090 (Octubre 16 de 2018) ART.3 - DE LA PLANEACIÓN: c) El plan de prácticas académicas por facultad 
                        será remitido en la primera semana de labores administrativas de la correspondiente vigencia a la Vicerrectora 
                        Académica de ahí se procederá a lo pertinente en el plan de adquisiciones.
                    </p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cualquier práctica académica de campo se tramitará por el sistema web PracticampoUD?</button>
                <div class="panelPregFrec">
                    <p>Todas las solicitudes de prácticas académicas de campo de la Facultad del Medio Ambiente y Recursos Naturales de la Universidad 
                        Distrital Francisco José de Caldas se deben registrar mediante el sistema web PracticampoUD.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cómo cambiar la contraseña para el ingreso al sistema web PracticampoUD?</button>
                <div class="panelPregFrec">
                    <p>Para el cambio de contraseña debe seleccionar la opción ¿Olvidaste tu contraseña? que se encuentra en la vista de inicio de sesión 
                        del sistema web, allí se direccionará a una vista para restablecer la contraseña en la cual se deberá indicar el correo electrónico 
                        institucional asociado al usuario y el sistema enviará un link para restablecer la contraseña a dicho correo.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cómo verificar las fechas en las que los módulos de Proyecciones y Solicitudes están habilitados?</button>
                <div class="panelPregFrec">
                    <p>Al iniciar sesión se puede visualizar un cuadro de Información de Interés en el cual se pueden conocer las fechas en las que los 
                        diferentes módulos del sistema web estarán inhabilitados.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cómo se debe proceder frente a las actividades de riesgo?</button>
                <div class="panelPregFrec">
                    <p>Cada práctica académica de campo debe contar con el respectivo plan de contingencia basado en una la mátriz de riesgos,
                        de esta forma se contará con un procedimiento a seguir según cada actividad de riesgo conteplada para dicha práctica.
                    </p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Es obligatorio registrar ruta de contingencia?</button>
                <div class="panelPregFrec">
                    <p>Con el fin de evitar cancelaciones en las prácticas académicas de campo el sistema web requiere de manera obligatoria el registro 
                        de una ruta de contingencia.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿En dónde se se debe incluir el/la monitor(a)?</button>
                <div class="panelPregFrec">
                    <p>Cuando la práctica académica de campo cuente con Monitor, este se debe incluir en el número de estudiantes. De esta forma recibirá 
                        el correspondiente auxilio.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cómo se verifica la veracidad de los soportes que suben los estudiantes?</button>
                <div class="panelPregFrec">
                    <p>Cada estudiante al diligenciar los correspondientes soportes requeridos reconoce la veracidad, exactitud, vigencia, autenticidad de
                        la información y los datos personales suministrados.
                    </p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cuáles son los requisitos que se deben presentar para la legalización de la práctica académica de campo? </button>
                <div class="panelPregFrec">
                    <p>Para realizar el proceso de legalización de avances puede ingresar a: http://planeacion.udistrital.edu.co:8080/sigud/pa/grf donde encontrará 
                        el instructivo para la legalización de la ejecución de gastos del presupuesto de la Universidad Distrital autorizados a través de avances.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cuál es el proceso para que el docente reciba los viáticos  de docentes y el auxilio de los estudiantes?</button>
                <div class="panelPregFrec">
                    <p>El sistema web le notificará al correo institucional del docente responsable de la práctica académica de campo el número de radicado en financiera para 
                        ejecutar el respectivo retiro de dinero según procedimiento establecido. Puede verificar el procedimiento de avance 
                        en: http://planeacion.udistrital.edu.co:8080/sigud/pa/grf</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿El sistema tiene servicio de notificaciones a los correos institucionales y personales?</button>
                <div class="panelPregFrec">
                    <p>El sistema web PracticampoUD cuenta con un servicio de notificaciones asociado al correo electrónico institucional de cada 
                        usuario brindando información concisa sobre cada uno de los cambios relacionados con las prácticas académicas de campo.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cuál es el número máximo de URL que se pueden agregar en las rutas?</button>
                <div class="panelPregFrec">
                    <p>El sistema web cuenta con un máximo de 6 URL con el fin de brindarle al usuario la posibilidad de registrar recorridos largos.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Por cada URL cuántas paradas máximo se pueden colocar?</button>
                <div class="panelPregFrec">
                    <p>El servicio de google maps brinda un máximo de 10 paradas o puntos de destino por cada URL.</p>
                </div>

                <button class="accPregFrec" name="accPregFrec">¿Cuándo se repite el recorrido en diferentes días se debe colocar en la ruta?</button>
                <div class="panelPregFrec">
                    <p>El recorrido de la práctica académica de campo debe ser lo más preciso posible, por lo cual se necesita registrar todas las paradas así se repitan 
                        en diferentes días.</p>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <br>
    </div>
  @endsection
  
@endif
