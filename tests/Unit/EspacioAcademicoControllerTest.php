<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PractiCampoUD\presupuesto;
use PractiCampoUD\solicitud;
use PractiCampoUD\User;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;

class EspacioAcademicoControllerTest extends TestCase
{
    /**
     * Prueba unitaria del método index del controlador EspacioAcademicoController
     */
    public function test_espacio_index(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $response = $this->get("espacios_academicos");
        $response->assertStatus(200);
        $response->assertViewIs('espacio_academico.edit'); 
    }

    /**
     * Prueba unitaria del método create del controlador EspacioAcademicoController
     */
    public function test_espacio_create(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $data = [
            'id_programa_academico' => 900,
            'codigo_espacio_academico' => 9000,
            'nombre_espacio_academico' => 'espacio_prueba',
            'plan_estudios_1' => '1',
            'plan_estudios_2' => '2',
            'tipo_espacio' => 'T/P',
            'electiva' => 0,
        ];
        $response = $this->post("espacios_academicos/create", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método update del controlador EspacioAcademicoController
     */
    public function test_espacio_update(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $id = 231;
        $data = [
            'id_programa_academico' => 1,
            'codigo_espacio_academico' => 9000,
            'nombre_espacio_academico' => 'espacio_prueba_update',
            'plan_estudios_1' => '11',
            'plan_estudios_2' => '22',
            'tipo_espacio' => 'T/P',
            'electiva' => 1,
        ];
        $response = $this->put("espacios_academicos/update/{$id}", $data);

        $response->assertStatus(302);
    }
}