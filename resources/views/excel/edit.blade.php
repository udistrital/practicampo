<!-- HTML HEAD -->
@extends('layouts.app')
<!-- end HTML HEAD -->


    @section('contenido')

    <div class="container">        
        <div class="card">
            <div class="card-header">{{ __('Generación de Reportes') }}</div>
            <div class="justify-content-center">
                <div class="col-md-12 justify-content-around">
                    @if(Auth::user()->admin() || Auth::user()->decano() || Auth::user()->asistenteD())  
                    <div class="form-group-row col-md-12 mt-4 mb-4 justify-content-center d-flex align-items-center" style="margin-left: -12px;">
                        <div class="card col-md-5">
                            <form action="{{ route('excel_programaciones_plan_salidas') }}" method="GET">
                                <div class="card-header">{{ __('Plan de Salidas de Campo') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <label for="fecha_inicial">Fecha Inicial:</label>
                                            <input type="date" id="fecha_inicial_plan_salidas" name="fecha_inicial" class="form-control" required>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="fecha_final">Fecha Final:</label>
                                            <input type="date" id="fecha_final_plan_salidas" name="fecha_final" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success" >Descargar</button>
                                </div>
                            </form>
                        </div>
                        <div class="card col-md-5 ml-3">
                            <form action="{{ route('excel_historico_presupuestos') }}" method="GET">
                                <div class="card-header">{{ __('Histórico Presupuestos') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <label for="fecha_inicial">Fecha Inicial:</label>
                                            <input type="date" id="fecha_inicial_plan_salidas" name="fecha_inicial" class="form-control" required>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="fecha_final">Fecha Final:</label>
                                            <input type="date" id="fecha_final_plan_salidas" name="fecha_final" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success" >Descargar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="form-group row col-md-12 mt-4 mb-4 justify-content-center d-flex align-items-center">
                        <div class="card col-md-5">
                            <form action="{{ route('excel_solicitudes_aprobadas_transporte') }}" method="GET">
                                <div class="card-header">{{ __('Solicitud de Transporte para Prácticas Aprobadas') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <label for="fecha_inicial">Fecha Inicial:</label>
                                            <input type="date" id="fecha_inicial_aprobadas" name="fecha_inicial" class="form-control" required>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="fecha_final">Fecha Final:</label>
                                            <input type="date" id="fecha_final_aprobadas" name="fecha_final" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Descargar</button>
                                </div>
                            </form>
                        </div>
                        <div class="card col-md-5 ml-3">
                            <form action="{{ route('excel_solicitudes_realizadas') }}" method="GET">
                                <div class="card-header">{{ __('Solicitudes Realizadas/No Realizadas') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <label for="fecha_inicial">Fecha Inicial:</label>
                                            <input type="date" id="fecha_inicial_realizadas" name="fecha_inicial" class="form-control" required>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="fecha_final">Fecha Final:</label>
                                            <input type="date" id="fecha_final_realizadas" name="fecha_final" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Descargar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->coordinador())  
                    <div class="form-group row col-md-12 mt-4 mb-4">
                        <div class="card col-md-5">
                            <form action="{{ route('excel_programaciones_aprobadas_coord') }}" method="GET">
                                <div class="card-header">{{ __('Reporte Programaciones Aprobadas Coordinación') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <label for="anio">Año:</label>
                                            <select id="anio_prog_aprob_coord" name="anio" class="form-control" required>
                                                @foreach (range(date('Y')+1, 2021) as $year)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="periodo">Periodo:</label>
                                            <select id="periodo_prog_aprob_coord" name="periodo" class="form-control" required>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Descargar</button>
                                </div>
                            </form>
                        </div>
                        <div class="card col-md-5 ml-3">
                            <form action="{{ route('excel_programaciones_aprobadas_cons_fac') }}" method="GET">
                                <div class="card-header">{{ __('Reporte Programaciones Aprobadas Consejo de Facultad') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <label for="anio">Año:</label>
                                            <select id="anio_prog_aprob_cons_fac" name="anio" class="form-control" required>
                                                @foreach (range(date('Y')+1, 2021) as $year)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="periodo">Periodo:</label>
                                            <select id="periodo_prog_aprob_cons_fac" name="periodo" class="form-control" required>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Descargar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="form-group row col-md-12 mt-4 mb-4">
                        <div class="card col-md-5">
                            <form action="{{ route('excel_solicitudes_aprobadas_coord') }}" method="GET">
                                <div class="card-header">{{ __('Reporte Solicitudes Aprobadas Coordinación') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <label for="anio">Año:</label>
                                            <select id="anio_sol_aprob" name="anio" class="form-control" required>
                                                @foreach (range(date('Y')+1, 2021) as $year)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="periodo">Periodo:</label>
                                            <select id="periodo_sol_aprob" name="periodo" class="form-control" required>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Descargar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection   