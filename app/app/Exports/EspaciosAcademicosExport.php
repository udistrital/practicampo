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

class EspaciosAcademicosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    use Exportable;
    // public function __construct()
    // {

    // }

    public function collection()
    {
        $esp_aca=DB::table('espacio_academico as esp_aca')
        ->select('esp_aca.id','esp_aca.espacio_academico','esp_aca.codigo_espacio_academico','pro_aca.programa_academico')
        ->join('programa_academico as pro_aca','esp_aca.id_programa_academico','=','pro_aca.id')->get();
        
        return $esp_aca;
    }

    public function headings():array
    {
        return[
            'ID', 
            'ESPACIO ACADÉMICO',
            'CÓD.ESPACIO ACADÉMICO',
            'PROGRAMA ACADÉMICO'
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:D1';
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
        $titleSheet = "Espacios Académicos";
        return $titleSheet;
    }
}