<?php

namespace PractiCampoUD\Imports;

use PractiCampoUD\proyeccion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use DateTime;
use DB;
use PractiCampoUD\costos_proyeccion;
use PractiCampoUD\docentes_practica;
use PractiCampoUD\materiales_herramientas_proyeccion;
use PractiCampoUD\practicas_integradas;
use PractiCampoUD\riesgos_amenazas_practica;
use PractiCampoUD\transporte_menor;
use PractiCampoUD\transporte_proyeccion;

class ProyeccionesPreliminaresImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        $mytime = Carbon::now('America/Bogota');

        foreach($collection as $row)
        {
            $docente_responsable = DB::table('users')
            ->select('id','id_programa_academico_coord','users.id_role as id_role',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
            ->where('id',$row['num_ident_docente'])->first();

            $id_prog_aca = $row['id_programa_academico'];
            $confim_docente = 0;
            $id_docente_confirm=null;

            $prog_aca =DB::table('programa_academico')
            ->where('id',$id_prog_aca)->first();

            if($id_prog_aca == $docente_responsable->id_programa_academico_coord || $docente_responsable->id_role == 4)
            {
                $confim_docente = 1;
                $id_docente_confirm = $docente_responsable->id;
            }

            if(!empty($docente_responsable) || $docente_responsable != null){

                $proyeccion = proyeccion::create([
                    'id_estado'=>1,
                    'id_programa_academico'=>$row['id_programa_academico'],
                    'id_espacio_academico'=>$row['id_espacio_academico'],
                    'id_periodo_academico'=>$row['per_aca'],
                    'anio_periodo'=>$row['ano_per'],
                    'id_semestre_asignatura'=>$row['sem_asig'],
                    'id_docente_responsable'=>$row['num_ident_docente'],
                    'num_estudiantes_aprox'=>$row['numero_de_estudiantes'],
                    'cantidad_grupos'=>$row['cant_grupos'],
                    'grupo_1'=>$row['grupo_1'],
                    'grupo_2'=>$row['grupo_2'],
                    'grupo_3'=>$row['grupo_3'],
                    'grupo_4'=>$row['grupo_4'],
                    'destino_rp'=>$row['destino_ruta_principal'],
                    'cantidad_url_rp'=>$row['cant_url_ruta_principal'],
                    'ruta_principal'=>$row['url_1_ruta_principal'],
                    'ruta_principal_2'=>$row['url_2_ruta_principal'],
                    'ruta_principal_3'=>$row['url_3_ruta_principal'],
                    'ruta_principal_4'=>$row['url_4_ruta_principal'],
                    'ruta_principal_5'=>$row['url_5_ruta_principal'],
                    'ruta_principal_6'=>$row['url_6_ruta_principal'],
                    'det_recorrido_interno_rp'=>$row['detalle_del_recorrido_interno_rp'],
                    'lugar_salida_rp'=>$row['id_sede_salida_rp'],
                    'lugar_regreso_rp'=>$row['id_sede_regreso_rp'],
                    'fecha_salida_aprox_rp'=>$row['salida_fecha_tentativa_rp'],
                    'fecha_regreso_aprox_rp'=>$row['regreso_fecha_tentativa_rp'],
                    'duracion_num_dias_rp'=>$this->calcNumDias($row['salida_fecha_tentativa_rp'],$row['regreso_fecha_tentativa_rp']),
                    'destino_ra'=>$row['destino_ruta_contingencia'],
                    'cantidad_url_ra'=>$row['cant_url_ruta_contingencia'],
                    'ruta_alterna'=>$row['url_1_ruta_contingencia'],
                    'ruta_alterna_2'=>$row['url_2_ruta_contingencia'],
                    'ruta_alterna_3'=>$row['url_3_ruta_contingencia'],
                    'ruta_alterna_4'=>$row['url_4_ruta_contingencia'],
                    'ruta_alterna_5'=>$row['url_5_ruta_contingencia'],
                    'ruta_alterna_6'=>$row['url_6_ruta_contingencia'],
                    'det_recorrido_interno_ra'=>$row['detalle_del_recorrido_interno_rc'],
                    'lugar_salida_ra'=>$row['id_sede_salida_rc'],
                    'lugar_regreso_ra'=>$row['id_sede_regreso_rc'],
                    'fecha_salida_aprox_ra'=>$row['salida_fecha_tentativa_rc'],
                    'fecha_regreso_aprox_ra'=>$row['regreso_fecha_tentativa_rc'],
                    'duracion_num_dias_ra'=>$this->calcNumDias($row['salida_fecha_tentativa_rc'],$row['regreso_fecha_tentativa_rc']),
                    'confirm_creador'=>1,
                    'id_creador_confirm'=>$row['num_ident_docente'],
                    'confirm_docente'=>$confim_docente,
                    'id_docente_confirm'=>$id_docente_confirm,
                    'confirm_coord'=>0,
                    'confirm_electiva_coord'=>0,
                    'confirm_asistD'=>0,
                    'aprobacion_coordinador'=>5,
                    'aprobacion_decano'=>5,
                    'aprobacion_asistD'=>5,
                    'aprobacion_consejo_facultad'=>5,
                    'fecha_diligenciamiento'=>$mytime,
                    
                ]);

                $docentes = docentes_practica::create([
                    'id'=>$proyeccion->id,
                    'total_docentes_apoyo'=>$row['total_docentes_apoyo'],
                    'num_docentes_apoyo'=>$row['cant_personal_apoyo'],
                    'docente_apoyo_1'=>$row['personal_apoyo_1'],
                    'docente_apoyo_2'=>$row['personal_apoyo_2'],
                    // 'docente_apoyo_3'=>$row['personal_apoyo_3'],
                    // 'docente_apoyo_4'=>$row['personal_apoyo_4'],
                    // 'docente_apoyo_5'=>$row['personal_apoyo_5'],
                    // 'docente_apoyo_6'=>$row['personal_apoyo_6'],
                    // 'docente_apoyo_7'=>$row['personal_apoyo_7'],
                    // 'docente_apoyo_8'=>$row['personal_apoyo_8'],
                    // 'docente_apoyo_9'=>$row['personal_apoyo_9'],
                    // 'docente_apoyo_10'=>$row['personal_apoyo_10'],
                    
                ]);

                $practicas_integradas = practicas_integradas::create([
                    'id'=>$proyeccion->id,
                    'cant_espa_aca'=>0,
                    
                ]);

                $transporte_menor = transporte_menor::create([
                    'id'=>$proyeccion->id,
                    'cant_trans_menor_rp'=>$row['cant_transporte_menor_rp'],
                    'cant_trans_menor_ra'=>$row['cant_transporte_menor_rc'],
                    'trans_menor_rp_1'=>$row['transporte_menor_1_rp'],
                    'trans_menor_rp_2'=>$row['transporte_menor_2_rp'],
                    'trans_menor_rp_3'=>$row['transporte_menor_3_rp'],
                    'trans_menor_rp_4'=>$row['transporte_menor_4_rp'],
                    'vlr_trans_menor_rp_1'=>$row['vlr_transporte_menor_1_rp'],
                    'vlr_trans_menor_rp_2'=>$row['vlr_transporte_menor_2_rp'],
                    'vlr_trans_menor_rp_3'=>$row['vlr_transporte_menor_3_rp'],
                    'vlr_trans_menor_rp_4'=>$row['vlr_transporte_menor_4_rp'],
                    'trans_menor_ra_1'=>$row['transporte_menor_1_rc'],
                    'trans_menor_ra_2'=>$row['transporte_menor_2_rc'],
                    'trans_menor_ra_3'=>$row['transporte_menor_3_rc'],
                    'trans_menor_ra_4'=>$row['transporte_menor_4_rc'],
                    'vlr_trans_menor_ra_1'=>$row['vlr_transporte_menor_1_rc'],
                    'vlr_trans_menor_ra_2'=>$row['vlr_transporte_menor_2_rc'],
                    'vlr_trans_menor_ra_3'=>$row['vlr_transporte_menor_3_rc'],
                    'vlr_trans_menor_ra_4'=>$row['vlr_transporte_menor_4_rc'],
                    
                ]);

                $t_m_1_rp = $row['vlr_transporte_menor_1_rp'];
                $t_m_2_rp = $row['vlr_transporte_menor_2_rp'];
                $t_m_3_rp = $row['vlr_transporte_menor_3_rp'];
                $t_m_4_rp = $row['vlr_transporte_menor_4_rp'];
                $t_m_1_ra = $row['vlr_transporte_menor_1_rc'];
                $t_m_2_ra = $row['vlr_transporte_menor_2_rc'];
                $t_m_3_ra = $row['vlr_transporte_menor_3_rc'];
                $t_m_4_ra = $row['vlr_transporte_menor_4_rc'];

                $costo_total_transporte_menor_rp = $this->CalcCostoTranspM($t_m_1_rp, $t_m_2_rp, $t_m_3_rp, $t_m_4_rp);
                $costo_total_transporte_menor_ra = $this->CalcCostoTranspM($t_m_1_ra, $t_m_2_ra, $t_m_3_ra, $t_m_4_ra);

                $transporte = transporte_proyeccion::create([
                    'id'=>$proyeccion->id,
                    'cant_transporte_rp'=>$row['cant_vehiculos_rp'],
                    'cant_transporte_ra'=>$row['cant_vehiculos_rc'],
                    'id_tipo_transporte_rp_1'=>$row['id_tipo_vehiculo_1_rp'],
                    'id_tipo_transporte_rp_2'=>$row['id_tipo_vehiculo_2_rp'],
                    'id_tipo_transporte_rp_3'=>$row['id_tipo_vehiculo_3_rp'],
                    'id_tipo_transporte_ra_1'=>$row['id_tipo_vehiculo_1_rc'],
                    'id_tipo_transporte_ra_2'=>$row['id_tipo_vehiculo_2_rc'],
                    'id_tipo_transporte_ra_3'=>$row['id_tipo_vehiculo_3_rc'],
                    'capac_transporte_rp_1'=>$row['capac_vehiculo_1_rp'],
                    'capac_transporte_rp_2'=>$row['capac_vehiculo_2_rp'],
                    'capac_transporte_rp_3'=>$row['capac_vehiculo_3_rp'],
                    'capac_transporte_ra_1'=>$row['capac_vehiculo_1_rc'],
                    'capac_transporte_ra_2'=>$row['capac_vehiculo_2_rc'],
                    'capac_transporte_ra_3'=>$row['capac_vehiculo_3_rc'],
                    'det_tipo_transporte_rp_1'=>$row['det_vehiculo_1_rp'],
                    'det_tipo_transporte_rp_2'=>$row['det_vehiculo_2_rp'],
                    'det_tipo_transporte_rp_3'=>$row['det_vehiculo_3_rp'],
                    'det_tipo_transporte_ra_1'=>$row['det_vehiculo_1_rc'],
                    'det_tipo_transporte_ra_2'=>$row['det_vehiculo_2_rc'],
                    'det_tipo_transporte_ra_3'=>$row['det_vehiculo_3_rc'],
                    'exclusiv_tiempo_rp_1'=>$row['disp_permanente_vehiculo_1_rp'],
                    'exclusiv_tiempo_rp_2'=>$row['disp_permanente_vehiculo_2_rp'],
                    'exclusiv_tiempo_rp_3'=>$row['disp_permanente_vehiculo_3_rp'],
                    'exclusiv_tiempo_ra_1'=>$row['disp_permanente_vehiculo_1_rc'],
                    'exclusiv_tiempo_ra_2'=>$row['disp_permanente_vehiculo_2_rc'],
                    'exclusiv_tiempo_ra_3'=>$row['disp_permanente_vehiculo_3_rc'],
                    'docen_respo_trasnporte_rp'=>$docente_responsable->full_name,
                    'docen_respo_trasnporte_ra'=>$docente_responsable->full_name,


                ]);

                $mate_herra = materiales_herramientas_proyeccion::create([
                    'id'=>$proyeccion->id,
                    'det_materiales_rp'=>$row['materiales_rp'],
                    'det_materiales_ra'=>$row['materiales_rc'],
                    'det_otros_boletas_rp'=>$row['boletasotros_rp'],
                    'det_otros_boletas_ra'=>$row['boletasotros_rc'],
                    'det_guias_baquianos_rp'=>$row['guiasbaquianos_rp'],
                    'det_guias_baquianos_ra'=>$row['guiasbaquianos_rc'],
                ]);

                $riesgo_amenaza = riesgos_amenazas_practica::create([
                    'id'=>$proyeccion->id,
                    'areas_acuaticas_rp'=>$row['areas_acuaticas_rp'],
                    'areas_acuaticas_ra'=>$row['areas_acuaticas_rc'],
                    'alturas_rp'=>$row['alturas_rp'],
                    'alturas_ra'=>$row['alturas_rc'],
                    'riesgo_biologico_rp'=>$row['riesgo_biologico_rp'],
                    'riesgo_biologico_ra'=>$row['riesgo_biologico_rc'],
                    'espacios_confinados_rp'=>$row['espacios_confinados_rp'],
                    'espacios_confinados_ra'=>$row['espacios_confinados_rc'],
                ]);

                $viaticos_estudiantes_rp=$this->calcViaticosEst($proyeccion->num_estudiantes_aprox, $proyeccion->duracion_num_dias_rp,$prog_aca);
                $viaticos_estudiantes_ra=$this->calcViaticosEst($proyeccion->num_estudiantes_aprox, $proyeccion->duracion_num_dias_ra,$prog_aca);
                $viaticos_docente_rp=$this->calcViaticosDoc($docentes->total_docentes_apoyo,$docentes->num_docentes_apoyo,$proyeccion->duracion_num_dias_rp);
                $viaticos_docente_ra=$this->calcViaticosDoc($docentes->total_docentes_apoyo,$docentes->num_docentes_apoyo,$proyeccion->duracion_num_dias_ra);

                $vlr_materiales_rp =$row['vlr_total_materiales_rp'];
                $vlr_materiales_ra =$row['vlr_total_materiales_rc'];
                $vlr_otros_boletas_rp =$row['vlr_total_boletasotros_rp'];
                $vlr_otros_boletas_ra =$row['vlr_total_boletasotros_rc'];
                $vlr_guias_baquianos_rp =$row['vlr_total_guiasbaquianos_rp'];
                $vlr_guias_baquianos_ra =$row['vlr_total_guiasbaquianos_rc'];

                $total_otros_rp = $vlr_materiales_rp + $vlr_otros_boletas_rp + $vlr_guias_baquianos_rp;
                $total_otros_ra = $vlr_materiales_ra + $vlr_otros_boletas_ra + $vlr_guias_baquianos_ra;

                $total_presupuesto_rp =$total_otros_rp + $viaticos_estudiantes_rp + $viaticos_docente_rp + $costo_total_transporte_menor_rp; 
                $total_presupuesto_ra =$total_otros_ra + $viaticos_estudiantes_ra + $viaticos_docente_ra + $costo_total_transporte_menor_ra; 

                $costos = costos_proyeccion::create([
                    'id'=>$proyeccion->id,
                    'vlr_materiales_rp'=>$row['vlr_total_materiales_rp'],
                    'vlr_materiales_ra'=>$row['vlr_total_materiales_rc'],
                    'vlr_otros_boletas_rp'=>$row['vlr_total_boletasotros_rp'],
                    'vlr_otros_boletas_ra'=>$row['vlr_total_boletasotros_rc'],
                    'vlr_guias_baquianos_rp'=>$row['vlr_total_guiasbaquianos_rp'],
                    'vlr_guias_baquianos_ra'=>$row['vlr_total_guiasbaquianos_rc'],
                    'viaticos_estudiantes_rp'=> $viaticos_estudiantes_rp,
                    'viaticos_estudiantes_ra'=> $viaticos_estudiantes_ra,
                    'viaticos_docente_rp'=>$viaticos_docente_rp,
                    'viaticos_docente_ra'=>$viaticos_docente_ra,
                    'costo_total_transporte_menor_rp'=>$costo_total_transporte_menor_rp,
                    'costo_total_transporte_menor_ra'=>$costo_total_transporte_menor_ra,
                    'total_presupuesto_rp'=>$total_presupuesto_rp,
                    'total_presupuesto_ra'=>$total_presupuesto_ra,
                ]);
            }

        }
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
      
    // }

    public function sheets(): array
    {
        return [
            'Proyecciones' => $this
        ];
    }

    public function calcNumDias($f_salida,$f_regreso)
    {
        $fecha_salida = new DateTime($f_salida);
        $fecha_regreso = new DateTime($f_regreso);

        $dias = $fecha_salida->diff($fecha_regreso);
        $num_dias = $dias->days + 1;

        return $num_dias;
    }

    public  function calcViaticosEst($n_est,$n_dias,$prog_aca)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $viaticos = 0;

        if($n_dias == 1)
        {
            if($prog_aca->pregrado == 1)
            {
                $viaticos = $n_est * $control_sistema->vlr_estud_min * $n_dias;
            }
            else if($prog_aca->pregrado == 0)
            {
                $viaticos = 0;
            }
        }
        else if($n_dias > 1)
        {
            if($prog_aca->pregrado == 1)
            {
                $viaticos = $n_est * $control_sistema->vlr_estud_max * $n_dias;
            }
            else if($prog_aca->pregrado == 0)
            {
                $viaticos = 0;
            }
        }

        return $viaticos;
    }

    public  function calcViaticosDoc($t_doc_apoyo,$n_apoyo,$n_dias)
    {
        $control_sistema =DB::table('control_sistema')->first();
        $viaticos = 0;
        $total_docentes = $t_doc_apoyo + 1;

        if($n_dias == 1)
        {

            $viaticos = 0;
        }
        else if($n_dias > 1)
        {
            $viaticos = ($n_dias-0.5) * $control_sistema->vlr_docen_max * $total_docentes;
        }

        return $viaticos;
    }

    public function CalcCostoTranspM($t_1,$t_2,$t_3,$t_4)
    {
        $costo_total_transporte_menor = $t_1 + $t_2 + $t_3 + $t_4;
        
        return $costo_total_transporte_menor;
    }

}
