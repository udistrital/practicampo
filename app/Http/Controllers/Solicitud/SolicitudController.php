<?php

namespace PractiCampoUD\Http\Controllers\Solicitud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use PractiCampoUD\costos_proyeccion;
use PractiCampoUD\docentes_practica;
use PractiCampoUD\documentos_requeridos_solicitud;
use PractiCampoUD\encuesta_transporte;
use PractiCampoUD\materiales_herramientas_proyeccion;
use PractiCampoUD\practicas_integradas;
use PractiCampoUD\proyeccion;
use PractiCampoUD\riesgos_amenazas_practica;
use PractiCampoUD\solicitud_transporte;
use PractiCampoUD\solicitud;
use PractiCampoUD\transporte_menor;
use PractiCampoUD\transporte_proyeccion;
use PractiCampoUD\presupuesto_programa_academico;
use PractiCampoUD\detalle_presupuesto_programa_academico;
use PractiCampoUD\estudiantes_practica;
use PractiCampoUD\Http\Controllers\Controller;
use PractiCampoUD\Mail\CodigoMail;
use Carbon\Carbon;
use DateTime;
use DB;
use stdClass;

/**
 * Solicitudes de prácticas
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
class SolicitudController extends Controller
{
    /**
     * Muestra formulario de solicitud
     *
     * @param  int  $id
     * @param  int  $tipo_ruta
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$tipo_ruta)
    {
        $id=Crypt::decrypt($id);
        $tipo_ruta=Crypt::decrypt($tipo_ruta);
        $idRole = Auth::user()->id_role;
        $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();

        $control_sistema =DB::table('control_sistema')->first();

        switch($idRole)
        {
            case 1:
                $proyeccion_preliminar = proyeccion::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $sedes = DB::table('sedes_universidad')->get();
                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $num_grupos_proy = 0; 

                $id_esp_aca = $proyeccion_preliminar->id_espacio_academico;
                $docentes_activos =DB::table('users')
                ->select('users.id',
                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->where('users.id_estado','=',1)
                ->where('users.id_role','=',5)
                ->where(function ($query) use($id_esp_aca){
                    $query->where('users.id_espacio_academico_1','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_2','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_3','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_4','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_5','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_6','=',$id_esp_aca);
                })->get();
                
                $num_docen_act = count($docentes_activos);
                if($num_docen_act == 0 || $docentes_activos == null)
                {
                    
                    $docentes_activos->id = 0;
                    $docentes_activos->full_name = 'No hay docentes activos';
                    $docentes_activos->push($docentes_activos);
                } 

                $all_esp_aca=DB::table('espacio_academico')->get();
                $all_prog_aca=$programa_academico;
        
                $prog_aca_user = [];
                $esp_aca_user = [];

                /** practicas integradas */
                    $docen_integ = [];
                    $d_int_espa_aca_1 = [];
                    $d_int_espa_aca_2 = [];
                    $d_int_espa_aca_3 = [];
                    $d_int_espa_aca_4 = [];
                    $d_int_espa_aca_5 = [];
                    $d_int_espa_aca_6 = [];
                    $d_int_espa_aca_7 = [];

                    if($practicas_integradas->id_docen_espa_aca_1 != null || $practicas_integradas->id_docen_espa_aca_1 > 0)
                    {
                        $d_1=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_1)->get();

                        foreach($d_1 as $d_1)
                        {
                            $d_int_espa_aca_1[] = ['id'=>$d_1->id,'full_name'=>$d_1->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_1[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_2 != null || $practicas_integradas->id_docen_espa_aca_2 > 0)
                    {
                        $d_2=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_2)->get();

                        foreach($d_2 as $d_2)
                        {
                            $d_int_espa_aca_2[] = ['id'=>$d_2->id,'full_name'=>$d_2->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_2[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_3 != null || $practicas_integradas->id_docen_espa_aca_3 > 0)
                    {
                        $d_3=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_3)->get();

                        foreach($d_3 as $d_3)
                        {
                            $d_int_espa_aca_3[] = ['id'=>$d_3->id,'full_name'=>$d_3->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_3[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_4 != null || $practicas_integradas->id_docen_espa_aca_4 > 0)
                    {
                        $d_4=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_4)->get();

                        foreach($d_4 as $d_4)
                        {
                            $d_int_espa_aca_4[] = ['id'=>$d_4->id,'full_name'=>$d_4->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_4[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_5 != null || $practicas_integradas->id_docen_espa_aca_5 > 0)
                    {
                    $d_5=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_5)->get();

                        foreach($d_5 as $d_5)
                        {
                            $d_int_espa_aca_5[] = ['id'=>$d_5->id,'full_name'=>$d_5->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_5[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_6 != null || $practicas_integradas->id_docen_espa_aca_6 > 0)
                    {
                        $d_6=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_6)->get();

                        foreach($d_6 as $d_6)
                        {
                            $d_int_espa_aca_6[] = ['id'=>$d_6->id,'full_name'=>$d_6->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_6[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_7 != null || $practicas_integradas->id_docen_espa_aca_7 > 0)
                    {
                        $d_7=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_7)->get();

                        foreach($d_7 as $d_7)
                        {
                            $d_int_espa_aca_7[] = ['id'=>$d_7->id,'full_name'=>$d_7->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_7[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }
                /** practicas integradas */

                $espa_aca_int = DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$practicas_integradas->id_espa_aca_1, $practicas_integradas->id_espa_aca_2, $practicas_integradas->id_espa_aca_3, 
                $practicas_integradas->id_espa_aca_4, $practicas_integradas->id_espa_aca_5, $practicas_integradas->id_espa_aca_6,
                $practicas_integradas->id_espa_aca_7])->get();
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }

                $estado_doc_respon =$usuario->id_estado;
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "practicas_integradas"=>$practicas_integradas,
                                                "espa_aca_integradas"=>$espa_aca_int,
                                                "d_int_espa_aca_1"=>$d_int_espa_aca_1,
                                                "d_int_espa_aca_2"=>$d_int_espa_aca_2,
                                                "d_int_espa_aca_3"=>$d_int_espa_aca_3,
                                                "d_int_espa_aca_4"=>$d_int_espa_aca_4,
                                                "d_int_espa_aca_5"=>$d_int_espa_aca_5,
                                                "d_int_espa_aca_6"=>$d_int_espa_aca_6,
                                                "d_int_espa_aca_7"=>$d_int_espa_aca_7,
                                                "sedes"=>$sedes,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "all_programas_aca"=>$all_prog_aca,
                                                "all_espacios_aca"=>$all_esp_aca,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "docentes_activos"=>$docentes_activos,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);

            break;

            case 2:
                $proyeccion_preliminar = proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);

                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
                $doc_req_solic = documentos_requeridos_solicitud::find($solicitud_practica->id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();
                $sedes = DB::table('sedes_universidad')->get();
                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();

                $id_esp_aca = $proyeccion_preliminar->id_espacio_academico;
                $docentes_activos =DB::table('users')
                ->select('users.id',
                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->where('users.id_estado','=',1)
                ->where('users.id_role','=',5)
                ->where(function ($query) use($id_esp_aca){
                    $query->where('users.id_espacio_academico_1','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_2','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_3','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_4','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_5','=',$id_esp_aca)
                    ->orWhere('users.id_espacio_academico_6','=',$id_esp_aca);
                })->get();
                
                $num_docen_act = count($docentes_activos);
                if($num_docen_act == 0 || $docentes_activos == null)
                {
                    
                    $docentes_activos->id = 0;
                    $docentes_activos->full_name = 'No hay docentes activos';
                    $docentes_activos->push($docentes_activos);
                } 
                

                $estado_doc_respon =$usuario->id_estado;
        
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];

                /** Practicas integradas */
                    $docen_integ = [];
                    $d_int_espa_aca_1 = [];
                    $d_int_espa_aca_2 = [];
                    $d_int_espa_aca_3 = [];
                    $d_int_espa_aca_4 = [];
                    $d_int_espa_aca_5 = [];
                    $d_int_espa_aca_6 = [];
                    $d_int_espa_aca_7 = [];

                    if($practicas_integradas->id_docen_espa_aca_1 != null || $practicas_integradas->id_docen_espa_aca_1 > 0)
                    {
                        $d_1=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_1)->get();

                        foreach($d_1 as $d_1)
                        {
                            $d_int_espa_aca_1[] = ['id'=>$d_1->id,'full_name'=>$d_1->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_1[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_2 != null || $practicas_integradas->id_docen_espa_aca_2 > 0)
                    {
                        $d_2=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_2)->get();

                        foreach($d_2 as $d_2)
                        {
                            $d_int_espa_aca_2[] = ['id'=>$d_2->id,'full_name'=>$d_2->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_2[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_3 != null || $practicas_integradas->id_docen_espa_aca_3 > 0)
                    {
                        $d_3=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_3)->get();

                        foreach($d_3 as $d_3)
                        {
                            $d_int_espa_aca_3[] = ['id'=>$d_3->id,'full_name'=>$d_3->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_3[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_4 != null || $practicas_integradas->id_docen_espa_aca_4 > 0)
                    {
                        $d_4=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_4)->get();

                        foreach($d_4 as $d_4)
                        {
                            $d_int_espa_aca_4[] = ['id'=>$d_4->id,'full_name'=>$d_4->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_4[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_5 != null || $practicas_integradas->id_docen_espa_aca_5 > 0)
                    {
                    $d_5=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_5)->get();

                        foreach($d_5 as $d_5)
                        {
                            $d_int_espa_aca_5[] = ['id'=>$d_5->id,'full_name'=>$d_5->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_5[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_6 != null || $practicas_integradas->id_docen_espa_aca_6 > 0)
                    {
                        $d_6=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_6)->get();

                        foreach($d_6 as $d_6)
                        {
                            $d_int_espa_aca_6[] = ['id'=>$d_6->id,'full_name'=>$d_6->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_6[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_7 != null || $practicas_integradas->id_docen_espa_aca_7 > 0)
                    {
                        $d_7=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_7)->get();

                        foreach($d_7 as $d_7)
                        {
                            $d_int_espa_aca_7[] = ['id'=>$d_7->id,'full_name'=>$d_7->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_7[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }
                /** practicas integradas */

                $espa_aca_int = DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$practicas_integradas->id_espa_aca_1, $practicas_integradas->id_espa_aca_2, $practicas_integradas->id_espa_aca_3, 
                $practicas_integradas->id_espa_aca_4, $practicas_integradas->id_espa_aca_5, $practicas_integradas->id_espa_aca_6,
                $practicas_integradas->id_espa_aca_7])->get();
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "sedes"=>$sedes,
                                                "practicas_integradas"=>$practicas_integradas,
                                                "espa_aca_integradas"=>$espa_aca_int,
                                                "d_int_espa_aca_1"=>$d_int_espa_aca_1,
                                                "d_int_espa_aca_2"=>$d_int_espa_aca_2,
                                                "d_int_espa_aca_3"=>$d_int_espa_aca_3,
                                                "d_int_espa_aca_4"=>$d_int_espa_aca_4,
                                                "d_int_espa_aca_5"=>$d_int_espa_aca_5,
                                                "d_int_espa_aca_6"=>$d_int_espa_aca_6,
                                                "d_int_espa_aca_7"=>$d_int_espa_aca_7,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "docentes_activos"=>$docentes_activos,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "documentos_requeridos"=>$doc_req_solic,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);
            break;

            case 3:
                $proyeccion_preliminar = proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);

                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
                $doc_req_solic = documentos_requeridos_solicitud::find($solicitud_practica->id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                
                $sedes = DB::table('sedes_universidad')->get();
                $programa_academico = DB::table('programa_academico')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $all_esp_aca=DB::table('espacio_academico')->get();
                $all_prog_aca=$programa_academico;

                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];

                $docen_integ = [];
                $d_int_espa_aca_1 = [];
                $d_int_espa_aca_2 = [];
                $d_int_espa_aca_3 = [];
                $d_int_espa_aca_4 = [];
                $d_int_espa_aca_5 = [];
                $d_int_espa_aca_6 = [];
                $d_int_espa_aca_7 = [];

                if($practicas_integradas->id_docen_espa_aca_1 != null || $practicas_integradas->id_docen_espa_aca_1 > 0)
                {
                    $d_1=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_1)->get();

                    foreach($d_1 as $d_1)
                    {
                        $d_int_espa_aca_1[] = ['id'=>$d_1->id,'full_name'=>$d_1->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_1[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_2 != null || $practicas_integradas->id_docen_espa_aca_2 > 0)
                {
                    $d_2=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_2)->get();

                    foreach($d_2 as $d_2)
                    {
                        $d_int_espa_aca_2[] = ['id'=>$d_2->id,'full_name'=>$d_2->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_2[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_3 != null || $practicas_integradas->id_docen_espa_aca_3 > 0)
                {
                    $d_3=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_3)->get();

                    foreach($d_3 as $d_3)
                    {
                        $d_int_espa_aca_3[] = ['id'=>$d_3->id,'full_name'=>$d_3->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_3[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_4 != null || $practicas_integradas->id_docen_espa_aca_4 > 0)
                {
                    $d_4=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_4)->get();

                    foreach($d_4 as $d_4)
                    {
                        $d_int_espa_aca_4[] = ['id'=>$d_4->id,'full_name'=>$d_4->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_4[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_5 != null || $practicas_integradas->id_docen_espa_aca_5 > 0)
                {
                   $d_5=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_5)->get();

                    foreach($d_5 as $d_5)
                    {
                        $d_int_espa_aca_5[] = ['id'=>$d_5->id,'full_name'=>$d_5->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_5[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_6 != null || $practicas_integradas->id_docen_espa_aca_6 > 0)
                {
                    $d_6=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_6)->get();

                    foreach($d_6 as $d_6)
                    {
                        $d_int_espa_aca_6[] = ['id'=>$d_6->id,'full_name'=>$d_6->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_6[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_7 != null || $practicas_integradas->id_docen_espa_aca_7 > 0)
                {
                    $d_7=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_7)->get();

                    foreach($d_7 as $d_7)
                    {
                        $d_int_espa_aca_7[] = ['id'=>$d_7->id,'full_name'=>$d_7->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_7[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                $espa_aca_int = DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$practicas_integradas->id_espa_aca_1, $practicas_integradas->id_espa_aca_2, $practicas_integradas->id_espa_aca_3, 
                $practicas_integradas->id_espa_aca_4, $practicas_integradas->id_espa_aca_5, $practicas_integradas->id_espa_aca_6,
                $practicas_integradas->id_espa_aca_7])->get();
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }

                $estado_doc_respon =$usuario->id_estado;
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "practicas_integradas"=>$practicas_integradas,
                                                "sedes"=>$sedes,
                                                "espa_aca_integradas"=>$espa_aca_int,
                                                "d_int_espa_aca_1"=>$d_int_espa_aca_1,
                                                "d_int_espa_aca_2"=>$d_int_espa_aca_2,
                                                "d_int_espa_aca_3"=>$d_int_espa_aca_3,
                                                "d_int_espa_aca_4"=>$d_int_espa_aca_4,
                                                "d_int_espa_aca_5"=>$d_int_espa_aca_5,
                                                "d_int_espa_aca_6"=>$d_int_espa_aca_6,
                                                "d_int_espa_aca_7"=>$d_int_espa_aca_7,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "all_programas_aca"=>$all_prog_aca,
                                                "all_espacios_aca"=>$all_esp_aca,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "documentos_requeridos"=>$doc_req_solic,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);
            break;

            case 4:
                $proyeccion_preliminar = proyeccion::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                
                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();

                $doc_req_solic = documentos_requeridos_solicitud::find($solicitud_practica->id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                $idUser_log = Auth::user()->id;
                $usuario_log=DB::table('users')
                ->where('id','=',$idUser_log)->first();

                $usuario_respon=DB::table('users')
                ->where('id','=',$idUser)->first();

                $sedes = DB::table('sedes_universidad')->get();
                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario_respon->id_espacio_academico_1, $usuario_respon->id_espacio_academico_2, $usuario_respon->id_espacio_academico_3, 
                $usuario_respon->id_espacio_academico_4, $usuario_respon->id_espacio_academico_5, $usuario_respon->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
        
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];

                /**integradas */
                    $docen_integ = [];
                    $d_int_espa_aca_1 = [];
                    $d_int_espa_aca_2 = [];
                    $d_int_espa_aca_3 = [];
                    $d_int_espa_aca_4 = [];
                    $d_int_espa_aca_5 = [];
                    $d_int_espa_aca_6 = [];
                    $d_int_espa_aca_7 = [];

                    if($practicas_integradas->id_docen_espa_aca_1 != null || $practicas_integradas->id_docen_espa_aca_1 > 0)
                    {
                        $d_1=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_1)->get();

                        foreach($d_1 as $d_1)
                        {
                            $d_int_espa_aca_1[] = ['id'=>$d_1->id,'full_name'=>$d_1->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_1[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_2 != null || $practicas_integradas->id_docen_espa_aca_2 > 0)
                    {
                        $d_2=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_2)->get();

                        foreach($d_2 as $d_2)
                        {
                            $d_int_espa_aca_2[] = ['id'=>$d_2->id,'full_name'=>$d_2->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_2[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_3 != null || $practicas_integradas->id_docen_espa_aca_3 > 0)
                    {
                        $d_3=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_3)->get();

                        foreach($d_3 as $d_3)
                        {
                            $d_int_espa_aca_3[] = ['id'=>$d_3->id,'full_name'=>$d_3->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_3[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_4 != null || $practicas_integradas->id_docen_espa_aca_4 > 0)
                    {
                        $d_4=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_4)->get();

                        foreach($d_4 as $d_4)
                        {
                            $d_int_espa_aca_4[] = ['id'=>$d_4->id,'full_name'=>$d_4->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_4[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_5 != null || $practicas_integradas->id_docen_espa_aca_5 > 0)
                    {
                    $d_5=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_5)->get();

                        foreach($d_5 as $d_5)
                        {
                            $d_int_espa_aca_5[] = ['id'=>$d_5->id,'full_name'=>$d_5->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_5[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_6 != null || $practicas_integradas->id_docen_espa_aca_6 > 0)
                    {
                        $d_6=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_6)->get();

                        foreach($d_6 as $d_6)
                        {
                            $d_int_espa_aca_6[] = ['id'=>$d_6->id,'full_name'=>$d_6->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_6[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_7 != null || $practicas_integradas->id_docen_espa_aca_7 > 0)
                    {
                        $d_7=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_7)->get();

                        foreach($d_7 as $d_7)
                        {
                            $d_int_espa_aca_7[] = ['id'=>$d_7->id,'full_name'=>$d_7->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_7[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }
                /**integradas */

                $espa_aca_int = DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$practicas_integradas->id_espa_aca_1, $practicas_integradas->id_espa_aca_2, $practicas_integradas->id_espa_aca_3, 
                $practicas_integradas->id_espa_aca_4, $practicas_integradas->id_espa_aca_5, $practicas_integradas->id_espa_aca_6,
                $practicas_integradas->id_espa_aca_7])->get();
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }
                
                $estado_doc_respon =$usuario_respon->id_estado;

                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario_log->primer_nombre.' '.$usuario_log->segundo_nombre.' '.$usuario_log->primer_apellido.' '.$usuario_log->segundo_apellido;
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;
                
                $presupuesto_programa_academico= DB::table('presupuesto_programa_academico')
                ->where('id_programa_academico',$proyeccion_preliminar->id_programa_academico)->first();
                $presupuesto_practica= 0;
                if($solicitud_practica->tipo_ruta == 1){
                    $presupuesto_practica=$costos_proyeccion->viaticos_docente_rp + $costos_proyeccion->viaticos_estudiantes_rp + $costos_proyeccion->vlr_guias_baquianos_rp +
                                        $costos_proyeccion->vlr_materiales_rp + $costos_proyeccion->vlr_otros_boletas_rp + $costos_proyeccion->costo_total_transporte_menor_rp;
                }else if($solicitud_practica->tipo_ruta == 2){
                    $presupuesto_practica=$costos_proyeccion->viaticos_docente_ra + $costos_proyeccion->viaticos_estudiantes_ra + $costos_proyeccion->vlr_guias_baquianos_ra +
                                        $costos_proyeccion->vlr_materiales_ra + $costos_proyeccion->vlr_otros_boletas_ra + $costos_proyeccion->costo_total_transporte_menor_ra;
                }
                
                $presupuesto_restante=$presupuesto_programa_academico->presupuesto_actual - $presupuesto_practica;
                $lista_estudiantes = DB::table('estudiantes_solicitud_practica')->where('id_solicitud_practica',$solicitud_practica->id)->get();

                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "espa_aca_integradas"=>$espa_aca_int,
                                                "d_int_espa_aca_1"=>$d_int_espa_aca_1,
                                                "d_int_espa_aca_2"=>$d_int_espa_aca_2,
                                                "d_int_espa_aca_3"=>$d_int_espa_aca_3,
                                                "d_int_espa_aca_4"=>$d_int_espa_aca_4,
                                                "d_int_espa_aca_5"=>$d_int_espa_aca_5,
                                                "d_int_espa_aca_6"=>$d_int_espa_aca_6,
                                                "d_int_espa_aca_7"=>$d_int_espa_aca_7,
                                                "sedes"=>$sedes,
                                                "practicas_integradas"=>$practicas_integradas,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "usuario_log"=>$usuario_log,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "documentos_requeridos"=>$doc_req_solic,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario_log,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'presupuesto_programa_academico'=>$presupuesto_programa_academico,
                                                'presupuesto_practica'=>$presupuesto_practica,
                                                'presupuesto_restante'=>$presupuesto_restante,
                                                'lista_estudiantes'=>$lista_estudiantes
        
                ]);
            break;

            case 5:
                $proyeccion_preliminar = proyeccion::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();

                $documentos_practica = documentos_requeridos_solicitud::find($solicitud_practica->id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $sedes = DB::table('sedes_universidad')->get();
                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];
                /** integradas */
                    $docen_integ = [];
                    $d_int_espa_aca_1 = [];
                    $d_int_espa_aca_2 = [];
                    $d_int_espa_aca_3 = [];
                    $d_int_espa_aca_4 = [];
                    $d_int_espa_aca_5 = [];
                    $d_int_espa_aca_6 = [];
                    $d_int_espa_aca_7 = [];
                
                    if($practicas_integradas->id_docen_espa_aca_1 != null || $practicas_integradas->id_docen_espa_aca_1 > 0)
                    {
                        $d_1=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_1)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_1)->get();

                        foreach($d_1 as $d_1)
                        {
                            $d_int_espa_aca_1[] = ['id'=>$d_1->id,'full_name'=>$d_1->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_1[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_2 != null || $practicas_integradas->id_docen_espa_aca_2 > 0)
                    {
                        $d_2=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_2)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_2)->get();

                        foreach($d_2 as $d_2)
                        {
                            $d_int_espa_aca_2[] = ['id'=>$d_2->id,'full_name'=>$d_2->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_2[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_3 != null || $practicas_integradas->id_docen_espa_aca_3 > 0)
                    {
                        $d_3=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_3)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_3)->get();

                        foreach($d_3 as $d_3)
                        {
                            $d_int_espa_aca_3[] = ['id'=>$d_3->id,'full_name'=>$d_3->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_3[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_4 != null || $practicas_integradas->id_docen_espa_aca_4 > 0)
                    {
                        $d_4=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_4)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_4)->get();

                        foreach($d_4 as $d_4)
                        {
                            $d_int_espa_aca_4[] = ['id'=>$d_4->id,'full_name'=>$d_4->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_4[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_5 != null || $practicas_integradas->id_docen_espa_aca_5 > 0)
                    {
                    $d_5=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_5)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_5)->get();

                        foreach($d_5 as $d_5)
                        {
                            $d_int_espa_aca_5[] = ['id'=>$d_5->id,'full_name'=>$d_5->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_5[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_6 != null || $practicas_integradas->id_docen_espa_aca_6 > 0)
                    {
                        $d_6=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_6)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_6)->get();

                        foreach($d_6 as $d_6)
                        {
                            $d_int_espa_aca_6[] = ['id'=>$d_6->id,'full_name'=>$d_6->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_6[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }

                    if($practicas_integradas->id_docen_espa_aca_7 != null || $practicas_integradas->id_docen_espa_aca_7 > 0)
                    {
                        $d_7=DB::table('users')
                            ->select('users.id',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_7)
                            ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_7)->get();

                        foreach($d_7 as $d_7)
                        {
                            $d_int_espa_aca_7[] = ['id'=>$d_7->id,'full_name'=>$d_7->full_name];
                        }
                    }
                    else{
                        $d_int_espa_aca_7[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                    }
                /** integradas */

                $espa_aca_int = DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$practicas_integradas->id_espa_aca_1, $practicas_integradas->id_espa_aca_2, $practicas_integradas->id_espa_aca_3, 
                $practicas_integradas->id_espa_aca_4, $practicas_integradas->id_espa_aca_5, $practicas_integradas->id_espa_aca_6,
                $practicas_integradas->id_espa_aca_7])->get();
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }

                $estado_doc_respon =$usuario->id_estado;
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "practicas_integradas"=>$practicas_integradas,
                                                "espa_aca_integradas"=>$espa_aca_int,
                                                "d_int_espa_aca_1"=>$d_int_espa_aca_1,
                                                "d_int_espa_aca_2"=>$d_int_espa_aca_2,
                                                "d_int_espa_aca_3"=>$d_int_espa_aca_3,
                                                "d_int_espa_aca_4"=>$d_int_espa_aca_4,
                                                "d_int_espa_aca_5"=>$d_int_espa_aca_5,
                                                "d_int_espa_aca_6"=>$d_int_espa_aca_6,
                                                "d_int_espa_aca_7"=>$d_int_espa_aca_7,
                                                "sedes"=>$sedes,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "documentos_requeridos"=>$documentos_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);
            break;

            case 7:
                $proyeccion_preliminar = proyeccion::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
                $idUser_resp = $proyeccion_preliminar->id_docente_responsable;
                $idUser = Auth::user()->id;
                $usuario_resp=DB::table('users')
                ->where('id','=',$idUser_resp)->first();
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario_resp->id_espacio_academico_1, $usuario_resp->id_espacio_academico_2, $usuario_resp->id_espacio_academico_3, 
                $usuario_resp->id_espacio_academico_4, $usuario_resp->id_espacio_academico_5, $usuario_resp->id_espacio_academico_6])->get();
                $sedes=DB::table('sedes_universidad')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }

                $estado_doc_respon =$usuario_resp->id_estado;
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario_resp->primer_nombre.' '.$usuario_resp->segundo_nombre.' '.$usuario_resp->primer_apellido.' '.$usuario_resp->segundo_apellido;

                $solicitud_transporte=DB::table('solicitud_transporte as sol_trans')
                                            ->where('sol_trans.id',$solicitud_practica->id)
                                            ->first();
        
                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "sedes"=>$sedes,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario_resp"=>$usuario_resp,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'solicitud_transporte'=>$solicitud_transporte,
        
                ]);
            break;

            default;
        }
    }

    /**
     * Actualización de solicitud
     *
     * @param  int  $id
     * @param  int  $tipo_ruta
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $tipo_ruta)
    {
        $id = Crypt::decrypt($id);
        $tipo_ruta = Crypt::decrypt($tipo_ruta);
        $control_sistema =DB::table('control_sistema')->first();
        $mytime = Carbon::now('America/Bogota');
        $sistema = DB::table('control_sistema')->first();
        $proyeccion_preliminar = proyeccion::where('id', '=', $id)->first();
        $transporte_proyeccion = transporte_proyeccion::where('id','=',$id)->first();
        $transporte_menor = transporte_menor::where('id','=',$id)->first();
        $costos_proyeccion = costos_proyeccion::where('id','=',$id)->first();
        $solicitud_practica = solicitud::where('id_proyeccion_preliminar', '=', $id)->first();
        $mater_herra_proyeccion = materiales_herramientas_proyeccion::where('id', '=', $id)->first();
        $docentes_practica = docentes_practica::where('id','=',$id)->first();
        $riesg_amen_practica = riesgos_amenazas_practica::where('id','=',$id)->first();
        $doc_req_solicitud = documentos_requeridos_solicitud::where('id','=',$solicitud_practica->id)->first();
        $solicitud_transp = new solicitud_transporte;
        $encuesta_transporte = new encuesta_transporte;
        $idUser_log = Auth::user()->id;
        $usuario_log=DB::table('users')
                ->where('id','=',$idUser_log)->first();

        $vlr_estud_max= $sistema->vlr_estud_max;
        $vlr_estud_min= $sistema->vlr_estud_min;
        $vlr_docen_max= $sistema->vlr_docen_max;
        $vlr_docen_min= $sistema->vlr_docen_min;
		
		$practicas_integradas = practicas_integradas::where('id','=',$id)->first();
        $programa_academico = DB::table('programa_academico')
        ->where('id',$proyeccion_preliminar->id_programa_academico)->first();

        $presupuesto_programa_academico = presupuesto_programa_academico::where('id_programa_academico','=',$proyeccion_preliminar->id_programa_academico)->first();

        if(Auth::user()->id_role == 1 ||  Auth::user()->id_role == 4 || Auth::user()->id_role == 5)
        {
            if(Auth::user()->id_role == 1)
            {
                $esp_aca = DB::table('espacio_academico as esp_aca')
                ->where('esp_aca.id_programa_academico','=',$proyeccion_preliminar->id_programa_academico)
                ->where('esp_aca.codigo_espacio_academico','=',$proyeccion_preliminar->id_espacio_academico)->first();
                $proyeccion_preliminar->id_espacio_academico=(!empty($esp_aca)||null)?
                $esp_aca->id:$proyeccion_preliminar->id_espacio_academico;
            
            }

            if(Auth::user()->id == $proyeccion_preliminar->id_docente_responsable || Auth::user()->id_role == 1)
            {
                $num_estudiantes = $request->get('num_estudiantes_aprox');
                //$total_docentes_apoyo = $request->get('total_docentes_apoyo');
                $total_docentes_apoyo = $docentes_practica->total_docentes_apoyo;
                $num_acompa_apoyo = $request->get('num_apoyo');
				$num_doc_pract_int = $practicas_integradas->cant_espa_aca;
                $total_docentes = $num_doc_pract_int + $total_docentes_apoyo + 1;
                $proyeccion_preliminar->num_estudiantes_aprox = $num_estudiantes;
                $solicitud_practica->num_estudiantes= $num_estudiantes;
                $solicitud_practica->total_docentes_apoyo= $total_docentes_apoyo;
                $solicitud_practica->num_acompaniantes_apoyo= $num_acompa_apoyo;
                $proyeccion_preliminar->cantidad_grupos=$request->get('cant_grupos');
                $proyeccion_preliminar->grupo_1=$request->get('grupo_1');
                $proyeccion_preliminar->grupo_2=$request->get('grupo_2');
                $proyeccion_preliminar->grupo_3=$request->get('grupo_3');
                $proyeccion_preliminar->grupo_4=$request->get('grupo_4');

                /**Tabla docentes_practica */
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('doc_apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=$request->get('doc_apoyo_4');
                    $docentes_practica->num_doc_docente_apoyo_5=$request->get('doc_apoyo_5');
                    $docentes_practica->num_doc_docente_apoyo_6=$request->get('doc_apoyo_6');
                    $docentes_practica->num_doc_docente_apoyo_7=$request->get('doc_apoyo_7');
                    $docentes_practica->num_doc_docente_apoyo_8=$request->get('doc_apoyo_8');
                    $docentes_practica->num_doc_docente_apoyo_9=$request->get('doc_apoyo_9');
                    $docentes_practica->num_doc_docente_apoyo_10=$request->get('doc_apoyo_10');
                    $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->docente_apoyo_4=$request->get('apoyo_4');
                    $docentes_practica->docente_apoyo_5=$request->get('apoyo_5');
                    $docentes_practica->docente_apoyo_6=$request->get('apoyo_6');
                    $docentes_practica->docente_apoyo_7=$request->get('apoyo_7');
                    $docentes_practica->docente_apoyo_8=$request->get('apoyo_8');
                    $docentes_practica->docente_apoyo_9=$request->get('apoyo_9');
                    $docentes_practica->docente_apoyo_10=$request->get('apoyo_10');
                /**Tabla docentes_practica */

                /**Tabla documentos_requeridos */
                    $solicitud_practica->cronograma = $request->get('cronograma');
                    $solicitud_practica->observaciones = $request->get('observaciones');
                    $solicitud_practica->justificacion = $request->get('justificacion');
                    $solicitud_practica->objetivo_general = $request->get('objetivo_general');
                    $solicitud_practica->metodologia_evaluacion = $request->get('metodologia_evaluacion');

                    // $doc_req_solicitud->id = $solicitud_practica->id;
                    $doc_req_solicitud->seguro_estudiantil=1;
                    $doc_req_solicitud->documento_identificacion=1;
                    $doc_req_solicitud->documento_rh=1;
                    $doc_req_solicitud->certificado_eps=1;
                    $doc_req_solicitud->permiso_acudiente=0;
                    $doc_req_solicitud->vacuna_fiebre_amarilla=$request->get('vacuna_fiebre_amarilla')=="on"?1:0;
                    $doc_req_solicitud->vacuna_tetanos=$request->get('vacuna_tetanos')=="on"?1:0;
                    $doc_req_solicitud->certificado_natacion=$request->get('certificado_natacion')=="on"?1:0;
                    $doc_req_solicitud->certificado_adicional_1=$request->get('certificado_adicional_1')=="on"?1:0;
                    $doc_req_solicitud->certificado_adicional_2=$request->get('certificado_adicional_2')=="on"?1:0;
                    $doc_req_solicitud->certificado_adicional_3=$request->get('certificado_adicional_3')=="on"?1:0;
                    $doc_req_solicitud->detalle_certificado_adcional_1=$request->get('det_certif_adicional_1');
                    $doc_req_solicitud->detalle_certificado_adcional_2=$request->get('det_certif_adicional_2');
                    $doc_req_solicitud->detalle_certificado_adcional_3=$request->get('det_certif_adicional_3');
                /**Tabla documentos_requeridos */

                /**Ruta Principal */
                    if($tipo_ruta == 1)
                    {
                        $solicitud_practica->tipo_ruta=1;
                        $proyeccion_preliminar->fecha_salida_aprox_rp= $request->get('fecha_salida_aprox_rp');
                        $solicitud_practica->fecha_salida= $request->get('fecha_salida_aprox_rp');
                        $solicitud_practica->hora_salida= $request->get('hora_salida_rp');
                        $proyeccion_preliminar->fecha_regreso_aprox_rp= $request->get('fecha_regreso_aprox_rp');
                        $solicitud_practica->fecha_regreso= $request->get('fecha_regreso_aprox_rp');
                        
                    
                        $fecha_salida_rp = new DateTime($solicitud_practica->fecha_salida);
                        $fecha_regreso_rp = new DateTime($solicitud_practica->fecha_regreso);
                        $num_dias_rp = $fecha_salida_rp->diff($fecha_regreso_rp);
                        $num_dias_rp = $num_dias_rp->days+1;
                        $solicitud_practica->duracion_num_dias= $num_dias_rp;
                        $proyeccion_preliminar->duracion_num_dias_rp= $num_dias_rp;
                        $solicitud_practica->hora_salida= $request->get('hora_salida_rp');                                    
                        $solicitud_practica->hora_regreso= $request->get('hora_regreso_rp'); 

                        $proyeccion_preliminar->lugar_salida_rp= $request->get('lugar_salida_rp');
                        $proyeccion_preliminar->lugar_regreso_rp= $request->get('lugar_regreso_rp');
                        $solicitud_practica->lugar_salida= $request->get('lugar_salida_rp');
                        $solicitud_practica->lugar_regreso= $request->get('lugar_regreso_rp');

                    
                        /**Tabla transporte_proyeccion RP*/
                            $transporte_proyeccion->cant_transporte_rp=$request->get('cant_transporte_rp_edit');
                        
                            $tipo_transporte_rp = $request->get('id_tipo_transporte_rp_');
                            $det_tipo_transporte_rp = $request->get('det_tipo_transporte_rp_');
                            $capacid_transporte_rp = $request->get('capac_transporte_rp_');
                        
                            $transporte_proyeccion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_proyeccion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??NULL;
                            $transporte_proyeccion->id_tipo_transporte_rp_3 =$tipo_transporte_rp[2]??NULL;
                        
                            $transporte_proyeccion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_proyeccion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??NULL;
                            $transporte_proyeccion->det_tipo_transporte_rp_3=$det_tipo_transporte_rp[2]??NULL;
                        
                            $transporte_proyeccion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_proyeccion->capac_transporte_rp_2=$capacid_transporte_rp[1]??NULL;
                            $transporte_proyeccion->capac_transporte_rp_3=$capacid_transporte_rp[2]??NULL;
                        
                            $transporte_proyeccion->docen_respo_trasnporte_rp=$request->get('docente_resp_transp_rp');
                        
                            $transporte_proyeccion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_proyeccion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==NULL?NULL:intval($request->get('exclusiv_tiempo_rp_2'));
                            $transporte_proyeccion->exclusiv_tiempo_rp_3=$request->get('exclusiv_tiempo_rp_3')==NULL?NULL:intval($request->get('exclusiv_tiempo_rp_3'));
                        /**Tabla transporte_proyeccion RP*/

                        /**Tabla transporte_menor */
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->cant_trans_menor_rp=$request->get('cant_trans_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                            $transporte_menor->trans_menor_rp_3=$request->get('trans_menor_rp_3');
                            $transporte_menor->trans_menor_rp_4=$request->get('trans_menor_rp_4');
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                            $transporte_menor->vlr_trans_menor_rp_3=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_3')));
                            $transporte_menor->vlr_trans_menor_rp_4=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_4')));

                            $vlr_trans_menor_rp_1=$transporte_menor->vlr_trans_menor_rp_1;
                            $vlr_trans_menor_rp_2=$transporte_menor->vlr_trans_menor_rp_2;
                            $vlr_trans_menor_rp_3=$transporte_menor->vlr_trans_menor_rp_3;
                            $vlr_trans_menor_rp_4=$transporte_menor->vlr_trans_menor_rp_4;

                        /**Tabla transporte_menor */
                                    
                        /**Tabla costos_proyeccion RP*/
                            $vlr_materiales_rp=str_replace(".","",$request->get('vlr_materiales_rp'));
                            $vlr_materiales_rp=intval(str_replace("$","", $vlr_materiales_rp));
                            $vlr_guias_baquianos_rp=str_replace(".","",$request->get('vlr_guias_baquia_rp'));
                            $vlr_guias_baquianos_rp=intval(str_replace("$","", $vlr_guias_baquianos_rp));
                            $vlr_otros_boletas_rp=str_replace(".","",$request->get('vlr_otros_bolet_rp'));
                            $vlr_otros_boletas_rp=intval(str_replace("$","", $vlr_otros_boletas_rp));
                        
                            if($num_dias_rp==1)
                            {
                                $viaticos_estudiantes_rp = $num_estudiantes*$vlr_estud_min*$num_dias_rp;
                                $viaticos_docente_rp = $vlr_docen_min;
                            }
                            else if($num_dias_rp>1)
                            {
                                $viaticos_estudiantes_rp = $num_estudiantes*$vlr_estud_max*$num_dias_rp;
                                $viaticos_docente_rp = ($num_dias_rp-0.5)*$vlr_docen_max*$total_docentes;
                            }
                            if($programa_academico->pregrado == 0){
								$viaticos_estudiantes_rp=0;
							} 
                            if($proyeccion_preliminar->realizada_bogota_rp == 1 && $num_dias_rp == 1){
                                $viaticos_estudiantes_rp = 0;
                                $viaticos_docente_rp = 0;
                            }       

                            $costo_total_transporte_menor_rp=$costos_proyeccion->costo_total_transporte_menor_rp;
                            $valor_estimado_transporte_rp=$costos_proyeccion->valor_estimado_transporte_rp;
                        
                            $nuevo_costo_total_transporte_menor_rp = $vlr_trans_menor_rp_1 + $vlr_trans_menor_rp_2 + $vlr_trans_menor_rp_3 + $vlr_trans_menor_rp_4;

                            $total_presupuesto_sin_transporte_menor_rp = $costos_proyeccion->total_presupuesto_rp - $costo_total_transporte_menor_rp; 
                        
                            $costos_proyeccion->costo_total_transporte_menor_rp = $nuevo_costo_total_transporte_menor_rp;
                            $costos_proyeccion->total_presupuesto_rp = $nuevo_costo_total_transporte_menor_rp + $total_presupuesto_sin_transporte_menor_rp;
                        
                            $costos_proyeccion->vlr_materiales_rp=$vlr_materiales_rp;
                            $costos_proyeccion->vlr_guias_baquianos_rp=$vlr_guias_baquianos_rp;
                            $costos_proyeccion->vlr_otros_boletas_rp=$vlr_otros_boletas_rp;
                            $costos_proyeccion->viaticos_estudiantes_rp=$viaticos_estudiantes_rp;
                            $costos_proyeccion->viaticos_docente_rp=$viaticos_docente_rp;
                            $costos_proyeccion->total_presupuesto_rp=$vlr_materiales_rp+$viaticos_estudiantes_rp+$viaticos_docente_rp+$nuevo_costo_total_transporte_menor_rp;
                        /**Tabla costos_proyeccion RP*/
                            
                        /**Tabla riesgos_amenazas_proyeccion RP*/
                            $riesg_amen_practica->areas_acuaticas_rp=$request->get('areas_acuaticas_rp')=='on'?1:0;
                            $riesg_amen_practica->alturas_rp=$request->get('alturas_rp')=='on'?1:0;
                            $riesg_amen_practica->riesgo_biologico_rp=$request->get('riesgo_biologico_rp')=='on'?1:0;
                            $riesg_amen_practica->espacios_confinados_rp=$request->get('espacios_confinados_rp')=='on'?1:0;
                        /**Tabla riesgos_amenazas_proyeccion RP*/
                    
                        /**Tabla materiales_herramientas_proyeccion */
                            $mater_herra_proyeccion->det_materiales_rp=$request->get('det_materiales_rp');
                            $mater_herra_proyeccion->det_guias_baquianos_rp=$request->get('det_guias_baquia_rp');
                            $mater_herra_proyeccion->det_otros_boletas_rp=$request->get('det_otros_bolet_rp');
                            
                        /**Tabla materiales_herramientas_proyeccion */              
                                
                    }
                /**Ruta Principal */

                /**Ruta Alterna */
                    else if($tipo_ruta == 2)
                    {
                        $solicitud_practica->tipo_ruta=2;
                        $proyeccion_preliminar->fecha_salida_aprox_ra= $request->get('fecha_salida_aprox_ra');
                        $solicitud_practica->fecha_salida= $request->get('fecha_salida_aprox_ra');
                        $solicitud_practica->hora_salida= $request->get('hora_salida_ra');
                        $proyeccion_preliminar->fecha_regreso_aprox_ra= $request->get('fecha_regreso_aprox_ra');
                        $solicitud_practica->fecha_regreso= $request->get('fecha_regreso_aprox_ra');
        
                        $fecha_salida_ra = new DateTime($solicitud_practica->fecha_salida);
                        $fecha_regreso_ra = new DateTime($solicitud_practica->fecha_regreso);
                        $num_dias_ra = $fecha_salida_ra->diff($fecha_regreso_ra);
                        $num_dias_ra = $num_dias_ra->days+1;
                        $solicitud_practica->duracion_num_dias= $num_dias_ra;
                        $proyeccion_preliminar->duracion_num_dias_ra= $num_dias_ra;                                  
                        $solicitud_practica->hora_salida= $request->get('hora_salida_ra');                                    
                        $solicitud_practica->hora_regreso= $request->get('hora_regreso_ra');   
                        
                        $proyeccion_preliminar->lugar_salida_ra= $request->get('lugar_salida_ra');
                        $proyeccion_preliminar->lugar_regreso_ra= $request->get('lugar_regreso_ra');
                        $solicitud_practica->lugar_salida= $request->get('lugar_salida_ra');
                        $solicitud_practica->lugar_regreso= $request->get('lugar_regreso_ra');
                    
                        /**Tabla transporte_proyeccion RA*/
                            $transporte_proyeccion->cant_transporte_ra=$request->get('cant_transporte_ra_edit');
                            // $docen_respo_trasnporte_ra = 

                            $tipo_transporte_ra = $request->get('id_tipo_transporte_ra_');
                            $det_tipo_transporte_ra = $request->get('det_tipo_transporte_ra_');
                            $capacid_transporte_ra = $request->get('capac_transporte_ra_');

                            $transporte_proyeccion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_proyeccion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??NULL;
                            $transporte_proyeccion->id_tipo_transporte_ra_3 =$tipo_transporte_ra[2]??NULL;

                            $transporte_proyeccion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_proyeccion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??NULL;
                            $transporte_proyeccion->det_tipo_transporte_ra_3=$det_tipo_transporte_ra[2]??NULL;

                            $transporte_proyeccion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_proyeccion->capac_transporte_ra_2=$capacid_transporte_ra[1]??NULL;
                            $transporte_proyeccion->capac_transporte_ra_3=$capacid_transporte_ra[2]??NULL;

                            $transporte_proyeccion->docen_respo_trasnporte_ra=$request->get('docente_resp_transp_ra');

                            $transporte_proyeccion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_proyeccion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==NULL?NULL:intval($request->get('exclusiv_tiempo_ra_2'));
                            $transporte_proyeccion->exclusiv_tiempo_ra_3=$request->get('exclusiv_tiempo_ra_3')==NULL?NULL:intval($request->get('exclusiv_tiempo_ra_3'));
                        /**Tabla transporte_proyeccion RA*/        
                        
                        /**Tabla transporte_menor */
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->cant_trans_menor_ra=$request->get('cant_trans_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                            $transporte_menor->trans_menor_ra_3=$request->get('trans_menor_ra_3');
                            $transporte_menor->trans_menor_ra_4=$request->get('trans_menor_ra_4');
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                            $transporte_menor->vlr_trans_menor_ra_3=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_3')));
                            $transporte_menor->vlr_trans_menor_ra_4=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_4')));

                            $vlr_trans_menor_ra_1=$transporte_menor->vlr_trans_menor_ra_1;
                            $vlr_trans_menor_ra_2=$transporte_menor->vlr_trans_menor_ra_2;
                            $vlr_trans_menor_ra_3=$transporte_menor->vlr_trans_menor_ra_3;
                            $vlr_trans_menor_ra_4=$transporte_menor->vlr_trans_menor_ra_4;

                        /**Tabla transporte_menor */
                    
                        /**Tabla costos_proyeccion RA*/
                            $vlr_materiales_ra=str_replace(".","",$request->get('vlr_materiales_ra'));
                            $vlr_materiales_ra=intval(str_replace("$","",$vlr_materiales_ra));
                            $vlr_guias_baquianos_ra=str_replace(".","",$request->get('vlr_guias_baquia_ra'));
                            $vlr_guias_baquianos_ra=intval(str_replace("$","", $vlr_guias_baquianos_ra));
                            $vlr_otros_boletas_ra=str_replace(".","",$request->get('vlr_otros_bolet_ra'));
                            $vlr_otros_boletas_ra=intval(str_replace("$","", $vlr_otros_boletas_ra));

                            if($num_dias_ra==1)
                            {
                                $viaticos_estudiantes_ra = $num_estudiantes*$vlr_estud_min*$num_dias_ra;
                                $viaticos_docente_ra = $vlr_docen_min;
                            }
                            else if($num_dias_ra>1)
                            {
                                $viaticos_estudiantes_ra = $num_estudiantes*$vlr_estud_max*$num_dias_ra;
                                $viaticos_docente_ra = ($num_dias_ra-0.5)*$vlr_docen_max*$total_docentes;
                            }
                            if($programa_academico->pregrado == 0){
								$viaticos_estudiantes_ra=0;
							}  
                            if($proyeccion_preliminar->realizada_bogota_ra == 1 && $num_dias_ra == 1){
                                $viaticos_estudiantes_ra = 0;
                                $viaticos_docente_ra = 0;
                            }
                            
                            $costo_total_transporte_menor_ra=$costos_proyeccion->costo_total_transporte_menor_ra;
                            $valor_estimado_transporte_ra=$costos_proyeccion->valor_estimado_transporte_ra;
                            
                            $nuevo_costo_total_transporte_menor_ra = $vlr_trans_menor_ra_1 + $vlr_trans_menor_ra_2 + $vlr_trans_menor_ra_3 + $vlr_trans_menor_ra_4;

                            $total_presupuesto_sin_transporte_menor_ra = $costos_proyeccion->total_presupuesto_ra - $costo_total_transporte_menor_ra; 

                            $costos_proyeccion->costo_total_transporte_menor_ra = $nuevo_costo_total_transporte_menor_ra;
                            $costos_proyeccion->total_presupuesto_ra = $nuevo_costo_total_transporte_menor_ra + $total_presupuesto_sin_transporte_menor_ra;

                            $costos_proyeccion->vlr_materiales_ra=$vlr_materiales_ra;
                            $costos_proyeccion->vlr_guias_baquianos_ra=$vlr_guias_baquianos_ra;
                            $costos_proyeccion->vlr_otros_boletas_ra=$vlr_otros_boletas_ra;
                            $costos_proyeccion->viaticos_estudiantes_ra=$viaticos_estudiantes_ra;
                            $costos_proyeccion->viaticos_docente_ra=$viaticos_docente_ra;
                            $costos_proyeccion->total_presupuesto_ra=$vlr_materiales_ra+$viaticos_estudiantes_ra+$viaticos_docente_ra+$costo_total_transporte_menor_ra+$nuevo_costo_total_transporte_menor_ra;
                        /**Tabla costos_proyeccion RA*/                                
                    
                        /**Tabla riesgos_amenazas_proyeccion RA*/
                            $riesg_amen_practica->areas_acuaticas_ra=$request->get('areas_acuaticas_ra')=='on'?1:0;
                            $riesg_amen_practica->alturas_ra=$request->get('alturas_ra')=='on'?1:0;
                            $riesg_amen_practica->riesgo_biologico_ra=$request->get('riesgo_biologico_ra')=='on'?1:0;
                            $riesg_amen_practica->espacios_confinados_ra=$request->get('espacios_confinados_ra')=='on'?1:0;
                        /**Tabla riesgos_amenazas_proyeccion RA*/
                    
                        /**Tabla materiales_herramientas_proyeccion */
                        
                            $mater_herra_proyeccion->det_materiales_ra=$request->get('det_materiales_ra');
                            $mater_herra_proyeccion->det_guias_baquianos_ra=$request->get('det_guias_baquia_ra');
                            $mater_herra_proyeccion->det_otros_boletas_ra=$request->get('det_otros_bolet_ra');
                                
                        /**Tabla materiales_herramientas_proyeccion */
                                    
                    }
                /**Ruta Alterna */

                if($solicitud_practica->aprobacion_coordinador == 4)
                {
                    $solicitud_practica->confirm_docente=1;
                    $solicitud_practica->aprobacion_coordinador=5;
                    
                }

                // $docs=documentos_requeridos_solicitud::where('id','=',$id)->first();
                // $docs=$doc_req_solicitud;

                // if(Auth::user()->id == $proyeccion_preliminar->id_docente_responsable)
                // {
                    
                //     if(empty($docs) || $docs == NULL)
                //     {
                //         $doc_req_solicitud->save();
                //     }
                //     else{
                //         $docs->update();
                //     }
                // }
            }

            if(Auth::user()->id_role == 4 || Auth::user()->id_role == 1)
            {
                if($proyeccion_preliminar->id_docente_responsable == Auth::user()->id)
                {
                    $solicitud_practica->confirm_creador= 1;
                    $solicitud_practica->id_docente_creador = Auth::user()->id;
                    $solicitud_practica->confirm_docente= 1;
                    $solicitud_practica->id_docente_confirm = Auth::user()->id;
                }

                $solicitud_practica->confirm_coord = 1;
                $proyeccion_preliminar->observ_coordinador= $request->get('observ_coordinador');
                $solicitud_practica->aprobacion_coordinador= $request->get('aprobacion_coordinador');
                $valor_formateado = (int) str_replace(['$', '.', ' '], '', $request->get('presupuesto_restante'));
                if($valor_formateado >= 0 && $request->get('aprobacion_coordinador') == 7){
                    $detalle_presupuesto_programa_academico = new detalle_presupuesto_programa_academico;
                    $presupuesto_programa_academico->presupuesto_actual = (int) str_replace(['$', '.', ' '], '', $request->get('presupuesto_restante'));
                    $detalle_presupuesto_programa_academico->id_presupuesto_programa = $presupuesto_programa_academico->id;
                    $detalle_presupuesto_programa_academico->id_solicitud = $solicitud_practica->id;
                    $detalle_presupuesto_programa_academico->presupuesto_practica = (int) str_replace(['$', '.', ' '], '', $request->get('presupuesto_práctica'));
                    $detalle_presupuesto_programa_academico->id_user_aprobacion = Auth::user()->id;
                    $detalle_presupuesto_programa_academico->fecha_aprobacion = $mytime;
                    $detalle_presupuesto_programa_academico->anio_periodo = $mytime->year;
                    $detalle_presupuesto_programa_academico->id_periodo_academico = $proyeccion_preliminar->id_periodo_academico;
                    $detalle_presupuesto_programa_academico->save();
                    $presupuesto_programa_academico->update();                    
                }                
                
                //dd($presupuesto_programa_academico,$detalle_presupuesto_programa_academico);

                if(Auth::user()->id_role == 1)
                {
                    $solicitud_practica->id_docente_creador = $proyeccion_preliminar->id_docente_responsable;
                    $solicitud_practica->id_docente_confirm = $proyeccion_preliminar->id_docente_responsable;
                    $solicitud_practica->id_coordinador_confirm =  $proyeccion_preliminar->id_coordinador_confirm;
                    $solicitud_practica->id_coordinador_aprob = $proyeccion_preliminar->id_coordinador_aprob;
                }
                else if(Auth::user()->id_role == 4)
                {
                    $solicitud_practica->id_coordinador_confirm =  Auth::user()->id;
                    $solicitud_practica->id_coordinador_aprob = Auth::user()->id;
                }

                if($solicitud_practica->aprobacion_coordinador == 4)
                {
                    $solicitud_practica->confirm_creador=1;
                    $solicitud_practica->confirm_docente=0;
                    $solicitud_practica->confirm_coord=0;
                }
                else if($solicitud_practica->aprobacion_coordinador == 2)
                {
                    $proyeccion_preliminar->id_estado=2;
                    $solicitud_practica->id_estado_solicitud_practica = 2;
                }

            }

            if(Auth::user()->id_role == 5 || Auth::user()->id_role == 1)
            {
                $solicitud_practica->confirm_creador= 1;
                
                $solicitud_practica->confirm_docente= 1;
                

                if(Auth::user()->id_role == 5)
                {
                    $solicitud_practica->id_docente_creador = Auth::user()->id;
                    $solicitud_practica->id_docente_confirm = Auth::user()->id;
                    $solicitud_practica->aprobacion_asistD= 5;
                    $solicitud_practica->aprobacion_coordinador= 5;
                    $solicitud_practica->aprobacion_decano= 5;
                }
                else if(Auth::user()->id_role == 1)
                {
                    $solicitud_practica->id_docente_creador = $proyeccion_preliminar->id_docente_responsable;
                    $solicitud_practica->id_docente_confirm = $proyeccion_preliminar->id_docente_responsable;
                }
            }
            
        }

        if(Auth::user()->id_role == 3 || Auth::user()->id_role == 1)
        {
            $valor_estimado_transporte_rp = $costos_proyeccion->valor_estimado_transporte_rp;
            $valor_estimado_transporte_ra = $costos_proyeccion->valor_estimado_transporte_ra;
            $valor_estimado_transporte_rp = $request->get('vlr_est_transp_rp')!=null&&$request->get('vlr_est_transp_rp')!=0?intval(str_replace(".","",$request->get('vlr_est_transp_rp'))):$valor_estimado_transporte_rp;
            $valor_estimado_transporte_ra = $request->get('vlr_est_transp_ra')!=null&&$request->get('vlr_est_transp_ra')!=0?intval(str_replace(".","",$request->get('vlr_est_transp_ra'))):$valor_estimado_transporte_ra;
            
            if($request->get('num_radicado_financiera') != null )
            {
                
                $solicitud_practica->radicado_financiera = 1;
                $solicitud_practica->num_radicado_financiera = $request->get('num_radicado_financiera');
                $solicitud_practica->fecha_radicado_financiera = $request->get('fecha_radicado_financiera');

                $solicitud_transp->id = $solicitud_practica->id;
                $solicitud_transp->save();
                $encuesta_transporte->id = $solicitud_practica->id;
                $encuesta_transporte->save();

            }
            else
            {
                if($tipo_ruta == 1)
                {
                    $total_presupuesto_rp = $costos_proyeccion->total_presupuesto_rp;
                    $valor_estimado_transporte_rp = $costos_proyeccion->valor_estimado_transporte_rp;
                    $nuevo_presupuesto_transporte= intval(str_replace(".","",$request->get('vlr_est_transp_rp')));
                    $costos_proyeccion->valor_estimado_transporte_rp = $nuevo_presupuesto_transporte;
                    $presupuesto_sin_transporte_rp = $total_presupuesto_rp - $valor_estimado_transporte_rp;
                    $nuevo_presupuesto_total_rp = $presupuesto_sin_transporte_rp + $nuevo_presupuesto_transporte;
                    $costos_proyeccion->total_presupuesto_rp = $nuevo_presupuesto_total_rp;
                }
                else if($tipo_ruta == 2)
                {
                    $total_presupuesto_ra = $costos_proyeccion->total_presupuesto_ra;
                    $valor_estimado_transporte_ra = $costos_proyeccion->valor_estimado_transporte_ra;
                    $nuevo_presupuesto_transporte= intval(str_replace(".","",$request->get('vlr_est_transp_ra')));
                    $costos_proyeccion->valor_estimado_transporte_ra = $nuevo_presupuesto_transporte;
                    $presupuesto_sin_transporte_ra = $total_presupuesto_ra- $valor_estimado_transporte_ra;
                    $nuevo_presupuesto_total_ra = $presupuesto_sin_transporte_ra + $nuevo_presupuesto_transporte;
                    $costos_proyeccion->total_presupuesto_ra = $nuevo_presupuesto_total_ra;
                }
                if($request->get('aprobacion_asistD') == 5){
                    //dd($request->get('aprobacion_asistD'));
                }else if($request->get('aprobacion_asistD') == 7){
                    //dd($request->get('aprobacion_asistD'));
                    if($solicitud_practica->num_resolucion = $request->get('num_resolucion') != null)
                    {
                        $solicitud_practica->tiene_resolucion=1;
                    }
                    $solicitud_practica->num_resolucion = $request->get('num_resolucion');
        
                    $solicitud_practica->fecha_resolucion = $request->get('fecha_resolucion');
                    $solicitud_practica->num_cdp = $request->get('num_cdp');
                    $solicitud_practica->si_capital = intval($request->get('si_capital'));
                    $solicitud_practica->num_solicitud_necesidad = $request->get('num_solicitud_necesidad');
        
                    $solicitud_practica->confirm_asistD = 1;
                    $solicitud_practica->aprobacion_asistD = 7;
        
                    if(Auth::user()->id_role == 1)
                    {
                        $solicitud_practica->id_asistD_confirm =  $proyeccion_preliminar->id_asistD_confirm;
                        $solicitud_practica->id_asistD_aprob = $proyeccion_preliminar->id_asistD_aprob;
                    }
                    else if(Auth::user()->id_role == 3)
                    {
                        $solicitud_practica->id_asistD_confirm =  Auth::user()->id;
                        $solicitud_practica->id_asistD_aprob = Auth::user()->id;
                    }
                }else if($request->get('aprobacion_asistD') == 4){
                    $detalle_presupuesto_programa_academico = detalle_presupuesto_programa_academico::where('id_solicitud', '=', $solicitud_practica->id)->first();
                    $lista_estudiantes = estudiantes_practica::where('id_solicitud_practica', '=', $solicitud_practica->id)->get();
                    $solicitud_practica->confirm_asistD = 0;
                    $solicitud_practica->aprobacion_asistD = 5;
                    $solicitud_practica->confirm_coord = 0;
                    $solicitud_practica->aprobacion_coordinador = 5;
                    $solicitud_practica->confirm_creador = 0;
                    $solicitud_practica->confirm_docente = 0;
                    $solicitud_practica->listado_estudiantes = 0;
                    $detalle_presupuesto_programa_academico;
                    $presupuesto_programa_academico->presupuesto_actual = $presupuesto_programa_academico->presupuesto_actual + $detalle_presupuesto_programa_academico->presupuesto_practica;
                    $presupuesto_programa_academico->update();
                    //dd($presupuesto_programa_academico, $detalle_presupuesto_programa_academico, $lista_estudiantes);                    
                    foreach ($lista_estudiantes as $list_estud){
                        $list_estud->delete();
                    }   
                    $detalle_presupuesto_programa_academico->delete();                 
                }    
            }            
        }

        if(Auth::user()->id_role == 2 || Auth::user()->id_role == 1)
        {
            if($request->get('docentes_activos') != 0)
            {
                $docente_responsable_activo =DB::table('users')
                ->select('id','id_estado','id_role',
                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->where('id',$request->get('docentes_activos'))->first();

                if(!empty($docente_responsable_activo) && $docente_responsable_activo != null)
                {
                    $proyeccion_preliminar->id_docente_responsable = $docente_responsable_activo->id;
                    
                    $transporte_proyeccion->docen_respo_trasnporte_rp = $docente_responsable_activo->full_name;
                    $transporte_proyeccion->docen_respo_trasnporte_ra = $docente_responsable_activo->full_name;
                    $transporte_menor->docente_resp_t_menor_rp = $docente_responsable_activo->full_name;
                    $transporte_menor->docente_resp_t_menor_ra = $docente_responsable_activo->full_name;
                }
            }

            $solicitud_practica->aprobacion_decano= $request->get('aprobacion_decano');

            if($solicitud_practica->aprobacion_decano == 1)
            {
                $solicitud_practica->id_decano_aprob =  $proyeccion_preliminar->id_decano_aprob;
            }
            else if($solicitud_practica->aprobacion_decano == 7)
            {
                $solicitud_practica->id_decano_aprob =  Auth::user()->id;
                $solicitud_practica->id_estado_solicitud_practica =  3;
            }
        }

        if(Auth::user()->id_role == 7)
        {
            $solicitud_transp = solicitud_transporte::where('id', '=', $solicitud_practica->id)->first();
            $solicitud_transp->nombre_conductor_vehi_1 = $request->get('nombre_cond_vehi_1');
            $solicitud_transp->celular_conductor_vehi_1 = $request->get('celular_cond_vehi_1');
            $solicitud_transp->email_conductor_vehi_1 = $request->get('email_cond_vehi_1');
            $solicitud_transp->nombre_conductor_2_vehi_1 = $request->get('nombre_cond_2_vehi_1');
            $solicitud_transp->celular_conductor_2_vehi_1 = $request->get('celular_cond_2_vehi_1');
            $solicitud_transp->email_conductor_2_vehi_1 = $request->get('email_cond_2_vehi_1');
            $solicitud_transp->placa_vehi_1 = $request->get('placa_vehi_1');

            $solicitud_transp->nombre_conductor_vehi_2 = $request->get('nombre_cond_vehi_2');
            $solicitud_transp->celular_conductor_vehi_2 = $request->get('celular_cond_vehi_2');
            $solicitud_transp->email_conductor_vehi_2 = $request->get('email_cond_vehi_2');
            $solicitud_transp->nombre_conductor_2_vehi_2 = $request->get('nombre_cond_2_vehi_2');
            $solicitud_transp->celular_conductor_2_vehi_2 = $request->get('celular_cond_2_vehi_2');
            $solicitud_transp->email_conductor_2_vehi_2 = $request->get('email_cond_2_vehi_2');
            $solicitud_transp->placa_vehi_2 = $request->get('placa_vehi_2');

            $solicitud_transp->nombre_conductor_vehi_3 = $request->get('nombre_cond_vehi_3');
            $solicitud_transp->celular_conductor_vehi_3 = $request->get('celular_cond_vehi_3');
            $solicitud_transp->email_conductor_vehi_3 = $request->get('email_cond_vehi_3');
            $solicitud_transp->nombre_conductor_2_vehi_3 = $request->get('nombre_cond_2_vehi_3');
            $solicitud_transp->celular_conductor_2_vehi_3 = $request->get('celular_cond_2_vehi_3');
            $solicitud_transp->email_conductor_2_vehi_3 = $request->get('email_cond_2_vehi_3');
            $solicitud_transp->placa_vehi_3 = $request->get('placa_vehi_3');

            $solicitud_transp->diligenciado = 1;
            $solicitud_transp->fecha_diligenciamiento = $mytime;

            $solicitud_practica->confirm_transportadora=1;
            $solicitud_practica->id_transport_confirm=Auth::user()->id;
            $solicitud_transp->update();
        }

        if(Auth::user()->id_role == 1)
        {
            $proyeccion_preliminar->id_estado=$request->get('estado_proyeccion');
            $solicitud_practica->id_estado_solicitud_practica = $request->get('estado_proyeccion');
        }        

        $doc_req_solicitud->update();
        $docentes_practica->update();
        $proyeccion_preliminar->update();
        $costos_proyeccion->update();
        $transporte_proyeccion->update();
        $transporte_menor->update();
        $mater_herra_proyeccion->update();
        $solicitud_practica->update();

        $proyeccion_preliminar = proyeccion::where('id', '=', $id)->first();
        $transporte_proyeccion = transporte_proyeccion::where('id','=',$id)->first();
        $costos_proyeccion = costos_proyeccion::where('id','=',$id)->first();
        $solicitud_practica = solicitud::where('id_proyeccion_preliminar', '=', $id)->first();
        $mater_herra_proyeccion = materiales_herramientas_proyeccion::where('id', '=', $id)->first();

        $radicado_financiera= $solicitud_practica->radicado_financiera;

        if(Auth::user()->id_role == 2)
        {

            if($solicitud_practica->aprobacion_decano == 7)
            {
                if($transporte_proyeccion->cant_transporte_rp >=1 || $transporte_proyeccion->cant_transporte_ra >=1)
                {
                    $this->noti_transp_solic($id);
                }
            }
        }

        if(Auth::user()->id_role == 3)
        {
            if($radicado_financiera == 1)
            {
                $this->radic_avance_tesor_solic($id);
                $this->info_solic_estudiantes($id);
                $cant_transp = 0;

                if($solicitud_practica->tipo_ruta == 1)
                {
                    if($transporte_proyeccion->cant_transporte_rp == 0 || $transporte_proyeccion->cant_transporte_rp == NULL || $transporte_proyeccion->cant_transporte_rp == '')
                    {
                        $cant_transp = 0;
                    }
                }
                else if($solicitud_practica->tipo_ruta == 2)
                {
                    if($transporte_proyeccion->cant_transporte_ra == 0 || $transporte_proyeccion->cant_transporte_ra == NULL || $transporte_proyeccion->cant_transporte_ra == '')
                    {
                        $cant_transp = 0;
                    }
                }

                if($cant_transp == 0)
                {
                    $this->encuesta_transp($request,$id);
                }
            }
        }

        if(Auth::user()->id_role == 4)
        {
            if($request->get('aprobacion_coordinador') == 3)
            {
                $this->aprob_coord_solic($id);
            }
            else if($request->get('aprobacion_coordinador') == 4)
            {
                $this->rechazo_coord_solic($id);
            }
            else if($request->get('aprobacion_coordinador') == 2)
            {
                $this->cierre_coord_solic($id);
            }
            
        }

        if(Auth::user()->id_role == 5)
        {
            if($solicitud_practica->listado_estudiantes == 0)
            {
                return view('solicitudes.lista_estudiantes',['id_solicitud'=>$solicitud_practica->id,
                                                         'usuario'=>$usuario_log,
                                                         'control_sistema'=>$control_sistema]);
            }
            else if($solicitud_practica->listado_estudiantes == 1)
            {
                return redirect('solicitudes/filtrar/all');
            }
        }

        return redirect('solicitudes/filtrar/all');
    }
    
    /**
     * Consecutivos Dfamarena y Cordis para oficio
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consec_solic(Request $request, $id)
    {
        // $id = Crypt::decrypt($id);
        $id=explode(",",$id);
        foreach($id as $item){ 
           $solicitud_practica = solicitud::where('id', '=', $item)->first();

           if(Auth::user()->id_role == 1 || Auth::user()->id_role == 2 || Auth::user()->id_role == 3)
           {
               $solicitud_practica->consec_dfamarena =$request->get('consec_dfamarena');
               $solicitud_practica->consec_cordis =$request->get('consec_cordis');
           }
           $solicitud_practica->update();
        }

        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('docentes_practica as doc_prac','p_prel.id','=','doc_prac.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        // ->where('doc_prac.tiene_soporte_avance','=',1)
                        // ->where('doc_prac.tiene_soporte_practica','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('id_docente_responsable',$solicitud_practica->id_docente_creador)
                        ->get();

        $docentes_aprob=[];

        foreach($proyeccion as $p)
        {
            $docentes_aprob[] = ['id_doc_resp'=>$p->id_docente_responsable,
            'full_name'=>$p->full_name,
            'cant_sol'=>1,
            'solic'=>$p->id_solicitud
                    
            ];
        }
        // $docentes_aprob = new stdClass();
        // $docentes_aprob->id_doc_resp=$proyeccion->id_docente_responsable;
        // $docentes_aprob->full_name=$proyeccion->full_name;
        // $docentes_aprob->cant_sol =1;
        // $docentes_aprob->solic = $proyeccion->id_solicitud;              

        // $docentes_aprob = [];

        // foreach($proyeccion as $p)
        // {
        //     $cant_doc = count($docentes_aprob);

        //     if(count($docentes_aprob) > 0)
        //     {
        //         $flag = false;
        //         foreach($docentes_aprob as $key=>$dp)
        //         {
        //         $flag = $dp['id_doc_resp'] == $p->id_docente_responsable?true:false;
                
        //         if($flag == true)
        //         {
        //             $sol = [$dp['solic']];
        //             $cant_sol = $dp['cant_sol']+1;
        //             array_push($sol,$p->id_solicitud);
        //             $docentes_aprob[$key]['cant_sol'] = $cant_sol;
        //             $docentes_aprob[$key]['solic'] = $sol;
        //             break;
        //         }
        //             else{
        //                 continue;
        //             }
        //         }

        //         if($flag == false)
        //         {
        //             $docentes_aprob[$cant_doc]['id_doc_resp'] = $p->id_docente_responsable;
        //             $docentes_aprob[$cant_doc]['full_name'] = $p->full_name;
        //             $docentes_aprob[$cant_doc]['cant_sol'] = 1;
        //             $docentes_aprob[$cant_doc]['solic'] = $p->id_solicitud;
        //         }
        //     }
        //     else if(count($docentes_aprob) == 0)
        //     {

        //         $docentes_aprob[] = ['id_doc_resp'=>$p->id_docente_responsable,
        //                             'full_name'=>$p->full_name,
        //                             'cant_sol'=>1,
        //                             'solic'=>$p->id_solicitud
                    
        //         ];
        //     }
        // }                 

        // return redirect()->action('Pdf\PdfController@accionesPdf',['id'=>Crypt::encrypt($id)]);
        return redirect()->action('Solicitud\SolicitudController@listado_sol_aprob',['id'=>Crypt::encrypt($docentes_aprob[0])]);
    }

    /**
     * Listado de solicitudes
     *
     * @param  string  $filter
     * @return \Illuminate\Http\Response
     */
    public function filterSolicitud($filter)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $idRole = Auth::user()->id_role;
        $idUser = Auth::user()->id;
        $user_DB= DB::table('users')
        ->where('id',$idUser)->first();

        switch($idRole)
        {   
            case 1:
                 switch($filter)
                {
                    case 'all':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                        
                        // return view('proyecciones.index',['proyecciones'=>$proyeccion, 
                        //                                     'usuario'=>$user_DB,
                        //                                     'filter'=>$filter,
                        //                                     'control_sistema'=>$control_sistema]);
                    break;

                    case 'inact':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        // ->where('p_prel.id_estado','=',2)
                        ->where('sol_prac.id_estado_solicitud_practica','=',2)
                        ->paginate(10000);
                        
                        // return view('proyecciones.index',['proyecciones'=>$proyeccion, 
                        //                                     'usuario'=>$user_DB,
                        //                                     'filter'=>$filter,
                        //                                     'control_sistema'=>$control_sistema]);
                    break;

                    default;
                }
            break;

            case 2:
                switch($filter)
                {
                    case 'inact':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('p_prel.id_estado','=',2)
                        ->paginate(10000);

                    break;

                    case 'aprob-cons':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);

                    break;

                    case 'no-elect':
                        $espacios = DB::table('espacio_academico as esp_aca')
                        ->select('esp_aca.id','esp_aca.id_programa_academico','esp_aca.codigo_espacio_academico','esp_aca.espacio_academico',
                        'esp_aca.electiva', 'p_aca.programa_academico')
                        ->join('programa_academico as p_aca','esp_aca.id_programa_academico','=','p_aca.id')
                        ->where('esp_aca.electiva','=',0)->get();
                        $proyeccion = [];
                        foreach($espacios as $esp)
                        {
                            $proyecciones=DB::table('proyeccion_preliminar as p_prel')
                            ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                    'e_aca.electiva', 'p_prel.id_espacio_academico', 'p_aca.programa_academico',
                                    'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                    'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                    'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                    'users.id_estado as id_estado_doc')
                                    // DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                            ->join('users','p_prel.id_docente_responsable','=','users.id')
                            ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                            ->where('p_prel.id_estado','=',1)
                            ->where('p_prel.id_espacio_academico','=',$esp->id)->get();
                            
                            if(count($proyecciones)==0)
                            {
                                $proyeccion[] = $esp;
                            }
                            
                        }
                        return view('proyecciones.index',['proyecciones'=>$proyeccion, 
                                                            'filter'=>$filter, 
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);

                    break;
                    
                    case 'elect':
                        $espacios = DB::table('espacio_academico as esp_aca')
                        ->where('electiva','=',1)->get();
                        // $proyeccion = 0;
                        // foreach($espacios as $esp)
                        // {
                            $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                            ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                    'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                    'es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','users.id_estado as id_estado_doc','es_consj.abrev as es_consj',
                                    'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                    'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                    'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                            ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                            ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                            ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                            ->join('users','p_prel.id_docente_responsable','=','users.id')
                            ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                            ->where('confirm_creador','=',1)
                            ->where('confirm_coord','=',1)
                            ->where('confirm_electiva_coord','=',1)
                            ->where('e_aca.electiva','=',1)
                            ->where('aprobacion_coordinador','=',7)
                            ->where('p_prel.id_estado','=',1)
                            ->paginate(10000);

                        //     if(count($proyecciones_extra) >= 1)
                        //     {
                        //         $proyeccion += $proyecciones_extra;
                        //     }
                        // }
                    break;

                    case 'pend':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,
                                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra','c_proy.vlr_guias_baquianos_rp','c_proy.vlr_guias_baquianos_ra',
                                'c_proy.vlr_otros_boletas_rp','c_proy.vlr_otros_boletas_ra',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.duracion_num_dias','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',5)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->paginate(10000);
                        return view('solicitudes.index',['proyecciones'=>$proyeccion, 
                                                            'filter'=>$filter, 
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    break;

                    case 'aprob':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('docentes_practica as doc_prac','p_prel.id','=','doc_prac.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        // ->where('doc_prac.tiene_soporte_avance','=',1)
                        // ->where('doc_prac.tiene_soporte_practica','=',1)
                        ->where('p_prel.id_estado','=',1)
			->orderby('full_name','asc')
                        ->paginate(10000);
//dd($proyeccion);
                      
                        $docentes_aprob = [];

                        foreach($proyeccion as $p)
                        {
                            $cant_doc = count($docentes_aprob);

                            if(count($docentes_aprob) > 0)
                            {
                                $flag = false;
                                foreach($docentes_aprob as $key=>$dp)
                                {

                                    $flag = $dp['id_doc_resp'] == $p->id_docente_responsable?true:false;
                                    
                                    if($flag == true)
                                    {
                                        $sol = [$dp['solic']];
                                        $cant_sol = $dp['cant_sol']+1;
                                        array_push($sol,$p->id_solicitud);
                                        $docentes_aprob[$key]['cant_sol'] = $cant_sol;
                                        $docentes_aprob[$key]['solic'] = $sol;
                                        break;
                                    }
                                    else{
                                        continue;
                                    }
                                }

                                if($flag == false)
                                {
                                    $docentes_aprob[$cant_doc]['id_doc_resp'] = $p->id_docente_responsable;
                                    $docentes_aprob[$cant_doc]['full_name'] = $p->full_name;
                                    $docentes_aprob[$cant_doc]['cant_sol'] = 1;
                                    $docentes_aprob[$cant_doc]['solic'] = $p->id_solicitud;
                                }
                            }
                            else if(count($docentes_aprob) == 0)
                            {

                                $docentes_aprob[] = ['id_doc_resp'=>$p->id_docente_responsable,
                                                    'full_name'=>$p->full_name,
                                                    'cant_sol'=>1,
                                                    'solic'=>$p->id_solicitud
                                    
                                ];
                            }
                        } 

                        return view('solicitudes.index',['proyecciones'=>$proyeccion, 
                                                        'docentes_aprob'=>$docentes_aprob,
                                                        'filter'=>$filter, 
                                                        'usuario'=>$user_DB,
                                                        'control_sistema'=>$control_sistema]);
                    break;
            
                    case 'all':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','p_prel.destino_ra','p_prel.fecha_salida_aprox_rp','p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_rp',
                                'p_prel.fecha_regreso_aprox_ra','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra','c_proy.vlr_guias_baquianos_rp','c_proy.vlr_guias_baquianos_ra',
                                'c_proy.vlr_otros_boletas_rp','c_proy.vlr_otros_boletas_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->paginate(10000);
                        
                        // $filter="all";

                        // $estudiantes=new estudiantes_practica();
                        //$estudiantes=DB::table('estudiantes_solicitud_practica')->get();
                    break;

                    default;
                }

            break;

            case 3:
                switch($filter)
                {
                    case 'pend':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',5)
                        ->where('sol_prac.id_estado_solicitud_practica','=',5)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->paginate(10000);
                    break;

                    case 'pend-teso':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('sol_prac.radicado_financiera','=',0)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->paginate(10000);
                    break;

                    case 'pend-cierre':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('solicitud_transporte as sol_transp','sol_prac.id','=','sol_transp.id')
                        ->join('encuesta_transporte as enc_transp','sol_prac.id','=','enc_transp.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('sol_prac.radicado_financiera','=',1)
                        ->where('sol_prac.legalizado_financiera','=',0)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->where('sol_prac.confirm_transportadora','=',1)
                        ->where('sol_transp.diligenciado','=',1)
                        ->where('enc_transp.diligenciado','=',1)
                        ->paginate(10000);
                    break;

                    case 'enc_trans':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('solicitud_transporte as sol_transp','sol_prac.id','=','sol_transp.id')
                        ->join('encuesta_transporte as enc_transp','sol_prac.id','=','enc_transp.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('sol_prac.radicado_financiera','=',1)
                        ->where('sol_prac.legalizado_financiera','=',0)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->where('sol_prac.confirm_transportadora','=',1)
                        ->where('sol_transp.diligenciado','=',1)
                        ->where('enc_transp.diligenciado','=',1)
                        ->paginate(10000);
                    break;

                    case 'aprob':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('docentes_practica as doc_prac','p_prel.id','=','doc_prac.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        // ->where('doc_prac.tiene_soporte_avance','=',1)
                        // ->where('doc_prac.tiene_soporte_practica','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);

                      
                        $docentes_aprob = [];

                        foreach($proyeccion as $p)
                        {
                            $cant_doc = count($docentes_aprob);

                            if(count($docentes_aprob) > 0)
                            {
                                $flag = false;
                                foreach($docentes_aprob as $key=>$dp)
                                {

                                    $flag = $dp['id_doc_resp'] == $p->id_docente_responsable?true:false;
                                    
                                    if($flag == true)
                                    {
                                        $sol = [$dp['solic']];
                                        $cant_sol = $dp['cant_sol']+1;
                                        array_push($sol,$p->id_solicitud);
                                        $docentes_aprob[$key]['cant_sol'] = $cant_sol;
                                        $docentes_aprob[$key]['solic'] = $sol;
                                        break;
                                    }
                                    else{
                                        continue;
                                    }
                                }

                                if($flag == false)
                                {
                                    $docentes_aprob[$cant_doc]['id_doc_resp'] = $p->id_docente_responsable;
                                    $docentes_aprob[$cant_doc]['full_name'] = $p->full_name;
                                    $docentes_aprob[$cant_doc]['cant_sol'] = 1;
                                    $docentes_aprob[$cant_doc]['solic'] = $p->id_solicitud;
                                }
                            }
                            else if(count($docentes_aprob) == 0)
                            {

                                $docentes_aprob[] = ['id_doc_resp'=>$p->id_docente_responsable,
                                                    'full_name'=>$p->full_name,
                                                    'cant_sol'=>1,
                                                    'solic'=>$p->id_solicitud
                                    
                                ];
                            }
                        } 

                        return view('solicitudes.index',['proyecciones'=>$proyeccion, 
                                                        'docentes_aprob'=>$docentes_aprob,
                                                        'filter'=>$filter, 
                                                        'usuario'=>$user_DB,
                                                        'control_sistema'=>$control_sistema]);
                    break;

                    case 'all':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_coord','users.id_estado as id_estado_doc',
                                'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->paginate(10000);
                    break;

                    default;
                }
            break; 

            case 4:
                switch($filter)
                {
                    case 'pre-proy':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador','users.id_estado as id_estado_doc',
                                'sol_prac.id as id_solicitud','sol_prac.aprobacion_coordinador as ap_coor','sol_prac.aprobacion_decano  as ap_dec',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.listado_estudiantes', 'sol_prac.confirm_creador','sol_prac.confirm_docente',
                                'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->where('p_prel.confirm_creador','=',1)
                        ->where('p_prel.confirm_docente','=',1)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.id_estado_solicitud_practica','=',5)
                        ->where('sol_prac.listado_estudiantes','=',0)
                        ->paginate(10000);
                        
                        return view('solicitudes.index',['proyecciones'=>$proyeccion,
                                                            'proyeccion_preliminar'=>$proyeccion, 
                                                            'filter'=>$filter, 
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                      
                    break;

                    case 'proy-comp':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador', 'sol_prac.tipo_ruta as tipo_ruta',
                                'sol_prac.id as id_solicitud','sol_prac.aprobacion_coordinador as ap_coor','sol_prac.aprobacion_decano  as ap_dec')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->where('p_prel.confirm_creador','=',1)
                        ->where('p_prel.confirm_docente','=',1)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.id_estado_solicitud_practica','=',5)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->paginate(10000);
                    break;

                    case 'pend':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $espacios = DB::table('espacio_academico as esp_aca')
                        ->where('electiva','=',1)->get();
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',5)
                        ->where('sol_prac.id_estado_solicitud_practica','=',5)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('p_prel.id_docente_responsable','=',$idUser)
                            ->orWhere('p_prel.id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);
                    break;
                    
                    case 'all':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $espacios = DB::table('espacio_academico as esp_aca')
                        ->where('electiva','=',1)->get();
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('p_prel.id_estado','=',1)
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('p_prel.id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);
                        //$estudiantes=DB::table('estudiantes_solicitud_practica')->get();
                    break;

                    default;
                }
            break;

            case 5:
                switch($filter)
                {
                    case 'pre-proy':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ap_coor',
                                'es_dec.abrev  as ap_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'sol_prac.id as id_solicitud','sol_prac.aprobacion_coordinador as ap_coor','sol_prac.aprobacion_decano  as ap_dec',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.listado_estudiantes', 'sol_prac.confirm_creador','sol_prac.confirm_docente')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        // ->where('aprobacion_coordinador','=',5)
                        ->where('p_prel.confirm_creador','=',1)
                        ->where('p_prel.confirm_docente','=',1)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.id_estado_solicitud_practica','=',5)
                        ->where('sol_prac.listado_estudiantes','=',0)
                        ->paginate(10000);
                        
                        return view('solicitudes.index',['proyecciones'=>$proyeccion,
                                                            'proyeccion_preliminar'=>$proyeccion, 
                                                            'filter'=>$filter, 
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);

                    break;

                    case 'proy-comp':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ap_coor',
                                'es_dec.abrev  as ap_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'sol_prac.id as id_solicitud','es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'sol_prac.tipo_ruta as tipo_ruta')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('p_prel.confirm_creador','=',1)
                        ->where('p_prel.confirm_docente','=',1)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.confirm_creador','=',1)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('sol_prac.confirm_coord','=',0)
                        ->where('sol_prac.confirm_asistD','=',0)
                        ->where('sol_prac.id_estado_solicitud_practica','=',5)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->paginate(10000);
                    break;

                    case 'proy-aprob':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ap_coor',
                                'es_dec.abrev  as ap_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'sol_prac.id as id_solicitud', 'sol_prac.tipo_ruta as tipo_ruta')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('id_estado_solicitud_practica','=',3)
                        ->where('si_capital','=',1)
                        ->where('tiene_resolucion','=',1)
                        ->paginate(10000);
                    break;

                    case 'aprob':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'sol_prac.id as id_solicitud', 'es_coor.abrev as ap_coor','es_dec.abrev as ap_dec',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.id as id_solicitud')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->where('p_prel.confirm_creador','=',1)
                        ->where('p_prel.confirm_docente','=',1)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('sol_prac.aprobacion_decano','=',7)
                        ->paginate(10000);
                    break;

                    case 'sol_recha':
                        $espacios = DB::table('espacio_academico as esp_aca')
                        ->where('electiva','=',1)->get();
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.aprobacion_coordinador','=',4)
                        ->paginate(10000);

                        //$estudiantes=DB::table('estudiantes_solicitud_practica')->get();
                    break;

		    case 'all':
                        $espacios = DB::table('espacio_academico as esp_aca')
                        ->where('electiva','=',1)->get();
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('aprobacion_consejo_facultad','=',3)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                        
                        // $filter="all";

                        // $estudiantes=new estudiantes_practica();
                        //$estudiantes=DB::table('estudiantes_solicitud_practica')->get();
                    break;

                    case 'ejec-sol':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'sol_prac.id as id_solicitud','sol_prac.aprobacion_coordinador as ap_coor','sol_prac.aprobacion_decano  as ap_dec',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.id as id_solicitud')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('solicitud_transporte as sol_transp','sol_prac.id','=','sol_transp.id')
                        ->join('encuesta_transporte as enc_transp','sol_prac.id','=','enc_transp.id')
                        ->where('p_prel.confirm_creador','=',1)
                        ->where('p_prel.confirm_docente','=',1)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('si_capital','=',1)
                        ->where('tiene_resolucion','=',1)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.radicado_financiera','=',1)
                        ->where('sol_transp.diligenciado','=',1)
                        ->where('sol_prac.legalizado_financiera','=',0)
                        ->where('enc_transp.diligenciado','=',0)
                        ->paginate(10000);
                    break;

                    case 'transp':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,
                                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.duracion_num_dias','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('solicitud_transporte as sol_transp','sol_prac.id','=','sol_transp.id')
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->where('sol_prac.radicado_financiera','=',1)
                        ->where('sol_prac.confirm_transportadora','=',1)
                        ->where('sol_transp.diligenciado','=',1)
                        ->paginate(10000);
                        return view('solicitudes.index',['proyecciones'=>$proyeccion, 
                                                            'filter'=>$filter, 
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    
                    break;

                    case 'estud':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,
                                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.duracion_num_dias','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('solicitud_transporte as sol_transp','sol_prac.id','=','sol_transp.id')
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->where('sol_prac.radicado_financiera','=',1)
                        ->where('sol_prac.confirm_transportadora','=',1)
                        ->where('sol_transp.diligenciado','=',1)
                        ->paginate(10000);
                        return view('solicitudes.index',['proyecciones'=>$proyeccion, 
                                                            'filter'=>$filter, 
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    
                    break;
                    
                    default;
                }
            break;

            case 7:
                switch($filter)
                {
                    case 'all':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,
                                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'transp_proy.cant_transporte_rp','transp_proy.cant_transporte_ra',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra','sol_prac.fecha_salida','sol_prac.fecha_regreso',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.duracion_num_dias','sol_prac.id as id_solicitud',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('transporte_proyeccion as transp_proy','p_prel.id','=','transp_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->where('sol_prac.radicado_financiera','=',1)
                        ->where('transp_proy.cant_transporte_rp','>=',1)
                        ->orWhere('transp_proy.cant_transporte_ra','>=',1)
                        ->paginate(10000);
                    break;

                    case 'aprob':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,
                                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'transp_proy.cant_transporte_rp','transp_proy.cant_transporte_ra',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra', 'sol_prac.fecha_salida','sol_prac.fecha_regreso',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.duracion_num_dias','sol_prac.id as id_solicitud', 'sol_prac.hora_salida',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('transporte_proyeccion as transp_proy','p_prel.id','=','transp_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->join('solicitud_transporte as sol_transp','sol_prac.id','=','sol_transp.id')
                        ->where('p_prel.aprobacion_consejo_facultad','=',3)
                        ->where('sol_prac.aprobacion_coordinador','=',7)
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.id_estado_solicitud_practica','=',3)
                        ->where('sol_prac.confirm_docente','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('sol_prac.listado_estudiantes','=',1)
                        ->where('sol_prac.radicado_financiera','=',1)
                        ->where('transp_proy.cant_transporte_rp','>=',1)
                        ->orWhere('transp_proy.cant_transporte_ra','>=',1)
                        // ->where('sol_prac.confirm_transportadora','=',0)
                        // ->where('sol_transp.diligenciado','=',0)
                        ->paginate(10000);
                        return view('solicitudes.index',['proyecciones'=>$proyeccion, 
                                                            'filter'=>$filter, 
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    
                    break;
                }

            default;
        }
        return view('solicitudes.index',['proyecciones'=>$proyeccion, 
                                            'filter'=>$filter, 
                                            'usuario'=>$user_DB,
                                            'control_sistema'=>$control_sistema]);
    }

    /**
     * Listado de solicitudes aprobadas asociadas al docente
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function listado_sol_aprob($id)
    {
        $filter = 'aprob_solic';
        $solic = Crypt::decrypt($id);
        $control_sistema =DB::table('control_sistema')->first();
        $documentos_sistema = DB::table('tipo_documentacion')->orderBy('id','asc')->get();
        $idRole = Auth::user()->id_role;
        $idUser = Auth::user()->id;
        $user_DB= DB::table('users')
        ->where('id',$idUser)->first();

        $cant_solic = $solic['cant_sol'];
        $list_solic = [];
	
        if($cant_solic == 1)
        {
            $proyeccion=DB::table('proyeccion_preliminar as p_prel')
            ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                    'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                    'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                    'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                    'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                    'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                    'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud','sol_prac.num_cdp','sol_prac.num_solicitud_necesidad','sol_prac.num_resolucion',
                    'sol_prac.consec_cordis','sol_prac.consec_dfamarena',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
            ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
            ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
            ->join('users','p_prel.id_docente_responsable','=','users.id')
            ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
            ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
            ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
            ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
            ->where('aprobacion_consejo_facultad','=',3)
            ->where('sol_prac.aprobacion_coordinador','=',7)
            ->where('sol_prac.aprobacion_asistD','=',7)
            ->where('sol_prac.aprobacion_decano','=',7)
            ->where('sol_prac.id_estado_solicitud_practica','=',3)
            ->where('p_prel.id_estado','=',1)
            ->where('sol_prac.id',$solic['solic'])
            ->paginate(20);
        }
        else if($cant_solic > 1)
        {

	    $array_obj = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($solic['solic']));

            foreach($array_obj as $key=>$value)
            {
                $list_solic[]=$value;
            }

            $proyeccion=DB::table('proyeccion_preliminar as p_prel')
            ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                    'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                    'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                    'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                    'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                    'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                    'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud','sol_prac.num_cdp','sol_prac.num_solicitud_necesidad','sol_prac.num_resolucion',
                    'sol_prac.consec_cordis','sol_prac.consec_dfamarena',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
            ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
            ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
            ->join('users','p_prel.id_docente_responsable','=','users.id')
            ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
            ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
            ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
            ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
            ->where('aprobacion_consejo_facultad','=',3)
            ->where('sol_prac.aprobacion_coordinador','=',7)
            ->where('sol_prac.aprobacion_asistD','=',7)
            ->where('sol_prac.aprobacion_decano','=',7)
            ->where('sol_prac.id_estado_solicitud_practica','=',3)
            ->where('p_prel.id_estado','=',1)
            ->whereIn('sol_prac.id',$list_solic)
            ->paginate(100);
        }

        return view('solicitudes.index',['proyecciones'=>$proyeccion, 
                                            'filter'=>$filter, 
                                            'usuario'=>$user_DB,
                                            'control_sistema'=>$control_sistema,
                                            'documentos_sistema'=>$documentos_sistema]);
    }

    /**
     * Listado de estudiantes registrados en la solicitud
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listado_estud($id)
    {
        $id = Crypt::decrypt($id);
        $idUser_log = Auth::user()->id;
        $usuario_log=DB::table('users')
                ->where('id','=',$idUser_log)->first();
        
        $solicitud_practica = DB::table('solicitud_practica')
                ->where('id_proyeccion_preliminar', '=', $id)->first();
        $control_sistema = DB::table('control_sistema')->first();

        return view('solicitudes.lista_estudiantes',['id_solicitud'=>$solicitud_practica->id,
                                                    'usuario'=>$usuario_log,
                                                    'control_sistema'=>$control_sistema]);
    }

    /**
     * Muestra formulario de legalización de solicitud
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function solic_legal($id)
    {
        $id=Crypt::decrypt($id);
        $control_sistema =DB::table('control_sistema')->first();
        if(Auth::user()->id_role == 3 || Auth::user()->id_role == 1)
        {
            $proyeccion_preliminar = proyeccion::where('id', '=', $id)->first();
            $sedes = DB::table('sedes_universidad')->get();
            $solicitud_practica = solicitud::where('id_proyeccion_preliminar', '=', $id)->first();
            $tipo_ruta=$solicitud_practica->tipo_ruta;
            $idRole = Auth::user()->id_role;
            $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();
            $proyeccion_preliminar = proyeccion::find($id);
            $practicas_integradas = practicas_integradas::find($id);
            $costos_proyeccion = costos_proyeccion::find($id);
            $docentes_practica = docentes_practica::find($id);
            $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
            $riesg_amen_practica = riesgos_amenazas_practica::find($id);
            $transporte_proyeccion = transporte_proyeccion::find($id);
            $transporte_menor = transporte_menor::find($id);
            $solicitud_practica = DB::table('solicitud_practica as sol_prac')
            ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
            $idUser = $proyeccion_preliminar->id_docente_responsable;
            $usuario=DB::table('users')
            ->where('id','=',$idUser)->first();

            $espacio_academico=DB::table('espacio_academico as esp_aca')
            ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
            'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
            ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
            ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
            $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                
            $programa_academico = DB::table('programa_academico')->get();
            $periodo_academico=DB::table('periodo_academico')->get();
            $semestre_asignatura=DB::table('semestre_asignatura')->get();
            $tipo_transporte=DB::table('tipo_transporte')->get();
            $all_esp_aca=DB::table('espacio_academico')->get();
            $all_prog_aca=$programa_academico;

            $num_grupos_proy = 0; 
        
            $prog_aca_user = [];
            $esp_aca_user = [];

            $docen_integ = [];
                $d_int_espa_aca_1 = [];
                $d_int_espa_aca_2 = [];
                $d_int_espa_aca_3 = [];
                $d_int_espa_aca_4 = [];
                $d_int_espa_aca_5 = [];
                $d_int_espa_aca_6 = [];
                $d_int_espa_aca_7 = [];

                if($practicas_integradas->id_docen_espa_aca_1 != null || $practicas_integradas->id_docen_espa_aca_1 > 0)
                {
                    $d_1=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_1)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_1)->get();

                    foreach($d_1 as $d_1)
                    {
                        $d_int_espa_aca_1[] = ['id'=>$d_1->id,'full_name'=>$d_1->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_1[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_2 != null || $practicas_integradas->id_docen_espa_aca_2 > 0)
                {
                    $d_2=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_2)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_2)->get();

                    foreach($d_2 as $d_2)
                    {
                        $d_int_espa_aca_2[] = ['id'=>$d_2->id,'full_name'=>$d_2->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_2[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_3 != null || $practicas_integradas->id_docen_espa_aca_3 > 0)
                {
                    $d_3=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_3)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_3)->get();

                    foreach($d_3 as $d_3)
                    {
                        $d_int_espa_aca_3[] = ['id'=>$d_3->id,'full_name'=>$d_3->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_3[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_4 != null || $practicas_integradas->id_docen_espa_aca_4 > 0)
                {
                    $d_4=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_4)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_4)->get();

                    foreach($d_4 as $d_4)
                    {
                        $d_int_espa_aca_4[] = ['id'=>$d_4->id,'full_name'=>$d_4->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_4[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_5 != null || $practicas_integradas->id_docen_espa_aca_5 > 0)
                {
                   $d_5=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_5)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_5)->get();

                    foreach($d_5 as $d_5)
                    {
                        $d_int_espa_aca_5[] = ['id'=>$d_5->id,'full_name'=>$d_5->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_5[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_6 != null || $practicas_integradas->id_docen_espa_aca_6 > 0)
                {
                    $d_6=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_6)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_6)->get();

                    foreach($d_6 as $d_6)
                    {
                        $d_int_espa_aca_6[] = ['id'=>$d_6->id,'full_name'=>$d_6->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_6[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                if($practicas_integradas->id_docen_espa_aca_7 != null || $practicas_integradas->id_docen_espa_aca_7 > 0)
                {
                    $d_7=DB::table('users')
                        ->select('users.id',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id_espacio_academico_1',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_2',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_3',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_4',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_5',$practicas_integradas->id_espa_aca_7)
                        ->orWhere('id_espacio_academico_6',$practicas_integradas->id_espa_aca_7)->get();

                    foreach($d_7 as $d_7)
                    {
                        $d_int_espa_aca_7[] = ['id'=>$d_7->id,'full_name'=>$d_7->full_name];
                    }
                }
                else{
                    $d_int_espa_aca_7[] = ['id'=>0,'full_name'=>'No hay docente registrado'];
                }

                $espa_aca_int = DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$practicas_integradas->id_espa_aca_1, $practicas_integradas->id_espa_aca_2, $practicas_integradas->id_espa_aca_3, 
                $practicas_integradas->id_espa_aca_4, $practicas_integradas->id_espa_aca_5, $practicas_integradas->id_espa_aca_6,
                $practicas_integradas->id_espa_aca_7])->get();
            
            
            foreach($espacio_academico as $esp_aca)
            {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
            }

            $estado_doc_respon =$usuario->id_estado;
                
            $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
            $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
            return view('solicitudes.formularios.edit_cierre',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "practicas_integradas"=>$practicas_integradas,
                                                "sedes"=>$sedes,
                                                "espa_aca_integradas"=>$espa_aca_int,
                                                "d_int_espa_aca_1"=>$d_int_espa_aca_1,
                                                "d_int_espa_aca_2"=>$d_int_espa_aca_2,
                                                "d_int_espa_aca_3"=>$d_int_espa_aca_3,
                                                "d_int_espa_aca_4"=>$d_int_espa_aca_4,
                                                "d_int_espa_aca_5"=>$d_int_espa_aca_5,
                                                "d_int_espa_aca_6"=>$d_int_espa_aca_6,
                                                "d_int_espa_aca_7"=>$d_int_espa_aca_7,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "all_programas_aca"=>$all_prog_aca,
                                                "all_espacios_aca"=>$all_esp_aca,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
                                                ]);

        }
    }

    /**
     * Cierre de solicitud
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function solic_cierre(Request $request,$id)
    {
        $id=Crypt::decrypt($id);
        if(Auth::user()->id_role == 3)
        {
            $proyeccion_preliminar = proyeccion::where('id', '=', $id)->first();
            $solicitud_practica = solicitud::where('id_proyeccion_preliminar', '=', $id)->first();

            $estado_legal = intval($request->get('legalizado_financiera'));
            if($estado_legal == 6)
            {

                $solicitud_practica->legalizado_financiera = 1;
                $proyeccion_preliminar->id_estado = 6;
                $solicitud_practica->id_estado_solicitud_practica = 6;

                $solicitud_practica->id_asistD_legal =  Auth::user()->id;
                $solicitud_practica->update();
                $proyeccion_preliminar->update();

            }

            return redirect('solicitudes/filtrar/all');
        }
    }

    /**
     * Muestra listado de rutas
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showRuta($id)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $idRole = Auth::user()->id_role;
        if($idRole == 1)
        {
            $proy=DB::table('proyeccion_preliminar as p_prel')
            ->where('p_prel.id','=',$id)
            ->first();
            $idUser = $proy->id_docente_responsable;
            $usuario=DB::table('users')->where('id','=',$idUser)->first();
            $id_prog_coord = $usuario->id_programa_academico_coord;

            $proyeccion=DB::table('proyeccion_preliminar as p_prel')
            ->select('p_prel.id','p_aca.programa_academico','e_aca.codigo_espacio_academico','e_aca.espacio_academico',
                    'p_prel.id_docente_responsable',
                    'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,
                    'p_prel.destino_ra','p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra','es_coor.abrev as ab_coor',
                    'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                    'sol_prac.id as id_solicitud','sol_prac.listado_estudiantes', 'sol_prac.confirm_creador', 'sol_prac.confirm_docente')
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
            ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
            ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
            ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
            ->where('p_prel.confirm_creador','=',1)
            ->where('p_prel.confirm_docente','=',1)
            ->where('p_prel.confirm_coord','=',1)
            ->where('p_prel.confirm_asistD','=',1)
            ->where('p_prel.id_docente_responsable','=',$idUser)
            ->where('p_prel.id_estado','=',1)
            ->where('p_prel.aprobacion_consejo_facultad','=',3)
            ->where('p_prel.id','=',$id)
            ->first();
        }
        else
        {
            $idUser = Auth::user()->id;
            $usuario=DB::table('users')->where('id','=',$idUser)->first();
            $id_prog_coord = $usuario->id_programa_academico_coord;

            $proyeccion=DB::table('proyeccion_preliminar as p_prel')
            ->select('p_prel.id','p_aca.programa_academico','e_aca.codigo_espacio_academico','e_aca.espacio_academico',
                    'p_prel.id_docente_responsable',
                    'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp' ,
                    'p_prel.destino_ra','p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra','es_coor.abrev as ab_coor',
                    'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                    'sol_prac.id as id_solicitud','sol_prac.listado_estudiantes', 'sol_prac.confirm_creador', 'sol_prac.confirm_docente')
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
            ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
            ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
            ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
            ->where('p_prel.confirm_creador','=',1)
            ->where('p_prel.confirm_docente','=',1)
            ->where('p_prel.confirm_coord','=',1)
            ->where('p_prel.confirm_asistD','=',1)
            ->where('p_prel.id_docente_responsable','=',$idUser)
            ->where('p_prel.id_estado','=',1)
            ->where('p_prel.aprobacion_consejo_facultad','=',3)
            ->where('sol_prac.id_estado_solicitud_practica','=',5)
            ->where('p_prel.id','=',$id)
            ->first();
        }

        $rp = new stdClass();
        $rp->programa_academico = $proyeccion->programa_academico;
        $rp->espacio_academico = $proyeccion->espacio_academico;
        $rp->destino = $proyeccion->destino_rp;
        $rp->fecha_salida = $proyeccion->fecha_salida_aprox_rp;
        $rp->fecha_regreso = $proyeccion->fecha_regreso_aprox_rp;
        $rp->tipo_ruta = 1;
        
        $ra = new stdClass();
        $ra->programa_academico = $proyeccion->programa_academico;
        $ra->espacio_academico = $proyeccion->espacio_academico;
        $ra->destino = $proyeccion->destino_ra;
        $ra->fecha_salida = $proyeccion->fecha_salida_aprox_ra;
        $ra->fecha_regreso = $proyeccion->fecha_regreso_aprox_ra;
        $ra->tipo_ruta = 2;

        $rutas = array($rp,$ra);
        if(Auth::user()->id_role == 1)
        {
            return view('solicitudes.rutas.index_rutas',['proyeccion_preliminar'=>$proyeccion,
                                                        'rutas'=>$rutas, 
                                                        'usuario'=>$usuario,
                                                        'control_sistema'=>$control_sistema]);
                
        }

        if(Auth::user()->id_role == 4 && Auth::user()->id == $proyeccion->id_docente_responsable)
        {
            if($proyeccion->confirm_creador == 0 && $proyeccion->confirm_docente == 0 && $proyeccion->listado_estudiantes == 0)
            {
                return view('solicitudes.rutas.index_rutas',['proyeccion_preliminar'=>$proyeccion,
                                                                'rutas'=>$rutas, 
                                                                'usuario'=>$usuario,
                                                                'control_sistema'=>$control_sistema]);
            }
        }

        if($proyeccion->confirm_creador == 1 && $proyeccion->confirm_docente == 1 && $proyeccion->listado_estudiantes == 0)
        {
            $solicitud_practica = solicitud::where('id_proyeccion_preliminar', '=', $proyeccion->id)->first();
            return view('solicitudes.lista_estudiantes',['id_solicitud'=>$solicitud_practica->id,
                                                            'usuario'=>$usuario,
                                                            'control_sistema'=>$control_sistema]);
        }
        else if($proyeccion->confirm_creador == 0 && $proyeccion->confirm_docente == 0 && $proyeccion->listado_estudiantes == 0)
        {
            return view('solicitudes.rutas.index_rutas',['proyeccion_preliminar'=>$proyeccion,
                                                            'rutas'=>$rutas, 
                                                            'usuario'=>$usuario,
                                                            'control_sistema'=>$control_sistema]);
        }

    }

    /**
     * Envío de información de solicitud nueva
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function creacion_solic($id)
    {
        $correos_administrativos = [];
        $filter = "creacion_solic";
        $nueva_proyeccion = "";

        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                        ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                                'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'proy_pre.anio_periodo',
                                'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                                'sol_prac.num_estudiantes', 'docen_prac.total_docentes_apoyo', 'docen_prac.num_docentes_apoyo','docen_prac.total_docentes_apoyo', 'proy_pre.id_docente_responsable',
                                DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                        ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                        ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                        ->join('docentes_practica as docen_prac', 'proy_pre.id', 'docen_prac.id')
                        ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                        ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                        ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                        ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                        ->where('sol_prac.id','=',$id)->first();

        $id_creador = $nueva_solicitud->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        $id_esp_aca = $nueva_solicitud->id_esp_aca;
        $id_pro_aca = $nueva_solicitud->id_pro_aca;
        $coord =DB::table('users')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        
        $emails = [];

        $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];

        // foreach($emails as $email)
        // {

        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos));
        // }  
    }

    /**
     * Aprobación de la solicitud por coordinación
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function aprob_coord_solic($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "aprob_coord_solic";

        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                    ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                            'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
                            'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                            'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
                            DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                    ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                    ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                    ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                    ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                    ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                    ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                    ->where('proy_pre.id','=',$id)->first();                    

        $id_creador = $nueva_solicitud->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_solicitud->id_pro_aca;
        $coord =DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_programa_academico_coord','=',$id_pro_aca)
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Coordinador")->orWhere('rol.id','=',4)->first();
        $decano = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

        // foreach($emails as $email)
        // {

        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
        // }
    }

    /**
     * Rechazo de la solicitud por coordinación
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rechazo_coord_solic($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "rechazo_coord_solic";

        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                    ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                            'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad','proy_pre.observ_coordinador',
                            'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                            'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
                            DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                    ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                    ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                    ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                    ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                    ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                    ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                    ->where('proy_pre.id','=',$id)->first();                    

        $id_creador = $nueva_solicitud->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_solicitud->id_pro_aca;
        $coord =DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_programa_academico_coord','=',$id_pro_aca)
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Coordinador")->orWhere('rol.id','=',4)->first();
        $decano = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

        // foreach($emails as $email)
        // {

        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
        // }
    }

    /**
     * Cierre de la solicitud por coordinación
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cierre_coord_solic($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "cierre_coord_solic";

        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                            ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
                                    'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca', 'proy_pre.observ_coordinador','proy_pre.observ_decano',
                                    'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
                                    DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                            ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                            ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                            ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                            ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                            ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                            ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                            ->where('proy_pre.id','=',$id)->first();

        $id_creador = $nueva_solicitud->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_solicitud->id_pro_aca;
        $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

        // foreach($emails as $email)
        // {

        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
        // }
    }

    /**
     * Aprobación para ejecutar de la solicitud por coordinación
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function aprob_ejec_solic($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "aprob_ejec_solic";
        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                    ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                            'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
                            'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                            'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
                            DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                    ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                    ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                    ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                    ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                    ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                    ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                    ->where('proy_pre.id','=',$id)->first();    

        $id_creador = $nueva_solicitud->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_solicitud->id_pro_aca;
        $coord =DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_programa_academico_coord','=',$id_pro_aca)
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Coordinador")->orWhere('rol.id','=',4)->first();
        $decano = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];

        if($id_creador != $coord->id)
        {

            $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        }

        // foreach($emails as $email)
        // {
        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email, $correos_administrativos));
        // }
    }

    /**
     * Radicación para ejecutar de la solicitud por coordinación
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function radic_avance_tesor_solic($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "radic_avance_tesor_solic";
        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                    ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                            'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
                            'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                            'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
                            'sol_prac.radicado_financiera', 'sol_prac.num_radicado_financiera', 'sol_prac.fecha_radicado_financiera',
                            DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                    ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                    ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                    ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                    ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                    ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                    ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                    ->where('sol_prac.radicado_financiera','=',1)
                    ->where('proy_pre.id','=',$id)->first();    

        $id_creador = $nueva_solicitud->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_solicitud->id_pro_aca;
        $coord =DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_programa_academico_coord','=',$id_pro_aca)
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Coordinador")->orWhere('rol.id','=',4)->first();
        $decano = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

        // foreach($emails as $email)
        // {
        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email, $correos_administrativos ));
        // }
    }

    /**
     * Información de la solicitud para estudiantes
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function info_solic_estudiantes($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "info_solic_estudiantes";
        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                    ->select('sol_prac.id', 'sol_prac.id_proyeccion_preliminar','pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                            'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
                            'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                            'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
                            'sol_prac.radicado_financiera', 'sol_prac.num_radicado_financiera', 'sol_prac.fecha_radicado_financiera',
                            DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                    ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                    ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                    ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                    ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                    ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                    ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                    ->where('sol_prac.radicado_financiera','=',1)
                    ->where('proy_pre.id','=',$id)->first();    

        $estudiantes_practica =DB::table('estudiantes_solicitud_practica as estu_prac')
                    ->join('solicitud_practica as sol_prac', 'estu_prac.id_solicitud_practica', 'sol_prac.id')
                    ->where('sol_prac.id','=',$nueva_solicitud->id)->get();    

        $id_creador = $nueva_solicitud->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_solicitud->id_pro_aca;
        $coord =DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_programa_academico_coord','=',$id_pro_aca)
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Coordinador")->orWhere('rol.id','=',4)->first();
        $decano = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        // $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];
        $correos_administrativos = $emails;
        foreach($estudiantes_practica as $estudiante)
        {
            $emails[] = ["email"=>$estudiante->email,"role"=>$estudiante->id_role];
        }

        // foreach($emails as $email)
        // {
        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email,$correos_administrativos));
        // }
    }

    /**
     * Información de la solicitud para transportador
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function noti_transp_solic($id)
    {
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "noti_transp_solic";
        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                    ->select('proy_pre.id as id_proyeccion_preliminar','sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                            'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
                            'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                            'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
                            'sol_prac.radicado_financiera', 'sol_prac.num_radicado_financiera', 'sol_prac.fecha_radicado_financiera',
                            'sol_prac.hora_salida as hora_salida','sol_prac.hora_regreso as hora_regreso','sedes_salida_rp.sede as sede_salida_rp','sedes_salida_ra.sede as sede_salida_ra','sedes_regreso_rp.sede as sede_regreso_rp','sedes_regreso_ra.sede as sede_regreso_ra',
                            'sedes_salida_rp.direccion as direccion_salida_rp','sedes_salida_ra.direccion as direccion_salida_ra','sedes_regreso_rp.direccion as direccion_regreso_rp','sedes_regreso_ra.direccion as direccion_regreso_ra',
                            'proy_pre.lugar_salida_rp', 'proy_pre.lugar_regreso_rp','proy_pre.lugar_salida_ra', 'proy_pre.lugar_regreso_ra',
                            DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                    ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                    ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                    ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                    ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                    ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                    ->join('sedes_universidad as sedes_salida_rp', 'proy_pre.lugar_salida_rp', 'sedes_salida_rp.id')
                    ->join('sedes_universidad as sedes_salida_ra', 'proy_pre.lugar_salida_ra', 'sedes_salida_ra.id')
                    ->join('sedes_universidad as sedes_regreso_rp', 'proy_pre.lugar_regreso_rp', 'sedes_regreso_rp.id')
                    ->join('sedes_universidad as sedes_regreso_ra', 'proy_pre.lugar_regreso_ra', 'sedes_regreso_ra.id')
                    ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                    ->where('sol_prac.radicado_financiera','=',0)
                    ->where('proy_pre.id','=',$id)->first();    

        $estudiantes_practica =DB::table('estudiantes_solicitud_practica as estu_prac')
                    ->join('solicitud_practica as sol_prac', 'estu_prac.id_solicitud_practica', 'sol_prac.id')
                    ->where('sol_prac.id','=',$id)->get();    

        $id_creador = $nueva_solicitud->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_solicitud->id_pro_aca;
        $coord =DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_programa_academico_coord','=',$id_pro_aca)
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Coordinador")->orWhere('rol.id','=',4)->first();
        $decano = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $ViceAdmin = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Vicerrectoria Administrativa")->orWhere('rol.id','=',6)->first();
        $Transporte = DB::table('users')
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Transportador")->orWhere('rol.id','=',7)->first();        
        $emails = [];


        // $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        // $emails[] = ["email"=>$ViceAdmin->email,"role"=>$ViceAdmin->id_role];
        $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];
        $emails[] = ["email"=>$Transporte->email,"role"=>$Transporte->id_role];

        $correos_administrativos = $emails;
        // foreach($emails as $email)
        // {
        //     $role = $email['role'];
        //     if($role == 7)
        //     {
        //         Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email, $correos_administrativos));
        //     }
        // }
    }

    /**
     * Buscador de solicitud por palabras claves 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buscador(Request $request)
    {
        if($request && ($request->get('searchText')) != null)
        {
            $control_sistema =DB::table('control_sistema')->first();
            $query=trim($request->get('searchText'));
            $idUser =Auth::user()->id;
            $usuario =DB::table('users')
            ->where('id',$idUser)->first();


            $proyeccion=DB::table('proyeccion_preliminar as p_prel')
            ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                    'p_prel.destino_rp','sol_prac.fecha_salida as fecha_salida_aprox_rp','sol_prac.fecha_regreso as fecha_regreso_aprox_rp' ,'es_coor.abrev as ab_coor',
                    'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                    'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                    'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                    'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                    'sol_prac.tipo_ruta as tipo_ruta', 'sol_prac.id as id_solicitud',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
            ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
            ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
            ->join('users','p_prel.id_docente_responsable','=','users.id')
            ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
            ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
            ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
            ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
            // ->where('aprobacion_consejo_facultad','=',3)
            ->where('p_prel.id_estado','=',1)
            ->where('sol_prac.id','LIKE','%'.$query.'%')
            ->orWhere('users.primer_nombre','LIKE','%'.$query.'%')
            ->orWhere('users.segundo_nombre','LIKE','%'.$query.'%')
            ->orWhere('users.primer_apellido','LIKE','%'.$query.'%')
            ->orWhere('users.segundo_apellido','LIKE','%'.$query.'%')
            ->orWhere('p_aca.programa_academico','LIKE','%'.$query.'%')
            ->orWhere('e_aca.espacio_academico','LIKE','%'.$query.'%')
            ->orWhere('p_prel.destino_rp','LIKE','%'.$query.'%')
            ->orWhere('p_prel.destino_ra','LIKE','%'.$query.'%')
            
            ->paginate(20);
            return view('solicitudes.buscador.buscador',['proyecciones'=>$proyeccion, 
                                                            'searchText'=>$query, 
                                                            'usuario'=>$usuario,
                                                            'control_sistema'=>$control_sistema]);
        }
        else{
            return redirect('solicitudes/filtrar/all');
        }
    }

    /**
     * Muestra formulario con información de la solicitud 
     * asociado al transportador
     *
     * @param  int  $id
     * @param  int  $tipo_ruta
     * @return \Illuminate\Http\Response
     */
    public function showTransport($id,$tipo_ruta)
    {
        $id=Crypt::decrypt($id);
        $tipo_ruta=Crypt::decrypt($tipo_ruta);
        $idRole = Auth::user()->id_role;
        $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();

        $control_sistema =DB::table('control_sistema')->first();
        $sedes = DB::table('sedes_universidad')->get();
        switch($idRole)
        {
            case 1:
                $proyeccion_preliminar = proyeccion::find($id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                
                $programa_academico = DB::table('programa_academico')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $all_esp_aca=DB::table('espacio_academico')->get();
                $all_prog_aca=$programa_academico;
        
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }

                $estado_doc_respon =$usuario->id_estado;
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
                return view('proyecciones.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "all_programas_aca"=>$all_prog_aca,
                                                "all_espacios_aca"=>$all_esp_aca,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);

            break;

            case 2:
                $proyeccion_preliminar = proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);

                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                // ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
                // ->join('costos_proyeccion as c_proy','sol_prac.id_proyeccion_preliminar','=','c_proy.id')
                // ->join('docentes_practica as doc_prac','sol_prac.id_proyeccion_preliminar','=','doc_prac.id')
                // ->join('materiales_herramientas_proyeccion as mat_herr_proy','sol_prac.id_proyeccion_preliminar','=','mat_herr_proy.id')
                // ->join('riesgos_amenazas_practica as ries_amen_prac','sol_prac.id_proyeccion_preliminar','=','ries_amen_prac.id')
                // ->join('transporte_proyeccion as transp_proy','sol_prac.id_proyeccion_preliminar','=','transp_proy.id')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
                $doc_req_solic = documentos_requeridos_solicitud::find($solicitud_practica->id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();
                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                
                $docentes_activos=DB::table('users')
                // ->select(
                // DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                // ->join('proyeccion_preliminar as p_prel','users.id','=','p_prel.id_docente_responsable')
                // ->whereIn($proyeccion_preliminar->id_espacio_academico, ['users.id_espacio_academico_1', 'users.id_espacio_academico_2', 'users.id_espacio_academico_3', 
                // 'users.id_espacio_academico_4', 'users.id_espacio_academico_5', 'users.id_espacio_academico_6'])
                ->where('users.id_estado','=',1)
                ->where('users.id_role','=',5)
                ->where('users.id_espacio_academico_1','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_2','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_3','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_4','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_5','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_6','=',$proyeccion_preliminar->id_espacio_academico)->get();

                $estado_doc_respon =$usuario->id_estado;
        
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "docentes_activos"=>$docentes_activos,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "documentos_requeridos"=>$doc_req_solic,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);
            break;

            case 3:
                $proyeccion_preliminar = proyeccion::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);

                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
                $doc_req_solic = documentos_requeridos_solicitud::find($solicitud_practica->id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                
                $programa_academico = DB::table('programa_academico')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $all_esp_aca=DB::table('espacio_academico')->get();
                $all_prog_aca=$programa_academico;

                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }

                $estado_doc_respon =$usuario->id_estado;
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "all_programas_aca"=>$all_prog_aca,
                                                "all_espacios_aca"=>$all_esp_aca,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "documentos_requeridos"=>$doc_req_solic,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);
            break;

            case 4:
                $proyeccion_preliminar = proyeccion::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                
                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                // ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
                // ->join('costos_proyeccion as c_proy','sol_prac.id_proyeccion_preliminar','=','c_proy.id')
                // ->join('docentes_practica as doc_prac','sol_prac.id_proyeccion_preliminar','=','doc_prac.id')
                // ->join('materiales_herramientas_proyeccion as mat_herr_proy','sol_prac.id_proyeccion_preliminar','=','mat_herr_proy.id')
                // ->join('riesgos_amenazas_practica as ries_amen_prac','sol_prac.id_proyeccion_preliminar','=','ries_amen_prac.id')
                // ->join('transporte_proyeccion as transp_proy','sol_prac.id_proyeccion_preliminar','=','transp_proy.id')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();

                $doc_req_solic = documentos_requeridos_solicitud::find($solicitud_practica->id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                $idUser_log = Auth::user()->id;
                $usuario_log=DB::table('users')
                ->where('id','=',$idUser_log)->first();

                $usuario_respon=DB::table('users')
                ->where('id','=',$idUser)->first();

                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario_respon->id_espacio_academico_1, $usuario_respon->id_espacio_academico_2, $usuario_respon->id_espacio_academico_3, 
                $usuario_respon->id_espacio_academico_4, $usuario_respon->id_espacio_academico_5, $usuario_respon->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
        
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }
                
                $estado_doc_respon =$usuario_respon->id_estado;

                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario_log->primer_nombre.' '.$usuario_log->segundo_nombre.' '.$usuario_log->primer_apellido.' '.$usuario_log->segundo_apellido;
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                return view('solicitudes.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "usuario_log"=>$usuario_log,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "documentos_requeridos"=>$doc_req_solic,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario_log,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);
            break;

            case 5:
                $proyeccion_preliminar = proyeccion::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                
                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();

                $solicitud_transporte = solicitud_transporte::find($solicitud_practica->id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }

                $estado_doc_respon =$usuario->id_estado;
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        
                return view('solicitudes.formularios.show_transportador',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "sedes"=>$sedes,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'solicitud_transporte'=>$solicitud_transporte,
        
                ]);
            break;

            case 7:
                $proyeccion_preliminar = proyeccion::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $docentes_practica = docentes_practica::find($id);
                $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $solicitud_practica = DB::table('solicitud_practica as sol_prac')
                ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
                $idUser_resp = $proyeccion_preliminar->id_docente_responsable;
                $idUser = Auth::user()->id;
                $usuario_resp=DB::table('users')
                ->where('id','=',$idUser_resp)->first();
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario_resp->id_espacio_academico_1, $usuario_resp->id_espacio_academico_2, $usuario_resp->id_espacio_academico_3, 
                $usuario_resp->id_espacio_academico_4, $usuario_resp->id_espacio_academico_5, $usuario_resp->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];
            
                foreach($espacio_academico as $esp_aca)
                {
                    $prog_aca_user[] = [
                        'id'=>$esp_aca->id_programa_academico,
                        'programa_academico'=>$esp_aca->programa_academico,
                    ];
                    
                }

                $estado_doc_respon =$usuario_resp->id_estado;
                
                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario_resp->primer_nombre.' '.$usuario_resp->segundo_nombre.' '.$usuario_resp->primer_apellido.' '.$usuario_resp->segundo_apellido;
        
                return view('solicitudes.formularios.show_transportador',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "solicitud_practica"=>$solicitud_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "docentes_practica"=>$docentes_practica,
                                                "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "tipo_ruta"=>$tipo_ruta,
                                                "usuario_resp"=>$usuario_resp,
                                                "usuario"=>$usuario,
                                                'vlr_viaticos'=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);
            break;

            default;
        }
    }

    /**
     * Muestra formulario de informe de servicio de transporte
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public  function info_trans($id)
    {
        $id = Crypt::decrypt($id);
        $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();

        $control_sistema =DB::table('control_sistema')->first();
        $proyeccion_preliminar = proyeccion::find($id);
        $costos_proyeccion = costos_proyeccion::find($id);
        $docentes_practica = docentes_practica::find($id);
        $mate_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
        $riesg_amen_practica = riesgos_amenazas_practica::find($id);
        $transporte_proyeccion = transporte_proyeccion::find($id);
        
        $sedes = DB::table('sedes_universidad')->get();
        $solicitud_practica = DB::table('solicitud_practica as sol_prac')
        ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();

        $solicitud_transporte=solicitud_transporte::find($solicitud_practica->id);
        $idUser_resp = $proyeccion_preliminar->id_docente_responsable;
        $idUser = Auth::user()->id;
        $usuario_resp=DB::table('users')
        ->where('id','=',$idUser_resp)->first();
        $usuario=DB::table('users')
        ->where('id','=',$idUser)->first();

        $programa_academico = DB::table('programa_academico')->get();
        $espacio_academico=DB::table('espacio_academico as esp_aca')
        ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
        ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
        ->whereIn('esp_aca.id', [$usuario_resp->id_espacio_academico_1, $usuario_resp->id_espacio_academico_2, $usuario_resp->id_espacio_academico_3, 
        $usuario_resp->id_espacio_academico_4, $usuario_resp->id_espacio_academico_5, $usuario_resp->id_espacio_academico_6])->get();
        $periodo_academico=DB::table('periodo_academico')->get();
        $semestre_asignatura=DB::table('semestre_asignatura')->get();
        $tipo_transporte=DB::table('tipo_transporte')->get();
        
        $num_grupos_proy = 0; 
        
        $prog_aca_user = [];
        $esp_aca_user = [];
            
        foreach($espacio_academico as $esp_aca)
        {
            $prog_aca_user[] = [
                'id'=>$esp_aca->id_programa_academico,
                'programa_academico'=>$esp_aca->programa_academico,
            ];
            
        }        

        $estado_doc_respon =$usuario_resp->id_estado;
                
        $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
        $nomb_usuario = $usuario_resp->primer_nombre.' '.$usuario_resp->segundo_nombre.' '.$usuario_resp->primer_apellido.' '.$usuario_resp->segundo_apellido;
        
        $tipo_ruta = $solicitud_practica->tipo_ruta;
        return view('solicitudes.formularios.informe_transporte',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                        "sedes"=>$sedes,
                                        "programas_academicos"=>$programa_academico,
                                        "espacios_academicos"=>$espacio_academico,
                                        "periodos_academicos"=>$periodo_academico,
                                        "semestres_asignaturas"=>$semestre_asignatura,
                                        "tipos_transportes"=>$tipo_transporte,
                                        "programas_usuario"=>$newArray_prog,
                                        "nombre_usuario"=>$nomb_usuario,
                                        "estado_doc_respon"=>$estado_doc_respon,
                                        "solicitud_practica"=>$solicitud_practica,
                                        "costos_proyeccion"=>$costos_proyeccion,
                                        "docentes_practica"=>$docentes_practica,
                                        "mate_herra_proyeccion"=>$mate_herra_proyeccion,
                                        "riesg_amen_practica"=>$riesg_amen_practica,
                                        "transporte_proyeccion"=>$transporte_proyeccion,
                                        "solicitud_transporte"=>$solicitud_transporte,
                                        "tipo_ruta"=>$tipo_ruta,
                                        "usuario_resp"=>$usuario_resp,
                                        "usuario"=>$usuario,
                                        'vlr_viaticos'=>$vlr_viaticos,
                                        'control_sistema'=>$control_sistema]);
    }

    /**
     * Actualización de informe de servicio de transporte
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function encuesta_transp(Request $request, $id)
    {
        //$id = Crypt::decrypt($id);
        $idUser_log = Auth::user()->id;
        $solic_prac = DB::table('solicitud_practica as sol_prac')
        ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
        $id_proy =$solic_prac->id_proyeccion_preliminar;
        $transporte_proyeccion = transporte_proyeccion::find($id_proy);
        $encuesta_transporte = encuesta_transporte::where('id','=',$id)->first();
        $cant_transp = 0;

        if($solic_prac->tipo_ruta == 1)
        {
            if($transporte_proyeccion->cant_transporte_rp == 0 || $transporte_proyeccion->cant_transporte_rp == NULL || $transporte_proyeccion->cant_transporte_rp == '')
            {
                $cant_transp = 0;
            }
        }

        if($solic_prac->tipo_ruta == 2)
        {
            if($transporte_proyeccion->cant_transporte_ra == 0 || $transporte_proyeccion->cant_transporte_ra == NULL || $transporte_proyeccion->cant_transporte_ra == '')
            {
                $cant_transp = 0;
            }
        }

        if($cant_transp == 0)
        {
            $encuesta_transporte->cumplio_expect = 'N/A';
            $encuesta_transporte->ruta_prevista = 'N/A';
            $encuesta_transporte->carac_solicitadas = 'N/A';
            $encuesta_transporte->comport_adecuado = 'N/A';
            $encuesta_transporte->horar_estab = 'N/A';
            $encuesta_transporte->nov_cron_ruta = 'N/A';
            $encuesta_transporte->adecuado_traslado = 'N/A';
            $encuesta_transporte->no_adecuado_traslado = 'N/A';
            $encuesta_transporte->con_nov_cron_ruta = 'N/A';
            $encuesta_transporte->no_horar_estab = 'N/A';
            $encuesta_transporte->no_comport_adecuado = 'N/A';
            $encuesta_transporte->no_carac_solicitadas = 'N/A';
            $encuesta_transporte->no_ruta_prevista = 'N/A';
            $encuesta_transporte->no_cumplio_expect = 'N/A';
            $encuesta_transporte->diligenciado = 1;
        }
        
        else
        {
            if(Auth::user()->id_role == 1 ||  Auth::user()->id_role == 4 || Auth::user()->id_role == 5)
            {
                $encuesta_transporte->cumplio_expect = $request->get('cumplio_expect')=='on'?1:0;
                $encuesta_transporte->ruta_prevista = $request->get('ruta_prevista')=='on'?1:0;
                $encuesta_transporte->carac_solicitadas = $request->get('carac_solicitadas')=='on'?1:0;
                $encuesta_transporte->comport_adecuado = $request->get('comport_adecuado')=='on'?1:0;
                $encuesta_transporte->horar_estab = $request->get('horar_estab')=='on'?1:0;
                $encuesta_transporte->nov_cron_ruta = $request->get('nov_cron_ruta')=='on'?0:1;
                $encuesta_transporte->adecuado_traslado = $request->get('adecuado_traslado')=='on'?1:0;
                $encuesta_transporte->no_adecuado_traslado = $request->get('no_adecuado_traslado');
                $encuesta_transporte->con_nov_cron_ruta = $request->get('con_nov_cron_ruta');
                $encuesta_transporte->no_horar_estab = $request->get('no_horar_estab');
                $encuesta_transporte->no_comport_adecuado = $request->get('no_comport_adecuado');
                $encuesta_transporte->no_carac_solicitadas = $request->get('no_carac_solicitadas');
                $encuesta_transporte->no_ruta_prevista = $request->get('no_ruta_prevista');
                $encuesta_transporte->no_cumplio_expect = $request->get('no_cumplio_expect');
                $encuesta_transporte->diligenciado = 1;
            }
            if(Auth::user()->id_role == 3 || Auth::user()->id_role == 1)
            {
    
            }
            if(Auth::user()->id_role == 2 || Auth::user()->id_role == 1)
            {
    
            }
        }

        $encuesta_transporte->update();

        return redirect('solicitudes/filtrar/all');
    }

    /**
     * Muestra documentos cargados por estudiantes asociados a 
     * solicitud
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public  function ver_doc_estud($id)
    {
        $id = Crypt::decrypt($id);
        $idUser_log=Auth::user()->id;
        $control_sistema =DB::table('control_sistema')->first();
        $usuario=DB::table('users')
                ->where('id','=',$idUser_log)->first();

        $estud_practica =DB::table('estudiantes_solicitud_practica as estud_prac')
        ->join('solicitud_practica as sol_prac','estud_prac.id_solicitud_practica','sol_prac.id')
        ->where('sol_prac.id',$id)->get();

        $estudiantes_practica = [];

        foreach($estud_practica as $item)
        {
            $estudiantes_practica['id_solicitud_practica']=$item->id_solicitud_practica;
            $estudiantes_practica['nombre_completo']=$item->nombre_completo;
            $estudiantes_practica['celular']=$item->celular;
            $estudiantes_practica['email']=$item->email;

            if($item->certificado_eps != null)
            {
                $estudiantes_practica['cert_eps']='Si';
            }
            else{
                $estudiantes_practica['cert_eps']='No';
            }

            if($item->seguro_estudiantil != null)
            {
                $estudiantes_practica['seg_est']='Si';
            }
            else{
                $estudiantes_practica['seg_est']='No';
            }

            if($item->documento_identificacion != null)
            {
                $estudiantes_practica['doc_ident']='Si';
            }
            else{
                $estudiantes_practica['doc_ident']='No';
            }

            if($item->vacuna_fiebre_amarilla != null)
            {
                $estudiantes_practica['vac_fiebre_a']='Si';
            }
            else{
                $estudiantes_practica['vac_fiebre_a']='No';
            }

            if($item->vacuna_tetanos != null)
            {
                $estudiantes_practica['vac_tet']='Si';
            }
            else{
                $estudiantes_practica['vac_tet']='No';
            }

            $es_prac[] = $estudiantes_practica;
        }

        return view('solicitudes.formularios.estud_doc',["estudiantes_practica"=>$es_prac,
                                                        "usuario"=>$usuario,
                                                        'control_sistema'=>$control_sistema]);
    }

}
