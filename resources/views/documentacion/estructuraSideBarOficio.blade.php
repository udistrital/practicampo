<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    {{-- <div class="card-header">{{ __('Registro Solicitud Práctica N° ') }}<php echo $solicitud_practica->id_proyeccion_preliminar?> <php echo "\t -"?> --}}
                        {{-- <div class="card-header">{{ __('Registro Solicitud Práctica N° ') }}<php echo $solicitud_practica->id_proyeccion_preliminar?>
                        {{ __('') }}</div> --}}
                        {{-- <php if($estado_doc_respon == 1){ echo $nombre_doc_resp;} elseif ($estado_doc_respon == 2){ echo "Usuario Inactivo";}?> --}}
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('doc_update',[Crypt::encrypt($id_documento)]) }}">
                            @method('PUT')
                            @csrf

                                @include('documentacion.formatoEdicionOficio')
                            
                            <!-- 25 -->
                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-5">
                                    <br>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </div>
                            <!-- 25 -->
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
        
    @endsection  