<?php

namespace PractiCampoUD\Http\Controllers\Excel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use PractiCampoUD\Exports\ReportProyeccionesExport;
use PractiCampoUD\Exports\ReportSolicitudesExport;
use PractiCampoUD\Exports\ReportUsersExport;
use PractiCampoUD\Http\Controllers\Controller;
use PractiCampoUD\Imports\ProyeccionesPreliminaresImport;
use PractiCampoUD\Imports\EstudiantesImport;
use PractiCampoUD\solicitud;
use PractiCampoUD\Exports\FormatoEstudiantesExport;
use PractiCampoUD\Exports\ReportFormatoEstudiantes;
use PractiCampoUD\Exports\ReportEncuestaExport;
use PractiCampoUD\Exports\ReportFormatoProyecciones;
use PractiCampoUD\Exports\ReportFormatoUsers;
use PractiCampoUD\Imports\ReportUsersImport;
use Carbon\Carbon;
use DB;

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
     * Exporta proyecciones preliminares
     *
     * @return \Illuminate\Http\Response
     */
    public function exportProyeccionesExcel(Request $request)
    {
        try
        {
            $id = $request->get('proyeccion_list');
            $mytime=Carbon::now('America/Bogota');
            return Excel::download(new ReportProyeccionesExport([$id]),'poyecciones_preliminares.xls');
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar listado de proyecciones preliminares.');
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
     * Exporta el formato para creación proyecciones
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFormatoProy()
    {
       try
       {
            return Excel::download(new ReportFormatoProyecciones(), 'proyecciones_preliminares.xlsx');
       }
       catch(\Exception $ex)
       {
        return back()->withError('Falla al descargar el formato de proyecciones preliminares.');
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
     * Importa nuevas proyecciones
     *
     * @return \Illuminate\Http\Response
     */
    public function importProyeccionesExcel()
    {
        try
        {
            Excel::import(new ProyeccionesPreliminaresImport,request()->file('proyecciones_preliminares'));
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al cargar, verifique el archivo. Mensaje->'.$ex->getMessage());
        }

        return Redirect::to('proyecciones/filtrar/all')->with('success', 'Creación exitosa');
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
            Excel::import(new EstudiantesImport($id),request()->file('listado_estudiantes'));
            
            $solicitud_practica =solicitud::where('id', '=', $id)->first();
            $solicitud_practica->listado_estudiantes = 1;
            $solicitud_practica->update();
            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return back()->withError('Falla al cargar, verifique el archivo. Mensaje->'.$ex->getMessage());
        }
        return Redirect::to('solicitudes/filtrar/proy-comp')->with('success', 'Creación exitosa');
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

}
