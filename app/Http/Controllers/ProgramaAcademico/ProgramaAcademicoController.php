<?php

namespace PractiCampoUD\Http\Controllers\ProgramaAcademico;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use PractiCampoUD\presupuesto_programa_academico;
use PractiCampoUD\programa_academico;
use PractiCampoUD\User;
use Carbon\Carbon;
use DateTime;
use DB;
use Exception;

/**
 * Controlador de los Programas académicos
 * 
 * PHP version 8.2
 * 
 * @category PHP
 * @author Julian Gonzalez
 * @copyright 2021 Sitio creado y administrado por la 
 * Facultad de Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas
 * @version 1.0
 * @link http://practicampo.udistrital.edu.co
 */

 class ProgramaAcademicoController extends Controller
{
    /**
     * Muestra los programas académicos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $control_sistema = DB::table('control_sistema')->first();
	    $programas_academicos =DB::table('programa_academico')->get();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        return view('programa_academico.edit',['control_sistema'=>$control_sistema,
				                    'programas_academicos'=>$programas_academicos,
                                    'usuario'=>$usuario]);
    }

    /**
     * Crea un programa académico
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        try {
            DB::beginTransaction(); 
            $programa_academico = new programa_academico; 
            $programa_academico->id = $request->get('id_programa_academico');
            $programa_academico->programa_academico = $request->get('nombre_programa_academico');
            $programa_academico->pregrado = (int) $request->get('pregrado');
            $presupuesto_programa_academico =new presupuesto_programa_academico;
            $presupuesto_programa_academico->id_programa_academico = $request->get('id_programa_academico');
            $presupuesto_programa_academico->presupuesto_inicial = 0;
            $presupuesto_programa_academico->presupuesto_actual = 0;
            $programa_academico->save();
            $presupuesto_programa_academico->save();
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al crear el programa académico. Intentalo nuevamente. ' . $e->getMessage());
        }
    }
    /**
     * Actualiza un programa académico
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        $mytime = Carbon::now('America/Bogota');
        try{
        DB::beginTransaction(); 
        $programa_academico = programa_academico::where('id', '=', $id)->first();
        $programa_academico->programa_academico = $request->get('nombre_programa_academico');
        $programa_academico->pregrado = (int) $request->get('pregrado');
        $programa_academico->update();
        DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el programa académico. Intentalo nuevamente. ' . $e->getMessage());
        }
        return redirect()->back();
    }
}
