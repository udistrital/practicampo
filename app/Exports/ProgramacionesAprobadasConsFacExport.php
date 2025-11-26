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

class ProgramacionesAprobadasConsFacExport implements ShouldAutoSize, WithTitle, FromArray, WithStyles, WithColumnWidths
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
            ["","REPORTE PROGRAMACIONES APROBADAS POR CONSEJO DE FACULTAD"],
            [""],
            ["",
                "PROGRAMA ACADÉMICO",
                "ESPACIO ACADÉMICO",
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
                "OBSERVACIONES"
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
                'pa.programa_academico',
                'ea.espacio_academico',
                'p.det_recorrido_interno_rp',
                DB::raw("CONCAT(p.anio_periodo, '-', p.id_periodo_academico) as periodo_academico"),
                'p.duracion_num_dias_rp',
                DB::raw("COALESCE(p.num_estudiantes_aprox, 0) AS numero_estudiantes"),
                DB::raw("COALESCE(dp.num_docentes_apoyo, 0) + COALESCE(pi.cant_espa_aca, 0) + 1 AS numero_docentes"),
                'cp.viaticos_docente_rp',
                'cp.viaticos_estudiantes_rp',
                'cp.vlr_guias_baquianos_rp',
                'cp.vlr_otros_boletas_rp',                
            )
            ->leftJoin('docentes_practica as dp', 'dp.id', '=', 'p.id')
            ->join('practicas_integradas as pi', 'pi.id', '=', 'p.id')
            ->join('users as u', 'u.id', '=', 'p.id_docente_responsable')
            ->join('programa_academico as pa', 'pa.id', '=', 'p.id_programa_academico')
            ->join('espacio_academico as ea', 'ea.id', '=', 'p.id_espacio_academico')
            ->join('costos_programacion as cp', 'cp.id', '=', 'p.id')
            ->where('p.aprobacion_decano', '=', 7)
            ->where('p.aprobacion_consejo_facultad', '=', 3)
            ->where('p.id_programa_academico', '=', $usuario->id_programa_academico_coord)
            ->where('p.anio_periodo', $anio)
            ->where('p.id_periodo_academico', $periodo)
            ->orderBy('pa.programa_academico','ASC')
            ->get();

        foreach ($programaciones as $p) {
            $datos[] = [
                "",
                $p->programa_academico,
                $p->espacio_academico,
                $p->det_recorrido_interno_rp,
                $p->periodo_academico,
                $p->duracion_num_dias_rp,
                $p->numero_estudiantes,
                $p->numero_docentes,
                $p->viaticos_docente_rp,
                $p->viaticos_estudiantes_rp,
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

        $sheet->mergeCells('B2:N2');
        $columnas = range('B', 'N');
        foreach ($columnas as $col) {
            $sheet->mergeCells("{$col}4:{$col}5");
        }

        $sheet->getStyle("A1:O{$lastRow}")->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'FFFFFF']
            ],
        ]);        

        $celdas = [
            'B2',
            'B4','C4','D4','E4','F4','G4','H4','I4','J4','K4','L4','M4','N4'
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

        $sheet->getStyle('B1:N5')->applyFromArray([
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        
        $sheet->getStyle('B2')->applyFromArray([
            'font' => [
                'size' => 16,
            ]
        ]);
        
        $sheet->getStyle("B4:N{$lastRow}")->applyFromArray([
            'font' => [
                'size' => 14,
            ]
        ]);

        $sheet->getStyle("A1:O{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE
                ]
            ]
        ]);

        $ranges = [
            'B2:N2',
            "B4:N{$lastRow}"
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

        $sheet->getStyle('I:M')->applyFromArray([
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
            'B' => 45.52,
            'C' => 45.52,
            'D' => 55.60,
            'E' => 15,
            'F' => 15,
            'G' => 30,
            'H' => 30,
            'I' => 25,
            'J' => 25,
            'K' => 30,
            'L' => 30,
            'M' => 19,
            'N' => 19,
        ];
    }
}
