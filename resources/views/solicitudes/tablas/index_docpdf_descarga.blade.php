@if($filter == 'aprob_solic')
    <form action=""  name="soli_aprob">
        {{-- {{route('solic_pend_edit')}} --}}
        @csrf
        <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
            <thead>
                <th style="width: 25px">Sel. Todo <input type="checkbox" id="sel_solic_aprob" name="sel_solic_aprob" value="" onchange="sel_solic_aprobadas()">
                </th>
                <th style="width: 35px">Cod.</th>
                <th style="width: 80px">Proy. Curricular</th>
                <th style="width: 75px">Esp. Académico</th>
                <th style="width: 40px">N° Resolución</th>
                <th style="width: 40px">N° CDP</th>
                <th style="width: 40px">N° Sol. Necesidad</th>
                <th style="width: 30px">Cordis</th>
                <th style="width: 30px">Dfamarena</th>
                <th style="width: 45px">Fecha Salida</th>
                <th style="width: 45px">Fecha Regreso</th>

            </thead>
            @foreach ($proyecciones as $item)
            <tr>
                <td style="text-align:center;"><label>
                    <input type="checkbox" id="solic_aprob_list[]" name="solic_aprob_list[]" value="{{ $item->id_solicitud }}"></label>
                </td>
                <td>{{ $item->id_solicitud }}</td>
                <td>{{ $item->programa_academico }}</td>
                <td>{{ $item->espacio_academico }}</td>
                {{-- @if($item->id_estado_doc == 1)
                    <td>{{ $item->full_name }}</td>
                @endif
                @if($item->id_estado_doc == 2)
                    <td>Usuario Inactivo</td>
                @endif --}}
                <td>{{ $item->num_resolucion }}</td>
                <td>{{ $item->num_cdp }}</td>
                <td>{{ $item->num_solicitud_necesidad }}</td>
                <td>{{ $item->consec_cordis }}</td>
                <td>{{ $item->consec_dfamarena }}</td>
                <td>{{ $item->fecha_salida_aprox_rp }}</td>
                <td>{{ $item->fecha_regreso_aprox_rp }}</td>

                {{-- <td style="text-align: center">
                    <a href="{{route('solicitud_edit',[Crypt::encrypt($item->id),Crypt::encrypt($item->tipo_ruta)])}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                    </a>
                </td>  --}}
            </tr>
            @endforeach
        </table>
    </form>

    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <table class="table table-bordered table-condensed table-hover table-sm" cellspacing="0" style="table-layout: fixed; width:100%; word-break: break-word; font-size: 12px">

                <thead>
                    <th style="width: 33px">Cod.</th>
                    <th style="width: 90px">Tipo Documento</th>
                    <th style="width: 95px">Abrev.</th>
                    <th style="width: 45px" style="text-align:center;">Descargar</th>
                    {{-- <th style="width: 37px">Importar</th> --}}
                </thead>

                @if(Auth::user()->decano() || Auth::user()->asistenteD())
                    @foreach ($documentos_sistema as $item)
                        <tr>
                            @if($item->id == 1 || $item->id == 3 || $item->id == 4 || $item->id == 2 || $item->id == 5 || $item->id == 6)
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->tipo_documentacion }}</td>
                                <td>{{ $item->abrev }}</td>

                                @if($item->id == 1)
                                <td style="text-align:center;">
                                    {{-- @if($docente_responsable->id_estado == 1) --}}
                                        {{-- <a href="{{route('giro.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}"> --}}
                                        {{-- <a id="llll" href="{{route('giro.pdf',Crypt::encrypt($proyecciones))}}"> --}}
                                        <a id="giro_pdf" name="giro_pdf" href="">
                                        <button id="btn_giro_pdf" name="btn_giro_pdf" class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>  PDF</button>
                                        </a>
                                    {{-- @else
                                        Docen. Inactivo
                                    @endif --}}
                                </td>
                                @endif

                                @if($item->id == 2)
                                <td style="text-align:center;">
                                    {{-- @if($docente_responsable->id_estado == 1) --}}
                                        {{-- <a href="{{route('oficio.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}"> --}}
                                        {{-- <a href="{{route('oficio.pdf',[Crypt::encrypt($proyecciones)])}}"> --}}
                                        <a id="oficio_pdf" name="oficio_pdf" href="">
                                        <button id="btn_oficio_pdf" name="btn_oficio_pdf" class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                        </a>
                                    {{-- @else
                                        Docen. Inactivo
                                    @endif --}}
                                </td>
                                @endif

                                @if($item->id == 3)
                                <td style="text-align:center;">
                                    {{-- @if($docente_responsable->id_estado == 1) --}}
                                        {{-- <a href="{{route('resolucion.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}"> --}}
                                        {{-- <a href="{{route('resolucion.pdf',[Crypt::encrypt($proyecciones)])}}"> --}}
                                       <a id="resolucion_pdf" name="resolucion_pdf" href="">
                                        <button id="btn_resolucion_pdf" name="btn_resolucion_pdf" class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                        </a>
                                    {{-- @else
                                        Docen. Inactivo
                                    @endif --}}
                                </td>
                                @endif

                                @if($item->id == 6)
                                <td style="text-align:center;">
                                    {{-- @if($docente_responsable->id_estado == 1) --}}
                                        {{-- <a href="{{route('transporte.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}"> --}}
                                        {{-- <a href="{{route('transporte.pdf',[Crypt::encrypt($proyecciones)])}}"> --}}
                                        <a id="transporte_pdf" name="transporte_pdf" href="">
                                        <button id="btn_transporte_pdf" name="btn_transporte_pdf" class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                        </a>
                                    {{-- @else
                                        Docen. Inactivo
                                    @endif --}}
                                </td>
                                @endif

                                @if($item->id == 4)
                                    <td style="text-align:center;">
                                        {{-- @if($docente_responsable->id_estado == 1) --}}
                                            {{-- <a href="{{route('avance.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}"> --}}
                                            {{-- <a href="{{route('avance.pdf',[Crypt::encrypt($proyecciones)])}}"> --}}
                                            <a id="avance_pdf" name="avance_pdf" href="">
                                                <button id="btn_avance_pdf" name="btn_avance_pdf" class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                            </a>
                                        {{-- @else
                                            Docen. Inactivo
                                        @endif --}}
                                    </td>
                                @endif

                                @if($item->id == 5)
                                    <td style="text-align:center;">
                                        {{-- @if($docente_responsable->id_estado == 1) --}}
                                            {{-- <a href="{{route('formatoPractica.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}}"> --}}
                                            {{-- <a href="{{route('formatoPractica.pdf',[Crypt::encrypt($proyecciones)])}}"> --}}
                                            <a id="practica_pdf" name="practica_pdf" href="">
                                                <button id="btn_practica_pdf" name="btn_practica_pdf" class="btn-success" style="background-color: #447161; border:0"><i class="fas fa-download"></i>   PDF</button>
                                            </a>
                                        {{-- @else
                                            Docen. Inactivo
                                        @endif --}}
                                    </td>
                                @endif

                                @endif


                        </tr>
                    @endforeach
                @endif

            </table>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <form method="POST" action="" id="fom_consec_dfama" name="fom_consec_dfama">
                {{-- {{ route('consec_solic',[Crypt::encrypt($solicitud->id)]) }} --}}
                @method('PUT')
                @csrf 

                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group row">
                            <div class="col-md-5" id="c_dfamarena">
                                <label for="consec_dfamarena" class="col-form-label text-md-left">
                                    <i class="fas fa-question-circle"
                                        data-toggle="tooltip" data-placement="left"
                                        data-title="Indique el consecutivo DFAMARENA"
                                        style="font-size: 0.813rem">
                                    </i> {{ __('Consecutivo DFAMARENA') }}</label>
                                <span class="hs-form-required">*</span>
                                <input id="consec_dfamarena" type="text" class="form-control @error('consec_dfamarena') is-invalid @enderror" name="consec_dfamarena"
                                value="" autocomplete="off" autofocus required onkeyup="onlyNmb(this)" onchange="onlyNmb(this)">
                                {{-- {{$solicitud->consec_dfamarena}} --}}
                                @error('consec_dfamarena')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-5" id="c_cordis">
                                <label for="consec_cordis" class="col-form-label text-md-left">
                                    <i class="fas fa-question-circle"
                                        data-toggle="tooltip" data-placement="left"
                                        data-title="Indique el consecutivo CORDIS"
                                        style="font-size: 0.813rem">
                                    </i> {{ __('Consecutivo CORDIS') }}</label>
                                <span class="hs-form-required">*</span>
                                <input id="consec_cordis" type="text" class="form-control @error('consec_cordis') is-invalid @enderror" name="consec_cordis"
                                value="" autocomplete="off" autofocus required>
                                {{-- {{$solicitud->consec_cordis}} --}}
                                @error('consec_cordis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- guardar -->

                                <div class="col-md-2" style="display: grid;align-items: end;">
                                    {{-- <br> --}}
                                    {{-- <a id="up_consec_dfama" name="up_consec_dfama" href=""> --}}
                                        {{-- {{route('giro.pdf',[Crypt::encrypt($solicitud->id_proyeccion_preliminar)])}} --}}
                                      {{-- <button class="btn-success" style="background-color: #447161; border:0">{{ __('Guardar') }}</button> --}}
                                      {{-- onclick="cons_dfama()" --}}
                                    {{-- </a> --}}
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            <!-- guardar -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        </div>
    </div>
        {{-- <button class="btn-success" style="background-color: #447161; border:0" name="edit_solic_pend" id="edit_solic_pend" disabled>
            Editar
        </button> --}}
@endif

{{$proyecciones->render()}}