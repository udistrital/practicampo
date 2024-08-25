<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportFormatoUsers implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

         $sheets[] = new FormatoUsersExport();
         $sheets[] = new TiposIdentificacionesExport();
         $sheets[] = new RolExport();
         $sheets[] = new EstadoExport();
         $sheets[] = new ProgramasAcademicosExport();
         $sheets[] = new EspaciosAcademicosExport();
         $sheets[] = new TiposVinculacionesExport();

        return $sheets;
    }
}
