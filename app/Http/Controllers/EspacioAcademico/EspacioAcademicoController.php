<?php

namespace PractiCampoUD\Http\Controllers\EspacioAcademico;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PractiCampoUD\espacio_academico;
use Carbon\Carbon;
use DB;
use Exception;

/**
 * Controlador de los espacios académicos
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

 class EspacioAcademicoController extends Controller
{
    /**
     * Muestra los espacios académicos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $control_sistema = DB::table('control_sistema')->first();
	    $espacios_academicos = DB::table('espacio_academico')
            ->join('programa_academico', 'programa_academico.id', '=', 'espacio_academico.id_programa_academico')
            ->select('espacio_academico.*', 'programa_academico.programa_academico as nombre_programa_academico')
            ->get();
        $programas_academicos =DB::table('programa_academico')->get();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        return view('espacio_academico.edit',['control_sistema'=>$control_sistema,
				                    'espacios_academicos'=>$espacios_academicos,
                                    'programas_academicos'=>$programas_academicos,
                                    'usuario'=>$usuario]);
    }

    /**
     * Crea un espacio académico
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        try {
            DB::beginTransaction();
            $max_espacios = DB::table('espacio_academico')
                ->where('id', '!=', 999)
                ->max('id');
            $espacio_academico = new espacio_academico; 
            $espacio_academico->id = $max_espacios+1;
            $espacio_academico->id_programa_academico = $request->get('id_programa_academico');
            $espacio_academico->codigo_espacio_academico = $request->get('codigo_espacio_academico');
            $espacio_academico->espacio_academico = $request->get('nombre_espacio_academico');
            $espacio_academico->plan_estudios_1 = $request->get('plan_estudios_1');
            $espacio_academico->plan_estudios_2 = $request->get('plan_estudios_2');
            $espacio_academico->tipo_espacio = $request->get('tipo_espacio');
            $espacio_academico->electiva = (int) $request->get('electiva');
            $espacio_academico->save();
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al crear el espacio académico. Intentalo nuevamente. ' . $e->getMessage());
        }
    }
    /**
     * Actualiza los programas académicos
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        $mytime = Carbon::now('America/Bogota');
        try{
        DB::beginTransaction(); 
        $espacio_academico = espacio_academico::where('id', '=', $id)->first();
        $espacio_academico->id_programa_academico = (int) $request->get('id_programa_academico');
        $espacio_academico->codigo_espacio_academico = (int) $request->get('codigo_espacio_academico');
        $espacio_academico->espacio_academico = $request->get('nombre_espacio_academico');
        $espacio_academico->plan_estudios_1 = (int) $request->get('plan_estudios_1');
        $espacio_academico->plan_estudios_2 = (int) $request->get('plan_estudios_2');
        $espacio_academico->tipo_espacio = $request->get('tipo_espacio');
        $espacio_academico->electiva = (int) $request->get('electiva');
        $espacio_academico->update();
        DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el espacio académico. Intentalo nuevamente. ' . $e->getMessage());
        }
        return redirect()->back();
    }
}
