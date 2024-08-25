<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportFormatoProyecciones implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

         $sheets[] = new FormatoProyecciones();
         $sheets[] = new InstructivoProyeccionesExport();
         $sheets[] = new ProgramasAcademicosExport();
         $sheets[] = new EspaciosAcademicosExport();
         $sheets[] = new SemestreAsignaturaExport();
         $sheets[] = new PeriodoAcademicoExport();
         $sheets[] = new SedesUniversidadExport();
         $sheets[] = new TipoVehiculosExport();
         $sheets[] = new TiposPersonalApoyoExport();

        return $sheets;
    }
}
