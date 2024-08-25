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
use PractiCampoUD\Exports\collection;
use PractiCampoUD\categoria;
use PractiCampoUD\formatoExportSolic;
use PractiCampoUD\proyeccion;
use stdClass;

class FormatoSolicitudes implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;
    public function __construct()
    {
     
    }

    public function collection()
    {
        return collect([
            ['(Consultar en el Sistema Web PractiCampoUD)','Solo números','Mayúscula cada palabra',
            '(Solo números)','(Solo números)','(Solo números)','(Solo números)','(Solo números)',
            '(Solo números)','(Solo números)',
            '(Hoja Tipos Personal Apoyo)','(Solo números)','(Mayúscula cada palabra)',
            '(Hoja Tipos Personal Apoyo)','(Solo números)','(Mayúscula cada palabra)',
            '(Indicar [0:NO - 1:SI])','(Solo números)',
            '(Solo números)','(Solo números)','(Solo números)','(Solo números)',
            '(Solo números)','(Solo números)','(Solo números)','(Solo números)',
            '(Solo números)','(Solo números)','(Solo números)','(Solo números)',
            '(Solo números)','(Solo números)','(Solo números)',
            '(Detallar el recorrido)',
            '(Hoja Sedes Universidad)','(Hoja Sedes Universidad)',
            '(Formato TEXTO aaaa-mm-dd)', '(Formato h:00 AM/PM)',
            '(Formato TEXTO aaaa-mm-dd)', '(Formato h:00 AM/PM)',
            '(Mayúscula inicial)','(Solo números)',
            '(Solo números)','(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)',
            '(Indicar [0:NO - 1:SI])','(Indicar [0:NO - 1:SI])','(Indicar [0:NO - 1:SI])','(Indicar [0:NO - 1:SI])',
            '(Detallar el cronograma del recorrido)','(Detallar las observaciones de la práctica, NO es obligatorio)','(Detallar la justificación de la práctica)',
            '(Detallar el objetivo general de la práctica)','(Detallar la metodología de trabajo y evaluación de la práctica)',
            '(Indicar [0:NO - 1:SI])','(Indicar [0:NO - 1:SI])',
            '(Indicar [0:NO - 1:SI])','Indicar el nombre del certificado',
            '(Indicar [0:NO - 1:SI])','Indicar el nombre del certificado',
            '(Indicar [0:NO - 1:SI])','Indicar el nombre del certificado'
            ]
        ]);

    }

    public function headings():array
    {
        return[
            'ID PROYECCIÓN',
            // 'ID PROGRAMA ACADÉMICO', 
            // 'ID ESPACIO ACADÉMICO',
            // 'SEM. ASIG',
            // 'AÑO PER.',
            // 'PER. ACA',
            'NUM. IDENT. DOCENTE',
            'DOCENTE RESPONSABLE',
            'CANT. GRUPOS',
            'GRUPO 1',
            'GRUPO 2',
            'GRUPO 3',
            'GRUPO 4',
            'NÚMERO DE ESTUDIANTES',
            'CANT. PERSONAL APOYO',
            // 'TOTAL DOCENTES APOYO',
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
            // 'CANT. URL RUTA',
            // 'URL 1 RUTA',
            // 'URL 2 RUTA',
            // 'URL 3 RUTA',
            // 'URL 4 RUTA',
            // 'URL 5 RUTA',
            // 'URL 6 RUTA',
            'DETALLE DEL RECORRIDO INTERNO',
            'ID SEDE SALIDA',
            'ID SEDE REGRESO',
            'SALIDA (FECHA CONFIRMADA)',
            'HORA SALIDA',
            'REGRESO (FECHA CONFIRMADA)',
            'HORA REGRESO',
            // 'CANT. VEHÍCULOS',
            // 'ID TIPO VEHÍCULO 1',
            // 'CAPAC. VEHÍCULO 1',
            'DET. VEHÍCULO',
            'DISP. PERMANENTE VEHÍCULO',
            // 'ID TIPO VEHÍCULO 2',
            // 'CAPAC. VEHÍCULO 2',
            // 'DET. VEHÍCULO 2',
            // 'DISP. PERMANENTE VEHÍCULO 2',
            // 'ID TIPO VEHÍCULO 3',
            // 'CAPAC. VEHÍCULO 3',
            // 'DET. VEHÍCULO 3',
            // 'DISP. PERMANENTE VEHÍCULO 3',
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
                $cellRange = 'A1:BV1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('74BB96');
            },
            BeforeWriting::class=>function(BeforeWriting $event){
                $event->writer->setActiveSheetIndex(0);
            }
        ];
    }

    public function title(): string
    {
        $titleSheet = "solicitudes";
        return $titleSheet;
    }
}
