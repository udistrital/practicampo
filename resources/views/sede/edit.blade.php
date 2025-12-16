<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')
<div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Crear una nueva sede') }}</div>  
                    <div class="card-body">
                        <form id="formCrearSede" method="POST" action="{{ route('create_sede') }}" onsubmit="return confirmarGuardar(event)">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-4">
                                <label for="sede" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Sede</label>
                                    <input id="sede" type="text" class="form-control col-md-12"
                                    name="sede" autocomplete="off" autofocus title="" required>
                                </div> 
                                <div class="col-md-6">
                                <label for="direccion" class="col-form-label text-md-left" title=""><i class="" 
                                    data-toggle="tooltip" data-placement="left" 
                                    data-title="" style="font-size: 0.813rem"></i>Dirección</label>
                                    <input id="direccion" type="text" class="form-control col-md-8"
                                    name="direccion" autocomplete="off" autofocus title="" required>
                                </div>                    
                            </div>
                            <button id="btnCrearSede" type="submit" class="btn btn-success"> {{ __('Crear') }} </button>
                        </form>
                    </div> 
                </div>
                <br>
                <div class="card">
                    <div class="card-header"><h4>{{ __('Sedes') }}</h4></div>    
                    <div class="card-body">
                        <br>
                        <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table">
                            <thead>
                                <th style="width: 35px">ID</th>
                                <th style="width: 35px">Sede</th>
                                <th style="width: 70px">Dirección</th>
                                <th style="width: 50px">Acciones</th>
                            </thead>

                            @foreach ($sedes as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->sede }}</td>
                                <td>{{ $item->direccion }}</td>
                                <td style="text-align: center">
                                    <button 
                                        class="btn btn-success btnEditarSede" 
                                        style="background-color: #447161; border:0"
                                        data-id="{{ $item->id }}"
                                        data-sede="{{ $item->sede }}"
                                        data-direccion="{{ $item->direccion }}"
                                        data-toggle="modal"
                                        data-target="#editModal">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                            <br><br><br><br><br><br><br>
                            <div class="modal-dialog mt-5" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        
                                        <h5 class="modal-title">Editar Sede</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form id="formEditarSede" method="POST" onsubmit="return confirmarGuardar(event)">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Sede</label>
                                                <input type="text" id="sede_edit" name="sede" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Dirección</label>
                                                <input type="text" id="direccion_edit" name="direccion" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btnGuardarSede" type="submit" class="btn btn-success" name="btnGuardarSede">
                                            {{ __('Guardar') }}
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->             
                    </div>
                </div>
            </div>
        </div>
    @endsection   
