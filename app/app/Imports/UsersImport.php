<?php

namespace PractiCampoUD\Imports;

use PractiCampoUD\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $identificacion = $row['identificacion'];
        return new User([
            'id' => $row['identificacion'],
            'id_tipo_identificacion' => $row['id_ti'],
            'expedicion_identificacion'=>$row['exp_identificacion'],
            'usuario' => $row['usuario'],
            'primer_nombre'=> $row['1er_nombre'],
            'segundo_nombre'=> $row['2do_nombre'],
            'primer_apellido'=> $row['1er_apellido'],
            'segundo_apellido'=> $row['2do_apellido'],
            'email' => $row['email'],
            // 'password'  =>  '12345678',
            'password'  =>  Hash::make($identificacion),
            'id_role' => $row['id_rol'],
            'id_programa_academico_coord' => $row['id_prog_acade_coord'],
            'id_tipo_vinculacion' => $row['id_vinculacion'],
            'cant_espacio_academico' => $row['cant_esp_acad'],
            'id_espacio_academico_1' => $row['id_esp_acad_1'],
            'id_espacio_academico_2' => $row['id_esp_acad_2'],
            'id_espacio_academico_3' => $row['id_esp_acad_3'],
            'id_espacio_academico_4' => $row['id_esp_acad_4'],
            'id_espacio_academico_5' => $row['id_esp_acad_5'],
            'id_espacio_academico_6' => $row['id_esp_acad_6'],
            'telefono' => $row['telefono'],
            'celular' => $row['celular'],
            'id_estado' => '1',
        ]);
    }

    // public function sheets(): array
    // {
    //     return [
    //         'Usuarios' => $this
    //     ];
    // }


}
