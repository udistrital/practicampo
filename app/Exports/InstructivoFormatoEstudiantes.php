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
use PractiCampoUD\User;
use stdClass;

class InstructivoFormatoEstudiantes implements FromCollection,  ShouldAutoSize, WithEvents, WithTitle 
{
    public function __construct()
    {
     
    }

    public function collection()
    {
        return collect([
            [''],
            ['','INSTRUCTIVO PARA DILIGENCIAR FORMATO DE ESTUDIANTES'],
            ['','RECUERDE: A LA HORA DE CARGAR EL ARCHIVO EN EL SISTEMA DEJAR SOLO LA HOJA "ESTUDIANTES", YA QUE LAS OTRAS HOJAS SOLO SON GUÍAS PARA SU BUEN MANEJO.'],
            ['','RECUERDE: NO SE DEBE CAMBIAR LA ESTRUCTURA DEL FORMATO, SI EN DADO CASO EL FORMATO REQUIERE CAMBIOS COMUNÍQUELO A DECANATURA FAMARENA.'],
            ['','RECUERDE: NO SE DEBE CAMBIAR EL NOMBRE DEL DOCUMENTO, ESTE DEBE SER "LISTADO_ESTUDIANTES" EN MINÚSCULA TODO.'],
            [''],
            ['','CAMPO','DETALLE','FORMATO'],
            ['','CÓDIGO','Indique el código estudiantil del estudiante','Solo números'],
            ['','NOMBRE COMPLETO','Indique el nombre completo del estudiante(1er nombre, 2do nombre, 1er apellido, 2do apellido)','Solo texto, Mayúscula Inicial'],
            ['','CORREO PERSONAL','Indique el correo personal del estudiante','Solo texto'],
            ['','CORREO INSTITUCIONAL','Indique el correo institucional del estudiante','Solo texto'],
            ['','GRUPO','Indique el número asignado al grupo','Solo números'],
            
        ]);

    }

    // public function headings():array
    // {
    //     return[
    //         'INSTRUCTIVO PARA DILIGENCIAR FORMATO DE ESTUDIANTES', 
            
    //     ];
    // }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'B2:D2';
                $cellRange2 ='B7:D7'; 
                $cellRange3 ='B8:B12'; 
                $cellRange4 ='C8:C12'; 
                $cellRange5 ='D8:D12'; 
                $cellRange6 ='B3:D3'; 
                $cellRange7 ='B4:D4'; 
                $cellRange8 ='B5:D5'; 

                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(50);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(0,2);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(90);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(false);
                $event->sheet->getDelegate()->mergeCells($cellRange);
                $event->sheet->getDelegate()->mergeCells($cellRange6);
                $event->sheet->getDelegate()->mergeCells($cellRange7);
                $event->sheet->getDelegate()->mergeCells($cellRange8);
                $event->sheet->getDelegate()->getStyle($cellRange4)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle($cellRange6)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle($cellRange2)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange2)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange6)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange7)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange8)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange6)->getFont()->setItalic(true);
                $event->sheet->getDelegate()->getStyle($cellRange7)->getFont()->setItalic(true);
                $event->sheet->getDelegate()->getStyle($cellRange8)->getFont()->setItalic(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange6)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange7)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange8)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange4)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle($cellRange2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle($cellRange4)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle($cellRange5)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('74BB96');
                $event->sheet->getDelegate()->getStyle($cellRange2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('74BB96');
            },
            BeforeWriting::class=>function(BeforeWriting $event){
                $event->writer->setActiveSheetIndex(1);
            }
        ];
    }

    public function title(): string
    {
        $titleSheet = "Instructivo";
        return $titleSheet;
    }
}
