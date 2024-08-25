@include('layouts.partials.htmlhead')

<div id="content" style="position: relative;background-color: #ebf4ef; background-image: url('img/descarga.png');background-repeat: no-repeat; background-size: 100% 100%;">

    <div class="container" >
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Documentación Estudiante') }}</div>
                        <div class="card-body">

                            <div class="row">
                                <label for="nombre_completo" class="col-md-6 col-form-label text-md-center">{{$rec_doc->nombre_completo}}</label>
                            </div>
                            {{-- <div class="row">
                                <label for="seguro_estudiantil" class="col-md-6 col-form-label text-md-center">Seguro Estudiantil</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img1}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;">
                                <embed src="{{$imagen1}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}

                                <embed src="{{$pdf1}}" width=100% height=600>
                            </div>

                            <br>
                            {{-- <div class="row">
                                <label for="documento_adicional_1" class="col-md-3 col-form-label text-md-left">Documento Adicional 1</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img2}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                                <embed src="{{$pdf2}}" width=100% height=600>
                            </div>

                            <br>
                            {{-- <div class="row">
                                <label for="documento_adicional_3" class="col-md-3 col-form-label text-md-left">Documento Adicional 3</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img4}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                                <embed src="{{$pdf4}}" width=100% height=600>
                            </div>

                            <br>
                            {{-- <div class="row">
                                <label for="documento_adicional_4" class="col-md-3 col-form-label text-md-left">Documento Adicional 4</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img5}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                                <embed src="{{$pdf5}}" width=100% height=600>
                            </div>

                            <br>
                            {{-- <div class="row">
                                <label for="documento_adicional_5" class="col-md-3 col-form-label text-md-left">Documento Adicional 5</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img6}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                                <embed src="{{$pdf6}}" width=100% height=600>
                            </div>

                            <br>
                            {{-- <div class="row">
                                <label for="documento_adicional_6" class="col-md-3 col-form-label text-md-left">Documento Adicional 6</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img7}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                                <embed src="{{$pdf7}}" width=100% height=600>
                            </div>

                            <br>
                            {{-- <div class="row">
                                <label for="documento_adicional_6" class="col-md-3 col-form-label text-md-left">Documento Adicional 6</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img9}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                                <embed src="{{$pdf9}}" width=100% height=600>
                            </div>

                            <br>
                            {{-- <div class="row">
                                <label for="documento_adicional_6" class="col-md-3 col-form-label text-md-left">Documento Adicional 6</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img10}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                                <embed src="{{$pdf10}}" width=100% height=600>
                            </div>

                            <br>
                            {{-- <div class="row">
                                <label for="documento_adicional_6" class="col-md-3 col-form-label text-md-left">Documento Adicional 6</label>
                            </div> --}}
                            <div class="row">
                                {{-- <img src="{{$img11}}" alt="" style="width: 70%;align-content: center;display: block;margin: auto;"> --}}
                                <embed src="{{$pdf11}}" width=100% height=600>
                            </div>
                            
                            <br>
                            <div class="form-group">
                                <a href="{{route('doc_est_ind',[Crypt::encrypt($rec_doc->email)])}}" class="btn btn-success">
                                    Inicio
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br><br><br>
</div>

</div>

<!-- footer -->
@include('layouts.partials.footerLogout')

@include('layouts.partials.scripts')


