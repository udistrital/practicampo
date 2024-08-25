@extends ('layouts.app')
@section ('contenido')  

  
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5"></div>
      <div class="card-header">{{ __('Listado de Documentos') }}</div>
    </div>
      <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
              <div class="form-group">
              </div>
            </div>
            
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            </div>
      </div>

      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

          <table class="table table-bordered table-condensed table-hover table-sm" cellspacing="0" style="table-layout: fixed; width:100%; word-break: break-word; font-size: 12px">
           
           <thead>
            <th style="width: 33px">Cod.</th>
            <th style="width: 90px">Tipo Documento</th>
            <th style="width: 95px">Abrev.</th>
            <th style="width: 37px">Acción</th>
           </thead> 
           @foreach ($documentos_sistema as $item) 
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->tipo_documentacion }}</td>
                <td>{{ $item->abrev }}</td>
                @if(Auth::user()->asistenteD() || Auth::user()->admin())
                  @if($item->editable == 1)
                  <td> 
                      <a href="{{route('doc_edit',Crypt::encrypt($item->id))}}">
                        <button class="btn-success" style="background-color: #447161; border:0">Editar</button>
                      </a>
                  </td> 
                  @endif
                @endif
                @if($item->editable == 1 && Auth::user()->decano())
                  <td>Editable</td>
                @endif
                @if($item->editable == 0)
                  <td>No Editable</td>
                @endif
              </tr>
            @endforeach
          </table>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        </div>

      </div>

@endsection