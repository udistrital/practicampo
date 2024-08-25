<!DOCTYPE html>
<html>
  <head>
    <title>Simple Click Events</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=geometry&key=AIzaSyCravbajx77Bnp_BBrvAWYTVooUCm7I_zU"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
       #Mapa {
        height:400px;
        width:100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        }
    </style>
    <script>
        $(document).ready(function () {

            $('#Mapa').hide();
            function localizacion(posicion) {

            console.log(posicion.coords);


            var latitud = 39.579745;
            var longitud = 2.654018;

            //Generamos el mapa que muestre y cual será el punto central
            var map = new google.maps.Map(document.getElementById('Mapa'), {
            center: {
            lat: latitud,
            lng: longitud
            },
            zoom: 14
            });

            //Generamos el marcadores para señalar una posición
            var markerMiPosicion = new google.maps.Marker({
            position: {
            lat: latitud,
            lng: longitud
            },
            title: "Ubicación estudiante"
            });

            $('#UbicacionPersonal').click(function () {
            $('#Mapa').show();
            latitudReal = posicion.coords.latitude;
            longitudReal = posicion.coords.longitude;
            var markerPosicionReal = new google.maps.Marker({
            position: {
            lat: latitudReal,
            lng: longitudReal
            },
            title: "Mi actual ubicación"
            });
            markerPosicionReal.setMap(map);
            map.setCenter(markerPosicionReal.getPosition());

            });


            // Mostramos los marcadores en el mapa.
            markerMiPosicion.setMap(map);


            }

            // En caso de no poder geolocalizar hay que tener un mensaje de error (o acción)
            function error() {
            alert('No se puede obtener tu ubicación actual')
            // un error a valorar es que el usuario no permite la geoloc, code:1
            }


            // Ahora empleamos todo lo declarado anteriormente.
            // Comprobamos si el navegador soporta la geolocalización
            if (navigator.geolocation) {
            //Caso SI soporta geolocalización. Ejecuto la API y llamo a mis funciones.
            navigator.geolocation.getCurrentPosition(localizacion, error);
            } else {
            //Caso NO soporta geolocalización
            alert('Navegador NO soporta geolocalización');
            }
            });
    </script>
  </head>
  <body>
    <div class="col-md-12 col-sm-12">
        <input type="button" id="UbicacionPersonal" value="Mi ubicación">
      </div>
      <div class="col-md-12 col-sm-12" id="Mapa"></div>
  </body>
</html>