<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')
<div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Presupuesto transporte menor') }}</h4></div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('presupuesto_update_tm') }}" onsubmit="return confirmarGuardar(event)">
                            @method('PUT')
                            @csrf

                            <br>                            
                            <div class="card border-secondary">
                                <div class="form-group row ml-1">
                                    <div class="col-md-8">
                                    <label for="presupuesto_inicial_transporte_menor" class="col-form-label text-md-left col-md-12" title=""><i class="" 
                                        data-toggle="tooltip" data-placement="left" 
                                        data-title="" style="font-size: 0.813rem"></i>Presupuesto dado al transporte menor</label>
                                        <input id="presupuesto_inicial_transporte_menor" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-12"
                                        name="presupuesto_inicial_transporte_menor" 
                                        value="$ {{number_format($presupuesto_transporte_menor->presupuesto_inicial,'0',',','.')}}" autocomplete="off" autofocus title="" disabled>
                                    </div> 
                                    <div class="col-md-4">
                                    <label for="presupuesto_restante_transporte_menor" class="col-form-label text-md-left col-md-12" title=""><i class="" 
                                        data-toggle="tooltip" data-placement="left" 
                                        data-title="" style="font-size: 0.813rem"></i> Presupuesto restante</label>
                                        <input id="presupuesto_restante_transporte_menor" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-8"
                                        name="presupuesto_restante_transporte_menor" 
                                        value="$ {{number_format($presupuesto_transporte_menor->presupuesto_restante,'0',',','.')}}" autocomplete="off" autofocus title="" disabled>

                                        @error('vlr_docen_min')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>                                 
                                </div>  
                                <div class="form-group row ml-1">
                                    <div class="col-md-8">
                                    <label for="presupuesto_transporte_menor" class="col-form-label text-md-left col-md-12" title=""><i class="" 
                                        data-toggle="tooltip" data-placement="left" 
                                        data-title="" style="font-size: 0.813rem"></i> Asignar Nuevo Presupuesto al transporte menor</label>
                                        <input id="presupuesto_transporte_menor" type="text" class="form-control @error('vlr_docen_min') is-invalid @enderror col-md-12"
                                        name="presupuesto_transporte_menor" 
                                        value="0" autocomplete="off" autofocus title="" onchange="formatVlr(this)" oninput="checkEmptyInput(this)"
                                        onfocus="clearDefaultValue(this)" onblur="restoreDefaultValue(this)" >
                                    </div>                               
                                </div>
                            </div>  
                            <hr class="divider">
                            <!-- 5 -->

                            

                            <!-- submit -->
                                <!-- 8 -->
                                <div class="form-group row mb-0">
                                    <div class="col-md-5 offset-md-5">
                                        <br>
                                        <button id="btnGuardarPresupuestoTM" type="submit" class="btn btn-success" name="submit">
                                            {{ __('Actualizar') }}
                                        </button>
                                    </div>
                                </div>
                                <!-- 8 -->
                            <!-- submit -->
                        </form>                        
                    </div>
                </div>
            </div>
        </div>

    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Presupuesto Programas Académicos') }}</h4></div>    
                    <div class="card-body">
                        <br>
                        <table id="myTable" class="table table-bordered table-condensed table-hover table-sm header_table">
                            <thead>
                                <th style="width: 10px">ID Pres.</th>
                                <th style="width: 70px">Programa Académico</th>
                                <th style="width: 70px">Presupuesto Inicial</th>                                
                                <th style="width: 70px">Presupuesto Restante</th>
                                <th style="width: 100px">Acciones</th>
                            </thead>

                            @foreach ($presupuesto_programa_academico as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->programa_academico }}</td>
                                <td>{{ number_format($item->presupuesto_inicial,0,',','.') }}</td>
                                <td>{{ number_format($item->presupuesto_actual,0,',','.') }}</td>
                                <td style="text-align: center">
                                    <button 
                                        class="btn btn-success btnSumarPresupuestoProgramaAcademico" 
                                        style="background-color: #447161; border:0"
                                        data-id="{{ $item->id }}"
                                        data-id_programa_academico="{{ $item->id_programa_academico }}"
                                        data-programa_academico="{{ $item->programa_academico }}"
                                        data-presupuesto_inicial="{{ $item->presupuesto_inicial }}"
                                        data-presupuesto_actual="{{ $item->presupuesto_actual }}"                                     
                                        data-toggle="modal"
                                        data-target="#sumarModal">
                                        Sumar
                                    </button>
                                    <button 
                                        class="btn btn-success btnActualizarPresupuestoProgramaAcademico" 
                                        style="background-color: #447161; border:0"
                                        data-id="{{ $item->id }}"
                                        data-id_programa_academico="{{ $item->id_programa_academico }}"
                                        data-programa_academico="{{ $item->programa_academico }}"
                                        data-presupuesto_inicial="{{ $item->presupuesto_inicial }}"
                                        data-presupuesto_actual="{{ $item->presupuesto_actual }}"                                         
                                        data-toggle="modal"
                                        data-target="#actualizarModal">
                                        Actualizar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        <!-- Modal -->
                        <div class="modal fade" id="sumarModal" tabindex="-1" role="dialog">
                            <br><br><br><br><br><br><br>
                            <div class="modal-dialog mt-5" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">  
                                        <div class="w-100">
                                            <h5 class="modal-title mb-0">Sumar Presupuesto Programa Académico</h5>
                                            <p class="modal-title mt-0">(formulario para sumar más presupuesto al presupuesto actual)</p>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form id="formSumarPresupuestoProgramaAcademico" method="POST" onsubmit="return confirmarGuardar(event)">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label>Cod. P.A.</label>
                                                    <input type="number" id="id_programa_academico_sum" name="id_programa_academico" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-9">
                                                    <label>Programa Académico</label>
                                                    <input type="text" id="programa_academico_sum" name="programa_academico" class="form-control" readonly>
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Presupuesto inicial</label>
                                                    <input type="text" id="presupuesto_inicial_sum" name="presupuesto_inicial" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Presupuesto restante</label>
                                                    <input type="text" id="presupuesto_actual_sum" name="presupuesto_actual" class="form-control" disabled>
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Ingresar presupuesto a sumar</label>
                                                    <input type="text" id="sumar_presupuesto_programa_academico" name="sumar_presupuesto_programa_academico"
                                                        class="form-control" value="0" autocomplete="off" autofocus title="" onchange="formatVlr(this)"
                                                        oninput="checkEmptyInput(this)" onfocus="clearDefaultValue(this)" onblur="restoreDefaultValue(this)" required>
                                                </div>                                              
                                            </div>
                                            <hr class="divider">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <h5>Previsualización Nuevo Presupuesto</h5>
                                                </div>
                                                    <div class="col-md-6">
                                                    <label>Presupuesto inicial</label>
                                                    <input type="text" id="prev_nuevo_presupuesto_inicial" name="prev_nuevo_presupuesto_inicial" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Presupuesto restante</label>
                                                    <input type="text" id="prev_nuevo_presupuesto_actual" name="prev_nuevo_presupuesto_actual" class="form-control" disabled>
                                                </div>                                                                                            
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btnSumarPresupuestoProgramaAcademico" type="submit" class="btn btn-success" name="btnSumarPresupuestoProgramaAcademico">
                                            {{ __('Guardar') }}
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->

                        <!-- Modal -->
                        <div class="modal fade" id="actualizarModal" tabindex="-1" role="dialog">
                            <br><br><br><br><br><br><br>
                            <div class="modal-dialog mt-5" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">  
                                        <div class="w-100">
                                            <h5 class="modal-title mb-0">Actualizar Presupuesto Programa Académico</h5>
                                            <p class="modal-title mt-0">(formulario para reemplazar el presupuesto por uno nuevo )</p>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form id="formActualizarPresupuestoProgramaAcademico" method="POST" onsubmit="return confirmarGuardar(event)">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label>Cod. P.A.</label>
                                                    <input type="number" id="id_programa_academico" name="id_programa_academico" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-9">
                                                    <label>Programa Académico</label>
                                                    <input type="text" id="programa_academico" name="programa_academico" class="form-control" readonly>
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Presupuesto inicial</label>
                                                    <input type="text" id="presupuesto_inicial" name="presupuesto_inicial" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Presupuesto restante</label>
                                                    <input type="text" id="presupuesto_actual" name="presupuesto_actual" class="form-control" disabled>
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Asignar nuevo presupuesto</label>
                                                    <input type="text" id="nuevo_presupuesto_programa_academico" name="nuevo_presupuesto_programa_academico"
                                                        class="form-control" value="0" autocomplete="off" autofocus title="" onchange="formatVlr(this)"
                                                        oninput="checkEmptyInput(this)" onfocus="clearDefaultValue(this)" onblur="restoreDefaultValue(this)" required>
                                                </div>                                              
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btnActualizarPresupuestoProgramaAcademico" type="submit" class="btn btn-success" name="btnActualizarPresupuestoProgramaAcademico">
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
