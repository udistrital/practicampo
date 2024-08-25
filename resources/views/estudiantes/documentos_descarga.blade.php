<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->

@section('contenido')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Documentación Estudiante') }} {{$rec_doc->nombre_completo}}</div>
                    <div class="card-body">

                        {{-- <div class="row">
                            <label for="nombre_completo" class="col-md-6 col-form-label text-md-center">{{$rec_doc->nombre_completo}}</label>
                        </div> --}}
                        <div class="row">
                            <label for="seguro_estudiantil" class="text-md-center">Seguro Estudiantil</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img1}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;">
                            <embed src="{{$imagen1}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}

                            <embed src="{{$pdf1}}" width=100% height=600>
                        </div>

                        <br>
                        <div class="row">
                            <label for="documento_adicional_1" class="ctext-md-left">Documento Identificación</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img2}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                            <embed src="{{$pdf2}}" width=100% height=600>
                        </div>

                        <br>
                        <div class="row">
                            <label for="documento_adicional_3" class="text-md-left">Cert. EPS (FOSYGA o equivalente)</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img4}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                            <embed src="{{$pdf4}}" width=100% height=600>
                        </div>

                        <br>
                        @if($doc_req_solicitud->permiso_acudiente == 1)
                        <div class="row">
                            <label for="documento_adicional_4" class="text-md-left">Permiso Acudiente</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img5}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                            <embed src="{{$pdf5}}" width=100% height=600>
                        </div>
                        @endif
                        @if($doc_req_solicitud->vacuna_fiebre_amarilla == 1)
                        <br>
                        <div class="row">
                            <label for="documento_adicional_5" class="text-md-left">Vacuna Fiebre Amarilla</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img6}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                            <embed src="{{$pdf6}}" width=100% height=600>
                        </div>
                        @endif
                        @if($doc_req_solicitud->vacuna_tetanos == 1)
                        <br>
                        <div class="row">
                            <label for="documento_adicional_6" class="text-md-left">Vacuna Tetanos (Min. 2 Dósis)</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img7}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                            <embed src="{{$pdf7}}" width=100% height=600>
                        </div>
                        @endif
                        @if($doc_req_solicitud->certificado_adicional_1 == 1)
                        <br>
                        <div class="row">
                            <label for="documento_adicional_6" class="text-md-left">Certificado Adicional 1</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img9}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                            <embed src="{{$pdf9}}" width=100% height=600>
                        </div>
                        @endif
                        @if($doc_req_solicitud->certificado_adicional_2 == 1)
                        <br>
                        <div class="row">
                            <label for="documento_adicional_6" class="text-md-left">Certificado Adicional 2</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img10}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                            <embed src="{{$pdf10}}" width=100% height=600>
                        </div>
                        @endif
                        @if($doc_req_solicitud->certificado_adicional_3 == 1)
                        <br>
                        <div class="row">
                            <label for="documento_adicional_6" class="text-md-left">Certificado Adicional 3</label>
                        </div>
                        <div class="row">
                            {{-- <img src="{{$img11}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                            <embed src="{{$pdf11}}" width=100% height=600>
                        </div>
                        @endif
                        
                        <br>
                        <div class="form-group">
                            <a href="{{route('estud_doc',[Crypt::encrypt($rec_doc->id_solicitud_practica)])}}" class="btn btn-success">
                                Atrás
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

@endsection  