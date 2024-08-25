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

class InstructivoFormatoUsers implements FromCollection,  ShouldAutoSize, WithEvents, WithTitle 
{
    public function __construct()
    {
     
    }

    public function collection()
    {
        return collect([
            [''],
            ['','INSTRUCTIVO PARA DILIGENCIAR FORMATO DE USUARIOS'],
            ['','RECUERDE: A LA HORA DE CARGAR EL ARCHIVO EN EL SISTEMA DEJAR SOLO LA HOJA "USUARIOS", YA QUE LAS OTRAS HOJAS SOLO SON GUÍAS PARA SU BUEN MANEJO.'],
            ['','RECUERDE: NO SE DEBE CAMBIAR LA ESTRUCTURA DEL FORMATO, SI EN DADO CASO EL FORMATO REQUIERE CAMBIOS COMUNÍQUELO A DECANATURA FAMARENA.'],
            ['','RECUERDE: NO SE DEBE CAMBIAR EL NOMBRE DEL DOCUMENTO, ESTE DEBE SER "USUARIOS" EN MINÚSCULA TODO.'],
            [''],
            ['','CAMPO','DETALLE','FORMATO'],
            ['','ID TI','Indique el ID del tipo de identificación que corresponda','Solo números'],
            ['','IDENTIFICACIÓN','Número de identificación del usuario','Solo números'],
            ['','EXP. IDENTIFICACIÓN','Lugar de expedición del documento de identificacón del usuario','Solo texto, Mayúscula Inicial'],
            ['','ID ROL','Indique el ID del rol que corresponda','Solo números'],
            ['','ID PROG. ACADÉ. COORD','Indique el ID del programa académico que corresponda(Solo para el rol COORDINADOR','Solo números'],
            ['','ID VINCULACIÓN','Indique el ID del tipo de vinculación que corresponda','Solo números'],
            ['','ID ESTADO','Indique el ID del estado que corresponda','Solo números'],
            ['','CANT. ESP. ACAD','Cantidad de espacios académicos asociados al usuario. Para los roles diferentes al de DOCENTE se debe dejar este campo con el valor "1"','Solo números'],
            ['','ID ESP. ACAD 1','Indique el ID del espacio académico que corresponda. Deje la celda en blanco en caso de NO requerirla. Para los roles diferentes al de DOCENTE se debe dejar este campo con el valor "999"','Solo números'],
            ['','ID ESP. ACAD 2','Indique el ID del espacio académico que corresponda. Deje la celda en blanco en caso de NO requerirla','Solo números'],
            ['','ID ESP. ACAD 3','Indique el ID del espacio académico que corresponda. Deje la celda en blanco en caso de NO requerirla','Solo números'],
            ['','ID ESP. ACAD 4','Indique el ID del espacio académico que corresponda. Deje la celda en blanco en caso de NO requerirla','Solo números'],
            ['','ID ESP. ACAD 5','Indique el ID del espacio académico que corresponda. Deje la celda en blanco en caso de NO requerirla','Solo números'],
            ['','ID ESP. ACAD 6','Indique el ID del espacio académico que corresponda. Deje la celda en blanco en caso de NO requerirla','Solo números'],
            ['','USUARIO','Indique el nombre de usuario del correo institucional. Ej. practicampoud para el correo practicampoud@udistrital.edu.co','Solo texto'],
            ['','1ER NOMBRE','Indique el primer nombre del usuario','Solo texto, Mayúscula Inicial'],
            ['','2DO NOMBRE','Indique el segundo nombre del usuario. Deje la celda en blanco en caso de NO reaquerirla','Solo texto, Mayúscula Inicial'],
            ['','1ER APELLIDO','Indique el primer apellido del usuario','Solo texto, Mayúscula Inicial'],
            ['','2DO APELLIDO','Indique el segundo apellido del usuario. Deje la celda en blanco en caso de NO reaquerirla','Solo texto, Mayúscula Inicial'],
            ['','CELULAR','Número de celular del usuario','Solo números'],
            ['','TELÉFONO','Número de teléfono del usuario','Solo números'],
            ['','EMAIL','Indique el correo institucional del usuario','Solo texto'],
            
        ]);

    }

    // public function headings():array
    // {
    //     return[
    //         'INSTRUCTIVO PARA DILIGENCIAR FORMATO DE USUARIOS', 
            
    //     ];
    // }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'B2:D2';
                $cellRange2 ='B7:D7'; 
                $cellRange3 ='B8:B29'; 
                $cellRange4 ='C8:C29'; 
                $cellRange5 ='D8:D29'; 
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
