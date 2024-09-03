<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}" type="text/javascript"></script>
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
<script src="{{ asset('js/timepicker.js') }}" type="text/javascript" async="async"></script>
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> --}}

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


<!-- functions-->
<script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        })   
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
        defaultTime: '7',
        startTime: '7',
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

function filtrar_proyecciones(value)
{
    switch(value)
    {
        case '1':
            href = "{!! route('proyeccion_filter','all'); !!}";
            break;
        case '2':
            href = "{!! route('proyeccion_filter','send'); !!}";
            break;
        case '3':
            href = "{!! route('proyeccion_filter','not_send'); !!}";
            break;

        case '4':
            href = "{!! route('proyeccion_filter','ext_mu'); !!}";
            break;

        case '5':
            href = "{!! route('proyeccion_filter','sin_pres'); !!}";
            break;

        case '6':
            href = "{!! route('proyeccion_filter','elect'); !!}";
            break;
        
        case '7':
            href = "{!! route('proyeccion_filter','pend'); !!}";
            break;

        case '8':
            href = "{!! route('proyeccion_filter','not_aprob'); !!}";
            break;

        case '9':
            href = "{!! route('proyeccion_filter','aprob'); !!}";
            break;

        case '10':
            href = "{!! route('proyeccion_filter','no-elect'); !!}";
            break;

        case '11':
            href = "{!! route('proyeccion_filter','aprob-cons'); !!}";
            break;
        
        case '12':
            href = "{!! route('proyeccion_filter','no-aprob-cons'); !!}";
            break;

        case '13':
            href = "{!! route('proyeccion_filter','proy_legal'); !!}";
            break

        case '14':
            href = "{!! route('proyeccion_filter','proy_recha'); !!}";
            break
        
        case '15':
            href = "{!! route('proyeccion_filter','not_send_docente'); !!}";
            break

        case '16':
            href = "{!! route('proyeccion_filter','inact'); !!}";
            break

        default:
        
    }
    window.location.href = href;
}

$('input:radio[name="id_filtro_proyeccion"]').change(
    function(){
        filtrar_proyecciones(this.value);
       
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
        default:
        
    }
    window.location.href = href;
}

$('input:radio[name="id_filtro_solicitud"]').change(
    function(){
        filtrar_solicitudes(this.value);
       
});


</script>

