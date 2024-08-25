<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportFormatoEstudiantes implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

         $sheets[] = new FormatoEstudiantesExport();
         $sheets[] = new InstructivoFormatoEstudiantes();

        return $sheets;
    }
}
