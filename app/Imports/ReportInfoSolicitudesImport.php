<?php

namespace PractiCampoUD\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportInfoSolicitudesImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new InfoSolicitudesImport()
        ];
    }
}
