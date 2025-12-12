<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')
<div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Programaciones para duplicar') }}</h4></div>    
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table">
                            <thead>
                                <th style="width: 35px">Cod.</th>
                                <th style="width: 70px">Programa Académico</th>
                                 <th style="width: 70px">Espacio Académico</th>
                                  <th style="width: 70px">Destino Principal</th>
                                   <th style="width: 70px">Destino Contingencia</th>
                                <th style="width: 50px">Acciones</th>
                            </thead>

                            @foreach ($programaciones as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->programa_academico }}</td>
                                <td>{{ $item->espacio_academico }}</td>
                                <td>{{ $item->destino_rp }}</td>
                                 <td>{{ $item->destino_ra }}</td>
                                <td style="text-align: center">
                                    <a href="{{route('programacion_duplicar',Crypt::encrypt($item->id))}}">
                                        <button class="btn-success" style="background-color: #447161; border:0">Duplicar</button>
                                    </a> 
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection   
