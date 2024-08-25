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
use push;
use Maatwebsite\Excel\Row;

use DB;
use PhpParser\Node\Expr\AssignOp\Concat;

class ProyeccionesIntegradasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    use Exportable;
    public function __construct($id)
    {
        $this->id_proyeccion = $id;
    }

    public function collection()
    {
        $lista_proyecciones = $this->id_proyeccion;
        $proyeccion = collect();

        foreach($lista_proyecciones[0]  as $id_proye)
        {
            
            $proyecciones=DB::table('proyeccion_preliminar as proy_prel')
            ->select('proy_prel.id','prog_aca.programa_academico',
            'integ_1.codigo_espacio_academico as cod_int_1','integ_1.espacio_academico as esp_int_1',
            DB::raw('CONCAT_WS(" ", us_1.primer_nombre, us_1.segundo_nombre, us_1.primer_apellido, us_1.segundo_apellido) as full_name_1'),
            'integ_2.codigo_espacio_academico as cod_int_2','integ_2.espacio_academico as esp_int_2',
            DB::raw('CONCAT_WS(" ", us_2.primer_nombre, us_2.segundo_nombre, us_2.primer_apellido, us_2.segundo_apellido) as full_name_2'),
            'integ_3.codigo_espacio_academico as cod_int_3','integ_3.espacio_academico as esp_int_3',
            DB::raw('CONCAT_WS(" ", us_3.primer_nombre, us_3.segundo_nombre, us_3.primer_apellido, us_3.segundo_apellido) as full_name_3'),
            'integ_4.codigo_espacio_academico as cod_int_4','integ_4.espacio_academico as esp_int_4',
            DB::raw('CONCAT_WS(" ", us_4.primer_nombre, us_4.segundo_nombre, us_4.primer_apellido, us_4.segundo_apellido) as full_name_4'),
            'integ_5.codigo_espacio_academico as cod_int_5','integ_5.espacio_academico as esp_int_5',
            DB::raw('CONCAT_WS(" ", us_5.primer_nombre, us_5.segundo_nombre, us_5.primer_apellido, us_5.segundo_apellido) as full_name_5'),
            'integ_6.codigo_espacio_academico as cod_int_6','integ_6.espacio_academico as esp_int_6',
            DB::raw('CONCAT_WS(" ", us_6.primer_nombre, us_6.segundo_nombre, us_6.primer_apellido, us_6.segundo_apellido) as full_name_6'),
            'integ_7.codigo_espacio_academico as cod_int_7','integ_7.espacio_academico as esp_int_7',
            DB::raw('CONCAT_WS(" ", us_7.primer_nombre, us_7.segundo_nombre, us_7.primer_apellido, us_7.segundo_apellido) as full_name_7')
            )
            ->join('espacio_academico as espa','proy_prel.id_espacio_academico','=','espa.id')
            ->join('programa_academico as prog_aca','espa.id_programa_academico','=','prog_aca.id')
            ->join('practicas_integradas as integ','proy_prel.id','=','integ.id')
            ->leftjoin('espacio_academico as integ_1','integ.id_espa_aca_1','=','integ_1.id')
            ->leftjoin('espacio_academico as integ_2','integ.id_espa_aca_2','=','integ_2.id')
            ->leftjoin('espacio_academico as integ_3','integ.id_espa_aca_3','=','integ_3.id')
            ->leftjoin('espacio_academico as integ_4','integ.id_espa_aca_4','=','integ_4.id')
            ->leftjoin('espacio_academico as integ_5','integ.id_espa_aca_5','=','integ_5.id')
            ->leftjoin('espacio_academico as integ_6','integ.id_espa_aca_6','=','integ_6.id')
            ->leftjoin('espacio_academico as integ_7','integ.id_espa_aca_7','=','integ_7.id')
            ->leftjoin('users as us_1','integ.id_docen_espa_aca_1','=','us_1.id')
            ->leftjoin('users as us_2','integ.id_docen_espa_aca_2','=','us_2.id')
            ->leftjoin('users as us_3','integ.id_docen_espa_aca_3','=','us_3.id')
            ->leftjoin('users as us_4','integ.id_docen_espa_aca_4','=','us_4.id')
            ->leftjoin('users as us_5','integ.id_docen_espa_aca_5','=','us_5.id')
            ->leftjoin('users as us_6','integ.id_docen_espa_aca_6','=','us_6.id')
            ->leftjoin('users as us_7','integ.id_docen_espa_aca_7','=','us_7.id')
            ->where('integ.id',$id_proye)->first();

            $proyeccion->push($proyecciones);
        }

        return $proyeccion;
    }

    public function headings():array
    {
        return['ID PROYECCIÓN','PROGRAMA ACADÉMICO', 'CÓD. ESPACIO ACADÉMICO 1', 'ESPACIO ACADÉMICO 1', 'DOCENTE 1',
                'CÓD. ESPACIO ACADÉMICO 2', 'ESPACIO ACADÉMICO 2', 'DOCENTE 2',
                'CÓD. ESPACIO ACADÉMICO 3', 'ESPACIO ACADÉMICO 3', 'DOCENTE 3',
                'CÓD. ESPACIO ACADÉMICO 4', 'ESPACIO ACADÉMICO 4', 'DOCENTE 4',
                'CÓD. ESPACIO ACADÉMICO 5', 'ESPACIO ACADÉMICO 5', 'DOCENTE 5',
                'CÓD. ESPACIO ACADÉMICO 6', 'ESPACIO ACADÉMICO 6', 'DOCENTE 6',
                'CÓD. ESPACIO ACADÉMICO 7', 'ESPACIO ACADÉMICO 7', 'DOCENTE 7'];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('74BB96');
            },
            BeforeWriting::class=>function(BeforeWriting $event){
                $event->writer->setActiveSheetIndex(0);
            }
        ];
    }

    public function title(): string
    {
        $titleSheet = "PLAN DE PRACTICAS - INTEGRADAS";
        return $titleSheet;
    }
}