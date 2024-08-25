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
                        <form method="POST" action="{{ route('firma_lito_add') }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                        <!-- 1 -->
                        <div class="form-group row">
                            <label for="firma_lito" class="col-md-3 col-form-label text-md-left">Firma Litográfica</label>
                            <div class="col-md-9">
                                <input type="file"  name="firma_lito" class="form-control" style="color: rgb(243, 3, 3)">
                            </div>
                        </div>
                        <!-- 1 -->
                        

                        <!-- submit -->
                            <!-- 2 -->
                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-5">
                                    <br>
                                    <button type="submit" class="btn btn-success" name="submit">
                                        {{ __('Guardar') }}
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