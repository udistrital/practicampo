<?php

namespace PractiCampoUD\Http\Controllers\Presupuesto;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use PractiCampoUD\costos_proyeccion;
use PractiCampoUD\materiales_herramientas_proyeccion;
use PractiCampoUD\proyeccion;
use PractiCampoUD\solicitud;
use PractiCampoUD\presupuesto_programa_academico;
use PractiCampoUD\detalle_presupuesto_programa_academico;
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
        $presupuesto_programa_academico =DB::table('presupuesto_programa_academico')->get();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        $programa_academico =DB::table('programa_academico')->get();
        return view('presupuesto.edit',['control_sistema'=>$control_sistema,
                                    'presupuesto_programa_academico'=>$presupuesto_programa_academico,
                                    'programa_academico'=>$programa_academico,
                                    'usuario'=>$usuario]);
    }

    /**
     * Actualiza el presupuesto de los programas académicos
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        //dd($request);
        $presupuesto_programa_academico =presupuesto_programa_academico::get();
        foreach ($presupuesto_programa_academico as $presu_pa){
            $presu_pa->presupuesto_inicial = $request->get($presu_pa->id_programa_academico);
            $presu_pa->presupuesto_actual = $request->get($presu_pa->id_programa_academico);
            $presu_pa->update();
        };

        $control_sistema = DB::table('control_sistema')->first();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        return view('home2',['usuario'=>$usuario,
                            'control_sistema'=>$control_sistema,]);

    }
}