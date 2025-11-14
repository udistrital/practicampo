<?php

namespace PractiCampoUD\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportprogramacionesImport implements WithMultipleSheets
{
    
    // public function sheets(): array
    // {
    //     return [
    //         'programaciones' => $this
    //     ];
    // }

    public function sheets(): array
    {
        return [
            new programacionesPreliminaresImport()
        ];
    }
}