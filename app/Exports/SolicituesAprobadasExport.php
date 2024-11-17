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

use Carbon\Carbon;
use DB;

class SolicituesAprobadasExport implements  FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
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
                's.id',
                DB::raw("CONCAT(u.primer_nombre, ' ', u.primer_apellido) as Nombre_Docente"),
                'u.celular',
                'pa.programa_academico',
                'ea.espacio_academico',
                DB::raw("CASE WHEN s.tipo_ruta = 1 THEN p.det_recorrido_interno_rp ELSE p.det_recorrido_interno_ra END AS ruta"),
                DB::raw("CASE WHEN s.tipo_ruta = 1 THEN (SELECT sede FROM sedes_universidad WHERE id = p.lugar_salida_rp) ELSE (SELECT sede FROM sedes_universidad WHERE id = p.lugar_salida_ra) END AS lugar_salida"),
                DB::raw("CASE WHEN s.tipo_ruta = 1 THEN (SELECT sede FROM sedes_universidad WHERE id = p.lugar_regreso_rp) ELSE (SELECT sede FROM sedes_universidad WHERE id = p.lugar_regreso_ra) END AS lugar_regreso"),
                's.fecha_salida',
                's.hora_salida',
                's.fecha_regreso',
                's.hora_regreso',
                's.duracion_num_dias',
                DB::raw("COALESCE(s.num_estudiantes, 0) + COALESCE(dp.num_docentes_apoyo, 0) + COALESCE(pi.cant_espa_aca, 0) + 1 AS numero_pasajeros")
            )
            ->join('proyeccion_preliminar as p', 'p.id', '=', 's.id_proyeccion_preliminar')
            ->leftJoin('docentes_practica as dp', 'dp.id', '=', 'p.id')
            ->join('practicas_integradas as pi', 'pi.id', '=', 'p.id')
            ->join('users as u', 'u.id', '=', 's.id_docente_creador')
            ->join('programa_academico as pa', 'pa.id', '=', 'p.id_programa_academico')
            ->join('espacio_academico as ea', 'ea.id', '=', 'p.id_espacio_academico')
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
            'ID Solicitud',
            'Nombre Docente',
            'Celular',
            'Programa Académico',
            'Espacio Académico',
            'Ruta',
            'Sede de Salida',
            'Sede de Regreso',
            'Fecha de Salida',
            'Hora de Salida',
            'Fecha de Regreso',
            'Hora de Regreso',
            'Duración (Días)',
            'Número de Pasajeros'
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:N1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('74BB96');
                foreach (range('A', 'N') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(false);
                    $event->sheet->getColumnDimension($column)->setWidth(15);
                }
                $event->sheet->getColumnDimension('B')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(25);
                $event->sheet->getColumnDimension('E')->setWidth(25);
                $event->sheet->getColumnDimension('F')->setWidth(25);
            },            
            BeforeWriting::class=>function(BeforeWriting $event){
                $event->writer->setActiveSheetIndex(0);
            }
        ];
    }

    public function title(): string
    {
        $titleSheet = "Solicitudes Aprobadas";
        return $titleSheet;
    }
}
