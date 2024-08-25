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

class PeriodoAcademicoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    use Exportable;
    // public function __construct()
    // {

    // }

    public function collection()
    {
        $per_aca=DB::table('periodo_academico as per_aca')
        ->select('per_aca.id','per_aca.periodo_academico')->get();
        
        return $per_aca;
    }

    public function headings():array
    {
        return[
            'ID',
            'PERÍODO ACADÉMICO'
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
        $titleSheet = "Períodos Académicos";
        return $titleSheet;
    }
}
