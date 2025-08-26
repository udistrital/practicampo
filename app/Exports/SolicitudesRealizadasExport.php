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

class SolicitudesRealizadasExport  implements  FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
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

        $solicitudes=DB::table('proyeccion_preliminar as p_prel')
        ->select('s.id',
                 DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'),
                 'p_aca.programa_academico','e_aca.espacio_academico',                 
		 'p_prel.destino_rp','s.fecha_salida as fecha_salida_aprox_rp','s.fecha_regreso as fecha_regreso_aprox_rp',
		 DB::raw('CASE WHEN s.tipo_ruta = 1 THEN cp.viaticos_docente_rp ELSE cp.viaticos_docente_ra END AS viaticos_docente'),
                DB::raw('CASE WHEN s.tipo_ruta = 1 THEN cp.viaticos_estudiantes_rp ELSE cp.viaticos_estudiantes_ra END AS viaticos_estudiantes'),
                DB::raw('CASE WHEN s.tipo_ruta = 1 THEN cp.vlr_otros_boletas_rp ELSE cp.vlr_otros_boletas_ra END AS valor_otros_boletas'),
                DB::raw('CASE WHEN s.tipo_ruta = 1 THEN cp.vlr_guias_baquianos_rp ELSE cp.vlr_guias_baquianos_ra END AS valor_guias_baquianos'),
                DB::raw('CASE WHEN s.tipo_ruta = 1 THEN cp.costo_total_transporte_menor_rp ELSE cp.costo_total_transporte_menor_ra END AS transporte_menor'),
		 'ep.estado')
        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
        ->join('users','p_prel.id_docente_responsable','=','users.id')
	->join('solicitud_practica as s','p_prel.id','=','s.id_proyeccion_preliminar')
        ->join('costos_proyeccion as cp','p_prel.id','=','cp.id')
	->join('estado_practica as ep', 'ep.id', '=', 's.estado_practica')
        ->where('s.aprobacion_decano', '=', 7)
        ->where('s.id_estado_solicitud_practica', '=', 3)
        ->whereBetween('s.fecha_salida', [$fecha_inicial, $fecha_final])
        ->get();
        foreach($solicitudes as $solicitud){
            $datos->push($solicitud);
        }
        return $datos;
    }

    public function headings():array
    {
        return [
            'ID', 
            'Docente',
            'Programa Académico', 
            'Espacio Académico',            
            'Destino', 
            'Fecha Salida', 
	    'Fecha Regreso',
	   'Viaticos Docente',
            'Viaticos Estudiantes',
            'Valor Otros Boletas',
            'Valor Guias Baquianos',
            'Valor Transporte Menor',
            'Estado Solicitud'            
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
		    $cellRange = 'A1:M1';
		    $sheet = $event->sheet->getDelegate();
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('74BB96');
                foreach (range('A', 'M') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(false);
                    $event->sheet->getColumnDimension($column)->setWidth(15);
                }
                $event->sheet->getColumnDimension('B')->setWidth(30);
                $event->sheet->getColumnDimension('C')->setWidth(40);
                $event->sheet->getColumnDimension('D')->setWidth(30);
		$event->sheet->getColumnDimension('E')->setWidth(40);

		foreach (range('H', 'L') as $col) {
                $sheet->getStyle($col . '2:' . $col . $sheet->getHighestRow())
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                }
                foreach (range('H', 'L') as $col) {
                $sheet->getStyle($col . '2:' . $col . $sheet->getHighestRow())
                    ->getNumberFormat()
                    ->setFormatCode('"$"#,##0');
                }
            },            
            BeforeWriting::class=>function(BeforeWriting $event){
                $event->writer->setActiveSheetIndex(0);
            }
        ];
    }

    public function title(): string
    {
        $titleSheet = "Solicitudes Realizadas/No Realizadas";
        return $titleSheet;
    }
}
