<?php

namespace PractiCampoUD\Imports;

use PractiCampoUD\estudiantes_practica;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PractiCampoUD\estudiante;

class EstudiantesImport implements ToModel, WithHeadingRow, WithMultipleSheets, SkipsEmptyRows
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
        $email = strtolower(trim($row['correo_institucional']));

        if (empty($email)) {
            throw new \Exception("El correo institucional está vacío en una fila del archivo.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("El correo '$email' no es un correo válido.");
        }
        if (!str_ends_with($email, '@udistrital.edu.co')) {
            throw new \Exception("El correo '$email' no pertenece al dominio @udistrital.edu.co.");
        }

        $estudiante = Estudiante::firstOrCreate(['email' => $email],
            [
                'num_identificacion' => null,
                'codigo_estudiante' => $row['codigo'],
                'password' => Hash::make($row['codigo']),
                'nombre_completo'=> $row['nombre_completo'],
                'fecha_nacimiento' => null,
                'celular' => null,
                'eps' => null,
            ]
        );

        return new estudiantes_practica([
            'id_tipo_identificacion' => 1,
            'id_solicitud_practica' => $this->id_solicitud,
            'email' => $email,
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
