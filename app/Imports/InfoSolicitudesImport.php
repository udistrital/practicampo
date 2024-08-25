<?php

namespace PractiCampoUD\Imports;

use PractiCampoUD\proyeccion;
use PractiCampoUD\solicitud;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use DateTime;
use DB;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use PractiCampoUD\costos_proyeccion;
use PractiCampoUD\docentes_practica;
use PractiCampoUD\materiales_herramientas_proyeccion;
use PractiCampoUD\documentos_requeridos_solicitud;
use PractiCampoUD\User;
use PractiCampoUD\practicas_integradas;
use PractiCampoUD\riesgos_amenazas_practica;
use PractiCampoUD\transporte_menor;
use PractiCampoUD\transporte_proyeccion;

class InfoSolicitudesImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;
    /**
     * Validadador de datos para registro de usuario
     *
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    protected function validator($data)
    {
    
        $rules=['id_proyeccion'=>['required','integer','digits_between:1,11'],
                'num_ident_docente'=>['required','integer','digits_between:5,15'],
                'docente_responsable'=>['required','string','max:50'],
                'cant_grupos'=>['required','integer','digits:1'],
                'grupo_1'=>['required','integer','digits_between:1,5'],
                'grupo_2'=>['integer','digits_between:0,5','nullable'],
                'grupo_3'=>['integer','digits_between:0,5','nullable'],
                'grupo_4'=>['integer','digits_between:0,5','nullable'],
                'numero_de_estudiantes'=>['required','integer','digits:2'],
                'cant_personal_apoyo'=>['required','integer','digits:1','min:0','max:2'],
                'id_tipo_personal_apoyo_1'=>['integer','digits_between:0,1','nullable'],
                'num_ident_personal_apoyo_1'=>['integer','digits_between:5,15','nullable'],
                'personal_apoyo_1'=>['string','max:50','nullable'],
                'id_tipo_personal_apoyo_2'=>['integer','digits_between:0,1','nullable'],
                'num_ident_personal_apoyo_2'=>['integer','digits_between:5,15','nullable'],
                'personal_apoyo_2'=>['string','max:50','nullable'],
                'practica_integrada'=>['required','integer','digits:1','min:0','max:1'],
                'cant_docentes_participantes'=>['required','integer','digits:1','min:0','max:7','nullable'],
                'num_ident_docente_participante_1'=>['integer','digits_between:5,15','nullable'],
                'id_esp_acad_docente_participante_1'=>['integer','digits_between:1,15','nullable'],
                'num_ident_docente_participante_2'=>['integer','digits_between:5,15','nullable'],
                'id_esp_acad_docente_participante_2'=>['integer','digits_between:1,15','nullable'],
                'num_ident_docente_participante_3'=>['integer','digits_between:5,15','nullable'],
                'id_esp_acad_docente_participante_3'=>['integer','digits_between:1,15','nullable'],
                'num_ident_docente_participante_4'=>['integer','digits_between:5,15','nullable'],
                'id_esp_acad_docente_participante_4'=>['integer','digits_between:1,15','nullable'],
                'num_ident_docente_participante_5'=>['integer','digits_between:5,15','nullable'],
                'id_esp_acad_docente_participante_5'=>['integer','digits_between:1,15','nullable'],
                'num_ident_docente_participante_6'=>['integer','digits_between:5,15','nullable'],
                'id_esp_acad_docente_participante_6'=>['integer','digits_between:1,15','nullable'],
                'num_ident_docente_participante_7'=>['integer','digits_between:5,15','nullable'],
                'id_esp_acad_docente_participante_7'=>['integer','digits_between:1,15','nullable'],
                'tipo_ruta'=>['required','integer','digits:1','min:1','max:2'],
                'detalle_del_recorrido_interno'=>['required','string','min:15','max:1000000'],
                'id_sede_salida'=>['required','integer','digits:1','min:1','max:6'],
                'id_sede_regreso'=>['required','integer','digits:1','min:1','max:6'],
                'salida_fecha_confirmada'=>['required','string','min:10','max:10'],
                'regreso_fecha_confirmada'=>['required','string','min:10','max:10'],
                'hora_salida'=>['required','string','min:7','max:8'],
                'hora_regreso'=>['required','string','min:7','max:8'],
                'det_vehiculo'=>['string','min:10','max:100','nullable'],
                'disp_permanente_vehiculo'=>['integer','digits:1','min:0','max:1'],
                'cant_transporte_menor'=>['required','integer','digits_between:0,1','min:0','max:4'],
                'transporte_menor_1'=>['string','min:4','max:20','nullable'],
                'transporte_menor_2'=>['string','min:4','max:20','nullable'],
                'transporte_menor_3'=>['string','min:4','max:20','nullable'],
                'transporte_menor_4'=>['string','min:4','max:20','nullable'],
                'vlr_transporte_menor_1'=>['integer','digits_between:5,7','nullable'],
                'vlr_transporte_menor_2'=>['integer','digits_between:5,7','nullable'],
                'vlr_transporte_menor_3'=>['integer','digits_between:5,7','nullable'],
                'vlr_transporte_menor_4'=>['integer','digits_between:5,7','nullable'],
                'materiales'=>['string','min:3','max:50','nullable'],
                'vlr_total_materiales'=>['integer','digits_between:5,7','nullable'],
                'guiasbaquianos'=>['string','min:3','max:50','nullable'],
                'vlr_total_guiasbaquianos'=>['integer','digits_between:5,7','nullable'],
                'boletasotros'=>['string','min:3','max:50','nullable'],
                'vlr_total_boletasotros'=>['integer','digits_between:5,7','nullable'],
                'areas_acuaticas'=>['required','integer','digits:1','min:0','max:1'],
                'alturas'=>['required','integer','digits:1','min:0','max:1'],
                'riesgo_biologico'=>['required','integer','digits:1','min:0','max:1'],
                'espacios_confinados'=>['required','integer','digits:1','min:0','max:1'],
                'cronograma_recorrido'=>['required','string','min:15','max:1000000'],
                'obs_practica'=>['string','min:15','max:1000000','nullable'],
                'just_practica'=>['required','string','min:15','max:1000000'],
                'obj_gral_practica'=>['required','string','min:15','max:1000000'],
                'met_trabajo_eval_practica'=>['required','string','min:15','max:1000000'],
                'vac_fiebre_amarilla'=>['required','integer','digits:1','min:0','max:1'],
                'vac_tetanos'=>['required','integer','digits:1','min:0','max:1'],
                'certificado_adicional_1'=>['required','integer','digits:1','min:0','max:1'],
                'certificado_adicional_2'=>['required','integer','digits:1','min:0','max:1'],
                'certificado_adicional_3'=>['required','integer','digits:1','min:0','max:1'],
                'det_cert_adicional_1'=>['string','min:3','max:50','nullable'],
                'det_cert_adicional_2'=>['string','min:3','max:50','nullable'],
                'det_cert_adicional_3'=>['string','min:3','max:50','nullable'],
        ];

        $itemValidado=Validator::make($data,$rules);

        return $itemValidado;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $collectionValidada= new collection;

        foreach($collection as $row)
        {
           $itemValidado = $this->validator($row->all())->validate();
           $collectionValidada->push($itemValidado);
        }

        // DB::beginTransaction();
        // try
        // {

            $idUser_log = Auth::user()->id;
            $mytime = Carbon::now('America/Bogota');
            $sistema = DB::table('control_sistema')->first();
            $user_log = User::where('id','=',$idUser_log)->first();

            $vlr_estud_max= $sistema->vlr_estud_max;
            $vlr_estud_min= $sistema->vlr_estud_min;
            $vlr_docen_max= $sistema->vlr_docen_max;
            $vlr_docen_min= $sistema->vlr_docen_min;

            foreach($collectionValidada as $row)
            {

                $id_proy = $row['id_proyeccion'];
                $proyeccion_preliminar = proyeccion::where('id', $id_proy)->first();
                $solicitud_practica = solicitud::where('id_proyeccion_preliminar', $id_proy)->first();
                $transporte_proyeccion = transporte_proyeccion::where('id','=',$id_proy)->first();
                $practicas_integradas = practicas_integradas::where('id','=',$id_proy)->first();
                $transporte_menor = transporte_menor::where('id','=',$id_proy)->first();
                $costos_proyeccion = costos_proyeccion::where('id','=',$id_proy)->first();
                $mater_herra_proyeccion = materiales_herramientas_proyeccion::where('id', '=', $id_proy)->first();
                $docentes_practica = docentes_practica::where('id','=',$id_proy)->first();
                $riesg_amen_practica = riesgos_amenazas_practica::where('id','=',$id_proy)->first();
                $doc_req_solicitud = documentos_requeridos_solicitud::where('id','=',$solicitud_practica->id)->first();

                $docente_responsable = DB::table('users')
                    ->select('id','id_programa_academico_coord','users.id_role as id_role',
                    'users.id_espacio_academico_1','users.id_espacio_academico_2','users.id_espacio_academico_3',
                    'users.id_espacio_academico_4','users.id_espacio_academico_5','users.id_espacio_academico_6',
                    DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                    ->where('id',$row['num_ident_docente'])->first();

                $esp_doc_responsable=DB::table('espacio_academico as esp_aca')
                ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                        'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
                ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
                ->whereIn('esp_aca.id', [$docente_responsable->id_espacio_academico_1, $docente_responsable->id_espacio_academico_2,
                 $docente_responsable->id_espacio_academico_3,$docente_responsable->id_espacio_academico_4, $docente_responsable->id_espacio_academico_5,
                 $docente_responsable->id_espacio_academico_6])->get();    

                $total_estudiantes = $row['numero_de_estudiantes'];
                $total_personal_apoyo = $row['cant_personal_apoyo'];
                $total_docentes = 1;
                $total_doc_participantes = 0;
                
                $integrada = $row['practica_integrada'];    

                if($integrada == 1)
                {
                    $total_doc_participantes = $row['cant_docentes_participantes'];
                    $total_docentes = $total_docentes + $total_doc_participantes;
                }

                if($row['id_tipo_personal_apoyo_1'] == 1)
                {
                    $total_estudiantes++;
                }
                if($row['id_tipo_personal_apoyo_1'] == 2)
                {
                    $total_docentes++;
                }
                if($row['id_tipo_personal_apoyo_2'] == 1)
                {
                    $total_estudiantes++;
                }
                if($row['id_tipo_personal_apoyo_2'] == 2)
                {
                    $total_docentes++; 
                }
                
                $tipo_ruta = $row['tipo_ruta'];

                $proyeccion_preliminar->cantidad_grupos = $row['cant_grupos'];
                $proyeccion_preliminar->grupo_1 = $row['grupo_1'];
                $proyeccion_preliminar->grupo_2 = $row['grupo_2'];
                $proyeccion_preliminar->grupo_3 = $row['grupo_3'];
                $proyeccion_preliminar->grupo_4 = $row['grupo_4'];

                $solicitud_practica->num_estudiantes = $row['numero_de_estudiantes'];
                $solicitud_practica->total_personal_apoyo = $row['cant_personal_apoyo'];
                $solicitud_practica->total_docentes_participantes = $row['cant_docentes_participantes'];

                $docentes_practica->total_personal_apoyo = $row['cant_personal_apoyo'];
                $docentes_practica->id_tipo_personal_apoyo_1 = $row['id_tipo_personal_apoyo_1'];
                $docentes_practica->personal_apoyo_1 = $row['personal_apoyo_1'];
                $docentes_practica->num_doc_personal_apoyo_1 = $row['num_ident_personal_apoyo_1'];
                $docentes_practica->id_tipo_personal_apoyo_2 = $row['id_tipo_personal_apoyo_2'];
                $docentes_practica->personal_apoyo_2 = $row['personal_apoyo_2'];
                $docentes_practica->num_doc_personal_apoyo_2 = $row['num_ident_personal_apoyo_2'];

                $practicas_integradas->cant_espa_aca = $row['cant_docentes_participantes'];
                $practicas_integradas->id_docen_espa_aca_1 = $row['num_ident_docente_participante_1'];
                $practicas_integradas->id_docen_espa_aca_2 = $row['num_ident_docente_participante_2'];
                $practicas_integradas->id_docen_espa_aca_3 = $row['num_ident_docente_participante_3'];
                $practicas_integradas->id_docen_espa_aca_4 = $row['num_ident_docente_participante_4'];
                $practicas_integradas->id_docen_espa_aca_5 = $row['num_ident_docente_participante_5'];
                $practicas_integradas->id_docen_espa_aca_6 = $row['num_ident_docente_participante_6'];
                $practicas_integradas->id_docen_espa_aca_7 = $row['num_ident_docente_participante_7'];
                $practicas_integradas->id_espa_aca_1 = $row['id_esp_acad_docente_participante_1'];
                $practicas_integradas->id_espa_aca_2 = $row['id_esp_acad_docente_participante_2'];
                $practicas_integradas->id_espa_aca_3 = $row['id_esp_acad_docente_participante_3'];
                $practicas_integradas->id_espa_aca_4 = $row['id_esp_acad_docente_participante_4'];
                $practicas_integradas->id_espa_aca_5 = $row['id_esp_acad_docente_participante_5'];
                $practicas_integradas->id_espa_aca_6 = $row['id_esp_acad_docente_participante_6'];
                $practicas_integradas->id_espa_aca_7 = $row['id_esp_acad_docente_participante_7'];

                $total_estudiantes = $solicitud_practica->num_estudiantes;
                $total_personal_apoyo = $row['cant_personal_apoyo'];
                $total_docentes = 1;
                $total_doc_participantes = 0;
                
                $integrada = $row['practica_integrada'];    

                if($integrada == 1)
                {
                    $total_doc_participantes = $row['cant_docentes_participantes'];
                    $total_docentes = $total_docentes + $total_doc_participantes;
                    $proyeccion_preliminar->practicas_integradas = $integrada;
                }

                if($docentes_practica->id_tipo_personal_apoyo_1 == 1)
                {
                    $total_estudiantes++;
                }
                if($docentes_practica->id_tipo_personal_apoyo_1 == 2)
                {
                    $total_docentes++;
                }
                if($docentes_practica->id_tipo_personal_apoyo_2 == 1)
                {
                    $total_estudiantes++;
                }
                if($docentes_practica->id_tipo_personal_apoyo_2 == 2)
                {
                    $total_docentes++;
                }

                $solicitud_practica->tipo_ruta = $tipo_ruta;
                $solicitud_practica->detalle_recorrido_interno = $row['detalle_del_recorrido_interno'];

                $solicitud_practica->lugar_salida = $row['id_sede_salida'];
                $solicitud_practica->lugar_regreso = $row['id_sede_regreso'];
                $solicitud_practica->fecha_salida = $row['salida_fecha_confirmada'];
                $solicitud_practica->hora_salida = $row['hora_salida'];
                $solicitud_practica->fecha_regreso = $row['regreso_fecha_confirmada'];
                $solicitud_practica->hora_regreso = $row['hora_regreso'];

                $fecha_salida = new DateTime($solicitud_practica->fecha_salida);
                $fecha_regreso = new DateTime($solicitud_practica->fecha_regreso);
                $num_dias = $fecha_salida->diff($fecha_regreso);
                $num_dias = $num_dias->days+1;
                $solicitud_practica->duracion_num_dias= $num_dias;

                if($tipo_ruta == 1)
                {
                    $transporte_proyeccion->det_tipo_transporte_rp=$row['det_vehiculo'];
                    $transporte_proyeccion->exclusiv_tiempo_rp=$row['disp_permanente_vehiculo'];

                    $transporte_menor->docente_resp_t_menor_rp=$docente_responsable->full_name;
                    $transporte_menor->cant_trans_menor_rp=$row['cant_transporte_menor'];
                    $transporte_menor->trans_menor_rp_1=$row['transporte_menor_1'];
                    $transporte_menor->trans_menor_rp_2=$row['transporte_menor_2'];
                    $transporte_menor->trans_menor_rp_3=$row['transporte_menor_3'];
                    $transporte_menor->trans_menor_rp_4=$row['transporte_menor_4'];

                    $vlr_trans_menor_rp_1=intval(str_replace(".","",$row['vlr_transporte_menor_1']));
                    $vlr_trans_menor_rp_2=intval(str_replace(".","",$row['vlr_transporte_menor_2']));
                    $vlr_trans_menor_rp_3=intval(str_replace(".","",$row['vlr_transporte_menor_3']));
                    $vlr_trans_menor_rp_4=intval(str_replace(".","",$row['vlr_transporte_menor_4']));

                    $transporte_menor->vlr_trans_menor_rp_1=$vlr_trans_menor_rp_1;
                    $transporte_menor->vlr_trans_menor_rp_2=$vlr_trans_menor_rp_2;
                    $transporte_menor->vlr_trans_menor_rp_3=$vlr_trans_menor_rp_3;
                    $transporte_menor->vlr_trans_menor_rp_4=$vlr_trans_menor_rp_4;
                    
                    $mater_herra_proyeccion->det_materiales_rp = $row['materiales'];
                    $mater_herra_proyeccion->det_otros_boletas_rp = $row['guiasbaquianos'];
                    $mater_herra_proyeccion->det_guias_baquianos_rp = $row['boletasotros'];

                    $vlr_materiales_rp=str_replace(".","",$row['vlr_total_materiales']);
                    $vlr_materiales_rp=intval(str_replace("$","", $vlr_materiales_rp));
                    $vlr_guias_baquianos_rp=str_replace(".","",$row['vlr_total_guiasbaquianos']);
                    $vlr_guias_baquianos_rp=intval(str_replace("$","", $vlr_guias_baquianos_rp));
                    $vlr_otros_boletas_rp=str_replace(".","",$row['vlr_total_boletasotros']);
                    $vlr_otros_boletas_rp=intval(str_replace("$","", $vlr_otros_boletas_rp));

                    $costos_proyeccion->vlr_materiales_rp = $vlr_materiales_rp;
                    $costos_proyeccion->vlr_guias_baquianos_rp = $vlr_guias_baquianos_rp;
                    $costos_proyeccion->vlr_otros_boletas_rp = $vlr_otros_boletas_rp;

                    if($num_dias==1)
                    {
                        $viaticos_estudiantes_rp = $total_estudiantes*$vlr_estud_min*$num_dias;
                        $viaticos_docente_rp = $vlr_docen_min;
                    }
                    else if($num_dias>1)
                    {
                        $viaticos_estudiantes_rp = $total_estudiantes*$vlr_estud_max*$num_dias;
                        $viaticos_docente_rp = ($num_dias-0.5)*$vlr_docen_max*$total_docentes;
                    }

                    $costos_proyeccion->viaticos_estudiantes_rp = $viaticos_estudiantes_rp;
                    $costos_proyeccion->viaticos_docente_rp = $viaticos_docente_rp;
                    $total_otros_rp = $vlr_materiales_rp + $vlr_guias_baquianos_rp + $vlr_otros_boletas_rp;
                    $costo_total_transporte_menor_rp = $vlr_trans_menor_rp_1 + $vlr_trans_menor_rp_2 + $vlr_trans_menor_rp_3 + $vlr_trans_menor_rp_4;

                    $costos_proyeccion->costo_total_transporte_menor_rp = $costo_total_transporte_menor_rp;
                    $costos_proyeccion->total_presupuesto_rp = $viaticos_docente_rp + $viaticos_estudiantes_rp + $total_otros_rp + $costo_total_transporte_menor_rp;

                    $riesg_amen_practica->areas_acuaticas_rp= $row['areas_acuaticas'];
                    $riesg_amen_practica->alturas_rp= $row['alturas'];
                    $riesg_amen_practica->riesgo_biologico_rp= $row['riesgo_biologico'];
                    $riesg_amen_practica->espacios_confinados_rp= $row['espacios_confinados'];

                }
                else if($tipo_ruta == 2)
                {
                    $transporte_proyeccion->det_tipo_transporte_ra=$row['det_vehiculo'];
                    $transporte_proyeccion->exclusiv_tiempo_ra=$row['disp_permanente_vehiculo'];

                    $transporte_menor->docente_resp_t_menor_ra=$docente_responsable->full_name;
                    $transporte_menor->cant_trans_menor_ra=$row['cant_transporte_menor'];
                    $transporte_menor->trans_menor_ra_1=$row['transporte_menor_1'];
                    $transporte_menor->trans_menor_ra_2=$row['transporte_menor_1'];
                    $transporte_menor->trans_menor_ra_3=$row['transporte_menor_1'];
                    $transporte_menor->trans_menor_ra_4=$row['transporte_menor_1'];

                    $vlr_trans_menor_ra_1=intval(str_replace(".","",$row['vlr_transporte_menor_1']));
                    $vlr_trans_menor_ra_2=intval(str_replace(".","",$row['vlr_transporte_menor_2']));
                    $vlr_trans_menor_ra_3=intval(str_replace(".","",$row['vlr_transporte_menor_3']));
                    $vlr_trans_menor_ra_4=intval(str_replace(".","",$row['vlr_transporte_menor_4']));

                    $transporte_menor->vlr_trans_menor_ra_1=$vlr_trans_menor_ra_1;
                    $transporte_menor->vlr_trans_menor_ra_2=$vlr_trans_menor_ra_2;
                    $transporte_menor->vlr_trans_menor_ra_3=$vlr_trans_menor_ra_3;
                    $transporte_menor->vlr_trans_menor_ra_4=$vlr_trans_menor_ra_4;

                    $mater_herra_proyeccion->det_materiales_ra = $row['materiales'];
                    $mater_herra_proyeccion->det_otros_boletas_ra = $row['guiasbaquianos'];
                    $mater_herra_proyeccion->det_guias_baquianos_ra = $row['boletasotros'];

                    $vlr_materiales_ra=str_replace(".","",$row['vlr_total_materiales']);
                    $vlr_materiales_ra=intval(str_replace("$","", $vlr_materiales_ra));
                    $vlr_guias_baquianos_ra=str_replace(".","",$row['vlr_total_guiasbaquianos']);
                    $vlr_guias_baquianos_ra=intval(str_replace("$","", $vlr_guias_baquianos_ra));
                    $vlr_otros_boletas_ra=str_replace(".","",$row['vlr_total_boletasotros']);
                    $vlr_otros_boletas_ra=intval(str_replace("$","", $vlr_otros_boletas_ra));

                    $costos_proyeccion->vlr_materiales_ra = $vlr_materiales_ra;
                    $costos_proyeccion->vlr_guias_baquianos_ra = $vlr_guias_baquianos_ra;
                    $costos_proyeccion->vlr_otros_boletas_ra = $vlr_otros_boletas_ra;

                    if($num_dias==1)
                    {
                        $viaticos_estudiantes_ra = $total_estudiantes*$vlr_estud_min*$num_dias;
                        $viaticos_docente_ra = $vlr_docen_min;
                    }
                    else if($num_dias>1)
                    {
                        $viaticos_estudiantes_ra = $total_estudiantes*$vlr_estud_max*$num_dias;
                        $viaticos_docente_ra = ($num_dias-0.5)*$vlr_docen_max*$total_docentes;
                    }

                    $costos_proyeccion->viaticos_estudiantes_ra = $viaticos_estudiantes_ra;
                    $costos_proyeccion->viaticos_docente_ra = $viaticos_docente_ra;
                    $total_otros_ra = $vlr_materiales_ra + $vlr_guias_baquianos_ra + $vlr_otros_boletas_ra;
                    $costo_total_transporte_menor_ra = $vlr_trans_menor_ra_1 + $vlr_trans_menor_ra_2 + $vlr_trans_menor_ra_3 + $vlr_trans_menor_ra_4;

                    $costos_proyeccion->costo_total_transporte_menor_ra = $costo_total_transporte_menor_ra;
                    $costos_proyeccion->total_presupuesto_ra = $viaticos_docente_ra + $viaticos_estudiantes_ra + $total_otros_ra + $costo_total_transporte_menor_ra;

                    $riesg_amen_practica->areas_acuaticas_ra= $row['areas_acuaticas'];
                    $riesg_amen_practica->alturas_ra= $row['alturas'];
                    $riesg_amen_practica->riesgo_biologico_ra= $row['riesgo_biologico'];
                    $riesg_amen_practica->espacios_confinados_ra= $row['espacios_confinados'];
                }

                $solicitud_practica->cronograma= $row['cronograma_recorrido'];
                $solicitud_practica->observaciones= $row['obs_practica'];
                $solicitud_practica->justificacion= $row['just_practica'];
                $solicitud_practica->objetivo_general= $row['obj_gral_practica'];
                $solicitud_practica->metodologia_evaluacion= $row['met_trabajo_eval_practica'];

                $doc_req_solicitud->seguro_estudiantil=1;
                $doc_req_solicitud->documento_identificacion=1;
                $doc_req_solicitud->documento_rh=1;
                $doc_req_solicitud->certificado_eps=1;
                $doc_req_solicitud->permiso_acudiente=0;
                $doc_req_solicitud->vacuna_fiebre_amarilla= $row['vac_fiebre_amarilla'];
                $doc_req_solicitud->vacuna_tetanos= $row['vac_tetanos'];
                $doc_req_solicitud->certificado_adicional_1= $row['certificado_adicional_1'];
                $doc_req_solicitud->certificado_adicional_2= $row['certificado_adicional_2'];
                $doc_req_solicitud->certificado_adicional_3= $row['certificado_adicional_3'];
                $doc_req_solicitud->detalle_certificado_adcional_1= $row['det_cert_adicional_1'];
                $doc_req_solicitud->detalle_certificado_adcional_2= $row['det_cert_adicional_2'];
                $doc_req_solicitud->detalle_certificado_adcional_3= $row['det_cert_adicional_3'];

                $confim_docente = 0;
                $id_docente_confirm=null;   

                $solicitud_practica->confirm_creador= 1;
                $solicitud_practica->confirm_docente= 1;
                
                $solicitud_practica->id_docente_creador = $docente_responsable->id;
                $solicitud_practica->id_docente_confirm = $docente_responsable->id;

                $solicitud_practica->aprobacion_asistD= 5;
                $solicitud_practica->aprobacion_coordinador= 5;
                $solicitud_practica->aprobacion_decano= 5;

                $total_asistentes = $total_estudiantes + $total_personal_apoyo + $total_doc_participantes + 1;
                $transporte_proyeccion->total_asistentes=$total_asistentes;

                $costos_proyeccion->update();
                $docentes_practica->update();
                $practicas_integradas->update();
                $doc_req_solicitud->update();
                $mater_herra_proyeccion->update();
                $riesg_amen_practica->update();
                $transporte_menor->update();
                $transporte_proyeccion->update();
                $proyeccion_preliminar->update();
                $solicitud_practica->update();

            }
        // }
        // catch(\Exception $ex)
        // {
        //     DB::rollback();
        //     return  back()->withError('Falla en la creación del usuario.');
        // }
    }
}
