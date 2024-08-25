<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')
    <br>
    <br>
    <br>
    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Firma Litográfica') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('firma_lito_del',$usuario->tiene_firma) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <!-- 1 -->
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div  class="col-md-6" style="width: 300px;height: 100px;overflow: hidden;">
                                    <img src="{{$img_firma_lito_DB}}" alt="" style="align-content: center;display: flex;margin: auto;width: 100%;height: 100%;">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <!-- 1 -->
                            
                            <!-- submit -->
                            <!-- 2 -->
                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-5">
                                    <br>
                                    <button type="submit" class="btn btn-success" name="submit">
                                        {{ __('Eliminar') }}
                                    </button>
                                </div>
                            </div>
                            <!-- 2 -->
                        <!-- submit -->
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
        
    @endsection   