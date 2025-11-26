<?php

namespace PractiCampoUD\Http\Controllers\Excel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use PractiCampoUD\Exports\ReportprogramacionesExport;
use PractiCampoUD\Exports\ReportSolicitudesExport;
use PractiCampoUD\Exports\ReportUsersExport;
use PractiCampoUD\Http\Controllers\Controller;
use PractiCampoUD\Imports\programacionesPreliminaresImport;
use PractiCampoUD\Imports\EstudiantesImport;
use PractiCampoUD\solicitud;
use PractiCampoUD\Exports\FormatoEstudiantesExport;
use PractiCampoUD\Exports\ReportFormatoEstudiantes;
use PractiCampoUD\Exports\ReportEncuestaExport;
use PractiCampoUD\Exports\ReportFormatoprogramaciones;
use PractiCampoUD\Exports\ReportFormatoUsers;
use PractiCampoUD\Imports\ReportUsersImport;
use PractiCampoUD\Exports\ReportSolicitudesAprobadasExport;
use PractiCampoUD\Exports\ReportSolicitudesRealizadasExport;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use PractiCampoUD\Exports\ReportPlanSalidasExport;
use PractiCampoUD\Exports\ReportProgramacionesAprobadasConsFac;
use PractiCampoUD\Exports\ReportProgramacionesAprobadasCoord;
use PractiCampoUD\Exports\ReportSolicitudesAprobadasCoord;

/**
 * Manejador de documentos 
 * formato excel
 * 
 * PHP version 7.2
 * 
 * @category PHP
 * @author LauraGiraldo
 * @copyright 2021 Sitio creado y administrado por la 
 * Facultad de Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas
 * @version 1.0
 * @link http://practicampo.udistrital.edu.co
 */
class ExcelController extends Controller
{

    /**
     * Exporta listado de usuarios
     *
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
        try
        {
            return Excel::download(new ReportUsersExport,'usuarios.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar listado de usuarios.');
        }
    }

    /**
     * Importa nuevos usuarios
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel()
    {
        try
        {
            Excel::import(new ReportUsersImport,request()->file('usuarios'));
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al cargar, verifique el archivo. Mensaje->'.$ex->getMessage());
        }
        return Redirect::to('users/filtrar/all')->with('success', 'Creación exitosa');
    }

    /**
     * Exporta programaciones preliminares
     *
     * @return \Illuminate\Http\Response
     */
    public function exportprogramacionesExcel(Request $request)
    {
        try
        {
            $id = $request->get('programacion_list');
            $mytime=Carbon::now('America/Bogota');
            return Excel::download(new ReportprogramacionesExport([$id]),'poyecciones_preliminares.xls');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar listado de programaciones preliminares.');
        }
    }

    /**
     * Exporta el formato para creación de usuarios
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFormatoUsers()
    {
       try
       {
            return Excel::download(new ReportFormatoUsers(), 'usuarios.xlsx');
       }
       catch(\Exception $ex)
       {
        return back()->withError('Falla al descargar el formato de usuarios.');
       }
    }

    /**
     * Exporta el formato para creación programaciones
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFormatoProy()
    {
       try
       {
            return Excel::download(new ReportFormatoprogramaciones(), 'programaciones_preliminares.xlsx');
       }
       catch(\Exception $ex)
       {
        return back()->withError('Falla al descargar el formato de programaciones preliminares.');
       }
    }

    /**
     * Exporta el formato para cargar estudiantes
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFormatoEstud()
    {
       try
       {
            return Excel::download(new ReportFormatoEstudiantes(), 'listado_estudiantes.xlsx');
       }
       catch(\Exception $ex)
       {
        return back()->withError('Falla al descargar el formato de estudiantes.');
       }
    }

    /**
     * Importa nuevas programaciones
     *
     * @return \Illuminate\Http\Response
     */
    public function importprogramacionesExcel()
    {
        try
        {
            Excel::import(new programacionesPreliminaresImport,request()->file('programaciones_preliminares'));
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al cargar, verifique el archivo. Mensaje->'.$ex->getMessage());
        }

        return Redirect::to('programaciones/filtrar/all')->with('success', 'Creación exitosa');
    }

    /**
     * Importa listado de estudiantes
     *
     * @return \Illuminate\Http\Response
     */
    public function importEstudiantesExcel($id)
    {
        DB::beginTransaction();
        try
        {
            $solicitud_practica =solicitud::where('id', '=', $id)->first();
            $validacion_estudiantes = DB::table('estudiantes_solicitud_practica')
                ->where('id_solicitud_practica', '=', $id)->exists();
            if($validacion_estudiantes){
                throw new Exception('Error: Ya se han importando los estudiantes anteriormente.');
            }
            $coleccion = Excel::toCollection(null, request()->file('listado_estudiantes'))->first();
            $total_filas = max(0, $coleccion->filter(function ($fila, $index) {
                return $index > 0 && !empty($fila[0]);
            })->count());
            if($solicitud_practica->num_estudiantes != $total_filas){
                throw new Exception('Error: Verifica que la cantidad de estudiantes registrada en la lista sea igual a la registrada en la solicitud'.
                                    "\n".'Estudiantes Lista Excel: '.$total_filas.
                                    "\n".'Estudiantes Solicitud: '.$solicitud_practica->num_estudiantes);
            }

            Excel::import(new EstudiantesImport($id),request()->file('listado_estudiantes'));            
            $solicitud_practica->listado_estudiantes = 1;
            $solicitud_practica->update();            

            DB::commit();
            return response()->json(['message' => 'Estudiantes importados con éxito'], 200);
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return response()->json(['error' => 'Hubo un error al importar el archivo.'."\n".$ex->getMessage()], 500);
            //return back()->withError('Falla al cargar, verifique el archivo. Mensaje->'.$ex->getMessage());
        }
        //return Redirect::to('solicitudes/filtrar/proy-comp')->with('success', 'Creación exitosa');
    }

    /**
     * Exporta listado de solicitudes
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function exportSolicitudesExcel(Request $request)
    {
        try
        {
            $id = $request->get('solicitud_list');
            $mytime=Carbon::now('America/Bogota');
            return Excel::download(new ReportSolicitudesExport([$id]),'solicitudes_practica.xls');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al cargar, verifique el archivo. Mensaje->'.$ex->getMessage());
        }
    }

    /**
     * Exporta encuestra servicio transporte
     *
     * @param  int  $id
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function exportEncuestaTrans(Request $request)
    {
        try
        {
            $id = $request->get('encuesta_transporte');
            $mytime=Carbon::now('America/Bogota');
            return Excel::download(new ReportEncuestaExport([$id]),'encuesta_transportador.xls');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar las encuestas de transporte.');
        }
    }

    /**
     * Muestra formulario para descargar los excel
     *
     * @return \Illuminate\Http\Response
     */
    public function excel_solicitudes_edit(){
        $usuario = DB::table('users')->where('id','=',Auth::user()->id)->first();
        $control_sistema = DB::table('control_sistema')->first();
        return view('excel.edit',[
                                'control_sistema' => $control_sistema,
                                'usuario' => $usuario]);
    }

    /**
     * Exporta las programaciones para el plan de salidas de campo
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function excel_programaciones_plan_salidas(Request $request){
        try
        {
            $fechaInicial = $request->input('fecha_inicial');
            $fechaFinal = $request->input('fecha_final');
            $mytime = Carbon::now('America/Bogota')->year + 1;
            //dd("Solicitudes Aprobadas: ",$fechaInicial,$fechaFinal);
            return Excel::download(new ReportPlanSalidasExport($fechaInicial,$fechaFinal),'Plan_salidas_de_campo_'.$mytime.'.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar excel: '.$ex->getMessage());
        }
    }
    /**
     * Exporta las prácticas aprobadas para la solicitud de transporte
     *
     * @return \Illuminate\Http\Response
     */
    public function excel_solicitudes_aprobadas_transporte(Request $request){
        try
        {
            $fechaInicial = $request->input('fecha_inicial');
            $fechaFinal = $request->input('fecha_final');
            $mytime = Carbon::now('America/Bogota')->toDateString();
            return Excel::download(new ReportSolicitudesAprobadasExport($fechaInicial,$fechaFinal),'Solicitud_Transporte_'.$mytime.'.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar excel: '.$ex->getMessage());
        }
    }

    /**
     * Exporta las prácticas que fueron o no realizadas
     *
     * @return \Illuminate\Http\Response
     */
    public function excel_solicitudes_realizadas(Request $request){
        try
        {
            $fechaInicial = $request->input('fecha_inicial');
            $fechaFinal = $request->input('fecha_final');
            $mytime = Carbon::now('America/Bogota')->toDateString();
            return Excel::download(new ReportSolicitudesRealizadasExport($fechaInicial,$fechaFinal),'Solicitudes_Realizadas_'.$mytime.'.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar excel: '.$ex->getMessage());
        }
    }

    /**
     * Exporta las programaciones aprobadas por coordinación
     *
     * @return \Illuminate\Http\Response
     */
    public function excel_programaciones_aprobadas_coord(Request $request){
        try
        {
            $anio = $request->input('anio');
            $periodo = $request->input('periodo');
            $mytime = Carbon::now('America/Bogota')->toDateString();
            return Excel::download(new ReportProgramacionesAprobadasCoord($anio,$periodo),'Programaciones_Aprobadas_Coordinacion_'.$anio.'-'.$periodo.'.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar excel: '.$ex->getMessage());
        }
    }

    /**
     * Exporta las programaciones aprobadas por consejo de facultad
     *
     * @return \Illuminate\Http\Response
     */
    public function excel_programaciones_aprobadas_cons_fac(Request $request){
        try
        {
            $anio = $request->input('anio');
            $periodo = $request->input('periodo');
            $mytime = Carbon::now('America/Bogota')->toDateString();
            return Excel::download(new ReportProgramacionesAprobadasConsFac($anio,$periodo),'Programaciones_Aprobadas_Coordinacion_'.$anio.'-'.$periodo.'.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar excel: '.$ex->getMessage());
        }
    }

    /**
     * Exporta las solicitudes aprobadas por coordinación
     *
     * @return \Illuminate\Http\Response
     */
    public function excel_solicitudes_aprobadas_coord(Request $request){
        try
        {
            $anio = $request->input('anio');
            $periodo = $request->input('periodo');
            $mytime = Carbon::now('America/Bogota')->toDateString();
            return Excel::download(new ReportSolicitudesAprobadasCoord($anio,$periodo),'Solicitudes_Aprobadas_Coordinacion_'.$anio.'-'.$periodo.'.xlsx');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar excel: '.$ex->getMessage());
        }
    }

}
