<?php

namespace PractiCampoUD\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportEstudiantesImport implements WithMultipleSheets
{
    
    public function sheets(): array
    {
        return [
            'Estudiantes' => $this
        ];
    }
}