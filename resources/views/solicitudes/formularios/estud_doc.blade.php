@extends ('layouts.app')
@section ('contenido') 

<div class="container-fluid">
    <div class="row">
      <div class="col-md-5"></div>
      <div class="card-header">{{ __('Listado de Estudiantes') }}</div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <table class="table table-bordered table-condensed table-hover table-sm header_table" cellspacing="0">
            <thead>
                <th style="width: 70px">Nombre completo</th>
                <th style="width: 70px">Email</th>
                <th style="width: 35px">Celular</th>
                <th style="width: 35px">EPS</th> 
                <th style="width: 35px">Seg. Estd.</th>
                <th style="width: 35px">Doc. Ident.</th>
                <th style="width: 35px">Vac. Fiebre A.</th>
                <th style="width: 35px">Vac. Tetanos.</th>
                <th style="width: 35px"></th>
            </thead> 
            @foreach ($estudiantes_practica as $item) 
                <tr>
                    <td>{{ $item['nombre_completo'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['celular'] }}</td>
                    <td>{{ $item['cert_eps'] }}</td>
                    <td>{{ $item['doc_ident'] }}</td>
                    <td>{{ $item['seg_est'] }}</td>
                    <td>{{ $item['vac_fiebre_a'] }}</td>
                    <td>{{ $item['vac_tet'] }}</td>
                    <td> 
                        {{-- <a href="{{route('dwn_doc_estud',[Crypt::encrypt($item['id_solicitud_practica'])])}}">
                            <button class="btn-success" ><i class="fas fa-download"></i>   PDF</button>
                        </a> --}}
                        <a href="{{route('dwn_doc_estud',[Crypt::encrypt($item['id_solicitud_practica']),Crypt::encrypt($item['email'])])}}">
                            <button class="btn-success" >VER</button>
                        </a>
                    </td> 
                
                </tr>
            @endforeach 

        </table>

        <br>
        </div>
@endsection