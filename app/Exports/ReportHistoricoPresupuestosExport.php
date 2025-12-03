<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportHistoricoPresupuestosExport implements WithMultipleSheets
{
    protected $fecha_inicial;
    protected $fecha_final;

    public function __construct($fecha_inicial, $fecha_final)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
    }

    public function sheets(): array
    {
        $sheets = [];

         $sheets[] = new HistoricoPresupuestosExport($this->fecha_inicial,$this->fecha_final);
         
        return $sheets;
    }
}
