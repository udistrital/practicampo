<?php

namespace PractiCampoUD\Imports;

use PractiCampoUD\estudiantes_practica;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Hash;

class EstudiantesImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    public function __construct($id_solicitud)
    {
        $this->id_solicitud = $id_solicitud;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $tipo_identificacion = 1;
        return new estudiantes_practica([
            'id_solicitud_practica' => $this->id_solicitud,
            'id_tipo_identificacion' => $tipo_identificacion,
            'password' => Hash::make($row['codigo']),
            'nombre_completo'=> $row['nombre'],
            'email' => $row['correo_institucional'],
            'grupo'=>$row['grupo'],
        ]);
    }

    public function sheets(): array
    {
        return [
            'Estudiantes' => $this
        ];
    }
}
