<?php

namespace PractiCampoUD\Http\Controllers\Sede;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PractiCampoUD\sedes_universidad;
use Carbon\Carbon;
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

 class SedeController extends Controller
{
    /**
     * Muestra las sedes de la universidad
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $control_sistema = DB::table('control_sistema')->first();
	    $sedes =DB::table('sedes_universidad')->get();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        return view('sede.edit',['control_sistema'=>$control_sistema,
				                    'sedes'=>$sedes,
                                    'usuario'=>$usuario]);
    }

    /**
     * Crea una nueva sede
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        try {
            DB::beginTransaction(); 
            $id = DB::table('sedes_universidad')->max('id');
            $sedes_universidad = new sedes_universidad(); 
            $sedes_universidad->id = $id+1;
            $sedes_universidad->sede = $request->get('sede');
            $sedes_universidad->direccion = $request->get('direccion');
            $sedes_universidad->save();
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al crear la sede. Intentalo nuevamente. ' . $e->getMessage());
        }
    }
    /**
     * Actualiza una sede
     *
     * @param  int id
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        try{
        DB::beginTransaction(); 
        $sedes_universidad = sedes_universidad::where('id', '=', $id)->first();
        $sedes_universidad->sede = $request->get('sede');
        $sedes_universidad->direccion = $request->get('direccion');
        $sedes_universidad->update();
        DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la sede. Intentalo nuevamente. ' . $e->getMessage());
        }
        return redirect()->back();
    }
}
