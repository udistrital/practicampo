<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use DB;

class ReportSolicitudesExport implements WithMultipleSheets
{

    public function __construct($id_solicitud)
    {
        $this->id_solicitud = $id_solicitud;
    }

    public function sheets(): array
    {
        $sheets = [];

         $sheets[] = new SolicitudesPracticasExport($this->id_solicitud);
         $sheets[] = new SolicitudesIntegradasExport($this->id_solicitud);

        return $sheets;
    }
}