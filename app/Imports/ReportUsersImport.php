<?php

namespace PractiCampoUD\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportUsersImport implements WithMultipleSheets
{
    
    public function sheets(): array
    {
        return [
            new UsersImport()
        ];
    }
}