<?php

namespace PractiCampoUD\Http\Controllers\Proyeccion;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use PractiCampoUD\costos_proyeccion;
use PractiCampoUD\docentes_practica;
use PractiCampoUD\documentos_requeridos_solicitud;
use PractiCampoUD\estudiantes_practica;
use PractiCampoUD\materiales_herramientas_proyeccion;
use PractiCampoUD\practicas_integradas;
use PractiCampoUD\proyeccion;
use PractiCampoUD\riesgos_amenazas_practica;
use PractiCampoUD\solicitud;
use PractiCampoUD\transporte_menor;
use PractiCampoUD\transporte_proyeccion;
use PractiCampoUD\cambios_proyeccion;
use PractiCampoUD\User;
use PractiCampoUD\Mail\CodigoMail;
use Carbon\Carbon;
use DateTime;
use DB;

/**
 * Proyecciones preliminares
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
class ProyeccionController extends Controller
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
     * Listado de proyecciones preliminares
     *
     * @param  string  $filter
     * @return \Illuminate\Http\Response
     */
    public function filterProyeccion($filter)
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
                        
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
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
                        
                        return view('proyecciones.index',['proyecciones'=>$proyeccion,
                                                            'filter'=>$filter,  
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    break;
                    case 'inact':
                        
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
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
                        
                        return view('proyecciones.index',['proyecciones'=>$proyeccion,
                                                            'filter'=>$filter,  
                                                            'usuario'=>$user_DB,
                                                            'control_sistema'=>$control_sistema]);
                    break;
                    case 'not_send_docente':
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
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

                        return view('proyecciones.index',['proyecciones'=>$proyeccion,
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
                        $proyeccion=DB::table('p2_aprob-cons')->paginate(10000);
						//->where('aprobacion_consejo_facultad','=',3)
                        //->where('p_prel.id_estado','=',1)
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
                            $proyecciones=DB::table('p2_no-elect')
                            ->where('id_espacio_academico','=',$esp->id)->get();
							//->where('p_prel.id_estado','=',1)
                            //->where('p_prel.id_espacio_academico','<>',999)
                            
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
                        $proyeccion=DB::table('p2_elect')->paginate(10000);
						//->where('confirm_creador','=',1)
                        //->where('confirm_coord','=',1)
                        //->where('confirm_electiva_coord','=',1)
                        //->where('e_aca.electiva','=',1)
                        //->where('aprobacion_coordinador','=',7)
                        //->where('p_prel.id_estado','=',1)
                    break;

                    case 'pend':
                        $proyeccion=DB::table('p2_pend')->paginate(10000);
						//->where('p_prel.aprobacion_asistD','=',7)
						//->where('p_prel.aprobacion_coordinador','=',7)
                        //->where('p_prel.aprobacion_decano','=',5)
                        //->where('p_prel.confirm_asistD','=',1)
						//->where('p_prel.confirm_coord','=',1)
                        //->where('p_prel.id_estado','=',1)
                    break;

                    case 'aprob':
						$proyeccion=DB::table('p2_aprob')->paginate(10000);
						//->where('p_prel.aprobacion_asistD','=',7)
						//->where('p_prel.aprobacion_decano','=',7)
						//->where('p_prel.confirm_asistD','=',1)
						//->where('p_prel.id_estado','=',1)
                    break;
                    
                    case 'all':
                        $proyeccion=DB::table('p2_all')->paginate(10000);
						//->where('p_prel.aprobacion_coordinador','=',7)
                        //->where('p_prel.aprobacion_asistD','=',7)
                        //->where('p_prel.confirm_asistD','=',1)
                        //->where('p_prel.id_estado','=',1)              
                    break;

                    default;
                }

            break;

            case 3:
                switch($filter)
                {

                    case 'no-aprob-cons':
                        $proyeccion=DB::table('p3_no-aprob-cons')->paginate(30);
						//->where('p_prel.aprobacion_coordinador','=',7)
                        //->where('p_prel.confirm_coord','=',1)
                        //->where('p_prel.confirm_asistD','=',1)
                        //->where('p_prel.aprobacion_decano','=',7)
                        //->where('p_prel.aprobacion_asistD','=',7)
                        //->where('p_prel.aprobacion_consejo_facultad','=',5)
                        //->where('p_prel.id_estado','=',1)
                    break;

                    case 'send':
                        $proyeccion=DB::table('p3_send')->paginate(10000);
						//->where('p_prel.aprobacion_coordinador','=',7)
                        //->where('p_prel.confirm_asistD','=',1)
                        //->where('p_prel.id_estado','=',1)
                    break;

                    case 'not_send':
                        $proyeccion=DB::table('p3_not_send')->paginate(10000);
						//->where('p_prel.aprobacion_coordinador','=',7)
                        //->where('p_prel.aprobacion_asistD','=',7)
                        //->where('p_prel.confirm_coord','=',1)
                        //->where('p_prel.confirm_asistD','=',0)
                        //->where('p_prel.id_estado','=',1)
                    break;

                    case 'sin_pres':
                        $proyeccion=DB::table('p3_sin_pres')->paginate(10000);
						//->where('p_prel.aprobacion_coordinador','=',7)
                        //->where('p_prel.aprobacion_asistD','=',5)
                        //->where('p_prel.confirm_coord','=',1)
                        //->where('p_prel.confirm_asistD','=',0)
                        //->where('p_prel.id_estado','=',1)
                        //->where(function($query){
                        //    $query->where('valor_estimado_transporte_rp','=',0)
                        //          ->orWhere('valor_estimado_transporte_rp','=',null)
                        //          ->orWhere('valor_estimado_transporte_ra','=',0)
                        //          ->orWhere('valor_estimado_transporte_ra','=',null);
						//})
                    break;
                    
                    case 'all':
                        $proyeccion=DB::table('p3_all')->paginate(10000);
						//->where('p_prel.aprobacion_coordinador','=',7)
                        //->where('p_prel.confirm_coord','=',1)
                        //->where('p_prel.id_estado','=',1)
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
                        $proyeccion=DB::table('p4_send')
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('id_programa_academico','=',$id_prog_coord);
                        })						
                        ->paginate(10000);
						//->where('aprobacion_coordinador','=',7)
                        //->where('confirm_creador','=',1)
                        //->where('confirm_coord','=',1)
                        //->where('p_prel.id_estado','=',1)
                    break;

                    case 'not_send':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $idProgAca_asociado = Auth::user()->id_programa_academico_coord;
                        $espacios=DB::table('espacio_academico as esp_aca')
                        ->where('id_programa_academico','=',$idProgAca_asociado)->get();
                        $proyeccion=DB::table('p4_not_send')
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);
						//->where('aprobacion_coordinador','=',7)
                        //->where('confirm_creador','=',1)
                        //->where('confirm_coord','=',0)
                        //->where('p_prel.id_estado','=',1)

                    break;

                    case 'pend':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('p4_pend')
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);
						//->where('p_prel.aprobacion_coordinador','=',5)
                        //->where('confirm_creador','=',1)
                        //->where('confirm_docente','=',1)
                        //->where('confirm_coord','=',0)
                        //->where('p_prel.id_estado','=',1)
                    break;
                    
                    case 'all':
                        $idProgAca_asociado = Auth::user()->id_programa_academico_coord;
                        // $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $idProgAca_asociado;
                        $espacios=DB::table('espacio_academico as esp_aca')
                        ->where('id_programa_academico','=',$idProgAca_asociado)->get();
                        $proyeccion=DB::table('p4_all')
                        ->where(function($query) use ($idUser, $id_prog_coord){
                            $query->where('id_docente_responsable','=',$idUser)
                            ->orWhere('id_programa_academico','=',$id_prog_coord);
                        })
                        ->paginate(10000);
						//->where('confirm_creador','=',1)
                        //->where('p_prel.id_estado','=',1)
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
                        $proyeccion=DB::table('p5_send')
						->where('id_docente_responsable','=',$idUser)
                        ->paginate(10000);
						//->where('confirm_creador','=',1)
                        //->where('confirm_docente','=',1)
                        //->where('p_prel.id_estado','=',1)
                    break;

                    case 'not_send':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('p5_not_send')
						->where('id_docente_responsable','=',$idUser)
                        ->paginate(10000);
						//->where('confirm_creador','=',1)
                        //->where('confirm_docente','=',0)
                        //->where('confirm_coord','=',0)
                        //->where('p_prel.id_estado','=',1)
                    break;

                    case 'proy_recha':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('p5_proy_recha')
						->where('id_docente_responsable','=',$idUser)
                        ->paginate(10000);
						//->where('p_prel.id_estado','=',1)
                        //->where('aprobacion_coordinador','=',4)
                        //->orWhere('aprobacion_consejo_facultad','=',4)
                    break;

                    case 'all':
                        $usuario=DB::table('users')->where('id','=',$idUser)->first();
                        $id_prog_coord = $usuario->id_programa_academico_coord;
                        $proyeccion=DB::table('p5_all')
						->where('id_docente_responsable','=',$idUser)
                        ->paginate(10000);
						//->where('p_prel.id_estado','=',1)
                        
                    break;

                    case 'proy_legal':
                        $year = $mytime->year;
                        $proyeccion=DB::table('proyeccion_preliminar as p_prel')
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
                        ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
                        ->join('solicitud_practica as sol_prac','p_prel.id','=','sol_prac.id_proyeccion_preliminar')
                        ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                        ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                        ->where('sol_prac.id_estado_solicitud_practica','=',6)
                        ->where('p_prel.id_estado','=',6)
						->where('id_docente_responsable','=',$idUser)
                        ->paginate(10000);
                        
                    break;

                    default;
                }
            break;
        }
        
        return view('proyecciones.index',['proyecciones'=>$proyeccion, 
                                            'filter'=>$filter, 
                                            'usuario'=>$user_DB, 
                                            'control_sistema'=>$control_sistema]);
    }

    /**
     * Muestra el formulario para registro de nueva 
     * proyección preliminar
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
        $proyeccion_preliminar=DB::table('proyeccion_preliminar')->get();
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
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();
                        

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

        return view('proyecciones.create', [
                                            "proyeccion_preliminar"=>$proyeccion_preliminar,
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

        ]);
    }
	/**
     * Método reutilizable para guardar x cantidad de campos consecutivos (x_1,x_2,x_3,x_4,...)
     *
     * @param  \Illuminate\Http\Request  $request
	 * @paran \PractiCampoUD\proyeccion $clase
	 * @param Int $cantidad
	 * @param String $campo
	 * @param Int $cont
     * @return \PractiCampoUD\proyeccion $clase
     */
	public function for_cantidades($request, $clase, $cantidad, $campo, $cont){
		for ($i = $cont; $i <= $cantidad; $i++) {
				$campo_clase = $campo . $i;
				$clase->$campo_clase = $request->get($campo_clase);
			}
		//return $clase;
	}
    /**
     * Registro de nueva proyección preliminar
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
        $vlr_estud_max=$control_sistema->vlr_estud_max;
        $vlr_estud_min=$control_sistema->vlr_estud_min;
        $vlr_docen_max=$control_sistema->vlr_docen_max;
        $vlr_docen_min=$control_sistema->vlr_docen_min;

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

        /**Tabla proyeccion_preliminar */
            $proyeccion_preliminar = new proyeccion;
            $proyeccion_preliminar->id_estado = 1;
            $proyeccion_preliminar->practicas_integradas = intval($request->get('integrada'));
            $proyeccion_preliminar->id_programa_academico=$id_prog_aca;
            $proyeccion_preliminar->id_espacio_academico=$esp_aca->id;
            $proyeccion_preliminar->id_periodo_academico=$request->get('id_periodo_academico');
            $proyeccion_preliminar->anio_periodo=$request->get('anio_periodo');
            $proyeccion_preliminar->id_semestre_asignatura=$request->get('id_semestre_asignatura');
            $proyeccion_preliminar->num_estudiantes_aprox=$request->get('num_estudiantes_aprox');
            $proyeccion_preliminar->cantidad_grupos=$request->get('cant_grupos');

			$campo='grupo_'; $cont=1;
			$this->for_cantidades($request, $proyeccion_preliminar, $proyeccion_preliminar->cantidad_grupos, $campo, $cont);
			/*for ($i = 1; $i <= $proyeccion_preliminar->cantidad_grupos; $i++) {
				$grupo = 'grupo_' . $i;
				$proyeccion_preliminar->$grupo = $request->get($grupo);
			}*/
			//dd($proyeccion_preliminar->grupo_1."---".$proyeccion_preliminar->grupo_2."---".$proyeccion_preliminar->grupo_3."---".$proyeccion_preliminar->grupo_4);

            $proyeccion_preliminar->destino_rp=$request->get('destino_rp');
            $proyeccion_preliminar->destino_ra=$request->get('destino_ra');
            $proyeccion_preliminar->cantidad_url_rp=$request->get('cant_url_rp');
            $proyeccion_preliminar->cantidad_url_ra=$request->get('cant_url_ra');

			$proyeccion_preliminar->ruta_principal=$request->get('ruta_principal');
			if($proyeccion_preliminar->cantidad_url_rp >= 2){
				$campo='ruta_principal_'; $cont=2;
				$this->for_cantidades($request, $proyeccion_preliminar, $proyeccion_preliminar->cantidad_url_rp, $campo, $cont);

			}
			
			$proyeccion_preliminar->ruta_alterna=$request->get('ruta_alterna');
			if($proyeccion_preliminar->cantidad_url_ra >= 2){
				$campo='ruta_alterna_'; $cont=2;
				$this->for_cantidades($request, $proyeccion_preliminar, $proyeccion_preliminar->cantidad_url_ra, $campo, $cont);
			}			
            
            $proyeccion_preliminar->det_recorrido_interno_rp=$request->get('det_recorrido_interno_rp');
            $proyeccion_preliminar->det_recorrido_interno_ra=$request->get('det_recorrido_interno_ra');
            $proyeccion_preliminar->lugar_salida_rp=$request->get('lugar_salida_rp');
            $proyeccion_preliminar->lugar_salida_ra=$request->get('lugar_salida_ra');
            $proyeccion_preliminar->lugar_regreso_rp=$request->get('lugar_regreso_rp');
            $proyeccion_preliminar->lugar_regreso_ra=$request->get('lugar_regreso_ra');
            $proyeccion_preliminar->fecha_salida_aprox_rp=$request->get('fecha_salida_aprox_rp');
            $proyeccion_preliminar->fecha_salida_aprox_ra=$request->get('fecha_salida_aprox_ra');
            $proyeccion_preliminar->fecha_regreso_aprox_rp=$request->get('fecha_regreso_aprox_rp');
            $proyeccion_preliminar->fecha_regreso_aprox_ra=$request->get('fecha_regreso_aprox_ra');
            
            $fecha_salida_rp = new DateTime($proyeccion_preliminar->fecha_salida_aprox_rp);
            $fecha_regreso_rp = new DateTime($proyeccion_preliminar->fecha_regreso_aprox_rp);
            $num_dias_rp = $fecha_salida_rp->diff($fecha_regreso_rp);
            $proyeccion_preliminar->duracion_num_dias_rp=$num_dias_rp->days+1;
            $fecha_salida_ra = new DateTime($proyeccion_preliminar->fecha_salida_aprox_ra);
            $fecha_regreso_ra = new DateTime($proyeccion_preliminar->fecha_regreso_aprox_ra);
            $num_dias_ra = $fecha_salida_ra->diff($fecha_regreso_ra);
            $proyeccion_preliminar->duracion_num_dias_ra=$num_dias_ra->days+1;
            $proyeccion_preliminar->id_docente_responsable=Auth::user()->id;
            $proyeccion_preliminar->aprobacion_coordinador= 5;

            $proyeccion_preliminar->aprobacion_asistD= 5;

            $proyeccion_preliminar->aprobacion_decano= 5;
            $proyeccion_preliminar->aprobacion_consejo_facultad= 5;

            //if($idRole == 5 || $idRole == 1)
			if(Auth::user()->docente() || Auth::user()->admin())
            {
                $proyeccion_preliminar->confirm_creador= 1;
                $proyeccion_preliminar->id_creador_confirm = Auth::user()->id;
                $proyeccion_preliminar->confirm_docente= 0;
                $proyeccion_preliminar->confirm_coord= 0;
                $proyeccion_preliminar->confirm_asistD= 0;
            }
            else
            {
                $proyeccion_preliminar->confirm_creador= 0;
                $proyeccion_preliminar->id_creador_confirm = Auth::user()->id;
                $proyeccion_preliminar->confirm_coord= 0;
                $proyeccion_preliminar->confirm_asistD= 0;
                $proyeccion_preliminar->confirm_electiva_coord= 0;

                //if($idRole == 4)
				if(Auth::user()->coordinador())
                {
                    $proyeccion_preliminar->confirm_creador= 1;
                    $proyeccion_preliminar->id_creador_confirm = Auth::user()->id;
                    $proyeccion_preliminar->confirm_docente= 1;
                    $proyeccion_preliminar->id_docente_confirm = Auth::user()->id;
                }
            }
            $proyeccion_preliminar->fecha_diligenciamiento=$mytime->toDateTimeString();

            //$proyeccion_preliminar->save();
            $id = $proyeccion_preliminar->id;
        /**Tabla proyeccion_preliminar */

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

            if($proyeccion_preliminar->practicas_integradas == 0)
            {
                $cant_espa_aca = 0;
            }
            else if($proyeccion_preliminar->practicas_integradas == 1)
            {
                $practicas_integradas->cant_espa_aca=$cant_espa_aca;
				$campo='id_espa_aca_'; $cont=1;
				$this->for_cantidades($request, $practicas_integradas, $practicas_integradas->cant_espa_aca, $campo, $cont);
				
				$campo='id_docen_espa_aca_'; $cont=1;
				$this->for_cantidades($request, $practicas_integradas, $practicas_integradas->cant_espa_aca, $campo, $cont);
            }

			//dd($proyeccion_preliminar."\n\n".$practicas_integradas);
            /*dd("ID ESPACIOS:    ".$practicas_integradas->id_espa_aca_1." - ".$practicas_integradas->id_espa_aca_2." - ".$practicas_integradas->id_espa_aca_3." - ".$practicas_integradas->id_espa_aca_4." - ".
			$practicas_integradas->id_espa_aca_5." - ".$practicas_integradas->id_espa_aca_6." - ".$practicas_integradas->id_espa_aca_7." - ".
			"\nID DOCENTES:    ".$practicas_integradas->id_docen_espa_aca_1." - ".$practicas_integradas->id_docen_espa_aca_2." - ".$practicas_integradas->id_docen_espa_aca_3." - ".
			$practicas_integradas->id_docen_espa_aca_4." - ".$practicas_integradas->id_docen_espa_aca_5." - ".$practicas_integradas->id_docen_espa_aca_6." - ".$practicas_integradas->id_docen_espa_aca_7);*/
            //$practicas_integradas->save();
        /**Tabla practicas_integradas */
            
        /**Tabla docentes_practica */
            $docentes_practica = new docentes_practica;
            $docentes_practica->id = $id;
            $docentes_practica->soporte_personal_apoyo = $request->file('sop_pers_apoyo') != null ? base64_encode(file_get_contents($request->file('sop_pers_apoyo')->path())) : null;
            $docentes_practica->total_docentes_apoyo=$request->get('num_acompaniantes');
            $docentes_practica->num_docentes_apoyo=$request->get('num_apoyo');
            $docentes_practica->total_docentes_apoyo=$request->get('total_docentes_apoyo');

			//$campo='doc_apoyo_1'; $cont=1;
			//$this->for_cantidades($request, $docentes_practica, $docentes_practica->num_docentes_apoyo, $campo, $cont);
			for ($i = 1; $i <= $docentes_practica->num_docentes_apoyo; $i++) {
				$doc_apoyo = 'doc_apoyo_' . $i;
				$num_doc_docente_apoyo= 'num_doc_docente_apoyo_' . $i;
				$docentes_practica->$num_doc_docente_apoyo = $request->get($doc_apoyo);
				
				$apoyo = 'apoyo_' . $i;
				$docente_apoyo= 'docente_apoyo_' . $i;
				$docentes_practica->$docente_apoyo = $request->get($apoyo);
			}
            //dd($docentes_practica);

            //$docentes_practica->save();
        /**Tabla docentes_practica */

        /**Tabla transporte_proyeccion */
            $transporte_proyeccion = new transporte_proyeccion;
            $transporte_proyeccion->id = $id;
            $transporte_proyeccion->cant_transporte_rp=$request->get('cant_transporte_rp');
            $transporte_proyeccion->cant_transporte_ra=$request->get('cant_transporte_ra');
            
            $transporte_proyeccion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
            $transporte_proyeccion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??null;
            $transporte_proyeccion->id_tipo_transporte_rp_3 =$tipo_transporte_rp[2]??null;
            $transporte_proyeccion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
            $transporte_proyeccion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??null;
            $transporte_proyeccion->id_tipo_transporte_ra_3 =$tipo_transporte_ra[2]??null;
            $transporte_proyeccion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
            $transporte_proyeccion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??null;
            $transporte_proyeccion->det_tipo_transporte_rp_3=$det_tipo_transporte_rp[2]??null;
            $transporte_proyeccion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
            $transporte_proyeccion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??null;
            $transporte_proyeccion->det_tipo_transporte_ra_3=$det_tipo_transporte_ra[2]??null;

            $transporte_proyeccion->docen_respo_trasnporte_rp=$docen_respo_trasnporte_rp;
            $transporte_proyeccion->docen_respo_trasnporte_ra=$docen_respo_trasnporte_ra;

            $transporte_proyeccion->capac_transporte_rp_1=$capacid_transporte_rp[0];
            $transporte_proyeccion->capac_transporte_rp_2=$capacid_transporte_rp[1]??null;
            $transporte_proyeccion->capac_transporte_rp_3=$capacid_transporte_rp[2]??null;
            $transporte_proyeccion->capac_transporte_ra_1=$capacid_transporte_ra[0];
            $transporte_proyeccion->capac_transporte_ra_2=$capacid_transporte_ra[1]??null;
            $transporte_proyeccion->capac_transporte_ra_3=$capacid_transporte_ra[2]??null;

            $transporte_proyeccion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
            $transporte_proyeccion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==null?null:intval($request->get('exclusiv_tiempo_rp_2'));
            $transporte_proyeccion->exclusiv_tiempo_rp_3=$request->get('exclusiv_tiempo_rp_3')==null?null:intval($request->get('exclusiv_tiempo_rp_3'));
            $transporte_proyeccion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
            $transporte_proyeccion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==null?null:intval($request->get('exclusiv_tiempo_ra_2'));
            $transporte_proyeccion->exclusiv_tiempo_ra_3=$request->get('exclusiv_tiempo_ra_3')==null?null:intval($request->get('exclusiv_tiempo_ra_3'));

            //$transporte_proyeccion->save();
        /**Tabla transporte_proyeccion */

        /**Tabla transporte_menor */
            $transporte_menor = new transporte_menor;
            $transporte_menor->id=$id;
            $transporte_menor->cant_trans_menor_rp=$request->get('cant_trans_menor_rp');
            $transporte_menor->cant_trans_menor_ra=$request->get('cant_trans_menor_ra');

			for ($i = 1; $i <= 4; $i++) {
				$vlr_trans_menor_rp = 'vlr_trans_menor_rp_' . $i;
				$transporte_menor->$vlr_trans_menor_rp = 0;
			}
			if($transporte_menor->cant_trans_menor_rp > 0){
				$transporte_menor->docente_resp_t_menor_rp=$request->get('docente_resp_t_menor_rp');
				for ($i = 1; $i <= $transporte_menor->cant_trans_menor_rp; $i++) {
					$trans_menor_rp = 'trans_menor_rp_' . $i;
					$transporte_menor->$trans_menor_rp = $request->get($trans_menor_rp);
					
					$vlr_trans_menor_rp = 'vlr_trans_menor_rp_' . $i;
					$transporte_menor->$vlr_trans_menor_rp = intval(str_replace(".","",$request->get($vlr_trans_menor_rp)));
				}
			}else{
				$transporte_menor->docente_resp_t_menor_rp=null;
			}
			
			for ($i = 1; $i <= 4; $i++) {
				$vlr_trans_menor_ra = 'vlr_trans_menor_ra_' . $i;
				$transporte_menor->$vlr_trans_menor_ra = 0;
			}
			if($transporte_menor->cant_trans_menor_ra > 0){
				$transporte_menor->docente_resp_t_menor_ra=$request->get('docente_resp_t_menor_ra');
				for ($i = 1; $i <= $transporte_menor->cant_trans_menor_ra; $i++) {
					$trans_menor_ra = 'trans_menor_ra_' . $i;
					$transporte_menor->$trans_menor_ra = $request->get($trans_menor_ra);
					
					$vlr_trans_menor_ra = 'vlr_trans_menor_ra_' . $i;
					$transporte_menor->$vlr_trans_menor_ra = intval(str_replace(".","",$request->get($vlr_trans_menor_ra)));
				}
			}else{
				$transporte_menor->docente_resp_t_menor_ra=null;
			}
            
            
            //$transporte_menor->save();
			

            $vlr_trans_menor_rp_1=$transporte_menor->vlr_trans_menor_rp_1;
            $vlr_trans_menor_rp_2=$transporte_menor->vlr_trans_menor_rp_2;
            $vlr_trans_menor_rp_3=$transporte_menor->vlr_trans_menor_rp_3;
            $vlr_trans_menor_rp_4=$transporte_menor->vlr_trans_menor_rp_4;
            $vlr_trans_menor_ra_1=$transporte_menor->vlr_trans_menor_ra_1;
            $vlr_trans_menor_ra_2=$transporte_menor->vlr_trans_menor_ra_2;
            $vlr_trans_menor_ra_3=$transporte_menor->vlr_trans_menor_ra_3;
            $vlr_trans_menor_ra_4=$transporte_menor->vlr_trans_menor_ra_4;

        /**Tabla transporte_menor */

        /**Tabla materiales_herramientas_proyeccion */
            $mater_herra_proyeccion = new materiales_herramientas_proyeccion;
            $mater_herra_proyeccion->id = $id;
            $mater_herra_proyeccion->det_materiales_rp=$request->get('det_materiales_rp');
            $mater_herra_proyeccion->det_materiales_ra=$request->get('det_materiales_ra');
            $mater_herra_proyeccion->det_guias_baquianos_rp=$request->get('det_guias_baquia_rp');
            $mater_herra_proyeccion->det_guias_baquianos_ra=$request->get('det_guias_baquia_ra');
            $mater_herra_proyeccion->det_otros_boletas_rp=$request->get('det_otros_bolet_rp');
            $mater_herra_proyeccion->det_otros_boletas_ra=$request->get('det_otros_bolet_ra');

            //$mater_herra_proyeccion->save();
        /**Tabla materiales_herramientas_proyeccion */

        /**Tabla riesgos_amenazas_proyeccion */
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
			
            //$riesg_amen_practica->save();
        /**Tabla riesgos_amenazas_proyeccion */

        /**Tabla costos_proyeccion */
            $costos_proyeccion = new costos_proyeccion;
            $costos_proyeccion->id = $id;
            $vlr_materiales_rp=intval(str_replace(".","",$request->get('vlr_materiales_rp')));
            $vlr_materiales_ra=intval(str_replace(".","",$request->get('vlr_materiales_ra')));
            $vlr_guias_baquianos_rp=intval(str_replace(".","",$request->get('vlr_guias_baquia_rp')));
            $vlr_guias_baquianos_ra=intval(str_replace(".","",$request->get('vlr_guias_baquia_ra')));
            $vlr_otros_boletas_rp=intval(str_replace(".","",$request->get('vlr_otros_bolet_rp')));
            $vlr_otros_boletas_ra=intval(str_replace(".","",$request->get('vlr_otros_bolet_ra')));

            $total_otros_rp = $vlr_materiales_rp + $vlr_guias_baquianos_rp + $vlr_otros_boletas_rp;
            $total_otros_ra = $vlr_materiales_ra + $vlr_guias_baquianos_ra + $vlr_otros_boletas_ra;

            $costos_proyeccion->vlr_materiales_rp=$vlr_materiales_rp;
            $costos_proyeccion->vlr_materiales_ra=$vlr_materiales_ra;
            $costos_proyeccion->vlr_guias_baquianos_rp=$vlr_guias_baquianos_rp;
            $costos_proyeccion->vlr_guias_baquianos_ra=$vlr_guias_baquianos_ra;
            $costos_proyeccion->vlr_otros_boletas_rp=$vlr_otros_boletas_rp;
            $costos_proyeccion->vlr_otros_boletas_ra=$vlr_otros_boletas_ra;

            $num_dias_rp = $proyeccion_preliminar->duracion_num_dias_rp;
            $num_dias_ra = $proyeccion_preliminar->duracion_num_dias_ra;
            $num_estud = $proyeccion_preliminar->num_estudiantes_aprox;
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

            $costos_proyeccion->viaticos_estudiantes_rp=$viaticos_estudiantes_rp;
            $costos_proyeccion->viaticos_estudiantes_ra=$viaticos_estudiantes_ra;

            $costos_proyeccion->viaticos_docente_rp=$viaticos_docente_rp;
            $costos_proyeccion->viaticos_docente_ra=$viaticos_docente_ra;

            $costo_total_transporte_menor_rp = $vlr_trans_menor_rp_1 + $vlr_trans_menor_rp_2 + $vlr_trans_menor_rp_3 + $vlr_trans_menor_rp_4;
            $costo_total_transporte_menor_ra = $vlr_trans_menor_ra_1 + $vlr_trans_menor_ra_2 + $vlr_trans_menor_ra_3 + $vlr_trans_menor_ra_4;

            $costos_proyeccion->costo_total_transporte_menor_rp =$costo_total_transporte_menor_rp;
            $costos_proyeccion->costo_total_transporte_menor_ra =$costo_total_transporte_menor_ra;
            
            $costos_proyeccion->total_presupuesto_rp=$viaticos_estudiantes_rp + $viaticos_docente_rp + $total_otros_rp + $costo_total_transporte_menor_rp;
            $costos_proyeccion->total_presupuesto_ra=$viaticos_estudiantes_ra + $viaticos_docente_ra + $total_otros_ra + $costo_total_transporte_menor_ra;
			
            //$costos_proyeccion->save();
        /**Tabla costos_proyeccion */

		$proyeccion_preliminar->save();
		$id=$proyeccion_preliminar->id;
		
		$practicas_integradas->id=$id;
		$practicas_integradas->save();
		
		$docentes_practica->id=$id;
		$docentes_practica->save();
		
		$transporte_proyeccion->id=$id;
		$transporte_proyeccion->save();	
		
		$transporte_menor->id=$id;
		$transporte_menor->save();
		
		$mater_herra_proyeccion->id=$id;
		$mater_herra_proyeccion->save();
		
		$riesg_amen_practica->id=$id;
		$riesg_amen_practica->save();
		
		$costos_proyeccion->id=$id;
		$costos_proyeccion->save();
		
        if(Auth::user()->docente() || Auth::user()->coordinador())
        {
            $this->creacion_proy($id);
        }

        return redirect('proyecciones/filtrar/all');
    }

    /**
     * Muestra formulario para editar proyección preliminar
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
                $proyeccion_preliminar = proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $docentes_practica= docentes_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
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
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();
                        
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
        
                return view('proyecciones.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
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
                                                "mater_herra_proyeccion"=>$mater_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
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
                $proyeccion_preliminar = proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
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

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();

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
        
                return view('proyecciones.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
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
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "mater_herra_proyeccion"=>$mater_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,    
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
        
                ]);
            break;

            case 3:
                $proyeccion_preliminar = proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
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
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();

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
        
                return view('proyecciones.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
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
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "mater_herra_proyeccion"=>$mater_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
        
                ]);
            break;

            case 4:
                $proyeccion_preliminar = proyeccion::find($id);
                // $cambios_proyeccion = cambios_proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
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
                $sedes=DB::table('sedes_universidad')->get();
                $periodo_academico=DB::table('periodo_academico')->get();
                $semestre_asignatura=DB::table('semestre_asignatura')->get();
                $tipo_transporte=DB::table('tipo_transporte')->get();
                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();
        
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

                return view('proyecciones.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                // "cambios_proyeccion"=>$cambios_proyeccion,
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
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "mater_herra_proyeccion"=>$mater_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario_log,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
        
                ]);
            break;

            case 5:
                $proyeccion_preliminar = proyeccion::find($id);
                // $cambios_proyeccion = cambios_proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica= docentes_practica::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
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
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();

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
        
                return view('proyecciones.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                // "cambios_proyeccion"=>$cambios_proyeccion,
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
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "mater_herra_proyeccion"=>$mater_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo

        
                ]);
            break;
        }
    }

    
    /**
     * habilitar cambios proyecciones
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
                $proyeccion_preliminar = proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $docentes_practica= docentes_practica::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
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
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();
                        
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
        
                return view('proyecciones.edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
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
                                                "mater_herra_proyeccion"=>$mater_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
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
                $proyeccion_preliminar = proyeccion::find($id);
                // $cambios_proyeccion = cambios_proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica = docentes_practica::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
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
                ->where('users.id_espacio_academico_1','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_2','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_3','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_4','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_5','=',$proyeccion_preliminar->id_espacio_academico)
                ->orWhere('users.id_espacio_academico_6','=',$proyeccion_preliminar->id_espacio_academico)->get();

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();

                $estado_doc_respon =$usuario->id_estado;
        
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

                $docentes = DB::table('docentes_practica')->where('id',$id)->first();
                $sop_pers_apoyo = $docentes->soporte_personal_apoyo;
                $img_sop_pers_apoyo="data:application/pdf;base64,$sop_pers_apoyo";
        
                return view('proyecciones.formularios.cambiar_edit',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                // "cambios_proyeccion"=>$cambios_proyeccion,
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
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "mater_herra_proyeccion"=>$mater_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,    
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
                                                'img_sop_pers_apoyo'=>$img_sop_pers_apoyo,
        
                ]);
            break;
        }
    }

    /**
     * actualizar cambios habilitados proyecciones
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function cambios_proy(Request $request,$id)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $idRole = Auth::user()->id_role;
        $idUser = Auth::user()->id;

        switch($idRole)
        {
            case 1:
                $proyeccion_preliminar = proyeccion::find($id);
                // $cambios_proyeccion = cambios_proyeccion::find($id);

                // $cambios_proyeccion->cambiar_programa_academico=isset($_POST['cambiar_programa_academico']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_espacio_academico=isset($_POST['cambiar_espacio_academico']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_sem_anio_per=isset($_POST['cambiar_sem_anio_per']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_integrada=isset($_POST['cambiar_integrada']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_estudiantes=isset($_POST['cambiar_estudiantes']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_grupos=isset($_POST['cambiar_grupos']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_personal_apoyo=isset($_POST['cambiar_personal_apoyo']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_destino_rp=isset($_POST['cambiar_destino_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_url_rp=isset($_POST['cambiar_url_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_detalle_rp=isset($_POST['cambiar_detalle_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_sedes_rp=isset($_POST['cambiar_sedes_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_fechas_rp=isset($_POST['cambiar_fechas_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_transporte_rp=isset($_POST['cambiar_transporte_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_transporte_menor_rp=isset($_POST['cambiar_transporte_menor_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_otros_rp=isset($_POST['cambiar_otros_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_actividades_riesgo_rp=isset($_POST['cambiar_actividades_riesgo_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_destino_ra=isset($_POST['cambiar_destino_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_url_ra=isset($_POST['cambiar_url_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_detalle_ra=isset($_POST['cambiar_detalle_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_sedes_ra=isset($_POST['cambiar_sedes_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_fechas_ra=isset($_POST['cambiar_fechas_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_transporte_ra=isset($_POST['cambiar_transporte_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_transporte_menor_ra=isset($_POST['cambiar_transporte_menor_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_otros_ra=isset($_POST['cambiar_otros_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_actividades_riesgo_ra=isset($_POST['cambiar_actividades_riesgo_ra']) ? 1 : 0;
                // $cambios_proyeccion->id_user_hab=$idUser;

                $proyeccion_preliminar->id_estado = 1;
                $proyeccion_preliminar->confirm_creador = 1;
                $proyeccion_preliminar->confirm_docente = 0;
                $proyeccion_preliminar->confirm_coord = 0;
                $proyeccion_preliminar->confirm_asistD = 0;
                $proyeccion_preliminar->aprobacion_coordinador = 5;
                $proyeccion_preliminar->aprobacion_asistD = 5;
                $proyeccion_preliminar->aprobacion_decano = 5;

                // $cambios_proyeccion->update();
                $proyeccion_preliminar->update();
                break;

            case 2:
                $proyeccion_preliminar = proyeccion::find($id);
                // $cambios_proyeccion = cambios_proyeccion::find($id);

                // $cambios_proyeccion->cambiar_programa_academico=isset($_POST['cambiar_programa_academico']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_espacio_academico=isset($_POST['cambiar_espacio_academico']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_sem_anio_per=isset($_POST['cambiar_sem_anio_per']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_integrada=isset($_POST['cambiar_integrada']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_estudiantes=isset($_POST['cambiar_estudiantes']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_grupos=isset($_POST['cambiar_grupos']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_personal_apoyo=isset($_POST['cambiar_personal_apoyo']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_destino_rp=isset($_POST['cambiar_destino_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_url_rp=isset($_POST['cambiar_url_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_detalle_rp=isset($_POST['cambiar_detalle_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_sedes_rp=isset($_POST['cambiar_sedes_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_fechas_rp=isset($_POST['cambiar_fechas_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_transporte_rp=isset($_POST['cambiar_transporte_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_transporte_menor_rp=isset($_POST['cambiar_transporte_menor_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_otros_rp=isset($_POST['cambiar_otros_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_actividades_riesgo_rp=isset($_POST['cambiar_actividades_riesgo_rp']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_destino_ra=isset($_POST['cambiar_destino_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_url_ra=isset($_POST['cambiar_url_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_detalle_ra=isset($_POST['cambiar_detalle_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_sedes_ra=isset($_POST['cambiar_sedes_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_fechas_ra=isset($_POST['cambiar_fechas_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_transporte_ra=isset($_POST['cambiar_transporte_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_transporte_menor_ra=isset($_POST['cambiar_transporte_menor_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_otros_ra=isset($_POST['cambiar_otros_ra']) ? 1 : 0;
                // $cambios_proyeccion->cambiar_actividades_riesgo_ra=isset($_POST['cambiar_actividades_riesgo_ra']) ? 1 : 0;
                // $cambios_proyeccion->id_user_hab=$idUser;

                $proyeccion_preliminar->id_estado = 1;
                $proyeccion_preliminar->confirm_creador = 1;
                $proyeccion_preliminar->confirm_docente = 0;
                $proyeccion_preliminar->confirm_coord = 0;
                $proyeccion_preliminar->confirm_asistD = 0;
                $proyeccion_preliminar->aprobacion_coordinador = 5;
                $proyeccion_preliminar->aprobacion_asistD = 5;
                $proyeccion_preliminar->aprobacion_decano = 5;

                // $cambios_proyeccion->update();
                $proyeccion_preliminar->update();
                break;
            
        }

        return redirect('proyecciones/filtrar/all');
    }
    /**
     * Ver proyección preliminar
     *
     * @param  string  $filter
     * @return \Illuminate\Http\Response
     */
    public function ver_proyeccion($id)
    {   
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $idRole = Auth::user()->id_role;

        switch($idRole)
        {
            case 5:
                $proyeccion_preliminar = proyeccion::find($id);
                $practicas_integradas = practicas_integradas::find($id);
                $transporte_proyeccion = transporte_proyeccion::find($id);
                $transporte_menor = transporte_menor::find($id);
                $docentes_practica= docentes_practica::find($id);
                $costos_proyeccion = costos_proyeccion::find($id);
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
                $riesg_amen_practica = riesgos_amenazas_practica::find($id);
                $idUser = $proyeccion_preliminar->id_docente_responsable;
                // $idUser = Auth::user()->id;
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

                $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();
        
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
        
                return view('proyecciones.ver',["proyeccion_preliminar"=>$proyeccion_preliminar,
                                                "practicas_integradas"=>$practicas_integradas,
                                                "programas_academicos"=>$programa_academico,
                                                "espacios_academicos"=>$espacio_academico,
                                                "periodos_academicos"=>$periodo_academico,
                                                "semestres_asignaturas"=>$semestre_asignatura,
                                                "tipos_transportes"=>$tipo_transporte,
                                                "programas_usuario"=>$newArray_prog,
                                                "nombre_usuario"=>$nomb_usuario,
                                                "sedes"=>$sedes,
                                                "estado_doc_respon"=>$estado_doc_respon,
                                                "transporte_proyeccion"=>$transporte_proyeccion,
                                                "transporte_menor"=>$transporte_menor,
                                                "docentes_practica"=>$docentes_practica,
                                                "costos_proyeccion"=>$costos_proyeccion,
                                                "mater_herra_proyeccion"=>$mater_herra_proyeccion,
                                                "riesg_amen_practica"=>$riesg_amen_practica,
                                                "usuario"=>$usuario,
                                                "vlr_viaticos"=>$vlr_viaticos,
                                                'control_sistema'=>$control_sistema,
        
                ]);

            break;

        }
    }

    /**
     * Actualización prouyección preliminar
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $mytime = Carbon::now('America/Bogota');
        $proyeccion_preliminar = proyeccion::where('id', '=', $id)->first();
        $transporte_proyeccion = transporte_proyeccion::where('id','=',$id)->first();
        $practicas_integradas = practicas_integradas::where('id','=',$id)->first();
        $transporte_menor = transporte_menor::where('id','=',$id)->first();
        $costos_proyeccion = costos_proyeccion::where('id','=',$id)->first();
        $docentes_practica = docentes_practica::where('id','=',$id)->first();
        $mater_herra_proyeccion = materiales_herramientas_proyeccion::where('id','=',$id)->first();
        $riesg_amen_practica = riesgos_amenazas_practica::where('id','=',$id)->first();
        $solicitud_practica = new  solicitud;
        // $cambios_proyeccion = new  cambios_proyeccion;
        $doc_req_sol = new  documentos_requeridos_solicitud;
        $id_prog_aca = $request->get('id_programa_academico');

        $prog_aca=DB::table('programa_academico')
        ->where('id',$id_prog_aca)->first();

        if(Auth::user()->id_role == 1 ||  Auth::user()->id_role == 4 || Auth::user()->id_role == 5)
        {
            if(Auth::user()->id == $proyeccion_preliminar->id_docente_responsable || Auth::user()->id_role == 1)
            {
                /**Tabla proyeccion_preliminar */
                    $proyeccion_preliminar->practicas_integradas = intval($request->get('integrada'));
                    $esp_aca = (!empty($request->get('id_espacio_academico')))?
                    $request->get('id_espacio_academico'):$proyeccion_preliminar->id_espacio_academico;

                    $id_prog_aca = ($request->get('id_programa_academico'))?
                    $request->get('id_programa_academico'):$proyeccion_preliminar->id_espacio_academico;

                    $esp_aca = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$id_prog_aca)
                    ->where('id','=',$esp_aca)->first();
                    $proyeccion_preliminar->id_espacio_academico=(!empty($esp_aca)||null)?
                    $esp_aca->id:$proyeccion_preliminar->id_espacio_academico;

                    $proyeccion_preliminar->id_programa_academico = $id_prog_aca;

                    $proyeccion_preliminar->id_semestre_asignatura=$request->get('id_semestre_asignatura');
                    $proyeccion_preliminar->id_periodo_academico=$request->get('id_periodo_academico');
                    $proyeccion_preliminar->anio_periodo=$request->get('anio_periodo');

                    $proyeccion_preliminar->num_estudiantes_aprox=$request->get('num_estudiantes_aprox');
                    $proyeccion_preliminar->cantidad_grupos=$request->get('cant_grupos');
                    
                    switch($proyeccion_preliminar->cantidad_grupos=$request->get('cant_grupos'))
                    {
                        case "1":
                            $proyeccion_preliminar->grupo_1=$request->get('grupo_1');
                            $proyeccion_preliminar->grupo_2=null;
                            $proyeccion_preliminar->grupo_3=null;
                            $proyeccion_preliminar->grupo_4=null;
                            break;
                        case "2":
                            $proyeccion_preliminar->grupo_1=$request->get('grupo_1');
                            $proyeccion_preliminar->grupo_2=$request->get('grupo_2');
                            $proyeccion_preliminar->grupo_3=null;
                            $proyeccion_preliminar->grupo_4=null;
                            break;
                        case "3":
                            $proyeccion_preliminar->grupo_1=$request->get('grupo_1');
                            $proyeccion_preliminar->grupo_2=$request->get('grupo_2');
                            $proyeccion_preliminar->grupo_3=$request->get('grupo_3');
                            $proyeccion_preliminar->grupo_4=null;
                            break;
                        case "4":
                            $proyeccion_preliminar->grupo_1=$request->get('grupo_1');
                            $proyeccion_preliminar->grupo_2=$request->get('grupo_2');
                            $proyeccion_preliminar->grupo_3=$request->get('grupo_3');
                            $proyeccion_preliminar->grupo_4=$request->get('grupo_4');
                            break;
                    }

                    $proyeccion_preliminar->fecha_salida_aprox_rp= $request->get('fecha_salida_aprox_rp');
                    $proyeccion_preliminar->fecha_regreso_aprox_rp= $request->get('fecha_regreso_aprox_rp');
                    $proyeccion_preliminar->fecha_salida_aprox_ra= $request->get('fecha_salida_aprox_ra');
                    $proyeccion_preliminar->fecha_regreso_aprox_ra= $request->get('fecha_regreso_aprox_ra');

                    $fecha_salida_rp = new DateTime($proyeccion_preliminar->fecha_salida_aprox_rp);
                    $fecha_regreso_rp = new DateTime($proyeccion_preliminar->fecha_regreso_aprox_rp);
                    $num_dias_rp = $fecha_salida_rp->diff($fecha_regreso_rp);
                    $proyeccion_preliminar->duracion_num_dias_rp=$num_dias_rp->days+1;

                    $fecha_salida_ra = new DateTime($proyeccion_preliminar->fecha_salida_aprox_ra);
                    $fecha_regreso_ra = new DateTime($proyeccion_preliminar->fecha_regreso_aprox_ra);
                    $num_dias_ra = $fecha_salida_ra->diff($fecha_regreso_ra);
                    $proyeccion_preliminar->duracion_num_dias_ra=$num_dias_ra->days+1;

                    $proyeccion_preliminar->destino_rp=$request->get('destino_rp');
                    $proyeccion_preliminar->destino_ra=$request->get('destino_ra');
                    $proyeccion_preliminar->det_recorrido_interno_rp=$request->get('det_recorrido_interno_rp');
                    $proyeccion_preliminar->det_recorrido_interno_ra=$request->get('det_recorrido_interno_ra');
                    $proyeccion_preliminar->lugar_salida_rp=$request->get('lugar_salida_rp');
                    $proyeccion_preliminar->lugar_regreso_rp=$request->get('lugar_regreso_rp');
                    $proyeccion_preliminar->lugar_salida_ra=$request->get('lugar_salida_ra');
                    $proyeccion_preliminar->lugar_regreso_ra=$request->get('lugar_regreso_ra');
                    
                    $proyeccion_preliminar->cantidad_url_rp=$request->get('cant_url_rp');
                    $proyeccion_preliminar->cantidad_url_ra=$request->get('cant_url_ra');
                   
                    switch($proyeccion_preliminar->cantidad_url_rp=$request->get('cant_url_rp'))
                    {
                        case"1":
                            $proyeccion_preliminar->ruta_principal=$request->get('ruta_principal');
                            $proyeccion_preliminar->ruta_principal_2=null;
                            $proyeccion_preliminar->ruta_principal_3=null;
                            $proyeccion_preliminar->ruta_principal_4=null;
                            $proyeccion_preliminar->ruta_principal_5=null;
                            $proyeccion_preliminar->ruta_principal_6=null;
                            break;
                        case"2":
                            $proyeccion_preliminar->ruta_principal=$request->get('ruta_principal');
                            $proyeccion_preliminar->ruta_principal_2=$request->get('ruta_principal_2');
                            $proyeccion_preliminar->ruta_principal_3=null;
                            $proyeccion_preliminar->ruta_principal_4=null;
                            $proyeccion_preliminar->ruta_principal_5=null;
                            $proyeccion_preliminar->ruta_principal_6=null;
                            break;
                        case"3":
                            $proyeccion_preliminar->ruta_principal=$request->get('ruta_principal');
                            $proyeccion_preliminar->ruta_principal_2=$request->get('ruta_principal_2');
                            $proyeccion_preliminar->ruta_principal_3=$request->get('ruta_principal_3');
                            $proyeccion_preliminar->ruta_principal_4=null;
                            $proyeccion_preliminar->ruta_principal_5=null;
                            $proyeccion_preliminar->ruta_principal_6=null;
                            break;
                        case"4":
                            $proyeccion_preliminar->ruta_principal=$request->get('ruta_principal');
                            $proyeccion_preliminar->ruta_principal_2=$request->get('ruta_principal_2');
                            $proyeccion_preliminar->ruta_principal_3=$request->get('ruta_principal_3');
                            $proyeccion_preliminar->ruta_principal_4=$request->get('ruta_principal_4');
                            $proyeccion_preliminar->ruta_principal_5=null;
                            $proyeccion_preliminar->ruta_principal_6=null;
                            break;
                        case"5":
                            $proyeccion_preliminar->ruta_principal=$request->get('ruta_principal');
                            $proyeccion_preliminar->ruta_principal_2=$request->get('ruta_principal_2');
                            $proyeccion_preliminar->ruta_principal_3=$request->get('ruta_principal_3');
                            $proyeccion_preliminar->ruta_principal_4=$request->get('ruta_principal_4');
                            $proyeccion_preliminar->ruta_principal_5=$request->get('ruta_principal_5');
                            $proyeccion_preliminar->ruta_principal_6=null;
                            break;
                        case"6":
                            $proyeccion_preliminar->ruta_principal=$request->get('ruta_principal');
                            $proyeccion_preliminar->ruta_principal_2=$request->get('ruta_principal_2');
                            $proyeccion_preliminar->ruta_principal_3=$request->get('ruta_principal_3');
                            $proyeccion_preliminar->ruta_principal_4=$request->get('ruta_principal_4');
                            $proyeccion_preliminar->ruta_principal_5=$request->get('ruta_principal_5');
                            $proyeccion_preliminar->ruta_principal_6=$request->get('ruta_principal_6');
                            break;
                    }
                    
                    switch($proyeccion_preliminar->cantidad_url_ra=$request->get('cant_url_ra'))
                    {
                        case "1":
                            $proyeccion_preliminar->ruta_alterna=$request->get('ruta_alterna');
                            $proyeccion_preliminar->ruta_alterna_2=null;
                            $proyeccion_preliminar->ruta_alterna_3=null;
                            $proyeccion_preliminar->ruta_alterna_4=null;
                            $proyeccion_preliminar->ruta_alterna_5=null;
                            $proyeccion_preliminar->ruta_alterna_6=null;
                            break;
                        case "2":
                            $proyeccion_preliminar->ruta_alterna=$request->get('ruta_alterna');
                            $proyeccion_preliminar->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $proyeccion_preliminar->ruta_alterna_3=null;
                            $proyeccion_preliminar->ruta_alterna_4=null;
                            $proyeccion_preliminar->ruta_alterna_5=null;
                            $proyeccion_preliminar->ruta_alterna_6=null;
                            break;
                        case "3":
                            $proyeccion_preliminar->ruta_alterna=$request->get('ruta_alterna');
                            $proyeccion_preliminar->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $proyeccion_preliminar->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $proyeccion_preliminar->ruta_alterna_4=null;
                            $proyeccion_preliminar->ruta_alterna_5=null;
                            $proyeccion_preliminar->ruta_alterna_6=null;
                            break;
                        case "4":
                            $proyeccion_preliminar->ruta_alterna=$request->get('ruta_alterna');
                            $proyeccion_preliminar->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $proyeccion_preliminar->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $proyeccion_preliminar->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $proyeccion_preliminar->ruta_alterna_5=null;
                            $proyeccion_preliminar->ruta_alterna_6=null;
                            break;
                        case "5":
                            $proyeccion_preliminar->ruta_alterna=$request->get('ruta_alterna');
                            $proyeccion_preliminar->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $proyeccion_preliminar->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $proyeccion_preliminar->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $proyeccion_preliminar->ruta_alterna_5=$request->get('ruta_alterna_5');
                            $proyeccion_preliminar->ruta_alterna_6=null;
                            break;
                        case "6":
                            $proyeccion_preliminar->ruta_alterna=$request->get('ruta_alterna');
                            $proyeccion_preliminar->ruta_alterna_2=$request->get('ruta_alterna_2');
                            $proyeccion_preliminar->ruta_alterna_3=$request->get('ruta_alterna_3');
                            $proyeccion_preliminar->ruta_alterna_4=$request->get('ruta_alterna_4');
                            $proyeccion_preliminar->ruta_alterna_5=$request->get('ruta_alterna_5');
                            $proyeccion_preliminar->ruta_alterna_6=$request->get('ruta_alterna_6');
                            break;
                    }

                    $proyeccion_preliminar->aprobacion_coordinador=5;
		    $proyeccion_preliminar->aprobacion_asistD=7;
                    $proyeccion_preliminar->aprobacion_decano=5;
                    $proyeccion_preliminar->confirm_asistD=1;
		    $costos_proyeccion->valor_estimado_transporte_rp=1;
		    $costos_proyeccion->valor_estimado_transporte_ra=1;

                /**Tabla proyeccion_preliminar */

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

                /**Tabla practicas_integradas */

                /**Tabla docentes_practica */
                    $docentes_practica->total_docentes_apoyo=$request->get('num_acompaniantes');
                    $docentes_practica->num_docentes_apoyo=$request->get('num_apoyo');
                    $docentes_practica->total_docentes_apoyo=$request->get('total_docentes_apoyo');
                    $docentes_practica->soporte_personal_apoyo = $request->file('sop_pers_apoyo') != null ? base64_encode(file_get_contents($request->file('sop_pers_apoyo')->path())) : null;

                    switch($docentes_practica->num_docentes_apoyo=$request->get('num_apoyo'))
                    {
                        case "0":
                            $docentes_practica->num_doc_docente_apoyo_1=null;
                            $docentes_practica->num_doc_docente_apoyo_2=null;
                            $docentes_practica->num_doc_docente_apoyo_3=null;
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=null;
                            $docentes_practica->docente_apoyo_2=null;
                            $docentes_practica->docente_apoyo_3=null;
                            $docentes_practica->docente_apoyo_4=null;
                            $docentes_practica->docente_apoyo_5=null;
                            $docentes_practica->docente_apoyo_6=null;
                            $docentes_practica->docente_apoyo_7=null;
                            $docentes_practica->docente_apoyo_8=null;
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "1":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=null;
                            $docentes_practica->num_doc_docente_apoyo_3=null;
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=null;
                            $docentes_practica->docente_apoyo_3=null;
                            $docentes_practica->docente_apoyo_4=null;
                            $docentes_practica->docente_apoyo_5=null;
                            $docentes_practica->docente_apoyo_6=null;
                            $docentes_practica->docente_apoyo_7=null;
                            $docentes_practica->docente_apoyo_8=null;
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "2":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=null;
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->docente_apoyo_3=null;
                            $docentes_practica->docente_apoyo_4=null;
                            $docentes_practica->docente_apoyo_5=null;
                            $docentes_practica->docente_apoyo_6=null;
                            $docentes_practica->docente_apoyo_7=null;
                            $docentes_practica->docente_apoyo_8=null;
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "3":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('doc_apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=null;
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->docente_apoyo_4=null;
                            $docentes_practica->docente_apoyo_5=null;
                            $docentes_practica->docente_apoyo_6=null;
                            $docentes_practica->docente_apoyo_7=null;
                            $docentes_practica->docente_apoyo_8=null;
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "4":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('doc_apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('doc_apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=null;
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->docente_apoyo_5=null;
                            $docentes_practica->docente_apoyo_6=null;
                            $docentes_practica->docente_apoyo_7=null;
                            $docentes_practica->docente_apoyo_8=null;
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "5":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('doc_apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('doc_apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('doc_apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=null;
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->docente_apoyo_6=null;
                            $docentes_practica->docente_apoyo_7=null;
                            $docentes_practica->docente_apoyo_8=null;
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "6":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('doc_apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('doc_apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('doc_apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('doc_apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=null;
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->docente_apoyo_7=null;
                            $docentes_practica->docente_apoyo_8=null;
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "7":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('doc_apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('doc_apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('doc_apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('doc_apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('doc_apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=null;
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->docente_apoyo_8=null;
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "8":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('doc_apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('doc_apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('doc_apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('doc_apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('doc_apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=$request->get('doc_apoyo_8');
                            $docentes_practica->num_doc_docente_apoyo_9=null;
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->docente_apoyo_8=$request->get('apoyo_8');
                            $docentes_practica->docente_apoyo_9=null;
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "9":
                            $docentes_practica->num_doc_docente_apoyo_1=$request->get('doc_apoyo_1');
                            $docentes_practica->num_doc_docente_apoyo_2=$request->get('doc_apoyo_2');
                            $docentes_practica->num_doc_docente_apoyo_3=$request->get('doc_apoyo_3');
                            $docentes_practica->num_doc_docente_apoyo_4=$request->get('doc_apoyo_4');
                            $docentes_practica->num_doc_docente_apoyo_5=$request->get('doc_apoyo_5');
                            $docentes_practica->num_doc_docente_apoyo_6=$request->get('doc_apoyo_6');
                            $docentes_practica->num_doc_docente_apoyo_7=$request->get('doc_apoyo_7');
                            $docentes_practica->num_doc_docente_apoyo_8=$request->get('doc_apoyo_8');
                            $docentes_practica->num_doc_docente_apoyo_9=$request->get('doc_apoyo_9');
                            $docentes_practica->num_doc_docente_apoyo_10=null;
                            $docentes_practica->docente_apoyo_1=$request->get('apoyo_1');
                            $docentes_practica->docente_apoyo_2=$request->get('apoyo_2');
                            $docentes_practica->docente_apoyo_3=$request->get('apoyo_3');
                            $docentes_practica->docente_apoyo_4=$request->get('apoyo_4');
                            $docentes_practica->docente_apoyo_5=$request->get('apoyo_5');
                            $docentes_practica->docente_apoyo_6=$request->get('apoyo_6');
                            $docentes_practica->docente_apoyo_7=$request->get('apoyo_7');
                            $docentes_practica->docente_apoyo_8=$request->get('apoyo_8');
                            $docentes_practica->docente_apoyo_9=$request->get('apoyo_9');
                            $docentes_practica->docente_apoyo_10=null;
                            break;
                        case "10":
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
                            break;
                    }
                    
                /**Tabla docentes_practica */
                    
                /**Tabla transporte_proyeccion */
                    $transporte_proyeccion->cant_transporte_rp=$request->get('cant_transporte_rp_edit');
                    $transporte_proyeccion->cant_transporte_ra=$request->get('cant_transporte_ra_edit');

                    $tipo_transporte_rp = $request->get('id_tipo_transporte_rp_');
                    $det_tipo_transporte_rp = $request->get('det_tipo_transporte_rp_');
                    $capacid_transporte_rp = $request->get('capac_transporte_rp_');

                    $tipo_transporte_ra = $request->get('id_tipo_transporte_ra_');
                    $det_tipo_transporte_ra = $request->get('det_tipo_transporte_ra_');
                    $capacid_transporte_ra = $request->get('capac_transporte_ra_');

                    switch($transporte_proyeccion->cant_transporte_rp)
                    {
                        case "1":
                            $transporte_proyeccion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_proyeccion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_proyeccion->id_tipo_transporte_rp_2 =null;
                            $transporte_proyeccion->id_tipo_transporte_rp_3 =null;
                            $transporte_proyeccion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_proyeccion->det_tipo_transporte_rp_2=null;
                            $transporte_proyeccion->det_tipo_transporte_rp_3=null;
                            $transporte_proyeccion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_proyeccion->capac_transporte_rp_2=null;
                            $transporte_proyeccion->capac_transporte_rp_3=null;
                            $transporte_proyeccion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_proyeccion->exclusiv_tiempo_rp_2=null;
                            $transporte_proyeccion->exclusiv_tiempo_rp_3=null;
                            break;
                        case "2":
                            $transporte_proyeccion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_proyeccion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_proyeccion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??null;
                            $transporte_proyeccion->id_tipo_transporte_rp_3 =null;
                            $transporte_proyeccion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_proyeccion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??null;
                            $transporte_proyeccion->det_tipo_transporte_rp_3=null;
                            $transporte_proyeccion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_proyeccion->capac_transporte_rp_2=$capacid_transporte_rp[1]??null;
                            $transporte_proyeccion->capac_transporte_rp_3=null;
                            $transporte_proyeccion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_proyeccion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==null?null:intval($request->get('exclusiv_tiempo_rp_2'));
                            $transporte_proyeccion->exclusiv_tiempo_rp_3=null;
                            break;
                        case "3":
                            $transporte_proyeccion->docen_respo_trasnporte_rp = $request->get('docente_resp_transp_rp');
                            $transporte_proyeccion->id_tipo_transporte_rp_1 =$tipo_transporte_rp[0];
                            $transporte_proyeccion->id_tipo_transporte_rp_2 =$tipo_transporte_rp[1]??null;
                            $transporte_proyeccion->id_tipo_transporte_rp_3 =$tipo_transporte_rp[2]??null;
                            $transporte_proyeccion->det_tipo_transporte_rp_1=$det_tipo_transporte_rp[0];
                            $transporte_proyeccion->det_tipo_transporte_rp_2=$det_tipo_transporte_rp[1]??null;
                            $transporte_proyeccion->det_tipo_transporte_rp_3=$det_tipo_transporte_rp[2]??null;
                            $transporte_proyeccion->capac_transporte_rp_1=$capacid_transporte_rp[0];
                            $transporte_proyeccion->capac_transporte_rp_2=$capacid_transporte_rp[1]??null;
                            $transporte_proyeccion->capac_transporte_rp_3=$capacid_transporte_rp[2]??null;
                            $transporte_proyeccion->exclusiv_tiempo_rp_1=intval($request->get('exclusiv_tiempo_rp_1'));
                            $transporte_proyeccion->exclusiv_tiempo_rp_2=$request->get('exclusiv_tiempo_rp_2')==null?null:intval($request->get('exclusiv_tiempo_rp_2'));
                            $transporte_proyeccion->exclusiv_tiempo_rp_3=$request->get('exclusiv_tiempo_rp_3')==null?null:intval($request->get('exclusiv_tiempo_rp_3'));
                            break;
                    }

                    switch($transporte_proyeccion->cant_transporte_ra)
                    {
                        case "1":
                            $transporte_proyeccion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_proyeccion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_proyeccion->id_tipo_transporte_ra_2 =null;
                            $transporte_proyeccion->id_tipo_transporte_ra_3 =null;
                            $transporte_proyeccion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_proyeccion->det_tipo_transporte_ra_2=null;
                            $transporte_proyeccion->det_tipo_transporte_ra_3=null;
                            $transporte_proyeccion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_proyeccion->capac_transporte_ra_2=null;
                            $transporte_proyeccion->capac_transporte_ra_3=null;
                            $transporte_proyeccion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_proyeccion->exclusiv_tiempo_ra_2=null;
                            $transporte_proyeccion->exclusiv_tiempo_ra_3=null;
                            break;
                        case "2":
                            $transporte_proyeccion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_proyeccion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_proyeccion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??null;
                            $transporte_proyeccion->id_tipo_transporte_ra_3 =null;
                            $transporte_proyeccion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_proyeccion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??null;
                            $transporte_proyeccion->det_tipo_transporte_ra_3=null;
                            $transporte_proyeccion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_proyeccion->capac_transporte_ra_2=$capacid_transporte_ra[1]??null;
                            $transporte_proyeccion->capac_transporte_ra_3=null;
                            $transporte_proyeccion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_proyeccion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==null?null:intval($request->get('exclusiv_tiempo_ra_2'));
                            $transporte_proyeccion->exclusiv_tiempo_ra_3=null;
                            break;
                        case "3":
                            $transporte_proyeccion->docen_respo_trasnporte_ra = $request->get('docente_resp_transp_ra');
                            $transporte_proyeccion->id_tipo_transporte_ra_1 =$tipo_transporte_ra[0];
                            $transporte_proyeccion->id_tipo_transporte_ra_2 =$tipo_transporte_ra[1]??null;
                            $transporte_proyeccion->id_tipo_transporte_ra_3 =$tipo_transporte_ra[2]??null;
                            $transporte_proyeccion->det_tipo_transporte_ra_1=$det_tipo_transporte_ra[0];
                            $transporte_proyeccion->det_tipo_transporte_ra_2=$det_tipo_transporte_ra[1]??null;
                            $transporte_proyeccion->det_tipo_transporte_ra_3=$det_tipo_transporte_ra[2]??null;
                            $transporte_proyeccion->capac_transporte_ra_1=$capacid_transporte_ra[0];
                            $transporte_proyeccion->capac_transporte_ra_2=$capacid_transporte_ra[1]??null;
                            $transporte_proyeccion->capac_transporte_ra_3=$capacid_transporte_ra[2]??null;
                            $transporte_proyeccion->exclusiv_tiempo_ra_1=intval($request->get('exclusiv_tiempo_ra_1'));
                            $transporte_proyeccion->exclusiv_tiempo_ra_2=$request->get('exclusiv_tiempo_ra_2')==null?null:intval($request->get('exclusiv_tiempo_ra_2'));
                            $transporte_proyeccion->exclusiv_tiempo_ra_3=$request->get('exclusiv_tiempo_ra_3')==null?null:intval($request->get('exclusiv_tiempo_ra_3'));
                            break;
                    }
                /**Tabla transporte_proyeccion */

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

                /**Tabla riesgos_amenazas_proyeccion */
                    $riesg_amen_practica->areas_acuaticas_rp=$request->get('areas_acuaticas_rp')=='on'?1:0;
                    $riesg_amen_practica->areas_acuaticas_ra=$request->get('areas_acuaticas_ra')=='on'?1:0;
                    $riesg_amen_practica->alturas_rp=$request->get('alturas_rp')=='on'?1:0;
                    $riesg_amen_practica->alturas_ra=$request->get('alturas_ra')=='on'?1:0;
                    $riesg_amen_practica->riesgo_biologico_rp=$request->get('riesgo_biologico_rp')=='on'?1:0;
                    $riesg_amen_practica->riesgo_biologico_ra=$request->get('riesgo_biologico_ra')=='on'?1:0;
                    $riesg_amen_practica->espacios_confinados_rp=$request->get('espacios_confinados_rp')=='on'?1:0;
                    $riesg_amen_practica->espacios_confinados_ra=$request->get('espacios_confinados_ra')=='on'?1:0;
                /**Tabla riesgos_amenazas_proyeccion */

                /**Tabla materiales_herramientas_proyeccion */
                    $mater_herra_proyeccion->det_materiales_rp=$request->get('det_materiales_rp');
                    $mater_herra_proyeccion->det_materiales_ra=$request->get('det_materiales_ra');
                
                    $mater_herra_proyeccion->det_guias_baquianos_rp=$request->get('det_guias_baquia_rp');
                    $mater_herra_proyeccion->det_guias_baquianos_ra=$request->get('det_guias_baquia_ra');
            
                    $mater_herra_proyeccion->det_otros_boletas_rp=$request->get('det_otros_bolet_rp');
                    $mater_herra_proyeccion->det_otros_boletas_ra=$request->get('det_otros_bolet_ra');
                /**Tabla materiales_herramientas_proyeccion */

                /**Tabla costos_proyeccion */
                
                    $vlr_materiales_rp=intval(str_replace(".","",$request->get('vlr_materiales_rp')));
                    $vlr_materiales_ra=intval(str_replace(".","",$request->get('vlr_materiales_ra')));
                    $vlr_guias_baquianos_rp=intval(str_replace(".","",$request->get('vlr_guias_baquia_rp')));
                    $vlr_guias_baquianos_ra=intval(str_replace(".","",$request->get('vlr_guias_baquia_ra')));
                    $vlr_otros_boletas_rp=intval(str_replace(".","",$request->get('vlr_otros_bolet_rp')));
                    $vlr_otros_boletas_ra=intval(str_replace(".","",$request->get('vlr_otros_bolet_ra')));

                    $costos_proyeccion->vlr_materiales_rp=$vlr_materiales_rp ;
                    $costos_proyeccion->vlr_materiales_ra=$vlr_materiales_ra ;
                    $costos_proyeccion->vlr_guias_baquianos_rp=$vlr_guias_baquianos_rp ;
                    $costos_proyeccion->vlr_guias_baquianos_ra=$vlr_guias_baquianos_ra ;
                    $costos_proyeccion->vlr_otros_boletas_rp=$vlr_otros_boletas_rp ;
                    $costos_proyeccion->vlr_otros_boletas_ra=$vlr_otros_boletas_ra ;

                    $total_otros_rp = $vlr_materiales_rp + $vlr_guias_baquianos_rp + $vlr_otros_boletas_rp;
                    $total_otros_ra = $vlr_materiales_ra + $vlr_guias_baquianos_ra + $vlr_otros_boletas_ra;

                    $num_dias_rp = $proyeccion_preliminar->duracion_num_dias_rp;
                    $num_dias_ra = $proyeccion_preliminar->duracion_num_dias_ra;
                    $num_estud = $proyeccion_preliminar->num_estudiantes_aprox;
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

                    $costos_proyeccion->viaticos_estudiantes_rp=$viaticos_estudiantes_rp;
                    $costos_proyeccion->viaticos_estudiantes_ra=$viaticos_estudiantes_ra;

                    $costos_proyeccion->viaticos_docente_rp=$viaticos_docente_rp;
                    $costos_proyeccion->viaticos_docente_ra=$viaticos_docente_ra;

                    $costo_total_transporte_menor_rp = $vlr_trans_menor_rp_1 + $vlr_trans_menor_rp_2 + $vlr_trans_menor_rp_3 + $vlr_trans_menor_rp_4;
                    $costo_total_transporte_menor_ra = $vlr_trans_menor_ra_1 + $vlr_trans_menor_ra_2 + $vlr_trans_menor_ra_3 + $vlr_trans_menor_ra_4;

                    $costos_proyeccion->costo_total_transporte_menor_rp =$costo_total_transporte_menor_rp;
                    $costos_proyeccion->costo_total_transporte_menor_ra =$costo_total_transporte_menor_ra;
                    
                    $costos_proyeccion->total_presupuesto_rp=$viaticos_estudiantes_rp + $viaticos_docente_rp + $total_otros_rp + $costo_total_transporte_menor_rp;
                    $costos_proyeccion->total_presupuesto_ra=$viaticos_estudiantes_ra + $viaticos_docente_ra + $total_otros_ra + $costo_total_transporte_menor_ra;

                    $costos_proyeccion->save();
                /**Tabla costos_proyeccion */

                if(Auth::user()->id_programa_academico_coord == $proyeccion_preliminar->id_programa_academico)
                {
                    if($request->get('aprobacion_coordinador') == 4)
                    {
                        $proyeccion_preliminar->confirm_creador=1;
                        $proyeccion_preliminar->confirm_docente=0;
                        $proyeccion_preliminar->confirm_coord=0;
                        $proyeccion_preliminar->aprobacion_coordinador=5;
    
                    }
                }

            }

            /**campos coordinador */
                if(Auth::user()->id_role == 1 || (Auth::user()->id_role == 4 && Auth::user()->id_programa_academico_coord == $proyeccion_preliminar->id_programa_academico))
                {   //Auth::user()->hasRole(['Admin','Coordinador Proyecto']);

                    $proyeccion_preliminar->conf_curricul_plan_pract_rp=$request->get('conf_curricul_plan_pract_rp')=='on'?1:0;
                    $proyeccion_preliminar->conf_curricul_plan_pract_ra=$request->get('conf_curricul_plan_pract_ra')=='on'?1:0;

                    $proyeccion_preliminar->observ_coordinador= $request->get('observ_coordinador');
                    $proyeccion_preliminar->aprobacion_coordinador= $request->get('aprobacion_coordinador');
                    $proyeccion_preliminar->id_coordinador_aprob = Auth::user()->id;
		    $proyeccion_preliminar->aprobacion_asistD=7;
                    $proyeccion_preliminar->confirm_asistD=1;
		    $costos_proyeccion->valor_estimado_transporte_rp=1;
		    $costos_proyeccion->valor_estimado_transporte_ra=1;


                    
                    if($proyeccion_preliminar->aprobacion_decano == 4 && $proyeccion_preliminar->aprobacion_coordinador == 7)
                    {
                        $proyeccion_preliminar->aprobacion_decano=5;
                    }
                    else if($proyeccion_preliminar->aprobacion_decano == 4 && $proyeccion_preliminar->aprobacion_coordinador == 2)
                    {
                        $proyeccion_preliminar->id_estado = 2;
                    }

                }
            /**campos coordinador */

        }

        if(Auth::user()->id_role == 1 || Auth::user()->id_role == 2 )
        {
            $proyeccion_preliminar->observ_decano= $request->get('observ_decano');
            $proyeccion_preliminar->aprobacion_decano= $request->get('aprobacion_decano')!=null?$request->get('aprobacion_decano'):$proyeccion_preliminar->aprobacion_decano;

            $proyeccion_preliminar->id_decano_aprob = Auth::user()->id;

            if($proyeccion_preliminar->aprobacion_consejo_facultad == 3)
            {
                $doc_resp = $request->get('docentes_activos');
                if(!empty($doc_resp) || $doc_resp != NULL)
                {
                    $proyeccion_preliminar->id_docente_responsable= $request->get('docentes_activos');
                }

                $proyeccion_preliminar->id_estado= $request->get('estado_proyeccion');
                $estado_proy = $request->get('estado_proyeccion');

                if($estado_proy == NULL)
                {
                    $estado_proy = 1;
                    $proyeccion_preliminar->id_estado = $estado_proy;
                }

                if($estado_proy == 2)
                {
                    $proyeccion_preliminar->observ_inactividad = $request->get('obs_inact_proy');
                }
            }
            $proyeccion_preliminar->update();
            
            if((Auth::user()->id_role == 1 || Auth::user()->id_role == 2) && $request->get('aprobacion_decano') == 4)
            {
                $proyeccion_preliminar->confirm_creador=1;
                $proyeccion_preliminar->confirm_docente=1;
                $proyeccion_preliminar->confirm_coord=0;
		#proyeccion_preliminar->confirm_asistD=0
                $proyeccion_preliminar->aprobacion_coordinador=5;
                #proteccion_preliminar->aprobacion_asistD=7
		$this->rechazo_decano_proy($id);

                $proyeccion_preliminar->update();
            
            }
            if(Auth::user()->id_role == 2)
            {

                return redirect('proyecciones/filtrar/pend');
            }
        }

        if(Auth::user()->id_role == 1 || Auth::user()->id_role == 3 )
        {
            /** Debe tener valores para actualizar o no requerir transporte */
            if($transporte_proyeccion->cant_transporte_rp == 0)
            {
                $proyeccion_preliminar->aprobacion_asistD = 7;
                $proyeccion_preliminar->id_asistD_aprob = Auth::user()->id;
            }
            else if($transporte_proyeccion->cant_transporte_rp > 0)
            {
                if(($request->get('vlr_est_transp_rp') > 0) && ($request->get('vlr_est_transp_rp') != null))
                {
                    $valor_estimado_transporte_rp = $request->get('vlr_est_transp_rp')!=null?intval(str_replace(".","",$request->get('vlr_est_transp_rp'))):0;
    
                    $costo_total_transporte_menor_rp = $costos_proyeccion->costo_total_transporte_menor_rp;
                    
                    $viaticos_estudiantes_rp = $costos_proyeccion->viaticos_estudiantes_rp;
                    $viaticos_docente_rp = $costos_proyeccion->viaticos_docente_rp;
    
                    $costo_materiales_rp = $costos_proyeccion->vlr_materiales_rp;
    
                    $costo_baquianos_rp = $costos_proyeccion->vlr_guias_baquianos_rp;
    
                    $costo_boletas_rp = $costos_proyeccion->vlr_otros_boletas_rp;
                    
                    $total_presupuesto_rp= $costo_total_transporte_menor_rp + $viaticos_docente_rp + $viaticos_estudiantes_rp +  $costo_materiales_rp + $costo_baquianos_rp + $costo_boletas_rp;
                    
                    $costos_proyeccion->valor_estimado_transporte_rp = $valor_estimado_transporte_rp;
                    
                    $costos_proyeccion->total_presupuesto_rp = $total_presupuesto_rp;
                    $proyeccion_preliminar->aprobacion_asistD = 7;
                    $proyeccion_preliminar->id_asistD_aprob = Auth::user()->id;
                }
            }

            if($transporte_proyeccion->cant_transporte_ra == 0)
            {
                $proyeccion_preliminar->aprobacion_asistD = 7;
                $proyeccion_preliminar->id_asistD_aprob = Auth::user()->id;
            }
            else if($transporte_proyeccion->cant_transporte_ra > 0)
            {
                if(($request->get('vlr_est_transp_ra') > 0) && ($request->get('vlr_est_transp_ra') != null))
                {
                    $valor_estimado_transporte_ra = $request->get('vlr_est_transp_ra')!=null?intval(str_replace(".","",$request->get('vlr_est_transp_ra'))):0;
    
                    $costo_total_transporte_menor_ra = $costos_proyeccion->costo_total_transporte_menor_ra;
                    
                    $viaticos_estudiantes_ra = $costos_proyeccion->viaticos_estudiantes_ra;
                    $viaticos_docente_ra = $costos_proyeccion->viaticos_docente_ra;
    
                    $costo_materiales_ra = $costos_proyeccion->vlr_materiales_ra;
    
                    $costo_baquianos_ra = $costos_proyeccion->vlr_guias_baquianos_ra;
    
                    $costo_boletas_ra = $costos_proyeccion->vlr_otros_boletas_ra;
                    
                    $total_presupuesto_ra= $costo_total_transporte_menor_rp + $viaticos_docente_ra + $viaticos_estudiantes_ra +  $costo_materiales_ra + $costo_baquianos_ra + $costo_boletas_ra;
                    
                    $costos_proyeccion->valor_estimado_transporte_ra = $valor_estimado_transporte_ra;
                    
                    $costos_proyeccion->total_presupuesto_ra = $total_presupuesto_ra;
                    $proyeccion_preliminar->aprobacion_asistD = 7;
                    $proyeccion_preliminar->id_asistD_aprob = Auth::user()->id;
                }
            }

            /** Debe tener valores para actualizar o no requerir transporte*/

            /** Agregar  aprobacion_consejo_facultad */
                if($proyeccion_preliminar->aprobacion_decano == 7)
                {
                    $aprobacion_consejo_facultad = $request->get('aprobacion_consejo_facultad');
                    $proyeccion_preliminar->aprobacion_consejo_facultad = $aprobacion_consejo_facultad;

                    if($aprobacion_consejo_facultad == 3)
                    {
                        $proyeccion_preliminar->num_acta_consejo_facultad = $request->get('num_acta_consejo_facultad');
                        $proyeccion_preliminar->fecha_acta_consejo_facultad = $request->get('fecha_acta_consejo_facultad');

                        $sol_pract = DB::table('solicitud_practica as sol_prac')
                            ->where('sol_prac.id_proyeccion_preliminar',$proyeccion_preliminar->id)
                            ->first();

                        if($sol_pract == NULL || empty($sol_pract))
                        {
                            $solicitud_practica->id_proyeccion_preliminar = $id;
                            $solicitud_practica->id_estado_solicitud_practica = 5;
                            $solicitud_practica->save();

                            $doc_req_sol->id =$solicitud_practica->id;
                            $doc_req_sol->save();
                        }   

                    }

                    $proyeccion_preliminar->id_asistD_aprob_consejo = Auth::user()->id;
                }
            /** Agregar  aprobacion_consejo_facultad */
        }

        if(Auth::user()->id_role == 1)
        {
            $proyeccion_preliminar->id_estado=$request->get('estado_proyeccion');
            $estado_proy = $request->get('estado_proyeccion');

            if($estado_proy == NULL)
            {
                $estado_proy = 1;
                $proyeccion_preliminar->id_estado = $estado_proy;
            }

            if($estado_proy == 2)
            {
                $sol_pract = DB::table('solicitud_practica as sol_prac')
                    ->where('sol_prac.id_proyeccion_preliminar',$proyeccion_preliminar->id)
                    ->first();

                if($sol_pract != NULL || !empty($sol_pract))
                {
                    $solicitud_practica = solicitud::where('id_proyeccion_preliminar','=',$proyeccion_preliminar->id)->first();

                    $solicitud_practica->id_estado_solicitud_practica = 2;
                    $solicitud_practica->observ_inactividad = $request->get('obs_inact_proy');

                    $solicitud_practica->update();
                }

                $proyeccion_preliminar->observ_inactividad = $request->get('obs_inact_proy');
            }
            else
            {
                $proyeccion_preliminar->observ_inactividad = NULL;
            }
        }  
        
        $proyeccion_preliminar->update();
        $practicas_integradas->update();
        $docentes_practica->update();
        $costos_proyeccion->update();
        $transporte_proyeccion->update();
        $transporte_menor->update();
        $riesg_amen_practica->update();
        $mater_herra_proyeccion->update();
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
                if($proyeccion_preliminar->aprobacion_decano == 7)
                {
                    if($aprobacion_consejo_facultad == 3)
                    {
                        return redirect('proyecciones/filtrar/all');
                    }
                }
            }

            
        /** Enviar notificacion */
        if(Auth::user()->id_role == 1 )
        {
            return redirect('proyecciones/filtrar/all');
        }

        return redirect('proyecciones/filtrar/not_send');
    }

    /**
     * Duplicar proyección legalizada
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicar_proy($id)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $id = Crypt::decrypt($id);
        $idRole = Auth::user()->id_role;
        $idUser = Auth::user()->id;
        $mytime = Carbon::now('America/Bogota');

        /**Datos a duplicar */
            $proyeccion_preliminar = proyeccion::find($id);
            $transporte_proyeccion = transporte_proyeccion::find($id);
            $practicas_integradas = practicas_integradas::find($id);
            $transporte_menor = transporte_menor::find($id);
            $docentes_practica= docentes_practica::find($id);
            $costos_proyeccion = costos_proyeccion::find($id);
            $mater_herra_proyeccion = materiales_herramientas_proyeccion::find($id);
            $riesg_amen_practica = riesgos_amenazas_practica::find($id);
            $practicas_integradas = practicas_integradas::find($id);
            $idUser = $proyeccion_preliminar->id_docente_responsable;
            // $idUser = Auth::user()->id;
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

            $vlr_viaticos=DB::table('control_sistema as cs')
                    ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                    'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();
            
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
        /**Datos a duplicar */

        /**Tabla proyeccion_preliminar */
            $duplicado_proyeccion_preliminar = new proyeccion;
            $duplicado_proyeccion_preliminar->id_estado = 1;
            $duplicado_proyeccion_preliminar->id_programa_academico=$proyeccion_preliminar->id_programa_academico;
            $duplicado_proyeccion_preliminar->id_espacio_academico=$proyeccion_preliminar->id_espacio_academico;
            $duplicado_proyeccion_preliminar->practicas_integradas=$proyeccion_preliminar->practicas_integradas;
            $duplicado_proyeccion_preliminar->id_periodo_academico=$proyeccion_preliminar->id_periodo_academico;
            $duplicado_proyeccion_preliminar->anio_periodo=$proyeccion_preliminar->anio_periodo;
            $duplicado_proyeccion_preliminar->id_semestre_asignatura=$proyeccion_preliminar->id_semestre_asignatura;
            $duplicado_proyeccion_preliminar->num_estudiantes_aprox=$proyeccion_preliminar->num_estudiantes_aprox;
            $duplicado_proyeccion_preliminar->cantidad_grupos=$proyeccion_preliminar->cantidad_grupos;
            $duplicado_proyeccion_preliminar->grupo_1=$proyeccion_preliminar->grupo_1;
            $duplicado_proyeccion_preliminar->grupo_2=$proyeccion_preliminar->grupo_2;
            $duplicado_proyeccion_preliminar->grupo_3=$proyeccion_preliminar->grupo_3;
            $duplicado_proyeccion_preliminar->grupo_4=$proyeccion_preliminar->grupo_4;

            $duplicado_proyeccion_preliminar->destino_rp=$proyeccion_preliminar->destino_rp;
            $duplicado_proyeccion_preliminar->destino_ra=$proyeccion_preliminar->destino_ra;
            $duplicado_proyeccion_preliminar->cantidad_url_rp=$proyeccion_preliminar->cantidad_url_rp;
            $duplicado_proyeccion_preliminar->cantidad_url_ra=$proyeccion_preliminar->cantidad_url_ra;
            $duplicado_proyeccion_preliminar->ruta_principal=$proyeccion_preliminar->ruta_principal;
            $duplicado_proyeccion_preliminar->ruta_principal_2=$proyeccion_preliminar->ruta_principal_2;
            $duplicado_proyeccion_preliminar->ruta_principal_3=$proyeccion_preliminar->ruta_principal_3;
            $duplicado_proyeccion_preliminar->ruta_principal_4=$proyeccion_preliminar->ruta_principal_4;
            $duplicado_proyeccion_preliminar->ruta_principal_5=$proyeccion_preliminar->ruta_principal_5;
            $duplicado_proyeccion_preliminar->ruta_principal_6=$proyeccion_preliminar->ruta_principal_6;
            $duplicado_proyeccion_preliminar->ruta_alterna=$proyeccion_preliminar->ruta_alterna;
            $duplicado_proyeccion_preliminar->ruta_alterna_2=$proyeccion_preliminar->ruta_alterna_2;
            $duplicado_proyeccion_preliminar->ruta_alterna_3=$proyeccion_preliminar->ruta_alterna_3;
            $duplicado_proyeccion_preliminar->ruta_alterna_4=$proyeccion_preliminar->ruta_alterna_4;
            $duplicado_proyeccion_preliminar->ruta_alterna_5=$proyeccion_preliminar->ruta_alterna_5;
            $duplicado_proyeccion_preliminar->ruta_alterna_6=$proyeccion_preliminar->ruta_alterna_6;
            $duplicado_proyeccion_preliminar->det_recorrido_interno_rp=$proyeccion_preliminar->det_recorrido_interno_rp;
            $duplicado_proyeccion_preliminar->det_recorrido_interno_ra=$proyeccion_preliminar->det_recorrido_interno_ra;
            $duplicado_proyeccion_preliminar->lugar_salida_rp=$proyeccion_preliminar->lugar_salida_rp;
            $duplicado_proyeccion_preliminar->lugar_salida_ra=$proyeccion_preliminar->lugar_salida_ra;
            $duplicado_proyeccion_preliminar->lugar_regreso_rp=$proyeccion_preliminar->lugar_regreso_rp;
            $duplicado_proyeccion_preliminar->lugar_regreso_ra=$proyeccion_preliminar->lugar_regreso_ra;
            $duplicado_proyeccion_preliminar->fecha_salida_aprox_rp=$proyeccion_preliminar->fecha_salida_aprox_rp;
            $duplicado_proyeccion_preliminar->fecha_salida_aprox_ra=$proyeccion_preliminar->fecha_salida_aprox_ra;
            $duplicado_proyeccion_preliminar->fecha_regreso_aprox_rp=$proyeccion_preliminar->fecha_regreso_aprox_rp;
            $duplicado_proyeccion_preliminar->fecha_regreso_aprox_ra=$proyeccion_preliminar->fecha_regreso_aprox_ra;
            
            $duplicado_proyeccion_preliminar->duracion_num_dias_rp=$proyeccion_preliminar->duracion_num_dias_rp;
            $duplicado_proyeccion_preliminar->duracion_num_dias_ra=$proyeccion_preliminar->duracion_num_dias_ra;
            $duplicado_proyeccion_preliminar->id_docente_responsable=Auth::user()->id;

            $duplicado_proyeccion_preliminar->aprobacion_coordinador= 5;
            $duplicado_proyeccion_preliminar->aprobacion_asistD= 5;

            $duplicado_proyeccion_preliminar->aprobacion_decano= 5;
            $duplicado_proyeccion_preliminar->aprobacion_consejo_facultad= 5;

            if($idRole == 5 || $idRole == 1)
            {
                $duplicado_proyeccion_preliminar->confirm_creador= 1;
                $duplicado_proyeccion_preliminar->id_creador_confirm = Auth::user()->id;
                $duplicado_proyeccion_preliminar->confirm_docente= 0;
                $duplicado_proyeccion_preliminar->confirm_coord= 0;
                $duplicado_proyeccion_preliminar->confirm_asistD= 0;
            }
            else
            {
                $duplicado_proyeccion_preliminar->confirm_creador= 0;
                $duplicado_proyeccion_preliminar->id_creador_confirm = Auth::user()->id;
                $duplicado_proyeccion_preliminar->confirm_coord= 0;
                $duplicado_proyeccion_preliminar->confirm_asistD= 0;
                $duplicado_proyeccion_preliminar->confirm_electiva_coord= 0;

                if($idRole == 4)
                {
                    $duplicado_proyeccion_preliminar->confirm_creador= 1;
                    $duplicado_proyeccion_preliminar->id_creador_confirm = Auth::user()->id;
                    $duplicado_proyeccion_preliminar->confirm_docente= 1;
                    $duplicado_proyeccion_preliminar->id_docente_confirm = Auth::user()->id;
                }
            }
            
            $duplicado_proyeccion_preliminar->fecha_diligenciamiento=$mytime->toDateTimeString();

            $duplicado_proyeccion_preliminar->save();
            $id_nuevo = $duplicado_proyeccion_preliminar->id;
        /**Tabla proyeccion_preliminar */

        /**Tabla practicas_integradas */
            $duplicado_practicas_integradas= new practicas_integradas;
            $duplicado_practicas_integradas->id=$id_nuevo;
            $duplicado_practicas_integradas->cant_espa_aca=$practicas_integradas->cant_espa_aca;
            $duplicado_practicas_integradas->id_espa_aca_1=$practicas_integradas->id_espa_aca_1;
            $duplicado_practicas_integradas->id_espa_aca_2=$practicas_integradas->id_espa_aca_2;
            $duplicado_practicas_integradas->id_espa_aca_3=$practicas_integradas->id_espa_aca_3;
            $duplicado_practicas_integradas->id_espa_aca_4=$practicas_integradas->id_espa_aca_4;
            $duplicado_practicas_integradas->id_espa_aca_5=$practicas_integradas->id_espa_aca_5;
            $duplicado_practicas_integradas->id_espa_aca_6=$practicas_integradas->id_espa_aca_6;
            $duplicado_practicas_integradas->id_espa_aca_7=$practicas_integradas->id_espa_aca_7;
            $duplicado_practicas_integradas->id_docen_espa_aca_1=$practicas_integradas->id_docen_espa_aca_1;
            $duplicado_practicas_integradas->id_docen_espa_aca_2=$practicas_integradas->id_docen_espa_aca_2;
            $duplicado_practicas_integradas->id_docen_espa_aca_3=$practicas_integradas->id_docen_espa_aca_3;
            $duplicado_practicas_integradas->id_docen_espa_aca_4=$practicas_integradas->id_docen_espa_aca_4;
            $duplicado_practicas_integradas->id_docen_espa_aca_5=$practicas_integradas->id_docen_espa_aca_5;
            $duplicado_practicas_integradas->id_docen_espa_aca_6=$practicas_integradas->id_docen_espa_aca_6;
            $duplicado_practicas_integradas->id_docen_espa_aca_7=$practicas_integradas->id_docen_espa_aca_7;

            $duplicado_practicas_integradas->save();

        /**Tabla practicas_integradas */

        /**Tabla docentes_practica */
            $duplicado_docentes_practica = new docentes_practica;
            $duplicado_docentes_practica->id = $id_nuevo;
            $duplicado_docentes_practica->soporte_personal_apoyo=$docentes_practica->soporte_personal_apoyo;
            $duplicado_docentes_practica->total_docentes_apoyo=$docentes_practica->total_docentes_apoyo;
            $duplicado_docentes_practica->num_docentes_apoyo=$docentes_practica->num_docentes_apoyo;
            $duplicado_docentes_practica->total_docentes_apoyo=$docentes_practica->total_docentes_apoyo;
            $duplicado_docentes_practica->num_doc_docente_apoyo_1=$docentes_practica->num_doc_docente_apoyo_1;
            $duplicado_docentes_practica->num_doc_docente_apoyo_2=$docentes_practica->num_doc_docente_apoyo_2;
            $duplicado_docentes_practica->num_doc_docente_apoyo_3=$docentes_practica->num_doc_docente_apoyo_3;
            $duplicado_docentes_practica->num_doc_docente_apoyo_4=$docentes_practica->num_doc_docente_apoyo_4;
            $duplicado_docentes_practica->num_doc_docente_apoyo_5=$docentes_practica->num_doc_docente_apoyo_5;
            $duplicado_docentes_practica->num_doc_docente_apoyo_6=$docentes_practica->num_doc_docente_apoyo_6;
            $duplicado_docentes_practica->num_doc_docente_apoyo_7=$docentes_practica->num_doc_docente_apoyo_7;
            $duplicado_docentes_practica->num_doc_docente_apoyo_8=$docentes_practica->num_doc_docente_apoyo_8;
            $duplicado_docentes_practica->num_doc_docente_apoyo_9=$docentes_practica->num_doc_docente_apoyo_9;
            $duplicado_docentes_practica->num_doc_docente_apoyo_10= $docentes_practica->num_doc_docente_apoyo_10;
            $duplicado_docentes_practica->docente_apoyo_1=$docentes_practica->docente_apoyo_1;
            $duplicado_docentes_practica->docente_apoyo_2=$docentes_practica->docente_apoyo_2;
            $duplicado_docentes_practica->docente_apoyo_3=$docentes_practica->docente_apoyo_3;
            $duplicado_docentes_practica->docente_apoyo_4=$docentes_practica->docente_apoyo_4;
            $duplicado_docentes_practica->docente_apoyo_5=$docentes_practica->docente_apoyo_5;
            $duplicado_docentes_practica->docente_apoyo_6=$docentes_practica->docente_apoyo_6;
            $duplicado_docentes_practica->docente_apoyo_7=$docentes_practica->docente_apoyo_7;
            $duplicado_docentes_practica->docente_apoyo_8=$docentes_practica->docente_apoyo_8;
            $duplicado_docentes_practica->docente_apoyo_9=$docentes_practica->docente_apoyo_9;
            $duplicado_docentes_practica->docente_apoyo_10=$docentes_practica->docente_apoyo_10;

            $duplicado_docentes_practica->save();
        /**Tabla docentes_practica */

        /**Tabla transporte_proyeccion */
            $duplicado_transporte_proyeccion = new transporte_proyeccion;
            $duplicado_transporte_proyeccion->id = $id_nuevo;
            $duplicado_transporte_proyeccion->cant_transporte_rp=$transporte_proyeccion->cant_transporte_rp;
            $duplicado_transporte_proyeccion->cant_transporte_ra=$transporte_proyeccion->cant_transporte_ra;
            
            $duplicado_transporte_proyeccion->id_tipo_transporte_rp_1 =$transporte_proyeccion->id_tipo_transporte_rp_1;
            $duplicado_transporte_proyeccion->id_tipo_transporte_rp_2 =$transporte_proyeccion->id_tipo_transporte_rp_2;
            $duplicado_transporte_proyeccion->id_tipo_transporte_rp_3 =$transporte_proyeccion->id_tipo_transporte_rp_3;
            $duplicado_transporte_proyeccion->id_tipo_transporte_ra_1 =$transporte_proyeccion->id_tipo_transporte_ra_1;
            $duplicado_transporte_proyeccion->id_tipo_transporte_ra_2 =$transporte_proyeccion->id_tipo_transporte_ra_2;
            $duplicado_transporte_proyeccion->id_tipo_transporte_ra_3 =$transporte_proyeccion->id_tipo_transporte_ra_3;
            $duplicado_transporte_proyeccion->det_tipo_transporte_rp_1=$transporte_proyeccion->det_tipo_transporte_rp_1;
            $duplicado_transporte_proyeccion->det_tipo_transporte_rp_2=$transporte_proyeccion->det_tipo_transporte_rp_2;
            $duplicado_transporte_proyeccion->det_tipo_transporte_rp_3=$transporte_proyeccion->det_tipo_transporte_rp_3;
            $duplicado_transporte_proyeccion->det_tipo_transporte_ra_1=$transporte_proyeccion->det_tipo_transporte_ra_1;
            $duplicado_transporte_proyeccion->det_tipo_transporte_ra_2=$transporte_proyeccion->det_tipo_transporte_ra_2;
            $duplicado_transporte_proyeccion->det_tipo_transporte_ra_3=$transporte_proyeccion->det_tipo_transporte_ra_3;

            $duplicado_transporte_proyeccion->docen_respo_trasnporte_rp=$transporte_proyeccion->docen_respo_trasnporte_rp;
            $duplicado_transporte_proyeccion->docen_respo_trasnporte_ra=$transporte_proyeccion->docen_respo_trasnporte_ra;

            $duplicado_transporte_proyeccion->capac_transporte_rp_1=$transporte_proyeccion->capac_transporte_rp_1;
            $duplicado_transporte_proyeccion->capac_transporte_rp_2=$transporte_proyeccion->capac_transporte_rp_2;
            $duplicado_transporte_proyeccion->capac_transporte_rp_3=$transporte_proyeccion->capac_transporte_rp_3;
            $duplicado_transporte_proyeccion->capac_transporte_ra_1=$transporte_proyeccion->capac_transporte_ra_1;
            $duplicado_transporte_proyeccion->capac_transporte_ra_2=$transporte_proyeccion->capac_transporte_ra_2;
            $duplicado_transporte_proyeccion->capac_transporte_ra_3=$transporte_proyeccion->capac_transporte_ra_3;

            $duplicado_transporte_proyeccion->exclusiv_tiempo_rp_1=$transporte_proyeccion->exclusiv_tiempo_rp_1;
            $duplicado_transporte_proyeccion->exclusiv_tiempo_rp_2=$transporte_proyeccion->exclusiv_tiempo_rp_2;
            $duplicado_transporte_proyeccion->exclusiv_tiempo_rp_3=$transporte_proyeccion->exclusiv_tiempo_rp_3;
            $duplicado_transporte_proyeccion->exclusiv_tiempo_ra_1=$transporte_proyeccion->exclusiv_tiempo_ra_1;
            $duplicado_transporte_proyeccion->exclusiv_tiempo_ra_2=$transporte_proyeccion->exclusiv_tiempo_ra_2;
            $duplicado_transporte_proyeccion->exclusiv_tiempo_ra_3=$transporte_proyeccion->exclusiv_tiempo_ra_3;

            $duplicado_transporte_proyeccion->save();
        /**Tabla transporte_proyeccion */

        /**Tabla transporte_menor */
            $duplicado_transporte_menor = new transporte_menor;
            $duplicado_transporte_menor->id=$id_nuevo;
            $duplicado_transporte_menor->docente_resp_t_menor_rp=$transporte_menor->docente_resp_t_menor_rp;
            $duplicado_transporte_menor->docente_resp_t_menor_ra=$transporte_menor->docente_resp_t_menor_ra;
            $duplicado_transporte_menor->cant_trans_menor_rp=$transporte_menor->cant_trans_menor_rp;
            $duplicado_transporte_menor->cant_trans_menor_ra=$transporte_menor->cant_trans_menor_ra;
            $duplicado_transporte_menor->trans_menor_rp_1=$transporte_menor->trans_menor_rp_1;
            $duplicado_transporte_menor->trans_menor_rp_2=$transporte_menor->trans_menor_rp_2;
            $duplicado_transporte_menor->trans_menor_rp_3=$transporte_menor->trans_menor_rp_3;
            $duplicado_transporte_menor->trans_menor_rp_4=$transporte_menor->trans_menor_rp_4;
            $duplicado_transporte_menor->trans_menor_ra_1=$transporte_menor->trans_menor_ra_1;
            $duplicado_transporte_menor->trans_menor_ra_2=$transporte_menor->trans_menor_ra_2;
            $duplicado_transporte_menor->trans_menor_ra_3=$transporte_menor->trans_menor_ra_3;
            $duplicado_transporte_menor->trans_menor_ra_4=$transporte_menor->trans_menor_ra_4;
            $duplicado_transporte_menor->vlr_trans_menor_rp_1=$transporte_menor->vlr_trans_menor_rp_1;
            $duplicado_transporte_menor->vlr_trans_menor_rp_2=$transporte_menor->vlr_trans_menor_rp_2;
            $duplicado_transporte_menor->vlr_trans_menor_rp_3=$transporte_menor->vlr_trans_menor_rp_3;
            $duplicado_transporte_menor->vlr_trans_menor_rp_4=$transporte_menor->vlr_trans_menor_rp_4;
            $duplicado_transporte_menor->vlr_trans_menor_ra_1=$transporte_menor->vlr_trans_menor_ra_1;
            $duplicado_transporte_menor->vlr_trans_menor_ra_2=$transporte_menor->vlr_trans_menor_ra_2;
            $duplicado_transporte_menor->vlr_trans_menor_ra_3=$transporte_menor->vlr_trans_menor_ra_3;
            $duplicado_transporte_menor->vlr_trans_menor_ra_4=$transporte_menor->vlr_trans_menor_ra_4;

            $duplicado_transporte_menor->save();

        /**Tabla transporte_menor */

        /**Tabla materiales_herramientas_proyeccion */
            $duplicado_mater_herra_proyeccion = new materiales_herramientas_proyeccion;
            $duplicado_mater_herra_proyeccion->id = $id_nuevo;
            $duplicado_mater_herra_proyeccion->det_materiales_rp=$mater_herra_proyeccion->det_materiales_rp;
            $duplicado_mater_herra_proyeccion->det_materiales_ra=$mater_herra_proyeccion->det_materiales_ra;
            $duplicado_mater_herra_proyeccion->det_guias_baquianos_rp=$mater_herra_proyeccion->det_guias_baquianos_rp;
            $duplicado_mater_herra_proyeccion->det_guias_baquianos_ra=$mater_herra_proyeccion->det_guias_baquianos_ra;
            $duplicado_mater_herra_proyeccion->det_otros_boletas_rp=$mater_herra_proyeccion->det_otros_boletas_rp;
            $duplicado_mater_herra_proyeccion->det_otros_boletas_ra=$mater_herra_proyeccion->det_otros_boletas_ra;

            $duplicado_mater_herra_proyeccion->save();
        /**Tabla materiales_herramientas_proyeccion */

        /**Tabla riesgos_amenazas_proyeccion */
            $duplicado_riesg_amen_practica = new riesgos_amenazas_practica;
            $duplicado_riesg_amen_practica->id = $id_nuevo;
            $duplicado_riesg_amen_practica->areas_acuaticas_rp=$riesg_amen_practica->areas_acuaticas_rp;
            $duplicado_riesg_amen_practica->areas_acuaticas_ra=$riesg_amen_practica->areas_acuaticas_ra;
            $duplicado_riesg_amen_practica->alturas_rp=$riesg_amen_practica->alturas_rp;
            $duplicado_riesg_amen_practica->alturas_ra=$riesg_amen_practica->alturas_ra;
            $duplicado_riesg_amen_practica->riesgo_biologico_rp=$riesg_amen_practica->riesgo_biologico_rp;
            $duplicado_riesg_amen_practica->riesgo_biologico_ra=$riesg_amen_practica->riesgo_biologico_ra;
            $duplicado_riesg_amen_practica->espacios_confinados_rp=$riesg_amen_practica->espacios_confinados_rp;
            $duplicado_riesg_amen_practica->espacios_confinados_ra=$riesg_amen_practica->espacios_confinados_ra;

            $duplicado_riesg_amen_practica->save();
        /**Tabla riesgos_amenazas_proyeccion */

        /**Tabla costos_proyeccion */
            $duplicado_costos_proyeccion = new costos_proyeccion;
            $duplicado_costos_proyeccion->id = $id_nuevo;
            $duplicado_costos_proyeccion->vlr_materiales_rp=$costos_proyeccion->vlr_materiales_rp;
            $duplicado_costos_proyeccion->vlr_materiales_ra=$costos_proyeccion->vlr_materiales_ra;
            $duplicado_costos_proyeccion->vlr_guias_baquianos_rp=$costos_proyeccion->vlr_guias_baquianos_rp;
            $duplicado_costos_proyeccion->vlr_guias_baquianos_ra=$costos_proyeccion->vlr_guias_baquianos_ra;
            $duplicado_costos_proyeccion->vlr_otros_boletas_rp=$costos_proyeccion->vlr_otros_boletas_rp;
            $duplicado_costos_proyeccion->vlr_otros_boletas_ra=$costos_proyeccion->vlr_otros_boletas_ra;

            $duplicado_costos_proyeccion->viaticos_estudiantes_rp=$costos_proyeccion->viaticos_estudiantes_rp;
            $duplicado_costos_proyeccion->viaticos_estudiantes_ra=$costos_proyeccion->viaticos_estudiantes_ra;
            $duplicado_costos_proyeccion->viaticos_docente_rp=$costos_proyeccion->viaticos_docente_rp;
            $duplicado_costos_proyeccion->viaticos_docente_ra=$costos_proyeccion->viaticos_docente_ra;

            $duplicado_costos_proyeccion->costo_total_transporte_menor_rp =$costos_proyeccion->costo_total_transporte_menor_rp;
            $duplicado_costos_proyeccion->costo_total_transporte_menor_ra =$costos_proyeccion->costo_total_transporte_menor_ra;

            $duplicado_costos_proyeccion->save();
        /**Tabla costos_proyeccion */

        if($idRole == 5 || $idRole == 4)
        {
            $this->creacion_proy($id_nuevo);
        }

        return redirect('proyecciones/filtrar/not_send');

    }

    /**
     * Proyección preliminar enviada-confirmada
     *
     * @return \Illuminate\Http\Response
     */
    public function sendProy(Request $request)
    {

        $idRole = Auth::user()->id_role;
        $idUser = Auth::user()->id;

        $id_proyecciones_confimadas = $request->get('data');
        switch($idRole)
        {
            case 1:
            break;

            case 2:
            break;

            case 3:
                foreach($id_proyecciones_confimadas as $id)
                {
                    $proyeccion = proyeccion::find($id);
                    $proyeccion->confirm_asistD = 1;
                    $proyeccion->id_asistD_confirm = $idUser;
                    $proyeccion->update();
                }
            break;

            case 4:
                foreach($id_proyecciones_confimadas as $id)
                {
                    $proyeccion = proyeccion::find($id);
                    // $proyeccion->confirm_electiva_coord = 1;
                    // $proyeccion->id_coordinador_electiva_confirm = $idUser;
                    $proyeccion->confirm_coord = 1;
                    $proyeccion->aprobacion_coordinador = 7;
                    $proyeccion->id_coordinador_confirm = $idUser;
                    $proyeccion->update();
                }
            break;

            case 5:
                foreach($id_proyecciones_confimadas as $id)
                {
                    $proyeccion = proyeccion::find($id);
                    $proyeccion->confirm_docente = 1;
                    $proyeccion->id_docente_confirm = $idUser;
                    $proyeccion->update();
                }

                // $this->creacion_proy($id_proyecciones_confimadas);
            break;

        }

        $filter = "send";

        return route('proyeccion_filter',['id'=>$filter]);
    }

    /**
     * Proyección preliminar visto bueno decanatura
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

            $id_proyecciones_vb_decano = $request->get('data');
            switch($idRole)
            {

                case 1:
                    foreach($id_proyecciones_vb_decano as $id)
                    {
                        $proyeccion = proyeccion::find($id);
                        $proyeccion->aprobacion_decano = 7;
                        $proyeccion->id_decano_aprob = $idUser;
                        $proyeccion->update();
                    }
                break;

                case 2:
                    foreach($id_proyecciones_vb_decano as $id)
                    {
                        $proyeccion = proyeccion::find($id);
                        $proyeccion->aprobacion_decano = 7;
                        $proyeccion->id_decano_aprob = $idUser;
                        $proyeccion->update();
                    }
                    $this->vb_decano_proy($id_proyecciones_vb_decano);
                break;

            }

        $filter = "aprob";

        return route('proyeccion_filter',['filter'=>$filter]);
    }

    /**
     * Validar asignaturas electivas
     *
     * @return \Illuminate\Http\Response
     */
    public function validar_electivas(Request $request)
    {
        $id_proyecciones_confimadas = $request->get('data');
        $proy = 0;
        $id_elect = [];

        if(count($id_proyecciones_confimadas) == 1)
        {
            $proyeccion=DB::table('proyeccion_preliminar as p_prel')
            ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico','e_aca.electiva')
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->where('p_prel.id','=',$id_proyecciones_confimadas)
            ->where('e_aca.electiva','=',1)->first();

            if(!empty($proyeccion))
            {
                $id_elect[] += $proyeccion->id;
            }
        }

        elseif(count($id_proyecciones_confimadas) > 1)
        {

            foreach($id_proyecciones_confimadas as $id)
            {
                $proyeccion=DB::table('proyeccion_preliminar as p_prel')
                            ->select('p_prel.id','e_aca.id_programa_academico','p_aca.programa_academico','e_aca.espacio_academico','e_aca.electiva')
                            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                            ->where('p_prel.id','=',$id)
                            ->where('e_aca.electiva','=',1)->first();
    
                
                if(!empty($proyeccion))
                {
                    $id_elect[] += $proyeccion->id;
                }
            }
        }

        return response()->json($id_elect);
    }

    /**
     * Información sobre la creación de la proyección
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function creacion_proy($id)
    {
        $correos_administrativos = [];
        $filter = "creacion_proy";
        $nueva_solicitud = "";
        
        $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
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

        $id_creador = $nueva_proyeccion->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_proyeccion->id_pro_aca;
        $coord =DB::table('users')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        
        $emails = [];

        $emails[] = ["email"=>$creador->email, "role"=>$creador->id_role];
        $emails[] = ["email"=>$coord->email, "role"=>$coord->id_role];
        
        // foreach($emails as $email)
        // {
        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email, $correos_administrativos));
        // }
    }

    /**
     * Aprobación de la proyección por coordinación
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function aprob_coord_proy($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "aprob_coord_proy";

        $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
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

        $id_creador = $nueva_proyeccion->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        $id_pro_aca = $nueva_proyeccion->id_pro_aca;
        $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];
        $emails[] = ["email"=>"juldgonzalezc@udistrital.edu.co","id_role"=>5];
        //$emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        //$emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        //$emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

        // foreach($emails as $email)
        // {

        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
        // }
    }

    /**
     * Rechazo de la proyección por coordinación
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function rechazo_coord_proy($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "rechazo_coord_proy";

        $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
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

        $id_creador = $nueva_proyeccion->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_proyeccion->id_pro_aca;
        $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        //$emails[] = ["email"=>"juldgonzalezc@udistrital.edu.co","role"=>5]; //prueba
        //$emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

         //foreach($emails as $email)
         //{
         //    Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
         //}
    }

    /**
     * Aprobación de la proyección por decanatura
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function aprob_decano_proy($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "aprob_decano_proy";

        $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
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

        $id_creador = $nueva_proyeccion->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        $id_pro_aca = $nueva_proyeccion->id_pro_aca;
        $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        // $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

        // foreach($emails as $email)
        // {

        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
        // }
    }

    /**
     * Rechazo de la proyección por decanatura
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function rechazo_decano_proy($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "rechazo_decano_proy";

        $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
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

        $id_creador = $nueva_proyeccion->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_proyeccion->id_pro_aca;
        $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
        $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.name','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
        $emails = [];

        // $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
        $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
        // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
        // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

        // foreach($emails as $email)
        // {

        //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
        // }
    }

    /**
     * Cierre de la proyección por coordinación
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function cierre_coord_proy($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "cierre_coord_proy";

        $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
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

        $id_creador = $nueva_proyeccion->id_docente_responsable;
        $creador=DB::table('users')->where('id','=',$id_creador)->first();
        // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
        $id_pro_aca = $nueva_proyeccion->id_pro_aca;
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
     * Visto bueno proyecciones por decanatura
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function vb_decano_proy($list_proy)
    {
        try
        {
                $nueva_proyeccion = [];
                $nueva_solicitud = "";
                $filter = "vb_decano_proy";
                

                foreach($list_proy as $item)
                {
                    $proyeccion = DB::table('proyeccion_preliminar as proy_pre')
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
                    
                    $nueva_proyeccion[] = ['id'=>$proyeccion->id,
                                            'programa_academico'=>$proyeccion->programa_academico,
                                            'espacio_academico'=>$proyeccion->espacio_academico,
                                            'sem_academico'=>$proyeccion->semestre_asignatura,
                                            'anio'=>$proyeccion->anio_periodo,
                                            'per_academico'=>$proyeccion->periodo_academico,
                                            'docente_responsable'=>$proyeccion->full_name,
                                            'destino_rp'=>$proyeccion->destino_rp,
                                            'fecha_salida_aprox_rp'=>$proyeccion->fecha_salida_aprox_rp,
                                            'fecha_regreso_aprox_rp'=>$proyeccion->fecha_regreso_aprox_rp,
                                            'destino_ra'=>$proyeccion->destino_ra,
                                            'fecha_salida_aprox_ra'=>$proyeccion->fecha_salida_aprox_ra,
                                            'fecha_regreso_aprox_ra'=>$proyeccion->fecha_regreso_aprox_ra];
                }
            
                $sec_acad =DB::table('correos_administrativos as c_admin')
                        ->where('c_admin.id','=',1)
                        ->orWhere('c_admin.area_dependencia','=','Secretaría Académica')
                        ->first();
                      
                $emails = [];
                $emails[] = ["email"=>$sec_acad->correo,"dependencia"=>$sec_acad->area_dependencia];
            
                $correos_administrativos = $emails;
                // foreach($emails as $email)
                // {
                    
                //     Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email, $correos_administrativos));
                    
                // }
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al enviar notificación.');
        }
    }


    /**
     * Buscador de proyección por palabras claves 
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

            $proyeccion=DB::table('proyeccion_preliminar as p_prel')
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
            ->join('costos_proyeccion as c_proy','p_prel.id','=','c_proy.id')
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
            
            $cant_resul = count($proyeccion);
        }
        else{
            return redirect('proyecciones/filtrar/all');
        }
        return view('proyecciones.buscador.tabla_buscador',['proyecciones'=>$proyeccion, 
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
        $vlr_estud_max=$control_sistema->vlr_estud_max;
        $vlr_estud_min=$control_sistema->vlr_estud_min;

        if($num_dias_rp>1)
        {
            $viaticos_estud_rp = $num_estud*$vlr_estud_max*$num_dias_rp;
        }
        else if($num_dias_rp==1)
        {
            $viaticos_estud_rp = $num_estud*$vlr_estud_min*$num_dias_rp;
        }
        else if($num_dias_rp==0 || $num_dias_rp == null || isEmpty($num_dias_rp))
        {
            $viaticos_estud_rp = 0;
        }

        if($num_dias_ra>1)
        {
            $viaticos_estud_ra = $num_estud*$vlr_estud_max*$num_dias_ra;
        }
        else if($num_dias_ra==1)
        {
            $viaticos_estud_ra = $num_estud*$vlr_estud_min*$num_dias_ra;
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
        $vlr_docen_max=$control_sistema->vlr_docen_max;
        $vlr_docen_min=$control_sistema->vlr_docen_min;

        if($num_dias_rp>1)
        {
            $viaticos_docen_rp = $total_docentes*$vlr_docen_max*($num_dias_rp-0.5);
        }
        else if($num_dias_rp==0 || $num_dias_rp==1 || $num_dias_rp == null || isEmpty($num_dias_rp))
        {
            $viaticos_docen_rp = 0;
        }

        if($num_dias_ra>1)
        {
            $viaticos_docen_ra = $total_docentes*$vlr_docen_max*($num_dias_ra-0.5);
        }
        else if($num_dias_ra==0 || $num_dias_ra==1 || $num_dias_ra == null || isEmpty($num_dias_ra))
        {
            $viaticos_docen_ra = 0;
        }

        return ['viaticos_docen_rp'=>$viaticos_docen_rp,'viaticos_docen_ra'=>$viaticos_docen_ra];
    }
}
