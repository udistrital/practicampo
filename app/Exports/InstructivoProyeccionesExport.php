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
use PractiCampoUD\categoria;
use PractiCampoUD\formatoExportProy;
use PractiCampoUD\proyeccion;
use stdClass;

class InstructivoProyeccionesExport implements FromCollection,  ShouldAutoSize, WithEvents, WithTitle 
{
    public function __construct()
    {
     
    }

    public function collection()
    {
        return collect([
            [''],
            ['','INSTRUCTIVO PARA DILIGENCIAR FORMATO DE PROYECCIONES PRELIMINARES'],
            ['','RECUERDE: A LA HORA DE CARGAR EL ARCHIVO EN EL SISTEMA DEJAR SOLO LA HOJA "PROYECCIONES", YA QUE LAS OTRAS HOJAS SOLO SON GUÍAS PARA SU BUEN MANEJO.'],
            ['','RECUERDE: NO SE DEBE CAMBIAR LA ESTRUCTURA DEL FORMATO, SI EN DADO CASO EL FORMATO REQUIERE CAMBIOS COMUNÍQUELO A DECANATURA FAMARENA.'],
            ['','RECUERDE: NO SE DEBE CAMBIAR EL NOMBRE DEL DOCUMENTO, ESTE DEBE SER "PROYECCIONES_PRELIMINARES" EN MINÚSCULA TODO.'],
            [''],
            ['','CAMPO','DETALLE','FORMATO'],
            ['','ID PROGRAMA ACADÉMICO','Indique el ID del Programa Académico que corresponda','Solo números'],
            ['','ID ESPACIO ACADÉMICO','Indique el ID del Espacio Académico que corresponda','Solo números'],
            ['','SEM. ASIG','Indique el ID del Semestre de Asignatura que corresponda','Solo números'],
            ['','AÑO PER.','Indique el año en el que se realizará la práctica académica de campo','Solo números'],
            ['','PER. ACA','Indique el ID del Período Académico que corresponda','Solo números'],
            ['','NUM. IDENT. DOCENTE','Número de identificación del docente a cargo de la práctica académica de campo','Solo números'],
            ['','DOCENTE RESPONSABLE','Nombre del docente a cargo de la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','CANT. GRUPOS','Cantidad de gurpos que van a asistir a la práctica académica de campo','Solo números'],
            ['','GRUPO 1','Número del grupo según el registro en el Sistema de Gestión Académica','Solo números'],
            ['','GRUPO 2','Número del grupo según el registro en el Sistema de Gestión Académica','Solo números'],
            ['','GRUPO 3','Número del grupo según el registro en el Sistema de Gestión Académica','Solo números'],
            ['','GRUPO 4','Número del grupo según el registro en el Sistema de Gestión Académica','Solo números'],
            ['','NÚMERO DE ESTUDIANTES','Cantidad de estudiantes que asitirán a la práctica académica de campo, se DEBE incluir al monitor si corresponde','Solo números'],
            ['','NÚMERO PERSONAS APOYO','Cantidad de personas de apoyo que asitirán a la práctica académica de campo','Solo números'],
            ['','TOTAL DOCENTES APOYO','De las personas de apoyo que asitirán a la práctica académica de campo, cuántos correspondes a docentes?','Solo números'],
            ['','PERSONAL APOYO 1','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 2','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 3','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 4','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 5','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 6','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 7','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 8','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 9','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PERSONAL APOYO 10','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','DESTINO RUTA PRINCIPAL','Nombre referente al destino de la práctica académica de campo','Solo texto'],
            ['','CANT. URL RUTA PRINCIPAL','Cantidad de URL que requiere para trazar el recorrido de la práctica académica de campo','Solo números entre [1 - 6]'],
            ['','URL 1 RUTA PRINCIPAL','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 2 RUTA PRINCIPAL','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 3 RUTA PRINCIPAL','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 4 RUTA PRINCIPAL','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 5 RUTA PRINCIPAL','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 6 RUTA PRINCIPAL','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','DETALLE DEL RECORRIDO INTERNO RP','Indicar el detalle del recorrido que se realizará en la práctica académica de campo',''],
            ['','ID SEDE SALIDA RP','Indique el ID de la Sede Universidad que corresponda','Solo números'],
            ['','ID SEDE REGRESO RP','Indique el ID de la Sede Universidad que corresponda','Solo números'],
            ['','SALIDA (FECHA TENTATIVA) RP','Indique la fecha de salida de la práctica académica de campo','Formato TEXTO aaaa-mm-dd'],
            ['','REGRESO (FECHA TENTATIVA) RP','Indique la fecha de regreso de la práctica académica de campo','Formato TEXTO aaaa-mm-dd'],
            ['','CANT. VEHÍCULOS RP','Cantidad de vehículos requeridos para la práctica académica de campo','Solo números entre [0 - 3]'],
            ['','ID TIPO VEHÍCULO 1 RP','Indique el ID del Tipo de Vehículo que corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','CAPAC. VEHÍCULO 1 RP','Cantidad de personas que irán en el vehiculo. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','DET. VEHÍCULO 1 RP','Información relacionada a especificaciones requeridas sobre el vehículo. Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            ['','DISP. PERMANENTE VEHÍCULO 1 RP','Indique si requiere que el vehículo este todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            ['','ID TIPO VEHÍCULO 2 RP','Indique el ID del Tipo de Vehículo que corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','CAPAC. VEHÍCULO 2 RP','Cantidad de personas que irán en el vehiculo. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','DET. VEHÍCULO 2 RP','Información relacionada a especificaciones requeridas sobre el vehículo. Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            ['','DISP. PERMANENTE VEHÍCULO 2 RP','Indique si requiere que el vehículo este todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            ['','ID TIPO VEHÍCULO 3 RP','Indique el ID del Tipo de Vehículo que corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','CAPAC. VEHÍCULO 3 RP','Cantidad de personas que irán en el vehiculo. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','DET. VEHÍCULO 3 RP','Información relacionada a especificaciones requeridas sobre el vehículo. Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            ['','DISP. PERMANENTE VEHÍCULO 3 RP','Indique si requiere que el vehículo este todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            ['','CANT. TRANSPORTE MENOR RP','Cantidad de vehículos asociados a transporte menor/local requeridos para la práctica académica de campo','Solo números entre [0 - 4]'],
            ['','TRANSPORTE MENOR 1 RP','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 1 RP','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 2 RP','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 2 RP','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 3 RP','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 3 RP','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 4 RP','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 4 RP','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','MATERIALES RP','Indique el nombre de los materiales requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir materiales',''],
            ['','VLR. TOTAL MATERIALES RP','Valor total de los materiales. Deje la celda en blanco en caso de NO requerir materiales','Solo números'],
            ['','GUÍAS/BAQUIANOS RP','Indique el nombre de los guías/baquianos requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir guías/baquianos',''],
            ['','VLR. TOTAL GUÍAS/BAQUIANOS RP','Valor total de los guías/baquianos. Deje la celda en blanco en caso de NO requerir guías/baquianos','Solo números'],
            ['','BOLETAS/OTROS RP','Indique el nombre de las boletas/otros requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir boletas/otros',''],
            ['','VLR. TOTAL BOLETAS/OTROS RP','Valor total de las boletas/otros. Deje la celda en blanco en caso de NO requerir boletas/otros','Solo números'],
            ['','ÁREAS ACUÁTICAS RP','Indique si la práctica académica de campo desarrolla maniobras  sobre áreas acuáticas(Ríos, lagos, lagunas, humedales, mares, etc). De ser afirmativa, DEBE tener un plan de contingencia basado en la mátriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','ALTURAS RP','Indique si la práctica académica de campo desarrolla desarrolla actividades de escalada o trabajo de alturas. De ser afirmativa, DEBE tener un plan de contingencia basado en la mátriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','RIESGO BIOLÓGICO RP','Indique si la práctica académica de campo desarrolla actividades al interior de bosques o lugares con riesgo biológico. De ser afirmativa, DEBE tener un plan de contingencia basado en la mátriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','ESPACIOS CONFINADOS RP','Indique si la práctica académica de campo desarrolla actividades en espacios confinados. De ser afirmativa, DEBE tener un plan de contingencia basado en la mátriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','DESTINO RUTA CONTINGENCIA','Nombre referente al destino de la práctica académica de campo','Solo texto'],
            ['','CANT. URL RUTA CONTINGENCIA','Cantidad de URL que requiere para trazar el recorrido de la práctica académica de campo','Solo números entre [1 - 6]'],
            ['','URL 1 RUTA CONTINGENCIA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 2 RUTA CONTINGENCIA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 3 RUTA CONTINGENCIA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 4 RUTA CONTINGENCIA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 5 RUTA CONTINGENCIA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','URL 6 RUTA CONTINGENCIA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','DETALLE DEL RECORRIDO INTERNO RC','Indicar el detalle del recorrido que se realizará en la práctica académica de campo',''],
            ['','ID SEDE SALIDA RC','Indique el ID de la Sede Universidad que corresponda','Solo números'],
            ['','ID SEDE REGRESO RC','Indique el ID de la Sede Universidad que corresponda','Solo números'],
            ['','SALIDA (FECHA TENTATIVA) RC','Indique la fecha de salida de la práctica académica de campo','Formato TEXTO aaaa-mm-dd'],
            ['','REGRESO (FECHA TENTATIVA) RC','Indique la fecha de regreso de la práctica académica de campo','Formato TEXTO aaaa-mm-dd'],
            ['','CANT. VEHÍCULOS RC','Cantidad de vehículos requeridos para la práctica académica de campo','Solo números entre [0 - 3]'],
            ['','ID TIPO VEHÍCULO 1 RC','Indique el ID del Tipo de Vehículo que corresponda, deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','CAPAC. VEHÍCULO 1 RC','Cantidad de personas que irán en el vehiculo, deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','DET. VEHÍCULO 1 RC','Información relacionada a especificaciones requeridas sobre el vehículo. Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            ['','DISP. PERMANENTE VEHÍCULO 1 RC','Indique si requiere que el vehículo este todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            ['','ID TIPO VEHÍCULO 2 RC','Indique el ID del Tipo de Vehículo que corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','CAPAC. VEHÍCULO 2 RC','Cantidad de personas que irán en el vehiculo. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','DET. VEHÍCULO 2 RC','Información relacionada a especificaciones requeridas sobre el vehículo. Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            ['','DISP. PERMANENTE VEHÍCULO 2 RC','Indique si requiere que el vehículo este todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            ['','ID TIPO VEHÍCULO 3 RC','Indique el ID del Tipo de Vehículo que corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','CAPAC. VEHÍCULO 3 RC','Cantidad de personas que irán en el vehiculo. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','DET. VEHÍCULO 3 RC','Información relacionada a especificaciones requeridas sobre el vehículo. Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            ['','DISP. PERMANENTE VEHÍCULO 3 RC','Indique si requiere que el vehículo este todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            ['','CANT. TRANSPORTE MENOR RC','Cantidad de vehículos asociados a transporte menor/local requeridos para la práctica académica de campo','Solo números entre [0 - 4]'],
            ['','TRANSPORTE MENOR 1 RC','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 1 RC','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 2 RC','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 2 RC','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 3 RC','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 3 RC','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 4 RC','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 4 RC','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','MATERIALES RC','Indique el nombre de los materiales requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir materiales',''],
            ['','VLR. TOTAL MATERIALES RC','Valor total de los materiales. Deje la celda en blanco en caso de NO requerir materiales','Solo números'],
            ['','GUÍAS/BAQUIANOS RC','Indique el nombre de los guías/baquianos requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir guías/baquianos',''],
            ['','VLR. TOTAL GUÍAS/BAQUIANOS RC','Valor total de los guías/baquianos. Deje la celda en blanco en caso de NO requerir guías/baquianos','Solo números'],
            ['','BOLETAS/OTROS RC','Indique el nombre de las boletas/otros requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir boletas/otros',''],
            ['','VLR. TOTAL BOLETAS/OTROS RC','Valor total de las boletas/otros. Deje la celda en blanco en caso de NO requerir boletas/otros','Solo números'],
            ['','ÁREAS ACUÁTICAS RC','Indique si la práctica académica de campo desarrolla maniobras  sobre áreas acuáticas(Ríos, lagos, lagunas, humedales, mares, etc). De ser afirmativa, DEBE tener un plan de contingencia basado en la mátriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','ALTURAS RC','Indique si la práctica académica de campo desarrolla desarrolla actividades de escalada o trabajo de alturas. De ser afirmativa, DEBE tener un plan de contingencia basado en la mátriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','RIESGO BIOLÓGICO RC','Indique si la práctica académica de campo desarrolla actividades al interior de bosques o lugares con riesgo biológico. De ser afirmativa, DEBE tener un plan de contingencia basado en la mátriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','ESPACIOS CONFINADOS RC','Indique si la práctica académica de campo desarrolla actividades en espacios confinados. De ser afirmativa, DEBE tener un plan de contingencia basado en la mátriz de riesgos','Solo números [0:NO - 1:SI]']
        ]);

    }

    // public function headings():array
    // {
    //     return[
    //         'INSTRUCTIVO PARA DILIGENCIAR FORMATO DE PROYECCIONES PRELIMINARES', 
            
    //     ];
    // }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'B2:D2';
                $cellRange2 ='B7:D7'; 
                $cellRange3 ='B8:B122'; 
                $cellRange4 ='C8:C122'; 
                $cellRange5 ='D8:D122'; 
                $cellRange6 ='B3:D3'; 
                $cellRange7 ='B4:D4'; 
                $cellRange8 ='B5:D5'; 

                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(50);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(0,2);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(80);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(false);
                $event->sheet->getDelegate()->mergeCells($cellRange);
                $event->sheet->getDelegate()->mergeCells($cellRange6);
                $event->sheet->getDelegate()->mergeCells($cellRange7);
                $event->sheet->getDelegate()->mergeCells($cellRange8);
                $event->sheet->getDelegate()->getStyle($cellRange4)->getAlignment()->setWrapText(true);
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
