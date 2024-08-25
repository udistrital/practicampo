<?php

namespace PractiCampoUD\Exports;

use PractiCampoUD\tipo_transporte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Concerns\WithTitle;

use DB;

class TipoVehiculosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;

    public function collection()
    {
        $transportes=DB::table('tipo_transporte as tp_trans')
        ->select('tp_trans.id','tp_trans.tipo_transporte')->get();
        
        return $transportes;
    }

    public function headings():array
    {
        return[
            'ID',
            'TIPO VEHÍCULO'
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
        $titleSheet = "Tipos Vehículos";
        return $titleSheet;
    }
}
