<?php

namespace PractiCampoUD\Exports;

use PractiCampoUD\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Concerns\WithTitle;

use DB;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $usuario=DB::table('users')
        ->select('users.id_tipo_identificacion', 'ti.sigla', 'users.id','users.expedicion_identificacion', 'users.id_role', 'roles.role', 'users.id_programa_academico_coord',
                 'users.id_tipo_vinculacion', 'tiv.tipo_vinculacion',
                 'users.id_estado', 'est.estado', 'users.cant_espacio_academico', 'users.id_espacio_academico_1', 'users.id_espacio_academico_2', 'users.id_espacio_academico_3',
                 'users.id_espacio_academico_4','users.id_espacio_academico_5','users.id_espacio_academico_6',
                //  'espa1.espacio_academico',
                //  'espa2.espacio_academico',
                //  'espa3.espacio_academico',
                //  'espa4.espacio_academico',   
                //  'espa6.espacio_academico',
                 'users.usuario', 'users.primer_nombre', 'users.segundo_nombre', 'users.primer_apellido', 'users.segundo_apellido', 'users.celular', 
                 'users.telefono', 'users.email')
        ->leftjoin('espacio_academico as espa1','users.id_espacio_academico_1','=','espa1.id')
        ->leftjoin('espacio_academico as espa2','users.id_espacio_academico_2','=','espa2.id')
        ->leftjoin('espacio_academico as espa3','users.id_espacio_academico_3','=','espa3.id')
        ->leftjoin('espacio_academico as espa4','users.id_espacio_academico_4','=','espa4.id')
        ->leftjoin('espacio_academico as espa5','users.id_espacio_academico_5','=','espa5.id')
        ->leftjoin('espacio_academico as espa6','users.id_espacio_academico_6','=','espa6.id')
        ->join('estado as est','users.id_estado','=','est.id')
        ->join('tipo_vinculacion as tiv','users.id_tipo_vinculacion','=','tiv.id')
        ->join('roles','users.id_role','=','roles.id')
        ->join('tipo_identificacion as ti','users.id_tipo_identificacion','=','ti.id')
        ->get();

        return $usuario;
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
        $titleSheet = "Usuarios";
        return $titleSheet;
    }

}
