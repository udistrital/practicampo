<?php

namespace PractiCampoUD\Http\Controllers\Programacion;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use PractiCampoUD\costos_programacion;
use PractiCampoUD\docentes_practica;
use PractiCampoUD\documentos_requeridos_solicitud;
use PractiCampoUD\estudiantes_practica;
use PractiCampoUD\materiales_herramientas_programacion;
use PractiCampoUD\practicas_integradas;
use PractiCampoUD\programacion;
use PractiCampoUD\riesgos_amenazas_practica;
use PractiCampoUD\solicitud;
use PractiCampoUD\transporte_menor;
use PractiCampoUD\transporte_programacion;
use PractiCampoUD\cambios_programacion;
use PractiCampoUD\User;
use PractiCampoUD\Mail\CodigoMail;
use Carbon\Carbon;
use DateTime;
use DB;
use Exception;

/**
 * programaciones practicas
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
class ProgramacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Listado de programaciones practicas
     *
     * @param  string  $filter
     * @return \Illuminate\Http\Response
     */
    public function filterprogramacion($filter)
    {
        $mytime = Carbon::now('America/Bogota');
        $idRole = Auth::user()->id_role;
        $idUser = Auth::user()->id;
        
        $user_DB= DB::table('users')
        ->where('id',$idUser)->first();

        $control_sistema =DB::table('control_sistema')->first();

        switch($idRole)
        {   
            case 1:
                 switch($filter)
                {
                    case 'all':
                        
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','es_consj.abrev as es_consj',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp',
                                'es_coor.abrev as ab_coor','es_dec.abrev  as ab_dec','p_prel.created_at as f_creacion')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->where('p_prel.id_estado',1)
                        // ->where('p_prel.aprobacion_consejo_facultad',5)
                        ->orderBy('p_aca.programa_academico', 'ASC')
                        ->paginate(10000);
                        
                        return view('programaciones.index',['programaciones'=>$programacion,
                                                            'filter'=>$filter,  
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    break;
                    case 'inact':
                        
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','es_consj.abrev as es_consj',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp',
                                'es_coor.abrev as ab_coor','es_dec.abrev  as ab_dec','p_prel.created_at as f_creacion')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->where('p_prel.id_estado',2)
                        // ->where('p_prel.aprobacion_consejo_facultad',5)
                        ->orderBy('p_aca.programa_academico', 'ASC')
                        ->paginate(10000);
                        
                        return view('programaciones.index',['programaciones'=>$programacion,
                                                            'filter'=>$filter,  
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    break;
                    case 'not_send_docente':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp',
                                'es_coor.abrev as ab_coor','es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj',
                                'p_prel.confirm_creador','p_prel.created_at as f_creacion')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        // ->where('aprobacion_coordinador','=',5)
                        ->where('confirm_creador','=',1)
                        ->where('confirm_docente','=',0)
                        // ->where('confirm_coord','=',0)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);

                        return view('programaciones.index',['programaciones'=>$programacion,
                                                            'filter'=>$filter,  
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    break;

                    default;
                }
            break;

            case 2:
                
                switch($filter)
                {
                    case 'aprob-cons':
                        $espacios = DB::table('espacio_academico as esp_aca')
                        ->where('electiva','=',1)->get();
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'c_proy.viaticos_docente_ra', 'c_proy.vlr_materiales_rp', 'c_proy.vlr_materiales_ra', 
                                'c_proy.vlr_otros_boletas_rp', 'c_proy.vlr_otros_boletas_ra', 'c_proy.vlr_guias_baquianos_rp', 'c_proy.vlr_guias_baquianos_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
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
                        $programacion = [];
                        foreach($espacios as $esp)
                        {
                            $programaciones=DB::table('programacion_practica as p_prel')
                            ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                    'e_aca.electiva', 'p_prel.id_espacio_academico', 'p_aca.programa_academico',
                                    'c_proy.vlr_otros_boletas_rp', 'c_proy.vlr_otros_boletas_ra', 'c_proy.vlr_guias_baquianos_rp', 'c_proy.vlr_guias_baquianos_ra', 
                                    'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                    'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                    'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                    'users.id_estado as id_estado_doc')
                            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                            ->join('users','p_prel.id_docente_responsable','=','users.id')
                            ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                            ->where('p_prel.id_estado','=',1)
                            ->where('p_prel.id_espacio_academico','<>',999)
                            ->where('p_prel.id_espacio_academico','=',$esp->id)->get();
                            
                            if(count($programaciones)==0)
                            {
                                $programacion[] = $esp;
                            }
                            
                        }
                        return view('programaciones.index',['programaciones'=>$programacion, 
                                                            'filter'=>$filter, 
                                                            'usuario'=>$user_DB, 
                                                            'control_sistema'=>$control_sistema]);

                    break;
                    
                    case 'elect':
                        $espacios = DB::table('espacio_academico as esp_aca')
                        ->where('electiva','=',1)->get();
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','users.id_estado as id_estado_doc','es_consj.abrev as es_consj',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'c_proy.viaticos_docente_ra', 'c_proy.vlr_materiales_rp', 'c_proy.vlr_materiales_ra', 
                                'c_proy.vlr_otros_boletas_rp', 'c_proy.vlr_otros_boletas_ra', 'c_proy.vlr_guias_baquianos_rp', 'c_proy.vlr_guias_baquianos_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('confirm_creador','=',1)
                        ->where('confirm_coord','=',1)
                        ->where('confirm_electiva_coord','=',1)
                        ->where('e_aca.electiva','=',1)
                        ->where('aprobacion_coordinador','=',7)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                    break;

                    case 'pend':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','users.id_estado as id_estado_doc','es_consj.abrev as es_consj',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec', 'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 
                                'c_proy.viaticos_estudiantes_ra', 'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                'c_proy.viaticos_docente_ra', 'c_proy.vlr_materiales_rp', 'c_proy.vlr_materiales_ra', 'c_proy.vlr_otros_boletas_rp', 'c_proy.vlr_otros_boletas_ra', 
                                'c_proy.vlr_guias_baquianos_rp', 'c_proy.vlr_guias_baquianos_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('p_prel.aprobacion_asistD','=',7)
						->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.aprobacion_decano','=',5)
                        ->where('p_prel.confirm_asistD','=',1)
						->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                    break;

                    case 'aprob':
                            $programacion=DB::table('programacion_practica as p_prel')
                            ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','users.id_estado as id_estado_doc','es_consj.abrev as es_consj',
                                    'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                    'es_dec.abrev  as ab_dec', 'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 
                                    'c_proy.viaticos_estudiantes_ra', 'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                    'c_proy.viaticos_docente_ra', 'c_proy.vlr_materiales_rp', 'c_proy.vlr_materiales_ra', 
                                    'c_proy.vlr_otros_boletas_rp', 'c_proy.vlr_otros_boletas_ra', 'c_proy.vlr_guias_baquianos_rp', 'c_proy.vlr_guias_baquianos_ra', 
                                    'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                    'p_prel.created_at as f_creacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                            ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                            ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                            ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                            ->join('users','p_prel.id_docente_responsable','=','users.id')
                            ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                            ->where('p_prel.aprobacion_asistD','=',7)
                            ->where('p_prel.aprobacion_decano','=',7)
                            ->where('p_prel.confirm_asistD','=',1)
                            ->where('p_prel.id_estado','=',1)
                            ->paginate(10000);
                    break;
                    
                    case 'all':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','users.id_estado as id_estado_doc',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor','es_dec.abrev  as ab_dec',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'c_proy.viaticos_docente_ra', 'c_proy.vlr_materiales_rp', 'c_proy.vlr_materiales_ra', 
                                'c_proy.vlr_otros_boletas_rp', 'c_proy.vlr_otros_boletas_ra', 'c_proy.vlr_guias_baquianos_rp', 'c_proy.vlr_guias_baquianos_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'es_consj.abrev  as es_consj','p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.aprobacion_asistD','=',7)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                        
                    break;

                    case 'edit_proy':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','users.id_estado as id_estado_doc',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor','es_dec.abrev  as ab_dec',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra', 
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'c_proy.viaticos_docente_ra', 'c_proy.vlr_materiales_rp', 'c_proy.vlr_materiales_ra', 
                                'c_proy.vlr_otros_boletas_rp', 'c_proy.vlr_otros_boletas_ra', 'c_proy.vlr_guias_baquianos_rp', 'c_proy.vlr_guias_baquianos_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'es_consj.abrev  as es_consj','p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.aprobacion_asistD','=',7)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where('p_prel.aprobacion_consejo_facultad','=',5)
                        ->paginate(10000);
                        
                    break;

                    default;
                }

            break;

            case 3:
                switch($filter)
                {

                    case 'no-aprob-cons':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico','es_consj.abrev as es_consj',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','p_prel.confirm_coord', 'c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'p_prel.aprobacion_coordinador','users.id_estado as id_estado_doc','p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.aprobacion_decano','=',7)
                        ->where('p_prel.aprobacion_asistD','=',7)
                        ->where('p_prel.aprobacion_consejo_facultad','=',5)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                    break;

                    case 'send':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico','users.id_estado as id_estado_doc',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor','es_consj.abrev as es_consj',
                                'es_dec.abrev  as ab_dec','p_prel.confirm_coord','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.confirm_asistD','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                    break;

                    case 'not_send':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico','es_consj.abrev as es_consj',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','p_prel.confirm_coord', 'c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'p_prel.aprobacion_coordinador','users.id_estado as id_estado_doc','p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.aprobacion_asistD','=',7)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',0)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                    break;

                    case 'sin_pres':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico','es_consj.abrev as es_consj',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor','users.id_estado as id_estado_doc',
                                'es_dec.abrev  as ab_dec','p_prel.confirm_coord', 'c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.aprobacion_asistD','=',5)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.confirm_asistD','=',0)
                        ->where('p_prel.id_estado','=',1)
                        ->where(function($query){
                            $query->where('valor_estimado_transporte_rp','=',0)
                                  ->orWhere('valor_estimado_transporte_rp','=',null)
                                  ->orWhere('valor_estimado_transporte_ra','=',0)
                                  ->orWhere('valor_estimado_transporte_ra','=',null);
                        })
                        ->paginate(10000);
                    break;
                    
                    case 'all':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_coord','users.id_estado as id_estado_doc',
                                'p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->where('p_prel.aprobacion_coordinador','=',7)
                        ->where('p_prel.confirm_coord','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                    break;

                    default;
                }
            break;

            case 4:
                switch($filter)
                {
                    case 'send':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $idProgAca_asociado = Auth::user()->id_programa_academico_coord;
                        $espacios=DB::table('espacio_academico as esp_aca')
                        ->where('id_programa_academico','=',$idProgAca_asociado)->get();
                        $programacion=DB::table('programacion_practica as p_prel','e_aca.confirm_coord')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev as es_consj','users.id_estado as id_estado_doc','p_prel.confirm_coord',
                                'p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->where('aprobacion_coordinador','=',7)
                        ->where('confirm_creador','=',1)
                        ->where('confirm_coord','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('p_prel.id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);
                    break;

                    case 'not_send':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $idProgAca_asociado = Auth::user()->id_programa_academico_coord;
                        $espacios=DB::table('espacio_academico as esp_aca')
                        ->where('id_programa_academico','=',$idProgAca_asociado)->get();
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','e_aca.electiva','p_prel.confirm_coord','users.id_estado as id_estado_doc',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->where('aprobacion_coordinador','=',7)
                        ->where('confirm_creador','=',1)
                        ->where('confirm_coord','=',0)
                        ->where('p_prel.id_estado','=',1)
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('p_prel.id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);

                    break;

                    case 'pend':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','es_consj.abrev  as es_consj','users.id_estado as id_estado_doc',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec', 'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp',
                                'c_proy.viaticos_estudiantes_ra', 'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('p_prel.aprobacion_coordinador','=',5)
                        ->where('confirm_creador','=',1)
                        ->where('confirm_docente','=',1)
                        ->where('confirm_coord','=',0)
                        ->where('p_prel.id_estado','=',1)
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('p_prel.id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);
		break;

			case 'proy_recha_cons':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','es_consj.abrev  as es_consj','users.id_estado as id_estado_doc',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec', 'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp',
                                'c_proy.viaticos_estudiantes_ra', 'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'p_prel.created_at as f_creacion', 'p_prel.aprobacion_consejo_facultad',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->where('p_prel.aprobacion_consejo_facultad','=',4)
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('p_prel.id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);
                    break;
                    
                    case 'all':
                        $idProgAca_asociado = Auth::user()->id_programa_academico_coord;
                        // $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $idProgAca_asociado;
                        $espacios=DB::table('espacio_academico as esp_aca')
                        ->where('id_programa_academico','=',$idProgAca_asociado)->get();
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','users.id_estado as id_estado_doc','p_prel.confirm_coord',
                                'p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
			->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        // ->where('id_docente_responsable','=',$idUser)
                        // ->where('aprobacion_coordinador','=',5)
                        // ->where('e_aca.id_programa_academico','=',$idProgAca_asociado)
                        ->where('confirm_creador','=',1)
                        ->where('p_prel.id_estado','=',1)
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('p_prel.id_programa_academico','=',$id_prog_coord);
                        })
                        // ->orWhere('aprobacion_coordinador','=',3)
                        // ->orWhere('aprobacion_decano','=',5)
                        ->paginate(10000);
                    break;

                    default;
                }
            break;

            case 5:
                switch($filter)
                {
                    case 'send':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','es_consj.abrev  as es_consj',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','p_prel.confirm_creador', 'p_prel.confirm_coord',
                                'p_prel.created_at as f_creacion')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        // ->where('aprobacion_coordinador','=',5)
                        ->where('confirm_creador','=',1)
                        ->where('confirm_docente','=',1)
                        // ->where('confirm_coord','=',1)
                        ->where('id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);
                    break;

                    case 'not_send':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'p_prel.created_at as f_creacion')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        // ->where('aprobacion_coordinador','=',5)
                        ->where('confirm_creador','=',1)
                        ->where('confirm_docente','=',0)
                        ->where('confirm_coord','=',0)
                        ->where('id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->paginate(10000);

                    break;

                    case 'proy_recha':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'p_prel.created_at as f_creacion')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        // ->where('aprobacion_coordinador','=',5)
                        ->where('id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->where('aprobacion_coordinador','=',4)
                        ->orWhere('aprobacion_consejo_facultad','=',4)
                        ->paginate(10000);
                    break;

                    case 'all':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'p_prel.created_at as f_creacion')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->where('id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        // ->where('aprobacion_coordinador','=',5)
                        // ->where('confirm_creador','=',0)
                        
                        ->paginate(10000);
                        
                    break;

                    case 'proy_legal':
                        $year = $mytime->year;
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_dec.abrev  as ab_dec','e_aca.electiva','p_prel.confirm_coord','es_consj.abrev as es_consj','users.id_estado as id_estado_doc',
                                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra', 'c_proy.viaticos_estudiantes_rp', 'c_proy.viaticos_estudiantes_ra',
                                'c_proy.viaticos_docente_rp', 'c_proy.viaticos_docente_ra', 'es_coor_sol.abrev as ap_coor','es_dec_sol.abrev as ap_dec',
                                'c_proy.total_presupuesto_rp','c_proy.total_presupuesto_ra','c_proy.valor_estimado_transporte_rp','c_proy.valor_estimado_transporte_ra',
                                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud','p_prel.created_at as f_creacion',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_programacion_practica')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('sol_prac.id_estado_solicitud_practica','=',6)
                        ->where('p_prel.id_estado','=',6)
                        ->paginate(10000);
                        
                    break;

                    case 'traspasar':
                        $programacion=DB::table('programacion_practica as p_prel')
                        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                                'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
                                'es_dec.abrev  as ab_dec','es_consj.abrev  as es_consj','p_prel.confirm_creador',
                                'p_prel.created_at as f_creacion')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('estado as es_coor','p_prel.aprobacion_coordinador','=','es_coor.id')
                        ->join('estado as es_dec','p_prel.aprobacion_decano','=','es_dec.id')
                        ->join('estado as es_consj','p_prel.aprobacion_consejo_facultad','=','es_consj.id')
                        ->where('id_docente_responsable','=',$idUser)
                        ->where('p_prel.id_estado','=',1)
                        ->whereIn('p_prel.aprobacion_coordinador', ['5','4'])
                        ->whereIn('p_prel.aprobacion_decano', ['5','4'])
                        
                        ->paginate(10000);
                        
                    break;

                    default;
                }
            break;
        }
        
        return view('programaciones.index',['programaciones'=>$programacion, 
                                            'filter'=>$filter, 
                                            'usuario'=>$user_DB, 
                                            'control_sistema'=>$control_sistema]);
    }

    /**
     * Muestra el formulario para registro de nueva 
     * Programación practica
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mytime = Carbon::now('America/Bogota')->format('d-m-Y');
        $hoy=$this->obtenerFechaEnLetra($mytime);
        $control_sistema =DB::table('control_sistema')->first();
        $id = Auth::user()->id;
        $usuario=User::find($id);
        $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
        $programacion_practica=DB::table('programacion_practica')->get();
        $sedes=DB::table('sedes_universidad as sedes')->get();
        $programa_academico=DB::table('programa_academico')->get();
        $espacio_academico=DB::table('espacio_academico as esp_aca')
        ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                 'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
        ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
        ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
        $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
        $semestre_asignatura=DB::table('semestre_asignatura')->get();
        $periodo_academico=DB::table('periodo_academico')->get();
        $tipo_zona_transitar=DB::table('tipo_zona_transitar')->get();
        $tipo_transporte=DB::table('tipo_transporte')->get();
        $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();
        $docentes=DB::table('users')
        ->select('users.id',DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
        ->where('id_role',5)
        ->where('id','!=',Auth::user()->id)
        ->orderBy('users.primer_nombre','ASC')
        ->get();                        

        $prog_aca_user = [];
        $esp_aca_user = [];
       
        foreach($espacio_academico as $esp_aca)
        {
            $prog_aca_user[] = [
                'id'=>$esp_aca->id_programa_academico,
                'programa_academico'=>$esp_aca->programa_academico,
            ];
            
        }

        $newArray = array_unique($prog_aca_user, SORT_REGULAR);

        return view('programaciones.create', [
                                            "programacion_practica"=>$programacion_practica,
                                            "sedes"=>$sedes,
                                            "programas_academicos"=>$programa_academico,
                                            "espacios_academicos"=>$espacio_academico,
                                            "semestres_asignaturas"=>$semestre_asignatura,
                                            "periodos_academicos"=>$periodo_academico,
                                            "tipos_zonas_transitar"=>$tipo_zona_transitar,
                                            "tipos_transportes"=>$tipo_transporte,
                                            "programas_usuario"=>$newArray,
                                            "nombre_usuario"=>$nomb_usuario, 
                                            'usuario'=>$usuario,
                                            'vlr_viaticos'=>$vlr_viaticos,
                                            'control_sistema'=>$control_sistema,
                                            'hoy'=>$hoy,
                                            'docentes'=>$docentes,

        ]);
    }

    /**
     * Registro de nueva Programación practica
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idRole = Auth::user()->id_role;
        $idUser = Auth::user()->id;
        $mytime = Carbon::now('America/Bogota');
        $control_sistema=DB::table('control_sistema as control')->first();
        $vlr_estud_max_estimado=$control_sistema->vlr_estud_max_estimado;
        $vlr_estud_min_estimado=$control_sistema->vlr_estud_min_estimado;
        $vlr_docen_max_estimado=$control_sistema->vlr_docen_max_estimado;
        $vlr_docen_min_estimado=$control_sistema->vlr_docen_min_estimado;

        $tipo_transporte_rp = $request->get('id_tipo_transporte_rp_');
        $tipo_transporte_ra = $request->get('id_tipo_transporte_ra_');
        $det_tipo_transporte_rp = $request->get('det_tipo_transporte_rp_');
        $det_tipo_transporte_ra = $request->get('det_tipo_transporte_ra_');
        $capacid_transporte_rp = $request->get('capac_transporte_rp_');
        $capacid_transporte_ra = $request->get('capac_transporte_ra_');
        $docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
        $docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
        $id_esp_aca = $request->get('id_espacio_academico');
        $id_prog_aca = $request->get('id_programa_academico');

        $esp_aca = DB::table('espacio_academico')
        ->where('id','=',$id_esp_aca)->first();

        $prog_aca = DB::table('programa_academico')
        ->where('id','=',$id_prog_aca)->first();

        /**Tabla programacion_practica */
            $programacion_practica = new programacion;
            $programacion_practica->id_estado = 1;
            $programacion_practica->practicas_integradas = intval($request->get('integrada'));
            $programacion_practica->id_programa_academico=$id_prog_aca;
            $programacion_practica->id_espacio_academico=$esp_aca->id;
            $programacion_practica->id_periodo_academico=$request->get('id_periodo_academico');
            $programacion_practica->anio_periodo=$request->get('anio_periodo');
            $programacion_practica->id_semestre_asignatura=$request->get('id_semestre_asignatura');
            $programacion_practica->num_estudiantes_aprox=$request->get('num_estudiantes_aprox');
            $programacion_practica->cantidad_grupos=$request->get('cant_grupos');

            switch($programacion_practica->cantidad_grupos=$request->get('cant_grupos'))
            {
                case "1":
                    $programacion_practica->grupo_1=$request->get('grupo_1');
                    $programacion_practica->grupo_2=null;
                    $programacion_practica->grupo_3=null;
                    $programacion_practica->grupo_4=null;
                    break;
                case "2":
                    $programacion_practica->grupo_1=$request->get('grupo_1');
                    $programacion_practica->grupo_2=$request->get('grupo_2');
                    $programacion_practica->grupo_3=null;
                    $programacion_practica->grupo_4=null;
                    break;
                case "3":
                    $programacion_practica->grupo_1=$request->get('grupo_1');
                    $programacion_practica->grupo_2=$request->get('grupo_2');
                    $programacion_practica->grupo_3=$request->get('grupo_3');
                    $programacion_practica->grupo_4=null;
                    break;
                case "4":
                    $programacion_practica->grupo_1=$request->get('grupo_1');
                    $programacion_practica->grupo_2=$request->get('grupo_2');
                    $programacion_practica->grupo_3=$request->get('grupo_3');
                    $programacion_practica->grupo_4=$request->get('grupo_4');
                    break;
            }

            $programacion_practica->realizada_bogota_rp=$request->get('realizada_bogota_rp');
            $programacion_practica->realizada_bogota_ra=$request->get('realizada_bogota_ra');
            $programacion_practica->destino_rp=$request->get('destino_rp');
            $programacion_practica->destino_ra=$request->get('destino_ra');
            $programacion_practica->cantidad_url_rp=$request->get('cant_url_rp');
            $programacion_practica->cantidad_url_ra=$request->get('cant_url_ra');

            switch($programacion_practica->cantidad_url_rp=$request->get('cant_url_rp'))
            {
                case"1":
                    $programacion_practica->ruta_principal=$request->get('ruta_principal');
                    $programacion_practica->ruta_principal_2=null;
                    $programacion_practica->ruta_principal_3=null;
                    $programacion_practica->ruta_principal_4=null;
                    $programacion_practica->ruta_principal_5=null;
                    $programacion_practica->ruta_principal_6=null;
                    break;
                case"2":
                    $programacion_practica->ruta_principal=$request->get('ruta_principal');
                    $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                    $programacion_practica->ruta_principal_3=null;
                    $programacion_practica->ruta_principal_4=null;
                    $programacion_practica->ruta_principal_5=null;
                    $programacion_practica->ruta_principal_6=null;
                    break;
                case"3":
                    $programacion_practica->ruta_principal=$request->get('ruta_principal');
                    $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                    $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                    $programacion_practica->ruta_principal_4=null;
                    $programacion_practica->ruta_principal_5=null;
                    $programacion_practica->ruta_principal_6=null;
                    break;
                case"4":
                    $programacion_practica->ruta_principal=$request->get('ruta_principal');
                    $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                    $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                    $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                    $programacion_practica->ruta_principal_5=null;
                    $programacion_practica->ruta_principal_6=null;
                    break;
                case"5":
                    $programacion_practica->ruta_principal=$request->get('ruta_principal');
                    $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                    $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                    $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                    $programacion_practica->ruta_principal_5=$request->get('ruta_principal_5');
                    $programacion_practica->ruta_principal_6=null;
                    break;
                case"6":
                    $programacion_practica->ruta_principal=$request->get('ruta_principal');
                    $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                    $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                    $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                    $programacion_practica->ruta_principal_5=$request->get('ruta_principal_5');
                    $programacion_practica->ruta_principal_6=$request->get('ruta_principal_6');
                    break;
            }
            
            switch($programacion_practica->cantidad_url_ra=$request->get('cant_url_ra'))
            {
                case "1":
                    $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                    $programacion_practica->ruta_alterna_2=null;
                    $programacion_practica->ruta_alterna_3=null;
                    $programacion_practica->ruta_alterna_4=null;
                    $programacion_practica->ruta_alterna_5=null;
                    $programacion_practica->ruta_alterna_6=null;
                    break;
                case "2":
                    $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                    $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                    $programacion_practica->ruta_alterna_3=null;
                    $programacion_practica->ruta_alterna_4=null;
                    $programacion_practica->ruta_alterna_5=null;
                    $programacion_practica->ruta_alterna_6=null;
                    break;
                case "3":
                    $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                    $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                    $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                    $programacion_practica->ruta_alterna_4=null;
                    $programacion_practica->ruta_alterna_5=null;
                    $programacion_practica->ruta_alterna_6=null;
                    break;
                case "4":
                    $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                    $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                    $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                    $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                    $programacion_practica->ruta_alterna_5=null;
                    $programacion_practica->ruta_alterna_6=null;
                    break;
                case "5":
                    $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                    $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                    $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                    $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                    $programacion_practica->ruta_alterna_5=$request->get('ruta_alterna_5');
                    $programacion_practica->ruta_alterna_6=null;
                    break;
                case "6":
                    $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                    $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                    $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                    $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                    $programacion_practica->ruta_alterna_5=$request->get('ruta_alterna_5');
                    $programacion_practica->ruta_alterna_6=$request->get('ruta_alterna_6');
                    break;
            }
            
            $programacion_practica->det_recorrido_interno_rp=$request->get('det_recorrido_interno_rp');
            $programacion_practica->det_recorrido_interno_ra=$request->get('det_recorrido_interno_ra');
            $programacion_practica->lugar_salida_rp=$request->get('lugar_salida_rp');
            $programacion_practica->lugar_salida_ra=$request->get('lugar_salida_ra');
            $programacion_practica->lugar_regreso_rp=$request->get('lugar_regreso_rp');
            $programacion_practica->lugar_regreso_ra=$request->get('lugar_regreso_ra');
            $programacion_practica->fecha_salida_aprox_rp=$request->get('fecha_salida_aprox_rp');
            $programacion_practica->fecha_salida_aprox_ra=$request->get('fecha_salida_aprox_ra');
            $programacion_practica->fecha_regreso_aprox_rp=$request->get('fecha_regreso_aprox_rp');
            $programacion_practica->fecha_regreso_aprox_ra=$request->get('fecha_regreso_aprox_ra');
            
            $fecha_salida_rp = new DateTime($programacion_practica->fecha_salida_aprox_rp);
            $fecha_regreso_rp = new DateTime($programacion_practica->fecha_regreso_aprox_rp);
            $num_dias_rp = $fecha_salida_rp->diff($fecha_regreso_rp);
            $programacion_practica->duracion_num_dias_rp=$num_dias_rp->days+1;
            $fecha_salida_ra = new DateTime($programacion_practica->fecha_salida_aprox_ra);
            $fecha_regreso_ra = new DateTime($programacion_practica->fecha_regreso_aprox_ra);
            $num_dias_ra = $fecha_salida_ra->diff($fecha_regreso_ra);
            $programacion_practica->duracion_num_dias_ra=$num_dias_ra->days+1;
            $programacion_practica->id_docente_responsable=Auth::user()->id;
            $programacion_practica->aprobacion_coordinador= 5;

            $programacion_practica->aprobacion_asistD= 5;

            $programacion_practica->aprobacion_decano= 5;
            $programacion_practica->aprobacion_consejo_facultad= 5;

            if($idRole == 5 || $idRole == 1)
            {
                $programacion_practica->confirm_creador= 1;
                $programacion_practica->id_creador_confirm = Auth::user()->id;
                $programacion_practica->confirm_docente= 1;
                $programacion_practica->confirm_coord= 0;
                $programacion_practica->confirm_asistD= 0;
            }
            else
            {
                $programacion_practica->confirm_creador= 0;
                $programacion_practica->id_creador_confirm = Auth::user()->id;
                $programacion_practica->confirm_coord= 0;
                $programacion_practica->confirm_asistD= 0;
                $programacion_practica->confirm_electiva_coord= 0;

                if($idRole == 4)
                {
                    $programacion_practica->confirm_creador= 1;
                    $programacion_practica->id_creador_confirm = Auth::user()->id;
                    $programacion_practica->confirm_docente= 1;
                    $programacion_practica->id_docente_confirm = Auth::user()->id;
                }
            }
            
            $programacion_practica->fecha_diligenciamiento=$mytime->toDateTimeString();

            $programacion_practica->save();
            $id = $programacion_practica->id;
        /**Tabla programacion_practica */

        /**Tabla practicas_integradas */
            $espa_aca_1=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_1'))->first();
            $espa_aca_2=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_2'))->first();
            $espa_aca_3=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_3'))->first();
            $espa_aca_4=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_4'))->first();
            $espa_aca_5=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_5'))->first();
            $espa_aca_6=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_6'))->first();
            $espa_aca_7=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_7'))->first();
            $practicas_integradas = new practicas_integradas;
            $practicas_integradas->id=$id;
            $cant_espa_aca = $request->get('cant_espa_aca');

            if($programacion_practica->practicas_integradas == 0)
            {
                $cant_espa_aca = 0;
            }
            else if($programacion_practica->practicas_integradas == 1)
            {
                $practicas_integradas->cant_espa_aca=$cant_espa_aca;
            }

            // $practicas_integradas->cant_espa_aca=$request->get('cant_espa_aca');

            switch($practicas_integradas->cant_espa_aca)
            {
                case "0":
                    $practicas_integradas->id_espa_aca_1=null;
                    $practicas_integradas->id_espa_aca_2=null;
                    $practicas_integradas->id_espa_aca_3=null;
                    $practicas_integradas->id_espa_aca_4=null;
                    $practicas_integradas->id_espa_aca_5=null;
                    $practicas_integradas->id_espa_aca_6=null;
                    $practicas_integradas->id_espa_aca_7=null;
                    $practicas_integradas->id_docen_espa_aca_1=null;
                    $practicas_integradas->id_docen_espa_aca_2=null;
                    $practicas_integradas->id_docen_espa_aca_3=null;
                    $practicas_integradas->id_docen_espa_aca_4=null;
                    $practicas_integradas->id_docen_espa_aca_5=null;
                    $practicas_integradas->id_docen_espa_aca_6=null;
                    $practicas_integradas->id_docen_espa_aca_7=null;
                    break;
                case "1":
                    $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                    $practicas_integradas->id_espa_aca_2=null;
                    $practicas_integradas->id_espa_aca_3=null;
                    $practicas_integradas->id_espa_aca_4=null;
                    $practicas_integradas->id_espa_aca_5=null;
                    $practicas_integradas->id_espa_aca_6=null;
                    $practicas_integradas->id_espa_aca_7=null;
                    $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                    $practicas_integradas->id_docen_espa_aca_2=null;
                    $practicas_integradas->id_docen_espa_aca_3=null;
                    $practicas_integradas->id_docen_espa_aca_4=null;
                    $practicas_integradas->id_docen_espa_aca_5=null;
                    $practicas_integradas->id_docen_espa_aca_6=null;
                    $practicas_integradas->id_docen_espa_aca_7=null;
                    break;
                case "2":
                    $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                    $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                    $practicas_integradas->id_espa_aca_3=null;
                    $practicas_integradas->id_espa_aca_4=null;
                    $practicas_integradas->id_espa_aca_5=null;
                    $practicas_integradas->id_espa_aca_6=null;
                    $practicas_integradas->id_espa_aca_7=null;
                    $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                    $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                    $practicas_integradas->id_docen_espa_aca_3=null;
                    $practicas_integradas->id_docen_espa_aca_4=null;
                    $practicas_integradas->id_docen_espa_aca_5=null;
                    $practicas_integradas->id_docen_espa_aca_6=null;
                    $practicas_integradas->id_docen_espa_aca_7=null;
                    break;
                case "3":
                    $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                    $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                    $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                    $practicas_integradas->id_espa_aca_4=null;
                    $practicas_integradas->id_espa_aca_5=null;
                    $practicas_integradas->id_espa_aca_6=null;
                    $practicas_integradas->id_espa_aca_7=null;
                    $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                    $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                    $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                    $practicas_integradas->id_docen_espa_aca_4=null;
                    $practicas_integradas->id_docen_espa_aca_5=null;
                    $practicas_integradas->id_docen_espa_aca_6=null;
                    $practicas_integradas->id_docen_espa_aca_7=null;
                    break;
                case "4":
                    $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                    $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                    $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                    $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                    $practicas_integradas->id_espa_aca_5=null;
                    $practicas_integradas->id_espa_aca_6=null;
                    $practicas_integradas->id_espa_aca_7=null;
                    $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                    $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                    $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                    $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                    $practicas_integradas->id_docen_espa_aca_5=null;
                    $practicas_integradas->id_docen_espa_aca_6=null;
                    $practicas_integradas->id_docen_espa_aca_7=null;
                    break;
                case "5":
                    $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                    $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                    $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                    $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                    $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                    $practicas_integradas->id_espa_aca_6=null;
                    $practicas_integradas->id_espa_aca_7=null;
                    $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                    $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                    $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                    $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                    $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                    $practicas_integradas->id_docen_espa_aca_6=null;
                    $practicas_integradas->id_docen_espa_aca_7=null;
                    break;
                case "6":
                    $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                    $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                    $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                    $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                    $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                    $practicas_integradas->id_espa_aca_6=$espa_aca_6->id;
                    $practicas_integradas->id_espa_aca_7=null;
                    $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                    $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                    $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                    $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                    $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                    $practicas_integradas->id_docen_espa_aca_6=$request->get('id_docen_espa_aca_6');
                    $practicas_integradas->id_docen_espa_aca_7=null;
                    break;
                case "7":
                    $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                    $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                    $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                    $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                    $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                    $practicas_integradas->id_espa_aca_6=$espa_aca_6->id;
                    $practicas_integradas->id_espa_aca_7=$espa_aca_7->id;
                    $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                    $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                    $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                    $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                    $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                    $practicas_integradas->id_docen_espa_aca_6=$request->get('id_docen_espa_aca_6');
                    $practicas_integradas->id_docen_espa_aca_7=$request->get('id_docen_espa_aca_7');
                    break;
            }
            for ($i = 1; $i <= 7; $i++) {
                if ($i <= $practicas_integradas->cant_espa_aca) {
                    $practicas_integradas->{"es_responsable_$i"} = (int) $request->get("integrada_responsable_$i");
                } else {
                    $practicas_integradas->{"es_responsable_$i"} = null;
                }
            }
            $practicas_integradas->save();
        /**Tabla practicas_integradas */
            
        /**Tabla docentes_practica */
            $docentes_practica = new docentes_practica;
            $docentes_practica->id = $id;
            $docentes_practica->soporte_personal_apoyo = $request->file('sop_pers_apoyo') != null ? base64_encode(file_get_contents($request->file('sop_pers_apoyo')->path())) : null;
            $docentes_practica->num_docentes_apoyo=$request->get('num_apoyo');
            $docentes_practica->total_docentes_apoyo=$request->get('num_apoyo');

            switch($docentes_practica->num_docentes_apoyo=$request->get('num_apoyo'))
            {
                case "1":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=null;
                    $docentes_practica->num_doc_docente_apoyo_3=null;
                    $docentes_practica->num_doc_docente_apoyo_4=null;
                    $docentes_practica->num_doc_docente_apoyo_5=null;
                    $docentes_practica->num_doc_docente_apoyo_6=null;
                    $docentes_practica->num_doc_docente_apoyo_7=null;
                    $docentes_practica->num_doc_docente_apoyo_8=null;
                    $docentes_practica->num_doc_docente_apoyo_9=null;
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "2":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=null;
                    $docentes_practica->num_doc_docente_apoyo_4=null;
                    $docentes_practica->num_doc_docente_apoyo_5=null;
                    $docentes_practica->num_doc_docente_apoyo_6=null;
                    $docentes_practica->num_doc_docente_apoyo_7=null;
                    $docentes_practica->num_doc_docente_apoyo_8=null;
                    $docentes_practica->num_doc_docente_apoyo_9=null;
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "3":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=null;
                    $docentes_practica->num_doc_docente_apoyo_5=null;
                    $docentes_practica->num_doc_docente_apoyo_6=null;
                    $docentes_practica->num_doc_docente_apoyo_7=null;
                    $docentes_practica->num_doc_docente_apoyo_8=null;
                    $docentes_practica->num_doc_docente_apoyo_9=null;
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "4":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                    $docentes_practica->num_doc_docente_apoyo_5=null;
                    $docentes_practica->num_doc_docente_apoyo_6=null;
                    $docentes_practica->num_doc_docente_apoyo_7=null;
                    $docentes_practica->num_doc_docente_apoyo_8=null;
                    $docentes_practica->num_doc_docente_apoyo_9=null;
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "5":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                    $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                    $docentes_practica->num_doc_docente_apoyo_6=null;
                    $docentes_practica->num_doc_docente_apoyo_7=null;
                    $docentes_practica->num_doc_docente_apoyo_8=null;
                    $docentes_practica->num_doc_docente_apoyo_9=null;
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "6":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                    $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                    $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                    $docentes_practica->num_doc_docente_apoyo_7=null;
                    $docentes_practica->num_doc_docente_apoyo_8=null;
                    $docentes_practica->num_doc_docente_apoyo_9=null;
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "7":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('dapoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                    $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                    $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                    $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                    $docentes_practica->num_doc_docente_apoyo_8=null;
                    $docentes_practica->num_doc_docente_apoyo_9=null;
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "8":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                    $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                    $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                    $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                    $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                    $docentes_practica->num_doc_docente_apoyo_9=null;
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "9":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                    $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                    $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                    $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                    $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                    $docentes_practica->num_doc_docente_apoyo_9=$request->get('apoyo_9');
                    $docentes_practica->num_doc_docente_apoyo_10=null;
                    break;
                case "10":
                    $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                    $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                    $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                    $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                    $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                    $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                    $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                    $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                    $docentes_practica->num_doc_docente_apoyo_9=$request->get('apoyo_9');
                    $docentes_practica->num_doc_docente_apoyo_10=$request->get('apoyo_10');
                    break;
            }
            for ($i = 1; $i <= 10; $i++) {
                $docente_id = $request->get("apoyo_$i");

                if ($docente_id) {
                    $nombre_docente = DB::table('users')
                        ->select(DB::raw('CONCAT_WS(" ", primer_nombre, segundo_nombre, primer_apellido, segundo_apellido) as full_name'))
                        ->where('id', $docente_id)
                        ->first();

                    $docentes_practica->{"docente_apoyo_$i"} = $nombre_docente->full_name;
                } else {
                    $docentes_practica->{"docente_apoyo_$i"} = null;
                }
            }
            for ($i = 1; $i <= 10; $i++) {
                if ($i <= $docentes_practica->num_docentes_apoyo) {
                    $docentes_practica->{"es_responsable_$i"} = (int) $request->get("apoyo_responsable_$i");
                } else {
                    $docentes_practica->{"es_responsable_$i"} = null;
                }
            }
            $docentes_practica->save();
        /**Tabla docentes_practica */

        /**Tabla transporte_programacion */
            $transporte_programacion = new transporte_programacion;
            $transporte_programacion->id = $id;
            $transporte_programacion->cant_transporte_rp=$request->get('cant_transporte_rp');
            $transporte_programacion->cant_transporte_ra=$request->get('cant_transporte_ra');
            
            $transporte_programacion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
            $transporte_programacion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??null;
            $transporte_programacion->id_tipo_transporte_rp_3 =$tipo_transporte_rp[2]??null;
            $transporte_programacion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
            $transporte_programacion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??null;
            $transporte_programacion->id_tipo_transporte_ra_3 =$tipo_transporte_ra[2]??null;
            $transporte_programacion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
            $transporte_programacion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??null;
            $transporte_programacion->det_tipo_transporte_rp_3=$det_tipo_transporte_rp[2]??null;
            $transporte_programacion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
            $transporte_programacion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??null;
            $transporte_programacion->det_tipo_transporte_ra_3=$det_tipo_transporte_ra[2]??null;

            $transporte_programacion->docen_respo_trasnporte_rp=$docen_respo_trasnporte_rp;
            $transporte_programacion->docen_respo_trasnporte_ra=$docen_respo_trasnporte_ra;

            $transporte_programacion->capac_transporte_rp_1=$capacid_transporte_rp[0];
            $transporte_programacion->capac_transporte_rp_2=$capacid_transporte_rp[1]??null;
            $transporte_programacion->capac_transporte_rp_3=$capacid_transporte_rp[2]??null;
            $transporte_programacion->capac_transporte_ra_1=$capacid_transporte_ra[0];
            $transporte_programacion->capac_transporte_ra_2=$capacid_transporte_ra[1]??null;
            $transporte_programacion->capac_transporte_ra_3=$capacid_transporte_ra[2]??null;

            $transporte_programacion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
            $transporte_programacion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==null?null:intval($request->get('exclusiv_tiempo_rp_2'));
            $transporte_programacion->exclusiv_tiempo_rp_3=$request->get('exclusiv_tiempo_rp_3')==null?null:intval($request->get('exclusiv_tiempo_rp_3'));
            $transporte_programacion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
            $transporte_programacion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==null?null:intval($request->get('exclusiv_tiempo_ra_2'));
            $transporte_programacion->exclusiv_tiempo_ra_3=$request->get('exclusiv_tiempo_ra_3')==null?null:intval($request->get('exclusiv_tiempo_ra_3'));

            $transporte_programacion->save();
        /**Tabla transporte_programacion */

        /**Tabla transporte_menor */
            $transporte_menor = new transporte_menor;
            $transporte_menor->id=$id;
            $transporte_menor->cant_trans_menor_rp=$request->get('cant_trans_menor_rp');
            $transporte_menor->cant_trans_menor_ra=$request->get('cant_trans_menor_ra');

            switch($transporte_menor->cant_trans_menor_rp)
            {
                case "0":
                    $transporte_menor->trans_menor_rp_1=null;
                    $transporte_menor->trans_menor_rp_2=null;
                    $transporte_menor->trans_menor_rp_3=null;
                    $transporte_menor->trans_menor_rp_4=null;
                    $transporte_menor->vlr_trans_menor_rp_1=0;
                    $transporte_menor->vlr_trans_menor_rp_2=0;
                    $transporte_menor->vlr_trans_menor_rp_3=0;
                    $transporte_menor->vlr_trans_menor_rp_4=0;
                    $transporte_menor->docente_resp_t_menor_rp=null;
                    break;
                case "1":
                    $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                    $transporte_menor->trans_menor_rp_2=null;
                    $transporte_menor->trans_menor_rp_3=null;
                    $transporte_menor->trans_menor_rp_4=null;
                    $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                    $transporte_menor->vlr_trans_menor_rp_2=0;
                    $transporte_menor->vlr_trans_menor_rp_3=0;
                    $transporte_menor->vlr_trans_menor_rp_4=0;
                    $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                    break;
                case "2":
                    $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                    $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                    $transporte_menor->trans_menor_rp_3=null;
                    $transporte_menor->trans_menor_rp_4=null;
                    $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                    $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                    $transporte_menor->vlr_trans_menor_rp_3=0;
                    $transporte_menor->vlr_trans_menor_rp_4=0;
                    $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                    break;
                case "3":
                    $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                    $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                    $transporte_menor->trans_menor_rp_3=$request->get('trans_menor_rp_3');
                    $transporte_menor->trans_menor_rp_4=null;
                    $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                    $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                    $transporte_menor->vlr_trans_menor_rp_3=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_3')));
                    $transporte_menor->vlr_trans_menor_rp_4=0;
                    $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                    break;
                case "4":
                    $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                    $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                    $transporte_menor->trans_menor_rp_3=$request->get('trans_menor_rp_3');
                    $transporte_menor->trans_menor_rp_4=$request->get('trans_menor_rp_4');
                    $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                    $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                    $transporte_menor->vlr_trans_menor_rp_3=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_3')));
                    $transporte_menor->vlr_trans_menor_rp_4=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_4')));
                    $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                    break;
            }

            switch($transporte_menor->cant_trans_menor_ra)
            {
                case "0":
                    $transporte_menor->trans_menor_ra_1=null;
                    $transporte_menor->trans_menor_ra_2=null;
                    $transporte_menor->trans_menor_ra_3=null;
                    $transporte_menor->trans_menor_ra_4=null;
                    $transporte_menor->vlr_trans_menor_ra_1=0;
                    $transporte_menor->vlr_trans_menor_ra_2=0;
                    $transporte_menor->vlr_trans_menor_ra_3=0;
                    $transporte_menor->vlr_trans_menor_ra_4=0;
                    $transporte_menor->docente_resp_t_menor_ra=null;
                    break;
                case "1":
                    $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                    $transporte_menor->trans_menor_ra_2=null;
                    $transporte_menor->trans_menor_ra_3=null;
                    $transporte_menor->trans_menor_ra_4=null;
                    $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                    $transporte_menor->vlr_trans_menor_ra_2=0;
                    $transporte_menor->vlr_trans_menor_ra_3=0;
                    $transporte_menor->vlr_trans_menor_ra_4=0;
                    $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                    break;
                case "2":
                    $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                    $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                    $transporte_menor->trans_menor_ra_3=null;
                    $transporte_menor->trans_menor_ra_4=null;
                    $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                    $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                    $transporte_menor->vlr_trans_menor_ra_3=0;
                    $transporte_menor->vlr_trans_menor_ra_4=0;
                    $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                    break;
                case "3":
                    $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                    $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                    $transporte_menor->trans_menor_ra_3=$request->get('trans_menor_ra_3');
                    $transporte_menor->trans_menor_ra_4=null;
                    $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                    $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                    $transporte_menor->vlr_trans_menor_ra_3=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_3')));
                    $transporte_menor->vlr_trans_menor_ra_4=0;
                    $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                    break;
                case "4":
                    $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                    $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                    $transporte_menor->trans_menor_ra_3=$request->get('trans_menor_ra_3');
                    $transporte_menor->trans_menor_ra_4=$request->get('trans_menor_ra_4');
                    $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                    $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                    $transporte_menor->vlr_trans_menor_ra_3=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_3')));
                    $transporte_menor->vlr_trans_menor_ra_4=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_4')));
                    $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                    break;
            }
            
            $transporte_menor->save();

            $vlr_trans_menor_rp_1=$transporte_menor->vlr_trans_menor_rp_1;
            $vlr_trans_menor_rp_2=$transporte_menor->vlr_trans_menor_rp_2;
            $vlr_trans_menor_rp_3=$transporte_menor->vlr_trans_menor_rp_3;
            $vlr_trans_menor_rp_4=$transporte_menor->vlr_trans_menor_rp_4;
            $vlr_trans_menor_ra_1=$transporte_menor->vlr_trans_menor_ra_1;
            $vlr_trans_menor_ra_2=$transporte_menor->vlr_trans_menor_ra_2;
            $vlr_trans_menor_ra_3=$transporte_menor->vlr_trans_menor_ra_3;
            $vlr_trans_menor_ra_4=$transporte_menor->vlr_trans_menor_ra_4;

        /**Tabla transporte_menor */

        /**Tabla materiales_herramientas_programacion */
            $mater_herra_programacion = new materiales_herramientas_programacion;
            $mater_herra_programacion->id = $id;
            $mater_herra_programacion->det_materiales_rp=$request->get('det_materiales_rp');
            $mater_herra_programacion->det_materiales_ra=$request->get('det_materiales_ra');
            $mater_herra_programacion->det_guias_baquianos_rp=$request->get('det_guias_baquia_rp');
            $mater_herra_programacion->det_guias_baquianos_ra=$request->get('det_guias_baquia_ra');
            $mater_herra_programacion->det_otros_boletas_rp=$request->get('det_otros_bolet_rp');
            $mater_herra_programacion->det_otros_boletas_ra=$request->get('det_otros_bolet_ra');

            $mater_herra_programacion->save();
        /**Tabla materiales_herramientas_programacion */

        /**Tabla riesgos_amenazas_programacion */
            $riesg_amen_practica = new riesgos_amenazas_practica;
            $riesg_amen_practica->id = $id;
            $riesg_amen_practica->areas_acuaticas_rp=$request->get('areas_acuaticas_rp')=='on'?1:0;
            $riesg_amen_practica->areas_acuaticas_ra=$request->get('areas_acuaticas_ra')=='on'?1:0;
            $riesg_amen_practica->alturas_rp=$request->get('alturas_rp')=='on'?1:0;
            $riesg_amen_practica->alturas_ra=$request->get('alturas_ra')=='on'?1:0;
            $riesg_amen_practica->riesgo_biologico_rp=$request->get('riesgo_biologico_rp')=='on'?1:0;
            $riesg_amen_practica->riesgo_biologico_ra=$request->get('riesgo_biologico_ra')=='on'?1:0;
            $riesg_amen_practica->espacios_confinados_rp=$request->get('espacios_confinados_rp')=='on'?1:0;
            $riesg_amen_practica->espacios_confinados_ra=$request->get('espacios_confinados_ra')=='on'?1:0;

            $riesg_amen_practica->save();
        /**Tabla riesgos_amenazas_programacion */

        /**Tabla costos_programacion */
            $costos_programacion = new costos_programacion;
            $costos_programacion->id = $id;
            $vlr_materiales_rp=intval(str_replace(".","",$request->get('vlr_materiales_rp')));
            $vlr_materiales_ra=intval(str_replace(".","",$request->get('vlr_materiales_ra')));
            $vlr_guias_baquianos_rp=intval(str_replace(".","",$request->get('vlr_guias_baquia_rp')));
            $vlr_guias_baquianos_ra=intval(str_replace(".","",$request->get('vlr_guias_baquia_ra')));
            $vlr_otros_boletas_rp=intval(str_replace(".","",$request->get('vlr_otros_bolet_rp')));
            $vlr_otros_boletas_ra=intval(str_replace(".","",$request->get('vlr_otros_bolet_ra')));

            $total_otros_rp = $vlr_materiales_rp + $vlr_guias_baquianos_rp + $vlr_otros_boletas_rp;
            $total_otros_ra = $vlr_materiales_ra + $vlr_guias_baquianos_ra + $vlr_otros_boletas_ra;

            $costos_programacion->vlr_materiales_rp=$vlr_materiales_rp;
            $costos_programacion->vlr_materiales_ra=$vlr_materiales_ra;
            $costos_programacion->vlr_guias_baquianos_rp=$vlr_guias_baquianos_rp;
            $costos_programacion->vlr_guias_baquianos_ra=$vlr_guias_baquianos_ra;
            $costos_programacion->vlr_otros_boletas_rp=$vlr_otros_boletas_rp;
            $costos_programacion->vlr_otros_boletas_ra=$vlr_otros_boletas_ra;

            $num_dias_rp = $programacion_practica->duracion_num_dias_rp;
            $num_dias_ra = $programacion_practica->duracion_num_dias_ra;
            $num_estud = $programacion_practica->num_estudiantes_aprox;
            $num_doc_pract_int = $practicas_integradas->cant_espa_aca;
            $num_doc_apoyo = $docentes_practica->num_docentes_apoyo;
            $total_docentes_apoyo = $docentes_practica->total_docentes_apoyo;
            $total_docentes = $num_doc_pract_int + $total_docentes_apoyo + 1;

            if($prog_aca->pregrado == 1)
            {
                $viaticos_estudiantes = $this->calc_viaticos_est($num_dias_rp,$num_dias_ra,$num_estud);
                $viaticos_estudiantes_rp = $viaticos_estudiantes['viaticos_estud_rp'];
                $viaticos_estudiantes_ra = $viaticos_estudiantes['viaticos_estud_ra'];
            }
            else{
                $viaticos_estudiantes_rp = 0;
                $viaticos_estudiantes_ra = 0;
            }

            $viaticos_docentes = $this->calc_viaticos_docen($num_dias_rp,$num_dias_ra,$total_docentes);
            $viaticos_docente_rp =$viaticos_docentes['viaticos_docen_rp'];
            $viaticos_docente_ra =$viaticos_docentes['viaticos_docen_ra'];

            if($request->get('realizada_bogota_rp') == 1 && $num_dias_rp == 1){
                $viaticos_estudiantes_rp = 0;
                $viaticos_docente_rp = 0;
            }

            if($request->get('realizada_bogota_ra') == 1 && $num_dias_ra == 1){
                $viaticos_estudiantes_ra = 0;
                $viaticos_docente_ra = 0;
            }

            $costos_programacion->viaticos_estudiantes_rp=$viaticos_estudiantes_rp;
            $costos_programacion->viaticos_estudiantes_ra=$viaticos_estudiantes_ra;

            $costos_programacion->viaticos_docente_rp=$viaticos_docente_rp;
            $costos_programacion->viaticos_docente_ra=$viaticos_docente_ra;

            $costo_total_transporte_menor_rp = $vlr_trans_menor_rp_1 + $vlr_trans_menor_rp_2 + $vlr_trans_menor_rp_3 + $vlr_trans_menor_rp_4;
            $costo_total_transporte_menor_ra = $vlr_trans_menor_ra_1 + $vlr_trans_menor_ra_2 + $vlr_trans_menor_ra_3 + $vlr_trans_menor_ra_4;

            $costos_programacion->costo_total_transporte_menor_rp =$costo_total_transporte_menor_rp;
            $costos_programacion->costo_total_transporte_menor_ra =$costo_total_transporte_menor_ra;
            
            $costos_programacion->total_presupuesto_rp=$viaticos_estudiantes_rp + $viaticos_docente_rp + $total_otros_rp + $costo_total_transporte_menor_rp;
            $costos_programacion->total_presupuesto_ra=$viaticos_estudiantes_ra + $viaticos_docente_ra + $total_otros_ra + $costo_total_transporte_menor_ra;

            $costos_programacion->save();
        /**Tabla costos_programacion */

        if($idRole == 5 || $idRole == 4)
        {
            $this->creacion_proy($id);
        }

        return redirect('/programaciones/filtrar/send');
    }

    /**
     * Muestra formulario para editar Programación practica
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $idRole = Auth::user()->id_role;
        switch($idRole)
        {
            case 1:
                $programacion_practica = programacion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $docentes_practica= docentes_practica::find($id);
                $transporte_programacion = transporte_programacion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $costos_programacion = costos_programacion::find($id);
                $mater_herra_programacion = materiales_herramientas_programacion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $programacion_practica->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $usuario_respon = $usuario;

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
                $sedes=DB::table('sedes_universidad')->get();

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();
                        
                $all_prog_aca=$programa_academico;
        
                $num_grupos_proy = 0; 

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
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                $sop_pers_apoyo = $docentes_practica->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
                // $img_sop_pers_apoyo="data:image/png;base64,$sop_pers_apoyo";
        
                return view('programaciones.edit',["programacion_practica"=>$programacion_practica,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
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
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "mater_herra_programacion"=>$mater_herra_programacion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "costos_programacion"=>$costos_programacion,
                                                "transporte_programacion"=>$transporte_programacion,
                                                "transporte_menor"=>$transporte_menor,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "docentes_practica"=>$docentes_practica,
                                                "all_programas_aca"=>$all_prog_aca,
                                                "all_espacios_aca"=>$all_esp_aca,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "usuario"=>$usuario,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema
        
                ]);

            break;

            case 2:
                $programacion_practica = programacion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_programacion = transporte_programacion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_programacion = costos_programacion::find($id);
                $mater_herra_programacion = materiales_herramientas_programacion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $programacion_practica->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $usuario_respon =$usuario;

                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $sedes=DB::table('sedes_universidad')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                
                $docentes_activos=DB::table('users')
                // ->select(
                // DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                // ->join('programacion_practica as p_prel','users.id','=','p_prel.id_docente_responsable')
                // ->whereIn($programacion_practica->id_espacio_academico, ['users.id_espacio_academico_1', 'users.id_espacio_academico_2', 'users.id_espacio_academico_3', 
                // 'users.id_espacio_academico_4', 'users.id_espacio_academico_5', 'users.id_espacio_academico_6'])
                ->where('users.id_estado','=',1)
                ->where('users.id_role','=',5)
                ->where('users.id_espacio_academico_1','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_2','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_3','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_4','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_5','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_6','=',$programacion_practica->id_espacio_academico)->get();

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();

                $estado_doc_respon =$usuario->id_estado;
        
                $num_grupos_proy = 0; 
        
                $prog_aca_user = [];
                $esp_aca_user = [];

                /**practicas integradas */
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
                /**practicas integradas */

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
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                $docentes = DB::table('docentes_practica')->where('id',$id)->first();
                $sop_pers_apoyo = $docentes->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
                // $img_sop_pers_apoyo="data:image/png;base64,$sop_pers_apoyo";
        
                return view('programaciones.edit',["programacion_practica"=>$programacion_practica,
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
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "docentes_activos"=>$docentes_activos,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "transporte_programacion"=>$transporte_programacion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_programacion"=>$costos_programacion,
                                                "mater_herra_programacion"=>$mater_herra_programacion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,    
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
        
                ]);
            break;

            case 3:
                $programacion_practica = programacion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_programacion = transporte_programacion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_programacion = costos_programacion::find($id);
                $mater_herra_programacion = materiales_herramientas_programacion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $programacion_practica->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $usuario_respon=$usuario;

                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $sedes=DB::table('sedes_universidad')->get();
                $programa_academico = DB::table('programa_academico')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $all_esp_aca=DB::table('espacio_academico')->get();
                $all_prog_aca=$programa_academico;

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();

                $num_grupos_proy = 0; 
        
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
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                $docentes = DB::table('docentes_practica')->where('id',$id)->first();
                $sop_pers_apoyo = $docentes->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
                // $img_sop_pers_apoyo="data:image/png;base64,$sop_pers_apoyo";
        
                return view('programaciones.edit',["programacion_practica"=>$programacion_practica,
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
                                                "all_programas_aca"=>$all_prog_aca,
                                                "all_espacios_aca"=>$all_esp_aca,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "transporte_programacion"=>$transporte_programacion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_programacion"=>$costos_programacion,
                                                "mater_herra_programacion"=>$mater_herra_programacion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
        
                ]);
            break;

            case 4:
                $programacion_practica = programacion::find($id);
                // $cambios_programacion = cambios_programacion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_programacion = transporte_programacion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_programacion = costos_programacion::find($id);
                $mater_herra_programacion = materiales_herramientas_programacion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $programacion_practica->id_docente_responsable;
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
                $sedes=DB::table('sedes_universidad')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();
        
                $num_grupos_proy = 0; 
        
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
                
                $estado_doc_respon =$usuario_respon->id_estado;

                $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
                $nomb_usuario = $usuario_log->primer_nombre.' '.$usuario_log->segundo_nombre.' '.$usuario_log->primer_apellido.' '.$usuario_log->segundo_apellido;
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                $docentes = DB::table('docentes_practica')->where('id',$id)->first();
                $sop_pers_apoyo = $docentes->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
                // $img_sop_pers_apoyo="data:image/png;base64,$sop_pers_apoyo";

                return view('programaciones.edit',["programacion_practica"=>$programacion_practica,
                                                // "cambios_programacion"=>$cambios_programacion,
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
                                                "usuario_log"=>$usuario_log,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "transporte_programacion"=>$transporte_programacion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_programacion"=>$costos_programacion,
                                                "mater_herra_programacion"=>$mater_herra_programacion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario_log,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
        
                ]);
            break;

            case 5:
                $programacion_practica = programacion::find($id);
                // $cambios_programacion = cambios_programacion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_programacion = transporte_programacion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica= docentes_practica::find($id);
                $costos_programacion = costos_programacion::find($id);
                $mater_herra_programacion = materiales_herramientas_programacion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $programacion_practica->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $usuario_respon=$usuario;

                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $sedes=DB::table('sedes_universidad')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();

                $docentes=DB::table('users')
                ->select('users.id',DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->where('id_role',5)
                ->where('id','!=',Auth::user()->id)
                ->orderBy('users.primer_nombre','ASC')
                ->get(); 

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
                $newArray_docen_integ = array_unique($docen_integ, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                $sop_pers_apoyo = $docentes_practica->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
                // $img_sop_pers_apoyo="data:image/png;base64,$sop_pers_apoyo";
        
                return view('programaciones.edit',["programacion_practica"=>$programacion_practica,
                                                // "cambios_programacion"=>$cambios_programacion,
                                                "programas_academicos"=>$programa_academico,
                                                "all_users"=>$newArray_docen_integ,
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
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "transporte_programacion"=>$transporte_programacion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_programacion"=>$costos_programacion,
                                                "mater_herra_programacion"=>$mater_herra_programacion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
                                                'docentes'=>$docentes

        
                ]);
            break;
        }
    }

    
    /**
     * habilitar cambios programaciones
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function hab_cambios_proy($id)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $idRole = Auth::user()->id_role;

        switch($idRole)
        {
            case 1:
                $programacion_practica = programacion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $docentes_practica= docentes_practica::find($id);
                $transporte_programacion = transporte_programacion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $costos_programacion = costos_programacion::find($id);
                $mater_herra_programacion = materiales_herramientas_programacion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $programacion_practica->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $usuario_respon = $usuario;

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
                $sedes=DB::table('sedes_universidad')->get();

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();
                        
                $all_prog_aca=$programa_academico;

                $docentes=DB::table('users')
                ->select('users.id',DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->where('id_role',5)
                ->where('id','!=',Auth::user()->id)
                ->orderBy('users.primer_nombre','ASC')
                ->get();  
        
                $num_grupos_proy = 0; 

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
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                $sop_pers_apoyo = $docentes_practica->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
                // $img_sop_pers_apoyo="data:image/png;base64,$sop_pers_apoyo";
        
                return view('programaciones.edit',["programacion_practica"=>$programacion_practica,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
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
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "mater_herra_programacion"=>$mater_herra_programacion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "costos_programacion"=>$costos_programacion,
                                                "transporte_programacion"=>$transporte_programacion,
                                                "transporte_menor"=>$transporte_menor,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "docentes_practica"=>$docentes_practica,
                                                "all_programas_aca"=>$all_prog_aca,
                                                "all_espacios_aca"=>$all_esp_aca,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "usuario"=>$usuario,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'docentes'=>$docentes        
                ]);

            break;

            case 2:
                $programacion_practica = programacion::find($id);
                // $cambios_programacion = cambios_programacion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_programacion = transporte_programacion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_programacion = costos_programacion::find($id);
                $mater_herra_programacion = materiales_herramientas_programacion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $programacion_practica->id_docente_responsable;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $usuario_respon =$usuario;

                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $sedes=DB::table('sedes_universidad')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                
                $docentes_activos=DB::table('users')
                ->where('users.id_estado','=',1)
                ->where('users.id_role','=',5)
                ->where('users.id_espacio_academico_1','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_2','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_3','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_4','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_5','=',$programacion_practica->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_6','=',$programacion_practica->id_espacio_academico)->get();

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();

                $estado_doc_respon =$usuario->id_estado;

                $docentes=DB::table('users')
                ->select('users.id',DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->where('id_role',5)
                ->where('id','!=',Auth::user()->id)
                ->orderBy('users.primer_nombre','ASC')
                ->get();  
        
                $prog_aca_user = [];

                /**practicas integradas */
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
                /**practicas integradas */

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
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                $docentes2 = DB::table('docentes_practica')->where('id',$id)->first();
                $sop_pers_apoyo = $docentes2->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
        
                return view('programaciones.formularios.cambiar_edit',["programacion_practica"=>$programacion_practica,
                                                // "cambios_programacion"=>$cambios_programacion,
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
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "docentes_activos"=>$docentes_activos,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "transporte_programacion"=>$transporte_programacion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_programacion"=>$costos_programacion,
                                                "mater_herra_programacion"=>$mater_herra_programacion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,    
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
                                                'docentes'=>$docentes
        
                ]);
            break;
        }
    }

    /**
     * actualizar cambios habilitados programaciones
     *
     * @param int $id
     * @return \Illuminate\Http\Request
     */
    public function cambios_proy(Request $request, $id)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $idRole = Auth::user()->id_role;

        switch($idRole)
        {
            case 1:
                //$programacion_practica = programacion::find($id);
                // $cambios_programacion = cambios_programacion::find($id);

                // $cambios_programacion->cambiar_programa_academico=isset($_POST['cambiar_programa_academico']) ? 1 : 0;
                // $cambios_programacion->cambiar_espacio_academico=isset($_POST['cambiar_espacio_academico']) ? 1 : 0;
                // $cambios_programacion->cambiar_sem_anio_per=isset($_POST['cambiar_sem_anio_per']) ? 1 : 0;
                // $cambios_programacion->cambiar_integrada=isset($_POST['cambiar_integrada']) ? 1 : 0;
                // $cambios_programacion->cambiar_estudiantes=isset($_POST['cambiar_estudiantes']) ? 1 : 0;
                // $cambios_programacion->cambiar_grupos=isset($_POST['cambiar_grupos']) ? 1 : 0;
                // $cambios_programacion->cambiar_personal_apoyo=isset($_POST['cambiar_personal_apoyo']) ? 1 : 0;
                // $cambios_programacion->cambiar_destino_rp=isset($_POST['cambiar_destino_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_url_rp=isset($_POST['cambiar_url_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_detalle_rp=isset($_POST['cambiar_detalle_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_sedes_rp=isset($_POST['cambiar_sedes_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_fechas_rp=isset($_POST['cambiar_fechas_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_transporte_rp=isset($_POST['cambiar_transporte_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_transporte_menor_rp=isset($_POST['cambiar_transporte_menor_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_otros_rp=isset($_POST['cambiar_otros_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_actividades_riesgo_rp=isset($_POST['cambiar_actividades_riesgo_rp']) ? 1 : 0;
                // $cambios_programacion->cambiar_destino_ra=isset($_POST['cambiar_destino_ra']) ? 1 : 0;
                // $cambios_programacion->cambiar_url_ra=isset($_POST['cambiar_url_ra']) ? 1 : 0;
                // $cambios_programacion->cambiar_detalle_ra=isset($_POST['cambiar_detalle_ra']) ? 1 : 0;
                // $cambios_programacion->cambiar_sedes_ra=isset($_POST['cambiar_sedes_ra']) ? 1 : 0;
                // $cambios_programacion->cambiar_fechas_ra=isset($_POST['cambiar_fechas_ra']) ? 1 : 0;
                // $cambios_programacion->cambiar_transporte_ra=isset($_POST['cambiar_transporte_ra']) ? 1 : 0;
                // $cambios_programacion->cambiar_transporte_menor_ra=isset($_POST['cambiar_transporte_menor_ra']) ? 1 : 0;
                // $cambios_programacion->cambiar_otros_ra=isset($_POST['cambiar_otros_ra']) ? 1 : 0;
                // $cambios_programacion->cambiar_actividades_riesgo_ra=isset($_POST['cambiar_actividades_riesgo_ra']) ? 1 : 0;
                // $cambios_programacion->id_user_hab=$idUser;

                //$programacion_practica->id_estado = 1;
                //$programacion_practica->confirm_creador = 1;
                //$programacion_practica->confirm_docente = 0;
                //$programacion_practica->confirm_coord = 0;
                //$programacion_practica->confirm_asistD = 0;
                //$programacion_practica->aprobacion_coordinador = 5;
                //$programacion_practica->aprobacion_asistD = 5;
                //$programacion_practica->aprobacion_decano = 5;

                // $cambios_programacion->update();
                //$programacion_practica->update();
                break;

            case 2:                
                if(Auth::user()->decano()){
                    $mytime = Carbon::now('America/Bogota');
                    $programacion_practica = programacion::where('id', '=', $id)->first();
                    $transporte_programacion = transporte_programacion::where('id','=',$id)->first();
                    $practicas_integradas = practicas_integradas::where('id','=',$id)->first();
                    $transporte_menor = transporte_menor::where('id','=',$id)->first();
                    $costos_programacion = costos_programacion::where('id','=',$id)->first();
                    $docentes_practica = docentes_practica::where('id','=',$id)->first();
                    $mater_herra_programacion = materiales_herramientas_programacion::where('id','=',$id)->first();
                    $riesg_amen_practica = riesgos_amenazas_practica::where('id','=',$id)->first();
                    $solicitud_practica = new  solicitud;
                    // $cambios_programacion = new  cambios_programacion;
                    $doc_req_sol = new  documentos_requeridos_solicitud;
                    $id_prog_aca = $request->get('id_programa_academico');
                    $prog_aca=DB::table('programa_academico')
                    ->where('id',$id_prog_aca)->first();
                    /**Tabla programacion_practica */
                    //dd($request->all());
                    $programacion_practica->practicas_integradas = intval($request->get('integrada'));
                    $esp_aca = (!empty($request->get('id_espacio_academico')))?
                    $request->get('id_espacio_academico'):$programacion_practica->id_espacio_academico;

                    $id_prog_aca = ($request->get('id_programa_academico'))?
                    $request->get('id_programa_academico'):$programacion_practica->id_espacio_academico;

                    $esp_aca = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$id_prog_aca)
                    ->where('id','=',$esp_aca)->first();
                    $programacion_practica->id_espacio_academico=(!empty($esp_aca)||null)?
                    $esp_aca->id:$programacion_practica->id_espacio_academico;

                    $programacion_practica->id_programa_academico = $id_prog_aca;

                    $programacion_practica->id_semestre_asignatura=$request->get('id_semestre_asignatura');
                    $programacion_practica->id_periodo_academico=$request->get('id_periodo_academico');
                    $programacion_practica->anio_periodo=$request->get('anio_periodo');

                    $programacion_practica->num_estudiantes_aprox=$request->get('num_estudiantes_aprox');                    

                    $programacion_practica->fecha_salida_aprox_rp= $request->get('fecha_salida_aprox_rp');
                    $programacion_practica->fecha_regreso_aprox_rp= $request->get('fecha_regreso_aprox_rp');
                    $programacion_practica->fecha_salida_aprox_ra= $request->get('fecha_salida_aprox_ra');
                    $programacion_practica->fecha_regreso_aprox_ra= $request->get('fecha_regreso_aprox_ra');

                    $fecha_salida_rp = new DateTime($programacion_practica->fecha_salida_aprox_rp);
                    $fecha_regreso_rp = new DateTime($programacion_practica->fecha_regreso_aprox_rp);
                    $num_dias_rp = $fecha_salida_rp->diff($fecha_regreso_rp);
                    $programacion_practica->duracion_num_dias_rp=$num_dias_rp->days+1;

                    $fecha_salida_ra = new DateTime($programacion_practica->fecha_salida_aprox_ra);
                    $fecha_regreso_ra = new DateTime($programacion_practica->fecha_regreso_aprox_ra);
                    $num_dias_ra = $fecha_salida_ra->diff($fecha_regreso_ra);
                    $programacion_practica->duracion_num_dias_ra=$num_dias_ra->days+1;

                    $programacion_practica->realizada_bogota_rp=$request->get('realizada_bogota_rp');
                    $programacion_practica->realizada_bogota_ra=$request->get('realizada_bogota_ra');
                    $programacion_practica->destino_rp=$request->get('destino_rp');
                    $programacion_practica->destino_ra=$request->get('destino_ra');
                    $programacion_practica->det_recorrido_interno_rp=$request->get('det_recorrido_interno_rp');
                    $programacion_practica->det_recorrido_interno_ra=$request->get('det_recorrido_interno_ra');
                    $programacion_practica->lugar_salida_rp=$request->get('lugar_salida_rp');
                    $programacion_practica->lugar_regreso_rp=$request->get('lugar_regreso_rp');
                    $programacion_practica->lugar_salida_ra=$request->get('lugar_salida_ra');
                    $programacion_practica->lugar_regreso_ra=$request->get('lugar_regreso_ra');
                    
                    $programacion_practica->cantidad_url_rp=$request->get('cant_url_rp');
                    $programacion_practica->cantidad_url_ra=$request->get('cant_url_ra');
                   
                    switch($programacion_practica->cantidad_url_rp=$request->get('cant_url_rp'))
                    {
                        case"1":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=null;
                            $programacion_practica->ruta_principal_3=null;
                            $programacion_practica->ruta_principal_4=null;
                            $programacion_practica->ruta_principal_5=null;
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"2":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=null;
                            $programacion_practica->ruta_principal_4=null;
                            $programacion_practica->ruta_principal_5=null;
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"3":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                            $programacion_practica->ruta_principal_4=null;
                            $programacion_practica->ruta_principal_5=null;
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"4":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                            $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                            $programacion_practica->ruta_principal_5=null;
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"5":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                            $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                            $programacion_practica->ruta_principal_5=$request->get('ruta_principal_5');
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"6":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                            $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                            $programacion_practica->ruta_principal_5=$request->get('ruta_principal_5');
                            $programacion_practica->ruta_principal_6=$request->get('ruta_principal_6');
                            break;
                    }
                    
                    switch($programacion_practica->cantidad_url_ra=$request->get('cant_url_ra'))
                    {
                        case "1":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=null;
                            $programacion_practica->ruta_alterna_3=null;
                            $programacion_practica->ruta_alterna_4=null;
                            $programacion_practica->ruta_alterna_5=null;
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "2":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=null;
                            $programacion_practica->ruta_alterna_4=null;
                            $programacion_practica->ruta_alterna_5=null;
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "3":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $programacion_practica->ruta_alterna_4=null;
                            $programacion_practica->ruta_alterna_5=null;
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "4":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $programacion_practica->ruta_alterna_5=null;
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "5":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $programacion_practica->ruta_alterna_5=$request->get('ruta_alterna_5');
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "6":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $programacion_practica->ruta_alterna_5=$request->get('ruta_alterna_5');
                            $programacion_practica->ruta_alterna_6=$request->get('ruta_alterna_6');
                            break;
                    }

                /**Tabla programacion_practica */

                /**Tabla practicas_integradas */
                    $espa_aca_1=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_1'))->first();
                    $espa_aca_2=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_2'))->first();
                    $espa_aca_3=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_3'))->first();
                    $espa_aca_4=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_4'))->first();
                    $espa_aca_5=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_5'))->first();
                    $espa_aca_6=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_6'))->first();
                    $espa_aca_7=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_7'))->first();
                  

                    $practica_integrada = $request->get('integrada')==null?0:intval($request->get('integrada'));

                    if($practica_integrada == 1)
                    {
                        $practicas_integradas->cant_espa_aca=$request->get('cant_espa_aca');
                    }
                    else if($practica_integrada == 0)
                    {
                        $practicas_integradas->cant_espa_aca=0;
                    }
                    
                    switch($practicas_integradas->cant_espa_aca)
                    {
                        case "0":
                            $practicas_integradas->id_espa_aca_1=null;
                            $practicas_integradas->id_espa_aca_2=null;
                            $practicas_integradas->id_espa_aca_3=null;
                            $practicas_integradas->id_espa_aca_4=null;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=null;
                            $practicas_integradas->id_docen_espa_aca_2=null;
                            $practicas_integradas->id_docen_espa_aca_3=null;
                            $practicas_integradas->id_docen_espa_aca_4=null;
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "1":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=null;
                            $practicas_integradas->id_espa_aca_3=null;
                            $practicas_integradas->id_espa_aca_4=null;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=null;
                            $practicas_integradas->id_docen_espa_aca_3=null;
                            $practicas_integradas->id_docen_espa_aca_4=null;
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "2":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=null;
                            $practicas_integradas->id_espa_aca_4=null;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=null;
                            $practicas_integradas->id_docen_espa_aca_4=null;
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "3":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=null;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=null;
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "4":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "5":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                            $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                            $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "6":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                            $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                            $practicas_integradas->id_espa_aca_6=$espa_aca_6->id;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                            $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                            $practicas_integradas->id_docen_espa_aca_6=$request->get('id_docen_espa_aca_6');
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "7":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                            $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                            $practicas_integradas->id_espa_aca_6=$espa_aca_6->id;
                            $practicas_integradas->id_espa_aca_7=$espa_aca_7->id;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                            $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                            $practicas_integradas->id_docen_espa_aca_6=$request->get('id_docen_espa_aca_6');
                            $practicas_integradas->id_docen_espa_aca_7=$request->get('id_docen_espa_aca_7');
                            break;
                    }
                    for ($i = 1; $i <= 7; $i++) {
                        if ($i <= $practicas_integradas->cant_espa_aca) {
                            $practicas_integradas->{"es_responsable_$i"} = (int) $request->get("integrada_responsable_$i");
                        } else {
                            $practicas_integradas->{"es_responsable_$i"} = null;
                        }
                    }
                /**Tabla practicas_integradas */

                /**Tabla docentes_practica */
                    $docentes_practica->num_docentes_apoyo=$request->get('num_apoyo');
                    $docentes_practica->total_docentes_apoyo=$request->get('num_apoyo');

                    switch($docentes_practica->num_docentes_apoyo=$request->get('num_apoyo'))
                    {
                        case "1":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=null;
                            $docentes_practica->num_doc_docente_apoyo_3=null;
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "2":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=null;
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "3":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "4":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "5":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "6":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "7":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('dapoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "8":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "9":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                            $docentes_practica->num_doc_docente_apoyo_9=$request->get('apoyo_9');
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "10":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                            $docentes_practica->num_doc_docente_apoyo_9=$request->get('apoyo_9');
                            $docentes_practica->num_doc_docente_apoyo_10=$request->get('apoyo_10');
                            break;
                    }
                    for ($i = 1; $i <= 10; $i++) {
                        $docente_id = $request->get("apoyo_$i");

                        if ($docente_id) {
                            $nombre_docente = DB::table('users')
                                ->select(DB::raw('CONCAT_WS(" ", primer_nombre, segundo_nombre, primer_apellido, segundo_apellido) as full_name'))
                                ->where('id', $docente_id)
                                ->first();

                            $docentes_practica->{"docente_apoyo_$i"} = $nombre_docente->full_name;
                        } else {
                            $docentes_practica->{"docente_apoyo_$i"} = null;
                        }
                    }
                    for ($i = 1; $i <= 10; $i++) {
                        if ($i <= $docentes_practica->num_docentes_apoyo) {
                            $docentes_practica->{"es_responsable_$i"} = (int) $request->get("apoyo_responsable_$i");
                        } else {
                            $docentes_practica->{"es_responsable_$i"} = null;
                        }
                    }                    
                /**Tabla docentes_practica */
                    
                /**Tabla transporte_programacion */
                    $transporte_programacion->cant_transporte_rp=$request->get('cant_transporte_rp_edit');
                    $transporte_programacion->cant_transporte_ra=$request->get('cant_transporte_ra_edit');

                    $tipo_transporte_rp = $request->get('id_tipo_transporte_rp_');
                    $det_tipo_transporte_rp = $request->get('det_tipo_transporte_rp_');
                    $capacid_transporte_rp = $request->get('capac_transporte_rp_');

                    $tipo_transporte_ra = $request->get('id_tipo_transporte_ra_');
                    $det_tipo_transporte_ra = $request->get('det_tipo_transporte_ra_');
                    $capacid_transporte_ra = $request->get('capac_transporte_ra_');

                    switch($transporte_programacion->cant_transporte_rp)
                    {
                        case "1":
                            $transporte_programacion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_programacion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_programacion->id_tipo_transporte_rp_2 =null;
                            $transporte_programacion->id_tipo_transporte_rp_3 =null;
                            $transporte_programacion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_programacion->det_tipo_transporte_rp_2=null;
                            $transporte_programacion->det_tipo_transporte_rp_3=null;
                            $transporte_programacion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_programacion->capac_transporte_rp_2=null;
                            $transporte_programacion->capac_transporte_rp_3=null;
                            $transporte_programacion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_programacion->exclusiv_tiempo_rp_2=null;
                            $transporte_programacion->exclusiv_tiempo_rp_3=null;
                            break;
                        case "2":
                            $transporte_programacion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_programacion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_programacion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??null;
                            $transporte_programacion->id_tipo_transporte_rp_3 =null;
                            $transporte_programacion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_programacion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??null;
                            $transporte_programacion->det_tipo_transporte_rp_3=null;
                            $transporte_programacion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_programacion->capac_transporte_rp_2=$capacid_transporte_rp[1]??null;
                            $transporte_programacion->capac_transporte_rp_3=null;
                            $transporte_programacion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_programacion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==null?null:intval($request->get('exclusiv_tiempo_rp_2'));
                            $transporte_programacion->exclusiv_tiempo_rp_3=null;
                            break;
                        case "3":
                            $transporte_programacion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_programacion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_programacion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??null;
                            $transporte_programacion->id_tipo_transporte_rp_3 =$tipo_transporte_rp[2]??null;
                            $transporte_programacion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_programacion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??null;
                            $transporte_programacion->det_tipo_transporte_rp_3=$det_tipo_transporte_rp[2]??null;
                            $transporte_programacion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_programacion->capac_transporte_rp_2=$capacid_transporte_rp[1]??null;
                            $transporte_programacion->capac_transporte_rp_3=$capacid_transporte_rp[2]??null;
                            $transporte_programacion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_programacion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==null?null:intval($request->get('exclusiv_tiempo_rp_2'));
                            $transporte_programacion->exclusiv_tiempo_rp_3=$request->get('exclusiv_tiempo_rp_3')==null?null:intval($request->get('exclusiv_tiempo_rp_3'));
                            break;
                    }

                    switch($transporte_programacion->cant_transporte_ra)
                    {
                        case "1":
                            $transporte_programacion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_programacion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_programacion->id_tipo_transporte_ra_2 =null;
                            $transporte_programacion->id_tipo_transporte_ra_3 =null;
                            $transporte_programacion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_programacion->det_tipo_transporte_ra_2=null;
                            $transporte_programacion->det_tipo_transporte_ra_3=null;
                            $transporte_programacion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_programacion->capac_transporte_ra_2=null;
                            $transporte_programacion->capac_transporte_ra_3=null;
                            $transporte_programacion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_programacion->exclusiv_tiempo_ra_2=null;
                            $transporte_programacion->exclusiv_tiempo_ra_3=null;
                            break;
                        case "2":
                            $transporte_programacion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_programacion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_programacion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??null;
                            $transporte_programacion->id_tipo_transporte_ra_3 =null;
                            $transporte_programacion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_programacion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??null;
                            $transporte_programacion->det_tipo_transporte_ra_3=null;
                            $transporte_programacion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_programacion->capac_transporte_ra_2=$capacid_transporte_ra[1]??null;
                            $transporte_programacion->capac_transporte_ra_3=null;
                            $transporte_programacion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_programacion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==null?null:intval($request->get('exclusiv_tiempo_ra_2'));
                            $transporte_programacion->exclusiv_tiempo_ra_3=null;
                            break;
                        case "3":
                            $transporte_programacion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_programacion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_programacion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??null;
                            $transporte_programacion->id_tipo_transporte_ra_3 =$tipo_transporte_ra[2]??null;
                            $transporte_programacion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_programacion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??null;
                            $transporte_programacion->det_tipo_transporte_ra_3=$det_tipo_transporte_ra[2]??null;
                            $transporte_programacion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_programacion->capac_transporte_ra_2=$capacid_transporte_ra[1]??null;
                            $transporte_programacion->capac_transporte_ra_3=$capacid_transporte_ra[2]??null;
                            $transporte_programacion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_programacion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==null?null:intval($request->get('exclusiv_tiempo_ra_2'));
                            $transporte_programacion->exclusiv_tiempo_ra_3=$request->get('exclusiv_tiempo_ra_3')==null?null:intval($request->get('exclusiv_tiempo_ra_3'));
                            break;
                    }
                /**Tabla transporte_programacion */

                /**Tabla transporte_menor */
                    $transporte_menor->cant_trans_menor_rp=$request->get('cant_trans_menor_rp');
                    $transporte_menor->cant_trans_menor_ra=$request->get('cant_trans_menor_ra');

                    switch($transporte_menor->cant_trans_menor_rp)
                    {
                        case "0":
                            $transporte_menor->docente_resp_t_menor_rp=null;
                            $transporte_menor->trans_menor_rp_1=null;
                            $transporte_menor->trans_menor_rp_2=null;
                            $transporte_menor->trans_menor_rp_3=null;
                            $transporte_menor->trans_menor_rp_4=null;
                            $transporte_menor->vlr_trans_menor_rp_1=0;
                            $transporte_menor->vlr_trans_menor_rp_2=0;
                            $transporte_menor->vlr_trans_menor_rp_3=0;
                            $transporte_menor->vlr_trans_menor_rp_4=0;
                            break;
                        case "1":
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=null;
                            $transporte_menor->trans_menor_rp_3=null;
                            $transporte_menor->trans_menor_rp_4=null;
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=0;
                            $transporte_menor->vlr_trans_menor_rp_3=0;
                            $transporte_menor->vlr_trans_menor_rp_4=0;
                            break;
                        case "2":
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                            $transporte_menor->trans_menor_rp_3=null;
                            $transporte_menor->trans_menor_rp_4=null;
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                            $transporte_menor->vlr_trans_menor_rp_3=0;
                            $transporte_menor->vlr_trans_menor_rp_4=0;
                            break;
                        case "3":
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                            $transporte_menor->trans_menor_rp_3=$request->get('trans_menor_rp_3');
                            $transporte_menor->trans_menor_rp_4=null;
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                            $transporte_menor->vlr_trans_menor_rp_3=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_3')));
                            $transporte_menor->vlr_trans_menor_rp_4=0;
                            break;
                        case "4":
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                            $transporte_menor->trans_menor_rp_3=$request->get('trans_menor_rp_3');
                            $transporte_menor->trans_menor_rp_4=$request->get('trans_menor_rp_4');
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                            $transporte_menor->vlr_trans_menor_rp_3=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_3')));
                            $transporte_menor->vlr_trans_menor_rp_4=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_4')));
                            break;
                    }

                    switch($transporte_menor->cant_trans_menor_ra)
                    {
                        case "0":
                            $transporte_menor->docente_resp_t_menor_ra=null;
                            $transporte_menor->trans_menor_ra_1=null;
                            $transporte_menor->trans_menor_ra_2=null;
                            $transporte_menor->trans_menor_ra_3=null;
                            $transporte_menor->trans_menor_ra_4=null;
                            $transporte_menor->vlr_trans_menor_ra_1=0;
                            $transporte_menor->vlr_trans_menor_ra_2=0;
                            $transporte_menor->vlr_trans_menor_ra_3=0;
                            $transporte_menor->vlr_trans_menor_ra_4=0;
                            break;
                        case "1":
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=null;
                            $transporte_menor->trans_menor_ra_3=null;
                            $transporte_menor->trans_menor_ra_4=null;
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=0;
                            $transporte_menor->vlr_trans_menor_ra_3=0;
                            $transporte_menor->vlr_trans_menor_ra_4=0;
                            break;
                        case "2":
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                            $transporte_menor->trans_menor_ra_3=null;
                            $transporte_menor->trans_menor_ra_4=null;
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                            $transporte_menor->vlr_trans_menor_ra_3=0;
                            $transporte_menor->vlr_trans_menor_ra_4=0;
                            break;
                        case "3":
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                            $transporte_menor->trans_menor_ra_3=$request->get('trans_menor_ra_3');
                            $transporte_menor->trans_menor_ra_4=null;
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                            $transporte_menor->vlr_trans_menor_ra_3=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_3')));
                            $transporte_menor->vlr_trans_menor_ra_4=0;
                            break;
                        case "4":
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                            $transporte_menor->trans_menor_ra_3=$request->get('trans_menor_ra_3');
                            $transporte_menor->trans_menor_ra_4=$request->get('trans_menor_ra_4');
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                            $transporte_menor->vlr_trans_menor_ra_3=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_3')));
                            $transporte_menor->vlr_trans_menor_ra_4=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_4')));
                            break;
                    }

                    $vlr_trans_menor_rp_1=$transporte_menor->vlr_trans_menor_rp_1;
                    $vlr_trans_menor_rp_2=$transporte_menor->vlr_trans_menor_rp_2;
                    $vlr_trans_menor_rp_3=$transporte_menor->vlr_trans_menor_rp_3;
                    $vlr_trans_menor_rp_4=$transporte_menor->vlr_trans_menor_rp_4;
                    $vlr_trans_menor_ra_1=$transporte_menor->vlr_trans_menor_ra_1;
                    $vlr_trans_menor_ra_2=$transporte_menor->vlr_trans_menor_ra_2;
                    $vlr_trans_menor_ra_3=$transporte_menor->vlr_trans_menor_ra_3;
                    $vlr_trans_menor_ra_4=$transporte_menor->vlr_trans_menor_ra_4;

                /**Tabla transporte_menor */

                /**Tabla riesgos_amenazas_programacion */
                    $riesg_amen_practica->areas_acuaticas_rp=$request->get('areas_acuaticas_rp')=='on'?1:0;
                    $riesg_amen_practica->areas_acuaticas_ra=$request->get('areas_acuaticas_ra')=='on'?1:0;
                    $riesg_amen_practica->alturas_rp=$request->get('alturas_rp')=='on'?1:0;
                    $riesg_amen_practica->alturas_ra=$request->get('alturas_ra')=='on'?1:0;
                    $riesg_amen_practica->riesgo_biologico_rp=$request->get('riesgo_biologico_rp')=='on'?1:0;
                    $riesg_amen_practica->riesgo_biologico_ra=$request->get('riesgo_biologico_ra')=='on'?1:0;
                    $riesg_amen_practica->espacios_confinados_rp=$request->get('espacios_confinados_rp')=='on'?1:0;
                    $riesg_amen_practica->espacios_confinados_ra=$request->get('espacios_confinados_ra')=='on'?1:0;
                /**Tabla riesgos_amenazas_programacion */

                /**Tabla materiales_herramientas_programacion */
                    $mater_herra_programacion->det_materiales_rp=$request->get('det_materiales_rp');
                    $mater_herra_programacion->det_materiales_ra=$request->get('det_materiales_ra');
                
                    $mater_herra_programacion->det_guias_baquianos_rp=$request->get('det_guias_baquia_rp');
                    $mater_herra_programacion->det_guias_baquianos_ra=$request->get('det_guias_baquia_ra');
            
                    $mater_herra_programacion->det_otros_boletas_rp=$request->get('det_otros_bolet_rp');
                    $mater_herra_programacion->det_otros_boletas_ra=$request->get('det_otros_bolet_ra');
                /**Tabla materiales_herramientas_programacion */

                /**Tabla costos_programacion */
                
                    $vlr_materiales_rp=intval(str_replace(".","",$request->get('vlr_materiales_rp')));
                    $vlr_materiales_ra=intval(str_replace(".","",$request->get('vlr_materiales_ra')));
                    $vlr_guias_baquianos_rp=intval(str_replace(".","",$request->get('vlr_guias_baquia_rp')));
                    $vlr_guias_baquianos_ra=intval(str_replace(".","",$request->get('vlr_guias_baquia_ra')));
                    $vlr_otros_boletas_rp=intval(str_replace(".","",$request->get('vlr_otros_bolet_rp')));
                    $vlr_otros_boletas_ra=intval(str_replace(".","",$request->get('vlr_otros_bolet_ra')));

                    $costos_programacion->vlr_materiales_rp=$vlr_materiales_rp ;
                    $costos_programacion->vlr_materiales_ra=$vlr_materiales_ra ;
                    $costos_programacion->vlr_guias_baquianos_rp=$vlr_guias_baquianos_rp ;
                    $costos_programacion->vlr_guias_baquianos_ra=$vlr_guias_baquianos_ra ;
                    $costos_programacion->vlr_otros_boletas_rp=$vlr_otros_boletas_rp ;
                    $costos_programacion->vlr_otros_boletas_ra=$vlr_otros_boletas_ra ;

                    $total_otros_rp = $vlr_materiales_rp + $vlr_guias_baquianos_rp + $vlr_otros_boletas_rp;
                    $total_otros_ra = $vlr_materiales_ra + $vlr_guias_baquianos_ra + $vlr_otros_boletas_ra;

                    $num_dias_rp = $programacion_practica->duracion_num_dias_rp;
                    $num_dias_ra = $programacion_practica->duracion_num_dias_ra;
                    $num_estud = $programacion_practica->num_estudiantes_aprox;
                    $num_doc_pract_int = $practicas_integradas->cant_espa_aca;
                    $num_doc_apoyo = $docentes_practica->num_docentes_apoyo;
                    $total_docentes_apoyo = $docentes_practica->total_docentes_apoyo;
                    
                    $total_docentes = $num_doc_pract_int + $total_docentes_apoyo + 1;
                    //$costos_programacion=$programacion;
                    if($prog_aca->pregrado == 1)
                    {
                        $viaticos_estudiantes = $this->calc_viaticos_est($num_dias_rp,$num_dias_ra,$num_estud);
                        $viaticos_estudiantes_rp = $viaticos_estudiantes['viaticos_estud_rp'];
                        $viaticos_estudiantes_ra = $viaticos_estudiantes['viaticos_estud_ra'];
                    }
                    else{
                        $viaticos_estudiantes_rp = 0;
                        $viaticos_estudiantes_ra = 0;
                    }

                    $viaticos_docentes = $this->calc_viaticos_docen($num_dias_rp,$num_dias_ra,$total_docentes);
                    $viaticos_docente_rp =$viaticos_docentes['viaticos_docen_rp'];
                    $viaticos_docente_ra =$viaticos_docentes['viaticos_docen_ra'];

                    if($request->get('realizada_bogota_rp') == 1 && $num_dias_rp == 1){
                        $viaticos_estudiantes_rp = 0;
                        $viaticos_docente_rp = 0;
                    }
        
                    if($request->get('realizada_bogota_ra') == 1 && $num_dias_ra == 1){
                        $viaticos_estudiantes_ra = 0;
                        $viaticos_docente_ra = 0;
                    } 

                    $costos_programacion->viaticos_estudiantes_rp=$viaticos_estudiantes_rp;
                    $costos_programacion->viaticos_estudiantes_ra=$viaticos_estudiantes_ra;

                    $costos_programacion->viaticos_docente_rp=$viaticos_docente_rp;
                    $costos_programacion->viaticos_docente_ra=$viaticos_docente_ra;

                    $costo_total_transporte_menor_rp = $vlr_trans_menor_rp_1 + $vlr_trans_menor_rp_2 + $vlr_trans_menor_rp_3 + $vlr_trans_menor_rp_4;
                    $costo_total_transporte_menor_ra = $vlr_trans_menor_ra_1 + $vlr_trans_menor_ra_2 + $vlr_trans_menor_ra_3 + $vlr_trans_menor_ra_4;

                    $costos_programacion->costo_total_transporte_menor_rp =$costo_total_transporte_menor_rp;
                    $costos_programacion->costo_total_transporte_menor_ra =$costo_total_transporte_menor_ra;
                    
                    $costos_programacion->total_presupuesto_rp=$viaticos_estudiantes_rp + $viaticos_docente_rp + $total_otros_rp + $costo_total_transporte_menor_rp;
                    $costos_programacion->total_presupuesto_ra=$viaticos_estudiantes_ra + $viaticos_docente_ra + $total_otros_ra + $costo_total_transporte_menor_ra;

                    $costos_programacion->save();
                /**Tabla costos_programacion */
                $programacion_practica->update();
                $practicas_integradas->update();
                $docentes_practica->update();
                $costos_programacion->update();
                $transporte_programacion->update();
                $transporte_menor->update();
                $riesg_amen_practica->update();
                $mater_herra_programacion->update();
                }
                break;
            
        }
        return redirect('programaciones/filtrar/edit_proy');
    }

    /**
     * Carga de docentes para traspasar programación
     * @param \Illuminate\Http\Request
     * @param  Int  $id
     * @return \Illuminate\Http\Response
     */
    public function cargar_docentes_traspaso($id){
        $programacion = DB::table('programacion_practica')->where('id', $id)->first();
        if(!$programacion){
          return response()->json('No se ha encontrado la programación');
        }
        $docentes = DB::table('users as u')
        ->where(function($q) use ($programacion){
            $q->where('id_espacio_academico_1', $programacion->id_espacio_academico)
              ->orWhere('id_espacio_academico_2', $programacion->id_espacio_academico)
              ->orWhere('id_espacio_academico_3', $programacion->id_espacio_academico)
              ->orWhere('id_espacio_academico_4', $programacion->id_espacio_academico)
              ->orWhere('id_espacio_academico_5', $programacion->id_espacio_academico)
              ->orWhere('id_espacio_academico_6', $programacion->id_espacio_academico);
        })
        ->select('id',DB::raw('CONCAT_WS(" ", primer_nombre, segundo_nombre, primer_apellido, segundo_apellido) as full_name'))
        ->get();

        return response()->json([
        'docentes' => $docentes,
        'id_docente_responsable' => $programacion->id_docente_responsable ?? null
    ]);
    }

    /**
     * Traspasar Programación
     * @param \Illuminate\Http\Request
     * @param  Int  $id
     * @return \Illuminate\Http\Response
     */
    public function traspasar_update(Request $request, $id){
        try {
            DB::beginTransaction();
            $programacion = programacion::where('id', $id)->first();
            $nuevo_docente = DB::table('users')
            ->select('id',DB::raw('CONCAT_WS(" ", primer_nombre, segundo_nombre, primer_apellido, segundo_apellido) as full_name'))        
            ->where('id',$request->get('id_docente'));
            $programacion->id_docente_responsable = $request->get('id_docente');
            $transporte_menor = transporte_menor::where('id', $id)->first();
            if($transporte_menor->cant_trans_menor_rp > 0){
                $transporte_menor->docente_resp_t_menor_rp= $nuevo_docente->full_name;
            }
            if($transporte_menor->cant_trans_menor_ra > 0){
                $transporte_menor->docente_resp_t_menor_ra= $nuevo_docente->full_name;
            }
            $programacion->update();
            $transporte_menor->update();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el docente responsable de la programación. Intentalo nuevamente. ' . $e->getMessage());
        }
        return redirect('programaciones/filtrar/traspasar');        
    }

    /**
     * Ver Programación practica
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ver_programacion($id)
    {   
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $programacion_practica = programacion::find($id);
        $practicas_integradas = practicas_integradas::find($id);
        $transporte_programacion = transporte_programacion::find($id);
        $transporte_menor = transporte_menor::find($id);
        $docentes_practica = docentes_practica::find($id);
        $costos_programacion = costos_programacion::find($id);
        $mater_herra_programacion = materiales_herramientas_programacion::find($id);
        $riesg_amen_practica = riesgos_amenazas_practica::find($id);
        $idUser = $programacion_practica->id_docente_responsable;
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
        $sedes=DB::table('sedes_universidad')->get();
        $periodo_academico=DB::table('periodo_academico')->get();
        $semestre_asignatura=DB::table('semestre_asignatura')->get();
        $tipo_transporte=DB::table('tipo_transporte')->get();
        $vlr_viaticos=DB::table('control_sistema as cs')
                ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();

        $num_grupos_proy = 0; 

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
        
        $estado_doc_respon =$usuario_respon->id_estado;

        $newArray_prog = array_unique($prog_aca_user, SORT_REGULAR);
        $nomb_usuario = $usuario_log->primer_nombre.' '.$usuario_log->segundo_nombre.' '.$usuario_log->primer_apellido.' '.$usuario_log->segundo_apellido;
        $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

        $docentes = DB::table('docentes_practica')->where('id',$id)->first();
        $sop_pers_apoyo = $docentes->soporte_personal_apoyo;
        $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
        // $img_sop_pers_apoyo="data:image/png;base64,$sop_pers_apoyo";

        return view('programaciones.formularios.ver',["programacion_practica"=>$programacion_practica,
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
                                        "usuario_log"=>$usuario_log,
                                        "nombre_usuario"=>$nomb_usuario,
                                        "nombre_doc_resp"=>$nomb_doc_respon,
                                        "estado_doc_respon"=>$estado_doc_respon,
                                        "transporte_programacion"=>$transporte_programacion,
                                        "transporte_menor"=>$transporte_menor,
                                        "docentes_practica"=>$docentes_practica,
                                        "costos_programacion"=>$costos_programacion,
                                        "mater_herra_programacion"=>$mater_herra_programacion,
                                        "riesg_amen_practica"=>$riesg_amen_practica,
                                        "usuario"=>$usuario_log,
                                        "vlr_viaticos"=>$vlr_viaticos,
                                        'control_sistema'=>$control_sistema,
                                        'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,

        ]);

    }

    /**
     * Actualización Programación practica
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $mytime = Carbon::now('America/Bogota');
        $programacion_practica = programacion::where('id', '=', $id)->first();
        $transporte_programacion = transporte_programacion::where('id','=',$id)->first();
        $practicas_integradas = practicas_integradas::where('id','=',$id)->first();
        $transporte_menor = transporte_menor::where('id','=',$id)->first();
        $costos_programacion = costos_programacion::where('id','=',$id)->first();
        $docentes_practica = docentes_practica::where('id','=',$id)->first();
        $mater_herra_programacion = materiales_herramientas_programacion::where('id','=',$id)->first();
        $riesg_amen_practica = riesgos_amenazas_practica::where('id','=',$id)->first();
        $solicitud_practica = new  solicitud;
        // $cambios_programacion = new  cambios_programacion;
        $doc_req_sol = new  documentos_requeridos_solicitud;
        $id_prog_aca = $request->get('id_programa_academico');

        $prog_aca=DB::table('programa_academico')
        ->where('id',$id_prog_aca)->first();

        if(Auth::user()->id_role == 1 ||  Auth::user()->id_role == 4 || Auth::user()->id_role == 5)
        {
            if(Auth::user()->id == $programacion_practica->id_docente_responsable || Auth::user()->id_role == 1)
            {
                /**Tabla programacion_practica */
                    $programacion_practica->practicas_integradas = intval($request->get('integrada'));
                    $esp_aca = (!empty($request->get('id_espacio_academico')))?
                    $request->get('id_espacio_academico'):$programacion_practica->id_espacio_academico;

                    $id_prog_aca = ($request->get('id_programa_academico'))?
                    $request->get('id_programa_academico'):$programacion_practica->id_espacio_academico;

                    $esp_aca = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$id_prog_aca)
                    ->where('id','=',$esp_aca)->first();
                    $programacion_practica->id_espacio_academico=(!empty($esp_aca)||null)?
                    $esp_aca->id:$programacion_practica->id_espacio_academico;

                    $programacion_practica->id_programa_academico = $id_prog_aca;

                    $programacion_practica->id_semestre_asignatura=$request->get('id_semestre_asignatura');
                    $programacion_practica->id_periodo_academico=$request->get('id_periodo_academico');
                    $programacion_practica->anio_periodo=$request->get('anio_periodo');

                    $programacion_practica->num_estudiantes_aprox=$request->get('num_estudiantes_aprox');
                    $programacion_practica->cantidad_grupos=$request->get('cant_grupos');
                    
                    switch($programacion_practica->cantidad_grupos=$request->get('cant_grupos'))
                    {
                        case "1":
                            $programacion_practica->grupo_1=$request->get('grupo_1');
                            $programacion_practica->grupo_2=null;
                            $programacion_practica->grupo_3=null;
                            $programacion_practica->grupo_4=null;
                            break;
                        case "2":
                            $programacion_practica->grupo_1=$request->get('grupo_1');
                            $programacion_practica->grupo_2=$request->get('grupo_2');
                            $programacion_practica->grupo_3=null;
                            $programacion_practica->grupo_4=null;
                            break;
                        case "3":
                            $programacion_practica->grupo_1=$request->get('grupo_1');
                            $programacion_practica->grupo_2=$request->get('grupo_2');
                            $programacion_practica->grupo_3=$request->get('grupo_3');
                            $programacion_practica->grupo_4=null;
                            break;
                        case "4":
                            $programacion_practica->grupo_1=$request->get('grupo_1');
                            $programacion_practica->grupo_2=$request->get('grupo_2');
                            $programacion_practica->grupo_3=$request->get('grupo_3');
                            $programacion_practica->grupo_4=$request->get('grupo_4');
                            break;
                    }

                    $programacion_practica->fecha_salida_aprox_rp= $request->get('fecha_salida_aprox_rp');
                    $programacion_practica->fecha_regreso_aprox_rp= $request->get('fecha_regreso_aprox_rp');
                    $programacion_practica->fecha_salida_aprox_ra= $request->get('fecha_salida_aprox_ra');
                    $programacion_practica->fecha_regreso_aprox_ra= $request->get('fecha_regreso_aprox_ra');

                    $fecha_salida_rp = new DateTime($programacion_practica->fecha_salida_aprox_rp);
                    $fecha_regreso_rp = new DateTime($programacion_practica->fecha_regreso_aprox_rp);
                    $num_dias_rp = $fecha_salida_rp->diff($fecha_regreso_rp);
                    $programacion_practica->duracion_num_dias_rp=$num_dias_rp->days+1;

                    $fecha_salida_ra = new DateTime($programacion_practica->fecha_salida_aprox_ra);
                    $fecha_regreso_ra = new DateTime($programacion_practica->fecha_regreso_aprox_ra);
                    $num_dias_ra = $fecha_salida_ra->diff($fecha_regreso_ra);
                    $programacion_practica->duracion_num_dias_ra=$num_dias_ra->days+1;

                    $programacion_practica->realizada_bogota_rp=$request->get('realizada_bogota_rp');
                    $programacion_practica->realizada_bogota_ra=$request->get('realizada_bogota_ra');
                    $programacion_practica->destino_rp=$request->get('destino_rp');
                    $programacion_practica->destino_ra=$request->get('destino_ra');
                    $programacion_practica->det_recorrido_interno_rp=$request->get('det_recorrido_interno_rp');
                    $programacion_practica->det_recorrido_interno_ra=$request->get('det_recorrido_interno_ra');
                    $programacion_practica->lugar_salida_rp=$request->get('lugar_salida_rp');
                    $programacion_practica->lugar_regreso_rp=$request->get('lugar_regreso_rp');
                    $programacion_practica->lugar_salida_ra=$request->get('lugar_salida_ra');
                    $programacion_practica->lugar_regreso_ra=$request->get('lugar_regreso_ra');
                    
                    $programacion_practica->cantidad_url_rp=$request->get('cant_url_rp');
                    $programacion_practica->cantidad_url_ra=$request->get('cant_url_ra');
                   
                    switch($programacion_practica->cantidad_url_rp=$request->get('cant_url_rp'))
                    {
                        case"1":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=null;
                            $programacion_practica->ruta_principal_3=null;
                            $programacion_practica->ruta_principal_4=null;
                            $programacion_practica->ruta_principal_5=null;
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"2":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=null;
                            $programacion_practica->ruta_principal_4=null;
                            $programacion_practica->ruta_principal_5=null;
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"3":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                            $programacion_practica->ruta_principal_4=null;
                            $programacion_practica->ruta_principal_5=null;
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"4":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                            $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                            $programacion_practica->ruta_principal_5=null;
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"5":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                            $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                            $programacion_practica->ruta_principal_5=$request->get('ruta_principal_5');
                            $programacion_practica->ruta_principal_6=null;
                            break;
                        case"6":
                            $programacion_practica->ruta_principal=$request->get('ruta_principal');
                            $programacion_practica->ruta_principal_2=$request->get('ruta_principal_2');
                            $programacion_practica->ruta_principal_3=$request->get('ruta_principal_3');
                            $programacion_practica->ruta_principal_4=$request->get('ruta_principal_4');
                            $programacion_practica->ruta_principal_5=$request->get('ruta_principal_5');
                            $programacion_practica->ruta_principal_6=$request->get('ruta_principal_6');
                            break;
                    }
                    
                    switch($programacion_practica->cantidad_url_ra=$request->get('cant_url_ra'))
                    {
                        case "1":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=null;
                            $programacion_practica->ruta_alterna_3=null;
                            $programacion_practica->ruta_alterna_4=null;
                            $programacion_practica->ruta_alterna_5=null;
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "2":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=null;
                            $programacion_practica->ruta_alterna_4=null;
                            $programacion_practica->ruta_alterna_5=null;
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "3":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $programacion_practica->ruta_alterna_4=null;
                            $programacion_practica->ruta_alterna_5=null;
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "4":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $programacion_practica->ruta_alterna_5=null;
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "5":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $programacion_practica->ruta_alterna_5=$request->get('ruta_alterna_5');
                            $programacion_practica->ruta_alterna_6=null;
                            break;
                        case "6":
                            $programacion_practica->ruta_alterna=$request->get('ruta_alterna');
                            $programacion_practica->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $programacion_practica->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $programacion_practica->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $programacion_practica->ruta_alterna_5=$request->get('ruta_alterna_5');
                            $programacion_practica->ruta_alterna_6=$request->get('ruta_alterna_6');
                            break;
                    }

                    $programacion_practica->aprobacion_coordinador=5;
                    $programacion_practica->confirm_coord=0;
		            $programacion_practica->aprobacion_asistD=7;
                    $programacion_practica->aprobacion_decano=5;
                    $programacion_practica->confirm_asistD=1;
		            $costos_programacion->valor_estimado_transporte_rp=1;
		            $costos_programacion->valor_estimado_transporte_ra=1;

                /**Tabla programacion_practica */

                /**Tabla practicas_integradas */
                    $espa_aca_1=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_1'))->first();
                    $espa_aca_2=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_2'))->first();
                    $espa_aca_3=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_3'))->first();
                    $espa_aca_4=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_4'))->first();
                    $espa_aca_5=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_5'))->first();
                    $espa_aca_6=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_6'))->first();
                    $espa_aca_7=DB::table('espacio_academico as espa_aca')->where('id',$request->get('id_espa_aca_7'))->first();
                  

                    $practica_integrada = $request->get('integrada')==null?0:intval($request->get('integrada'));

                    if($practica_integrada == 1)
                    {
                        $practicas_integradas->cant_espa_aca=$request->get('cant_espa_aca');
                    }
                    else if($practica_integrada == 0)
                    {
                        $practicas_integradas->cant_espa_aca=0;
                    }
                    
                    switch($practicas_integradas->cant_espa_aca)
                    {
                        case "0":
                            $practicas_integradas->id_espa_aca_1=null;
                            $practicas_integradas->id_espa_aca_2=null;
                            $practicas_integradas->id_espa_aca_3=null;
                            $practicas_integradas->id_espa_aca_4=null;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=null;
                            $practicas_integradas->id_docen_espa_aca_2=null;
                            $practicas_integradas->id_docen_espa_aca_3=null;
                            $practicas_integradas->id_docen_espa_aca_4=null;
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "1":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=null;
                            $practicas_integradas->id_espa_aca_3=null;
                            $practicas_integradas->id_espa_aca_4=null;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=null;
                            $practicas_integradas->id_docen_espa_aca_3=null;
                            $practicas_integradas->id_docen_espa_aca_4=null;
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "2":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=null;
                            $practicas_integradas->id_espa_aca_4=null;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=null;
                            $practicas_integradas->id_docen_espa_aca_4=null;
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "3":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=null;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=null;
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "4":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                            $practicas_integradas->id_espa_aca_5=null;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                            $practicas_integradas->id_docen_espa_aca_5=null;
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "5":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                            $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                            $practicas_integradas->id_espa_aca_6=null;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                            $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                            $practicas_integradas->id_docen_espa_aca_6=null;
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "6":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                            $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                            $practicas_integradas->id_espa_aca_6=$espa_aca_6->id;
                            $practicas_integradas->id_espa_aca_7=null;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                            $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                            $practicas_integradas->id_docen_espa_aca_6=$request->get('id_docen_espa_aca_6');
                            $practicas_integradas->id_docen_espa_aca_7=null;
                            break;
                        case "7":
                            $practicas_integradas->id_espa_aca_1=$espa_aca_1->id;
                            $practicas_integradas->id_espa_aca_2=$espa_aca_2->id;
                            $practicas_integradas->id_espa_aca_3=$espa_aca_3->id;
                            $practicas_integradas->id_espa_aca_4=$espa_aca_4->id;
                            $practicas_integradas->id_espa_aca_5=$espa_aca_5->id;
                            $practicas_integradas->id_espa_aca_6=$espa_aca_6->id;
                            $practicas_integradas->id_espa_aca_7=$espa_aca_7->id;
                            $practicas_integradas->id_docen_espa_aca_1=$request->get('id_docen_espa_aca_1');
                            $practicas_integradas->id_docen_espa_aca_2=$request->get('id_docen_espa_aca_2');
                            $practicas_integradas->id_docen_espa_aca_3=$request->get('id_docen_espa_aca_3');
                            $practicas_integradas->id_docen_espa_aca_4=$request->get('id_docen_espa_aca_4');
                            $practicas_integradas->id_docen_espa_aca_5=$request->get('id_docen_espa_aca_5');
                            $practicas_integradas->id_docen_espa_aca_6=$request->get('id_docen_espa_aca_6');
                            $practicas_integradas->id_docen_espa_aca_7=$request->get('id_docen_espa_aca_7');
                            break;
                    }
                    for ($i = 1; $i <= 7; $i++) {
                        if ($i <= $practicas_integradas->cant_espa_aca) {
                            $practicas_integradas->{"es_responsable_$i"} = (int) $request->get("integrada_responsable_$i");
                        } else {
                            $practicas_integradas->{"es_responsable_$i"} = null;
                        }
                    }
                /**Tabla practicas_integradas */

                /**Tabla docentes_practica */
                    $docentes_practica->num_docentes_apoyo=$request->get('num_apoyo');
                    $docentes_practica->total_docentes_apoyo=$request->get('num_apoyo');
                    if($request->file('sop_pers_apoyo') != null){
                        $docentes_practica->soporte_personal_apoyo = $request->file('sop_pers_apoyo') != null ? base64_encode(file_get_contents($request->file('sop_pers_apoyo')->path())) : null;
                    }                    
                    switch($docentes_practica->num_docentes_apoyo=$request->get('num_apoyo'))
                    {
                        case "1":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=null;
                            $docentes_practica->num_doc_docente_apoyo_3=null;
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "2":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=null;
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "3":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "4":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "5":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "6":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "7":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('dapoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "8":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "9":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                            $docentes_practica->num_doc_docente_apoyo_9=$request->get('apoyo_9');
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            break;
                        case "10":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=$request->get('apoyo_8');
                            $docentes_practica->num_doc_docente_apoyo_9=$request->get('apoyo_9');
                            $docentes_practica->num_doc_docente_apoyo_10=$request->get('apoyo_10');
                            break;
                    }
                    for ($i = 1; $i <= 10; $i++) {
                        $docente_id = $request->get("apoyo_$i");

                        if ($docente_id) {
                            $nombre_docente = DB::table('users')
                                ->select(DB::raw('CONCAT_WS(" ", primer_nombre, segundo_nombre, primer_apellido, segundo_apellido) as full_name'))
                                ->where('id', $docente_id)
                                ->first();

                            $docentes_practica->{"docente_apoyo_$i"} = $nombre_docente->full_name;
                        } else {
                            $docentes_practica->{"docente_apoyo_$i"} = null;
                        }
                    }
                    for ($i = 1; $i <= 10; $i++) {
                        if ($i <= $docentes_practica->num_docentes_apoyo) {
                            $docentes_practica->{"es_responsable_$i"} = (int) $request->get("apoyo_responsable_$i");
                        } else {
                            $docentes_practica->{"es_responsable_$i"} = null;
                        }
                    }  
                /**Tabla docentes_practica */
                    
                /**Tabla transporte_programacion */
                    $transporte_programacion->cant_transporte_rp=$request->get('cant_transporte_rp_edit');
                    $transporte_programacion->cant_transporte_ra=$request->get('cant_transporte_ra_edit');

                    $tipo_transporte_rp = $request->get('id_tipo_transporte_rp_');
                    $det_tipo_transporte_rp = $request->get('det_tipo_transporte_rp_');
                    $capacid_transporte_rp = $request->get('capac_transporte_rp_');

                    $tipo_transporte_ra = $request->get('id_tipo_transporte_ra_');
                    $det_tipo_transporte_ra = $request->get('det_tipo_transporte_ra_');
                    $capacid_transporte_ra = $request->get('capac_transporte_ra_');

                    switch($transporte_programacion->cant_transporte_rp)
                    {
                        case "1":
                            $transporte_programacion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_programacion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_programacion->id_tipo_transporte_rp_2 =null;
                            $transporte_programacion->id_tipo_transporte_rp_3 =null;
                            $transporte_programacion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_programacion->det_tipo_transporte_rp_2=null;
                            $transporte_programacion->det_tipo_transporte_rp_3=null;
                            $transporte_programacion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_programacion->capac_transporte_rp_2=null;
                            $transporte_programacion->capac_transporte_rp_3=null;
                            $transporte_programacion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_programacion->exclusiv_tiempo_rp_2=null;
                            $transporte_programacion->exclusiv_tiempo_rp_3=null;
                            break;
                        case "2":
                            $transporte_programacion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_programacion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_programacion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??null;
                            $transporte_programacion->id_tipo_transporte_rp_3 =null;
                            $transporte_programacion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_programacion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??null;
                            $transporte_programacion->det_tipo_transporte_rp_3=null;
                            $transporte_programacion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_programacion->capac_transporte_rp_2=$capacid_transporte_rp[1]??null;
                            $transporte_programacion->capac_transporte_rp_3=null;
                            $transporte_programacion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_programacion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==null?null:intval($request->get('exclusiv_tiempo_rp_2'));
                            $transporte_programacion->exclusiv_tiempo_rp_3=null;
                            break;
                        case "3":
                            $transporte_programacion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_programacion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_programacion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??null;
                            $transporte_programacion->id_tipo_transporte_rp_3 =$tipo_transporte_rp[2]??null;
                            $transporte_programacion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_programacion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??null;
                            $transporte_programacion->det_tipo_transporte_rp_3=$det_tipo_transporte_rp[2]??null;
                            $transporte_programacion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_programacion->capac_transporte_rp_2=$capacid_transporte_rp[1]??null;
                            $transporte_programacion->capac_transporte_rp_3=$capacid_transporte_rp[2]??null;
                            $transporte_programacion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_programacion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==null?null:intval($request->get('exclusiv_tiempo_rp_2'));
                            $transporte_programacion->exclusiv_tiempo_rp_3=$request->get('exclusiv_tiempo_rp_3')==null?null:intval($request->get('exclusiv_tiempo_rp_3'));
                            break;
                    }

                    switch($transporte_programacion->cant_transporte_ra)
                    {
                        case "1":
                            $transporte_programacion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_programacion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_programacion->id_tipo_transporte_ra_2 =null;
                            $transporte_programacion->id_tipo_transporte_ra_3 =null;
                            $transporte_programacion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_programacion->det_tipo_transporte_ra_2=null;
                            $transporte_programacion->det_tipo_transporte_ra_3=null;
                            $transporte_programacion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_programacion->capac_transporte_ra_2=null;
                            $transporte_programacion->capac_transporte_ra_3=null;
                            $transporte_programacion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_programacion->exclusiv_tiempo_ra_2=null;
                            $transporte_programacion->exclusiv_tiempo_ra_3=null;
                            break;
                        case "2":
                            $transporte_programacion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_programacion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_programacion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??null;
                            $transporte_programacion->id_tipo_transporte_ra_3 =null;
                            $transporte_programacion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_programacion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??null;
                            $transporte_programacion->det_tipo_transporte_ra_3=null;
                            $transporte_programacion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_programacion->capac_transporte_ra_2=$capacid_transporte_ra[1]??null;
                            $transporte_programacion->capac_transporte_ra_3=null;
                            $transporte_programacion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_programacion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==null?null:intval($request->get('exclusiv_tiempo_ra_2'));
                            $transporte_programacion->exclusiv_tiempo_ra_3=null;
                            break;
                        case "3":
                            $transporte_programacion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_programacion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_programacion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??null;
                            $transporte_programacion->id_tipo_transporte_ra_3 =$tipo_transporte_ra[2]??null;
                            $transporte_programacion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_programacion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??null;
                            $transporte_programacion->det_tipo_transporte_ra_3=$det_tipo_transporte_ra[2]??null;
                            $transporte_programacion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_programacion->capac_transporte_ra_2=$capacid_transporte_ra[1]??null;
                            $transporte_programacion->capac_transporte_ra_3=$capacid_transporte_ra[2]??null;
                            $transporte_programacion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_programacion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==null?null:intval($request->get('exclusiv_tiempo_ra_2'));
                            $transporte_programacion->exclusiv_tiempo_ra_3=$request->get('exclusiv_tiempo_ra_3')==null?null:intval($request->get('exclusiv_tiempo_ra_3'));
                            break;
                    }
                /**Tabla transporte_programacion */

                /**Tabla transporte_menor */
                    $transporte_menor->cant_trans_menor_rp=$request->get('cant_trans_menor_rp');
                    $transporte_menor->cant_trans_menor_ra=$request->get('cant_trans_menor_ra');

                    switch($transporte_menor->cant_trans_menor_rp)
                    {
                        case "0":
                            $transporte_menor->docente_resp_t_menor_rp=null;
                            $transporte_menor->trans_menor_rp_1=null;
                            $transporte_menor->trans_menor_rp_2=null;
                            $transporte_menor->trans_menor_rp_3=null;
                            $transporte_menor->trans_menor_rp_4=null;
                            $transporte_menor->vlr_trans_menor_rp_1=0;
                            $transporte_menor->vlr_trans_menor_rp_2=0;
                            $transporte_menor->vlr_trans_menor_rp_3=0;
                            $transporte_menor->vlr_trans_menor_rp_4=0;
                            break;
                        case "1":
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=null;
                            $transporte_menor->trans_menor_rp_3=null;
                            $transporte_menor->trans_menor_rp_4=null;
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=0;
                            $transporte_menor->vlr_trans_menor_rp_3=0;
                            $transporte_menor->vlr_trans_menor_rp_4=0;
                            break;
                        case "2":
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                            $transporte_menor->trans_menor_rp_3=null;
                            $transporte_menor->trans_menor_rp_4=null;
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                            $transporte_menor->vlr_trans_menor_rp_3=0;
                            $transporte_menor->vlr_trans_menor_rp_4=0;
                            break;
                        case "3":
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                            $transporte_menor->trans_menor_rp_3=$request->get('trans_menor_rp_3');
                            $transporte_menor->trans_menor_rp_4=null;
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                            $transporte_menor->vlr_trans_menor_rp_3=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_3')));
                            $transporte_menor->vlr_trans_menor_rp_4=0;
                            break;
                        case "4":
                            $transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
                            $transporte_menor->trans_menor_rp_1=$request->get('trans_menor_rp_1');
                            $transporte_menor->trans_menor_rp_2=$request->get('trans_menor_rp_2');
                            $transporte_menor->trans_menor_rp_3=$request->get('trans_menor_rp_3');
                            $transporte_menor->trans_menor_rp_4=$request->get('trans_menor_rp_4');
                            $transporte_menor->vlr_trans_menor_rp_1=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_1')));
                            $transporte_menor->vlr_trans_menor_rp_2=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_2')));
                            $transporte_menor->vlr_trans_menor_rp_3=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_3')));
                            $transporte_menor->vlr_trans_menor_rp_4=intval(str_replace(".","",$request->get('vlr_trans_menor_rp_4')));
                            break;
                    }

                    switch($transporte_menor->cant_trans_menor_ra)
                    {
                        case "0":
                            $transporte_menor->docente_resp_t_menor_ra=null;
                            $transporte_menor->trans_menor_ra_1=null;
                            $transporte_menor->trans_menor_ra_2=null;
                            $transporte_menor->trans_menor_ra_3=null;
                            $transporte_menor->trans_menor_ra_4=null;
                            $transporte_menor->vlr_trans_menor_ra_1=0;
                            $transporte_menor->vlr_trans_menor_ra_2=0;
                            $transporte_menor->vlr_trans_menor_ra_3=0;
                            $transporte_menor->vlr_trans_menor_ra_4=0;
                            break;
                        case "1":
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=null;
                            $transporte_menor->trans_menor_ra_3=null;
                            $transporte_menor->trans_menor_ra_4=null;
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=0;
                            $transporte_menor->vlr_trans_menor_ra_3=0;
                            $transporte_menor->vlr_trans_menor_ra_4=0;
                            break;
                        case "2":
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                            $transporte_menor->trans_menor_ra_3=null;
                            $transporte_menor->trans_menor_ra_4=null;
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                            $transporte_menor->vlr_trans_menor_ra_3=0;
                            $transporte_menor->vlr_trans_menor_ra_4=0;
                            break;
                        case "3":
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                            $transporte_menor->trans_menor_ra_3=$request->get('trans_menor_ra_3');
                            $transporte_menor->trans_menor_ra_4=null;
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                            $transporte_menor->vlr_trans_menor_ra_3=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_3')));
                            $transporte_menor->vlr_trans_menor_ra_4=0;
                            break;
                        case "4":
                            $transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
                            $transporte_menor->trans_menor_ra_1=$request->get('trans_menor_ra_1');
                            $transporte_menor->trans_menor_ra_2=$request->get('trans_menor_ra_2');
                            $transporte_menor->trans_menor_ra_3=$request->get('trans_menor_ra_3');
                            $transporte_menor->trans_menor_ra_4=$request->get('trans_menor_ra_4');
                            $transporte_menor->vlr_trans_menor_ra_1=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_1')));
                            $transporte_menor->vlr_trans_menor_ra_2=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_2')));
                            $transporte_menor->vlr_trans_menor_ra_3=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_3')));
                            $transporte_menor->vlr_trans_menor_ra_4=intval(str_replace(".","",$request->get('vlr_trans_menor_ra_4')));
                            break;
                    }

                    $vlr_trans_menor_rp_1=$transporte_menor->vlr_trans_menor_rp_1;
                    $vlr_trans_menor_rp_2=$transporte_menor->vlr_trans_menor_rp_2;
                    $vlr_trans_menor_rp_3=$transporte_menor->vlr_trans_menor_rp_3;
                    $vlr_trans_menor_rp_4=$transporte_menor->vlr_trans_menor_rp_4;
                    $vlr_trans_menor_ra_1=$transporte_menor->vlr_trans_menor_ra_1;
                    $vlr_trans_menor_ra_2=$transporte_menor->vlr_trans_menor_ra_2;
                    $vlr_trans_menor_ra_3=$transporte_menor->vlr_trans_menor_ra_3;
                    $vlr_trans_menor_ra_4=$transporte_menor->vlr_trans_menor_ra_4;

                /**Tabla transporte_menor */

                /**Tabla riesgos_amenazas_programacion */
                    $riesg_amen_practica->areas_acuaticas_rp=$request->get('areas_acuaticas_rp')=='on'?1:0;
                    $riesg_amen_practica->areas_acuaticas_ra=$request->get('areas_acuaticas_ra')=='on'?1:0;
                    $riesg_amen_practica->alturas_rp=$request->get('alturas_rp')=='on'?1:0;
                    $riesg_amen_practica->alturas_ra=$request->get('alturas_ra')=='on'?1:0;
                    $riesg_amen_practica->riesgo_biologico_rp=$request->get('riesgo_biologico_rp')=='on'?1:0;
                    $riesg_amen_practica->riesgo_biologico_ra=$request->get('riesgo_biologico_ra')=='on'?1:0;
                    $riesg_amen_practica->espacios_confinados_rp=$request->get('espacios_confinados_rp')=='on'?1:0;
                    $riesg_amen_practica->espacios_confinados_ra=$request->get('espacios_confinados_ra')=='on'?1:0;
                /**Tabla riesgos_amenazas_programacion */

                /**Tabla materiales_herramientas_programacion */
                    $mater_herra_programacion->det_materiales_rp=$request->get('det_materiales_rp');
                    $mater_herra_programacion->det_materiales_ra=$request->get('det_materiales_ra');
                
                    $mater_herra_programacion->det_guias_baquianos_rp=$request->get('det_guias_baquia_rp');
                    $mater_herra_programacion->det_guias_baquianos_ra=$request->get('det_guias_baquia_ra');
            
                    $mater_herra_programacion->det_otros_boletas_rp=$request->get('det_otros_bolet_rp');
                    $mater_herra_programacion->det_otros_boletas_ra=$request->get('det_otros_bolet_ra');
                /**Tabla materiales_herramientas_programacion */

                /**Tabla costos_programacion */
                
                    $vlr_materiales_rp=intval(str_replace(".","",$request->get('vlr_materiales_rp')));
                    $vlr_materiales_ra=intval(str_replace(".","",$request->get('vlr_materiales_ra')));
                    $vlr_guias_baquianos_rp=intval(str_replace(".","",$request->get('vlr_guias_baquia_rp')));
                    $vlr_guias_baquianos_ra=intval(str_replace(".","",$request->get('vlr_guias_baquia_ra')));
                    $vlr_otros_boletas_rp=intval(str_replace(".","",$request->get('vlr_otros_bolet_rp')));
                    $vlr_otros_boletas_ra=intval(str_replace(".","",$request->get('vlr_otros_bolet_ra')));

                    $costos_programacion->vlr_materiales_rp=$vlr_materiales_rp ;
                    $costos_programacion->vlr_materiales_ra=$vlr_materiales_ra ;
                    $costos_programacion->vlr_guias_baquianos_rp=$vlr_guias_baquianos_rp ;
                    $costos_programacion->vlr_guias_baquianos_ra=$vlr_guias_baquianos_ra ;
                    $costos_programacion->vlr_otros_boletas_rp=$vlr_otros_boletas_rp ;
                    $costos_programacion->vlr_otros_boletas_ra=$vlr_otros_boletas_ra ;

                    $total_otros_rp = $vlr_materiales_rp + $vlr_guias_baquianos_rp + $vlr_otros_boletas_rp;
                    $total_otros_ra = $vlr_materiales_ra + $vlr_guias_baquianos_ra + $vlr_otros_boletas_ra;

                    $num_dias_rp = $programacion_practica->duracion_num_dias_rp;
                    $num_dias_ra = $programacion_practica->duracion_num_dias_ra;
                    $num_estud = $programacion_practica->num_estudiantes_aprox;
                    
                    $contador_validos = 0;
                    for ($i = 1; $i <= $practicas_integradas->cant_espa_aca; $i++) {
                        $docente_id = $request->get('id_docen_espa_aca_'.$i);
                        
                        if ($docente_id != $programacion_practica->id_docente_responsable) {
                            $contador_validos++;
                        }
                    }
                    $num_doc_pract_int = $contador_validos;
                    $num_doc_apoyo = $docentes_practica->num_docentes_apoyo;
                    $total_docentes_apoyo = $docentes_practica->total_docentes_apoyo;
                    
                    $total_docentes = $num_doc_pract_int + $total_docentes_apoyo + 1;

                    if($prog_aca->pregrado == 1)
                    {
                        $viaticos_estudiantes = $this->calc_viaticos_est($num_dias_rp,$num_dias_ra,$num_estud);
                        $viaticos_estudiantes_rp = $viaticos_estudiantes['viaticos_estud_rp'];
                        $viaticos_estudiantes_ra = $viaticos_estudiantes['viaticos_estud_ra'];
                    }
                    else{
                        $viaticos_estudiantes_rp = 0;
                        $viaticos_estudiantes_ra = 0;
                    }

                    $viaticos_docentes = $this->calc_viaticos_docen($num_dias_rp,$num_dias_ra,$total_docentes);
                    $viaticos_docente_rp =$viaticos_docentes['viaticos_docen_rp'];
                    $viaticos_docente_ra =$viaticos_docentes['viaticos_docen_ra'];

                    if($request->get('realizada_bogota_rp') == 1 && $num_dias_rp == 1){
                        $viaticos_estudiantes_rp = 0;
                        $viaticos_docente_rp = 0;
                    }
        
                    if($request->get('realizada_bogota_ra') == 1 && $num_dias_ra == 1){
                        $viaticos_estudiantes_ra = 0;
                        $viaticos_docente_ra = 0;
                    }

                    $costos_programacion->viaticos_estudiantes_rp=$viaticos_estudiantes_rp;
                    $costos_programacion->viaticos_estudiantes_ra=$viaticos_estudiantes_ra;

                    $costos_programacion->viaticos_docente_rp=$viaticos_docente_rp;
                    $costos_programacion->viaticos_docente_ra=$viaticos_docente_ra;

                    $costo_total_transporte_menor_rp = $vlr_trans_menor_rp_1 + $vlr_trans_menor_rp_2 + $vlr_trans_menor_rp_3 + $vlr_trans_menor_rp_4;
                    $costo_total_transporte_menor_ra = $vlr_trans_menor_ra_1 + $vlr_trans_menor_ra_2 + $vlr_trans_menor_ra_3 + $vlr_trans_menor_ra_4;

                    $costos_programacion->costo_total_transporte_menor_rp =$costo_total_transporte_menor_rp;
                    $costos_programacion->costo_total_transporte_menor_ra =$costo_total_transporte_menor_ra;
                    
                    $costos_programacion->total_presupuesto_rp=$viaticos_estudiantes_rp + $viaticos_docente_rp + $total_otros_rp + $costo_total_transporte_menor_rp;
                    $costos_programacion->total_presupuesto_ra=$viaticos_estudiantes_ra + $viaticos_docente_ra + $total_otros_ra + $costo_total_transporte_menor_ra;

                    $costos_programacion->save();
                /**Tabla costos_programacion */

                if(Auth::user()->id_programa_academico_coord == $programacion_practica->id_programa_academico)
                {
                    if($request->get('aprobacion_coordinador') == 4)
                    {
                        $programacion_practica->confirm_creador=1;
                        $programacion_practica->confirm_docente=1;
                        $programacion_practica->confirm_coord=0;
                        $programacion_practica->aprobacion_coordinador=5;
    
                    }
                }

            }

            /**campos coordinador */
                if(Auth::user()->id_role == 1 || (Auth::user()->id_role == 4 && Auth::user()->id_programa_academico_coord == $programacion_practica->id_programa_academico))
                {   //Auth::user()->hasRole(['Admin','Coordinador Proyecto']);

                    $programacion_practica->conf_curricul_plan_pract_rp=$request->get('conf_curricul_plan_pract_rp')=='on'?1:0;
                    $programacion_practica->conf_curricul_plan_pract_ra=$request->get('conf_curricul_plan_pract_ra')=='on'?1:0;

                    $programacion_practica->observ_coordinador= $request->get('observ_coordinador');
                    $programacion_practica->aprobacion_coordinador= $request->get('aprobacion_coordinador');
                    if($programacion_practica->aprobacion_coordinador == 7){
                        $programacion_practica->confirm_coord=1;
                    }                    
                    $programacion_practica->id_coordinador_aprob = Auth::user()->id;
		            $programacion_practica->aprobacion_asistD=7;
                    $programacion_practica->confirm_asistD=1;
                    $costos_programacion->valor_estimado_transporte_rp=1;
                    $costos_programacion->valor_estimado_transporte_ra=1;


                    
                    if($programacion_practica->aprobacion_decano == 4 && $programacion_practica->aprobacion_coordinador == 7)
                    {
                        $programacion_practica->aprobacion_decano=5;
                    }
                    else if($programacion_practica->aprobacion_decano == 4 && $programacion_practica->aprobacion_coordinador == 2)
                    {
                        $programacion_practica->id_estado = 2;
		    }
		    if($programacion_practica->aprobacion_consejo_facultad == 4)
                    {
                        $programacion_practica->aprobacion_consejo_facultad = 5;
                    }

                }
            /**campos coordinador */

        }

        if(Auth::user()->id_role == 1 || Auth::user()->id_role == 2 )
        {
            $programacion_practica->observ_decano= $request->get('observ_decano');
            $programacion_practica->aprobacion_decano= $request->get('aprobacion_decano')!=null?$request->get('aprobacion_decano'):$programacion_practica->aprobacion_decano;

            $programacion_practica->id_decano_aprob = Auth::user()->id;

            if($programacion_practica->aprobacion_consejo_facultad == 3)
            {
                $doc_resp = $request->get('docentes_activos');
                if(!empty($doc_resp) || $doc_resp != NULL)
                {
                    $programacion_practica->id_docente_responsable= $request->get('docentes_activos');
                }

                $programacion_practica->id_estado= $request->get('estado_programacion');
                $estado_proy = $request->get('estado_programacion');

                if($estado_proy == NULL)
                {
                    $estado_proy = 1;
                    $programacion_practica->id_estado = $estado_proy;
                }

                if($estado_proy == 2)
                {
                    $programacion_practica->observ_inactividad = $request->get('obs_inact_proy');
                }
            }
            $programacion_practica->update();
            
            if((Auth::user()->id_role == 1 || Auth::user()->id_role == 2) && $request->get('aprobacion_decano') == 4)
            {
                $programacion_practica->confirm_creador=1;
                $programacion_practica->confirm_docente=1;
                $programacion_practica->confirm_coord=0;
		#programacion_practica->confirm_asistD=0
                $programacion_practica->aprobacion_coordinador=5;
                #proteccion_preliminar->aprobacion_asistD=7
		$this->rechazo_decano_proy($id);

                $programacion_practica->update();
            
            }
            if(Auth::user()->id_role == 2)
            {

                return redirect('programaciones/filtrar/pend');
            }
        }

        if(Auth::user()->id_role == 1 || Auth::user()->id_role == 3 )
        {
            /** Debe tener valores para actualizar o no requerir transporte */
            if($transporte_programacion->cant_transporte_rp == 0)
            {
                $programacion_practica->aprobacion_asistD = 7;
                $programacion_practica->id_asistD_aprob = Auth::user()->id;
            }
            else if($transporte_programacion->cant_transporte_rp > 0)
            {
                if(($request->get('vlr_est_transp_rp') > 0) && ($request->get('vlr_est_transp_rp') != null))
                {
                    $valor_estimado_transporte_rp = $request->get('vlr_est_transp_rp')!=null?intval(str_replace(".","",$request->get('vlr_est_transp_rp'))):0;
    
                    $costo_total_transporte_menor_rp = $costos_programacion->costo_total_transporte_menor_rp;
                    
                    $viaticos_estudiantes_rp = $costos_programacion->viaticos_estudiantes_rp;
                    $viaticos_docente_rp = $costos_programacion->viaticos_docente_rp;
    
                    $costo_materiales_rp = $costos_programacion->vlr_materiales_rp;
    
                    $costo_baquianos_rp = $costos_programacion->vlr_guias_baquianos_rp;
    
                    $costo_boletas_rp = $costos_programacion->vlr_otros_boletas_rp;
                    
                    $total_presupuesto_rp= $costo_total_transporte_menor_rp + $viaticos_docente_rp + $viaticos_estudiantes_rp +  $costo_materiales_rp + $costo_baquianos_rp + $costo_boletas_rp;
                    
                    $costos_programacion->valor_estimado_transporte_rp = $valor_estimado_transporte_rp;
                    
                    $costos_programacion->total_presupuesto_rp = $total_presupuesto_rp;
                    $programacion_practica->aprobacion_asistD = 7;
                    $programacion_practica->id_asistD_aprob = Auth::user()->id;
                }
            }

            if($transporte_programacion->cant_transporte_ra == 0)
            {
                $programacion_practica->aprobacion_asistD = 7;
                $programacion_practica->id_asistD_aprob = Auth::user()->id;
            }
            else if($transporte_programacion->cant_transporte_ra > 0)
            {
                if(($request->get('vlr_est_transp_ra') > 0) && ($request->get('vlr_est_transp_ra') != null))
                {
                    $valor_estimado_transporte_ra = $request->get('vlr_est_transp_ra')!=null?intval(str_replace(".","",$request->get('vlr_est_transp_ra'))):0;
    
                    $costo_total_transporte_menor_ra = $costos_programacion->costo_total_transporte_menor_ra;
                    
                    $viaticos_estudiantes_ra = $costos_programacion->viaticos_estudiantes_ra;
                    $viaticos_docente_ra = $costos_programacion->viaticos_docente_ra;
    
                    $costo_materiales_ra = $costos_programacion->vlr_materiales_ra;
    
                    $costo_baquianos_ra = $costos_programacion->vlr_guias_baquianos_ra;
    
                    $costo_boletas_ra = $costos_programacion->vlr_otros_boletas_ra;
                    
                    $total_presupuesto_ra= $costo_total_transporte_menor_rp + $viaticos_docente_ra + $viaticos_estudiantes_ra +  $costo_materiales_ra + $costo_baquianos_ra + $costo_boletas_ra;
                    
                    $costos_programacion->valor_estimado_transporte_ra = $valor_estimado_transporte_ra;
                    
                    $costos_programacion->total_presupuesto_ra = $total_presupuesto_ra;
                    $programacion_practica->aprobacion_asistD = 7;
                    $programacion_practica->id_asistD_aprob = Auth::user()->id;
                }
            }

            /** Debe tener valores para actualizar o no requerir transporte*/

            /** Agregar  aprobacion_consejo_facultad */
                if($programacion_practica->aprobacion_decano == 7)
                {
                    $aprobacion_consejo_facultad = $request->get('aprobacion_consejo_facultad');
                    $programacion_practica->aprobacion_consejo_facultad = $aprobacion_consejo_facultad;

                    if($aprobacion_consejo_facultad == 3)
                    {
                        $programacion_practica->num_acta_consejo_facultad = $request->get('num_acta_consejo_facultad');
                        $programacion_practica->fecha_acta_consejo_facultad = $request->get('fecha_acta_consejo_facultad');

                        $sol_pract = DB::table('solicitud_practica as sol_prac')
                            ->where('sol_prac.id_programacion_practica',$programacion_practica->id)
                            ->first();

                        if($sol_pract == NULL || empty($sol_pract))
                        {
                            $solicitud_practica->id_programacion_practica = $id;
                            $solicitud_practica->id_estado_solicitud_practica = 5;
                            $solicitud_practica->save();

                            $doc_req_sol->id =$solicitud_practica->id;
                            $doc_req_sol->save();
                        }   

                    }else if($aprobacion_consejo_facultad == 4){
                        $programacion_practica->confirm_creador=1;
                        $programacion_practica->confirm_docente=1;
                        $programacion_practica->confirm_coord=0;
                        $programacion_practica->aprobacion_decano=5;
                        $programacion_practica->aprobacion_coordinador=5;
                    }

                    $programacion_practica->id_asistD_aprob_consejo = Auth::user()->id;
                }
            /** Agregar  aprobacion_consejo_facultad */
        }

        if(Auth::user()->id_role == 1)
        {
            $programacion_practica->id_estado=$request->get('estado_programacion');
            $estado_proy = $request->get('estado_programacion');

            if($estado_proy == NULL)
            {
                $estado_proy = 1;
                $programacion_practica->id_estado = $estado_proy;
            }

            if($estado_proy == 2)
            {
                $sol_pract = DB::table('solicitud_practica as sol_prac')
                    ->where('sol_prac.id_programacion_practica',$programacion_practica->id)
                    ->first();

                if($sol_pract != NULL || !empty($sol_pract))
                {
                    $solicitud_practica = solicitud::where('id_programacion_practica','=',$programacion_practica->id)->first();

                    $solicitud_practica->id_estado_solicitud_practica = 2;
                    $solicitud_practica->observ_inactividad = $request->get('obs_inact_proy');

                    $solicitud_practica->update();
                }

                $programacion_practica->observ_inactividad = $request->get('obs_inact_proy');
            }
            else
            {
                $programacion_practica->observ_inactividad = NULL;
            }
        }  
        
        $programacion_practica->update();
        $practicas_integradas->update();
        $docentes_practica->update();
        $costos_programacion->update();
        $transporte_programacion->update();
        $transporte_menor->update();
        $riesg_amen_practica->update();
        $mater_herra_programacion->update();
        // $solicitud_practica->save();

        /** Enviar notificacion */
            if(Auth::user()->id_role == 4 && $request->get('aprobacion_coordinador') == 7)
            {
                $this->aprob_coord_proy($id);
            }

            if(Auth::user()->id_role == 4 && $request->get('aprobacion_coordinador') == 4)
            {
                $this->rechazo_coord_proy($id);
            }

            if(Auth::user()->id_role == 4 && $request->get('aprobacion_coordinador') == 2)
            {
                $this->cierre_coord_proy($id);
            }
            
            if(Auth::user()->id_role == 1 || Auth::user()->id_role == 3 )
            {
                if($programacion_practica->aprobacion_decano == 7)
                {
                    if($aprobacion_consejo_facultad == 3)
                    {
                        return redirect('programaciones/filtrar/all');
                    }
                }
            }

            
        /** Enviar notificacion */
        if(Auth::user()->id_role == 1 )
        {
            return redirect('programaciones/filtrar/all');
        }

        return redirect('programaciones/filtrar/send');
    }

    /**
     * Formulario para elegir Programación a duplicar
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicar_index()
    {
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        $control_sistema = DB::table('control_sistema')->first();
        $programaciones=DB::table('programacion_practica as p_prel')
        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico',
                'p_prel.destino_rp','p_prel.destino_ra')
        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
        ->where('id_docente_responsable','=',Auth::user()->id)
        ->where('p_prel.id_estado','=',1)        
        ->paginate(10000);
        return view('programaciones.duplicar.index',['control_sistema'=>$control_sistema,
                                    'programaciones'=>$programaciones,
                                    'usuario'=>$usuario]);
    }
    /**
     * Duplicar Programación
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicar($id)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $idRole = Auth::user()->id_role;
        switch($idRole){
            case 5:                
                $programacion_practica = programacion::find($id);
                // $cambios_programacion = cambios_programacion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_programacion = transporte_programacion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica= docentes_practica::find($id);
                $costos_programacion = costos_programacion::find($id);
                $mater_herra_programacion = materiales_herramientas_programacion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $programacion_practica->id_docente_responsable;
                // $idUser = Auth::user()->id;
                $usuario=DB::table('users')
                ->where('id','=',$idUser)->first();

                $usuario_respon=$usuario;

                $programa_academico = DB::table('programa_academico')->get();
                $espacio_academico=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
                $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $sedes=DB::table('sedes_universidad')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max_estimado', 'cs.vlr_estud_min_estimado',
                        'cs.vlr_docen_min_estimado', 'cs.vlr_docen_max_estimado')->first();

                $docentes=DB::table('users')
                ->select('users.id',DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->where('id_role',5)
                ->where('id','!=',Auth::user()->id)
                ->orderBy('users.primer_nombre','ASC')
                ->get(); 

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
                $newArray_docen_integ = array_unique($docen_integ, SORT_REGULAR);
                $nomb_usuario = $usuario->primer_nombre.' '.$usuario->segundo_nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido;
                $nomb_doc_respon = $usuario_respon->primer_nombre.' '.$usuario_respon->segundo_nombre.' '.$usuario_respon->primer_apellido.' '.$usuario_respon->segundo_apellido;

                $sop_pers_apoyo = $docentes_practica->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
                // $img_sop_pers_apoyo="data:image/png;base64,$sop_pers_apoyo";
        
                return view('programaciones.duplicar.edit',["programacion_practica"=>$programacion_practica,
                                                // "cambios_programacion"=>$cambios_programacion,
                                                "programas_academicos"=>$programa_academico,
                                                "all_users"=>$newArray_docen_integ,
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
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "nombre_doc_resp"=>$nomb_doc_respon,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "transporte_programacion"=>$transporte_programacion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_programacion"=>$costos_programacion,
                                                "mater_herra_programacion"=>$mater_herra_programacion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
                                                'docentes'=>$docentes

        
                ]);
            break;
        }
    }

    /**
     * Programación practica enviada-confirmada
     *
     * @return \Illuminate\Http\Response
     */
    public function sendProy(Request $request)
    {

        $idRole = Auth::user()->id_role;
        $idUser = Auth::user()->id;

        $id_programaciones_confimadas = $request->get('data');
        switch($idRole)
        {
            case 1:
            break;

            case 2:
            break;

            case 3:
                foreach($id_programaciones_confimadas as $id)
                {
                    $programacion = programacion::find($id);
                    $programacion->confirm_asistD = 1;
                    $programacion->id_asistD_confirm = $idUser;
                    $programacion->update();
                }
            break;

            case 4:
                foreach($id_programaciones_confimadas as $id)
                {
                    $programacion = programacion::find($id);
                    // $programacion->confirm_electiva_coord = 1;
                    // $programacion->id_coordinador_electiva_confirm = $idUser;
                    $programacion->confirm_coord = 1;
                    $programacion->aprobacion_coordinador = 7;
                    $programacion->id_coordinador_confirm = $idUser;
                    $programacion->update();
                }
            break;

            case 5:
                foreach($id_programaciones_confimadas as $id)
                {
                    $programacion = programacion::find($id);
                    $programacion->confirm_docente = 1;
                    $programacion->id_docente_confirm = $idUser;
                    $programacion->update();
                }

                // $this->creacion_proy($id_programaciones_confimadas);
            break;

        }

        $filter = "send";

        return route('programacion_filter',['id'=>$filter]);
    }

    /**
     * Programación practica visto bueno decanatura
     *
     * @return \Illuminate\Http\Response
     */
    public function vbProy(Request $request)
    {

        // DB::beginTransaction();
        // try
        // {
            $idRole = Auth::user()->id_role;
            $idUser = Auth::user()->id;

            $id_programaciones_vb_decano = $request->get('data');
            switch($idRole)
            {

                case 1:
                    foreach($id_programaciones_vb_decano as $id)
                    {
                        $programacion = programacion::find($id);
                        $programacion->aprobacion_decano = 7;
                        $programacion->id_decano_aprob = $idUser;
                        $programacion->update();
                    }
                break;

                case 2:
                    foreach($id_programaciones_vb_decano as $id)
                    {
                        $programacion = programacion::find($id);
                        $programacion->aprobacion_decano = 7;
                        $programacion->id_decano_aprob = $idUser;
                        $programacion->update();
                    }
                    $this->vb_decano_proy($id_programaciones_vb_decano);
                break;

            }

        $filter = "aprob";

        return route('programacion_filter',['filter'=>$filter]);
    }

    /**
     * Validar asignaturas electivas
     *
     * @return \Illuminate\Http\Response
     */
    public function validar_electivas(Request $request)
    {
        $id_programaciones_confimadas = $request->get('data');
        $proy = 0;
        $id_elect = [];

        if(count($id_programaciones_confimadas) == 1)
        {
            $programacion=DB::table('programacion_practica as p_prel')
            ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico','e_aca.electiva')
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->where('p_prel.id','=',$id_programaciones_confimadas)
            ->where('e_aca.electiva','=',1)->first();

            if(!empty($programacion))
            {
                $id_elect[] += $programacion->id;
            }
        }

        elseif(count($id_programaciones_confimadas) > 1)
        {

            foreach($id_programaciones_confimadas as $id)
            {
                $programacion=DB::table('programacion_practica as p_prel')
                            ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico','e_aca.electiva')
                            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                            ->where('p_prel.id','=',$id)
                            ->where('e_aca.electiva','=',1)->first();
    
                
                if(!empty($programacion))
                {
                    $id_elect[] += $programacion->id;
                }
            }
        }

        return response()->json($id_elect);
    }

    /**
     * Información sobre la creación de la Programación
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function creacion_proy($id)
    {
        try {
            $correos_administrativos = [];
            $filter = "creacion_proy";
            $nueva_solicitud = "";
            
            $nueva_programacion = DB::table('programacion_practica as proy_pre')
                                ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
                                        'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca','proy_pre.anio_periodo',
                                        'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
                                        DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                                ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                                ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                                ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                                ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                                ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                                ->where('proy_pre.id','=',$id)->first();

            $id_creador = $nueva_programacion->id_docente_responsable;
            $creador=DB::table('users')->where('id','=',$id_creador)->first();
            $id_esp_aca = $nueva_programacion->id_esp_aca;
            $id_pro_aca = $nueva_programacion->id_pro_aca;
            $coord =DB::table('users')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
            
            $emails = [];

            $emails[] = ["email"=>$creador->email, "role"=>$creador->id_role];
            $emails[] = ["email"=>$coord->email, "role"=>$coord->id_role];
            
            /*foreach($emails as $email){
                try {
                    Mail::bcc($email['email'])
                        ->send(new CodigoMail($filter,$nueva_programacion,$nueva_solicitud,$email, $correos_administrativos));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("$filter -- Error enviando correo a {$email['email']}: " . $e->getMessage());
                    continue;
                }
            }*/
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("$filter -- Ha ocurrido un error al enviar notificación por correo. " . $e->getMessage());
        }        
    }

    /**
     * Aprobación de la Programación por coordinación
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function aprob_coord_proy($id)
    {
        try {
            $correos_administrativos = [];
            $nueva_programacion = "";
            $nueva_solicitud = "";
            $filter = "aprob_coord_proy";

            $nueva_programacion = DB::table('programacion_practica as proy_pre')
                                ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
                                        'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca',
                                        'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
                                        DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                                ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                                ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                                ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                                ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                                ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                                ->where('proy_pre.id','=',$id)->first();

            $id_creador = $nueva_programacion->id_docente_responsable;
            $creador=DB::table('users')->where('id','=',$id_creador)->first();
            $id_pro_aca = $nueva_programacion->id_pro_aca;
            $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
            $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
            $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->get();
            $emails = [];

            $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
            $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];

            /*foreach($emails as $email){
                try {
                    Mail::bcc($email['email'])
                        ->send(new CodigoMail($filter,$nueva_programacion,$nueva_solicitud,$email, $correos_administrativos));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("$filter -- Error enviando correo a {$email['email']}: " . $e->getMessage());
                    continue;
                }
            }*/
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("$filter -- Ha ocurrido un error al enviar notificación por correo. " . $e->getMessage());
        } 
    }

    /**
     * Rechazo de la Programación por coordinación
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function rechazo_coord_proy($id)
    {
        try {
            $correos_administrativos = [];
            $nueva_programacion = "";
            $nueva_solicitud = "";
            $filter = "rechazo_coord_proy";

            $nueva_programacion = DB::table('programacion_practica as proy_pre')
                                ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
                                        'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca', 'proy_pre.observ_coordinador',
                                        'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
                                        DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                                ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                                ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                                ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                                ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                                ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                                ->where('proy_pre.id','=',$id)->first();

            $id_creador = $nueva_programacion->id_docente_responsable;
            $creador=DB::table('users')->where('id','=',$id_creador)->first();
            // $id_esp_aca = $nueva_programacion->id_esp_aca;
            $id_pro_aca = $nueva_programacion->id_pro_aca;
            $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
            $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
            $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->get();
            $emails = [];

            $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
            //$emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
            //$emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];

            /*foreach($emails as $email){
                try {
                    Mail::bcc($email['email'])
                        ->send(new CodigoMail($filter,$nueva_programacion,$nueva_solicitud,$email, $correos_administrativos));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("$filter -- Error enviando correo a {$email['email']}: " . $e->getMessage());
                    continue;
                }
            }*/
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("$filter -- Ha ocurrido un error al enviar notificación por correo. " . $e->getMessage());
        } 
    }

    /**
     * Aprobación de la Programación por decanatura
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function aprob_decano_proy($id)
    {
        try{
            $correos_administrativos = [];
            $nueva_programacion = "";
            $nueva_solicitud = "";
            $filter = "aprob_decano_proy";

            $nueva_programacion = DB::table('programacion_practica as proy_pre')
                                ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
                                        'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca',
                                        'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
                                        DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                                ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                                ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                                ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                                ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                                ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                                ->where('proy_pre.id','=',$id)->first();

            $id_creador = $nueva_programacion->id_docente_responsable;
            $creador=DB::table('users')->where('id','=',$id_creador)->first();
            $id_pro_aca = $nueva_programacion->id_pro_aca;
            $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
            $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
            $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->get();
            $emails = [];

            $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
            //$emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
            foreach ($AsisD as $user) {
                $emails[] = ["email" => $user->email,"role"  => $user->id_role];
            }

            /*foreach($emails as $email){
                try {
                    Mail::bcc($email['email'])
                        ->send(new CodigoMail($filter,$nueva_programacion,$nueva_solicitud,$email, $correos_administrativos));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("$filter -- Error enviando correo a {$email['email']}: " . $e->getMessage());
                    continue;
                }
            }*/
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("$filter -- Ha ocurrido un error al enviar notificación por correo. " . $e->getMessage());
        } 
    }

    /**
     * Rechazo de la Programación por decanatura
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function rechazo_decano_proy($id)
    {
        try{
            $correos_administrativos = [];
            $nueva_programacion = "";
            $nueva_solicitud = "";
            $filter = "rechazo_decano_proy";

            $nueva_programacion = DB::table('programacion_practica as proy_pre')
                                ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
                                        'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca', 'proy_pre.observ_coordinador','proy_pre.observ_decano',
                                        'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
                                        DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                                ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                                ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                                ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                                ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                                ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                                ->where('proy_pre.id','=',$id)->first();

            $id_creador = $nueva_programacion->id_docente_responsable;
            $creador=DB::table('users')->where('id','=',$id_creador)->first();
            // $id_esp_aca = $nueva_programacion->id_esp_aca;
            $id_pro_aca = $nueva_programacion->id_pro_aca;
            $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
            $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
            $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
            $emails = [];

            // $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
            $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
            // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
            // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

            /*foreach($emails as $email){
                try {
                    Mail::bcc($email['email'])
                        ->send(new CodigoMail($filter,$nueva_programacion,$nueva_solicitud,$email, $correos_administrativos));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("$filter -- Error enviando correo a {$email['email']}: " . $e->getMessage());
                    continue;
                }
            }*/
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("$filter -- Ha ocurrido un error al enviar notificación por correo. " . $e->getMessage());
        } 
    }

    /**
     * Cierre de la Programación por coordinación
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function cierre_coord_proy($id)
    {
        try{
        $correos_administrativos = [];
        $nueva_programacion = "";
        $nueva_solicitud = "";
        $filter = "cierre_coord_proy";

        $nueva_programacion = DB::table('programacion_practica as proy_pre')
                            ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
                                    'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca', 'proy_pre.observ_coordinador','proy_pre.observ_decano',
                                    'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
                                    DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                            ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                            ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                            ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                            ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                            ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                            ->where('proy_pre.id','=',$id)->first();

        $id_creador = $nueva_programacion->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_programacion->id_esp_aca;
        $id_pro_aca = $nueva_programacion->id_pro_aca;
        $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

            /*foreach($emails as $email){
                try {
                    Mail::bcc($email['email'])
                        ->send(new CodigoMail($filter,$nueva_programacion,$nueva_solicitud,$email, $correos_administrativos));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("$filter -- Error enviando correo a {$email['email']}: " . $e->getMessage());
                    continue;
                }
            }*/
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("$filter -- Ha ocurrido un error al enviar notificación por correo. " . $e->getMessage());
        } 
    }

    /**
     * Visto bueno programaciones por decanatura
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function vb_decano_proy($list_proy)
    {
        try
        {
            $nueva_programacion = [];
            $nueva_solicitud = "";
            $filter = "vb_decano_proy";
            

            foreach($list_proy as $item)
            {
                $programacion = DB::table('programacion_practica as proy_pre')
                                ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
                                        'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca', 'proy_pre.anio_periodo',
                                        'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
                                        'proy_pre.fecha_salida_aprox_rp','proy_pre.fecha_regreso_aprox_rp','proy_pre.fecha_salida_aprox_ra','proy_pre.fecha_regreso_aprox_ra',
                                        DB::raw('CONCAT(users.primer_nombre, " ", users.primer_apellido) as full_name'))
                                ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                                ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                                ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                                ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                                ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                                ->where('proy_pre.id','=',$item)->first();   
                
                $nueva_programacion[] = ['id'=>$programacion->id,
                                        'programa_academico'=>$programacion->programa_academico,
                                        'espacio_academico'=>$programacion->espacio_academico,
                                        'sem_academico'=>$programacion->semestre_asignatura,
                                        'anio'=>$programacion->anio_periodo,
                                        'per_academico'=>$programacion->periodo_academico,
                                        'docente_responsable'=>$programacion->full_name,
                                        'destino_rp'=>$programacion->destino_rp,
                                        'fecha_salida_aprox_rp'=>$programacion->fecha_salida_aprox_rp,
                                        'fecha_regreso_aprox_rp'=>$programacion->fecha_regreso_aprox_rp,
                                        'destino_ra'=>$programacion->destino_ra,
                                        'fecha_salida_aprox_ra'=>$programacion->fecha_salida_aprox_ra,
                                        'fecha_regreso_aprox_ra'=>$programacion->fecha_regreso_aprox_ra];
            }
        
            $sec_acad =DB::table('correos_administrativos as c_admin')
                    ->where('c_admin.id','=',1)
                    ->orWhere('c_admin.area_dependencia','=','Secretaría Académica')
                    ->first();
                    
            $emails = [];
            $emails[] = ["email"=>$sec_acad->correo,"dependencia"=>$sec_acad->area_dependencia];
        
            $correos_administrativos = $emails;
            /*foreach($emails as $email){
                try {
                    Mail::bcc($email['email'])
                        ->send(new CodigoMail($filter,$nueva_programacion,$nueva_solicitud,$email, $correos_administrativos));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("$filter -- Error enviando correo a {$email['email']}: " . $e->getMessage());
                    continue;
                }
            }*/
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("$filter -- Ha ocurrido un error al enviar notificación por correo. " . $e->getMessage());
        } 
    }


    /**
     * Buscador de Programación por palabras claves 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function buscador(Request $request,$id_sel)
    public function buscador(Request $request)
    {

        $proy_sel=[];
        $proy_sel=$request->get('sort');
        if($request && ($request->get('searchText')) != null)
        {

            $id[] = 0;
            $control_sistema =DB::table('control_sistema')->first();
            $query=trim($request->get('searchText'));
            $idUser = Auth::user()->id;
            $usuario =DB::table('users')
                    ->where('id',$idUser)->first();

            $programacion=DB::table('programacion_practica as p_prel')
            ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico','p_prel.id_docente_responsable',
                    'p_prel.destino_rp','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp','es_coor.abrev as ab_coor',
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
            ->join('costos_programacion as c_proy','p_prel.id','=','c_proy.id')
            ->where('p_prel.id_estado','=',1)
            ->where('p_prel.id','LIKE','%'.$query.'%')
            ->orWhere('users.primer_nombre','LIKE','%'.$query.'%')
            ->orWhere('users.segundo_nombre','LIKE','%'.$query.'%')
            ->orWhere('users.primer_apellido','LIKE','%'.$query.'%')
            ->orWhere('users.segundo_apellido','LIKE','%'.$query.'%')
            ->orWhere('p_aca.programa_academico','LIKE','%'.$query.'%')
            ->orWhere('e_aca.espacio_academico','LIKE','%'.$query.'%')
            ->orWhere('p_prel.destino_rp','LIKE','%'.$query.'%')
            ->orWhere('p_prel.destino_ra','LIKE','%'.$query.'%')
            
            ->paginate(500)
            ->appends(request()->query());
            
            $cant_resul = count($programacion);
        }
        else{
            return redirect('programaciones/filtrar/all');
        }
        return view('programaciones.buscador.tabla_buscador',['programaciones'=>$programacion, 
                                                                'searchText'=>$query, 
                                                                'cant_resul'=>$cant_resul, 
                                                                'usuario'=>$usuario,
                                                                'control_sistema'=>$control_sistema]);
    }

    /**
     * Formato de fecha en letras 
     *
     * @param  string  $fecha
     * @return \Illuminate\Http\Response
     */
    public function obtenerFechaEnLetra($fecha){
        $num = date("j", strtotime($fecha));
        $anno = date("Y", strtotime($fecha));
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes[(date('m', strtotime($fecha))*1)-1];
        return ["num"=>$num,"mes"=>$mes,"anio"=>$anno];
    }

    /**
     * Calcular auxilio para estudiantes
     *
     * @param  int  $num_dias_rp
     * @param  int  $num_dias_ra
     * @param  int  $num_estud
     * @return \Illuminate\Http\Response
     */
    public function calc_viaticos_est($num_dias_rp,$num_dias_ra,$num_estud)
    {
        $control_sistema=DB::table('control_sistema as control')->first();
        $vlr_estud_max_estimado=$control_sistema->vlr_estud_max_estimado;
        $vlr_estud_min_estimado=$control_sistema->vlr_estud_min_estimado;

        if($num_dias_rp>1)
        {
            $viaticos_estud_rp = $num_estud*$vlr_estud_max_estimado*$num_dias_rp;
        }
        else if($num_dias_rp==1)
        {
            $viaticos_estud_rp = $num_estud*$vlr_estud_min_estimado*$num_dias_rp;
        }
        else if($num_dias_rp==0 || $num_dias_rp == null || isEmpty($num_dias_rp))
        {
            $viaticos_estud_rp = 0;
        }

        if($num_dias_ra>1)
        {
            $viaticos_estud_ra = $num_estud*$vlr_estud_max_estimado*$num_dias_ra;
        }
        else if($num_dias_ra==1)
        {
            $viaticos_estud_ra = $num_estud*$vlr_estud_min_estimado*$num_dias_ra;
        }
        else if($num_dias_ra==0 || $num_dias_ra == null || isEmpty($num_dias_ra))
        {
            $viaticos_estud_ra = 0;
        }

        return ['viaticos_estud_rp'=>$viaticos_estud_rp,'viaticos_estud_ra'=>$viaticos_estud_ra];
    }

    /**
     * Calcular viáticos para docentes
     *
     * @param  int  $num_dias_rp
     * @param  int  $num_dias_ra
     * @param  int  $total_docentes
     * @return \Illuminate\Http\Response
     */
    public function calc_viaticos_docen($num_dias_rp,$num_dias_ra,$total_docentes)
    {
        $control_sistema=DB::table('control_sistema as control')->first();
        $vlr_docen_max_estimado=$control_sistema->vlr_docen_max_estimado;
        $vlr_docen_min_estimado=$control_sistema->vlr_docen_min_estimado;

        if($num_dias_rp>1)
        {
            $viaticos_docen_rp = $total_docentes*$vlr_docen_max_estimado*($num_dias_rp-0.5);
        }
        else if($num_dias_rp==0 || $num_dias_rp==1 || $num_dias_rp == null || isEmpty($num_dias_rp))
        {
            $viaticos_docen_rp = 0;
        }

        if($num_dias_ra>1)
        {
            $viaticos_docen_ra = $total_docentes*$vlr_docen_max_estimado*($num_dias_ra-0.5);
        }
        else if($num_dias_ra==0 || $num_dias_ra==1 || $num_dias_ra == null || isEmpty($num_dias_ra))
        {
            $viaticos_docen_ra = 0;
        }

        return ['viaticos_docen_rp'=>$viaticos_docen_rp,'viaticos_docen_ra'=>$viaticos_docen_ra];
    }
}
