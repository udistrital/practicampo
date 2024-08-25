<?php

namespace PractiCampoUD\Http\Controllers\Otros;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

/**
 * Espacio académico para formularios
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
class EspacioAcademicoController extends Controller
{
    /**
     * Busca los espacios académicos 
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function searchEspaAca(Request $request)
    {
        if($request->opc == 1)
        {
            $espa_aca = DB::table('espacio_academico')
            ->where('id_programa_academico','=',$request->id_pa)
            ->where('codigo_espacio_academico','=', $request->id)->first();

            return response()->json($espa_aca);
        }
        elseif($request->opc == 2)
        {
            $espa_aca = DB::table('espacio_academico')
            ->where('id_programa_academico','=',$request->id_pa)
            ->where('codigo_espacio_academico','=', $request->id_ea)->first();

            return response()->json($espa_aca);
        }
    }

    /**
     * Recarga los espacios académicos 
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public  function recargarEspaAca(Request $request)
    {
        $id_prog_aca = $request->id_prog_aca;
        $idUser=$request->id_docen;

        $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

        $espa_aca =DB::table('espacio_academico as esp_aca')
                    ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                            'esp_aca.espacio_academico', 'prog_aca.pregrado')
                    ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                    ->where('id_programa_academico',$id_prog_aca)
                    ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                    $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
        
        $all_espa_aca =DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'prog_aca.pregrado')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->where('id_programa_academico',$id_prog_aca)->get();

        $respu = array ('respu'=>$espa_aca, 'respu2'=>$all_espa_aca);

        return response()->json($respu);
    }

    /**
     * Recarga los espacios académicos editables
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public  function recargarEspaAcaEdit(Request $request)
    {
        $id_prog_aca = $request->id_prog_aca;
        $id_espa_aca = $request->id_espa_aca;
        $idUser=$request->id_docen;

        $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

        $espa_aca =DB::table('espacio_academico as esp_aca')
                    ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                            'esp_aca.espacio_academico', 'prog_aca.pregrado')
                    ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                    ->where('id_programa_academico',$id_prog_aca)
                    ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                    $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();

        $all_espa_aca =DB::table('espacio_academico as esp_aca')
        ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                'esp_aca.espacio_academico', 'prog_aca.pregrado')
        ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
        ->where('id_programa_academico',$id_prog_aca)->get();
    
        $respu = array ('respu'=>$espa_aca, 'respu2'=>$all_espa_aca);            

        return response()->json($respu);
    }

    /**
     * Recarga los docentes asociados a los
     * espacios académicos 
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public  function recargarDocenEspaAca(Request $request)
    {
        $id_espa_aca = $request->id_espa_aca;
        $espa_aca = DB::table('espacio_academico as espa_aca')
                    ->where('id',$id_espa_aca)->first();

        $docentes=DB::table('users')
                    ->select('id',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->where('id_espacio_academico_1',$espa_aca->id)
                    ->orWhere('id_espacio_academico_2',$espa_aca->id)
                    ->orWhere('id_espacio_academico_3',$espa_aca->id)
                    ->orWhere('id_espacio_academico_4',$espa_aca->id)
                    ->orWhere('id_espacio_academico_5',$espa_aca->id)
                    ->orWhere('id_espacio_academico_6',$espa_aca->id)->get();

        if(count($docentes) == 0)
        {
            $docentes[]=['id'=>0,'full_name'=>"No hay docente registrado"];
        }

        return response()->json($docentes);
    }

}
