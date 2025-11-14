<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use DB;

class ReportprogramacionesExport implements WithMultipleSheets
{

    public function __construct($id)
    {
        $this->id_programacion = $id;
    }

    public function sheets(): array
    {
        $sheets = [];

         $sheets[] = new programacionesPreliminaresExport($this->id_programacion);
         $sheets[] = new programacionesContingenciaExport($this->id_programacion);
         $sheets[] = new programacionesIntegradasExport($this->id_programacion);

        return $sheets;
    }
}