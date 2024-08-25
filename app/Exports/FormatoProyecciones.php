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

class FormatoProyecciones implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;
    public function __construct()
    {
     
    }

    public function collection()
    {
        return collect([
            ["(Hoja Programas Académicos)", "(Hoja Espacios Académicos)", "(Hoja Espacios Académicos)",
            '(Año del período formato aaaa)','(Hoja Períodos Académicos)','(Solo números)',
            '(Mayúscula cada palabra)','(Solo números)','(Solo números)',
            '(Solo números)','(Solo números)','(Solo números)',
            '(Solo números)','(Solo números)','(Solo números)','(Mayúscula cada palabra)',
            '(Mayúscula cada palabra)','(Mayúscula cada palabra)','(Mayúscula cada palabra)',
            '(Mayúscula cada palabra)','(Mayúscula cada palabra)','(Mayúscula cada palabra)',
            '(Mayúscula cada palabra)','(Mayúscula cada palabra)','(Mayúscula cada palabra)',
            '(Mayúscula cada palabra)','(Solo números)','(URL google maps)',
            '(URL google maps)','(URL google maps)','(URL google maps)',
            '(URL google maps)','(URL google maps)','(Detallar el recorrido)',
            '(Hoja Sedes Universidad)','(Hoja Sedes Universidad)','(Formato TEXTO aaaa-mm-dd)',
            '(Formato TEXTO aaaa-mm-dd)','(Solo números)','(Hoja Tipos Vehículos)',
            '(Solo números)','(Mayúscula inicial)','(Para SI indicar 1 o para NO indicar 0)',
            '(Hoja Tipos Vehículos)','(Solo números)','(Mayúscula inicial)',
            '(Para SI indicar 1 o para NO indicar 0)','(Hoja Tipos Vehículos)','(Solo números)',
            '(Mayúscula inicial)','(Para SI indicar 1 o para NO indicar 0)','(Solo números)',
            '(Mayúscula inicial)','(Mayúscula inicial)',
            '(Solo números)','(Solo números)','(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)','(Mayúscula inicial)',
            '(Solo números)','(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)','(Para SI indicar 1 o para NO indicar 0)',
            '(Para SI indicar 1 o para NO indicar 0)','(Para SI indicar 1 o para NO indicar 0)','(Para SI indicar 1 o para NO indicar 0)',
            '(Mayúscula Inicial)','(Solo Números)','(URL google maps)',
            '(URL google maps)','(URL google maps)','(URL google maps)',
            '(URL google maps)','(URL google maps)','(Detallar el recorrido)',
            '(Hoja Sedes Universidad)','(Hoja Sedes Universidad)','(Formato TEXTO aaaa-mm-dd)',
            '(Formato TEXTO aaaa-mm-dd)','(Solo números)','(Hoja Tipos Vehículos)',
            '(Solo números)','(Mayúscula inicial)','(Para SI indicar 1 o para NO indicar 0)',
            '(Hoja Tipos Vehículos)','(Solo números)','(Mayúscula inicial)',
            '(Para SI indicar 1 o para NO indicar 0)','(Hoja Tipos Vehículos)','(Solo números)',
            '(Mayúscula inicial)','(Para SI indicar 1 o para NO indicar 0)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)','(Mayúscula inicial)',
            '(Solo números)','(Mayúscula inicial)','(Solo númerosC)',
            '(Mayúscula inicial)','(Solo números)','(Mayúscula inicial)',
            '(Solo números)','(Mayúscula inicial)','(Solo números)',
            '(Mayúscula inicial)','(Solo números)','(Para SI indicar 1 o para NO indicar 0)',
            '(Para SI indicar 1 o para NO indicar 0)','(Para SI indicar 1 o para NO indicar 0)','(Para SI indicar 1 o para NO indicar 0)']
        ]);

    }

    public function headings():array
    {
        return[
            'ID PROGRAMA ACADÉMICO', 
            'ID ESPACIO ACADÉMICO',
            'SEM. ASIG',
            'AÑO PER.',
            'PER. ACA',
            'NUM. IDENT. DOCENTE',
            'DOCENTE RESPONSABLE',
            'CANT. GRUPOS',
            'GRUPO 1',
            'GRUPO 2',
            'GRUPO 3',
            'GRUPO 4',
            'NÚMERO DE ESTUDIANTES',
            'NÚMERO PERSONAS APOYO',
            'TOTAL DOCENTES APOYO',
            'PERSONAL APOYO 1',
            'PERSONAL APOYO 2',
            'PERSONAL APOYO 3',
            'PERSONAL APOYO 4',
            'PERSONAL APOYO 5',
            'PERSONAL APOYO 6',
            'PERSONAL APOYO 7',
            'PERSONAL APOYO 8',
            'PERSONAL APOYO 9',
            'PERSONAL APOYO 10',
            'DESTINO RUTA PRINCIPAL',
            'CANT. URL RUTA PRINCIPAL',
            'URL 1 RUTA PRINCIPAL',
            'URL 2 RUTA PRINCIPAL',
            'URL 3 RUTA PRINCIPAL',
            'URL 4 RUTA PRINCIPAL',
            'URL 5 RUTA PRINCIPAL',
            'URL 6 RUTA PRINCIPAL',
            'DETALLE DEL RECORRIDO INTERNO RP',
            'ID SEDE SALIDA RP',
            'ID SEDE REGRESO RP',
            'SALIDA (FECHA TENTATIVA) RP',
            'REGRESO (FECHA TENTATIVA) RP',
            'CANT. VEHÍCULOS RP',
            'ID TIPO VEHÍCULO 1 RP',
            'CAPAC. VEHÍCULO 1 RP',
            'DET. VEHÍCULO 1 RP',
            'DISP. PERMANENTE VEHÍCULO 1 RP',
            'ID TIPO VEHÍCULO 2 RP',
            'CAPAC. VEHÍCULO 2 RP',
            'DET. VEHÍCULO 2 RP',
            'DISP. PERMANENTE VEHÍCULO 2 RP',
            'ID TIPO VEHÍCULO 3 RP',
            'CAPAC. VEHÍCULO 3 RP',
            'DET. VEHÍCULO 3 RP',
            'DISP. PERMANENTE VEHÍCULO 3 RP',
            'CANT. TRANSPORTE MENOR RP',
            'TRANSPORTE MENOR 1 RP',
            'VLR. TRANSPORTE MENOR 1 RP',
            'TRANSPORTE MENOR 2 RP',
            'VLR. TRANSPORTE MENOR 2 RP',
            'TRANSPORTE MENOR 3 RP',
            'VLR. TRANSPORTE MENOR 3 RP',
            'TRANSPORTE MENOR 4 RP',
            'VLR. TRANSPORTE MENOR 4 RP',
            'MATERIALES RP',
            'VLR. TOTAL MATERIALES RP',
            'GUÍAS/BAQUIANOS RP',
            'VLR. TOTAL GUÍAS/BAQUIANOS RP',
            'BOLETAS/OTROS RP',
            'VLR. TOTAL BOLETAS/OTROS RP',
            'ÁREAS ACUÁTICAS RP',
            'ALTURAS RP',
            'RIESGO BIOLÓGICO RP',
            'ESPACIOS CONFINADOS RP',
            'DESTINO RUTA CONTINGENCIA',
            'CANT. URL RUTA CONTINGENCIA',
            'URL 1 RUTA CONTINGENCIA',
            'URL 2 RUTA CONTINGENCIA',
            'URL 3 RUTA CONTINGENCIA',
            'URL 4 RUTA CONTINGENCIA',
            'URL 5 RUTA CONTINGENCIA',
            'URL 6 RUTA CONTINGENCIA',
            'DETALLE DEL RECORRIDO INTERNO RC',
            'ID SEDE SALIDA RC',
            'ID SEDE REGRESO RC',
            'SALIDA (FECHA TENTATIVA) RC',
            'REGRESO (FECHA TENTATIVA) RC',
            'CANT. VEHÍCULOS RC',
            'ID TIPO VEHÍCULO 1 RC',
            'CAPAC. VEHÍCULO 1 RC',
            'DET. VEHÍCULO 1 RC',
            'DISP. PERMANENTE VEHÍCULO 1 RC',
            'ID TIPO VEHÍCULO 2 RC',
            'CAPAC. VEHÍCULO 2 RC',
            'DET. VEHÍCULO 2 RC',
            'DISP. PERMANENTE VEHÍCULO 2 RC',
            'ID TIPO VEHÍCULO 3 RC',
            'CAPAC. VEHÍCULO 3 RC',
            'DET. VEHÍCULO 3 RC',
            'DISP. PERMANENTE VEHÍCULO 3 RC',
            'CANT. TRANSPORTE MENOR RC',
            'TRANSPORTE MENOR 1 RC',
            'VLR. TRANSPORTE MENOR 1 RC',
            'TRANSPORTE MENOR 2 RC',
            'VLR. TRANSPORTE MENOR 2 RC',
            'TRANSPORTE MENOR 3 RC',
            'VLR. TRANSPORTE MENOR 3 RC',
            'TRANSPORTE MENOR 4 RC',
            'VLR. TRANSPORTE MENOR 4 RC',
            'MATERIALES RC',
            'VLR. TOTAL MATERIALES RC',
            'GUÍAS/BAQUIANOS RC',
            'VLR. TOTAL GUÍAS/BAQUIANOS RC',
            'BOLETAS/OTROS RC',
            'VLR. TOTAL BOLETAS/OTROS RC',
            'ÁREAS ACUÁTICAS RC',
            'ALTURAS RC',
            'RIESGO BIOLÓGICO RC',
            'ESPACIOS CONFINADOS RC',
        ];
    }

    public function registerEvents():array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:DK1';
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
        $titleSheet = "proyecciones";
        return $titleSheet;
    }
}
