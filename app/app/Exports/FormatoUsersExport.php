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

use DB;

class FormatoUsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    use Exportable;
    // public function __construct()
    // {

    // }

    public function collection()
    {
        return collect([
            // []
        ]);
    }

    public function headings():array
    {
        return['ID TI', 'TI', 'IDENTIFICACION','EXP. IDENTIFICACION', 'ID ROL', 'ROL', 
               'ID PROG. ACADÉ. COORD.',
               'ID VINCULACION', 'VINCULACION', 'ID ESTADO', 'ESTADO', 
               'CANT. ESP. ACAD',
               'ID ESP. ACAD 1',
            //    'ESP. ACAD 1',
               'ID ESP. ACAD 2', 
            //    'ESP. ACAD 2', 
               'ID ESP. ACAD 3', 
            //    'ESP. ACAD 3', 
               'ID ESP. ACAD 4', 
            //    'ESP. ACAD 4', 
               'ID ESP. ACAD 5', 
            //    'ESP. ACAD 5',
               'ID ESP. ACAD 6', 
            //    'ESP. ACAD 6',
               'USUARIO', '1ER NOMBRE', '2DO NOMBRE', '1ER APELLIDO',
               '2DO APELLIDO','CELULAR', 'TELEFONO','EMAIL'
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:Z1';
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
        $titleSheet = "usuarios";
        return $titleSheet;
    }
}
