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
use PractiCampoUD\formatoExportSolic;
use PractiCampoUD\proyeccion;
use stdClass;

class InstructivoSolicitudesExport implements FromCollection,  ShouldAutoSize, WithEvents, WithTitle 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        //
    }

    public function collection()
    {
        return collect([
            [''],
            ['','INSTRUCTIVO PARA DILIGENCIAR FORMATO DE SOLICITUDES DE PRÁCTICA'],
            ['','RECUERDE: A LA HORA DE CARGAR EL ARCHIVO EN EL SISTEMA DEJAR SOLO LA HOJA "SOLICITUDES", YA QUE LAS OTRAS HOJAS SOLO SON GUÍAS PARA SU BUEN MANEJO.'],
            ['','RECUERDE: NO SE DEBE CAMBIAR LA ESTRUCTURA DEL FORMATO, SI EN DADO CASO EL FORMATO REQUIERE CAMBIOS COMUNÍQUELO A LA DECANATURA FAMARENA.'],
            ['','RECUERDE: NO SE DEBE CAMBIAR EL NOMBRE DEL DOCUMENTO, ESTE DEBE SER "INFORMACION_SOLICITUDES" EN MINÚSCULA TODO Y SIN TÍLDES.'],
            [''],
            ['','CAMPO','DETALLE','FORMATO'],
            ['','ID PROYECCIÓN','Indique el ID de la proyección preliminar que corresponda para completar','Solo números'],
            // ['','ID PROGRAMA ACADÉMICO','Indique el ID del Programa Académico que corresponda','Solo números'],
            // ['','ID ESPACIO ACADÉMICO','Indique el ID del Espacio Académico que corresponda','Solo números'],
            // ['','SEM. ASIG','Indique el ID del Semestre de Asignatura que corresponda','Solo números'],
            // ['','AÑO PER.','Indique el año en el que se realizará la práctica académica de campo','Solo números'],
            // ['','PER. ACA','Indique el ID del Período Académico que corresponda','Solo números'],
            ['','NUM. IDENT. DOCENTE','Número de identificación del docente a cargo de la práctica académica de campo','Solo números'],
            ['','DOCENTE RESPONSABLE','Nombre del docente a cargo de la práctica académica de campo. Primer Nombre y primer apellido','Solo texto, Mayúscula cada palabra'],
            ['','CANT. GRUPOS','Cantidad de grupos que van a asistir a la práctica académica de campo','Solo números'],
            ['','GRUPO 1','Número del grupo según el registro en el Sistema de Gestión Académica','Solo números'],
            ['','GRUPO 2','Número del grupo según el registro en el Sistema de Gestión Académica. Deje la celda en blanco en caso de NO requerir este grupo','Solo números'],
            ['','GRUPO 3','Número del grupo según el registro en el Sistema de Gestión Académica. Deje la celda en blanco en caso de NO requerir este grupo','Solo números'],
            ['','GRUPO 4','Número del grupo según el registro en el Sistema de Gestión Académica. Deje la celda en blanco en caso de NO requerir este grupo','Solo números'],
            ['','NÚMERO DE ESTUDIANTES','Cantidad de estudiantes que asistirán a la práctica académica de campo, se DEBE incluir al monitor si corresponde','Solo números'],
            ['','CANT. PERSONAL APOYO','Cantidad de personas de apoyo que asistirán a la práctica académica de campo','Solo números'],
            ['','ID TIPO PERSONAL APOYO 1','Indique el ID del tipo de personal de apoyo que corresponda. Deje la celda en blanco en caso de NO requerir personal de apoyo','Solo números'],
            ['','NUM. IDENT. PERSONAL APOYO 1','Número de identificación de la persona de apoyo. Deje la celda en blanco en caso de NO requerir personal de apoyo','Solo números'],
            ['','PERSONAL APOYO 1','Nombre de la persona de apoyo que asistirá a la práctica académica de campo. Deje la celda en blanco en caso de NO requerir personal de apoyo','Solo texto, Mayúscula cada palabra'],
            ['','ID TIPO PERSONAL APOYO 2','Indique el ID del tipo de personal de apoyo que corresponda. Deje la celda en blanco en caso de NO requerir personal de apoyo','Solo números'],
            ['','NUM. IDENT. PERSONAL APOYO 2','Número de identificación de la persona de apoyo. Deje la celda en blanco en caso de NO requerir personal de apoyo','Solo números'],
            ['','PERSONAL APOYO 2','Nombre de la persona de apoyo que asistirá a la práctica académica de campo','Solo texto, Mayúscula cada palabra'],
            ['','PRÁCTICA INTEGRADA','Indique si es o no una práctica integrada','Solo números [0:NO - 1:SI]'],
            ['','CANT. DOCENTES PARTICIPANTES','Cantidad de docentes que participarán de la práctica integrada. Deje la celda en blanco en caso de NO SEA una práctica integrada','Solo números'],
            ['','NUM. IDENT. DOCENTE PARTICIPANTE 1','Número de identificación del docente participante. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','ID ESP. ACAD. DOCENTE PARTICIPANTE 1','Indique el ID del Espacio Académico asociado al docente participante de la práctica académica de campo. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','NUM. IDENT. DOCENTE PARTICIPANTE 2','Número de identificación del docente participante. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','ID ESP. ACAD. DOCENTE PARTICIPANTE 2','Indique el ID del Espacio Académico asociado al docente participante de la práctica académica de campo. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','NUM. IDENT. DOCENTE PARTICIPANTE 3','Número de identificación del docente participante. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','ID ESP. ACAD. DOCENTE PARTICIPANTE 3','Indique el ID del Espacio Académico asociado al docente participante de la práctica académica de campo. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','NUM. IDENT. DOCENTE PARTICIPANTE 4','Número de identificación del docente participante. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','ID ESP. ACAD. DOCENTE PARTICIPANTE 4','Indique el ID del Espacio Académico asociado al docente participante de la práctica académica de campo. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','NUM. IDENT. DOCENTE PARTICIPANTE 5','Número de identificación del docente participante. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','ID ESP. ACAD. DOCENTE PARTICIPANTE 5','Indique el ID del Espacio Académico asociado al docente participante de la práctica académica de campo. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','NUM. IDENT. DOCENTE PARTICIPANTE 6','Número de identificación del docente participante. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','ID ESP. ACAD. DOCENTE PARTICIPANTE 6','Indique el ID del Espacio Académico asociado al docente participante de la práctica académica de campo. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','NUM. IDENT. DOCENTE PARTICIPANTE 7','Número de identificación del docente participante. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','ID ESP. ACAD. DOCENTE PARTICIPANTE7','Indique el ID del Espacio Académico asociado al docente participante de la práctica académica de campo. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números'],
            ['','TIPO RUTA','Indique el tipo de ruta que va a seleccionar para la práctica académica de campo. Deje la celda en blanco en caso de NO requerir docentes participantes','Solo números [1:Principal - 2:Contingencia]'],
            // ['','DESTINO RUTA','Nombre referente al destino de la práctica académica de campo','Solo texto'],
            // ['','CANT. URL RUTA','Cantidad de URL que requiere para trazar el recorrido de la práctica académica de campo','Solo números entre [1 - 6]'],
            // ['','URL 1 RUTA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            // ['','URL 2 RUTA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            // ['','URL 3 RUTA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            // ['','URL 4 RUTA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            // ['','URL 5 RUTA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            // ['','URL 6 RUTA','URL copiada de Google Maps','Debe iniciar con el formato: https://www.google.com.co/maps/dir/'],
            ['','DETALLE DEL RECORRIDO INTERNO','Indicar el detalle del recorrido que se realizará en la práctica académica de campo. Ej. Sitios, veredas, '. 
            'municipios que se van a visitar. PD: No parametrizar por días',''],
            ['','ID SEDE SALIDA','Indique el ID de la Sede Universidad que corresponda','Solo números'],
            ['','ID SEDE REGRESO','Indique el ID de la Sede Universidad que corresponda','Solo números'],
            ['','SALIDA (FECHA CONFIRMADA)','Indique la fecha de salida de la práctica académica de campo','Formato TEXTO aaaa-mm-dd'],
            ['','HORA SALIDA','Indique la hora de salida de la sede de partida. Ej. 5:45 AM','Formato h:mm AM/PM'],
            ['','REGRESO (FECHA CONFIRMADA)','Indique la fecha de regreso de la práctica académica de campo','Formato TEXTO aaaa-mm-dd'],
            ['','HORA REGRESO','Indique la hora en la que iniciará el retorno hacia la sede de retorno. Tener en cuenta que la hora aproximada de llegar a la ciudad de Bogotá D.C  DEBE'.
            ' ser a más tardar las 9:00 PM. Ej. El viaje de regreso dura 3hrs, la hora de regreso DEBE ser antes de las 6:00 PM','Formato h:mm AM/PM'],
            // ['','CANT. VEHÍCULOS','Cantidad de vehículos requeridos para la práctica académica de campo','Solo números entre [0 - 3]'],
            // ['','ID TIPO VEHÍCULO 1','Indique el ID del Tipo de Vehículo que corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            // ['','CAPAC. VEHÍCULO 1','Cantidad de personas que irán en el vehiculo. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','DET. VEHÍCULO','Información relacionada a especificaciones requeridas sobre el/los vehículo(s). Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            ['','DISP. PERMANENTE VEHÍCULO','Indique si requiere que el/los vehículo(s) esté(n) todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            // ['','ID TIPO VEHÍCULO 2','Indique el ID del Tipo de Vehículo que corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            // ['','CAPAC. VEHÍCULO 2','Cantidad de personas que irán en el vehiculo. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            // ['','DET. VEHÍCULO 2','Información relacionada a especificaciones requeridas sobre el vehículo. Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            // ['','DISP. PERMANENTE VEHÍCULO 2','Indique si requiere que el vehículo este todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            // ['','ID TIPO VEHÍCULO 3','Indique el ID del Tipo de Vehículo que corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            // ['','CAPAC. VEHÍCULO 3','Cantidad de personas que irán en el vehiculo. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            // ['','DET. VEHÍCULO 3','Información relacionada a especificaciones requeridas sobre el vehículo. Ej. Maleteros amplios para equipos, aire acondicionado, etc. Deje la celda en blanco en caso de NO requerir vehículo',''],
            // ['','DISP. PERMANENTE VEHÍCULO 3','Indique si requiere que el vehículo este todo el tiempo con los asistentes. Deje la celda en blanco en caso de NO requerir vehículo','Solo números [0:NO - 1:SI]'],
            ['','CANT. TRANSPORTE MENOR','Cantidad de vehículos asociados a transporte menor/local requeridos para la práctica académica de campo','Solo números entre [0 - 4]'],
            ['','TRANSPORTE MENOR 1','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 1','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 2','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 2','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 3','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 3','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','TRANSPORTE MENOR 4','Nombre del vehículo requerido. Ej. Chiva, Lancha, etc. Deje la celda en blanco en caso de NO requerir vehículo','Solo texto, Mayúscula cada palabra'],
            ['','VLR. TRANSPORTE MENOR 4','Valor total del transporte, se DEBE incluir ida y regreso según corresponda. Deje la celda en blanco en caso de NO requerir vehículo','Solo números'],
            ['','MATERIALES','Indique el nombre de los materiales requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir materiales',''],
            ['','VLR. TOTAL MATERIALES','Valor total de los materiales. Deje la celda en blanco en caso de NO requerir materiales','Solo números'],
            ['','GUÍAS/BAQUIANOS','Indique el nombre de los guías/baquianos requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir guías/baquianos',''],
            ['','VLR. TOTAL GUÍAS/BAQUIANOS','Valor total de los guías/baquianos. Deje la celda en blanco en caso de NO requerir guías/baquianos','Solo números'],
            ['','BOLETAS/OTROS','Indique el nombre de las boletas/otros requeridos en la práctica académica de campo. Deje la celda en blanco en caso de NO requerir boletas/otros',''],
            ['','VLR. TOTAL BOLETAS/OTROS','Valor total de las boletas/otros. Deje la celda en blanco en caso de NO requerir boletas/otros','Solo números'],
            ['','ÁREAS ACUÁTICAS','Indique si la práctica académica de campo desarrolla maniobras  sobre áreas acuáticas(Ríos, lagos, lagunas, humedales, mares, etc). De ser afirmativa, DEBE tener un plan de contingencia basado en la matriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','ALTURAS','Indique si la práctica académica de campo desarrolla actividades de escalada o trabajo de alturas. De ser afirmativa, DEBE tener un plan de contingencia basado en la matriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','RIESGO BIOLÓGICO','Indique si la práctica académica de campo desarrolla actividades al interior de bosques o lugares con riesgo biológico. De ser afirmativa, DEBE tener un plan de contingencia basado en la matriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','ESPACIOS CONFINADOS','Indique si la práctica académica de campo desarrolla actividades en espacios confinados. De ser afirmativa, DEBE tener un plan de contingencia basado en la matriz de riesgos','Solo números [0:NO - 1:SI]'],
            ['','CRONOGRAMA RECORRIDO','Información detalla del cronograma del recorrido','Máx: 32.000 caracteres'],
            ['','OBS. PRÁCTICA','Observaciones relacionadas con la práctica académica de campo','Máx: 32.000 caracteres'],
            ['','JUST. PRÁCTICA','Información detallada de la justificación de la práctica académica de campo','Máx: 32.000 caracteres'],
            ['','OBJ. GRAL. PRÁCTICA','Información detallada del objetivo general de la práctica académica de campo','Máx: 32.000 caracteres'],
            ['','MET. TRABAJO - EVAL. PRÁCTICA','Información detallada de la metodología de trabajo y la evaluación de la práctica académica de campo','Máx: 32.000 caracteres'],
            ['','VAC. FIEBRE AMARILLA','Indique si requiere este certificado','Solo números [0:NO - 1:SI]'],
            ['','VAC. TÉTANOS','Indique si requiere este certificado','Solo números [0:NO - 1:SI]'],
            ['','CERTIFICADO ADICIONAL 1','Indique si requiere este certificado','Solo números [0:NO - 1:SI]'],
            ['','DET. CERT. ADICIONAL 1','Nombre del certificado. Deje la celda en blanco en caso de NO requerir certificado adicional','Máx: 50 caracteres'],
            ['','CERTIFICADO ADICIONAL 2','Indique si requiere este certificado','Solo números [0:NO - 1:SI]'],
            ['','DET. CERT. ADICIONAL 2','Nombre del certificado. Deje la celda en blanco en caso de NO requerir certificado adicional','Máx: 50 caracteres'],
            ['','CERTIFICADO ADICIONAL 3','Indique si requiere este certificado','Solo números [0:NO - 1:SI]'],
            ['','DET. CERT. ADICIONAL 3','Nombre del certificado. Deje la celda en blanco en caso de NO requerir certificado adicional','Máx: 50 caracteres'],
            
        ]);

    }

    // public function headings():array
    // {
    //     return[
    //         'INSTRUCTIVO PARA DILIGENCIAR FORMATO DE SOLICITUDES PRÁCTICA', 
            
    //     ];
    // }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'B2:D2';
                $cellRange2 ='B7:D7'; 
                $cellRange3 ='B8:B81'; 
                $cellRange4 ='C8:C81'; 
                $cellRange5 ='D8:D81'; 
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
