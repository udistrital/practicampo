<?php

namespace PractiCampoUD\Http\Controllers\Otros;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use DB;

/**
 * Viáticos sistema
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
class OtrosController extends Controller
{
    /**
     * Información de viáticos DB
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function searchViaticos(Request $request)
    {
         $id_prog_aca = $request->id_prog_aca;
         $viaticos =DB::table('control_sistema  as sist')->first();
 
         $prog =DB::table('programa_academico as prog_aca')
         ->select('prog_aca.pregrado')
         ->where('prog_aca.id',$id_prog_aca)->first();
 
         $respu = array ('respu'=>$viaticos, 'respu2'=>$prog);
 
         return response()->json($respu);
 
    }
}

