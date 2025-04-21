<!-- HTML HEAD -->
@extends('layouts.app2')
@include('layouts.partials.modal_seleccionar_rol')
<!-- end HTML HEAD -->

@if(Auth::user()->inactivo())
  @section('contenido')
    <div class="container-fluid">
      <h6> Usuario Inactivo</h6>
      
  @endsection
@else
  @section('contenido')
  <div class="container-fluid" style="position: relative;">
    @if(!session('rol_seleccionado'))
      <div class="modal fade show" id="rolModal" tabindex="-1" aria-labelledby="rolModalLabel" aria-hidden="true" style="display: block; background: rgba(0,0,0,0.5);">
          <div class="modal-dialog modal-dialog-centered" style="margin-top: -5vh;">   
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header" style="background-color:rgb(0, 56, 36); border-color: rgb(0, 56, 36); color: white;">
                      <h5 class="modal-title" id="rolModalLabel">Selecciona un rol</h5>
                  </div>
                  <div class="modal-body">
                      <form id="rolForm" action="{{ route('seleccionar_rol') }}" method="POST">
                          @csrf
                          @php
                              $roles = session('roles_disponibles', []);
                          @endphp
                          <select class="col-md-12" name="rol" id="rol" required>
                            @foreach($roles as $id => $nombre)
                                <option value="{{ $id }}">{{ $nombre }}</option>
                            @endforeach
                          </select>
                          <button type="submit" class="btn btn-success mt-3">Confirmar</button>
                      </form>
                  </div>
                </div>
              </div>
          </div>
      </div> 
    @endif
    <br>
    <br>
    <br>
    <div class="form-group row">
      <!-- Carousel -->
        <div class="col-md-6">
          <div class="container" >

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
                <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                </ol>
              <!-- Indicators -->

              <!-- Wrapper for slides -->
                <div class="carousel-inner" style="border: double #083f1485; border-style:inset;">
                  <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('img/slide_img1.jpg') }}" alt="First slide" style="height: 29.595rem;">
                    <div class="carousel-caption">
                      <h2 class="animated zoomIn" style="animation-delay: 1s; background-color: #0009;">Guatavita - Cundinamarca</h2>
                      <h3 class="animated zoomIn" style="animation-delay: 2s; background-color: #0009;">FAMARENA | Salida de Campo</h3>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('img/slide_img2.jpg') }}" alt="Second slide" style="height: 29.595rem;">
                    <div class="carousel-caption">
                      <h2 class="animated zoomIn" style="animation-delay: 1s;background-color: #0009;">Mariposario - Quindio</h2>
                      <h3 class="animated zoomIn" style="animation-delay: 2s;background-color: #0009;">FAMARENA | Salida de Campo</h3>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('img/slide_img3.jpg') }}" alt="Third slide" style="height: 29.595rem;">
                    <div class="carousel-caption">
                      {{-- <h2 class="animated zoomIn" style="animation-delay: 1s;background-color: #0009;">Universidad Distrital Francisco José de Caldas</h2> --}}
                      <h3 class="animated zoomIn" style="animation-delay: 2s;background-color: #0009;">FAMARENA | Salida de Campo</h3>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('img/slide_img4.jpg') }}" alt="Third slide" style="height: 29.595rem;">
                    <div class="carousel-caption">
                      {{-- <h2 class="animated zoomIn" style="animation-delay: 1s;background-color: #0009;">Universidad Distrital Francisco José de Caldas</h2> --}}
                      <h3 class="animated zoomIn" style="animation-delay: 2s;background-color: #0009;">FAMARENA | Salida de Campo</h3>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('img/famarena.jpg') }}" alt="Third slide" style="height: 29.595rem;">
                    <div class="carousel-caption">
                      {{-- <h2 class="animated zoomIn" style="animation-delay: 1s;background-color: #0009;">Universidad Distrital Francisco José de Caldas</h2> --}}
                      <h3 class="animated zoomIn" style="animation-delay: 2s;background-color: #0009;">FAMARENA | Sede Vivero</h3>
                    </div>
                  </div>

                </div>
              <!-- Wrapper for slides -->
                
              <!-- Controls -->
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              <!-- Controls -->
            
            </div>

          </div>
        </div>
      <!-- Carousel -->

      <!-- columnas contenido -->
        <div class="col-md-6">
          <div class="container">
            <div class="form-group row" style="border: #083f1485 double; border-style:inset;margin: 0 0 1rem 0;flex: auto;background-color: #ffffffdb; height:30rem;overflow:auto;">
              {{-- <div class="col-md-12" style="height: 0.1rem;"> --}}
                <div class="card-header col-md-12" style="border-radius: 0rem; background-color:#083f1463;">
                <h4 style="text-align: center; margin-top:1.5rem">Información de Interés</h4>
              </div>
              {{-- </div> --}}
              <div class="col-md-12" style="padding: 1.75rem;">
                {{-- <h5 style="text-align: justify; margin-top:0.5rem">Proyecciones Prácticas Académicas 2022 Períodos I y III</h5>
                <p style="text-align: justify; margin-top:0.5rem;">En el plan de prácticas del año 2022 se tendrán en cuenta 
                  para los períodos académicos 2022-I y 2022-III las proyecciones de prácticas académicas de campo 
                  registradas en el sistema web PracticampoUD y que cuenten con el respectivo Visto Bueno de la coordinación
                  con fecha límite del 16 de Diciembre del 2021.</p>                
                  <hr class="divider"> --}}
                <h5 style="text-align: justify; margin-top:0.5rem">Cierre Módulos</h5>
                <p style="text-align: justify; margin-top:0.5rem;">Los módulos de proyecciones preliminares y solicitudes de prácticas serán inhabilitados en las siguientes fechas:</p>
                <p style="text-align: justify; margin-top:0.5rem; font-weight:bolder; padding-left:1rem"><b>- Proyección Preliminar:</b> {{$control_sistema->fecha_cierre_proy}}.<br>
                <strong>- Solicitud Práctica:</strong> {{$control_sistema->fecha_cierre_solic}}.</p>
                <hr class="divider">
                <h5 style="text-align: justify; margin-top:0.5rem; padding-top:0.938rem">Legalización Avances</h5>
                <p style="text-align: justify; margin-top:0.5rem; font-weight:bolder">Para realizar el proceso de legalización de avances puede ingresar a: 
                  <a href="http://planeacion.udistrital.edu.co:8080/sigud/pa/grf" target="_blank">http://planeacion.udistrital.edu.co:8080/sigud/pa/grf</a>
                  donde encontrará el instructivo  para  la  legalización  de  la ejecución de gastos del presupuesto de la Universidad Distrital autorizados a través de avances.  
                </p>
                <hr class="divider">
                <h5 style="text-align: justify; margin-top:0.5rem; padding-top:0.938rem">Resolución 090</h5>
                <p style="text-align: justify; margin-top:0.5rem; font-weight:bolder">Estimado usuario, es importante consultar la resolución 090 por medio de la cual se reglamentan los procedimientos
                  académicos y administrativos para el desarrollo de las prácticas académicas en los programas de pregrado de la Universidad Distrital Francisco José de Caldas, puede hacerlo al ingresar a: 
                  <a href="https://sgral.udistrital.edu.co/xdata/ca/res_2018-090.pdf" target="_blank">https://sgral.udistrital.edu.co/xdata/ca/res_2018-090.pdf</a>
                  o descargar la resolución desde el módulo de documentos.  
                </p>
              </div>
            </div>
          </div>
        </div>
      <!-- columnas contenido -->
    
    </div>

  @endsection
  </div>
@endif