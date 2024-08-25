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
use push;
use Maatwebsite\Excel\Row;

use DB;
use PhpParser\Node\Expr\AssignOp\Concat;

class ProyeccionesPreliminaresExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    use Exportable;
    public function __construct($id)
    {
        $this->id_proyeccion = $id;
    }

    public function collection()
    {
        $lista_proyecciones = $this->id_proyeccion;
        $proyeccion = collect();

        foreach($lista_proyecciones[0]  as $id_proye)
        {
            
            // $proyecciones=DB::table('proyeccion_preliminar as proy_prel')
            // ->select('proy_prel.id', 'prog_aca.programa_academico', 'espa.codigo_espacio_academico','espa.espacio_academico', 'sem_asig.semestre_asignatura', 
            //         'proy_prel.anio_periodo','per_aca.periodo_academico','proy_prel.id_docente_responsable',
            //          DB::raw('CONCAT_WS(" ", us.primer_nombre, us.segundo_nombre, us.primer_apellido, us.segundo_apellido) as full_name'),
            //         'proy_prel.grupo_1', 'proy_prel.grupo_2', 'proy_prel.grupo_3', 'proy_prel.grupo_4', 
            //         'proy_prel.num_estudiantes_aprox','doce_prac.num_docentes_apoyo','doce_prac.total_docentes_apoyo','doce_prac.docente_apoyo_1','doce_prac.docente_apoyo_2','doce_prac.docente_apoyo_3',
            //         'doce_prac.docente_apoyo_4','doce_prac.docente_apoyo_5','doce_prac.docente_apoyo_6','doce_prac.docente_apoyo_7','doce_prac.docente_apoyo_8',
            //         'doce_prac.docente_apoyo_9','doce_prac.docente_apoyo_10',
            //         'proy_prel.destino_rp', 'proy_prel.cantidad_url_rp', 'proy_prel.ruta_principal', 'proy_prel.ruta_principal_2', 'proy_prel.ruta_principal_3', 
            //         'proy_prel.ruta_principal_4', 'proy_prel.ruta_principal_5', 'proy_prel.ruta_principal_6', 
            //         'proy_prel.det_recorrido_interno_rp', 'salida_rp.sede as sede_salida','regreso_rp.sede as sede_regreso',
            //         'proy_prel.fecha_salida_aprox_rp','proy_prel.fecha_regreso_aprox_rp','proy_prel.duracion_num_dias_rp', 
            //         'trans_proy.cant_transporte_rp',
            //         'tip_tra_rp1.tipo_transporte as tip_t_rp_1','trans_proy.capac_transporte_rp_1','trans_proy.det_tipo_transporte_rp_1','trans_proy.exclusiv_tiempo_rp_1',
            //         'tip_tra_rp2.tipo_transporte as tip_t_rp_2','trans_proy.capac_transporte_rp_2','trans_proy.det_tipo_transporte_rp_2','trans_proy.exclusiv_tiempo_rp_2',
            //         'tip_tra_rp3.tipo_transporte as tip_t_rp_3','trans_proy.capac_transporte_rp_3','trans_proy.det_tipo_transporte_rp_3','trans_proy.exclusiv_tiempo_rp_3',
            //         'c_proy.valor_estimado_transporte_rp',
            //         'trans_menor.cant_trans_menor_rp','trans_menor.trans_menor_rp_1','trans_menor.vlr_trans_menor_rp_1','trans_menor.trans_menor_rp_2',
            //         'trans_menor.vlr_trans_menor_rp_2','trans_menor.trans_menor_rp_3','trans_menor.vlr_trans_menor_rp_3','trans_menor.trans_menor_rp_4',
            //         'trans_menor.vlr_trans_menor_rp_4',
            //         'mate.det_materiales_rp','c_proy.vlr_materiales_rp','mate.det_guias_baquianos_rp','c_proy.vlr_guias_baquianos_rp','mate.det_otros_boletas_rp',
            //         'c_proy.vlr_otros_boletas_rp',
            //         'riesgos.areas_acuaticas_rp','riesgos.alturas_rp','riesgos.riesgo_biologico_rp','riesgos.espacios_confinados_rp',
            //         'c_proy.viaticos_estudiantes_rp','c_proy.viaticos_docente_rp',  'c_proy.total_presupuesto_rp',
            //         'es_coor.abrev as ap_coor','es_dec.abrev as ap_dec','es_consj.abrev as ap_cons'
            //         )
            //         ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
            //         ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
            //         ->join('periodo_academico as per_aca','proy_prel.id_periodo_academico','=','per_aca.id')
            //         ->join('semestre_asignatura as sem_asig','proy_prel.id_semestre_asignatura','=','sem_asig.id')
            //         ->join('docentes_practica as doce_prac','proy_prel.id','=','doce_prac.id')
            //         ->join('sedes_universidad as salida_rp','proy_prel.lugar_salida_rp','=','salida_rp.id')
            //         ->join('sedes_universidad as regreso_rp','proy_prel.lugar_salida_rp','=','regreso_rp.id')
            //         ->join('transporte_proyeccion as trans_proy','proy_prel.id','=','trans_proy.id')
            //         ->join('transporte_menor as trans_menor','proy_prel.id','=','trans_menor.id')
            //         ->join('materiales_herramientas_proyeccion as mate','proy_prel.id','=','mate.id')
            //         ->join('riesgos_amenazas_practica as riesgos','proy_prel.id','=','riesgos.id')
            //         ->leftjoin('tipo_transporte as tip_tra_rp1','trans_proy.id_tipo_transporte_rp_1','=','tip_tra_rp1.id')
            //         ->leftjoin('tipo_transporte as tip_tra_rp2','trans_proy.id_tipo_transporte_rp_2','=','tip_tra_rp2.id')
            //         ->leftjoin('tipo_transporte as tip_tra_rp3','trans_proy.id_tipo_transporte_rp_3','=','tip_tra_rp3.id')
            //         ->join('users as us','proy_prel.id_docente_responsable','=','us.id')
            //         ->join('costos_proyeccion as c_proy','proy_prel.id','=','c_proy.id')
            //         ->join('estado as es_coor','proy_prel.aprobacion_coordinador','=','es_coor.id')
            //         ->join('estado as es_dec','proy_prel.aprobacion_decano','=','es_dec.id')
            //         ->join('estado as es_consj','proy_prel.aprobacion_consejo_facultad','=','es_consj.id')
            //         ->where('proy_prel.id',$id_proye)->first();
            //         $proyeccion->push($proyecciones);

            $proyecciones=DB::table('proyeccion_preliminar as proy_prel')
            ->select('proy_prel.id', 'prog_aca.programa_academico', 'espa.espacio_academico',
                    'proy_prel.id_docente_responsable',
                     DB::raw('CONCAT_WS(" ", us.primer_nombre, us.segundo_nombre, us.primer_apellido, us.segundo_apellido) as full_name'),
                    'proy_prel.cantidad_grupos', 'proy_prel.grupo_1', 'proy_prel.grupo_2', 'proy_prel.grupo_3', 'proy_prel.grupo_4', 
                    'proy_prel.num_estudiantes_aprox','doce_prac.total_personal_apoyo',
                    'doce_prac.id_tipo_personal_apoyo_1', 'doce_prac.num_doc_personal_apoyo_1','doce_prac.personal_apoyo_1',
                    'doce_prac.id_tipo_personal_apoyo_2','doce_prac.num_doc_personal_apoyo_2','doce_prac.personal_apoyo_2',
                    'proy_prel.practicas_integradas','prac_inte.cant_espa_aca',
                    'prac_inte.id_docen_espa_aca_1','prac_inte.id_espa_aca_1','prac_inte.id_docen_espa_aca_2','prac_inte.id_espa_aca_2',
                    'prac_inte.id_docen_espa_aca_3','prac_inte.id_espa_aca_3','prac_inte.id_docen_espa_aca_4','prac_inte.id_espa_aca_4',
                    'prac_inte.id_docen_espa_aca_5','prac_inte.id_espa_aca_5','prac_inte.id_docen_espa_aca_6','prac_inte.id_espa_aca_6',
                    'prac_inte.id_docen_espa_aca_7','prac_inte.id_espa_aca_7',
                    'proy_prel.observ_inactividad', 'proy_prel.observ_decano',
                    'salida_rp.id as sede_salida','regreso_rp.id as sede_regreso',
                    // 'salida_rp.sede as sede_salida','regreso_rp.sede as sede_regreso',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad','proy_prel.observ_inactividad',
                    'proy_prel.observ_inactividad'
                    )
                    ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
                    ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
                    ->join('periodo_academico as per_aca','proy_prel.id_periodo_academico','=','per_aca.id')
                    ->join('semestre_asignatura as sem_asig','proy_prel.id_semestre_asignatura','=','sem_asig.id')
                    ->join('docentes_practica as doce_prac','proy_prel.id','=','doce_prac.id')
                    ->join('practicas_integradas as prac_inte','proy_prel.id','=','prac_inte.id')
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
                    ->where('proy_prel.id',$id_proye)->first();
                    $proyeccion->push($proyecciones);
        }

        return $proyeccion;
    }

    public function headings():array
    {
        // return['ID PROYECCIÓN','PROGRAMA ACADÉMICO', 'CÓD. ESPACIO ACADÉMICO', 'ESPACIO ACADÉMICO', 'SEM. ACA','AÑO PER.','PER. ACA',
        //         'CÉDULA','DOCENTE RESPONSABLE','GRUPO 1','GRUPO 2','GRUPO 3','GRUPO 4', 'NÚMERO DE ESTUDIANTES','NÚMERO PERSONAS APOYO',
        //         'TOTAL DOCENTES APOYO',
        //         'PERSONAL APOYO 1','PERSONAL APOYO 2','PERSONAL APOYO 3','PERSONAL APOYO 4','PERSONAL APOYO 5',
        //         'PERSONAL APOYO 6','PERSONAL APOYO 7','PERSONAL APOYO 8','PERSONAL APOYO 9','PERSONAL APOYO 10',
        //         'DESTINO RUTA PRINCIPAL','CANT. URL RUTA PRINCIPAL','URL 1 RUTA PRINCIPAL','URL 2 RUTA PRINCIPAL',
        //         'URL 3 RUTA PRINCIPAL','URL 4 RUTA PRINCIPAL','URL 5 RUTA PRINCIPAL','URL 6 RUTA PRINCIPAL', 'DETALLE DEL RECORRIDO INTERNO',
        //         'SEDE SALIDA RP','SEDE REGRESO RP',
        //         'SALIDA (FECHA TENTATIVA) RP', 'REGRESO (FECHA TENTATIVA) RP', 'N. DÍAS RP',
        //         'CANT. VEHÍCULOS RP',
        //         'TIPO VEHÍCULO 1 RP', 'CAPAC. VEHÍCULO 1 RP', 'DET. VEHÍCULO 1 RP','DISP. PERMANENTE VEHÍCULO 1 RP',
        //         'TIPO VEHÍCULO 2 RP', 'CAPAC. VEHÍCULO 2 RP', 'DET. VEHÍCULO 2 RP','DISP. PERMANENTE VEHÍCULO 2 RP',
        //         'TIPO VEHÍCULO 3 RP', 'CAPAC. VEHÍCULO 3 RP', 'DET. VEHÍCULO 3 RP','DISP. PERMANENTE VEHÍCULO 3 RP',
        //         'VLR. ESTIMADO TRANSPORTE RP','CANT. TRANSPORTE MENOR RP',
        //         'TRANSPORTE MENOR 1 RP', 'VLR. TRANSPORTE MENOR 1 RP', 'TRANSPORTE MENOR 2 RP','VLR. TRANSPORTE MENOR 2 RP',
        //         'TRANSPORTE MENOR 3 RP', 'VLR. TRANSPORTE MENOR 3 RP', 'TRANSPORTE MENOR 4 RP','VLR. TRANSPORTE MENOR 4 RP',
        //         'MATERIALES RP','VLR. TOTAL MATERIALES RP','GUÍAS/BAQUIANOS RP','VLR. TOTAL GUÍAS/BAQUIANOS RP','BOLETAS/OTROS RP','VLR. TOTAL BOLETAS/OTROS RP',
        //         'ÁREAS ACUÁTICAS RP','ALTURAS RP','RIESGO BIOLÓGICO RP','ESPACIOS CONFINADOS RP',
        //         'V. ESTUDIANTES RP','V. DOCENTES RP','TOTAL PRESUPUESTO RP',
        //         'E. COORD', 'E. DECANO', 'E. CONSJ. F.'];

        return[
            'ID PROYECCIÓN',
            'PROGRAMA ACADÉMICO', 
            'ESPACIO ACADÉMICO',
            'NUM. IDENT. DOCENTE',
            'DOCENTE RESPONSABLE',
            'CANT. GRUPOS',
            'GRUPO 1',
            'GRUPO 2',
            'GRUPO 3',
            'GRUPO 4',
            'NÚMERO DE ESTUDIANTES',
            'CANT. PERSONAL APOYO',
            'ID TIPO PERSONAL APOYO 1',
            'NUM. IDENT. PERSONAL APOYO 1',
            'PERSONAL APOYO 1',
            'ID TIPO PERSONAL APOYO 2',
            'NUM. IDENT. PERSONAL APOYO 2',
            'PERSONAL APOYO 2',
            'PRÁCTICA INTEGRADA',
            'CANT. DOCENTES PARTICIPANTES',
            'NUM. IDENT. DOCENTE PARTICIPANTE 1',
            'ID ESP. ACAD. DOCENTE PARTICIPANTE 1',
            'NUM. IDENT. DOCENTE PARTICIPANTE 2',
            'ID ESP. ACAD. DOCENTE PARTICIPANTE 2',
            'NUM. IDENT. DOCENTE PARTICIPANTE 3',
            'ID ESP. ACAD. DOCENTE PARTICIPANTE 3',
            'NUM. IDENT. DOCENTE PARTICIPANTE 4',
            'ID ESP. ACAD. DOCENTE PARTICIPANTE 4',
            'NUM. IDENT. DOCENTE PARTICIPANTE 5',
            'ID ESP. ACAD. DOCENTE PARTICIPANTE 5',
            'NUM. IDENT. DOCENTE PARTICIPANTE 6',
            'ID ESP. ACAD. DOCENTE PARTICIPANTE 6',
            'NUM. IDENT. DOCENTE PARTICIPANTE 7',
            'ID ESP. ACAD. DOCENTE PARTICIPANTE 7',
            'TIPO RUTA',
            'DETALLE DEL RECORRIDO INTERNO',
            'ID SEDE SALIDA',
            'ID SEDE REGRESO',
            'SALIDA (FECHA CONFIRMADA)',
            'HORA SALIDA',
            'REGRESO (FECHA CONFIRMADA)',
            'HORA REGRESO',
            'DET. VEHÍCULO',
            'DISP. PERMANENTE VEHÍCULO',
            'CANT. TRANSPORTE MENOR',
            'TRANSPORTE MENOR 1',
            'VLR. TRANSPORTE MENOR 1',
            'TRANSPORTE MENOR 2',
            'VLR. TRANSPORTE MENOR 2',
            'TRANSPORTE MENOR 3',
            'VLR. TRANSPORTE MENOR 3',
            'TRANSPORTE MENOR 4',
            'VLR. TRANSPORTE MENOR 4',
            'MATERIALES',
            'VLR. TOTAL MATERIALES',
            'GUÍAS/BAQUIANOS',
            'VLR. TOTAL GUÍAS/BAQUIANOS',
            'BOLETAS/OTROS',
            'VLR. TOTAL BOLETAS/OTROS',
            'ÁREAS ACUÁTICAS',
            'ALTURAS',
            'RIESGO BIOLÓGICO',
            'ESPACIOS CONFINADOS',
            'CRONOGRAMA RECORRIDO',
            'OBS. PRÁCTICA',
            'JUST. PRÁCTICA',
            'OBJ. GRAL. PRÁCTICA',
            'MET. TRABAJO - EVAL. PRÁCTICA',
            'VAC. FIEBRE AMARILLA',
            'VAC. TÉTANOS',
            'CERTIFICADO ADICIONAL 1',
            'DET. CERT. ADICIONAL 1',
            'CERTIFICADO ADICIONAL 2',
            'DET. CERT. ADICIONAL 2',
            'CERTIFICADO ADICIONAL 3',
            'DET. CERT. ADICIONAL 3',
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:BX1';
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
        $titleSheet = "PLAN DE PRACTICAS CONTROL DEFIN";
        return $titleSheet;
    }
}