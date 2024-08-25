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

class ProgramasAcademicosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $prog_aca=DB::table('programa_academico as prog_aca')
        ->select('prog_aca.id', 'prog_aca.programa_academico')->get();
        
        return $prog_aca;
    }

    public function headings():array
    {
        return[
            'ID', 
            'PROGRAMA ACADÉMICO'
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:B1';
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
        $titleSheet = "Programas Académicos";
        return $titleSheet;
    }
}
