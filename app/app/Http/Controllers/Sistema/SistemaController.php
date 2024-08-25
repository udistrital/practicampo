<?php

namespace PractiCampoUD\Http\Controllers\Sistema;

use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PractiCampoUD\control_sistema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

/**
* Información del sistema
* 
* PHP version 7.2
* 
* @category PHP
* @author LauraGiraldo
* @copyright 2021 Sitio creado y administrado por la 
* Facultad de Medio Ambiente y Recursos Naturales de la Universidad Francisco José de Caldas
* @version 1.0
* @link http://practicampo.udistrital.edu.co
*/
class SistemaController extends Controller
{
    /**
     * Muestra formulario para editar información del sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $control_sistema =DB::table('control_sistema')->first();
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        return view('sistema.edit',['control_sistema'=>$control_sistema,
                                    'usuario'=>$usuario]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Actualización de información del sistema
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $mytime = Carbon::now('America/Bogota');
        $control_sistema = control_sistema::first();

        $control_sistema->fecha_apert_proy = $request->get('fecha_apert_proy');
        $control_sistema->fecha_cierre_proy = $request->get('fecha_cierre_proy');
        $control_sistema->fecha_apert_solic = $request->get('fecha_apert_solic');
        $control_sistema->fecha_cierre_solic = $request->get('fecha_cierre_solic');
        $control_sistema->vlr_docen_min = $request->get('vlr_docen_min');
        $control_sistema->vlr_docen_max = $request->get('vlr_docen_max');
        $control_sistema->vlr_estud_min = $request->get('vlr_estud_min');
        $control_sistema->vlr_estud_max = $request->get('vlr_estud_max');
        $control_sistema->fecha_actualizacion = $mytime->toDateString();
        $control_sistema->id_usuer_update = Auth::user()->id;
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();

        $control_sistema->update();
        return view('home2',['usuario'=>$usuario,
                            'control_sistema'=>$control_sistema,]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
