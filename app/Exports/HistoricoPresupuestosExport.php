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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Carbon\Carbon;
use DB;

class HistoricoPresupuestosExport  implements  FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;

    protected $fecha_inicial;
    protected $fecha_final;

    public function __construct($fecha_inicial, $fecha_final)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
    }

    public function collection()
    {
        $datos = collect();
        $fecha_inicial = Carbon::parse($this->fecha_inicial)->format('Y-m-d');
        $fecha_final = Carbon::parse($this->fecha_final)->format('Y-m-d');

        $solicitudes = DB::table('solicitud_practica as s')
                            ->select(
                                'pa.programa_academico',
                                'det.id as id_detalle_presupuesto',
                                's.id as id_sol',
                                's.num_cdp',
                                'u.id as id_user',
                                DB::raw("CONCAT(u.primer_nombre, ' ', u.primer_apellido) AS nombre_docente"),                                
                                'hpres.presupuesto_inicial_historico',
                                'det.presupuesto_practica',
                                'ppa.presupuesto_actual'
                            )
                            ->join('programacion_practica as p', 'p.id', '=', 's.id_programacion_practica')
                            ->leftJoin('detalle_presupuesto_programa_academico as det', 'det.id_solicitud', '=', 's.id')
                            ->leftJoin('presupuesto_programa_academico as ppa', 'ppa.id', '=', 'det.id_presupuesto_programa')
                            ->leftJoin('historico_presupuesto_programa_academico as hpres', 'hpres.id', '=', 'det.id_presupuesto_programa_historico')
                            ->leftJoin('users as u', 'u.id', '=', 'p.id_docente_responsable')
                            ->leftJoin('programa_academico as pa', 'pa.id', '=', 'p.id_programa_academico')
                            ->where('s.aprobacion_coordinador', 7)
                            ->whereBetween('s.fecha_salida', [$fecha_inicial, $fecha_final])
                            ->orderBy('pa.programa_academico','ASC')
                            ->orderBy('det.id','ASC')
                            ->get();
        foreach($solicitudes as $solicitud){
            $datos->push($solicitud);
        }
        return $datos;
    }

    public function headings():array
    {
        return [
            'PROGRAMA ACADEMICO',
            'ID DETALLE PRESUPUESTO',
            'ID SOLICITUD',
            'NUM CDP',
            'CÉDULA DOCENTE',
            'NOMBRE DOCENTE',
            'PRESUPUESTO INICIAL HISTORICO',
            'PRESUPUESTO PRACTICA',
            'PRESUPUESTO RESTANTE PROYECTO',
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
		    $cellRange = 'A1:I1';
		    $sheet = $event->sheet->getDelegate();
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                foreach (range('A', 'M') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(false);
                    $event->sheet->getColumnDimension($column)->setWidth(15);
                }
                $event->sheet->getRowDimension('1')->setRowHeight(30);
                $event->sheet->getColumnDimension('A')->setWidth(35);
                $event->sheet->getColumnDimension('B')->setWidth(20);
                $event->sheet->getColumnDimension('B')->setWidth(20);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(20);
		        $event->sheet->getColumnDimension('E')->setWidth(20);
                $event->sheet->getColumnDimension('F')->setWidth(20);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(20);
                $event->sheet->getColumnDimension('I')->setWidth(25);

                foreach (range('G', 'I') as $col) {
                $sheet->getStyle($col . '2:' . $col . $sheet->getHighestRow())
                    ->getNumberFormat()
                    ->setFormatCode('"$"#,##0');
                }

                $sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => 'solid',
                        'color' => ['rgb' => 'D9D9D9']
                    ],
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => 'center',
                        'horizontal' => 'center',
                    ],
                ]);
            },            
            BeforeWriting::class=>function(BeforeWriting $event){
                $event->writer->setActiveSheetIndex(0);
            }
        ];
    }

    public function title(): string
    {
        $titleSheet = "Historico Presupuestos";
        return $titleSheet;
    }
}
