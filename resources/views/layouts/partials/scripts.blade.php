<!-- Bootstrap core JavaScript -->
<!-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}" type="text/javascript"></script> -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 <!-- <script src="https://code.jquery.com/jquery-migrate-3.4.0.min.js"></script> -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}" type="text/javascript"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}" type="text/javascript"></script>

<!-- Page level plugins -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}" type="text/javascript"></script>

<!-- Page level demo scripts -->
<script src="{{ asset('js/demo/chart-area-demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}" type="text/javascript"></script>

<!-- datepicker scripts -->
<script src="{{ asset('js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>

<!-- mask scripts -->
{{-- <script src="{{ asset('js/jquery.mask.js') }}"></script> --}}

<!-- custom scripts -->
<script src="{{ asset('js/custom.js') }}" type="text/javascript" async="async"></script>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tipsy/1.0.3/jquery.tipsy.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcxFB5k6kTgK_16HMqi_SlKkzHAHMzysQ&callback=initMap"async defer></script>

{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> --}}


<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> jQuery library -->
{{-- <script src="{{ asset('js/timepicker.js') }}" type="text/javascript" async="async"></script> --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- functions-->
 <script>
    $('#importEstudForm').on('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                location.reload();
                alert(response.message);
            },
            error: function(response) {
                alert(response.responseJSON.error);
            }
        });
    });

    $(document).on('click', '.btnVerDocumentos', function () {
        let email = $(this).data('email');
        let id_solicitud = $(this).data('id_solicitud');
        $("#nombreEstudianteDocs").text($(this).data('nombre'));

        $("#listaDocumentos").empty();
        $("#documentosLoader").show();

        $.ajax({
            url: "/ver-documentos-estudiante",
            type: "GET",
            data: { email: email, id: id_solicitud },
            success: function(res) {
                $("#documentosLoader").hide();
                let documentos = res.documentos;
                let html = "";
                let hasDocs = false;

                for (let key in documentos) {
                    if (documentos[key]) {
                        hasDocs = true;
                        html += `
                            <div class="mb-3">
                                <strong>${key.replace(/_/g, " ").toUpperCase()}</strong>

                                <div class="mt-2 d-flex align-items-center">
                                    <button 
                                        class="btn btn-success btn-sm mr-2 btnMostrarPdf" 
                                        style="background-color: #447161; border:0"
                                        data-target="pdf_${key}">
                                        <i class="far fa-eye"></i>
                                        <i class="fa fa-arrow-right"></i>
                                        <i class="fa fa-file"></i>
                                        Ver PDF
                                    </button>
                                </div>

                                <!-- Contenedor oculto del PDF -->
                                <div id="pdf_${key}" style="display:none;">
                                    <embed src="${documentos[key].pdf}" width="100%" height="600">
                                </div>
                            </div>
                        `;
                    }
                }
                if (!hasDocs) {
                    html = `
                        <div class="alert alert-warning text-center">
                            El estudiante no ha subido ningún documento.
                        </div>
                    `;
                }
                $("#listaDocumentos").html(html);
            },
            error: function(err) {
                let mensaje = err.responseJSON?.error || "Error al cargar documentos del estudiante.";
                $("#documentosLoader").hide();
                $("#listaDocumentos").html(`
                    <div class="alert alert-danger text-center">
                        ${mensaje}
                    </div>
                `);
            }
        });
    });
    $(document).on('click', '.btnMostrarPdf', function () {
        let target = $(this).data('target');
        let div = $('#' + target);

        div.toggle();

        if (div.is(':visible')) {
            $(this).html(`<i class="fa fa-eye-slash"></i> Ocultar PDF`);
        } else {
            $(this).html(`
                <i class="far fa-eye"></i>
                <i class="fa fa-arrow-right"></i>
                <i class="fa fa-file"></i>
                Ver PDF
            `);
        }
    });

    $(document).on('click', '.btnEliminarEstudiante', function() {
        let id_solicitud = $(this).data('id_solicitud');
        let email = $(this).data('email');

        if(!confirm("¿Seguro que deseas eliminar este estudiante? Esta acción no se puede deshacer.")) {
            return;
        }

        $.ajax({
            url: '/eliminar-estudiante',
            type: 'POST',
            data: {
                id: id_solicitud,
                email: email,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                alert(res.message);
                location.reload();
            },
            error: function(err) {
                alert(err.responseJSON?.error || "Ha ocurrido un error al eliminar el estudiante");
            }
        });
    });

    $(document).on('click', '.btnVerificarAsistenciaEstudiante', function() {
        let id_solicitud = $(this).data('id_solicitud');
        let email = $(this).data('email');
        let valor = $(this).data('valor');
        let $btn = $(this);
        let $checkbox = $btn.closest('td').find('input[type="checkbox"]');

        let fila = $(this).closest('td'); 
        let btnGuardar = fila.find('.btnGuardarAsist');
        let btnQuitar = fila.find('.btnQuitarAsist');

        if(valor === 1){
            if(!confirm("¿Seguro que deseas guardar la asistencia de este estudiante?")) {
                return;
            }
        }else{
            if(!confirm("¿Seguro que deseas quitar la asistencia de este estudiante?")) {
                return;
            }
        }        

        $.ajax({
            url: '/verificar-asistencia-estudiante',
            type: 'POST',
            data: {
                id: id_solicitud,
                email: email,
                valor: valor,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                alert(res.message);
                
                if(valor === 1){
                    $checkbox.prop('checked', true);
                    btnGuardar.prop('disabled', true);
                    btnQuitar.prop('disabled', false);
                }else{
                    $checkbox.prop('checked', false);
                    btnGuardar.prop('disabled', false);
                    btnQuitar.prop('disabled', true);
                }                 
            },
            error: function(err) {
                console.log(err);
                alert(err.responseJSON?.error || "Ha ocurrido un error al verificar la asistencia del estudiante");
            }
        });
    });

    $(document).on('click', '.btnAbrilModalCrearEstudiante', function() {
        let id_solicitud = $(this).data('id_solicitud');
        $("#id_solicitud_modal").val(id_solicitud);
        $("#codigo_estudiante, #nombre_completo, #email_estudiante, #grupo_estudiante").val('');
    });
    $(document).on("click", "#btnCrearEstudiante", function () {
        if(!confirm("¿Seguro que deseas añadir este estudiante a la lista?")) {
            return;
        }

        $.ajax({
            url: '/crear-estudiante',
            type: 'POST',
            data: {
                id_solicitud: $("#id_solicitud_modal").val(),
                codigo_estudiante: $("#codigo_estudiante").val(),
                nombre_completo: $("#nombre_completo").val(),
                email: $("#email_estudiante").val(),
                grupo: $("#grupo_estudiante").val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                alert(res.message);
                $('#modalCrearEstudiante').modal('hide');
                location.reload();
            },
            error: function(err) {
                console.log(err);
                alert(err.responseJSON?.error || "Ha ocurrido un error al añadir el estudiante");
            }
        });
    });

    $(document).on('click', '.btnEnviarSolicitudRevision', function() {
        let id_solicitud = $(this).data('id_solicitud');

        if(!confirm("¿Seguro que deseas enviar la solicitud? Asegurate de haber revisado correctamente los documentos de los estudiantes.")) {
            return;
        }

        $.ajax({
            url: '/enviar-solicitud-revision',
            type: 'POST',
            data: {
                id: id_solicitud,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                alert(res.message);
                location.href = '/solicitudes/filtrar/proy-comp';
            },
            error: function(err) {
                console.log(err);
                alert(err.responseJSON?.error || "Ha ocurrido un error al enviar la solicitud");
            }
        });
    });
</script>
<script>
    $(document).on('click', '.btnEditarRealizada', function (event) {

        const modalContent = $('#modalContent')
        const url = $(this).data('url');

        modalContent.html(`
            <div class="text-center p-4">
                <span class="spinner-border"></span>
            </div>
        `);

        $('#modalPracticaRealizada').modal('show');

        fetch(url)
            .then(res => res.text())
            .then(html => {
                modalContent.html(html);
            })
            .catch(err => {
                modalContent.html(`<div class="alert alert-danger">Error al cargar</div>`);
            });
    });
    $(document).on('submit', '#formPracticaRealizada', function (event) {
        event.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();        

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function (response) {
                $('#modalPracticaRealizada').modal('hide');
                var id = response.id;
                var nuevoEstado = response.estado;
                $(".estado-" + id).text(nuevoEstado);

            },
            error: function () {
                alert("Error al guardar. Intente nuevamente.");
            }
        });
    });
</script>
<script>
    $(document).on('click', '.btnTraspasarProgramacion', function (event) {
        var id = $(this).data('id');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/programaciones/cargar_docentes_traspaso/' + id,
            type: 'POST',
            success: function(response) {
                var select = $('#selectDocentes');
                select.empty();
                if(response.docentes.length > 0){
                    response.docentes.forEach(function(docente){
                        var selected = (docente.id == response.id_docente_responsable) ? 'selected' : '';
                        select.append('<option value="'+docente.id+'" '+selected+'>'+docente.full_name+'</option>')
                    });
                } else {
                    select.append('<option value="">No hay docentes disponibles</option>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if(jqXHR.responseJSON && jqXHR.responseJSON.error){
                    alert(jqXHR.responseJSON.error);
                } else {
                    alert("Ocurrió un error al cargar los docentes. Código: " + jqXHR.status);
                }
            }         
        });
        $('#formTraspasarProgramacion').attr('action', '{{ route("programacion_traspasar_update", "") }}/' + id);
    });
</script>
<script>
    $(document).on('click', '.btnTraspasarSolicitud', function (event) {
        var id = $(this).data('id');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/solicitudes/cargar_docentes_traspaso/' + id,
            type: 'POST',
            success: function(response) {
                var select = $('#selectDocentes');
                select.empty();
                if(response.docentes.length > 0){
                    response.docentes.forEach(function(docente){
                        var selected = (docente.id == response.id_docente_responsable) ? 'selected' : '';
                        select.append('<option value="'+docente.id+'" '+selected+'>'+docente.full_name+'</option>')
                    });
                } else {
                    select.append('<option value="">No hay docentes disponibles</option>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if(jqXHR.responseJSON && jqXHR.responseJSON.error){
                    alert(jqXHR.responseJSON.error);
                } else {
                    alert("Ocurrió un error al cargar los docentes. Código: " + jqXHR.status);
                }
            }         
        });
        $('#formTraspasarSolicitud').attr('action', '{{ route("solicitud_traspasar_update", "") }}/' + id);
    });
</script>
<script>
    $(document).on('click', '.btnActualizarPresupuestoProgramaAcademico', function () {
        var id = $(this).data('id');
        var id_programa_academico = $(this).data('id_programa_academico');
        var programa_academico = $(this).data('programa_academico');
        var presupuesto_inicial = Number($(this).data('presupuesto_inicial'))
                                                .toLocaleString('es-CO');
        var presupuesto_actual = Number($(this).data('presupuesto_actual'))
                                                .toLocaleString('es-CO');

        $('#id_programa_academico').val(id_programa_academico);
        $('#programa_academico').val(programa_academico);
        $('#presupuesto_inicial').val('$ '+presupuesto_inicial);
        $('#presupuesto_actual').val('$ '+presupuesto_actual);

        $('#formActualizarPresupuestoProgramaAcademico').attr('action', '{{ route("presupuesto_update", "") }}/' + id);

    });
</script>
<script>
    $(document).on('click', '.btnSumarPresupuestoProgramaAcademico', function () {
        var id = $(this).data('id');
        var id_programa_academico = $(this).data('id_programa_academico');
        var programa_academico = $(this).data('programa_academico');
        var presupuesto_inicial = Number($(this).data('presupuesto_inicial'))
                                                .toLocaleString('es-CO');
        var presupuesto_actual = Number($(this).data('presupuesto_actual'))
                                                .toLocaleString('es-CO');

        $('#id_programa_academico_sum').val(id_programa_academico);
        $('#programa_academico_sum').val(programa_academico);
        $('#presupuesto_inicial_sum').val(presupuesto_inicial);
        $('#presupuesto_actual_sum').val(presupuesto_actual);

        $('#formSumarPresupuestoProgramaAcademico').attr('action', '{{ route("presupuesto_sum", "") }}/' + id);

    });
    $('#sumar_presupuesto_programa_academico').on('input', function () {

        var presupuesto_inicial = Number($('#presupuesto_inicial_sum').val().replace(/\D/g, ""));  
        var presupuesto_actual  = Number($('#presupuesto_actual_sum').val().replace(/\D/g, ""));

        var nuevo = Number($(this).val().replace(/\D/g, ""));

        if (isNaN(nuevo)) nuevo = 0;

        var nuevo_inicial  = Number(presupuesto_inicial + nuevo).toLocaleString('es-CO');
        var nuevo_restante = Number(presupuesto_actual + nuevo).toLocaleString('es-CO');

        $('#prev_nuevo_presupuesto_inicial').val(nuevo_inicial);
        $('#prev_nuevo_presupuesto_actual').val(nuevo_restante);
    });
</script>
<script>
    $(document).on('click', '.btnActualizarPresupuestoTransporteMenor', function () {
        var id = $(this).data('id');
        var presupuesto_inicial = Number($(this).data('presupuesto_inicial_tm'))
                                                .toLocaleString('es-CO');
        var presupuesto_restante = Number($(this).data('presupuesto_restante_tm'))
                                                .toLocaleString('es-CO');

        $('#id_transporte_menor').val(id);
        $('#presupuesto_inicial_tm').val('$ '+presupuesto_inicial);
        $('#presupuesto_restante_tm').val('$ '+presupuesto_restante);

        $('#formActualizarPresupuestoTransporteMenor').attr('action', '{{ route("presupuesto_update_tm", "") }}');

    });
</script>
<script>
    $(document).on('click', '.btnSumarPresupuestoTransporteMenor', function () {
        var id = $(this).data('id');
        var presupuesto_inicial = Number($(this).data('presupuesto_inicial_tm'))
                                                .toLocaleString('es-CO');
        var presupuesto_restante = Number($(this).data('presupuesto_restante_tm'))
                                                .toLocaleString('es-CO');

        $('#id_transporte_menor_sum').val(id);
        $('#presupuesto_inicial_tm_sum').val(presupuesto_inicial);
        $('#presupuesto_restante_tm_sum').val(presupuesto_restante);

        $('#formSumarPresupuestoTransporteMenor').attr('action', '{{ route("presupuesto_sum_tm", "") }}/' + id);

    });
    $('#sumar_presupuesto_transporte_menor').on('input', function () {

        var presupuesto_inicial = Number($('#presupuesto_inicial_tm_sum').val().replace(/\D/g, ""));  
        var presupuesto_actual  = Number($('#presupuesto_restante_tm_sum').val().replace(/\D/g, ""));

        var nuevo = Number($(this).val().replace(/\D/g, ""));

        if (isNaN(nuevo)) nuevo = 0;

        var nuevo_inicial  = Number(presupuesto_inicial + nuevo).toLocaleString('es-CO');
        var nuevo_restante = Number(presupuesto_actual + nuevo).toLocaleString('es-CO');

        $('#prev_nuevo_presupuesto_inicial_tm').val(nuevo_inicial);
        $('#prev_nuevo_presupuesto_restante_tm').val(nuevo_restante);
    });
</script>
<script>
    $(document).on('click', '.btnEditarProgramaAcademico', function () {
        var id = $(this).data('id');
        var programa_academico = $(this).data('programa_academico');
        var pregrado = $(this).data('pregrado');
        $('#nombre_programa_academico_edit').val(programa_academico);

        if(pregrado === 1){
            $('#pregrado_edit_si').prop('checked', true);
        }else{
            $('#pregrado_edit_no').prop('checked', true);
        }        
        $('#formEditarProgramaAcademico').attr('action', '{{ route("update_programa_academico", "") }}/' + id);
    });
</script>
<script>
    $(document).on('click', '.btnEditarEspacioAcademico', function () {
        var id = $(this).data('id');
        var id_programa_academico = $(this).data('id_programa_academico');
        var codigo_espacio_academico = $(this).data('codigo_espacio_academico');
        var espacio_academico = $(this).data('nombre_espacio_academico');
        var plan_estudios_1 = $(this).data('plan_estudios_1');
        var plan_estudios_2 = $(this).data('plan_estudios_2');
        var tipo_espacio = $(this).data('tipo_espacio');
        var electiva = $(this).data('electiva');

        $('#id_programa_academico_edit').val(id_programa_academico);
        $('#codigo_espacio_academico_edit').val(codigo_espacio_academico);
        $('#nombre_espacio_academico_edit').val(espacio_academico);
        $('#plan_estudios_1_edit').val(plan_estudios_1);
        $('#plan_estudios_2_edit').val(plan_estudios_2);
        $('#tipo_espacio_edit').val(tipo_espacio);

        if(electiva === 1){
            $('#electiva_edit_si').prop('checked', true);
        }else{
            $('#electiva_edit_no').prop('checked', true);
        }

        $('#formEditarEspacioAcademico').attr('action', '{{ route("update_espacio_academico", "") }}/' + id);

    });
</script>
<script>
    $(document).on('click', '.btnEditarEstudiante', function () {
        var num_identificacion = $(this).data('num_identificacion');
        var codigo_estudiante = $(this).data('codigo_estudiante');
        var nombre_completo = $(this).data('nombre_completo');
        var email = $(this).data('email');
        var fecha_nacimiento = $(this).data('fecha_nacimiento');
        var celular = $(this).data('celular');
        var eps = $(this).data('eps');

        $('#num_identificacion_edit').val(num_identificacion);
        $('#codigo_estudiante_edit').val(codigo_estudiante);
        $('#nombre_completo_edit').val(nombre_completo);
        $('#email_edit').val(email);
        $('#fecha_nacimiento_edit').val(fecha_nacimiento);
        $('#celular_edit').val(celular);
        $('#eps_edit').val(eps);

        $('#formEditarEstudiante').attr('action', '{{ route("estudiante_update", "") }}/' + email);
    });

    $(document).on('click', '.btnGuardarEstudiante', function () {
        console.log('CLICK GUARDAR DISPARADO');
        let form = $('#formEditarEstudiante');
        let url  = form.attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function(res) {
                alert(res.message);  
                $('#editModal').modal('hide');
                location.reload();             
            },
            error: function(err) {
                console.log(err);
                alert(err.responseJSON?.error || "Ha ocurrido un error al actualizar los datos del estudiante");
            }
        });

    });
</script>
<script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        })   
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: "Seleccione...",
            allowClear: true
        });
    });
</script>
<script>

$(document).ready(function() {
    // fecha_actual = new Date();
    $('.datetimepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true,
        // maxDate: '+0d',
        // minDate: new Date()
    });

    // $('.datetimepickerHr').timepicker({
    //     pickDate: false 
    //     timeFormat: 'h:mm p',
    //     interval: 60,
    //     minTime: '10',
    //     maxTime: '6:00pm',
    //     defaultTime: '11',
    //     startTime: '10:00',
    //     dynamic: false,
    //     dropdown: true,
    //     scrollbar: true
    // });
    $('.data-create').datepicker(
        'setDate', new Date()
    );

    
    $('input.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        startTime: '1',
        scrollbar: false
    });

    // $('#hora_salida_rp').timepicker({
    //     timeFormat: 'h:mm p',
    //     interval: 60,
    //     minTime: '0',
    //     maxTime: '12:00pm',
    //     defaultTime: '11',
    //     startTime: '10:00',
    //     dynamic: false,
    //     dropdown: true,
    //     scrollbar: true
    // });
    $('[data-toggle="tooltip"]').tooltip();
});

function filterUser(value)
{
    switch(value)
    {
        case '3':
            href = "{!! route('users_filter','all'); !!}";
            break;
        case '2':
            href = "{!! route('users_filter','inac'); !!}";
            break;
        case '1':
            href = "{!! route('users_filter','act'); !!}";
            break;
        default:
    }
    window.location.href = href;
}

$('input:radio[name="id_estado_usuario"]').change(
    function(){
        filterUser(this.value);
       
});

function filtrar_programaciones(value)
{
    switch(value)
    {
        case '1':
            href = "{!! route('programacion_filter','all'); !!}";
            break;
        case '2':
            href = "{!! route('programacion_filter','send'); !!}";
            break;
        case '3':
            href = "{!! route('programacion_filter','not_send'); !!}";
            break;

        case '4':
            href = "{!! route('programacion_filter','ext_mu'); !!}";
            break;

        case '5':
            href = "{!! route('programacion_filter','sin_pres'); !!}";
            break;

        case '6':
            href = "{!! route('programacion_filter','elect'); !!}";
            break;
        
        case '7':
            href = "{!! route('programacion_filter','pend'); !!}";
            break;

        case '8':
            href = "{!! route('programacion_filter','not_aprob'); !!}";
            break;

        case '9':
            href = "{!! route('programacion_filter','aprob'); !!}";
            break;

        case '10':
            href = "{!! route('programacion_filter','no-elect'); !!}";
            break;

        case '11':
            href = "{!! route('programacion_filter','aprob-cons'); !!}";
            break;
        
        case '12':
            href = "{!! route('programacion_filter','no-aprob-cons'); !!}";
            break;

        case '13':
            href = "{!! route('programacion_filter','proy_legal'); !!}";
            break

        case '14':
            href = "{!! route('programacion_filter','proy_recha'); !!}";
            break
        
        case '15':
            href = "{!! route('programacion_filter','not_send_docente'); !!}";
            break

        case '16':
            href = "{!! route('programacion_filter','inact'); !!}";
            break
        
        case '17':
        href = "{!! route('programacion_filter','edit_proy'); !!}";
        break

        case '18':
            href = "{!! route('programacion_filter','proy_recha_cons'); !!}";
            break

        case '19':
        href = "{!! route('programacion_filter','traspasar'); !!}";
        break

        default:
        
    }
    window.location.href = href;
}

$('input:radio[name="id_filtro_programacion"]').change(
    function(){
        filtrar_programaciones(this.value);
       
});



function obtenerUsuario()
{
    var correo = document.getElementById("email").value;
    var correo_analizado = /^([^]+)@(\w+).(\w+).(\w+)$/.exec(correo);

    if(correo_analizado == null)
    {
       correo_analizado = /^([^]+)@(\w+).(\w+).(\w+).(\w+)$/.exec(correo);
       var [,nombre,adicional,servidor,dominio] = correo_analizado;
    }
    else{

        var [,nombre,servidor,dominio] = correo_analizado;
    }

    document.getElementById("usuario").value = nombre;
}


function filtrar_solicitudes(value)
{
    switch(value)
    {
        case '1':
            href = "{!! route('solicitud_filter','all'); !!}";
            break;
        case '2':
            href = "{!! route('solicitud_filter','send'); !!}";
            break;
        case '3':
            href = "{!! route('solicitud_filter','not_send'); !!}";
            break;

        case '4':
            href = "{!! route('solicitud_filter','ext_mu'); !!}";
            break;

        case '5':
            href = "{!! route('solicitud_filter','sin_pres'); !!}";
            break;

        case '6':
            href = "{!! route('solicitud_filter','elect'); !!}";
            break;
        
        case '7':
            href = "{!! route('solicitud_filter','pend'); !!}";
            break;

        case '8':
            href = "{!! route('solicitud_filter','not_aprob'); !!}";
            break;

        case '9':
            href = "{!! route('solicitud_filter','aprob'); !!}";
            break;

        case '10':
            href = "{!! route('solicitud_filter','no-elect'); !!}";
            break;

        case '11':
            href = "{!! route('solicitud_filter','aprob-cons'); !!}";
            break;
        
        case '12':
            href = "{!! route('solicitud_filter','no-aprob-cons'); !!}";
            break;

        case '13':
            href = "{!! route('solicitud_filter','pre-proy'); !!}";
            break;
        
        case '14':
            href = "{!! route('solicitud_filter','proy-aprob'); !!}";
            break;

        case '15':
            href = "{!! route('solicitud_filter','proy-comp'); !!}";
            break;
        
        case '16':
            href = "{!! route('solicitud_filter','ejec-sol'); !!}";
            break;   
            
        
        case '17':
            href = "{!! route('solicitud_filter','pend-teso'); !!}";
            break;

        case '18':
            href = "{!! route('solicitud_filter','pend-cierre'); !!}";
            break;

        case '19':
            href = "{!! route('solicitud_filter','transp'); !!}";
            break;

        case '20':
            href = "{!! route('solicitud_filter','sol_recha'); !!}";
            break;

        case '21':
            href = "{!! route('solicitud_filter','enc_trans'); !!}";
            break;
            
        case '22':
            href = "{!! route('solicitud_filter','estud'); !!}";
            break;
            
        case '23':
        href = "{!! route('solicitud_filter','sol_realizadas'); !!}";
        break;

        case '24':
        href = "{!! route('solicitud_filter','edit_sol'); !!}";
        break

        case '25':
        href = "{!! route('solicitud_filter','traspasar'); !!}";
        break

        default:
        
    }
    window.location.href = href;
}

$('input:radio[name="id_filtro_solicitud"]').change(
    function(){
        filtrar_solicitudes(this.value);
       
});

function filtrar_solicutudes_estudiante(value)
{
    switch(value)
    {
        case '1':
            href = "{!! route('estudiante_filter_solicitud','sol_estudiante'); !!}";
            break;
        case '2':
            href = "{!! route('estudiante_filter_solicitud','sol_evaluacion'); !!}";
            break;

        default:
        
    }
    window.location.href = href;
}

$('input:radio[name="id_filtro_estudiante"]').change(
    function(){
        filtrar_solicutudes_estudiante(this.value);
       
});

</script>

