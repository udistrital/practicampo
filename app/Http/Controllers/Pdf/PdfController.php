<?php

namespace PractiCampoUD\Http\Controllers\Pdf;

use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PractiCampoUD\docentes_practica;
use PractiCampoUD\solicitud;
use PractiCampoUD\User;
use Carbon\Carbon;
use DB;
use NumberFormatter;
use PDF;
use stdClass;


/**
 * Documentos con formato .pdf
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
class PdfController extends Controller
{
    /**
     * Exportar resolución
     * Formato .pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response    
     */
    public function exportResolucionPdf($ids)
    {
        // $id=Crypt::decrypt($id);
        $id=explode(",",$ids);

        $list_solic = [];
        $list_doc = [];
        $list_proy =[];
        $f_sal_reg = [];
        $list_viaticos_docente = [];
        $list_viaticos_estudiante = [];
        $list_valor_est_trans = [];
        $list_vlr_trans_menor = [];
        $list_vlr_materiales = [];
        $list_vlr_guias_baquianos = [];
        $list_vlr_boletas_otros = [];
        $list_presupuesto_total = [];

        
        $total_asistentes =[];

        foreach($id as $item)
        {
            $list_solic[]=$item;
        }

        $data = ['title' => 'Formato Resolución'];
        $control_sistema =DB::table('control_sistema')->first();
        
        $parrafos_modificables =DB::table('resolucion')->first();
        $fecha_solicitud = Carbon::now('America/Bogota')->format('Y');
        $consulta_solicitud=DB::table('solicitud_practica')->select('id', 'id_proyeccion_preliminar')->whereIN('id',$list_solic)->get();
        foreach($consulta_solicitud as $item)
	{
	   $list_doc[]=$item->id_proyeccion_preliminar;
	}
	$docentes_practica=docentes_practica::whereIn('id',$list_doc)->get();

        $solicitudes_practica =DB::table('solicitud_practica as sol_prac')
        // $solicitudes_practica_aprob =DB::table('solicitud_practica as sol_prac')
        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico', 'e_aca.codigo_espacio_academico',
                'per_aca.periodo_academico','sem_asig.semestre_asignatura',
                'p_prel.destino_rp','p_prel.destino_ra','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp',
                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra',
                'p_prel.id_docente_responsable','docen_pract.docente_apoyo_1',
                'p_prel.duracion_num_dias_rp','c_proy.viaticos_docente_rp','c_proy.viaticos_estudiantes_rp','c_proy.total_presupuesto_rp',
                'p_prel.duracion_num_dias_ra','c_proy.viaticos_docente_ra','c_proy.viaticos_estudiantes_ra','c_proy.total_presupuesto_ra',
                'c_proy.valor_estimado_transporte_rp', 'c_proy.valor_estimado_transporte_ra','c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra',
                'c_proy.vlr_guias_baquianos_rp','c_proy.vlr_guias_baquianos_ra','c_proy.vlr_otros_boletas_rp','c_proy.vlr_otros_boletas_ra',
                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra',
                'tip_vinc.tipo_vinculacion', 'users.celular', 'users.email',
                'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo',
                'p_prel.cantidad_grupos', 'sol_prac.fecha_salida','sol_prac.fecha_regreso','sol_prac.duracion_num_dias',
                'transp.cant_transporte_rp', 'transp.cant_transporte_ra', 'sol_prac.cronograma', 'sol_prac.observaciones', 
                'sol_prac.justificacion', 'sol_prac.objetivo_general', 'sol_prac.metodologia_evaluacion',
                'sol_prac.tipo_ruta','sol_prac.id as id_solicitud', 'sol_prac.num_resolucion','sol_prac.fecha_resolucion',
                'sol_prac.num_cdp', 'p_prel.num_acta_consejo_facultad', 'p_prel.fecha_acta_consejo_facultad',
                'tip_ident.tipo_identificacion','users.id as id_user','docen_pract.*',
                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) 
                as full_name'))
        ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
        ->join('practicas_integradas as p_int','sol_prac.id_proyeccion_preliminar','=','p_int.id')
        ->join('costos_proyeccion as c_proy','sol_prac.id_proyeccion_preliminar','=','c_proy.id')
        ->join('docentes_practica as docen_pract','sol_prac.id_proyeccion_preliminar','=','docen_pract.id')
        ->join('users','p_prel.id_docente_responsable','=','users.id')
        ->join('periodo_academico as per_aca','p_prel.id_periodo_academico','=','per_aca.id')
        ->join('semestre_asignatura as sem_asig','p_prel.id_semestre_asignatura','=','sem_asig.id')
        ->join('tipo_vinculacion as tip_vinc','users.id_tipo_vinculacion','=','tip_vinc.id')
        ->join('tipo_identificacion as tip_ident','users.id_tipo_identificacion','=','tip_ident.id')
        ->join('transporte_proyeccion as transp','p_prel.id','=','transp.id')
        ->where('id_estado_solicitud_practica','=',3)
        // ->where('si_capital','=',1)
        // ->where('tiene_resolucion','=',1)
        ->whereIn('sol_prac.id',$list_solic)->get();

        $vlr_viaticos=DB::table('control_sistema as cs')
                        ->select('cs.vlr_estud_max', 'cs.vlr_estud_min',
                        'cs.vlr_docen_min', 'cs.vlr_docen_max')->first();

        $decano = DB::table('users')
                ->select('users.firma_litografica','users.tiene_firma',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, 
                        users.primer_apellido, users.segundo_apellido) as full_name'))
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();

        $anio_resolucion = $solicitudes_practica[0]->fecha_resolucion;

        if($decano->tiene_firma == 1)
        {
            $firma_lito = "data:image/png;base64,$decano->firma_litografica";
        }
        else if($decano->tiene_firma == 0)
        {
            $firma_lito = "";
        }

        $pract_inte=DB::table('practicas_integradas as prac_int')
                        ->where('prac_int.id',$solicitudes_practica[0]->id)
                        ->first();

        $doce_pract_int = [];

        $docente_resp=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
                    ->where('id',$solicitudes_practica[0]->id_docente_responsable)->first();
//dd($pract_inte->cant_espa_aca);
        if($pract_inte->cant_espa_aca == 0 or is_null($pract_inte->cant_espa_aca)){        
           $doce_pract_int[] =['id'=>$docente_resp->id,'full_name'=>$docente_resp->full_name,
                            'email'=>$docente_resp->email,'celular'=>$docente_resp->celular];
        }
//dd($doce_pract_int);
        $contador = 0;
        $sumatoria_presupuesto=0;

        $viaticos_docente = 0;
        $viaticos_estudiante = 0;
        $valor_est_trans = 0;
        $transporte_menor = 0;
        $valor_materiales = 0;
        $valor_baquianos = 0;
        $valor_boletas = 0;
        $total_resolucion = 0;
        foreach($solicitudes_practica as $sol)
        {
        $pract_inte=DB::table('practicas_integradas as prac_int')
                        ->where('prac_int.id',$sol->id)
                        ->first();

            $contador++;
            if($sol->tipo_ruta == 1){
                $list_valor_est_trans[$contador-1] = ['vlr_estimado_transporte'=>$sol->valor_estimado_transporte_rp, 
                                                      'id_proy'=>$sol->id];
                $list_vlr_trans_menor[$contador-1] = ['vlr_total_transporte_menor'=>$sol->costo_total_transporte_menor_rp, 
                                                    'id_proy'=>$sol->id];
                $list_viaticos_docente[$contador-1] = ['vlr_viaticos_docente'=>$sol->viaticos_docente_rp, 
                                                    'id_proy'=>$sol->id];
                $list_viaticos_estudiante[$contador-1] = ['vlr_viaticos_estudiantes'=>$sol->viaticos_estudiantes_rp, 
                                                    'id_proy'=>$sol->id];
                $list_vlr_materiales[$contador-1] = ['vlr_materiales'=>$sol->vlr_materiales_rp, 
                                                    'vlr_guias_baquianos'=>$sol->vlr_guias_baquianos_rp, 
                                                    'vlr_otros_boletas'=>$sol->vlr_otros_boletas_rp,
                                                    'total'=>$sol->vlr_otros_boletas_rp + $sol->vlr_guias_baquianos_rp + $sol->vlr_materiales_rp,
                                                    'id_proy'=>$sol->id];
                $list_presupuesto_total[$contador-1] = ['total_presupuesto'=>$sol->total_presupuesto_rp, 
                                                    'id_proy'=>$sol->id];
                $valor_materiales = $sol->vlr_materiales_rp;
                $valor_boletas = $sol->vlr_otros_boletas_rp;
                $valor_baquianos =  $sol->vlr_guias_baquianos_rp;
                $viaticos_docente = $sol->viaticos_docente_rp;
                $viaticos_estudiante = $sol->viaticos_estudiantes_rp;
                $valor_est_trans = $sol->valor_estimado_transporte_rp;
                $transporte_menor = $sol->costo_total_transporte_menor_rp;
                $total_resolucion =  $valor_materiales + $valor_baquianos + $valor_boletas + $transporte_menor + $viaticos_docente + $viaticos_estudiante;
                $list_presupuesto_total[$contador-1] = ['total_presupuesto'=>$total_resolucion,//$sol->total_presupuesto_ra, 
                                                    'id_proy'=>$sol->id];
                $sumatoria_presupuesto+= $total_resolucion;   
                //$sumatoria_presupuesto = $sumatoria_presupuesto + $sol->total_presupuesto_rp;
                // $doce_pract_int[] =['id'=>$docente_resp->id,'full_name'=>$docente_resp->full_name,
                // 'email'=>$docente_resp->email,'celular'=>$docente_resp->celular];

                $espa_pract_int[] =['id_proy'=>$sol->id,'espacio_academico'=>$sol->espacio_academico,
                'codigo_espacio_academico'=>$sol->codigo_espacio_academico,'id_docente'=>$sol->id_docente_responsable];
		
                $f_sal_reg[$contador-1] =['fecha_salida'=>$this->obtenerFechaEnLetra($sol->fecha_salida),
                                          'fecha_regreso'=>$this->obtenerFechaEnLetra($sol->fecha_regreso),
                                          'programa_academico'=>$sol->programa_academico,
                                          'id_proy'=>$sol->id];
            }
            else if($sol->tipo_ruta == 2){
                $list_valor_est_trans[$contador-1] = ['vlr_estimado_transporte'=>$sol->valor_estimado_transporte_ra, 
                                                      'id_proy'=>$sol->id];
                $list_vlr_trans_menor[$contador-1] = ['vlr_total_transporte_menor'=>$sol->costo_total_transporte_menor_ra, 
                                                    'id_proy'=>$sol->id];
                $list_viaticos_docente[$contador-1] = ['vlr_viaticos_docente'=>$sol->viaticos_docente_ra, 
                                                    'id_proy'=>$sol->id];
                $list_viaticos_estudiante[$contador-1] = ['vlr_viaticos_estudiantes'=>$sol->viaticos_estudiantes_ra, 
                                                    'id_proy'=>$sol->id];
                $list_vlr_materiales[$contador-1] = ['vlr_materiales'=>$sol->vlr_materiales_ra, 
                                                    'vlr_guias_baquianos'=>$sol->vlr_guias_baquianos_ra,
                                                    'vlr_otros_boletas'=>$sol->vlr_otros_boletas_ra, 
                                                    'total'=>$sol->vlr_otros_boletas_ra + $sol->vlr_guias_baquianos_ra + $sol->vlr_materiales_ra,
                                                    'id_proy'=>$sol->id];
                //$list_presupuesto_total[$contador-1] = ['total_presupuesto'=>$sol->total_presupuesto_ra, 
                //                                    'id_proy'=>$sol->id];     

                $valor_materiales = $sol->vlr_materiales_ra;
                $valor_boletas = $sol->vlr_otros_boletas_ra;
                $valor_baquianos =  $sol->vlr_guias_baquianos_ra;
                $viaticos_docente = $sol->viaticos_docente_ra;
                $viaticos_estudiante = $sol->viaticos_estudiantes_ra;
                $valor_est_trans = $sol->valor_estimado_transporte_ra;
                $transporte_menor = $sol->costo_total_transporte_menor_ra;
                $total_resolucion =  $valor_materiales + $valor_baquianos + $valor_boletas + $transporte_menor + $viaticos_docente + $viaticos_estudiante;
                $list_presupuesto_total[$contador-1] = ['total_presupuesto'=>$total_resolucion,//$sol->total_presupuesto_ra, 
                                                    'id_proy'=>$sol->id];
                $sumatoria_presupuesto+= $total_resolucion;   
                // $doce_pract_int[] =['id'=>$docente_resp->id,'full_name'=>$docente_resp->full_name,
                // 'email'=>$docente_resp->email,'celular'=>$docente_resp->celular];

                //$sumatoria_presupuesto = $sumatoria_presupuesto + $sol->total_presupuesto_ra;

                $espa_pract_int[] =['id_proy'=>$sol->id,'espacio_academico'=>$sol->espacio_academico,
                'codigo_espacio_academico'=>$sol->codigo_espacio_academico,'id_docente'=>$sol->id_docente_responsable];
 
                $f_sal_reg[$contador-1] =['fecha_salida'=>$this->obtenerFechaEnLetra($sol->fecha_salida),
                                          'fecha_regreso'=>$this->obtenerFechaEnLetra($sol->fecha_regreso),
                                          'programa_academico'=>$sol->programa_academico,
                                          'id_proy'=>$sol->id];
            }
            foreach($docentes_practica as $doc){
                if($doc->id == $sol->id){
                $total_asistentes[$contador-1] = ['id_proy'=>$sol->id,
                                                    'num_estudiantes'=>$sol->num_estudiantes,
                                                    'num_docentes'=>1 + $doc->total_docentes_apoyo + $pract_inte->cant_espa_aca];
            }
            }
            
            /*                                                
            foreach($docentes_practica as $item)
            {
                if($item->total_docentes_apoyo > 0)
                {
                        $total_asistentes[$contador-1] = ['id_proy'=>$sol->id,
                                                            'num_estudiantes'=>$sol->num_estudiantes,
                                                            'num_docentes'=>1 + $item->total_docentes_apoyo + $pract_inte->cant_espa_aca];
                       
                
                    /*if($item->id_tipo_personal_apoyo_1 == 1)
                    {
                        $total_asistentes[$contador-1] = ['id_proy'=>1 + $sol->id,
                                                            'num_estudiantes'=>1 + $sol->num_estudiantes,
                                                            'num_docentes'=>1 + $pract_inte->cant_espa_aca];
                    }
    
                    else if($item->id_tipo_personal_apoyo_1 == 2)
                    {
                        $total_asistentes[$contador-1] = ['id_proy'=>$sol->id,
                                                            'num_estudiantes'=>$sol->num_estudiantes,
                                                            'num_docentes'=>1 + 1 + $pract_inte->cant_espa_aca];
                    }   
    
                    else if($item->id_tipo_personal_apoyo_1 == 3)
                    {
                        $total_asistentes[$contador-1] = ['id_proy'=>$sol->id,
                                                            'num_estudiantes'=>$sol->num_estudiantes,
                                                            'num_docentes'=>1 + $pract_inte->cant_espa_aca];
                    }
    
                    if($item->id_tipo_personal_apoyo_2 == 1)
                    {
                        $total_asistentes[$contador-1] = ['id_proy'=>$sol->id,
                                                            'num_estudiantes'=>1 + $sol->num_estudiantes,
                                                            'num_docentes'=>1 + $pract_inte->cant_espa_aca];
                    }
    
                    else if($item->id_tipo_personal_apoyo_2 == 2)
                    {
                        $total_asistentes[$contador-1] = ['id_proy'=>$sol->id,
                                                            'num_estudiantes'=>$sol->num_estudiantes,
                                                            'num_docentes'=>1 + 1 + $pract_inte->cant_espa_aca];
                    }
    
                    else if($item->id_tipo_personal_apoyo_2 == 3)
                    {
                        $total_asistentes[$contador-1] = ['id_proy'=>$sol->id,
                                                            'num_estudiantes'=>$sol->num_estudiantes,
                                                            'num_docentes'=>1 + $pract_inte->cant_espa_aca];
                    }
                }
                else if($item->total_docentes_apoyo == 0)
                {
 
                    $total_asistentes[$contador-1] = ['id_proy'=>$sol->id,
                                                        'num_estudiantes'=>$sol->num_estudiantes,
                                                        'num_docentes'=>1 + $pract_inte->cant_espa_aca];
                }
            }*/ 
                                                                             
        }
        //dd($docentes_practica);
        //dd($total_asistentes); 
        $list_pract_inte=DB::table('practicas_integradas as prac_int')
        ->select('prac_int.id as id','prac_int.cant_espa_aca','prac_int.id_espa_aca_1','prac_int.id_espa_aca_2','prac_int.id_espa_aca_3',
                'prac_int.id_espa_aca_4','prac_int.id_espa_aca_5','prac_int.id_espa_aca_6','prac_int.id_espa_aca_7','prac_int.id_docen_espa_aca_1',
                'prac_int.id_docen_espa_aca_2','prac_int.id_docen_espa_aca_3','prac_int.id_docen_espa_aca_4','prac_int.id_docen_espa_aca_5',
                'prac_int.id_docen_espa_aca_6','prac_int.id_docen_espa_aca_7','proy_prel.practicas_integradas')
        ->join('proyeccion_preliminar as proy_prel','prac_int.id','proy_prel.id')
        ->join('solicitud_practica as sol_prac','proy_prel.id','sol_prac.id_proyeccion_preliminar')
        ->whereIn('sol_prac.id',$list_solic)->get();

        $cont_prac_int=0;

        foreach($list_pract_inte as $pract_inte)
        {
            switch($pract_inte->cant_espa_aca)
            {
                // case "0":
                //     $docente_resp=DB::table('users')
                //         ->select('id','email','celular',
                //         DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
                //         ->where('id',$solicitudes_practica[0]->id_docente_responsable)->first();
    
                //     $doce_pract_int[] =['id'=>$solicitudes_practica[0]->id_user,'full_name'=>$sol->full_name,
                //                         'email'=>$docente_resp->email,'celular'=>$docente_resp->celular,
                //                         ];
    
                //     $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica[0]->espacio_academico,
                //                 'codigo_espacio_academico'=>$solicitudes_practica[0]->codigo_espacio_academico];
    
                //     break;
                case "1":
		    $id_docente=$pract_inte->id_docen_espa_aca_1;
		    $id_proy=$pract_inte->id;
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)->first();
    
                    $doce_pract_int[] =['id'=>$docentes_pract_int->id,'full_name'=>$docentes_pract_int->full_name,
                                        'email'=>$docentes_pract_int->email,'celular'=>$docentes_pract_int->celular];
    
                    $pract_inte=DB::table('practicas_integradas as prac_int')
                            ->select('prac_int.id','e_aca.espacio_academico as espacio_academico','e_aca.codigo_espacio_academico as codigo_espacio_academico')
                            ->join('espacio_academico as e_aca','prac_int.id_espa_aca_1','=','e_aca.id')
                            ->where('prac_int.id',$pract_inte->id)
                            ->first();

                    //$id_docente=$pract_inte->id_docen_espa_aca_1;

                    $espa_pract_int[] =['id_proy'=>$pract_inte->id,'espacio_academico'=>$pract_inte->espacio_academico,
                                'codigo_espacio_academico'=>$pract_inte->codigo_espacio_academico,'id_docente'=>$id_docente];
                  
                    break;
                case "2":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $id_1 = $pract_inte->id_espa_aca_1;
                    $id_2 = $pract_inte->id_espa_aca_2;

                    $espa_aca = DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_1);

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_2));

                    $espa_aca = $espa_aca->get();
    
                    foreach($espa_aca as $item)
                    {
                        $cont_prac_int++;
                        $id_docente=0;

                        switch($cont_prac_int)
                        {
                            case 1:
                                $id_docente=$pract_inte->id_docen_espa_aca_1;
                                break;
                            case 2:
                                $id_docente=$pract_inte->id_docen_espa_aca_2;
                                break;
                            case 3:
                                $id_docente=$pract_inte->id_docen_espa_aca_3;
                                break;
                            case 4:
                                $id_docente=$pract_inte->id_docen_espa_aca_4;
                                break;
                            case 5:
                                $id_docente=$pract_inte->id_docen_espa_aca_5;
                                break;
                            case 6:
                                $id_docente=$pract_inte->id_docen_espa_aca_6;
                                break;
                            case 7:
                                $id_docente=$pract_inte->id_docen_espa_aca_7;
                                break;
                        }

                        $espa_pract_int[] =['id_proy'=>$pract_inte->id,'espacio_academico'=>$item->espacio_academico,
                                'codigo_espacio_academico'=>$item->codigo_espacio_academico,'id_docente'=>$id_docente];
                    }
    
                    break;
                case "3":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $id_1 = $pract_inte->id_espa_aca_1;
                    $id_2 = $pract_inte->id_espa_aca_2;
                    $id_3 = $pract_inte->id_espa_aca_3;

                    $espa_aca = DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_1);

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_2));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_3));

                    $espa_aca = $espa_aca->get();
    
                    foreach($espa_aca as $item)
                    {
                        $cont_prac_int++;
                        $id_docente=0;

                        switch($cont_prac_int)
                        {
                            case 1:
                                $id_docente=$pract_inte->id_docen_espa_aca_1;
                                break;
                            case 2:
                                $id_docente=$pract_inte->id_docen_espa_aca_2;
                                break;
                            case 3:
                                $id_docente=$pract_inte->id_docen_espa_aca_3;
                                break;
                            case 4:
                                $id_docente=$pract_inte->id_docen_espa_aca_4;
                                break;
                            case 5:
                                $id_docente=$pract_inte->id_docen_espa_aca_5;
                                break;
                            case 6:
                                $id_docente=$pract_inte->id_docen_espa_aca_6;
                                break;
                            case 7:
                                $id_docente=$pract_inte->id_docen_espa_aca_7;
                                break;
                        }

                        $espa_pract_int[] =['id_proy'=>$pract_inte->id,'espacio_academico'=>$item->espacio_academico,
                                'codigo_espacio_academico'=>$item->codigo_espacio_academico,'id_docente'=>$id_docente];
                    }
    
                    break;
                case "4":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_4)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $id_1 = $pract_inte->id_espa_aca_1;
                    $id_2 = $pract_inte->id_espa_aca_2;
                    $id_3 = $pract_inte->id_espa_aca_3;
                    $id_4 = $pract_inte->id_espa_aca_4;

                    $espa_aca = DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_1);

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_2));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_3));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_4));

                    $espa_aca = $espa_aca->get();

    
                    foreach($espa_aca as $item)
                    {
                        $cont_prac_int++;
                        $id_docente=0;

                        switch($cont_prac_int)
                        {
                            case 1:
                                $id_docente=$pract_inte->id_docen_espa_aca_1;
                                break;
                            case 2:
                                $id_docente=$pract_inte->id_docen_espa_aca_2;
                                break;
                            case 3:
                                $id_docente=$pract_inte->id_docen_espa_aca_3;
                                break;
                            case 4:
                                $id_docente=$pract_inte->id_docen_espa_aca_4;
                                break;
                            case 5:
                                $id_docente=$pract_inte->id_docen_espa_aca_5;
                                break;
                            case 6:
                                $id_docente=$pract_inte->id_docen_espa_aca_6;
                                break;
                            case 7:
                                $id_docente=$pract_inte->id_docen_espa_aca_7;
                                break;
                        }

                        $espa_pract_int[] =['id_proy'=>$pract_inte->id,'espacio_academico'=>$item->espacio_academico,
                                'codigo_espacio_academico'=>$item->codigo_espacio_academico,'id_docente'=>$id_docente];
                    }
    
                    break;
                case "5":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_5)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $id_1 = $pract_inte->id_espa_aca_1;
                    $id_2 = $pract_inte->id_espa_aca_2;
                    $id_3 = $pract_inte->id_espa_aca_3;
                    $id_4 = $pract_inte->id_espa_aca_4;
                    $id_5 = $pract_inte->id_espa_aca_5;

                    $espa_aca = DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_1);

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_2));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_3));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_4));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_5));

                    $espa_aca = $espa_aca->get();

    
                    foreach($espa_aca as $item)
                    {
                        $cont_prac_int++;
                        $id_docente=0;

                        switch($cont_prac_int)
                        {
                            case 1:
                                $id_docente=$pract_inte->id_docen_espa_aca_1;
                                break;
                            case 2:
                                $id_docente=$pract_inte->id_docen_espa_aca_2;
                                break;
                            case 3:
                                $id_docente=$pract_inte->id_docen_espa_aca_3;
                                break;
                            case 4:
                                $id_docente=$pract_inte->id_docen_espa_aca_4;
                                break;
                            case 5:
                                $id_docente=$pract_inte->id_docen_espa_aca_5;
                                break;
                        }

                        $espa_pract_int[] =['id_proy'=>$pract_inte->id,'espacio_academico'=>$item->espacio_academico,
                                'codigo_espacio_academico'=>$item->codigo_espacio_academico,'id_docente'=>$id_docente];
                    }
    
                    break;
                case "6":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_5)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_6)->get();

                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
                    break;
    
                    $id_1 = $pract_inte->id_espa_aca_1;
                    $id_2 = $pract_inte->id_espa_aca_2;
                    $id_3 = $pract_inte->id_espa_aca_3;
                    $id_4 = $pract_inte->id_espa_aca_4;
                    $id_5 = $pract_inte->id_espa_aca_5;
                    $id_6 = $pract_inte->id_espa_aca_6;

                    $espa_aca = DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_1);

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_2));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_3));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_4));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_5));

                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_6));

                    $espa_aca = $espa_aca->get();

    
                            foreach($espa_aca as $item)
                            {
                                $cont_prac_int++;
                                $id_docente=0;
        
                                switch($cont_prac_int)
                                {
                                    case 1:
                                        $id_docente=$pract_inte->id_docen_espa_aca_1;
                                        break;
                                    case 2:
                                        $id_docente=$pract_inte->id_docen_espa_aca_2;
                                        break;
                                    case 3:
                                        $id_docente=$pract_inte->id_docen_espa_aca_3;
                                        break;
                                    case 4:
                                        $id_docente=$pract_inte->id_docen_espa_aca_4;
                                        break;
                                    case 5:
                                        $id_docente=$pract_inte->id_docen_espa_aca_5;
                                        break;
                                    case 6:
                                        $id_docente=$pract_inte->id_docen_espa_aca_6;
                                        break;
                                }
        
                                $espa_pract_int[] =['id_proy'=>$pract_inte->id,'espacio_academico'=>$item->espacio_academico,
                                        'codigo_espacio_academico'=>$item->codigo_espacio_academico,'id_docente'=>$id_docente];
                            }
    
                case "7":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre,  users.primer_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_5)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_6)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_7)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    /*$espa_aca=DB::table('espacio_academico as espa_aca')
                            ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                            // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                            // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                            ->where('id',$pract_inte->id_espa_aca_1)
                            ->orWhere('id',$pract_inte->id_espa_aca_2)
                            ->orWhere('id',$pract_inte->id_espa_aca_3)
                            ->orWhere('id',$pract_inte->id_espa_aca_4)
                            ->orWhere('id',$pract_inte->id_espa_aca_5)
                            ->orWhere('id',$pract_inte->id_espa_aca_6)
                            ->orWhere('id',$pract_inte->id_espa_aca_7)->get();*/
                    $id_1 = $pract_inte->id_espa_aca_1;
                    $id_2 = $pract_inte->id_espa_aca_2;
                    $id_3 = $pract_inte->id_espa_aca_3;
                    $id_4 = $pract_inte->id_espa_aca_4;
                    $id_5 = $pract_inte->id_espa_aca_5;
                    $id_6 = $pract_inte->id_espa_aca_6;
                    $id_7 = $pract_inte->id_espa_aca_7;
                    
                    $espa_aca = DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_1);
                    
                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_2));
                    
                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_3));
                    
                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_4));
                    
                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_5));
                    
                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_6));
                    
                    $espa_aca = $espa_aca->unionAll(DB::table('espacio_academico as espa_aca')
                        ->select('espacio_academico', 'codigo_espacio_academico')
                        ->where('id', $id_7));
                    
                    $espa_aca = $espa_aca->get();  
    
                    foreach($espa_aca as $item)
                    {
                        $cont_prac_int++;
                        $id_docente=0;

                        switch($cont_prac_int)
                        {
                            case 1:
                                $id_docente=$pract_inte->id_docen_espa_aca_1;
                                break;
                            case 2:
                                $id_docente=$pract_inte->id_docen_espa_aca_2;
                                break;
                            case 3:
                                $id_docente=$pract_inte->id_docen_espa_aca_3;
                                break;
                            case 4:
                                $id_docente=$pract_inte->id_docen_espa_aca_4;
                                break;
                            case 5:
                                $id_docente=$pract_inte->id_docen_espa_aca_5;
                                break;
                            case 6:
                                $id_docente=$pract_inte->id_docen_espa_aca_6;
                                break;
                            case 7:
                                $id_docente=$pract_inte->id_docen_espa_aca_7;
                                break;
                        }

                        $espa_pract_int[] =['id_proy'=>$pract_inte->id,'espacio_academico'=>$item->espacio_academico,
                                'codigo_espacio_academico'=>$item->codigo_espacio_academico,'id_docente'=>$id_docente];
                    }
                    break;
                    
            }
            
        }
        //dd($espa_aca);
		$flag = true;
		$primary = null;
		$temp = [];
		
		foreach($doce_pract_int as $item){
			if ($flag){
				$primary = $item['id'];
				$flag = false;
				$temp[] = $item;
			} else {
				if ($primary <> $item['id'])
					$temp[] = $item;
			}
		}

		$doce_pract_int = $temp;        
        //dd($espa_pract_int);
        $f_resolucion=$this->obtenerFechaEnLetra($anio_resolucion);
        $f_plan_prac=$this->obtenerFechaEnLetra($anio_resolucion);
        $hoy=$this->obtenerFechaEnLetra($fecha_solicitud);
        $hoy_letras = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        if(empty($solicitudes_practica[0]->fecha_resolucion) || $solicitudes_practica[0]->fecha_resolucion == NULL)
        {
            $f_resolucion=['num'=>'___','mes'=>'_________','anio'=>'____'];
        }
        else if(!empty($solicitudes_practica[0]->fecha_resolucion) || $solicitudes_practica[0]->fecha_resolucion != NULL)
        {
            $f_resolucion=$this->obtenerFechaEnLetra($solicitudes_practica[0]->fecha_resolucion);
        }

        if(empty($solicitudes_practica[0]->fecha_acta_consejo_facultad) || $solicitudes_practica[0]->fecha_acta_consejo_facultad == NULL)
        {
            $f_plan_prac=['num'=>'___','mes'=>'_________','anio'=>'____'];
        }
        else if(!empty($solicitudes_practica[0]->fecha_acta_consejo_facultad) || $solicitudes_practica[0]->fecha_acta_consejo_facultad != NULL)
        {
            $f_plan_prac=$this->obtenerFechaEnLetra($solicitudes_practica[0]->fecha_acta_consejo_facultad);
        }
        $pdf = PDF::LoadView('documentacion.formatoResolucionExportar', $data,['parrafos_modificables'=>$parrafos_modificables,
                                'solicitud_practica'=>$solicitudes_practica,
                                'fecha_solicitud'=>$fecha_solicitud,
                                'anio_resolucion'=>$anio_resolucion,
                                'viaticos_docente'=>$list_viaticos_docente,
                                'viaticos_estudiante'=>$list_viaticos_estudiante,
                                'valor_est_trans'=>$list_valor_est_trans,
                                'vlr_materiales'=>$list_vlr_materiales,
                                'vlr_baquianos'=>$list_vlr_guias_baquianos,
                                'vlr_boletas'=>$list_vlr_boletas_otros,
                                'vlr_trans_menor'=>$list_vlr_trans_menor,
                                'presupuesto'=>$list_presupuesto_total,
                                'sumatoria_presupuesto'=>$sumatoria_presupuesto,
                                'doce_pract_int'=>$doce_pract_int,
                                'docentes_practica'=>$docentes_practica,
                                'espa_pract_int'=>$espa_pract_int,
                                'pract_inte'=>$pract_inte,
                                'decano'=>$decano,
                                'firma_lito'=>$firma_lito,
                                "hoy"=>$hoy,
                                "hoy_letras"=>$hoy_letras,
                                "f_resolucion"=>$f_resolucion,
                                "f_plan_prac"=>$f_plan_prac,
                                "f_sal_reg"=>$f_sal_reg,
                                "vlr_viaticos"=>$vlr_viaticos,
                                "total_asistentes"=>$total_asistentes,
                               "control_sistema"=> $control_sistema]);
        return $pdf->download('resolucion_solicitud.pdf');

        // return view('documentacion.formatoResolucionExportar', $data,['parrafos_modificables'=>$parrafos_modificables,
        //                         'solicitud_practica'=>$solicitudes_practica,
        //                         'fecha_solicitud'=>$fecha_solicitud,
        //                         'anio_resolucion'=>$anio_resolucion,
        //                         'viaticos_docente'=>$viaticos_docente,
        //                         'viaticos_estudiante'=>$viaticos_estudiante,
        //                         'valor_est_trans'=>$valor_est_trans,
        //                         'doce_pract_int'=>$doce_pract_int,
        //                         'costos_proyeccion'=>$costos_proyeccion,
        //                         'decano'=>$decano,
        //                         'firma_lito'=>$firma_lito,
        //                         "hoy"=>$hoy,
        //                         "f_resolucion"=>$f_resolucion,
        //                         "vlr_viaticos"=>$vlr_viaticos,]);
    }

    /**
     * Exportar solicitud de práctica
     * Formato .pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportFormatoPracticaPdf($ids)
    {

        // if(Auth::user()->id_role == 4)
        // {

            // $id=Crypt::decrypt($id);
            $id=explode(",",$ids);
            $total_asistentes = [];
            $mytime = Carbon::now('America/Bogota')->format('d-m-Y');
            $fecha_solicitud = $mytime;
            $consulta_solicitud=DB::table('solicitud_practica')->select('id', 'id_proyeccion_preliminar')->where('id', '=', $id)->first();
            //$consulta_solicitud=solicitud::where('id_proyeccion_preliminar',$id)->first();
            $docentes_practica=docentes_practica::where('id',$consulta_solicitud->id_proyeccion_preliminar)->first();
            //$docentes_practica=docentes_practica::where('id',$id)->first();
            // $consulta_docente = user::where('id',$consulta_solicitud->id_docente_creador)->first();
            $transporte_proyeccion = DB::table('transporte_proyeccion as transp_proy')
            ->where('transp_proy.id','=',$consulta_solicitud->id_proyeccion_preliminar)->first();
            
            $solicitudes_practica =DB::table('solicitud_practica as sol_prac')
            // $solicitudes_practica_aprob =DB::table('solicitud_practica as sol_prac')
            ->select('p_prel.id','p_aca.id as id_pro_aca','p_aca.programa_academico','e_aca.id as id_esp_aca','e_aca.espacio_academico', 'e_aca.codigo_espacio_academico',
                    'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'p_prel.anio_periodo',
                    'p_prel.destino_rp','p_prel.destino_ra','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp',
                    'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra',
                    'p_prel.duracion_num_dias_rp','c_proy.viaticos_docente_rp','c_proy.viaticos_estudiantes_rp','c_proy.total_presupuesto_rp',
                    'p_prel.duracion_num_dias_ra','c_proy.viaticos_docente_ra','c_proy.viaticos_estudiantes_ra','c_proy.total_presupuesto_ra',
                    'c_proy.valor_estimado_transporte_rp', 'c_proy.valor_estimado_transporte_ra','c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra',
                    'c_proy.vlr_otros_boletas_rp','c_proy.vlr_otros_boletas_ra','c_proy.vlr_guias_baquianos_rp','c_proy.vlr_guias_baquianos_ra',
                    'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra',
                    'tip_vinc.tipo_vinculacion', 'users.celular', 'users.email','users.id as id_docente_responsable',
                    'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo',
                    'p_prel.cantidad_grupos', 'sol_prac.fecha_salida','sol_prac.fecha_regreso','sol_prac.duracion_num_dias',
                    'sol_prac.hora_salida','sol_prac.hora_regreso',
                    'transp.cant_transporte_rp', 'transp.cant_transporte_ra', 'sol_prac.cronograma', 'sol_prac.observaciones', 
                    'sol_prac.justificacion', 'sol_prac.objetivo_general', 'sol_prac.metodologia_evaluacion',
                    'sol_prac.tipo_ruta','sol_prac.id as id_solicitud', 'sol_prac.num_resolucion', 'sol_prac.id as id_solicitud', 
                    DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
            ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->join('costos_proyeccion as c_proy','sol_prac.id_proyeccion_preliminar','=','c_proy.id')
            ->join('docentes_practica as docen_pract','sol_prac.id_proyeccion_preliminar','=','docen_pract.id')
            ->join('users','p_prel.id_docente_responsable','=','users.id')
            ->join('periodo_academico as per_aca','p_prel.id_periodo_academico','=','per_aca.id')
            ->join('semestre_asignatura as sem_asig','p_prel.id_semestre_asignatura','=','sem_asig.id')
            ->join('tipo_vinculacion as tip_vinc','users.id_tipo_vinculacion','=','tip_vinc.id')
            ->join('transporte_proyeccion as transp','p_prel.id','=','transp.id')
            // ->where('id_estado_solicitud_practica','=',5)
            ->where('sol_prac.aprobacion_decano','=',7)
            // ->where('si_capital','=',1)
            // ->where('tiene_resolucion','=',1)
            ->where('sol_prac.id','=',$id)->first();

            $practicas_integradas=DB::table('practicas_integradas as prac_int')
                            ->where('prac_int.id',$solicitudes_practica->id)
                            ->first();
            
            $tipo_transporte = new stdClass;
            $tipo_transporte_1 = new stdClass;
            $tipo_transporte_2 = new stdClass;
            $tipo_transporte_3 = new stdClass;

            if($solicitudes_practica->tipo_ruta == 1)
            {
                $t_transporte = DB::table('transporte_proyeccion as trans')
                            ->select('tip_transp_1.tipo_transporte as tp_1','tip_transp_2.tipo_transporte as tp_2','tip_transp_3.tipo_transporte as tp_3',
                            'trans.capac_transporte_rp_1 as cp_1','trans.capac_transporte_rp_2 as cp_2','trans.capac_transporte_rp_3 as cp_3')
                            ->join('tipo_transporte as tip_transp_1','trans.id_tipo_transporte_rp_1','tip_transp_1.id')
                            ->leftjoin('tipo_transporte as tip_transp_2','trans.id_tipo_transporte_rp_2','tip_transp_2.id')
                            ->leftjoin('tipo_transporte as tip_transp_3','trans.id_tipo_transporte_rp_3','tip_transp_3.id')
                            ->where('trans.id',$solicitudes_practica->id)->first();

                if($t_transporte == NULL)
                {
                    $t_transporte = DB::table('transporte_proyeccion as trans')
                            ->where('trans.id',$id)->first();
                    $t_transporte->tp_1 ='N/A';            
                    $t_transporte->tp_2 ='N/A';   
                    $t_transporte->tp_3 ='N/A';    

                    $t_transporte->cp_1 =0;            
                    $t_transporte->cp_2 =0;   
                    $t_transporte->cp_3 =0;   
                }

                switch($transporte_proyeccion->cant_transporte_rp)
                {
                    case 0:
                        
                        $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_1)->first();
                        
                        $tipo_transporte->tipo = 'N/A';
                        $tipo_transporte->capacidad = 0;
                        break;
                    case 1:
                        
                        $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_1)->first();
                        
                        $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte;
                        $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_rp_1;
                        break;
                    case 2:
                        $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_1)->first();
                        
                        $tipo_transporte_2 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_2)->first();

                        $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte . " | " . $tipo_transporte_2->tipo_transporte;
                        $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_rp_1 . " | " . $transporte_proyeccion->capac_transporte_rp_2;
                        break;
                    case 3:
                        $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_1)->first();
                        
                        $tipo_transporte_2 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_2)->first();
                    
                        $tipo_transporte_3 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_3)->first();
                        
                        $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte . " | " . $tipo_transporte_2->tipo_transporte . " | " . $tipo_transporte_3->tipo_transporte;
                        $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_rp_1 . " | " . $transporte_proyeccion->capac_transporte_rp_2 . " | " . $transporte_proyeccion->capac_transporte_rp_3;

                        break;
                    
                }
            }
            else if($solicitudes_practica->tipo_ruta == 2)
            {

                $t_transporte = DB::table('transporte_proyeccion as trans')
                            ->select('tip_transp_1.tipo_transporte as tp_1','tip_transp_2.tipo_transporte as tp_2','tip_transp_3.tipo_transporte as tp_3',
                            'trans.capac_transporte_ra_1 as cp_1','trans.capac_transporte_ra_2 as cp_2','trans.capac_transporte_ra_3 as cp_3')
                            ->join('tipo_transporte as tip_transp_1','trans.id_tipo_transporte_ra_1','tip_transp_1.id')
                            ->leftjoin('tipo_transporte as tip_transp_2','trans.id_tipo_transporte_ra_2','tip_transp_2.id')
                            ->leftjoin('tipo_transporte as tip_transp_3','trans.id_tipo_transporte_ra_3','tip_transp_3.id')
                            ->where('trans.id',$id)->first();

                if($t_transporte == NULL)
                {
                    $t_transporte = DB::table('transporte_proyeccion as trans')
                            ->where('trans.id',$id)->first();
                    $t_transporte->tp_1 ='N/A';            
                    $t_transporte->tp_2 ='N/A';   
                    $t_transporte->tp_3 ='N/A';    

                    $t_transporte->cp_1 =0;            
                    $t_transporte->cp_2 =0;   
                    $t_transporte->cp_3 =0;   
                }

                switch($transporte_proyeccion->cant_transporte_ra)
                {
                    case 0:
                        
                        $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_1)->first();
                        
                        $tipo_transporte->tipo = 'N/A';
                        $tipo_transporte->capacidad = 0;
                        break;
                    case 1:
                        $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_1)->first();
                        
                        $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte;
                        $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_ra_1 ;
                        
                        break;
                    case 2:
                        $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_1)->first();
                    
                        $tipo_transporte_2 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_2)->first();
                        
                        $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte . " | " . $tipo_transporte_2->tipo_transporte;
                        $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_ra_1 . " | " . $transporte_proyeccion->capac_transporte_ra_2 ;

                        break;
                    case 3:
                        $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_1)->first();
                        
                        $tipo_transporte_2 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_2)->first();
                    
                        $tipo_transporte_3 = DB::table('tipo_transporte as tip_transp')
                            ->select('tip_transp.tipo_transporte')
                            ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_3)->first();
                        
                        $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte . " | " . $tipo_transporte_2->tipo_transporte . " | " . $tipo_transporte_3->tipo_transporte;
                        $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_ra_1 . " | " . $transporte_proyeccion->capac_transporte_ra_2 . " | " . $transporte_proyeccion->capac_transporte_ra_3;

                        break;
                    default;
                }
            }

            $valor_diario = DB::table('control_sistema')->first();
            $id_solicitud = $solicitudes_practica->id_solicitud;

            $decano = DB::table('users')
                    ->select('users.firma_litografica','users.tiene_firma',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->join('roles as rol','users.id_role','rol.id')
                    ->where('id_estado','=',1)
                    ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();

            $id_pro_aca = $solicitudes_practica->id_pro_aca;
            $coord = DB::table('users')
                    ->select('users.firma_litografica','users.tiene_firma',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->join('roles as rol','users.id_role','rol.id')
                    ->where('rol.name','=',"Coordinador")->orWhere('rol.id','=',4)
                    ->where('id_estado','=',1)
                    ->where('id_programa_academico_coord','=',$id_pro_aca)->first();

            $docente_responsable = DB::table('users')
                    ->select('users.firma_litografica','users.tiene_firma',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->join('solicitud_practica as sol_prac','users.id','sol_prac.id_docente_creador')
                    ->join('roles as rol','users.id_role','rol.id')
                    ->where('id_estado','=',1)
                    ->where('users.id','=',$solicitudes_practica->id_docente_responsable)->orWhere('rol.id','=',2)->first();
            
            $valor_diario->vlr_estud_max = number_format($valor_diario->vlr_estud_max, 0, ',','.');
            $valor_diario->vlr_estud_min = number_format($valor_diario->vlr_estud_min, 0, ',','.');
            $valor_diario->vlr_docen_max = number_format($valor_diario->vlr_docen_max, 0, ',','.');
            $valor_diario->vlr_docen_min = number_format($valor_diario->vlr_docen_min, 0, ',','.');

            if($solicitudes_practica->tipo_ruta == 1){
                $valor_materiales = $solicitudes_practica->vlr_materiales_rp;
                $valor_boletas = $solicitudes_practica->vlr_otros_boletas_rp;
                $valor_baquianos = $solicitudes_practica->vlr_guias_baquianos_rp;
                $viaticos_docente = $solicitudes_practica->viaticos_docente_rp;
                $viaticos_estudiante = $solicitudes_practica->viaticos_estudiantes_rp;
                $valor_est_trans = $solicitudes_practica->valor_estimado_transporte_rp;
                $transporte_menor = $solicitudes_practica->costo_total_transporte_menor_rp;
                //$total_presupuesto = $solicitudes_practica->total_presupuesto_rp;
                $total_presupuesto = $valor_materiales + $valor_baquianos + $valor_boletas + $transporte_menor + $viaticos_docente + $viaticos_estudiante;
                
            }
            else if($solicitudes_practica->tipo_ruta == 2){
                $valor_materiales = $solicitudes_practica->vlr_materiales_ra;
                $valor_boletas = $solicitudes_practica->vlr_otros_boletas_ra;
                $valor_baquianos = $solicitudes_practica->vlr_guias_baquianos_ra;
                $viaticos_docente = $solicitudes_practica->viaticos_docente_ra;
                $viaticos_estudiante = $solicitudes_practica->viaticos_estudiantes_ra;
                $valor_est_trans = $solicitudes_practica->valor_estimado_transporte_ra;
                $transporte_menor = $solicitudes_practica->costo_total_transporte_menor_ra;
                //$total_presupuesto = $solicitudes_practica->total_presupuesto_ra;
                $total_presupuesto = $valor_materiales + $valor_baquianos + $valor_boletas + $transporte_menor + $viaticos_docente + $viaticos_estudiante;
            }
            $total_otros = $valor_materiales + $valor_boletas + $valor_baquianos;

            $estudiantes = DB::table('estudiantes_solicitud_practica as estud')
                            ->where('estud.id_solicitud_practica','=',$id_solicitud)->get();
                            
                        $docentes_acompaniantes = DB::table('docentes_practica as acompa')
			                ->select('acompa.id','acompa.total_docentes_apoyo','acompa.num_doc_docente_apoyo_1','acompa.num_doc_docente_apoyo_2',
									'acompa.num_doc_docente_apoyo_3','acompa.num_doc_docente_apoyo_4','acompa.num_doc_docente_apoyo_5',
									'acompa.num_doc_docente_apoyo_6','acompa.num_doc_docente_apoyo_7','acompa.num_doc_docente_apoyo_8',
									'acompa.num_doc_docente_apoyo_9','acompa.num_doc_docente_apoyo_10',
									'acompa.docente_apoyo_1','acompa.docente_apoyo_2','acompa.docente_apoyo_3','acompa.docente_apoyo_4',
									'acompa.docente_apoyo_5','acompa.docente_apoyo_6','acompa.docente_apoyo_7','acompa.docente_apoyo_8','acompa.docente_apoyo_9',
									'acompa.docente_apoyo_10')
									//'acompa.docente_apoyo_1','tp_p_apoyo_2.tipo_docente_apoyo as tp_p_apoyo_2','acompa.num_doc_docente_apoyo_2','acompa.docente_apoyo_2')
									//->select('acompa.id','acompa.total_docente_apoyo','tp_p_apoyo_1.tipo_docente_apoyo as tp_p_apoyo_1','acompa.num_doc_docente_apoyo_2',
									//'acompa.docente_apoyo_1','tp_p_apoyo_2.tipo_docente_apoyo as tp_p_apoyo_2','acompa.num_doc_docente_apoyo_2','acompa.docente_apoyo_2')
									//->join('tipo_docente_apoyo as tp_p_apoyo_1','acompa.id_tipo_docente_apoyo_1','tp_p_apoyo_1.id')
									//->join('tipo_docente_apoyo as tp_p_apoyo_2','acompa.id_tipo_docente_apoyo_2','tp_p_apoyo_2.id')
                            ->where('acompa.id','=',$solicitudes_practica->id)->first();

            if($docentes_practica->total_personal_apoyo > 0)
            {
		$total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
					'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
					'num_docentes'=> 1 + $docentes_practica->total_personal_apoyo ];			
                    
                    /* if($docentes_practica->id_tipo_personal_apoyo_1 == 1)
                    {
                            $total_asistentes[0] = ['id_proy'=>1 + $solicitudes_practica->id,
                                                    'num_estudiantes'=>1 + $solicitudes_practica->num_estudiantes,
                                                    'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
                    }

                    else if($docentes_practica->id_tipo_personal_apoyo_1 == 2)
                    {
                            $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                                    'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                                    'num_docentes'=>1 + 1 + $practicas_integradas->cant_espa_aca];
                    }

                    else if($docentes_practica->id_tipo_personal_apoyo_1 == 3)
                    {
                            $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                                    'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                                    'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
                    }

                    if($docentes_practica->id_tipo_personal_apoyo_2 == 1)
                    {
                            $total_asistentes[0]= ['id_proy'=>$solicitudes_practica->id,
                                                    'num_estudiantes'=>1 + $solicitudes_practica->num_estudiantes,
                                                    'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
                    }

                    else if($docentes_practica->id_tipo_personal_apoyo_2 == 2)
                    {
                            $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                                    'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                                    'num_docentes'=>1 + 1 + $practicas_integradas->cant_espa_aca];
                    }

                    else if($docentes_practica->id_tipo_personal_apoyo_2 == 3)
                    {
                            $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                                    'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                                    'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
                    } */
            }
            else if($docentes_practica->total_personal_apoyo == 0)
            {
                $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                        'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                        'num_docentes'=>1];
            }

            $acompa = [];

            if($docentes_acompaniantes->total_docentes_apoyo==0)
            {
                $acompa[] = ["nombre"=>"N/A",
                            "identificacion"=>"N/A",
                            "tipo"=>"N/A",
                            "num_apoyo"=>0];
            }
            if($docentes_acompaniantes->docente_apoyo_1!=Null)
            {
                $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_1,
                            "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_1,
                            "tipo"=>"Apoyo",
                            "num_apoyo"=>1];
            }
            if($docentes_acompaniantes->docente_apoyo_2!=Null)
            {
                $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_2,
                            "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_2,
                            "tipo"=>"Apoyo",
                            "num_apoyo"=>2];
            }
            if($docentes_acompaniantes->docente_apoyo_3!=Null)
             {
                
                 $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_3,
                             "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_3,
                             "tipo"=>"Apoyo",
                             "num_apoyo"=>3];
             }
             if($docentes_acompaniantes->docente_apoyo_4!=Null)
             {
                 $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_4,
                             "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_4,
                             "tipo"=>"Apoyo",
                             "num_apoyo"=>4];
             }
             if($docentes_acompaniantes->docente_apoyo_5!=Null)
             {
                 $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_5,
                             "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_5,
                             "tipo"=>"Apoyo",
                             "num_apoyo"=>5];
             }
             if($docentes_acompaniantes->docente_apoyo_6!=Null)
             {
                
                 $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_6,
                             "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_6,
                             "tipo"=>"Apoyo",
                             "num_apoyo"=>6];
             }
             if($docentes_acompaniantes->docente_apoyo_7!=Null)
             {
                 $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_7,
                             "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_7,
                             "tipo"=>"Apoyo",
                             "num_apoyo"=>7];
             }
             if($docentes_acompaniantes->docente_apoyo_8!=Null)
             {
                 $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_8,
                             "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_8,
                             "tipo"=>"Apoyo",
                             "num_apoyo"=>8];
             }
             if($docentes_acompaniantes->docente_apoyo_9!=Null)
             {
                
                 $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_9,
                             "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_9,
                             "tipo"=>"Apoyo",
                             "num_apoyo"=>9];
             }
             if($docentes_acompaniantes->docente_apoyo_10!=Null)
             {
                 $acompa[] = ["nombre"=>$docentes_acompaniantes->docente_apoyo_10,
                             "identificacion"=>$docentes_acompaniantes->num_doc_docente_apoyo_10,
                             "tipo"=>"Apoyo",
                             "num_apoyo"=>10];
             }
            
            $firma_lito_decano = "data:image/png;base64,$decano->firma_litografica";
            $firma_lito_coord = "data:image/png;base64,$coord->firma_litografica";
            $firma_lito_docente = "data:image/png;base64,$docente_responsable->firma_litografica";

            $hoy=$this->obtenerFechaEnLetra($fecha_solicitud);
            $f_salida=$this->obtenerFechaEnLetra($solicitudes_practica->fecha_salida);
            $f_regreso=$this->obtenerFechaEnLetra($solicitudes_practica->fecha_regreso);

            $doce_pract_int = [];
            $pract_inte=DB::table('practicas_integradas as prac_int')
                            ->where('prac_int.id',$solicitudes_practica->id)
                            ->first();

            $docente_resp=DB::table('users')
                        ->select('users.id','email','celular','tip_vinc.tipo_vinculacion as tipo_vinculacion',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
                        ->join('tipo_vinculacion as tip_vinc','users.id_tipo_vinculacion','=','tip_vinc.id')
                        ->where('users.id',$solicitudes_practica->id_docente_responsable)->first();

            $doce_pract_int[] =['id'=>$solicitudes_practica->id_docente_responsable,'full_name'=>$solicitudes_practica->full_name,
                                'email'=>$docente_resp->email,'celular'=>$docente_resp->celular, 'tipo_vinculacion'=>$docente_resp->tipo_vinculacion
                                ];

            if($pract_inte->cant_espa_aca == NULL)
            {
                $pract_inte->cant_espa_aca = 0;
            }

            switch($pract_inte->cant_espa_aca)
            {
                case "0":
                                $docente_resp=DB::table('users')
                                    ->select('users.id','email','celular','tp_vin.tipo_vinculacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
                                    ->join('tipo_vinculacion as tp_vin','users.id_tipo_vinculacion','tp_vin.id')
                                    ->where('users.id',$solicitudes_practica->id_docente_responsable)->first();
                
                                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                                            'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];
                
                                break;
                case "1":
                                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                                            'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

                                $docentes_pract_int=DB::table('users')
                                    ->select('users.id','email','celular','tp_vin.tipo_vinculacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                                    ->join('tipo_vinculacion as tp_vin','users.id_tipo_vinculacion','tp_vin.id')
                                    ->where('users.id',$pract_inte->id_docen_espa_aca_1)->first();
                
                                $doce_pract_int[] =['id'=>$docentes_pract_int->id,'full_name'=>$docentes_pract_int->full_name,
                                                    'email'=>$docentes_pract_int->email,'celular'=>$docentes_pract_int->celular,
                                                    'tipo_vinculacion'=>$docentes_pract_int->tipo_vinculacion];
                
                                $pract_inte=DB::table('practicas_integradas as prac_int')
                                        ->select('e_aca.espacio_academico as espacio_academico','e_aca.codigo_espacio_academico as codigo_espacio_academico')
                                        ->join('espacio_academico as e_aca','prac_int.id_espa_aca_1','=','e_aca.id')
                                        ->where('prac_int.id',$solicitudes_practica->id)
                                        ->first();
                
                                $espa_pract_int[] =['espacio_academico'=>$pract_inte->espacio_academico,
                                            'codigo_espacio_academico'=>$pract_inte->codigo_espacio_academico];
                                break;
                case "2":
                                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                                                        'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

                                $docentes_pract_int=DB::table('users')
                                    ->select('users.id','email','celular','tp_vin.tipo_vinculacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                                    ->join('tipo_vinculacion as tp_vin','users.id_tipo_vinculacion','tp_vin.id')
                                    ->where('users.id',$pract_inte->id_docen_espa_aca_1)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_2)->get(); 
                
                                foreach($docentes_pract_int as $item)
                                {
                                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                                        'email'=>$item->email,'celular'=>$item->celular,
                                                        'tipo_vinculacion'=>$item->tipo_vinculacion];
                                }
                
                                $espa_aca=DB::table('espacio_academico as espa_aca')
                                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                                        ->where('id',$pract_inte->id_espa_aca_1)
                                        ->orWhere('id',$pract_inte->id_espa_aca_2)->get();
                
                                foreach($espa_aca as $item)
                                {
                                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                                }
                
                                break;
                case "3":
                                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                                'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

                                $docentes_pract_int=DB::table('users')
                                    ->select('users.id','email','celular','tp_vin.tipo_vinculacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                                    ->join('tipo_vinculacion as tp_vin','users.id_tipo_vinculacion','tp_vin.id')
                                    ->where('users.id',$pract_inte->id_docen_espa_aca_1)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_2)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_3)->get();
                
                                foreach($docentes_pract_int as $item)
                                {
                                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                                        'email'=>$item->email,'celular'=>$item->celular,
                                                        'tipo_vinculacion'=>$item->tipo_vinculacion];
                                }
                
                                $espa_aca=DB::table('espacio_academico as espa_aca')
                                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                                        ->where('id',$pract_inte->id_espa_aca_1)
                                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                                        ->orWhere('id',$pract_inte->id_espa_aca_3)->get();
                
                                foreach($espa_aca as $item)
                                {
                                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                                }
                
                                break;
                case "4":
                                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                                'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

                                $docentes_pract_int=DB::table('users')
                                    ->select('users.id','users.email','users.celular','tp_vin.tipo_vinculacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                                    ->join('tipo_vinculacion as tp_vin','users.id_tipo_vinculacion','tp_vin.id')
                                    ->where('users.id',$pract_inte->id_docen_espa_aca_1)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_2)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_3)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_4)->get();
                
                                foreach($docentes_pract_int as $item)
                                {
                                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                                        'email'=>$item->email,'celular'=>$item->celular,
                                                        'tipo_vinculacion'=>$item->tipo_vinculacion];
                                }
                
                                $espa_aca=DB::table('espacio_academico as espa_aca')
                                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                                        ->where('id',$pract_inte->id_espa_aca_1)
                                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                                        ->orWhere('id',$pract_inte->id_espa_aca_3)
                                        ->orWhere('id',$pract_inte->id_espa_aca_4)->get();
                
                                foreach($espa_aca as $item)
                                {
                                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                                }
                
                                break;
                case "5":
                                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                                            'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

                                $docentes_pract_int=DB::table('users')
                                    ->select('users.id','users.email','users.celular','tp_vin.tipo_vinculacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                                    ->join('tipo_vinculacion as tp_vin','users.id_tipo_vinculacion','tp_vin.id')
                                    ->where('users.id',$pract_inte->id_docen_espa_aca_1)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_2)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_3)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_4)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_5)->get();
                
                                foreach($docentes_pract_int as $item)
                                {
                                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                                        'email'=>$item->email,'celular'=>$item->celular,
                                                        'tipo_vinculacion'=>$item->tipo_vinculacion];
                                }
                
                                $espa_aca=DB::table('espacio_academico as espa_aca')
                                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                                        ->where('id',$pract_inte->id_espa_aca_1)
                                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                                        ->orWhere('id',$pract_inte->id_espa_aca_3)
                                        ->orWhere('id',$pract_inte->id_espa_aca_4)
                                        ->orWhere('id',$pract_inte->id_espa_aca_5)->get();
                
                                foreach($espa_aca as $item)
                                {
                                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                                }
                
                                break;
                case "6":
                                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                                'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

                                $docentes_pract_int=DB::table('users')
                                    ->select('users.id','users.email','users.celular','tp_vin.tipo_vinculacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                                    ->join('tipo_vinculacion as tp_vin','users.id_tipo_vinculacion','tp_vin.id')
                                    ->where('users.id',$pract_inte->id_docen_espa_aca_1)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_2)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_3)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_4)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_5)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_6)->get();
                
                                foreach($docentes_pract_int as $item)
                                {
                                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                                        'email'=>$item->email,'celular'=>$item->celular,
                                                        'tipo_vinculacion'=>$item->tipo_vinculacion];
                                }
                                break;
                
                                $espa_aca=DB::table('espacio_academico as espa_aca')
                                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                                        ->where('id',$pract_inte->id_espa_aca_1)
                                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                                        ->orWhere('id',$pract_inte->id_espa_aca_3)
                                        ->orWhere('id',$pract_inte->id_espa_aca_4)
                                        ->orWhere('id',$pract_inte->id_espa_aca_5)
                                        ->orWhere('id',$pract_inte->id_espa_aca_6)->get();
                
                                foreach($espa_aca as $item)
                                {
                                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                                }
                
                case "7":
                                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                                'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

                                $docentes_pract_int=DB::table('users')
                                    ->select('users.id','users.email','users.celular','tp_vin.tipo_vinculacion',
                                    DB::raw('CONCAT_WS(" ",users.primer_nombre,  users.primer_apellido) as full_name'))
                                    ->join('tipo_vinculacion as tp_vin','users.id_tipo_vinculacion','tp_vin.id')
                                    ->where('users.id',$pract_inte->id_docen_espa_aca_1)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_2)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_3)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_4)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_5)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_6)
                                    ->orWhere('users.id',$pract_inte->id_docen_espa_aca_7)->get();
                
                                foreach($docentes_pract_int as $item)
                                {
                                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                                        'email'=>$item->email,'celular'=>$item->celular,
                                                        'tipo_vinculacion'=>$item->tipo_vinculacion];
                                }
                
                                $espa_aca=DB::table('espacio_academico as espa_aca')
                                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                                        ->where('id',$pract_inte->id_espa_aca_1)
                                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                                        ->orWhere('id',$pract_inte->id_espa_aca_3)
                                        ->orWhere('id',$pract_inte->id_espa_aca_4)
                                        ->orWhere('id',$pract_inte->id_espa_aca_5)
                                        ->orWhere('id',$pract_inte->id_espa_aca_6)
                                        ->orWhere('id',$pract_inte->id_espa_aca_7)->get();
                
                
                            foreach($espa_aca as $item)
                                {
                                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                                }
                                break;
            }

            $num_apoyo = $docentes_acompaniantes->total_docentes_apoyo;

            $data = ['title' => 'Formato Solicitud Práctica'];
            $pdf = PDF::LoadView('documentacion.formatoPractica', $data,[
                                'solicitud_practica'=>$solicitudes_practica,
                                'practicas_integradas'=>$practicas_integradas,
                                'docentes_practica'=>$docentes_practica,
                                'doce_pract_int'=>$doce_pract_int,
                                'espa_pract_int'=>$espa_pract_int,
                                'fecha_solicitud'=>$fecha_solicitud,
                                'valor_diario'=>$valor_diario,
                                'viaticos_docente'=>$viaticos_docente,
                                'viaticos_estudiante'=>$viaticos_estudiante,
                                'valor_est_trans'=>$valor_est_trans,
                                'valor_materiales'=>$valor_materiales,
                                'valor_baquianos'=>$valor_baquianos,
                                'valor_boletas'=>$valor_boletas,
                                'transporte_menor'=>$transporte_menor,
                                'presupuesto'=>$total_presupuesto,
                                'total_otros'=>$total_otros,
                                'estudiantes'=>$estudiantes,
                                'firma_lito_coord'=>$firma_lito_coord,
                                'firma_lito_decano'=>$firma_lito_decano,
                                'firma_lito_docente'=>$firma_lito_docente,
                                'docente_responsable'=>$docente_responsable,
                                'transporte_proyeccion'=>$transporte_proyeccion,
                                'tipo_transporte'=>$tipo_transporte,
                                't_transporte'=>$t_transporte,
                                'acompaniantes'=>$acompa,
                                'num_apoyo'=>$num_apoyo,
                                'total_asistentes'=>$total_asistentes,
                                'hoy'=>$hoy,
                                'f_salida'=>$f_salida,
                                'f_regreso'=>$f_regreso]);

            $pdf->setPaper('letter');

            return $pdf->download('formatoPractica.pdf');

            // return view('documentacion.formatoPractica', [
            //     'solicitud_practica'=>$solicitudes_practica,
            //     'practicas_integradas'=>$practicas_integradas,
            //     'docentes_practica'=>$docentes_practica,
            //     'doce_pract_int'=>$doce_pract_int,
            //     'espa_pract_int'=>$espa_pract_int,
            //     'fecha_solicitud'=>$fecha_solicitud,
            //     'valor_diario'=>$valor_diario,
            //     'viaticos_docente'=>$viaticos_docente,
            //     'viaticos_estudiante'=>$viaticos_estudiante,
            //     'valor_est_trans'=>$valor_est_trans,
            //     'valor_materiales'=>$valor_materiales,
            //     'valor_baquianos'=>$valor_baquianos,
            //     'valor_boletas'=>$valor_boletas,
            //     'transporte_menor'=>$transporte_menor,
            //     'presupuesto'=>$total_presupuesto,
            //     'total_otros'=>$total_otros,
            //     'estudiantes'=>$estudiantes,
            //     'firma_lito_coord'=>$firma_lito_coord,
            //     'firma_lito_decano'=>$firma_lito_decano,
            //     'firma_lito_docente'=>$firma_lito_docente,
            //     'docente_responsable'=>$docente_responsable,
            //     'transporte_proyeccion'=>$transporte_proyeccion,
            //     'tipo_transporte'=>$tipo_transporte,
            //     't_transporte'=>$t_transporte,
            //     'acompaniantes'=>$acompa,
            //     'num_apoyo'=>$num_apoyo,
            //     'total_asistentes'=>$total_asistentes,
            //     'hoy'=>$hoy,
            //     'f_salida'=>$f_salida,
            //     'f_regreso'=>$f_regreso]);
        // }
        // else if(Auth::user()->id_role == 3 || Auth::user()->id_role == 2 || Auth::user()->id_role == 1)
        // {
        //     $id=explode(",",$ids);

        //     $docentes_practica= DB::table('docentes_practica as doc_prac')
        //     ->select('doc_prac.id','doc_prac.soporte_formato_avance','doc_prac.soporte_formato_practica',
        //     'doc_prac.tiene_soporte_avance','doc_prac.tiene_soporte_practica')
        //     ->join('solicitud_practica as sol_prac','doc_prac.id','sol_prac.id_proyeccion_preliminar')
        //     ->where('sol_prac.id',$ids)->first();
            
        //     $fmt_practica = $docentes_practica->soporte_formato_practica;
        //     $dwn_practica = base64_decode($fmt_practica);

        //     $file = 'practica.pdf';
        //     file_put_contents($file, $dwn_practica);

        //     if (file_exists($file)) {
        //         header('Content-Description: File Transfer');
        //         header('Content-Type: application/octet-stream');
        //         header('Content-Disposition: attachment; filename="'.basename($file).'"');
        //         header('Expires: 0');
        //         header('Cache-Control: must-revalidate');
        //         header('Pragma: public');
        //         header('Content-Length: ' . filesize($file));
        //         readfile($file);
        //         exit;
        //     }
        //     // return response()->download($dwn_avance);
        // }    

    }

    /**
     * Exportar solicitud de transporte
     * Formato .pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportTransportePdf($ids)
    {
        // $id=Crypt::decrypt($id);
        $id=explode(",",$ids);
        $data = ['title' => 'Solicitud Transporte'];
        $total_asistentes = [];
        
        $parrafos_modificables =DB::table('resolucion')->first();
        $fecha_solicitud = Carbon::now('America/Bogota')->format('d-m-Y');
        $transporte_proyeccion = DB::table('transporte_proyeccion as transp_proy')
        ->where('transp_proy.id','=',$id)->first();
        $practicas_integradas = DB::table('practicas_integradas')
        ->where('id','=',$id)->first();
        $docentes_practica = DB::table('docentes_practica')
        ->where('id','=',$id)->first();
        $solicitudes_practica =DB::table('solicitud_practica as sol_prac')
        // $solicitudes_practica_aprob =DB::table('solicitud_practica as sol_prac')
        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico', 'e_aca.codigo_espacio_academico',
                'per_aca.periodo_academico','p_prel.anio_periodo','sem_asig.semestre_asignatura',
                'p_prel.destino_rp','p_prel.destino_ra','p_prel.det_recorrido_interno_rp','p_prel.det_recorrido_interno_ra',
                'p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp', 'sol_prac.hora_salida','sol_prac.hora_regreso',
                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra', 'sol_prac.hora_salida','sol_prac.hora_regreso',
                'p_prel.id_docente_responsable','docen_pract.docente_apoyo_1',
                'p_prel.duracion_num_dias_rp','c_proy.viaticos_docente_rp','c_proy.viaticos_estudiantes_rp','c_proy.total_presupuesto_rp',
                'p_prel.duracion_num_dias_ra','c_proy.viaticos_docente_ra','c_proy.viaticos_estudiantes_ra','c_proy.total_presupuesto_ra',
                'c_proy.valor_estimado_transporte_rp', 'c_proy.valor_estimado_transporte_ra',
                'tip_vinc.tipo_vinculacion', 'users.celular', DB::raw('SUBSTRING_INDEX(users.email,"@",-1) as dominio'),
                DB::raw('SUBSTRING_INDEX(users.email,"@",1) as email'),
                'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo',
                'p_prel.cantidad_grupos', 'sol_prac.fecha_salida','sol_prac.fecha_regreso','sol_prac.duracion_num_dias',
                'transp.cant_transporte_rp', 'transp.cant_transporte_ra', 'transp.det_tipo_transporte_rp_1', 'transp.det_tipo_transporte_ra_1', 
                'transp.exclusiv_tiempo_rp_1', 'transp.exclusiv_tiempo_ra_1','sol_prac.cronograma', 'sol_prac.observaciones', 
                'sol_prac.justificacion', 'sol_prac.objetivo_general', 'sol_prac.metodologia_evaluacion',
                'sol_prac.tipo_ruta','sol_prac.id as id_solicitud', 'sol_prac.num_resolucion','sol_prac.fecha_resolucion',
                'sol_prac.num_cdp', 'p_prel.num_acta_consejo_facultad', 'p_prel.fecha_acta_consejo_facultad',
                'salida_rp.sede as sede_salida_rp',
                'regreso_rp.sede as sede_regreso_rp','salida_ra.sede as sede_salida_ra','regreso_ra.sede as sede_regreso_ra', 
                'salida_rp.direccion as direccion_salida_rp','regreso_rp.direccion as direccion_regreso_rp','salida_ra.direccion as direccion_salida_ra','regreso_ra.direccion as direccion_regreso_ra',
                'tip_ident.tipo_identificacion','users.id as id_docente_responsable', 'tip_ident.sigla',
                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
        ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
        ->join('costos_proyeccion as c_proy','sol_prac.id_proyeccion_preliminar','=','c_proy.id')
        ->join('docentes_practica as docen_pract','sol_prac.id_proyeccion_preliminar','=','docen_pract.id')
        ->join('users','p_prel.id_docente_responsable','=','users.id')
        ->join('periodo_academico as per_aca','p_prel.id_periodo_academico','=','per_aca.id')
        ->join('semestre_asignatura as sem_asig','p_prel.id_semestre_asignatura','=','sem_asig.id')
        ->join('tipo_vinculacion as tip_vinc','users.id_tipo_vinculacion','=','tip_vinc.id')
        ->join('tipo_identificacion as tip_ident','users.id_tipo_identificacion','=','tip_ident.id')
        ->join('transporte_proyeccion as transp','p_prel.id','=','transp.id')
        ->join('sedes_universidad as salida_rp','p_prel.lugar_salida_rp','=','salida_rp.id')
        ->join('sedes_universidad as regreso_rp','p_prel.lugar_regreso_rp','=','regreso_rp.id')
        ->join('sedes_universidad as salida_ra','p_prel.lugar_salida_ra','=','salida_ra.id')
        ->join('sedes_universidad as regreso_ra','p_prel.lugar_regreso_ra','=','regreso_ra.id')
        ->where('id_estado_solicitud_practica','=',3)
        // ->where('si_capital','=',1)
        // ->where('tiene_resolucion','=',1)
        ->where('sol_prac.id','=',$id)->first();

        $decano = DB::table('users')
                ->select('users.firma_litografica','users.tiene_firma',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();

        $tipo_transporte = new stdClass;
        $tipo_transporte_1 = new stdClass;
        $tipo_transporte_2 = new stdClass;
        $tipo_transporte_3 = new stdClass;

        if($solicitudes_practica->tipo_ruta == 1)
        {
            $viaticos_docente = $solicitudes_practica->viaticos_docente_rp;
            $viaticos_estudiante = $solicitudes_practica->viaticos_estudiantes_rp;
            $valor_est_trans = $solicitudes_practica->valor_estimado_transporte_rp;
            $detalle_recorrido = $solicitudes_practica->det_recorrido_interno_rp;

            $t_transporte = DB::table('transporte_proyeccion as trans')
                        ->select('tip_transp_1.tipo_transporte as tp_1','tip_transp_2.tipo_transporte as tp_2','tip_transp_3.tipo_transporte as tp_3',
                        'trans.capac_transporte_rp_1 as cp_1','trans.capac_transporte_rp_2 as cp_2','trans.capac_transporte_rp_3 as cp_3')
                        ->join('tipo_transporte as tip_transp_1','trans.id_tipo_transporte_rp_1','tip_transp_1.id')
                        ->leftjoin('tipo_transporte as tip_transp_2','trans.id_tipo_transporte_rp_2','tip_transp_2.id')
                        ->leftjoin('tipo_transporte as tip_transp_3','trans.id_tipo_transporte_rp_3','tip_transp_3.id')
                        ->where('trans.id',$id)->first();

            if($t_transporte == NULL)
            {
                $t_transporte = DB::table('transporte_proyeccion as trans')
                        ->where('trans.id',$id)->first();
                $t_transporte->tp_1 ='N/A';            
                $t_transporte->tp_2 ='N/A';   
                $t_transporte->tp_3 ='N/A';    

                $t_transporte->cp_1 =0;            
                $t_transporte->cp_2 =0;   
                $t_transporte->cp_3 =0;   
            }            

            switch($transporte_proyeccion->cant_transporte_rp)
            {
                case 0:
                    
                    $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_1)->first();
                    
                    $tipo_transporte->tipo = 'N/A';
                    $tipo_transporte->capacidad = 0;

                    $t_transporte->tp_1 ='N/A';            
                    $t_transporte->tp_2 ='N/A';   
                    $t_transporte->tp_3 ='N/A';    

                    $t_transporte->cp_1 =0;            
                    $t_transporte->cp_2 =0;   
                    $t_transporte->cp_3 =0; 
                    break;
                case 1:
                    
                    $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_1)->first();
                    
                    $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte;
                    $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_rp_1;

                    $t_transporte->tp_1 =$tipo_transporte_1->tipo_transporte;            
                    $t_transporte->tp_2 ='N/A';   
                    $t_transporte->tp_3 ='N/A';    

                    $t_transporte->cp_1 =$transporte_proyeccion->capac_transporte_rp_1;            
                    $t_transporte->cp_2 =0;   
                    $t_transporte->cp_3 =0; 

                    break;
                case 2:
                    $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_1)->first();
                    
                    $tipo_transporte_2 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_2)->first();

                    $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte . " | " . $tipo_transporte_2->tipo_transporte;
                    $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_rp_1 . " | " . $transporte_proyeccion->capac_transporte_rp_2;

                    $t_transporte->tp_1 =$tipo_transporte_1->tipo_transporte;            
                    $t_transporte->tp_2 =$tipo_transporte_2->tipo_transporte;   
                    $t_transporte->tp_3 ='N/A';    

                    $t_transporte->cp_1 =$transporte_proyeccion->capac_transporte_ra_1;            
                    $t_transporte->cp_2 =$transporte_proyeccion->capac_transporte_ra_2;   
                    $t_transporte->cp_3 =0; 

                    break;
                case 3:
                    $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_1)->first();
                    
                    $tipo_transporte_2 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_2)->first();
                   
                    $tipo_transporte_3 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_rp_3)->first();
                    
                    $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte . " | " . $tipo_transporte_2->tipo_transporte . " | " . $tipo_transporte_3->tipo_transporte;
                    $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_rp_1 . " | " . $transporte_proyeccion->capac_transporte_rp_2 . " | " . $transporte_proyeccion->capac_transporte_rp_3;

                    $t_transporte->tp_1 =$tipo_transporte_1->tipo_transporte;            
                    $t_transporte->tp_2 =$tipo_transporte_2->tipo_transporte;   
                    $t_transporte->tp_3 =$tipo_transporte_3->tipo_transporte;    

                    $t_transporte->cp_1 =$transporte_proyeccion->capac_transporte_ra_1;            
                    $t_transporte->cp_2 =$transporte_proyeccion->capac_transporte_ra_2;   
                    $t_transporte->cp_3 =$transporte_proyeccion->capac_transporte_ra_3; 

                    break;
                
            }
        }
        else if($solicitudes_practica->tipo_ruta == 2)
        {
            $viaticos_docente = $solicitudes_practica->viaticos_docente_ra;
            $viaticos_estudiante = $solicitudes_practica->viaticos_estudiantes_ra;
            $valor_est_trans = $solicitudes_practica->valor_estimado_transporte_ra;
            $detalle_recorrido = $solicitudes_practica->det_recorrido_interno_ra;

            $t_transporte = DB::table('transporte_proyeccion as trans')
                        ->select('tip_transp_1.tipo_transporte as tp_1','tip_transp_2.tipo_transporte as tp_2','tip_transp_3.tipo_transporte as tp_3',
                        'trans.capac_transporte_ra_1 as cp_1','trans.capac_transporte_ra_2 as cp_2','trans.capac_transporte_ra_3 as cp_3')
                        ->join('tipo_transporte as tip_transp_1','trans.id_tipo_transporte_ra_1','tip_transp_1.id')
                        ->leftjoin('tipo_transporte as tip_transp_2','trans.id_tipo_transporte_ra_2','tip_transp_2.id')
                        ->leftjoin('tipo_transporte as tip_transp_3','trans.id_tipo_transporte_ra_3','tip_transp_3.id')
                        ->where('trans.id',$id)->first();

            if($t_transporte == NULL)
            {
                $t_transporte = DB::table('transporte_proyeccion as trans')
                        ->where('trans.id',$id)->first();
                $t_transporte->tp_1 ='N/A';            
                $t_transporte->tp_2 ='N/A';   
                $t_transporte->tp_3 ='N/A';    

                $t_transporte->cp_1 =0;            
                $t_transporte->cp_2 =0;   
                $t_transporte->cp_3 =0;   
            }

            switch($transporte_proyeccion->cant_transporte_ra)
            {
                case 0:
                    
                    $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_1)->first();
                    
                    $tipo_transporte->tipo = 'N/A';
                    $tipo_transporte->capacidad = 0;

                    $t_transporte->tp_1 ='N/A';            
                    $t_transporte->tp_2 ='N/A';   
                    $t_transporte->tp_3 ='N/A';    

                    $t_transporte->cp_1 =0;            
                    $t_transporte->cp_2 =0;   
                    $t_transporte->cp_3 =0;  
                    break;
                case 1:
                    $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_1)->first();
                    
                    $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte;
                    $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_ra_1 ;

                    $t_transporte->tp_1 =$tipo_transporte->tipo;            
                    $t_transporte->tp_2 ='N/A';   
                    $t_transporte->tp_3 ='N/A';    

                    $t_transporte->cp_1 =$tipo_transporte->capacidad;            
                    $t_transporte->cp_2 =0;   
                    $t_transporte->cp_3 =0;  
                    
                    break;
                case 2:
                    $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_1)->first();
                   
                    $tipo_transporte_2 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_2)->first();
                    
                    $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte . " | " . $tipo_transporte_2->tipo_transporte;
                    $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_ra_1 . " | " . $transporte_proyeccion->capac_transporte_ra_2 ;

                    $t_transporte->tp_1 =$tipo_transporte_1->tipo_transporte;            
                    $t_transporte->tp_2 =$tipo_transporte_2->tipo_transporte;   
                    $t_transporte->tp_3 ='N/A';    

                    $t_transporte->cp_1 =$transporte_proyeccion->capac_transporte_ra_1;            
                    $t_transporte->cp_2 =$transporte_proyeccion->capac_transporte_ra_2;   
                    $t_transporte->cp_3 =0;  

                    break;
                case 3:
                    $tipo_transporte_1 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_1)->first();
                    
                    $tipo_transporte_2 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_2)->first();
                   
                    $tipo_transporte_3 = DB::table('tipo_transporte as tip_transp')
                        ->select('tip_transp.tipo_transporte')
                        ->where('id',$transporte_proyeccion->id_tipo_transporte_ra_3)->first();
                    
                    $tipo_transporte->tipo = $tipo_transporte_1->tipo_transporte . " | " . $tipo_transporte_2->tipo_transporte . " | " . $tipo_transporte_3->tipo_transporte;
                    $tipo_transporte->capacidad = $transporte_proyeccion->capac_transporte_ra_1 . " | " . $transporte_proyeccion->capac_transporte_ra_2 . " | " . $transporte_proyeccion->capac_transporte_ra_3;

                    $t_transporte->tp_1 =$tipo_transporte_1->tipo_transporte;            
                    $t_transporte->tp_2 =$tipo_transporte_2->tipo_transporte;   
                    $t_transporte->tp_3 =$tipo_transporte_3->tipo_transporte;    

                    $t_transporte->cp_1 =$transporte_proyeccion->capac_transporte_ra_1;            
                    $t_transporte->cp_2 =$transporte_proyeccion->capac_transporte_ra_2;   
                    $t_transporte->cp_3 =$transporte_proyeccion->capac_transporte_ra_3;  

                    break;
                default;
            }
        }


        $pract_inte=DB::table('practicas_integradas as prac_int')
                        ->where('prac_int.id',$solicitudes_practica->id)
                        ->first();

        $doce_pract_int = [];
        $espa_pract_int = [];

        $docente_resp=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
                    ->where('id',$solicitudes_practica->id_docente_responsable)->first();

        // $doce_pract_int[] =['id'=>$docente_resp->id,'full_name'=>$docente_resp->full_name,
        //                     'email'=>$docente_resp->email,'celular'=>$docente_resp->celular];

        // $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
        //                     'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

        $docentes_acompanantes = DB::table('docentes_practica as acompa')->select('acompa.id','acompa.total_docentes_apoyo','acompa.num_doc_docente_apoyo_1','acompa.num_doc_docente_apoyo_2','acompa.num_doc_docente_apoyo_3','acompa.num_doc_docente_apoyo_4','acompa.num_doc_docente_apoyo_5','acompa.num_doc_docente_apoyo_6','acompa.num_doc_docente_apoyo_7','acompa.num_doc_docente_apoyo_8','acompa.num_doc_docente_apoyo_9','acompa.num_doc_docente_apoyo_10','acompa.docente_apoyo_1','acompa.docente_apoyo_2','acompa.docente_apoyo_3','acompa.docente_apoyo_4','acompa.docente_apoyo_5','acompa.docente_apoyo_6','acompa.docente_apoyo_7','acompa.docente_apoyo_8','acompa.docente_apoyo_9','acompa.docente_apoyo_10')->where('acompa.id','=',$id)->first();

        if($docentes_practica->total_docentes_apoyo > 0)
        {
        if($docentes_practica->id_tipo_personal_apoyo_1 == 1)
        {
                $total_asistentes[0] = ['id_proy'=>1 + $solicitudes_practica->id,
                                        'num_estudiantes'=>1 + $solicitudes_practica->num_estudiantes,
                                        'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
        }

        else if($docentes_practica->id_tipo_personal_apoyo_1 == 2)
        {
                $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                        'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                        'num_docentes'=>1 + 1 + $practicas_integradas->cant_espa_aca];
        }

        else if($docentes_practica->id_tipo_personal_apoyo_1 == 3)
        {
                $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                        'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                        'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
        }

        if($docentes_practica->id_tipo_personal_apoyo_2 == 1)
        {
                $total_asistentes[0]= ['id_proy'=>$solicitudes_practica->id,
                                        'num_estudiantes'=>1 + $solicitudes_practica->num_estudiantes,
                                        'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
        }

        else if($docentes_practica->id_tipo_personal_apoyo_2 == 2)
        {
                $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                        'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                        'num_docentes'=>1 + 1 + $practicas_integradas->cant_espa_aca];
        }

        else if($docentes_practica->id_tipo_personal_apoyo_2 == 3)
        {
                $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                                        'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                                        'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
        }
        }
        else if($docentes_practica->total_docentes_apoyo == 0)
        {
        $total_asistentes[0] = ['id_proy'=>$solicitudes_practica->id,
                            'num_estudiantes'=>$solicitudes_practica->num_estudiantes,
                            'num_docentes'=>1 + $practicas_integradas->cant_espa_aca];
        }

        $acompa = [];

        if($docentes_acompanantes->total_docentes_apoyo==0)
        {
        $acompa[] = ["nombre"=>"N/A",
                "identificacion"=>"N/A",
                "tipo"=>"N/A",
                "num_apoyo"=>0];
        }
        if($docentes_acompanantes->personal_apoyo_1!=Null)
        {
        $acompa[] = ["nombre"=>$docentes_acompaniantes->personal_apoyo_1,
                "identificacion"=>$docentes_acompaniantes->num_doc_personal_apoyo_1,
                "tipo"=>($docentes_acompaniantes->tipo_personal_apoyo_1)==Null?"":"Apoyo",
                "num_apoyo"=>1];
        }
        if($docentes_acompanantes->personal_apoyo_1!=Null)
        {
        $acompa[] = ["nombre"=>$docentes_acompaniantes->personal_apoyo_2,
                "identificacion"=>$docentes_acompaniantes->num_doc_personal_apoyo_2,
                "tipo"=>($docentes_acompaniantes->tipo_personal_apoyo_2)==Null?"":"Apoyo",
                "num_apoyo"=>2];
        }
        
        switch($pract_inte->cant_espa_aca)
        {
            case "0":
                $docente_resp=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
                    ->where('id',$solicitudes_practica->id_docente_responsable)->first();

                $doce_pract_int[] =['id'=>$solicitudes_practica->id_docente_responsable,'full_name'=>$solicitudes_practica->full_name,
                                    'email'=>$docente_resp->email,'celular'=>$docente_resp->celular,
                                    ];

                $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica->espacio_academico,
                            'codigo_espacio_academico'=>$solicitudes_practica->codigo_espacio_academico];

                break;
            case "1":
                $docentes_pract_int=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->where('id',$pract_inte->id_docen_espa_aca_1)->first();

                $doce_pract_int[] =['id'=>$docentes_pract_int->id,'full_name'=>$docentes_pract_int->full_name,
                                    'email'=>$docentes_pract_int->email,'celular'=>$docentes_pract_int->celular];

                $pract_inte=DB::table('practicas_integradas as prac_int')
                        ->select('e_aca.espacio_academico as espacio_academico','e_aca.codigo_espacio_academico as codigo_espacio_academico')
                        ->join('espacio_academico as e_aca','prac_int.id_espa_aca_1','=','e_aca.id')
                        ->where('prac_int.id',$solicitudes_practica->id)
                        ->first();

                $espa_pract_int[] =['espacio_academico'=>$pract_inte->espacio_academico,
                            'codigo_espacio_academico'=>$pract_inte->codigo_espacio_academico];
                break;
            case "2":
                $docentes_pract_int=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->where('id',$pract_inte->id_docen_espa_aca_1)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_2)->get();

                foreach($docentes_pract_int as $item)
                {
                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                        'email'=>$item->email,'celular'=>$item->celular];
                }

                $espa_aca=DB::table('espacio_academico as espa_aca')
                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                        ->where('id',$pract_inte->id_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_espa_aca_2)->get();

                foreach($espa_aca as $item)
                {
                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                }

                break;
            case "3":
                $docentes_pract_int=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->where('id',$pract_inte->id_docen_espa_aca_1)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_3)->get();

                foreach($docentes_pract_int as $item)
                {
                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                        'email'=>$item->email,'celular'=>$item->celular];
                }

                $espa_aca=DB::table('espacio_academico as espa_aca')
                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                        ->where('id',$pract_inte->id_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_espa_aca_3)->get();

                foreach($espa_aca as $item)
                {
                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                }

                break;
            case "4":
                $docentes_pract_int=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->where('id',$pract_inte->id_docen_espa_aca_1)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_4)->get();

                foreach($docentes_pract_int as $item)
                {
                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                        'email'=>$item->email,'celular'=>$item->celular];
                }

                $espa_aca=DB::table('espacio_academico as espa_aca')
                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                        ->where('id',$pract_inte->id_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_espa_aca_4)->get();

                foreach($espa_aca as $item)
                {
                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                }

                break;
            case "5":
                $docentes_pract_int=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->where('id',$pract_inte->id_docen_espa_aca_1)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_5)->get();

                foreach($docentes_pract_int as $item)
                {
                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                        'email'=>$item->email,'celular'=>$item->celular];
                }

                $espa_aca=DB::table('espacio_academico as espa_aca')
                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                        ->where('id',$pract_inte->id_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_espa_aca_5)->get();

                foreach($espa_aca as $item)
                {
                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                }

                break;
            case "6":
                $docentes_pract_int=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->where('id',$pract_inte->id_docen_espa_aca_1)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_5)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_6)->get();

                foreach($docentes_pract_int as $item)
                {
                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                        'email'=>$item->email,'celular'=>$item->celular];
                }
                break;

                $espa_aca=DB::table('espacio_academico as espa_aca')
                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                        ->where('id',$pract_inte->id_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_espa_aca_5)
                        ->orWhere('id',$pract_inte->id_espa_aca_6)->get();

                foreach($espa_aca as $item)
                {
                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                }

            case "7":
                $docentes_pract_int=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre,  users.primer_apellido) as full_name'))
                    ->where('id',$pract_inte->id_docen_espa_aca_1)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_5)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_6)
                    ->orWhere('id',$pract_inte->id_docen_espa_aca_7)->get();

                foreach($docentes_pract_int as $item)
                {
                    $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                        'email'=>$item->email,'celular'=>$item->celular];
                }

                $espa_aca=DB::table('espacio_academico as espa_aca')
                        ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                        // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                        // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                        ->where('id',$pract_inte->id_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_espa_aca_5)
                        ->orWhere('id',$pract_inte->id_espa_aca_6)
                        ->orWhere('id',$pract_inte->id_espa_aca_7)->get();


              foreach($espa_aca as $item)
                {
                    $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                            'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                }
                break;
        }

        $anio_resolucion = $solicitudes_practica->fecha_resolucion;

        $firma_lito_decano = "data:image/png;base64,$decano->firma_litografica";
        $num_carac_detalle=strlen($detalle_recorrido);
        $num_carac_crono=strlen($solicitudes_practica->cronograma);

        $pdf = PDF::LoadView('documentacion.formatoTransporte', $data,['parrafos_modificables'=>$parrafos_modificables,
                                'solicitud_practica'=>$solicitudes_practica,
                                'practicas_integradas'=>$practicas_integradas,
                                'espa_pract_int'=>$espa_pract_int,
                                'docentes_practica'=>$docentes_practica,
                                'fecha_solicitud'=>$fecha_solicitud,
                                'anio_resolucion'=>$anio_resolucion,
                                'doce_pract_int'=>$doce_pract_int,
                                'total_asistentes'=>$total_asistentes,
                                'docentes_acompaniantes'=>$docentes_acompaniantes,
                                'viaticos_docente'=>$viaticos_docente,
                                'viaticos_estudiante'=>$viaticos_estudiante,
                                'valor_est_trans'=>$valor_est_trans,
                                'detalle_recorrido'=>$detalle_recorrido,
                                'num_carac_detalle'=>$num_carac_detalle,
                                'num_carac_crono'=>$num_carac_crono,
                                'tipo_transporte'=>$tipo_transporte,
                                't_transporte'=>$t_transporte,
                                'decano'=>$decano,
                                'firma_lito_decano'=>$firma_lito_decano]);

        $pdf->setPaper('letter');
        return $pdf->download('solicitud_transporte.pdf');

        // return view('documentacion.formatoTransporte', $data,['parrafos_modificables'=>$parrafos_modificables,
        //                         'solicitud_practica'=>$solicitudes_practica,
        //                         'practicas_integradas'=>$practicas_integradas,
        //                         'docentes_practica'=>$docentes_practica,
        //                         'fecha_solicitud'=>$fecha_solicitud,
        //                         'anio_resolucion'=>$anio_resolucion,
        //                         'doce_pract_int'=>$doce_pract_int,
        //                         'espa_pract_int'=>$espa_pract_int,
        //                         'viaticos_docente'=>$viaticos_docente,
        //                         'viaticos_estudiante'=>$viaticos_estudiante,
        //                         'valor_est_trans'=>$valor_est_trans,
        //                         'detalle_recorrido'=>$detalle_recorrido,
        //                         'tipo_transporte'=>$tipo_transporte,
        //                         't_transporte'=>$t_transporte,
        //                         'decano'=>$decano,
        //                         'firma_lito_decano'=>$firma_lito_decano]);
    }

    /**
     * Exportar solicitud de avance
     * Formato .pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportAvancePdf($ids)
    {
        // if(Auth::user()->id_role == 4)
        // {    
            $id=explode(",",$ids);
            $list_solic = [];
            $f_sal_reg = [];

            foreach($id as $item)
            {
                $list_solic[]=$item;
            }

            $viaticos_docente = 0;
            $viaticos_estudiante = 0;
            $valor_est_trans = 0;
            $transporte_menor = 0;
            $valor_materiales = 0;
            $valor_baquianos = 0;
            $valor_boletas = 0;
            $total_presupuesto = 0;
            
            // $id=Crypt::decrypt($id);
            $mytime = Carbon::now('America/Bogota')->format('d-m-Y');
            $fecha_solicitud = $mytime;

            $solicitudes_practica =DB::table('solicitud_practica as sol_prac')
            // $solicitudes_practica_aprob =DB::table('solicitud_practica as sol_prac')
            ->select('p_prel.id','sol_prac.id as id_solicitud','p_aca.id as id_pro_aca','p_aca.programa_academico', 'e_aca.id as id_esp_aca','e_aca.espacio_academico', 'e_aca.codigo_espacio_academico',
                    'per_aca.periodo_academico','sem_asig.semestre_asignatura',
                    'p_prel.destino_rp','p_prel.destino_ra','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp',
                    'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra',
                    'p_prel.duracion_num_dias_rp','c_proy.viaticos_docente_rp','c_proy.viaticos_estudiantes_rp','c_proy.total_presupuesto_rp',
                    'p_prel.duracion_num_dias_ra','c_proy.viaticos_docente_ra','c_proy.viaticos_estudiantes_ra','c_proy.total_presupuesto_ra',
                    'c_proy.valor_estimado_transporte_rp', 'c_proy.valor_estimado_transporte_ra', 'c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra',
                    'c_proy.vlr_otros_boletas_rp','c_proy.vlr_otros_boletas_ra','c_proy.vlr_guias_baquianos_rp','c_proy.vlr_guias_baquianos_ra',
                    'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra',
                    'tip_vinc.tipo_vinculacion', 'users.celular', 'users.telefono','users.email', 'users.id as id_docente_responsable', 'users.expedicion_identificacion',
                    'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo',
                    'p_prel.cantidad_grupos', 'sol_prac.fecha_salida','sol_prac.fecha_regreso','sol_prac.duracion_num_dias',
                    'transp.cant_transporte_rp', 'transp.cant_transporte_ra', 'sol_prac.cronograma', 'sol_prac.observaciones', 
                    'sol_prac.justificacion', 'sol_prac.objetivo_general', 'sol_prac.metodologia_evaluacion', 'sol_prac.id as id_solicitud',
                    'sol_prac.tipo_ruta',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
            ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
            ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
            ->join('costos_proyeccion as c_proy','sol_prac.id_proyeccion_preliminar','=','c_proy.id')
            ->join('docentes_practica as docen_pract','sol_prac.id_proyeccion_preliminar','=','docen_pract.id')
            ->join('users','p_prel.id_docente_responsable','=','users.id')
            ->join('periodo_academico as per_aca','p_prel.id_periodo_academico','=','per_aca.id')
            ->join('semestre_asignatura as sem_asig','p_prel.id_semestre_asignatura','=','sem_asig.id')
            ->join('tipo_vinculacion as tip_vinc','users.id_tipo_vinculacion','=','tip_vinc.id')
            ->join('transporte_proyeccion as transp','p_prel.id','=','transp.id')
            // ->where('id_estado_solicitud_practica','=',5)
            ->where('sol_prac.aprobacion_decano','=',7)
            // ->where('si_capital','=',1)
            // ->where('tiene_resolucion','=',1)
            ->whereIn('sol_prac.id',$list_solic)->paginate(10);

            $decano = DB::table('users')
                    ->select('users.firma_litografica','users.tiene_firma',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->join('roles as rol','users.id_role','rol.id')
                    ->where('id_estado','=',1)
                    ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();

            $id_docente_responsable = $solicitudes_practica[0]->id_docente_responsable;
            $docente_responsable = DB::table('users')
            ->select('users.firma_litografica','users.tiene_firma',
                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
            ->join('solicitud_practica as sol_prac','users.id','sol_prac.id_docente_creador')
            ->join('roles as rol','users.id_role','rol.id')
            ->where('id_estado','=',1)
            ->where('users.id','=',$id_docente_responsable)->orWhere('rol.id','=',2)->first();

            $id_pro_aca = $solicitudes_practica[0]->id_pro_aca;
            $coord = DB::table('users')
                    ->select('users.firma_litografica','users.tiene_firma',
                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->join('roles as rol','users.id_role','rol.id')
                    ->where('rol.name','=',"Coordinador")->orWhere('rol.id','=',4)
                    ->where('id_estado','=',1)
                    ->where('id_programa_academico_coord','=',$id_pro_aca)->first();

            $valor_diario = DB::table('control_sistema')->first();

            $contador = 0;
            foreach($solicitudes_practica as $sol)
            {
                $contador++;

                if($sol->tipo_ruta == 1){
                    $valor_materiales = $valor_materiales + $sol->vlr_materiales_rp;
                    $valor_boletas = $valor_boletas + $sol->vlr_otros_boletas_rp;
                    $valor_baquianos = $valor_baquianos + $sol->vlr_guias_baquianos_rp;
                    $viaticos_docente = $viaticos_docente + $sol->viaticos_docente_rp;
                    $viaticos_estudiante = $viaticos_estudiante + $sol->viaticos_estudiantes_rp;
                    $valor_est_trans = $valor_est_trans + $sol->valor_estimado_transporte_rp;
                    $transporte_menor = $transporte_menor + $sol->costo_total_transporte_menor_rp;
                    $total_presupuesto = $total_presupuesto + $sol->total_presupuesto_rp;
                    $total_avance_solicitud = $valor_materiales + $valor_baquianos + $valor_boletas + $transporte_menor + $viaticos_docente + $viaticos_estudiante;
                }
                else if($sol->tipo_ruta == 2){
                    $valor_materiales = $valor_materiales + $sol->vlr_materiales_ra;
                    $valor_boletas = $valor_boletas + $sol->vlr_otros_boletas_ra;
                    $valor_baquianos = $valor_baquianos + $sol->vlr_guias_baquianos_ra;
                    $viaticos_docente = $viaticos_docente + $sol->viaticos_docente_ra;
                    $viaticos_estudiante = $viaticos_estudiante + $sol->viaticos_estudiantes_ra;
                    $valor_est_trans = $valor_est_trans + $sol->valor_estimado_transporte_ra;
                    $transporte_menor = $transporte_menor + $sol->costo_total_transporte_menor_ra;
                    $total_presupuesto = $total_presupuesto + $sol->total_presupuesto_ra;
                    $total_avance_solicitud = $valor_materiales + $valor_baquianos + $valor_boletas + $transporte_menor + $viaticos_docente + $viaticos_estudiante;
                }
            }

            
            // $id_solicitud = $solicitudes_practica->id_solicitud;
            // $estudiantes = DB::table('estudiantes_solicitud_practica as estud')
            //                 ->where('estud.id_solicitud_practica','=',$id_solicitud)->get();

            $firma_lito_decano = "data:image/png;base64,$decano->firma_litografica";
            $firma_lito_coord = "data:image/png;base64,$coord->firma_litografica";
            $firma_lito_docente = "data:image/png;base64,$docente_responsable->firma_litografica";

            $hoy=$this->obtenerFechaEnLetra($fecha_solicitud);

            $idUser = Auth::user()->id;
            $usuario= DB::table('users')
            ->where('id',$idUser)->first();

            // $solicitud = DB::table('solicitud_practica as sol_prac')
            //                 ->where('sol_prac.id_proyeccion_preliminar','=',$id)->first();
            // $documentos_sistema = DB::table('tipo_documentacion')->orderBy('id','asc')->get();

            $docente_responsable = DB::table('users')
                    ->select('users.firma_litografica','users.tiene_firma',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->join('solicitud_practica as sol_prac','users.id','sol_prac.id_docente_creador')
                    ->join('roles as rol','users.id_role','rol.id')
                    ->where('id_estado','=',1)
                    ->where('users.id','=',$id_docente_responsable)->orWhere('rol.id','=',2)->first();
            
            if($docente_responsable->tiene_firma == 1)
            {
                $firma_lito_docente = "data:image/png;base64,$docente_responsable->firma_litografica";
            }
            elseif($docente_responsable->tiene_firma == 0)
            {
                $firma_lito_docente = "";
            }

            // $tiene_firma = $docente_responsable->tiene_firma;

            // $control_sistema =DB::table('control_sistema')->first();

            $data = ['title' => 'Formato Solicitud avance'];
            $pdf = PDF::LoadView('documentacion.formatoAvance', $data,[
                                'solicitud_practica'=>$solicitudes_practica,
                                'fecha_solicitud'=>$fecha_solicitud,
                                'valor_diario'=>$valor_diario,
                                'viaticos_docente'=>$viaticos_docente,
                                'viaticos_estudiante'=>$viaticos_estudiante,
                                'valor_est_trans'=>$valor_est_trans,
                                // 'estudiantes'=>$estudiantes, 
                                'valor_materiales'=>$valor_materiales,
                                'valor_baquianos'=>$valor_baquianos,
                                'valor_boletas'=>$valor_boletas,
                                'transporte_menor'=>$transporte_menor,
                                'presupuesto'=>$total_presupuesto,
                                'total_avance'=>$total_avance_solicitud,
                                'decano'=>$decano,
                                'firma_lito_decano'=>$firma_lito_decano,
                                'firma_lito_coord'=>$firma_lito_coord,
                                'firma_lito_docente'=>$firma_lito_docente,
                                'docente_responsable'=>$docente_responsable,
                                'hoy'=>$hoy]);

            $pdf->setPaper('letter');
    
            return $pdf->download('avance.pdf');
            // return view('documentacion.formatoAvance', $data,[
            //         'solicitud_practica'=>$solicitudes_practica,
            //             'fecha_solicitud'=>$fecha_solicitud,
            //             'valor_diario'=>$valor_diario,
            //             'viaticos_docente'=>$viaticos_docente,
            //             'viaticos_estudiante'=>$viaticos_estudiante,
            //             'valor_est_trans'=>$valor_est_trans,
            //             // 'estudiantes'=>$estudiantes, 
            //             'valor_materiales'=>$valor_materiales,
            //             'valor_baquianos'=>$valor_baquianos,
            //             'valor_boletas'=>$valor_boletas,
            //             'transporte_menor'=>$transporte_menor,
            //             'presupuesto'=>$total_presupuesto,
            //             'total_avance'=>$total_avance_solicitud,
            //             'decano'=>$decano,
            //             'firma_lito_decano'=>$firma_lito_decano,
            //             'firma_lito_coord'=>$firma_lito_coord,
            //             'firma_lito_docente'=>$firma_lito_docente,
            //             'docente_responsable'=>$docente_responsable,
            //             'hoy'=>$hoy]);
        // }
        // else if(Auth::user()->id_role == 3 || Auth::user()->id_role == 2 || Auth::user()->id_role == 1)
        // {
        //     $id=explode(",",$ids);

        //     $docentes_practica= DB::table('docentes_practica as doc_prac')
        //     ->select('doc_prac.id','doc_prac.soporte_formato_avance','doc_prac.soporte_formato_practica',
        //     'doc_prac.tiene_soporte_avance','doc_prac.tiene_soporte_practica')
        //     ->join('solicitud_practica as sol_prac','doc_prac.id','sol_prac.id_proyeccion_preliminar')
        //     ->where('sol_prac.id',$ids)->first();
            
        //     $fmt_avance = $docentes_practica->soporte_formato_avance;
        //     $dwn_avance = base64_decode($fmt_avance);

        //     $file = 'avance.pdf';
        //     file_put_contents($file, $dwn_avance);

        //     if (file_exists($file)) {
        //         header('Content-Description: File Transfer');
        //         header('Content-Type: application/octet-stream');
        //         header('Content-Disposition: attachment; filename="'.basename($file).'"');
        //         header('Expires: 0');
        //         header('Cache-Control: must-revalidate');
        //         header('Pragma: public');
        //         header('Content-Length: ' . filesize($file));
        //         readfile($file);
        //         exit;
        //     }
        //     // return response()->download($dwn_avance);
        // } 
    }

    /**
     * Exportar oficio
     * Formato .pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportOficioPdf($ids)
    {
        // $id=Crypt::decrypt($id);
        $id=explode(",",$ids);

        $list_solic = [];
        $f_sal_reg = [];

        foreach($id as $item)
        {
            $list_solic[]=$item;
        }

        $data = ['title' => 'Oficio Práctica'];
        $parrafos_modificables =DB::table('oficio')->first();
        $fecha_solicitud = Carbon::now('America/Bogota')->format('d-m-Y');

        $doce_pract_int = [];
        $espa_pract_int = [];

        $viaticos_docente = 0;
        $viaticos_estudiante = 0;
        $valor_est_trans = 0;
        $vlr_trans_menor = 0;
        $vlr_materiales = 0;
        $vlr_guias_baquianos = 0;
        $vlr_boletas_otros = 0;
        $presupuesto_total = 0;

        $solicitudes_practica =DB::table('solicitud_practica as sol_prac')
        // $solicitudes_practica_aprob =DB::table('solicitud_practica as sol_prac')
        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico', 'e_aca.codigo_espacio_academico',
                'per_aca.periodo_academico','sem_asig.semestre_asignatura',
                'p_prel.destino_rp','p_prel.destino_ra','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp',
                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra',
                'p_prel.id_docente_responsable','docen_pract.docente_apoyo_1',
                'p_prel.duracion_num_dias_rp','c_proy.viaticos_docente_rp','c_proy.viaticos_estudiantes_rp','c_proy.total_presupuesto_rp',
                'p_prel.duracion_num_dias_ra','c_proy.viaticos_docente_ra','c_proy.viaticos_estudiantes_ra','c_proy.total_presupuesto_ra',
                'c_proy.vlr_otros_boletas_rp','c_proy.vlr_otros_boletas_ra','c_proy.vlr_guias_baquianos_rp','c_proy.vlr_guias_baquianos_ra',
                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra',
                'c_proy.valor_estimado_transporte_rp', 'c_proy.valor_estimado_transporte_ra','c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra',
                'c_proy.vlr_guias_baquianos_rp','c_proy.vlr_guias_baquianos_ra','c_proy.vlr_otros_boletas_rp','c_proy.vlr_otros_boletas_ra',
                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra',
                'tip_vinc.tipo_vinculacion', 'users.celular', 'users.email',
                'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo',
                'p_prel.cantidad_grupos', 'sol_prac.fecha_salida','sol_prac.fecha_regreso','sol_prac.duracion_num_dias',
                'transp.cant_transporte_rp', 'transp.cant_transporte_ra', 'sol_prac.cronograma', 'sol_prac.observaciones', 
                'sol_prac.justificacion', 'sol_prac.objetivo_general', 'sol_prac.metodologia_evaluacion',
                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud', 'sol_prac.num_resolucion','sol_prac.fecha_resolucion',
                'sol_prac.num_cdp','sol_prac.num_solicitud_necesidad', 'p_prel.num_acta_consejo_facultad', 'p_prel.fecha_acta_consejo_facultad',
                'tip_ident.tipo_identificacion','users.id as id_user', 'tip_ident.sigla', 'sol_prac.consec_dfamarena','sol_prac.consec_cordis',
                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
        ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
        ->join('costos_proyeccion as c_proy','sol_prac.id_proyeccion_preliminar','=','c_proy.id')
        ->join('docentes_practica as docen_pract','sol_prac.id_proyeccion_preliminar','=','docen_pract.id')
        ->join('users','p_prel.id_docente_responsable','=','users.id')
        ->join('periodo_academico as per_aca','p_prel.id_periodo_academico','=','per_aca.id')
        ->join('semestre_asignatura as sem_asig','p_prel.id_semestre_asignatura','=','sem_asig.id')
        ->join('tipo_vinculacion as tip_vinc','users.id_tipo_vinculacion','=','tip_vinc.id')
        ->join('tipo_identificacion as tip_ident','users.id_tipo_identificacion','=','tip_ident.id')
        ->join('transporte_proyeccion as transp','p_prel.id','=','transp.id')
        ->where('id_estado_solicitud_practica','=',3)
        // ->where('si_capital','=',1)
        // ->where('tiene_resolucion','=',1)
        ->whereIn('sol_prac.id',$list_solic)->paginate(10);

        $decano = DB::table('users')
                ->select('users.firma_litografica','users.tiene_firma',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();
                
        $docente_resp=DB::table('users')
                    ->select('id','email','celular',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
                    ->where('id',$solicitudes_practica[0]->id_docente_responsable)->first();
            
        $doce_pract_int[] =['id'=>$docente_resp->id,'full_name'=>$docente_resp->full_name,
        'email'=>$docente_resp->email,'celular'=>$docente_resp->celular];
        
        $contador = 0;

        foreach($solicitudes_practica as $sol)
        {
            $contador++;
            if($sol->tipo_ruta == 1){
                $valor_est_trans = $valor_est_trans + $sol->valor_estimado_transporte_rp;
                $vlr_trans_menor = $vlr_trans_menor + $sol->costo_total_transporte_menor_rp;
                $viaticos_docente = $viaticos_docente + $sol->viaticos_docente_rp;
                $viaticos_estudiante = $viaticos_estudiante + $sol->viaticos_estudiantes_rp;
                $vlr_materiales = $vlr_materiales + $sol->vlr_materiales_rp;
                $vlr_guias_baquianos = $vlr_guias_baquianos + $sol->vlr_guias_baquianos_rp;
                $vlr_boletas_otros = $vlr_boletas_otros + $sol->vlr_otros_boletas_rp;
                //$presupuesto_total = $presupuesto_total + $sol->total_presupuesto_rp;
                $presupuesto_total = $vlr_materiales + $vlr_boletas_otros + $vlr_guias_baquianos + $viaticos_docente + $viaticos_estudiante + $vlr_trans_menor; 

                $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$sol->espacio_academico,
                                    'codigo_espacio_academico'=>$sol->codigo_espacio_academico,
                                    'programa_academico'=>$sol->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($sol->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($sol->fecha_regreso)
                                   ];

                $f_sal_reg[$contador-1] =['fecha_salida'=>$this->obtenerFechaEnLetra($sol->fecha_salida),
                                          'fecha_regreso'=>$this->obtenerFechaEnLetra($sol->fecha_regreso),
                                          'programa_academico'=>$sol->programa_academico];
            }
            else if($sol->tipo_ruta == 2){
                $valor_est_trans = $valor_est_trans + $sol->valor_estimado_transporte_ra;
                $vlr_trans_menor = $vlr_trans_menor + $sol->costo_total_transporte_menor_ra;
                $viaticos_docente = $viaticos_docente + $sol->viaticos_docente_ra;
                $viaticos_estudiante = $viaticos_estudiante + $sol->viaticos_estudiantes_ra;
                $vlr_materiales = $vlr_materiales + $sol->vlr_materiales_ra;
                $vlr_guias_baquianos = $vlr_guias_baquianos + $sol->vlr_guias_baquianos_ra;
                $vlr_boletas_otros = $vlr_boletas_otros + $sol->vlr_otros_boletas_ra;
                //$presupuesto_total = $presupuesto_total + $sol->total_presupuesto_ra;
                $presupuesto_total = $vlr_materiales + $vlr_boletas_otros + $vlr_guias_baquianos + $viaticos_docente + $viaticos_estudiante + $vlr_trans_menor;   

                $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$sol->espacio_academico,
                                    'codigo_espacio_academico'=>$sol->codigo_espacio_academico,
                                    'programa_academico'=>$sol->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($sol->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($sol->fecha_regreso)];}

                $f_sal_reg[$contador-1] =['fecha_salida'=>$this->obtenerFechaEnLetra($sol->fecha_salida),
                                          'fecha_regreso'=>$this->obtenerFechaEnLetra($sol->fecha_regreso),
                                          'programa_academico'=>$sol->programa_academico];
        }

        $list_solic_id_proy=DB::table('solicitud_practica as sp')
        ->select('id_proyeccion_preliminar')
        ->whereIn('sp.id',$list_solic)->get();
        $ids_list_solic_id_proy=$list_solic_id_proy->pluck('id_proyeccion_preliminar')->all();
        $list_pract_inte=DB::table('practicas_integradas as prac_int')
            ->select('prac_int.id as id','prac_int.cant_espa_aca','prac_int.id_espa_aca_1','prac_int.id_espa_aca_2','prac_int.id_espa_aca_3',
                    'prac_int.id_espa_aca_4','prac_int.id_espa_aca_5','prac_int.id_espa_aca_6','prac_int.id_espa_aca_7','prac_int.id_docen_espa_aca_1',
                    'prac_int.id_docen_espa_aca_2','prac_int.id_docen_espa_aca_3','prac_int.id_docen_espa_aca_4','prac_int.id_docen_espa_aca_5',
                    'prac_int.id_docen_espa_aca_6','prac_int.id_docen_espa_aca_7','proy_prel.practicas_integradas')
            ->join('proyeccion_preliminar as proy_prel','prac_int.id','proy_prel.id')
            ->join('solicitud_practica as sol_prac','proy_prel.id','sol_prac.id_proyeccion_preliminar')
            ->whereIn('proy_prel.id',$ids_list_solic_id_proy)->get();
        //dd($list_pract_inte);
        foreach($list_pract_inte as $pract_inte)
        {
            switch($pract_inte->cant_espa_aca)
            {
                // case "0":
                //     $docente_resp=DB::table('users')
                //         ->select('id','email','celular',
                //         DB::raw('CONCAT_WS(" ",users.primer_nombre,users.primer_apellido) as full_name'))
                //         ->where('id',$solicitudes_practica[0]->id_docente_responsable)->first();
    
                //     $doce_pract_int[] =['id'=>$solicitudes_practica[0]->id_user,'full_name'=>$sol->full_name,
                //                         'email'=>$docente_resp->email,'celular'=>$docente_resp->celular,
                //                         ];
    
                //     $espa_pract_int[] =['espacio_academico'=>$solicitudes_practica[0]->espacio_academico,
                //                 'codigo_espacio_academico'=>$solicitudes_practica[0]->codigo_espacio_academico];
    
                //     break;
                case "1":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)->first();
    
                    $doce_pract_int[] =['id'=>$docentes_pract_int->id,'full_name'=>$docentes_pract_int->full_name,
                                        'email'=>$docentes_pract_int->email,'celular'=>$docentes_pract_int->celular];
    
                    $pract_integrada=DB::table('practicas_integradas as prac_int')
                            ->select('e_aca.espacio_academico as espacio_academico','e_aca.codigo_espacio_academico as codigo_espacio_academico',
                                    'p_aca.programa_academico','sol_prac.fecha_salida','sol_prac.fecha_regreso')
                            ->join('espacio_academico as e_aca','prac_int.id_espa_aca_1','=','e_aca.id')
                            ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                            ->join('solicitud_practica as sol_prac','prac_int.id','=','sol_prac.id_proyeccion_preliminar')
                            ->where('prac_int.id',$pract_inte->id)
                            ->first();
    
                    $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$pract_integrada->espacio_academico,
                                    'codigo_espacio_academico'=>$pract_integrada->codigo_espacio_academico,
                                    'programa_academico'=>$pract_integrada->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($pract_integrada->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($pract_integrada->fecha_regreso)
                                   ];
                    break;
                case "2":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $espa_aca=DB::table('espacio_academico as espa_aca')
                            ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico',
                                    'p_aca.programa_academico','sol_prac.fecha_salida','sol_prac.fecha_regreso')
                            // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                            // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                            // ->join('practicas_integradas as prac_int','espa_aca.id','prac_int.id_espa_aca_1')
                            ->join('programa_academico as p_aca','espa_aca.id_programa_academico','=','p_aca.id')
                            //->join('solicitud_practica as sol_prac',$pract_inte->id,'=','sol_prac.id_proyeccion_preliminar')
                            ->join('solicitud_practica as sol_prac', function ($join) use ($pract_inte) {
                                        $join->on('sol_prac.id_proyeccion_preliminar', '=', DB::raw($pract_inte->id));
                                    })
                            ->where('espa_aca.id',$pract_inte->id_espa_aca_1)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_2)->get()
                            ->and();
    
                    foreach($espa_aca as $item)
                    {
                        $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$item->espacio_academico,
                                    'codigo_espacio_academico'=>$item->codigo_espacio_academico,
                                    'programa_academico'=>$item->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($item->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($item->fecha_regreso)
                                   ];
                    }
    
                    break;
                case "3":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $espa_aca=DB::table('espacio_academico as espa_aca')
                            ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico',
                                    'p_aca.programa_academico','sol_prac.fecha_salida','sol_prac.fecha_regreso')
                            // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                            // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                            ->join('programa_academico as p_aca','espa_aca.id_programa_academico','=','p_aca.id')
                            //->join('solicitud_practica as sol_prac',$pract_inte->id,'=','sol_prac.id_proyeccion_preliminar')
                            ->join('solicitud_practica as sol_prac', function ($join) use ($pract_inte) {
                                        $join->on('sol_prac.id_proyeccion_preliminar', '=', DB::raw($pract_inte->id));
                                    })
                            ->where('espa_aca.id',$pract_inte->id_espa_aca_1)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_2)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_3)->get();
    
                    foreach($espa_aca as $item)
                    {
                        $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$item->espacio_academico,
                                    'codigo_espacio_academico'=>$item->codigo_espacio_academico,
                                    'programa_academico'=>$item->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($item->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($item->fecha_regreso)
                                   ];
                    }
    
                    break;
                case "4":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_4)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $espa_aca=DB::table('espacio_academico as espa_aca')
                            ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico',
                                    'p_aca.programa_academico','sol_prac.fecha_salida','sol_prac.fecha_regreso')
                            // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                            // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                            ->join('programa_academico as p_aca','espa_aca.id_programa_academico','=','p_aca.id')
                            //->join('solicitud_practica as sol_prac',$pract_inte->id,'=','sol_prac.id_proyeccion_preliminar')
                            ->join('solicitud_practica as sol_prac', function ($join) use ($pract_inte) {
                                        $join->on('sol_prac.id_proyeccion_preliminar', '=', DB::raw($pract_inte->id));
                                    })
                            ->where('espa_aca.id',$pract_inte->id_espa_aca_1)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_2)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_3)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_4)->get();
    
                    foreach($espa_aca as $item)
                    {
                        $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$item->espacio_academico,
                                    'codigo_espacio_academico'=>$item->codigo_espacio_academico,
                                    'programa_academico'=>$item->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($item->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($item->fecha_regreso)
                                   ];
                    }
    
                    break;
                case "5":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_5)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $espa_aca=DB::table('espacio_academico as espa_aca')
                            ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico',
                                    'p_aca.programa_academico','sol_prac.fecha_salida','sol_prac.fecha_regreso')
                            // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                            // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                            ->join('programa_academico as p_aca','espa_aca.id_programa_academico','=','p_aca.id')
                            //->join('solicitud_practica as sol_prac','prac_int.id','=','sol_prac.id_proyeccion_preliminar')
                            ->join('solicitud_practica as sol_prac', function ($join) use ($pract_inte) {
                                        $join->on('sol_prac.id_proyeccion_preliminar', '=', DB::raw($pract_inte->id));
                                    })
                            ->where('espa_aca.id',$pract_inte->id_espa_aca_1)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_2)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_3)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_4)
                            ->orWhere('espa_aca.id',$pract_inte->id_espa_aca_5)->get();
    
                    foreach($espa_aca as $item)
                    {
                        $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$item->espacio_academico,
                                    'codigo_espacio_academico'=>$item->codigo_espacio_academico,
                                    'programa_academico'=>$item->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($item->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($item->fecha_regreso)
                                   ];
                    }
    
                    break;
                case "6":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_5)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_6)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
                    break;
    
                    $espa_aca=DB::table('espacio_academico as espa_aca')
                            ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico',
                                    'p_aca.programa_academico','sol_prac.fecha_salida','sol_prac.fecha_regreso')
                            // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                            // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                            ->join('programa_academico as p_aca','espa_aca.id_programa_academico','=','p_aca.id')
                            ->join('solicitud_practica as sol_prac','prac_int.id','=','sol_prac.id_proyeccion_preliminar')
                            ->where('id',$pract_inte->id_espa_aca_1)
                            ->orWhere('id',$pract_inte->id_espa_aca_2)
                            ->orWhere('id',$pract_inte->id_espa_aca_3)
                            ->orWhere('id',$pract_inte->id_espa_aca_4)
                            ->orWhere('id',$pract_inte->id_espa_aca_5)
                            ->orWhere('id',$pract_inte->id_espa_aca_6)->get();
    
                    foreach($espa_aca as $item)
                    {
                        $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$item->espacio_academico,
                                    'codigo_espacio_academico'=>$item->codigo_espacio_academico,
                                    'programa_academico'=>$item->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($item->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($item->fecha_regreso)
                                   ];
                    }
    
                case "7":
                    $docentes_pract_int=DB::table('users')
                        ->select('id','email','celular',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre,  users.primer_apellido) as full_name'))
                        ->where('id',$pract_inte->id_docen_espa_aca_1)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_2)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_3)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_4)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_5)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_6)
                        ->orWhere('id',$pract_inte->id_docen_espa_aca_7)->get();
    
                    foreach($docentes_pract_int as $item)
                    {
                        $doce_pract_int[] =['id'=>$item->id,'full_name'=>$item->full_name,
                                            'email'=>$item->email,'celular'=>$item->celular];
                    }
    
                    $espa_aca=DB::table('espacio_academico as espa_aca')
                            ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico',
                                    'p_aca.programa_academico','sol_prac.fecha_salida','sol_prac.fecha_regreso')
                            // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                            // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                            ->join('programa_academico as p_aca','espa_aca.id_programa_academico','=','p_aca.id')
                            ->join('solicitud_practica as sol_prac','prac_int.id','=','sol_prac.id_proyeccion_preliminar')
                            ->where('id',$pract_inte->id_espa_aca_1)
                            ->orWhere('id',$pract_inte->id_espa_aca_2)
                            ->orWhere('id',$pract_inte->id_espa_aca_3)
                            ->orWhere('id',$pract_inte->id_espa_aca_4)
                            ->orWhere('id',$pract_inte->id_espa_aca_5)
                            ->orWhere('id',$pract_inte->id_espa_aca_6)
                            ->orWhere('id',$pract_inte->id_espa_aca_7)->get();
    
    
                  foreach($espa_aca as $item)
                    {
                        $espa_pract_int[] =['id_proy'=>$sol->id,
                                    'espacio_academico'=>$item->espacio_academico,
                                    'codigo_espacio_academico'=>$item->codigo_espacio_academico,
                                    'programa_academico'=>$item->programa_academico,
                                    'fecha_salida'=>$this->obtenerFechaEnLetra($item->fecha_salida),
                                    'fecha_regreso'=>$this->obtenerFechaEnLetra($item->fecha_regreso)
                                   ];
                    }
                    break;
            }

        }

        // array_unique($espa_pract_int,SORT_REGULAR);
        // array_map("unserialize", array_unique(array_map("serialize", $espa_pract_int)));

        $anio_resolucion = $solicitudes_practica[0]->fecha_resolucion;

        if($decano->tiene_firma == 1)
        {
            $firma_lito = "data:image/png;base64,$decano->firma_litografica";
        }
        else if($decano->tiene_firma == 0)
        {
            $firma_lito = "";
        }

        $hoy=$this->obtenerFechaEnLetra($fecha_solicitud);

        $f_resol =$this->obtenerFechaEnLetra($solicitudes_practica[0]->fecha_resolucion);
        $f_plan_prac =$this->obtenerFechaEnLetra($solicitudes_practica[0]->fecha_acta_consejo_facultad);
        $f_plan_prac=['num'=>$f_plan_prac['num'],'mes'=>$f_plan_prac['mes'],'anio'=>Carbon::now()->year];
        
        if(empty($solicitudes_practica[0]->fecha_resolucion) || $solicitudes_practica[0]->fecha_resolucion == NULL)
        {
            $f_resol=['num'=>'___','mes'=>'_________','anio'=>'____'];
        }
        else if(!empty($solicitudes_practica[0]->fecha_resolucion) || $solicitudes_practica[0]->fecha_resolucion != NULL)
        {
            $f_resol=$this->obtenerFechaEnLetra($solicitudes_practica[0]->fecha_resolucion);
        }

        if(empty($solicitudes_practica[0]->fecha_acta_consejo_facultad) || $solicitudes_practica[0]->fecha_acta_consejo_facultad == NULL)
        {
            $f_plan_prac=['num'=>'___','mes'=>'_________','anio'=>'____'];
        }
        else if(!empty($solicitudes_practica[0]->fecha_acta_consejo_facultad) || $solicitudes_practica[0]->fecha_acta_consejo_facultad != NULL)
        {
            $f_plan_prac=$this->obtenerFechaEnLetra($solicitudes_practica[0]->fecha_acta_consejo_facultad);
            $f_plan_prac=['num'=>$f_plan_prac['num'],'mes'=>$f_plan_prac['mes'],'anio'=>Carbon::now()->year];
        }

        $pdf = PDF::LoadView('documentacion.formatoOficio', $data,['parrafos_modificables'=>$parrafos_modificables,
                                'solicitud_practica'=>$solicitudes_practica,
                                'espa_pract_int'=>$espa_pract_int,
                                'fecha_solicitud'=>$fecha_solicitud,
                                'anio_resolucion'=>$anio_resolucion,
                                'viaticos_docente'=>$viaticos_docente,
                                'viaticos_estudiante'=>$viaticos_estudiante,
                                'valor_est_trans'=>$valor_est_trans,
                                'vlr_materiales'=>$vlr_materiales,
                                'vlr_baquianos'=>$vlr_guias_baquianos,
                                'vlr_boletas'=>$vlr_boletas_otros,
                                'transporte_menor'=>$vlr_trans_menor,
                                'presupuesto'=>$presupuesto_total,
                                'decano'=>$decano,
                                'firma_lito'=>$firma_lito,
                                "hoy"=>$hoy,
                                "f_sal_reg"=>$f_sal_reg,
                                "f_resol"=>$f_resol,
                                "f_plan_prac"=>$f_plan_prac]);

        return $pdf->download('oficio_practica.pdf');

        // return view('documentacion.formatoOficio', $data,['parrafos_modificables'=>$parrafos_modificables,
        //                         'solicitud_practica'=>$solicitudes_practica,
        //                         'espa_pract_int'=>$espa_pract_int,
        //                         'fecha_solicitud'=>$fecha_solicitud,
        //                         'anio_resolucion'=>$anio_resolucion,
        //                         'viaticos_docente'=>$viaticos_docente,
        //                         'viaticos_estudiante'=>$viaticos_estudiante,
        //                         'valor_est_trans'=>$valor_est_trans,
        //                         'vlr_materiales'=>$vlr_materiales,
        //                         'vlr_baquianos'=>$vlr_guias_baquianos,
        //                         'vlr_boletas'=>$vlr_boletas_otros,
        //                         'transporte_menor'=>$vlr_trans_menor,
        //                         'presupuesto'=>$presupuesto_total,
        //                         'decano'=>$decano,
        //                         'firma_lito'=>$firma_lito,
        //                         "hoy"=>$hoy,
        //                         "f_sal_reg"=>$f_sal_reg,
        //                         "f_resol"=>$f_resol,
        //                         "f_plan_prac"=>$f_plan_prac]);
  
        
    }

    /**
     * Exportar autorización de giro
     * Formato .pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportGiroPdf($ids)
    {
        // $id=Crypt::decrypt($id);
        $id=explode(",",$ids);
        
        $data = ['title' => 'Autorización Giro'];
        
        $parrafos_modificables =DB::table('resolucion')->first();
        $fecha_solicitud = Carbon::now('America/Bogota')->format('Y');

        $list_solic = [];
        foreach($id as $item)
        {
            $list_solic[]=$item;
        }

        $solicitudes_practica =DB::table('solicitud_practica as sol_prac')
        // $solicitudes_practica_aprob =DB::table('solicitud_practica as sol_prac')
        ->select('p_prel.id','p_aca.programa_academico','e_aca.espacio_academico', 'e_aca.codigo_espacio_academico',
                'per_aca.periodo_academico','sem_asig.semestre_asignatura',
                'p_prel.destino_rp','p_prel.destino_ra','p_prel.fecha_salida_aprox_rp','p_prel.fecha_regreso_aprox_rp',
                'p_prel.fecha_salida_aprox_ra','p_prel.fecha_regreso_aprox_ra',
                'p_prel.id_docente_responsable','docen_pract.docente_apoyo_1',
                'p_prel.duracion_num_dias_rp','c_proy.viaticos_docente_rp','c_proy.viaticos_estudiantes_rp','c_proy.total_presupuesto_rp',
                'p_prel.duracion_num_dias_ra','c_proy.viaticos_docente_ra','c_proy.viaticos_estudiantes_ra','c_proy.total_presupuesto_ra',
                'c_proy.valor_estimado_transporte_rp', 'c_proy.valor_estimado_transporte_ra','c_proy.vlr_materiales_rp','c_proy.vlr_materiales_ra',
                'c_proy.vlr_guias_baquianos_rp','c_proy.vlr_guias_baquianos_ra','c_proy.vlr_otros_boletas_rp','c_proy.vlr_otros_boletas_ra',
                'c_proy.costo_total_transporte_menor_rp','c_proy.costo_total_transporte_menor_ra',
                'tip_vinc.tipo_vinculacion', 'users.celular', 'users.email',
                'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo',
                'p_prel.cantidad_grupos', 'sol_prac.fecha_salida','sol_prac.fecha_regreso','sol_prac.duracion_num_dias',
                'transp.cant_transporte_rp', 'transp.cant_transporte_ra', 'sol_prac.cronograma', 'sol_prac.observaciones', 
                'sol_prac.justificacion', 'sol_prac.objetivo_general', 'sol_prac.metodologia_evaluacion',
                'sol_prac.tipo_ruta as tipo_ruta','sol_prac.id as id_solicitud', 'sol_prac.num_resolucion','sol_prac.fecha_resolucion',
                'sol_prac.num_cdp','sol_prac.num_solicitud_necesidad', 'p_prel.num_acta_consejo_facultad', 'p_prel.fecha_acta_consejo_facultad',
                'tip_ident.tipo_identificacion','users.id as id_user', 'tip_ident.sigla',
                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
        ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
        ->join('costos_proyeccion as c_proy','sol_prac.id_proyeccion_preliminar','=','c_proy.id')
        ->join('docentes_practica as docen_pract','sol_prac.id_proyeccion_preliminar','=','docen_pract.id')
        ->join('users','p_prel.id_docente_responsable','=','users.id')
        ->join('periodo_academico as per_aca','p_prel.id_periodo_academico','=','per_aca.id')
        ->join('semestre_asignatura as sem_asig','p_prel.id_semestre_asignatura','=','sem_asig.id')
        ->join('tipo_vinculacion as tip_vinc','users.id_tipo_vinculacion','=','tip_vinc.id')
        ->join('tipo_identificacion as tip_ident','users.id_tipo_identificacion','=','tip_ident.id')
        ->join('transporte_proyeccion as transp','p_prel.id','=','transp.id')
        ->where('id_estado_solicitud_practica','=',3)
        // ->where('si_capital','=',1)
        // ->where('tiene_resolucion','=',1)
        // ->whereIn('sol_prac.id_proyeccion_preliminar',$list_solic)->paginate(10);
        ->whereIn('sol_prac.id',$list_solic)->paginate(10);

        $decano = DB::table('users')
                ->select('users.firma_litografica','users.tiene_firma',
                        DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->join('roles as rol','users.id_role','rol.id')
                ->where('id_estado','=',1)
                ->where('rol.name','=',"Decano")->orWhere('rol.id','=',2)->first();

        $viaticos_docente = 0;
        $viaticos_estudiante = 0;
        $valor_est_trans = 0;
        $vlr_trans_menor = 0;
        $vlr_materiales = 0;
        $vlr_guias_baquianos = 0;
        $vlr_boletas_otros = 0;
        $presupuesto_total = 0;

        foreach($solicitudes_practica as $sol)
        {

            if($sol->tipo_ruta == 1){
                $vlr_materiales = $vlr_materiales + $sol->vlr_materiales_rp;
                $vlr_boletas_otros = $vlr_boletas_otros + $sol->vlr_otros_boletas_rp;
                $vlr_guias_baquianos = $vlr_guias_baquianos + $sol->vlr_guias_baquianos_rp;
                $viaticos_docente = $viaticos_docente + $sol->viaticos_docente_rp;
                $viaticos_estudiante = $viaticos_estudiante + $sol->viaticos_estudiantes_rp;
                $valor_est_trans = $valor_est_trans + $sol->valor_estimado_transporte_rp;
                $vlr_trans_menor = $vlr_trans_menor + $sol->costo_total_transporte_menor_rp;
                //$presupuesto_total = $presupuesto_total + $sol->total_presupuesto_rp;
                $presupuesto_total = $vlr_materiales + $vlr_boletas_otros + $vlr_guias_baquianos + $viaticos_docente + $viaticos_estudiante + $vlr_trans_menor;
            }
            else if($sol->tipo_ruta == 2){
                $vlr_materiales = $vlr_materiales + $sol->vlr_materiales_ra;
                $vlr_boletas_otros = $vlr_boletas_otros + $sol->vlr_otros_boletas_ra;
                $vlr_guias_baquianos = $vlr_guias_baquianos + $sol->vlr_guias_baquianos_ra;
                $viaticos_docente = $viaticos_docente + $sol->viaticos_docente_ra;
                $viaticos_estudiante = $viaticos_estudiante + $sol->viaticos_estudiantes_ra;
                $valor_est_trans = $valor_est_trans + $sol->valor_estimado_transporte_ra;
                $vlr_trans_menor = $vlr_trans_menor + $sol->costo_total_transporte_menor_ra;
                //$presupuesto_total = $presupuesto_total + $sol->total_presupuesto_rp;
                $presupuesto_total = $vlr_materiales + $vlr_boletas_otros + $vlr_guias_baquianos + $viaticos_docente + $viaticos_estudiante + $vlr_trans_menor;        }
        }

        $anio_resolucion = $solicitudes_practica[0]->fecha_resolucion;

        if($decano->tiene_firma == 1)
        {
            $firma_lito = "data:image/png;base64,$decano->firma_litografica";
        }
        else if($decano->tiene_firma == 0)
        {
            $firma_lito = "";
        }

        $sumatoria_total_presupuesto = $viaticos_docente + $viaticos_estudiante + $vlr_materiales;
        $total_presupuesto = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        // ucfirst($sumatoria_total_presupuesto);
        $hoy=$this->obtenerFechaEnLetra($fecha_solicitud);

        $pdf = PDF::LoadView('documentacion.formatoGiro', $data,['parrafos_modificables'=>$parrafos_modificables,
                                'solicitud_practica'=>$solicitudes_practica[0],
                                'fecha_solicitud'=>$fecha_solicitud,
                                'anio_resolucion'=>$anio_resolucion,
                                'viaticos_docente'=>$viaticos_docente,
                                'viaticos_estudiante'=>$viaticos_estudiante,
                                'valor_est_trans'=>$valor_est_trans,
                                'vlr_materiales'=>$vlr_materiales,
                                'decano'=>$decano,
                                'firma_lito'=>$firma_lito,
                                "sumatoria_total_presupuesto"=>$sumatoria_total_presupuesto,
                                "total_presupuesto"=>$total_presupuesto,
                                "presupuesto"=>$presupuesto_total,
                                "hoy"=>$hoy]);
                                
        return $pdf->download('autorizacion_giro.pdf');
    }

    /**
     * Listado de documentos a exportar
     * Formato .pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accionesPdf($id)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $id=Crypt::decrypt($id);
        $idUser = Auth::user()->id;
        $usuario= DB::table('users')
        ->where('id',$idUser)->first();

        $solicitud = DB::table('solicitud_practica as sol_prac')
                        ->where('sol_prac.id','=',$id)->first();
        $documentos_sistema = DB::table('tipo_documentacion')->orderBy('id','asc')->get();

        $docente_responsable = DB::table('users')
                ->select('users.firma_litografica','users.tiene_firma','users.id_estado',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                ->join('solicitud_practica as sol_prac','users.id','sol_prac.id_docente_creador')
                ->join('roles as rol','users.id_role','rol.id')
                // ->where('id_estado','=',1)
                ->where('users.id','=',$solicitud->id_docente_creador)->orWhere('rol.id','=',2)->first();
        
        // if($docente_responsable->tiene_firma == 1)
        // {

            // $firma_lito_docente = "data:image/png;base64,$docente_responsable->firma_litografica";
        // }
        // elseif($docente_responsable->tiene_firma == 0)
        // {
        //     $firma_lito_docente = "";
        // }

        // $tiene_firma = $docente_responsable->tiene_firma;

        return view('documentacion.tablas.acciones_documentos',['id'=>$id,
                                                                'solicitud'=>$solicitud,
                                                                'documentos_sistema'=>$documentos_sistema, 
                                                                // 'firma_lito_docente'=>$firma_lito_docente,
                                                                // 'tiene_firma'=>$tiene_firma,
                                                                'usuario'=>$usuario,
                                                                'docente_responsable'=>$docente_responsable,
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
     * Exportar documentos estudiante
     *
     * @param  int  $id
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public  function dwn_doc_estud($id,$email)
    {
        $id=Crypt::decrypt($id);
        $email=Crypt::decrypt($email);

        $rec_doc =DB::table('estudiantes_solicitud_practica as estud_prac')
        ->join('solicitud_practica as sol_prac','estud_prac.id_solicitud_practica','sol_prac.id')
        ->where('estud_prac.email',$email)
        ->where('sol_prac.id',$id)->first();

        $doc_req_solicitud = DB::table('documentos_requeridos_solicitud as doc_req')
                ->select('doc_req.vacuna_fiebre_amarilla', 'doc_req.vacuna_tetanos', 'doc_req.permiso_acudiente', 
                         'doc_req.certificado_adicional_1', 'doc_req.certificado_adicional_2', 'doc_req.certificado_adicional_3',
                         'doc_req.detalle_certificado_adcional_1', 'doc_req.detalle_certificado_adcional_2', 'doc_req.detalle_certificado_adcional_3')
                ->where('id',$id)->first();

        $doc_img = [];

        if($rec_doc->seguro_estudiantil != null)
        {
            $ccc1 = $rec_doc->seguro_estudiantil;
            $show_image1 = base64_decode($ccc1);
            $pdf1="data:application/pdf;base64,$ccc1";
            $img1="data:image/png;base64,$ccc1";
            $doc_img['img1']=$img1;
            
        }
        else{
            $doc_img['img1']="";
            $pdf1="";
        }

        if($rec_doc->documento_identificacion != null)
        {
            $ccc2 = $rec_doc->documento_identificacion;
            $show_image2 = base64_decode($ccc2);
            $pdf2="data:application/pdf;base64,$ccc2";
            $img2="data:image/png;base64,$ccc2";
            $doc_img['img2']=$img2;
        }
        else{
            $doc_img['img2']="";
            $pdf2="";
        }

        if($rec_doc->certificado_eps != null)
        {
            $ccc4 = $rec_doc->certificado_eps;
            $show_image4 = base64_decode($ccc4);
            $pdf4="data:application/pdf;base64,$ccc4";
            $img4="data:image/png;base64,$ccc4";
            // $doc_img['img4']=$img4;
            $doc_img['img4']=$pdf4;
        }
        else{
            $doc_img['img4']="";
            $pdf4="";
        }

        if($rec_doc->permiso_acudiente != null)
        {
            $ccc5 = $rec_doc->permiso_acudiente;
            $show_image5 = base64_decode($ccc5);
            $pdf5="data:application/pdf;base64,$ccc5";
            $img5="data:image/png;base64,$ccc5";
            // $doc_img['img5']=$img5;
            $doc_img['img5']=$pdf5;
        }
        else{
            $doc_img['img5']="";
            $pdf5="";
        }

        if($rec_doc->vacuna_fiebre_amarilla != null)
        {
            $ccc6 = $rec_doc->vacuna_fiebre_amarilla;
            $show_image6 = base64_decode($ccc6);
            $pdf6="data:application/pdf;base64,$ccc6";
            $img6="data:image/png;base64,$ccc6";
            // $doc_img['img6']=$img6;
            $doc_img['img6']=$pdf6;
        }
        else{
            $doc_img['img6']="";
            $pdf6="";
        }

        if($rec_doc->vacuna_tetanos != null)
        {
            $ccc7 = $rec_doc->vacuna_tetanos;
            $show_image7 = base64_decode($ccc7);
            $pdf7="data:application/pdf;base64,$ccc7";
            $img7="data:image/png;base64,$ccc7";
            // $doc_img['img7']=$img7;
            $doc_img['img7']=$pdf7;
        }
        else{
            $doc_img['img7']="";
            $pdf7="";
        }

        if($rec_doc->certificado_adicional_1 != null)
        {
            $ccc9 = $rec_doc->certificado_adicional_1;
            $show_image9 = base64_decode($ccc9);
            $pdf9="data:application/pdf;base64,$ccc9";
            $img9="data:image/png;base64,$ccc9";
            // $doc_img['img9']=$img9;
            $doc_img['img9']=$pdf9;
        }
        else{
            $doc_img['img9']="";
            $pdf9="";
        }

        if($rec_doc->certificado_adicional_2 != null)
        {
            $ccc10 = $rec_doc->certificado_adicional_2;
            $show_image10 = base64_decode($ccc10);
            $pdf10="data:application/pdf;base64,$ccc10";
            $img10="data:image/png;base64,$ccc10";
            // $doc_img['img10']=$img10;
            $doc_img['img10']=$pdf10;
        }
        else{
            $doc_img['img10']="";
            $pdf10="";
        }

        if($rec_doc->certificado_adicional_3 != null)
        {
            $ccc11 = $rec_doc->certificado_adicional_3;
            $show_image11 = base64_decode($ccc11);
            $pdf11="data:application/pdf;base64,$ccc11";
            $img11="data:image/png;base64,$ccc11";
            // $doc_img['img11']=$img11;
            $doc_img['img11']=$pdf11;
        }
        else{
            $doc_img['img11']="";
            $pdf11="";
        }
        
        // $pdf = PDF::LoadView('estudiantes.documentos_descarga',["doc_img"=>$doc_img, "nnn"=>$pdf1, "bbb"=>$img1,
        //                                                         "rec_doc"=>$rec_doc]);
        // $pdf->setPaper('letter');

        $nom_arch = $rec_doc->nombre_completo;
        // return $pdf->download($nom_arch.'.pdf');

        $idUser_log=Auth::user()->id;
        $control_sistema =DB::table('control_sistema')->first();
        $usuario=DB::table('users')
                ->where('id','=',$idUser_log)->first();

        return view('estudiantes.documentos_descarga',["doc_img"=>$doc_img,
                                                        "pdf1"=>$pdf1,
                                                        "pdf2"=>$pdf2,
                                                        "pdf4"=>$pdf4,
                                                        "pdf5"=>$pdf5,
                                                        "pdf6"=>$pdf6,
                                                        "pdf7"=>$pdf7,
                                                        "pdf9"=>$pdf9,
                                                        "pdf10"=>$pdf10,
                                                        "pdf11"=>$pdf11,
                                                        "rec_doc"=>$rec_doc,
                                                        "doc_req_solicitud"=>$doc_req_solicitud,
                                                        "usuario"=>$usuario,
                                                        'control_sistema'=>$control_sistema]);
    }
}
