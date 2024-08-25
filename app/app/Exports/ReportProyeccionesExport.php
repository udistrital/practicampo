<?php

namespace PractiCampoUD\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use DB;

class ReportProyeccionesExport implements WithMultipleSheets
{

    public function __construct($id)
    {
        $this->id_proyeccion = $id;
    }

    public function sheets(): array
    {
        $sheets = [];

         $sheets[] = new ProyeccionesPreliminaresExport($this->id_proyeccion);
         $sheets[] = new ProyeccionesContingenciaExport($this->id_proyeccion);
         $sheets[] = new ProyeccionesIntegradasExport($this->id_proyeccion);

        return $sheets;
    }
}