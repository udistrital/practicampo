<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgramacionesAprobadasCoordExport implements ShouldAutoSize, WithTitle, FromArray, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $anio;
    protected $periodo;

    public function __construct($anio, $periodo)
    {
        $this->anio = $anio;
        $this->periodo = $periodo;
    }

    public function title(): string
    {
        $titleSheet = "Programaciones Aprob.";
        return $titleSheet;
    }

    public function array(): array
    {
        $datos = [
            [""],
            ["","REPORTE PROGRAMACIONES APROBADAS POR COORDINACIÓN"],
            [""],
            ["",
                "ID Prog.",
                "PROGRAMA ACADÉMICO",
                "ESPACIO ACADÉMICO",
                "CÉDULA DOCENTE",
                "NOMBRE DOCENTE",
                "RUTA DESARROLLO SALIDA DE CAMPO",
                "PERIODO ACADÉMICO",
                "NÚMERO DE DÍAS",
                "NÚMERO ESTUDIANTES",
                "NÚMERO DOCENTES",
                "VIÁTICOS DOCENTES",
                "VIÁTICOS ESTUDIANTES",
                "VALOR TRANSPORTE MENOR",
                "VALOR GUIAS/BAQUIANOS",
                "VALOR OTROS/BOLETAS",
                "OBSERVACIONES",
            ],
            [""],
        ];

        $anio = $this->anio;
        $periodo = $this->periodo;

        $usuario = DB::table('users as u')
            ->select('id_programa_academico_coord')
            ->where('id',Auth::user()->id)->first();

        $programaciones = DB::table('programacion_practica as p')
            ->select(
                'p.id',
                'pa.programa_academico',
                'ea.espacio_academico',
                'u.id as id_user',
                DB::raw('CONCAT_WS(" ",u.primer_nombre, u.segundo_nombre, u.primer_apellido, u.segundo_apellido) as full_name'),
                'p.det_recorrido_interno_rp',
                DB::raw("CONCAT(p.anio_periodo, '-', p.id_periodo_academico) as periodo_academico"),
                'p.duracion_num_dias_rp',
                DB::raw("COALESCE(p.num_estudiantes_aprox, 0) AS numero_estudiantes"),
                DB::raw("COALESCE(dp.num_docentes_apoyo, 0) + COALESCE(pi.cant_espa_aca, 0) + 1 AS numero_docentes"),
                'cp.viaticos_docente_rp',
                'cp.viaticos_estudiantes_rp',
                'cp.costo_total_transporte_menor_rp',
                'cp.vlr_guias_baquianos_rp',
                'cp.vlr_otros_boletas_rp',                
            )
            ->leftJoin('docentes_practica as dp', 'dp.id', '=', 'p.id')
            ->join('practicas_integradas as pi', 'pi.id', '=', 'p.id')
            ->join('users as u', 'u.id', '=', 'p.id_docente_responsable')
            ->join('programa_academico as pa', 'pa.id', '=', 'p.id_programa_academico')
            ->join('espacio_academico as ea', 'ea.id', '=', 'p.id_espacio_academico')
            ->join('costos_programacion as cp', 'cp.id', '=', 'p.id')
            ->where('p.aprobacion_coordinador', '=', 7)
            ->where('p.confirm_coord', '=', 1)
            ->where('p.id_programa_academico', '=', $usuario->id_programa_academico_coord)
            ->where('p.anio_periodo', $anio)
            ->where('p.id_periodo_academico', $periodo)
            ->orderBy('p.id','ASC')
            ->get();

        foreach ($programaciones as $p) {
            $datos[] = [
                "",
                $p->id,
                $p->programa_academico,
                $p->espacio_academico,
                $p->id_user,
                $p->full_name,
                $p->det_recorrido_interno_rp,
                $p->periodo_academico,
                $p->duracion_num_dias_rp,
                $p->numero_estudiantes,
                $p->numero_docentes,
                $p->viaticos_docente_rp,
                $p->viaticos_estudiantes_rp,
                $p->costo_total_transporte_menor_rp,
                $p->vlr_guias_baquianos_rp,
                $p->vlr_otros_boletas_rp,
                ""
            ];
        }
        return $datos;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        $sheet->mergeCells('B2:Q2');
        $columnas = range('B', 'Q');
        foreach ($columnas as $col) {
            $sheet->mergeCells("{$col}4:{$col}5");
        }

        $sheet->getStyle("A1:R{$lastRow}")->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'FFFFFF']
            ],
        ]);        

        $celdas = [
            'B2',
            'B4','C4','D4','E4','F4','G4','H4','I4','J4','K4','L4','M4','N4','O4','P4','Q4'
        ];
        foreach ($celdas as $celda){
            $sheet->getStyle($celda)->applyFromArray([
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
        
        }

        $sheet->getStyle('B1:Q5')->applyFromArray([
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        
        $sheet->getStyle('B2')->applyFromArray([
            'font' => [
                'size' => 16,
            ]
        ]);
        
        $sheet->getStyle("B4:Q{$lastRow}")->applyFromArray([
            'font' => [
                'size' => 14,
            ]
        ]);

        $sheet->getStyle("A1:R{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE
                ]
            ]
        ]);

        $ranges = [
            'B2:Q2',
            "B4:Q{$lastRow}"
        ];
        foreach ($ranges as $range) {
            $sheet->getStyle($range)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);
        }

        $sheet->getStyle('L:P')->applyFromArray([
            'numberFormat' => [
                'formatCode' => '$ #,##0',
            ],
        ]);

        $filas = [2];
        foreach ($filas as $fila) {
            $sheet->getRowDimension($fila)->setRowHeight(40);
        }

        for ($i = 4; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(40);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setBottom(0.5);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 2.41,
            'B' => 10,
            'C' => 30,
            'D' => 30,
            'E' => 20,
            'F' => 45.52,
            'G' => 55.6015,
            'H' => 30,
            'I' => 30,
            'J' => 25,
            'K' => 25,
            'L' => 30,
            'M' => 30,
            'N' => 19,
            'O' => 19,
            'P' => 19,
            'Q' => 19,
        ];
    }
}
