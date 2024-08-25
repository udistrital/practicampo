<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Concerns\WithTitle;
use phpDocumentor\Reflection\Types\Collection;
use push;
use Maatwebsite\Excel\Row;

use DB;
use PhpParser\Node\Expr\AssignOp\Concat;
use PractiCampoUD\solicitud;

class SolicitudesPracticasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    use Exportable;
    public function __construct($id_solicitud)
    {
        $this->id_solicitud = $id_solicitud;
    }

    public function collection()
    {
        $lista_solicitudes = $this->id_solicitud;
        $solicitud = collect();

        foreach($lista_solicitudes[0]  as $id_solicitud)
        {
            $tipo_ruta =DB::table('solicitud_practica as sol_prac')
                ->select('sol_prac.tipo_ruta')
                ->where('sol_prac.id','=',$id_solicitud)->first();
            $t_r = $tipo_ruta->tipo_ruta;

            if($t_r == null)
            {
                $solicitudes=DB::table('proyeccion_preliminar as proy_prel')
                ->select('proy_prel.id', 'sol_prac.id as id_solicitud','prog_aca.programa_academico', 'espa.codigo_espacio_academico','espa.espacio_academico', 'sem_asig.semestre_asignatura', 
                    'proy_prel.anio_periodo','per_aca.periodo_academico','proy_prel.id_docente_responsable',
                     DB::raw('CONCAT_WS(" ", us.primer_nombre, us.segundo_nombre, us.primer_apellido, us.segundo_apellido) as full_name'),
                    'proy_prel.grupo_1', 'proy_prel.grupo_2', 'proy_prel.grupo_3', 'proy_prel.grupo_4', 
                    'proy_prel.num_estudiantes_aprox','doce_prac.num_docentes_apoyo','doce_prac.total_docentes_apoyo','doce_prac.total_docentes_apoyo','doce_prac.docente_apoyo_1','doce_prac.docente_apoyo_2','doce_prac.docente_apoyo_3',
                    'doce_prac.docente_apoyo_4','doce_prac.docente_apoyo_5','doce_prac.docente_apoyo_6','doce_prac.docente_apoyo_7','doce_prac.docente_apoyo_8',
                    'doce_prac.docente_apoyo_9','doce_prac.docente_apoyo_10','sol_prac.tipo_ruta as tipo_ruta'
                    )
                    ->join('solicitud_practica as sol_prac','proy_prel.id','=','sol_prac.id_proyeccion_preliminar')
                    ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
                    ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
                    ->join('periodo_academico as per_aca','proy_prel.id_periodo_academico','=','per_aca.id')
                    ->join('semestre_asignatura as sem_asig','proy_prel.id_semestre_asignatura','=','sem_asig.id')
                    ->join('docentes_practica as doce_prac','proy_prel.id','=','doce_prac.id')
                    ->join('sedes_universidad as salida_rp','proy_prel.lugar_salida_rp','=','salida_rp.id')
                    ->join('sedes_universidad as regreso_rp','proy_prel.lugar_salida_rp','=','regreso_rp.id')
                    ->join('transporte_proyeccion as trans_proy','proy_prel.id','=','trans_proy.id')
                    ->join('transporte_menor as trans_menor','proy_prel.id','=','trans_menor.id')
                    ->join('materiales_herramientas_proyeccion as mate','proy_prel.id','=','mate.id')
                    ->join('riesgos_amenazas_practica as riesgos','proy_prel.id','=','riesgos.id')
                    ->leftjoin('tipo_transporte as tip_tra_rp1','trans_proy.id_tipo_transporte_rp_1','=','tip_tra_rp1.id')
                    ->leftjoin('tipo_transporte as tip_tra_rp2','trans_proy.id_tipo_transporte_rp_2','=','tip_tra_rp2.id')
                    ->leftjoin('tipo_transporte as tip_tra_rp3','trans_proy.id_tipo_transporte_rp_3','=','tip_tra_rp3.id')
                    ->join('users as us','proy_prel.id_docente_responsable','=','us.id')
                    ->join('costos_proyeccion as c_proy','proy_prel.id','=','c_proy.id')
                    ->join('estado as es_coor','proy_prel.aprobacion_coordinador','=','es_coor.id')
                    ->join('estado as es_dec','proy_prel.aprobacion_decano','=','es_dec.id')
                    ->join('estado as es_consj','proy_prel.aprobacion_consejo_facultad','=','es_consj.id')
                    ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                    ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                    ->where('sol_prac.id','=',$id_solicitud)->first();
                    $solicitudes->tipo_ruta = "Sin definir";
                $solicitud->push($solicitudes);
            }

            if($t_r == 1)
            {
                $solicitudes=DB::table('proyeccion_preliminar as proy_prel')
                ->select('proy_prel.id', 'sol_prac.id as id_solicitud','prog_aca.programa_academico', 'espa.codigo_espacio_academico','espa.espacio_academico', 'sem_asig.semestre_asignatura', 
                    'proy_prel.anio_periodo','per_aca.periodo_academico','proy_prel.id_docente_responsable',
                     DB::raw('CONCAT_WS(" ", us.primer_nombre, us.segundo_nombre, us.primer_apellido, us.segundo_apellido) as full_name'),
                    'proy_prel.grupo_1', 'proy_prel.grupo_2', 'proy_prel.grupo_3', 'proy_prel.grupo_4', 
                    'proy_prel.num_estudiantes_aprox','doce_prac.num_docentes_apoyo','doce_prac.total_docentes_apoyo','doce_prac.docente_apoyo_1','doce_prac.docente_apoyo_2','doce_prac.docente_apoyo_3',
                    'doce_prac.docente_apoyo_4','doce_prac.docente_apoyo_5','doce_prac.docente_apoyo_6','doce_prac.docente_apoyo_7','doce_prac.docente_apoyo_8',
                    'doce_prac.docente_apoyo_9','doce_prac.docente_apoyo_10','sol_prac.tipo_ruta as tipo_ruta',
                    'proy_prel.destino_rp', 'proy_prel.cantidad_url_rp', 'proy_prel.ruta_principal', 'proy_prel.ruta_principal_2', 'proy_prel.ruta_principal_3', 
                    'proy_prel.ruta_principal_4', 'proy_prel.ruta_principal_5', 'proy_prel.ruta_principal_6', 
                    'proy_prel.det_recorrido_interno_rp', 'salida_rp.sede as sede_salida','regreso_rp.sede as sede_regreso',
                    'sol_prac.fecha_salida','sol_prac.hora_salida','sol_prac.fecha_regreso','sol_prac.hora_regreso','sol_prac.duracion_num_dias', 
                    'trans_proy.cant_transporte_rp',
                    'tip_tra_rp1.tipo_transporte as tip_t_rp_1','trans_proy.capac_transporte_rp_1','trans_proy.det_tipo_transporte_rp_1','trans_proy.exclusiv_tiempo_rp_1',
                    'tip_tra_rp2.tipo_transporte as tip_t_rp_2','trans_proy.capac_transporte_rp_2','trans_proy.det_tipo_transporte_rp_2','trans_proy.exclusiv_tiempo_rp_2',
                    'tip_tra_rp3.tipo_transporte as tip_t_rp_3','trans_proy.capac_transporte_rp_3','trans_proy.det_tipo_transporte_rp_3','trans_proy.exclusiv_tiempo_rp_3',
                    'c_proy.valor_estimado_transporte_rp',
                    'trans_menor.cant_trans_menor_rp','trans_menor.trans_menor_rp_1','trans_menor.vlr_trans_menor_rp_1','trans_menor.trans_menor_rp_2',
                    'trans_menor.vlr_trans_menor_rp_2','trans_menor.trans_menor_rp_3','trans_menor.vlr_trans_menor_rp_3','trans_menor.trans_menor_rp_4',
                    'trans_menor.vlr_trans_menor_rp_4',
                    'mate.det_materiales_rp','c_proy.vlr_materiales_rp','mate.det_guias_baquianos_rp','c_proy.vlr_guias_baquianos_rp','mate.det_otros_boletas_rp',
                    'c_proy.vlr_otros_boletas_rp',
                    'riesgos.areas_acuaticas_rp','riesgos.alturas_rp','riesgos.riesgo_biologico_rp','riesgos.espacios_confinados_rp',
                    'c_proy.viaticos_estudiantes_rp','c_proy.viaticos_docente_rp',  'c_proy.total_presupuesto_rp',
                    'sol_prac.cronograma','sol_prac.observaciones','sol_prac.justificacion','sol_prac.objetivo_general','sol_prac.metodologia_evaluacion',
                    'es_coor_sol.abrev as es_coor','es_dec_sol.abrev as es_dec'
                    )
                    ->join('solicitud_practica as sol_prac','proy_prel.id','=','sol_prac.id_proyeccion_preliminar')
                    ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
                    ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
                    ->join('periodo_academico as per_aca','proy_prel.id_periodo_academico','=','per_aca.id')
                    ->join('semestre_asignatura as sem_asig','proy_prel.id_semestre_asignatura','=','sem_asig.id')
                    ->join('docentes_practica as doce_prac','proy_prel.id','=','doce_prac.id')
                    ->join('sedes_universidad as salida_rp','proy_prel.lugar_salida_rp','=','salida_rp.id')
                    ->join('sedes_universidad as regreso_rp','proy_prel.lugar_salida_rp','=','regreso_rp.id')
                    ->join('transporte_proyeccion as trans_proy','proy_prel.id','=','trans_proy.id')
                    ->join('transporte_menor as trans_menor','proy_prel.id','=','trans_menor.id')
                    ->join('materiales_herramientas_proyeccion as mate','proy_prel.id','=','mate.id')
                    ->join('riesgos_amenazas_practica as riesgos','proy_prel.id','=','riesgos.id')
                    ->leftjoin('tipo_transporte as tip_tra_rp1','trans_proy.id_tipo_transporte_rp_1','=','tip_tra_rp1.id')
                    ->leftjoin('tipo_transporte as tip_tra_rp2','trans_proy.id_tipo_transporte_rp_2','=','tip_tra_rp2.id')
                    ->leftjoin('tipo_transporte as tip_tra_rp3','trans_proy.id_tipo_transporte_rp_3','=','tip_tra_rp3.id')
                    ->join('users as us','proy_prel.id_docente_responsable','=','us.id')
                    ->join('costos_proyeccion as c_proy','proy_prel.id','=','c_proy.id')
                    ->join('estado as es_coor','proy_prel.aprobacion_coordinador','=','es_coor.id')
                    ->join('estado as es_dec','proy_prel.aprobacion_decano','=','es_dec.id')
                    ->join('estado as es_consj','proy_prel.aprobacion_consejo_facultad','=','es_consj.id')
                    ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                    ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                    ->where('sol_prac.id','=',$id_solicitud)->first();
                    $solicitudes->tipo_ruta = "Principal";
                $solicitud->push($solicitudes);
            }

            else if($t_r == 2)
            {
                $solicitudes=DB::table('proyeccion_preliminar as proy_prel')
                ->select('proy_prel.id', 'sol_prac.id as id_solicitud','prog_aca.programa_academico', 'espa.codigo_espacio_academico','espa.espacio_academico', 'sem_asig.semestre_asignatura', 
                    'proy_prel.anio_periodo','per_aca.periodo_academico','proy_prel.id_docente_responsable',
                     DB::raw('CONCAT_WS(" ", us.primer_nombre, us.segundo_nombre, us.primer_apellido, us.segundo_apellido) as full_name'),
                    'proy_prel.grupo_1', 'proy_prel.grupo_2', 'proy_prel.grupo_3', 'proy_prel.grupo_4', 
                    'proy_prel.num_estudiantes_aprox','doce_prac.num_docentes_apoyo','doce_prac.total_docentes_apoyo','doce_prac.docente_apoyo_1','doce_prac.docente_apoyo_2','doce_prac.docente_apoyo_3',
                    'doce_prac.docente_apoyo_4','doce_prac.docente_apoyo_5','doce_prac.docente_apoyo_6','doce_prac.docente_apoyo_7','doce_prac.docente_apoyo_8',
                    'doce_prac.docente_apoyo_9','doce_prac.docente_apoyo_10','sol_prac.tipo_ruta as tipo_ruta',
                    'proy_prel.destino_ra', 'proy_prel.cantidad_url_ra', 'proy_prel.ruta_alterna', 'proy_prel.ruta_alterna_2', 'proy_prel.ruta_alterna_3', 
                    'proy_prel.ruta_alterna_4', 'proy_prel.ruta_alterna_5', 'proy_prel.ruta_alterna_6', 
                    'proy_prel.det_recorrido_interno_ra', 'salida_ra.sede as sede_salida','regreso_ra.sede as sede_regreso',
                    'sol_prac.fecha_salida','sol_prac.hora_salida','sol_prac.fecha_regreso','sol_prac.hora_regreso','sol_prac.duracion_num_dias', 
                    'trans_proy.cant_transporte_ra',
                    'tip_tra_ra1.tipo_transporte as tip_t_ra_1','trans_proy.capac_transporte_ra_1','trans_proy.det_tipo_transporte_ra_1','trans_proy.exclusiv_tiempo_ra_1',
                    'tip_tra_ra2.tipo_transporte as tip_t_ra_2','trans_proy.capac_transporte_ra_2','trans_proy.det_tipo_transporte_ra_2','trans_proy.exclusiv_tiempo_ra_2',
                    'tip_tra_ra3.tipo_transporte as tip_t_ra_3','trans_proy.capac_transporte_ra_3','trans_proy.det_tipo_transporte_ra_3','trans_proy.exclusiv_tiempo_ra_3',
                    'c_proy.valor_estimado_transporte_ra',
                    'trans_menor.cant_trans_menor_ra','trans_menor.trans_menor_ra_1','trans_menor.vlr_trans_menor_ra_1','trans_menor.trans_menor_ra_2',
                    'trans_menor.vlr_trans_menor_ra_2','trans_menor.trans_menor_ra_3','trans_menor.vlr_trans_menor_ra_3','trans_menor.trans_menor_ra_4',
                    'trans_menor.vlr_trans_menor_ra_4',
                    'mate.det_materiales_ra','c_proy.vlr_materiales_ra','mate.det_guias_baquianos_ra','c_proy.vlr_guias_baquianos_ra','mate.det_otros_boletas_ra',
                    'c_proy.vlr_otros_boletas_ra',
                    'riesgos.areas_acuaticas_ra','riesgos.alturas_ra','riesgos.riesgo_biologico_ra','riesgos.espacios_confinados_ra',
                    'c_proy.viaticos_estudiantes_ra','c_proy.viaticos_docente_ra',  'c_proy.total_presupuesto_ra',
                    'sol_prac.cronograma','sol_prac.observaciones','sol_prac.justificacion','sol_prac.objetivo_general','sol_prac.metodologia_evaluacion',
                    'es_coor_sol.abrev as es_coor','es_dec_sol.abrev as es_dec'
                    )
                    ->join('solicitud_practica as sol_prac','proy_prel.id','=','sol_prac.id_proyeccion_preliminar')
                    ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
                    ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
                    ->join('periodo_academico as per_aca','proy_prel.id_periodo_academico','=','per_aca.id')
                    ->join('semestre_asignatura as sem_asig','proy_prel.id_semestre_asignatura','=','sem_asig.id')
                    ->join('docentes_practica as doce_prac','proy_prel.id','=','doce_prac.id')
                    ->join('sedes_universidad as salida_ra','proy_prel.lugar_salida_ra','=','salida_ra.id')
                    ->join('sedes_universidad as regreso_ra','proy_prel.lugar_salida_ra','=','regreso_ra.id')
                    ->join('transporte_proyeccion as trans_proy','proy_prel.id','=','trans_proy.id')
                    ->join('transporte_menor as trans_menor','proy_prel.id','=','trans_menor.id')
                    ->join('materiales_herramientas_proyeccion as mate','proy_prel.id','=','mate.id')
                    ->join('riesgos_amenazas_practica as riesgos','proy_prel.id','=','riesgos.id')
                    ->leftjoin('tipo_transporte as tip_tra_ra1','trans_proy.id_tipo_transporte_ra_1','=','tip_tra_ra1.id')
                    ->leftjoin('tipo_transporte as tip_tra_ra2','trans_proy.id_tipo_transporte_ra_2','=','tip_tra_ra2.id')
                    ->leftjoin('tipo_transporte as tip_tra_ra3','trans_proy.id_tipo_transporte_ra_3','=','tip_tra_ra3.id')
                    ->join('users as us','proy_prel.id_docente_responsable','=','us.id')
                    ->join('costos_proyeccion as c_proy','proy_prel.id','=','c_proy.id')
                    ->join('estado as es_coor','proy_prel.aprobacion_coordinador','=','es_coor.id')
                    ->join('estado as es_dec','proy_prel.aprobacion_decano','=','es_dec.id')
                    ->join('estado as es_consj','proy_prel.aprobacion_consejo_facultad','=','es_consj.id')
                    ->join('estado as es_coor_sol','sol_prac.aprobacion_coordinador','=','es_coor_sol.id')
                    ->join('estado as es_dec_sol','sol_prac.aprobacion_decano','=','es_dec_sol.id')
                    ->where('sol_prac.id','=',$id_solicitud)->first();
                    $solicitudes->tipo_ruta = "Contingencia";
                $solicitud->push($solicitudes);
            }
        }

        return $solicitud;
    }

    public function headings():array
    {
        return['ID PROYECCIÓN','ID SOLICITUD','PROGRAMA ACADÉMICO', 'CÓD. ESPACIO ACADÉMICO', 'ESPACIO ACADÉMICO', 'SEM. ACA','AÑO PER.','PER. ACA',
                'CÉDULA','DOCENTE RESPONSABLE','GRUPO 1','GRUPO 2','GRUPO 3','GRUPO 4', 'NÚMERO DE ESTUDIANTES','NÚMERO PERSONAS APOYO',
                'TOTAL DOCENTES APOYO',
                'PERSONAL APOYO 1','PERSONAL APOYO 2','PERSONAL APOYO 3','PERSONAL APOYO 4','PERSONAL APOYO 5',
                'PERSONAL APOYO 6','PERSONAL APOYO 7','PERSONAL APOYO 8','PERSONAL APOYO 9','PERSONAL APOYO 10','TIPO RUTA',
                'DESTINO RUTA PRINCIPAL','CANT. URL RUTA','URL 1 RUTA','URL 2 RUTA',
                'URL 3 RUTA','URL 4 RUTA','URL 5 RUTA','URL 6 RUTA', 'DETALLE DEL RECORRIDO INTERNO',
                'SEDE SALIDA','SEDE REGRESO',
                'SALIDA', 'HORA SALIDA','REGRESO', 'HORA REGRESO','N. DÍAS',
                'CANT. VEHÍCULOS',
                'TIPO VEHÍCULO 1', 'CAPAC. VEHÍCULO 1', 'DET. VEHÍCULO 1','DISP. PERMANENTE VEHÍCULO 1',
                'TIPO VEHÍCULO 2', 'CAPAC. VEHÍCULO 2', 'DET. VEHÍCULO 2','DISP. PERMANENTE VEHÍCULO 2',
                'TIPO VEHÍCULO 3', 'CAPAC. VEHÍCULO 3', 'DET. VEHÍCULO 3','DISP. PERMANENTE VEHÍCULO 3',
                'VLR. ESTIMADO TRANSPORTE','CANT. TRANSPORTE MENOR',
                'TRANSPORTE MENOR 1', 'VLR. TRANSPORTE MENOR 1', 'TRANSPORTE MENOR 2','VLR. TRANSPORTE MENOR 2',
                'TRANSPORTE MENOR 3', 'VLR. TRANSPORTE MENOR 3', 'TRANSPORTE MENOR 4','VLR. TRANSPORTE MENOR 4',
                'MATERIALES','VLR. TOTAL MATERIALES','GUÍAS/BAQUIANOS','VLR. TOTAL GUÍAS/BAQUIANOS','BOLETAS/OTROS','VLR. TOTAL BOLETAS/OTROS',
                'ÁREAS ACUÁTICAS','ALTURASP','RIESGO BIOLÓGICO','ESPACIOS CONFINADOS',
                'V. ESTUDIANTES','V. DOCENTES','TOTAL PRESUPUESTO',
                'CRONOGRAMA','OBSERVACIONES','JUSTIFICACIÓN','OBJETIVO GENERAL','METODOLOGÍA EVALUACIÓN',
                'E. COORD', 'E. DECANO'];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:CI1';
                // $cellRangeName ='H1:K1'; 
                // $event->sheet->getDelegate()->mergeCells($cellRangeName);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('74BB96');
            },
            BeforeWriting::class=>function(BeforeWriting $event){
                $event->writer->setActiveSheetIndex(0);
            }
        ];
    }

    public function title(): string
    {
        $titleSheet = "PLAN DE PRACTICAS DE CAMPO";
        return $titleSheet;
    }
}