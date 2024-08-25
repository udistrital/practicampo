<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportEncuestaExport implements WithMultipleSheets
{
    public function __construct($id)
    {
        $this->id_solicitud = $id;
    }

    public function sheets(): array
    {
        $sheets = [];

         $sheets[] = new EncuestaTransportadorExport($this->id_solicitud);
         
        return $sheets;
    }
}
