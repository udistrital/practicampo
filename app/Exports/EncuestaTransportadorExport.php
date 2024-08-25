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

use DB;

class EncuestaTransportadorExport implements  FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;

    public function __construct($id)
    {
        $this->id_solicitud = $id;
    }

    public function collection()
    {

        $lista_solicitudes = $this->id_solicitud;
        $solicitud = collect();

        foreach($lista_solicitudes[0]  as $id_solic)
        {
            $tipo_ruta=DB::table('solicitud_practica as solic_prac')
            ->select('tipo_ruta')
            ->where('solic_prac.id_proyeccion_preliminar',$id_solic)->first();

            if($tipo_ruta->tipo_ruta == 1)
            {
                $solicitudes=DB::table('solicitud_practica as solic_prac')
                ->select('solic_prac.id', 'prog_aca.programa_academico', 'espa.codigo_espacio_academico','espa.espacio_academico', 'sem_asig.semestre_asignatura',
                        'per_aca.periodo_academico','proy_prel.id_docente_responsable',
                        DB::raw('CONCAT_WS(" ", us.primer_nombre, us.segundo_nombre, us.primer_apellido, us.segundo_apellido)'),
                        'proy_prel.destino_rp', 'proy_prel.det_recorrido_interno_rp',
                        'solic_prac.fecha_salida','solic_prac.hora_salida','solic_prac.fecha_regreso','solic_prac.hora_regreso','solic_prac.duracion_num_dias',
                        'trans_proy.cant_transporte_rp',
                        'tip_tra_rp1.tipo_transporte as tip_t_rp_1','trans_proy.capac_transporte_rp_1','trans_proy.det_tipo_transporte_rp_1',
                        'tip_tra_rp2.tipo_transporte as tip_t_rp_2','trans_proy.capac_transporte_rp_2','trans_proy.det_tipo_transporte_rp_2',
                        'tip_tra_rp3.tipo_transporte as tip_t_rp_3','trans_proy.capac_transporte_rp_3','trans_proy.det_tipo_transporte_rp_3',
                        'enc_trans.cumplio_expect','enc_trans.no_cumplio_expect','enc_trans.ruta_prevista','enc_trans.no_ruta_prevista','enc_trans.carac_solicitadas',
                        'enc_trans.no_carac_solicitadas','enc_trans.comport_adecuado','enc_trans.no_comport_adecuado','enc_trans.horar_estab',
                        'enc_trans.no_horar_estab','enc_trans.nov_cron_ruta','enc_trans.con_nov_cron_ruta','enc_trans.adecuado_traslado','enc_trans.no_adecuado_traslado'
                        )
                        ->join('proyeccion_preliminar as proy_prel','proy_prel.id','=','solic_prac.id_proyeccion_preliminar')
                        ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
                        ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
                        ->join('periodo_academico as per_aca','proy_prel.id_periodo_academico','=','per_aca.id')
                        ->join('semestre_asignatura as sem_asig','proy_prel.id_semestre_asignatura','=','sem_asig.id')
                        ->join('sedes_universidad as salida_rp','proy_prel.lugar_salida_rp','=','salida_rp.id')
                        ->join('sedes_universidad as regreso_rp','proy_prel.lugar_salida_rp','=','regreso_rp.id')
                        ->join('transporte_proyeccion as trans_proy','proy_prel.id','=','trans_proy.id')
                        ->leftjoin('tipo_transporte as tip_tra_rp1','trans_proy.id_tipo_transporte_rp_1','=','tip_tra_rp1.id')
                        ->leftjoin('tipo_transporte as tip_tra_rp2','trans_proy.id_tipo_transporte_rp_2','=','tip_tra_rp2.id')
                        ->leftjoin('tipo_transporte as tip_tra_rp3','trans_proy.id_tipo_transporte_rp_3','=','tip_tra_rp3.id')
                        ->join('users as us','proy_prel.id_docente_responsable','=','us.id')
                        ->join('encuesta_transporte as enc_trans','solic_prac.id','=','enc_trans.id')
                        ->where('solic_prac.id_proyeccion_preliminar',$id_solic)->first();

                $solicitudes->det_tipo_transporte_rp_1 = $solicitudes->det_tipo_transporte_rp_1 ==null?"N/A":$solicitudes->det_tipo_transporte_rp_1;
                
                $solicitudes->tip_t_rp_2 = $solicitudes->tip_t_rp_2 ==null?"N/A":$solicitudes->tip_t_rp_2;
                $solicitudes->capac_transporte_rp_2 = $solicitudes->capac_transporte_rp_2 ==null?"N/A":$solicitudes->capac_transporte_rp_2;
                $solicitudes->det_tipo_transporte_rp_2 = $solicitudes->det_tipo_transporte_rp_2 ==null?"N/A":$solicitudes->det_tipo_transporte_rp_2;

                $solicitudes->tip_t_rp_3 = $solicitudes->tip_t_rp_3 ==null?"N/A":$solicitudes->tip_t_rp_3;
                $solicitudes->capac_transporte_rp_3 = $solicitudes->capac_transporte_rp_3 ==null?"N/A":$solicitudes->capac_transporte_rp_3;
                $solicitudes->det_tipo_transporte_rp_3 = $solicitudes->det_tipo_transporte_rp_3 ==null?"N/A":$solicitudes->det_tipo_transporte_rp_3;
            }

            else if($tipo_ruta->tipo_ruta == 2)
            {
                $solicitudes=DB::table('solicitud_practica as solic_prac')
                ->select('solic_prac.id', 'prog_aca.programa_academico', 'espa.codigo_espacio_academico','espa.espacio_academico', 'sem_asig.semestre_asignatura',
                        'per_aca.periodo_academico','proy_prel.id_docente_responsable',
                         DB::raw('CONCAT_WS(" ", us.primer_nombre, us.segundo_nombre, us.primer_apellido, us.segundo_apellido)'),
                        'proy_prel.destino_ra', 'proy_prel.det_recorrido_interno_ra',
                        'solic_prac.fecha_salida','solic_prac.hora_salida','solic_prac.fecha_regreso','solic_prac.hora_regreso','solic_prac.duracion_num_dias',
                        'trans_proy.cant_transporte_ra',
                        'tip_tra_rp1.tipo_transporte as tip_t_ra_1','trans_proy.capac_transporte_ra_1','trans_proy.det_tipo_transporte_ra_1',
                        'tip_tra_rp2.tipo_transporte as tip_t_ra_2','trans_proy.capac_transporte_ra_2','trans_proy.det_tipo_transporte_ra_2',
                        'tip_tra_rp3.tipo_transporte as tip_t_ra_3','trans_proy.capac_transporte_ra_3','trans_proy.det_tipo_transporte_ra_3',
                        'enc_trans.cumplio_expect','enc_trans.no_cumplio_expect','enc_trans.ruta_prevista','enc_trans.no_ruta_prevista','enc_trans.carac_solicitadas',
                        'enc_trans.no_carac_solicitadas','enc_trans.comport_adecuado','enc_trans.no_comport_adecuado','enc_trans.horar_estab',
                        'enc_trans.no_horar_estab','enc_trans.nov_cron_ruta','enc_trans.con_nov_cron_ruta','enc_trans.adecuado_traslado','enc_trans.no_adecuado_traslado'
                        )
                        ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
                        ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
                        ->join('periodo_academico as per_aca','proy_prel.id_periodo_academico','=','per_aca.id')
                        ->join('semestre_asignatura as sem_asig','proy_prel.id_semestre_asignatura','=','sem_asig.id')
                        ->join('sedes_universidad as salida_ra','proy_prel.lugar_salida_ra','=','salida_ra.id')
                        ->join('sedes_universidad as regreso_ra','proy_prel.lugar_salida_ra','=','regreso_ra.id')
                        ->join('transporte_proyeccion as trans_proy','proy_prel.id','=','trans_proy.id')
                        ->leftjoin('tipo_transporte as tip_tra_ra1','trans_proy.id_tipo_transporte_ra_1','=','tip_tra_ra1.id')
                        ->leftjoin('tipo_transporte as tip_tra_ra2','trans_proy.id_tipo_transporte_ra_2','=','tip_tra_ra2.id')
                        ->leftjoin('tipo_transporte as tip_tra_ra3','trans_proy.id_tipo_transporte_ra_3','=','tip_tra_ra3.id')
                        ->join('users as us','proy_prel.id_docente_responsable','=','us.id')
                        ->join('encuesta_transporte as enc_trans','solic_prac.id','=','enc_trans.id')
                        ->where('solic_prac.id_proyeccion_preliminar',$id_solic)->first();
                
                        
                $solicitudes->det_tipo_transporte_ra_1 = $solicitudes->det_tipo_transporte_ra_1 ==null?"N/A":$solicitudes->det_tipo_transporte_ra_1;
                
                $solicitudes->tip_t_ra_1 = $solicitudes->tip_t_ra_2 ==null?"N/A":$solicitudes->tip_t_ra_3;
                $solicitudes->capac_transporte_ra_2 = $solicitudes->capac_transporte_ra_2 ==null?"N/A":$solicitudes->capac_transporte_ra_2;
                $solicitudes->det_tipo_transporte_ra_2 = $solicitudes->det_tipo_transporte_ra_2 ==null?"N/A":$solicitudes->det_tipo_transporte_ra_2;

                $solicitudes->tip_t_ra_3 = $solicitudes->tip_t_ra_3 ==null?"N/A":$solicitudes->tip_t_ra_3;
                $solicitudes->capac_transporte_ra_3 = $solicitudes->capac_transporte_ra_3 ==null?"N/A":$solicitudes->capac_transporte_ra_3;
                $solicitudes->det_tipo_transporte_ra_3 = $solicitudes->det_tipo_transporte_ra_3 ==null?"N/A":$solicitudes->det_tipo_transporte_ra_3;

            }

            $solicitudes->cumplio_expect = $solicitudes->cumplio_expect ==0?"No":"Si";
            $solicitudes->ruta_prevista = $solicitudes->ruta_prevista ==0?"No":"Si";
            $solicitudes->carac_solicitadas = $solicitudes->carac_solicitadas ==0?"No":"Si";
            $solicitudes->comport_adecuado = $solicitudes->comport_adecuado ==0?"No":"Si";
            $solicitudes->horar_estab = $solicitudes->horar_estab ==0?"No":"Si";
            $solicitudes->nov_cron_ruta = $solicitudes->nov_cron_ruta ==0?"No":"Si";
            $solicitudes->adecuado_traslado = $solicitudes->adecuado_traslado ==0?"No":"Si";

            $solicitud->push($solicitudes);
        }

        return $solicitud;
    }

    public function headings():array
    {
        return['ID TI','PROGRAMA ACADÉMICO',  
                'CÓD. ESPACIO ACADÉMICO','ESPACIO ACADÉMICO','SEM. ACA','PER. ACA',
                'CÉDULA','DOCENTE RESPONSABLE',
                'DESTINO RUTA', 'DETALLE DEL RECORRIDO INTERNO',
                'FECHA SALIDA', 'HORA SALIDA','FECHA REGRESO','HORA SALIDA', 'N. DÍAS',
                'CANT. VEHÍ.',
                'T. TRANSPORTE 1', 'CAPAC. TRANSPORTE 1', 'DET. TRANSPORTE 1',
                'T. TRANSPORTE 2', 'CAPAC. TRANSPORTE 1', 'DET. TRANSPORTE 1',
                'T. TRANSPORTE 3', 'CAPAC. TRANSPORTE 1', 'DET. TRANSPORTE 1',
                'CUMPLIÓ CON LAS EXPECTATIVAS?','PORQUÉ?',
                'REALIZÓ LA RUTA PREVISTA?','PORQUÉ?',
                'CONTÓ CON LAS CARACTERÍSTICAS SOLICITADAS?','PORQUÉ?',
                'CONTÓ CON UN COMPORTAMIENTO ADECUADO?','PORQUÉ?',
                'CUMPLIÓ CON LOS HORARIOS ESTABLECIDOS?','PORQUÉ?',
                'PRESENTÓ NOVEDADES CON EL CRONOGRAMA DE LA RUTA?','CUÁL(ES)?',
                'HABÍA BUENAS CONDICIONES PARA PASAJEROS?','PORQUÉ?',
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:AM1';
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
        $titleSheet = "Encuestas_solicitudes";
        return $titleSheet;
    }
}
