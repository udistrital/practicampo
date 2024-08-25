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

class ProyeccionesContingenciaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
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
            
            $proyecciones=DB::table('proyeccion_preliminar as proy_prel')
            ->select('proy_prel.id', 'prog_aca.programa_academico', 'espa.codigo_espacio_academico','espa.espacio_academico', 'sem_asig.semestre_asignatura', 
                    'proy_prel.anio_periodo','per_aca.periodo_academico','proy_prel.id_docente_responsable',
                    DB::raw('CONCAT_WS(" ", us.primer_nombre, us.segundo_nombre, us.primer_apellido, us.segundo_apellido) as full_name'),
                    'proy_prel.grupo_1', 'proy_prel.grupo_2', 'proy_prel.grupo_3', 'proy_prel.grupo_4', 
                    'proy_prel.num_estudiantes_aprox','doce_prac.num_docentes_apoyo','doce_prac.total_docentes_apoyo','doce_prac.docente_apoyo_1','doce_prac.docente_apoyo_2','doce_prac.docente_apoyo_3',
                    'doce_prac.docente_apoyo_4','doce_prac.docente_apoyo_5','doce_prac.docente_apoyo_6','doce_prac.docente_apoyo_7','doce_prac.docente_apoyo_8',
                    'doce_prac.docente_apoyo_9','doce_prac.docente_apoyo_10',
                    'proy_prel.destino_ra', 'proy_prel.cantidad_url_ra','proy_prel.ruta_alterna', 'proy_prel.ruta_alterna_2', 'proy_prel.ruta_alterna_3', 
                    'proy_prel.ruta_alterna_4', 'proy_prel.ruta_alterna_5', 'proy_prel.ruta_alterna_6',
                    'proy_prel.det_recorrido_interno_ra', 'salida_ra.sede as sede_salida','regreso_ra.sede as sede_regreso',
                    'proy_prel.fecha_salida_aprox_ra','proy_prel.fecha_regreso_aprox_ra','proy_prel.duracion_num_dias_ra', 
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
                    'es_coor.abrev as ap_coor','es_dec.abrev as ap_dec','es_consj.abrev as ap_cons'
                    )
                    ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
                    ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
                    ->join('periodo_academico as per_aca','proy_prel.id_periodo_academico','=','per_aca.id')
                    ->join('semestre_asignatura as sem_asig','proy_prel.id_semestre_asignatura','=','sem_asig.id')
                    ->join('docentes_practica as doce_prac','proy_prel.id','=','doce_prac.id')
                    ->join('sedes_universidad as salida_ra','proy_prel.lugar_salida_rp','=','salida_ra.id')
                    ->join('sedes_universidad as regreso_ra','proy_prel.lugar_salida_rp','=','regreso_ra.id')
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
                    ->where('proy_prel.id',$id_proye)->first();
                    $proyeccion->push($proyecciones);
        }

        return $proyeccion;
    }

    public function headings():array
    {
        return['ID PROYECCIÓN','PROGRAMA ACADÉMICO', 'CÓD. ESPACIO ACADÉMICO', 'ESPACIO ACADÉMICO', 'SEM. ACA','AÑO PER.','PER. ACA',
                'CÉDULA','DOCENTE RESPONSABLE','GRUPO 1','GRUPO 2','GRUPO 3','GRUPO 4', 'NÚMERO DE ESTUDIANTES','NÚMERO PERSONAS APOYO',
                'TOTAL DOCENTES APOYO',
                'PERSONAL APOYO 1','PERSONAL APOYO 2','PERSONAL APOYO 3','PERSONAL APOYO 4','PERSONAL APOYO 5',
                'PERSONAL APOYO 6','PERSONAL APOYO 7','PERSONAL APOYO 8','PERSONAL APOYO 9','PERSONAL APOYO 10',
                'DESTINO RUTA CONTINGENCIA','CANT. URL RUTA CONTINGENCIA', 'URL 1 RUTA CONTINGENCIA','URL 2 RUTA CONTINGENCIA',
                'URL 3 RUTA CONTINGENCIA','URL 4 RUTA CONTINGENCIA','URL 5 RUTA CONTINGENCIA','URL 6 RUTA CONTINGENCIA', 'DETALLE DEL RECORRIDO INTERNO',
                'SEDE SALIDA RC','SEDE REGRESO RC',
                'SALIDA (FECHA TENTATIVA)', 'LLEGADA (FECHA TENTATIVA)', 'N. DÍAS RC',
                'CANT. VEHÍCULOS RC',
                'TIPO VEHÍCULO 1 RC', 'CAPAC. VEHÍCULO 1 RC', 'DET. VEHÍCULO 1 RC','DISP. PERMANENTE VEHÍCULO 1 RC',
                'TIPO VEHÍCULO 2 RC', 'CAPAC. VEHÍCULO 2 RC', 'DET. VEHÍCULO 2 RC','DISP. PERMANENTE VEHÍCULO 2 RC',
                'TIPO VEHÍCULO 3 RC', 'CAPAC. VEHÍCULO 3 RC', 'DET. VEHÍCULO 3 RC','DISP. PERMANENTE VEHÍCULO 3 RC',
                'VLR. ESTIMADO TRANSPORTE RC','CANT. TRANSPORTE MENOR RC',
                'TRANSPORTE MENOR 1 RC', 'VLR. TRANSPORTE MENOR 1 RC', 'TRANSPORTE MENOR 2 RC','VLR. TRANSPORTE MENOR 2 RC',
                'TRANSPORTE MENOR 3 RC', 'VLR. TRANSPORTE MENOR 3 RC', 'TRANSPORTE MENOR 4 RC','VLR. TRANSPORTE MENOR 4 RC',
                'MATERIALES RC','VLR. TOTAL MATERIALES RC','GUÍAS/BAQUIANOS RC','VLR. TOTAL GUÍAS/BAQUIANOS RC','BOLETAS/OTROS RC','VLR. TOTAL BOLETAS/OTROS RC',
                'ÁREAS ACUÁTICAS RC','ALTURAS RC','RIESGO BIOLÓGICO RC','ESPACIOS CONFINADOS RC',
                'V. ESTUDIANTES RC','V. DOCENTES RC','TOTAL PRESUPUESTO RC',
                'E. COORD', 'E. DECANO', 'E. CONSJ. F.'];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:CA1';
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
        $titleSheet = "PLAN DE PRACTICAS - CONTINGENCIA";
        return $titleSheet;
    }
}