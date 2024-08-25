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

class TiposIdentificacionesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    use Exportable;
    // public function __construct()
    // {

    // }

    public function collection()
    {
        $tipos_vinculaciones=DB::table('tipo_identificacion as tip_ide')
        ->select('tip_ide.id', 'tip_ide.tipo_identificacion', 'tip_ide.sigla')->get();
        
        return $tipos_vinculaciones;
    }

    public function headings():array
    {
        return['ID', 'TIPO IDENTIFICACIÓN', 'SIGLA'];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:C1';
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
        $titleSheet = "Tipos Identificación";
        return $titleSheet;
    }
}