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

class SolicitudesAprobadasExport implements ShouldAutoSize, WithTitle, FromArray, WithStyles, WithDrawings, WithColumnWidths
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
            ["","", "FORMATO: PLAN DE SALIDAS DE CAMPO", "", "","","", "","","","","","","","","", "Código: GD-PR-010-FR-XXX", "", ""],
            ["","", "Macroproceso: Direccionamiento Estratégico", "", "","","", "","","","","","","","","", "Verisón: 001", "", ""],
            ["","", "Proceso: Currículo y Calidad", "", "","","", "","","","","","","","","", "Fecha de Aprobación:", "", ""],
            [""],
            ["","FACULTAD", "Medio Ambiente y Recursos Naturales"],
            ["","VIGENCIA", ""],
            [""],
            ["","SOLICITUD DE TRANSPORTE SALIDAS DE CAMPO"],
            [""],
            ["",
                "No",
                "CONSECUTIVO SOLICITUD DE FACULTAD",
                "FACULTAD",
                "FECHA DE SOLICITUD",
                "ITEM (EMPRESA DE TRANSPORTE)",
                "RECORRIDO INTERNO (EMPRESA DE TRANSPORTE)",
                "RUTA SALIDA DE CAMPO",
                "SEDE SALIDA",
                "SEDE REGRESO",
                "DIAS SERVICIO",
                "No PASAJEROS",
                "FECHA SALIDA",
                "HORA SALIDA",
                "FECHA REGRESO",
                "HORA REGRESO",
                "DOCENTE ENCARGADO",
                "CÉDULA",
                "CELULAR DE CONTACTO",
                "OBSERVACIÓN",
            ],
            [""],
        ];

        $fecha_inicial = Carbon::parse($this->fecha_inicial)->format('Y-m-d');
        $fecha_final = Carbon::parse($this->fecha_final)->format('Y-m-d');
        $mytime = Carbon::now('America/Bogota')->toDateString();
        $solicitudes = DB::table('solicitud_practica as s')
            ->select(
                's.id',                
                's.consec_dfamarena',
                DB::raw("CASE WHEN s.tipo_ruta = 1 THEN p.destino_rp ELSE p.destino_ra END AS destino"),
                DB::raw("CASE WHEN s.tipo_ruta = 1 THEN p.det_recorrido_interno_rp ELSE p.det_recorrido_interno_ra END AS ruta"),
                DB::raw("CASE WHEN s.tipo_ruta = 1 THEN (SELECT CONCAT('SEDE ',sede,' ',direccion) FROM sedes_universidad WHERE id = p.lugar_salida_rp) ELSE (SELECT CONCAT('SEDE ',sede,' ',direccion) FROM sedes_universidad WHERE id = p.lugar_salida_ra) END AS sede_salida"),
                DB::raw("CASE WHEN s.tipo_ruta = 1 THEN (SELECT CONCAT('SEDE ',sede,' ',direccion) FROM sedes_universidad WHERE id = p.lugar_regreso_rp) ELSE (SELECT CONCAT('SEDE ',sede,' ',direccion) FROM sedes_universidad WHERE id = p.lugar_regreso_ra) END AS sede_regreso"),
                's.duracion_num_dias',
                 DB::raw("COALESCE(s.num_estudiantes, 0) + COALESCE(dp.num_docentes_apoyo, 0) + COALESCE(pi.cant_espa_aca, 0) + 1 AS numero_pasajeros"),
                's.fecha_salida',
                's.hora_salida',
                's.fecha_regreso',
                's.hora_regreso',
                DB::raw("CONCAT(u.primer_nombre, ' ', u.primer_apellido) as nombre_docente"),
                'u.id as id_user',                
                'u.celular',
            )
            ->join('programacion_practica as p', 'p.id', '=', 's.id_programacion_practica')
            ->leftJoin('docentes_practica as dp', 'dp.id', '=', 'p.id')
            ->join('practicas_integradas as pi', 'pi.id', '=', 'p.id')
            ->join('users as u', 'u.id', '=', 's.id_docente_creador')
            ->join('programa_academico as pa', 'pa.id', '=', 'p.id_programa_academico')
            ->join('espacio_academico as ea', 'ea.id', '=', 'p.id_espacio_academico')
            ->where('s.aprobacion_decano', '=', 7)
            ->where('s.id_estado_solicitud_practica', '=', 3)
            ->whereBetween('s.fecha_salida', [$fecha_inicial, $fecha_final])
            ->get();

        foreach ($solicitudes as $s) {
            $datos[] = [
                "",
                $s->id,
                $s->consec_dfamarena,
                "MEDIO AMBIENTE Y RECURSOS NATURALES",
                $mytime,
                "",
                $s->destino,
                $s->ruta,
                $s->sede_salida,
                $s->sede_regreso,
                $s->duracion_num_dias,
                $s->numero_pasajeros,
                $s->fecha_salida,
                $s->hora_salida,
                $s->fecha_regreso,
                $s->hora_regreso,
                $s->nombre_docente,
                $s->id_user,
                $s->celular,
                ""
            ];
        }
        return $datos;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        $sheet->mergeCells('B2:B4');
        $sheet->mergeCells('C2:P2');
        $sheet->mergeCells('C3:P3');
        $sheet->mergeCells('C4:P4');
        $sheet->mergeCells('Q2:R2');
        $sheet->mergeCells('Q3:R3');
        $sheet->mergeCells('Q4:R4');
        $sheet->mergeCells('S2:T4');
        $sheet->mergeCells('C6:T6');
        $sheet->mergeCells('C7:T7');
        $sheet->mergeCells('B9:T9');
        $columnas = range('B', 'T');
        foreach ($columnas as $col) {
            $sheet->mergeCells("{$col}11:{$col}12");
        }

        $sheet->getStyle("A1:U{$lastRow}")->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'FFFFFF']
            ],
        ]);
        $celdas = [
            'Q2','R2',
            'C3','D3','E3','F3','G3','H3','I3','J3','K3', 'L3', 'M3', 'N3', 'O3', 'P3', 'Q3', 'R3',
            'C4','D4','E4','F4','G4','H4','I4','J4','K4', 'L4', 'M4', 'N4', 'O4', 'P4', 'Q4', 'R4',
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
            'B9','C9','D9','E9','F9','G9','H9','I9','J9','K9','L9','M9','N9','O9','P9','Q9','R9','S9','T9',
            'B11','C11','D11','E11','F11','G11','H11','I11', 'J11', 'K11', 'L11', 'M11', 'N11', 'O11', 'P11', 'Q11', 'R11', 'S11', 'T11',
            
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

        $sheet->getStyle('B1:T11')->applyFromArray([
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        
        $sheet->getStyle('B2:T4')->applyFromArray([
            'font' => [
                'size' => 16,
            ]
        ]);
        
        $sheet->getStyle("B6:T{$lastRow}")->applyFromArray([
            'font' => [
                'size' => 14,
            ]
        ]);

        $sheet->getStyle("A1:U{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE
                ]
            ]
        ]);
        $ranges = [
            'B2:T4',
            'B6:T7',
            'B9:T9',
            'B9:T9',
            "B11:T{$lastRow}"
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

        $filas = [2, 3, 4, 6, 7, 9];
        foreach ($filas as $fila) {
            $sheet->getRowDimension($fila)->setRowHeight(40);
        }

        for ($i = 11; $i <= $lastRow; $i++) {
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
        $logo2->setCoordinates('S2');
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
            'K' => 15,
            'L' => 15,
            'M' => 25,
            'N' => 15,
            'O' => 25,
            'P' => 15,
            'Q' => 25,
            'R' => 25,
            'S' => 19,
            'T' => 19,
        ];
    }
}