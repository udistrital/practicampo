<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use function PHPSTORM_META\map;

class PlanSalidasExport implements ShouldAutoSize, WithTitle, FromArray, WithStyles, WithDrawings, WithColumnWidths
{
    use Exportable;

    protected $fecha_inicial;
    protected $fecha_final;

    public function __construct($fecha_inicial, $fecha_final)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
    }

    public function title(): string
    {
        $titleSheet = "Plan salidas de campo";
        return $titleSheet;
    }

    public function array(): array
    {
        $datos = [
            [""],
            ["","", "FORMATO: PLAN DE SALIDAS DE CAMPO", "", "","","", "","","", "Código: GD-PR-010-FR-XXX", "", ""],
            ["","", "Macroproceso: Direccionamiento Estratégico", "", "","","", "","","", "Verisón: 001", "", ""],
            ["","", "Proceso: Currículo y Calidad", "", "","","", "","","", "Fecha de Aprobación:", "", ""],
            [""],
            ["","FACULTAD", "MEDIO AMBIENTE Y RECURSOS NATURALES"],
            ["","VIGENCIA", ""],
            [""],
            ["","APROBACIÓN CONSEJO DE FACULTAD", "NÚMERO DE ACTA:","","","","", "FECHA DE APROBACIÓN:","",""],
            [""],
            ["","PLAN DE SALIDAS DE CAMPO"],
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

        $fecha_inicial = Carbon::parse($this->fecha_inicial)->format('Y-m-d');
        $fecha_final = Carbon::parse($this->fecha_final)->format('Y-m-d');

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
            ->where('p.aprobacion_decano', '=', 7)
            ->where('p.aprobacion_consejo_facultad', '=', 3)
            ->whereBetween('p.fecha_salida_aprox_rp', [$fecha_inicial, $fecha_final])
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

        $sheet->mergeCells('B2:B4');
        $sheet->mergeCells('C2:J2');
        $sheet->mergeCells('C3:J3');
        $sheet->mergeCells('C4:J4');
        $sheet->mergeCells('K2:L2');
        $sheet->mergeCells('K3:L3');
        $sheet->mergeCells('K4:L4');
        $sheet->mergeCells('M2:N4');
        $sheet->mergeCells('C6:N6');
        $sheet->mergeCells('C7:N7');
        $sheet->mergeCells('D9:G9');
        $sheet->mergeCells('I9:N9');
        $sheet->mergeCells('B11:N11');
        $columnas = range('B', 'N');
        foreach ($columnas as $col) {
            $sheet->mergeCells("{$col}13:{$col}14");
        }

        $sheet->getStyle("A1:O{$lastRow}")->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'FFFFFF']
            ],
        ]);
        $celdas = [
            'K2','L2',
            'C3','D3','E3','F3','G3','H3','I3','J3','K3', 'L3',
            'C4','D4','E4','F4','G4','H4','I4','J4','K4', 'L4',
        ];

        foreach ($celdas as $celda) {
            $sheet->getStyle($celda)->applyFromArray([
                'fill' => [
                    'fillType' => 'solid',
                    'color' => ['rgb' => 'FFFF00']
                ],
            ]);
        }

        $celdas = [
            'C2','F2',
            'B11',
        ];
        foreach($celdas as $celda){
            $sheet->getStyle($celda)->applyFromArray([
                'font' => ['bold' => true]
            ]);
        }
        

        $celdas = [
            'B6',
            'B7',
            'C9','H9',
            'B11','C11','D11','E11','F11','G11','H11','I11', 'J11', 'K11', 'L11', 'M11', 'N11',
            'B13','C13','D13','E13','F13','G13','H13','I13', 'J13', 'K13', 'L13', 'M13', 'N13',
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

        $sheet->getStyle('B9')->applyFromArray([
                'fill' => [
                    'fillType' => 'solid',
                    'color' => ['rgb' => 'F2F2F2']
                ],
            ]);

        $sheet->getStyle('B1:N13')->applyFromArray([
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        
        $sheet->getStyle('B2:N4')->applyFromArray([
            'font' => [
                'size' => 16,
            ]
        ]);
        
        $sheet->getStyle("B6:N{$lastRow}")->applyFromArray([
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
            'B2:N4',
            'B6:N7',
            'B9:N9',
            'B11:N11',
            "B13:N{$lastRow}"
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

        $filas = [2, 3, 4, 6, 7, 9, 11];
        foreach ($filas as $fila) {
            $sheet->getRowDimension($fila)->setRowHeight(40);
        }

        for ($i = 13; $i <= $lastRow; $i++) {
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

    public function drawings()
    {
    // LOGO UD
        $logo1 = new Drawing();
        $logo1->setName('Logo UD');
        $logo1->setPath(public_path('img/logo_ud.png'));
        $logo1->setHeight(100);
        $logo1->setWidth(160);
        $logo1->setCoordinates('B2');
        $logo1->setOffsetX(85);
        $logo1->setOffsetY(0);

        $logo2 = new Drawing();
        $logo2->setName('Logo SIGUD');
        $logo2->setPath(public_path('img/sigud2.jpg'));
        $logo2->setHeight(150);
        $logo2->setWidth(240);
        $logo2->setCoordinates('M2');
        $logo2->setOffsetX(15);
        $logo2->setOffsetY(55);

        return [$logo1, $logo2];
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
