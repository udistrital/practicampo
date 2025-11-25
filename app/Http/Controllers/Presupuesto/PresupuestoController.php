<?php

namespace PractiCampoUD\Http\Controllers\Presupuesto;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use PractiCampoUD\costos_programacion;
use PractiCampoUD\materiales_herramientas_programacion;
use PractiCampoUD\programacion;
use PractiCampoUD\solicitud;
use PractiCampoUD\presupuesto_programa_academico;
use PractiCampoUD\historico_presupuesto_programa_academico;
use PractiCampoUD\presupuesto_transporte_menor;
use PractiCampoUD\User;
use Carbon\Carbon;
use DateTime;
use DB;

/**
 * Presupuesto de los programas académicos
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

 class PresupuestoController extends Controller
{
    /**
     * Muestra formulario para editar los presupuestos de los programas academicos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $control_sistema = DB::table('control_sistema')->first();
	    $presupuesto_programa_academico =DB::table('presupuesto_programa_academico as ppa')
        ->select('ppa.*', 'pa.programa_academico')
        ->join('programa_academico as pa','ppa.id_programa_academico','=','pa.id')
        ->get();
	    $presupuesto_transporte_menor = DB::table('presupuesto_transporte_menor')
            ->orderBy('id', 'desc')
            ->first();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        $programas_academicos =DB::table('programa_academico')
        ->orderByRaw("
        CASE
            WHEN programa_academico LIKE 'Tec%' THEN 1
            WHEN programa_academico LIKE 'Ing%' THEN 2
            WHEN programa_academico LIKE 'Adm%' THEN 3
            WHEN programa_academico LIKE 'Esp%' THEN 4
            WHEN programa_academico LIKE 'Maes%' THEN 5
            ELSE 5
        END
        ")
        ->get();
        return view('presupuesto.edit',['control_sistema'=>$control_sistema,
                                    'presupuesto_programa_academico'=>$presupuesto_programa_academico,
                                    'presupuesto_transporte_menor'=>$presupuesto_transporte_menor,
                                    'programa_academico'=>$programas_academicos,
                                    'usuario'=>$usuario]);
    }

    /**
     * Actualiza el presupuesto del programa académico
     *
     * @param  \Illuminate\Http\Request
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $mytime = Carbon::now('America/Bogota');
        try{
        DB::beginTransaction(); 
            $presupuesto_programa_academico = presupuesto_programa_academico::where('id', '=', $id)->first();
            $valor_formateado = (int) str_replace(['$', '.', ' '], '', $request->get('nuevo_presupuesto_programa_academico'));            
            $presupuesto_programa_academico->presupuesto_inicial = $valor_formateado;
            $presupuesto_programa_academico->presupuesto_actual = $valor_formateado;
             
            $historico_presupuesto_programa_academico = new historico_presupuesto_programa_academico;                      
            $historico_presupuesto_programa_academico->id_presupuesto_programa = $presupuesto_programa_academico->id;
            $historico_presupuesto_programa_academico->id_programa_academico = $presupuesto_programa_academico->id_programa_academico;
            $historico_presupuesto_programa_academico->presupuesto_inicial_historico = $presupuesto_programa_academico->presupuesto_inicial;
            $historico_presupuesto_programa_academico->id_user_update = Auth::user()->id;
            $historico_presupuesto_programa_academico->fecha_update = $mytime;
            $presupuesto_programa_academico->update();
            $historico_presupuesto_programa_academico->save();
        DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Error al guardar presupuesto inicial: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el presupuesto. Intentalo nuevamente. ' . $e->getMessage());
        }
        return redirect()->back();

    }

    /**
     * Suma el presupuesto del programa académico
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function sum(Request $request, $id){
        $mytime = Carbon::now('America/Bogota');
        try{
        DB::beginTransaction(); 
            $presupuesto_programa_academico = presupuesto_programa_academico::where('id', '=', $id)->first();
            $valor_formateado = (int) str_replace(['$', '.', ' '], '', $request->get('sumar_presupuesto_programa_academico'));            
            $presupuesto_programa_academico->presupuesto_inicial = $presupuesto_programa_academico->presupuesto_inicial + $valor_formateado;
            $presupuesto_programa_academico->presupuesto_actual = $presupuesto_programa_academico->presupuesto_actual + $valor_formateado;
             
            $historico_presupuesto_programa_academico = new historico_presupuesto_programa_academico;                      
            $historico_presupuesto_programa_academico->id_presupuesto_programa = $presupuesto_programa_academico->id;
            $historico_presupuesto_programa_academico->id_programa_academico = $presupuesto_programa_academico->id_programa_academico;
            $historico_presupuesto_programa_academico->presupuesto_inicial_historico = $valor_formateado;
            $historico_presupuesto_programa_academico->id_user_update = Auth::user()->id;
            $historico_presupuesto_programa_academico->fecha_update = $mytime;
            $presupuesto_programa_academico->update();
            $historico_presupuesto_programa_academico->save();
        DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Error al guardar presupuesto inicial: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el presupuesto. Intentalo nuevamente. ' . $e->getMessage());
        }
        return redirect()->back();

    }

    /**
     * Actualiza el presupuesto del transporte menor
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update_presupuesto_tm(Request $request){
        $mytime = Carbon::now('America/Bogota');
        try{
        DB::beginTransaction();
        $presupuesto_transporte_menor = presupuesto_transporte_menor::orderBy('id', 'desc')->first();
        $valor_formateado = (int) str_replace(['$', '.', ' '], '', $request->get('presupuesto_transporte_menor'));
        if($valor_formateado != 0){
        $presupuesto_transporte_menor = new presupuesto_transporte_menor;
        $presupuesto_transporte_menor->presupuesto_inicial = $valor_formateado;
        $presupuesto_transporte_menor->presupuesto_restante = $valor_formateado;
        $presupuesto_transporte_menor->id_user_update = Auth::user()->id;
        $presupuesto_transporte_menor->fecha_update = $mytime;
        $presupuesto_transporte_menor->save();
        }else{
            throw new \Exception('El nuevo presupuesto debe ser mayor a cero (0)');
        }


        DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Error al guardar presupuesto del transporte menor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el presupuesto del transporte menor. Intentalo nuevamente. ' . $e->getMessage());
        }

        $control_sistema = DB::table('control_sistema')->first();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        return view('home2',['usuario'=>$usuario,
                            'control_sistema'=>$control_sistema,]);

    }

    /**
     * Actualiza el presupuesto del transporte menor
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function sum_presupuesto_tm(Request $request){
        $mytime = Carbon::now('America/Bogota');
        try{
        DB::beginTransaction();
        $presupuesto_transporte_menor = presupuesto_transporte_menor::orderBy('id', 'desc')->first();
        $valor_formateado = (int) str_replace(['$', '.', ' '], '', $request->get('presupuesto_transporte_menor'));
        if($valor_formateado != 0){
        $presupuesto_transporte_menor = new presupuesto_transporte_menor;
        $presupuesto_transporte_menor->presupuesto_inicial = $valor_formateado;
        $presupuesto_transporte_menor->presupuesto_restante = $valor_formateado;
        $presupuesto_transporte_menor->id_user_update = Auth::user()->id;
        $presupuesto_transporte_menor->fecha_update = $mytime;
        $presupuesto_transporte_menor->save();
        }else{
            throw new \Exception('El nuevo presupuesto debe ser mayor a cero (0)');
        }


        DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Error al guardar presupuesto del transporte menor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el presupuesto del transporte menor. Intentalo nuevamente. ' . $e->getMessage());
        }

        $control_sistema = DB::table('control_sistema')->first();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        return view('home2',['usuario'=>$usuario,
                            'control_sistema'=>$control_sistema,]);

    }
}
