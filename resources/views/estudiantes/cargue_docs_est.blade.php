@include('layouts.partials.htmlhead')
{{-- @include('layouts.partials.header1') --}}

<div id="content" style="position: relative;background-color: #ebf4ef; background-image: url('/img/descarga.png');background-repeat: no-repeat; background-size: 100% 100%;">
    
    <div class="container">
        <div>
        <!-- HEADER -->
            <div  class="row">
                @include('layouts.partials.headerEst')
            </div>
        </div>
            <!-- end HEADER -->
        <br><br>
        <div>
            <div class="row justify-content-center">
                {{-- <div class="col-md-8">
                    <div class="card"> --}}
                        <div class="col-md-12 card-header">{{ __('Documentación Estudiante') }}</div>
                        <div class="col-md-12 card-body" style="background-color: #f8f9fc">
                            <form method="POST" action="{{ route('update_datos_basicos',[Crypt::encrypt($estudiante->email),Crypt::encrypt($estudiante->id_solicitud_practica)]) }}"  enctype="multipart/form-data">
                                @csrf    
                                <div class="form-group row" style="border: #e3e6f0 double;margin: 0 0 1rem 0;flex: auto;background-color: #fff;">
                                    <div class="col-md-12" >
                                        <h4 style="text-align: center; margin-top:0.5rem">Tratamiento Datos Personales</h4>
                                    </div>

                                    <div class="col-md-12" >
                                        <p style="text-align: justify; margin-top:0.5rem">Las personas que entregan sus datos a la Universidad Distrital, 
                                            consienten y autorizan de manera expresa e inequívoca que sus datos personales sean tratados y administrados, 
                                            conforme a lo previsto en el documento Resolución 432 de 2016 el cual contiene la Política de Tratamiento de Datos 
                                            Personales <a href="https://sgral.udistrital.edu.co/xdata/rec/res_2016-432.pdf" target="_blank">(https://sgral.udistrital.edu.co/xdata/rec/res_2016-432.pdf)</a>
                                            y la Resolución 711 de 2008 
                                            <a href="https://sgral.udistrital.edu.co/xdata/rec/res_2008-711.pdf" target="_blank">(https://sgral.udistrital.edu.co/xdata/rec/res_2008-711.pdf)</a>
                                            sobre la reglamentación del uso de los servicios de 
                                            publicación en internet y correo electrónico que se prestan en la Universidad.  
                                        </p>
                                        <p style="text-align: justify; margin-top:0.5rem"><strong>Canal de Habeas Data:</strong> La unidad administrativa responsable de velar 
                                            por el cumplimiento de esta política al interior de la Universidad es la Secretaría General 
                                            <a href="mailto:correosgral@udistrital.edu.co">correosgral@udistrital.edu.co</a>, que estará disponible para la atención de consultas y reclamos, por parte de Los 
                                            Titulares de la información, así como para realizar cualquier actualización, rectificación y supresión de datos 
                                            personales. Asimismo, allí se absolverá cualquier duda o inquietud.</p>
                                        <p style="text-align: justify; margin-top:0.5rem"> Asimismo,  usted reconoce que la información y los datos personales recogidos son veraces, exactos, vigentes y autenticos.
                                            </p>
                                    </div>
                                    <label class="ml-2 mr-1 mt-2" for="aprob_terminos_condiciones">Aprobar términos y condiciones</label>
                                    <span class="hs-form-required mr-1 mt-2">*</span>
                                    <input type="checkbox" id="aprob_terminos_condiciones" name="aprob_terminos_condiciones" value="1" required
                                        <?php if(isset($estudiante) && $estudiante->aprob_terminos_condiciones == 1) echo 'checked' ?>
                                        <?php if(isset($estudiante) && $estudiante->aprob_terminos_condiciones == 1) echo 'disabled' ?>>
                                </div>

                                <div class="form-group row">
                                    
                                    <!-- datos a completar -->
                                        <div class="col-md-3">
                                            <label for="id_tipo_identificacion" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el tipo de identificación" style="font-size: 0.813rem"></i> {{ __('Tipo Identificación') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <select name="id_tipo_identificacion" class="form-control" required>
                                                @foreach($tipos_identificaciones as $tip_ident)
                                                    <option value="{{$tip_ident->id}}"
                                                    <?php if(isset($estudiante) && $tip_ident->id == $estudiante->id_tipo_identificacion) echo 'selected' ?>>{{$tip_ident->tipo_identificacion}}</option>  
                                                @endforeach
                                            </select>
                                            @error('id_tipo_identificacion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="num_identificacion" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique el número de identificación" style="font-size: 0.813rem"></i> {{ __('N° Identificación') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="num_identificacion"  class="form-control @error('num_identificacion') is-invalid @enderror" name="num_identificacion" value="{{ $estudiante->num_identificacion }}"
                                            onkeyup="onlyNmb(this)" onchange="onlyNmb(this)" 
                                            required autocomplete="off" autofocus>

                                            @error('num_identificacion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label for="fecha_nacimiento" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione la fecha de nacimiento" style="font-size: 0.813rem"></i> {{ __('F. Nacimiento') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                            <input class="inputDate form-control datetimepicker" id="fecha_nacimiento" name="fecha_nacimiento" type="text" required
                                            onchange="mayorEdad()" value="{{ $estudiante->fecha_nacimiento }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="celular" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique un número de celular" style="font-size: 0.813rem"></i> {{ __('Celular') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="celular" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ $estudiante->celular }}"
                                            onkeyup="onlyNmb(this)" onchange="onlyNmb(this)"
                                            required autocomplete="off">
                                            
                                            @error('celular')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="eps" class="col-form-label text-md-right">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Indique la EPS a la que pertenece" style="font-size: 0.813rem"></i> {{ __('EPS') }}</label>
                                            <span class="hs-form-required">*</span>
                                            <input id="eps" class="form-control @error('eps') is-invalid @enderror" name="eps" value="{{ $estudiante->eps }}" required autocomplete="off">
                                            
                                            @error('eps')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    <!-- datos a completar -->
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success" name="update_datos_basicos" title="">Guardar Datos Básicos</button></a>
                                </div>
                            </form>
                            @if($estudiante->num_identificacion && $estudiante->aprob_terminos_condiciones == 1)
                            <form method="POST" action="{{ route('import_doc_estudiante.img',[Crypt::encrypt($estudiante->email),Crypt::encrypt($estudiante->id_solicitud_practica)]) }}"  enctype="multipart/form-data">
                                @csrf
                                <hr class="divider">  
                                <div class="mt-1 mb-2">
                                    <p class="text-danger">Importante: Todos los archivos deben ser subidos en formato PDF y pesar menos de 200 KB (se recomienda comprimir los archivos antes de subirlos).</p>
                                </div>  
                                <hr class="divider"> 
                                <div class="mt-1 mb-2">
                                    <a id="declaracion_responsabilidad_est" name="declaracion_responsabilidad_est"
                                    href="{{ route('declaracion_resp_estudiante.pdf', [Crypt::encrypt($estudiante->email), Crypt::encrypt($estudiante->id_solicitud_practica)]) }}">
                                    <button id="btn_declaracion_responsabilidad_est" name="btn_declaracion_responsabilidad_est" class="btn-success"
                                            type="button" style="background-color: #447161; border:0"><i class="fas fa-download"></i>Descargar Formato Declaración Responsabilidad</button>
                                    </a>
                                </div> 
                                
                                <hr class="divider">      
                                @error('declaracion_responsabilidad')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror                       
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="declaracion_responsabilidad" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Descargue el formato declaración de responsabilidad. firmelo y subalo" style="font-size: 0.813rem"></i>
                                            Formato Declaración de Responsabilidad</label>
                                        <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['declaracion_responsabilidad']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_declaracion_responsabilidad" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['declaracion_responsabilidad']))
                                            <div id="pdf_declaracion_responsabilidad" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['declaracion_responsabilidad']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="declaracion_responsabilidad" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['declaracion_responsabilidad']) ? 'required' : '' }}>
                                        @if(!empty($documentos['declaracion_responsabilidad']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>

                                @error('seguro_estudiantil')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror  
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="seguro_estudiantil" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle"
                                            data-toggle="tooltip"
                                            data-placement="left"
                                            data-title="Busque en su computador el certificado requerido para la salida de campo"
                                            style="font-size: 0.813rem"></i>
                                            Seguro Estudiantil
                                        </label>
                                        <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['seguro_estudiantil']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_seguro_estudiantil" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['seguro_estudiantil']))
                                            <div id="pdf_seguro_estudiantil" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['seguro_estudiantil']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="seguro_estudiantil" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['seguro_estudiantil']) ? 'required' : '' }}>
                                        @if(!empty($documentos['seguro_estudiantil']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>

                                @error('documento_identificacion')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror  
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="documento_identificacion" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle"
                                            data-toggle="tooltip"
                                            data-placement="left"
                                            data-title="Busque en su computador el certificado requerido para la salida de campo"
                                            style="font-size: 0.813rem"></i>
                                            Documento Identificación
                                        </label>
                                        <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['documento_identificacion']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_documento_identificacion" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['documento_identificacion']))
                                            <div id="pdf_documento_identificacion" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['documento_identificacion']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="documento_identificacion" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['documento_identificacion']) ? 'required' : '' }}>
                                        @if(!empty($documentos['documento_identificacion']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>

                                @error('certificado_eps')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror 
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="certificado_eps" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Busque en su computador el certificado requerido para la 
                                            salida de campo" style="font-size: 0.813rem"></i> Cert. EPS (FOSYGA o equivalente)</label>
                                        <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['certificado_eps']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_certificado_eps" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['certificado_eps']))
                                            <div id="pdf_certificado_eps" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['certificado_eps']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="certificado_eps" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['certificado_eps']) ? 'required' : '' }}>
                                        @if(!empty($documentos['certificado_eps']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>

                                @error('permiso_acudiente')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror 
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="permiso_acudiente" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Busque en su computador el certificado requerido para la 
                                            salida de campo" style="font-size: 0.813rem"></i> Permiso Acudiente</label>
                                        @if(!empty($documentos['permiso_acudiente']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_permiso_acudiente" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['permiso_acudiente']))
                                            <div id="pdf_permiso_acudiente" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['permiso_acudiente']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="permiso_acudiente" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['permiso_acudiente']) ? '' : '' }}>
                                        @if(!empty($documentos['permiso_acudiente']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>

                                @if($doc_req_solicitud->vacuna_fiebre_amarilla == 1)
                                @error('vacuna_fiebre_amarilla')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror 
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="vacuna_fiebre_amarilla" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Busque en su computador el certificado requerido para la 
                                            salida de práctica académica" style="font-size: 0.813rem"></i> Vacuna Fiebre Amarilla</label>
                                        <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['vacuna_fiebre_amarilla']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_vacuna_fiebre_amarilla" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['vacuna_fiebre_amarilla']))
                                            <div id="pdf_vacuna_fiebre_amarilla" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['vacuna_fiebre_amarilla']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="vacuna_fiebre_amarilla" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['vacuna_fiebre_amarilla']) ? 'required' : '' }}>
                                        @if(!empty($documentos['vacuna_fiebre_amarilla']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($doc_req_solicitud->vacuna_tetanos == 1)
                                @error('vacuna_tetanos')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror 
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="vacuna_tetanos" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Busque en su computador el certificado requerido para la 
                                            salida de práctica académica" style="font-size: 0.813rem"></i> Vacuna Tetanos (Min. 2 Dósis)</label>
                                        <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['vacuna_tetanos']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_vacuna_tetanos" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['vacuna_tetanos']))
                                            <div id="pdf_vacuna_tetanos" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['vacuna_tetanos']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="vacuna_tetanos" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['vacuna_tetanos']) ? 'required' : '' }}>
                                        @if(!empty($documentos['vacuna_tetanos']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($doc_req_solicitud->certificado_adicional_1 == 1)
                                @error('certificado_adicional_1')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror 
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="certificado_adicional_1" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Busque en su computador el certificado requerido para la 
                                            salida de práctica académica" style="font-size: 0.813rem"></i> Certificado Adicional 1</label>
                                        <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['certificado_adicional_1']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_certificado_adicional_1" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['certificado_adicional_1']))
                                            <div id="pdf_certificado_adicional_1" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['certificado_adicional_1']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="certificado_adicional_1" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['certificado_adicional_1']) ? 'required' : '' }}>
                                        @if(!empty($documentos['certificado_adicional_1']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($doc_req_solicitud->certificado_adicional_1 == 1)
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="detalle_certificado_adicional_1" class="col-form-label text-md-left">Detalle Certificado Adicional 1</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text"  name="detalle_certificado_adicional_1"  class="form-control" value="{{$doc_req_solicitud->detalle_certificado_adcional_1}}" 
                                        readonly>
                                    </div>
                                </div>
                                @endif

                                @if($doc_req_solicitud->certificado_adicional_2 == 1)
                                @error('certificado_adicional_2')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror 
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="certificado_adicional_2" class="col-form-label text-md-left">
                                            <i class="fas fa-question-circle" 
                                            data-toggle="tooltip" data-placement="left" 
                                            data-title="Busque en su computador el certificado requerido para la salida
                                             de práctica académica" style="font-size: 0.813rem"></i> Certificado Adicional 2</label>
                                        <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['certificado_adicional_2']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_certificado_adicional_2" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['certificado_adicional_2']))
                                            <div id="pdf_certificado_adicional_2" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['certificado_adicional_2']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="certificado_adicional_2" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['certificado_adicional_2']) ? 'required' : '' }}>
                                        @if(!empty($documentos['certificado_adicional_2']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($doc_req_solicitud->certificado_adicional_2 == 1)
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="detalle_certificado_adicional_2" class="col-form-label text-md-left"> Detalle Certificado Adicional 2</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text"  name="detalle_certificado_adicional_2"  class="form-control" value="{{$doc_req_solicitud->detalle_certificado_adcional_2}}"
                                        readonly>
                                    </div>
                                </div>
                                @endif

                                @if($doc_req_solicitud->certificado_adicional_3 == 1)
                                @error('certificado_adicional_3')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror 
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label for="certificado_adicional_3" class="col-form-label text-md-left">
                                                <i class="fas fa-question-circle" 
                                                data-toggle="tooltip" data-placement="left" 
                                                data-title="Seleccione el tipo de identificación" style="font-size: 0.813rem"></i> Certificado Adicional 3</label>
                                            <span class="hs-form-required">*</span>
                                        @if(!empty($documentos['certificado_adicional_3']))
                                            <button class="btn btn-success btn-sm mr-2 btnMostrarPdf" style="background-color: #447161; border: 0"
                                                    data-target="pdf_certificado_adicional_3" type="button">
                                                <i class="far fa-eye"></i><i class="fa fa-arrow-right"></i><i class="fa fa-file"></i>
                                                Ver PDF
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($documentos['certificado_adicional_3']))
                                            <div id="pdf_certificado_adicional_3" style="display: none;">
                                                <div class="mb-3 border rounded">
                                                    <embed src="{{ $documentos['certificado_adicional_3']['pdf'] }}"
                                                        type="application/pdf" width="100%" height="400px">
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Tamaño Máximo: 200 KB</small>
                                        <input type="file" accept="application/pdf" name="certificado_adicional_3" class="form-control" style="color: rgb(243, 3, 3)"
                                            {{ empty($documentos['certificado_adicional_3']) ? 'required' : '' }}>
                                        @if(!empty($documentos['certificado_adicional_3']))
                                        <small class="text-muted">
                                            Si desea cambiar el archivo, seleccione uno nuevo.
                                        </small>
                                        @endif
                                    </div>
                                    </div>
                                @endif

                                @if($doc_req_solicitud->certificado_adicional_3 == 1)
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label for="detalle_certificado_adicional_3" class="col-form-label text-md-left">Detalle Certificado Adicional 3</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text"  name="detalle_certificado_adicional_3"  class="form-control" value="{{$doc_req_solicitud->detalle_certificado_adcional_3}}" 
                                            readonly>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <button class="btn btn-success" name="import_docs_estud" title=""><i class="fas fa-file-import"></i>     INSCRIBIRSE</button></a>
                                </div>
                        
                            </form>
                            @endif
                        </div>
                        
                    {{-- </div>
                </div> --}}
            </div>
            <br><br>
        </div>
    </div>
    <br>
    <br><br><br>
</div>
</div>
<!-- footer -->
@include('layouts.partials.footerLogout')

@include('layouts.partials.scripts')
