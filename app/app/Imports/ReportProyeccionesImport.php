<?php

namespace PractiCampoUD\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportProyeccionesImport implements WithMultipleSheets
{
    
    // public function sheets(): array
    // {
    //     return [
    //         'Proyecciones' => $this
    //     ];
    // }

    public function sheets(): array
    {
        return [
            new ProyeccionesPreliminaresImport()
        ];
    }
}