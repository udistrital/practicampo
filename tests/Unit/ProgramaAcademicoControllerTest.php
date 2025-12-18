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

class ProgramaAcademicoControllerTest extends TestCase
{
    /**
     * Prueba unitaria del método index del controlador ProgramaAcademicoController
     */
    public function test_programa_index(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $response = $this->get("programas_academicos");
        $response->assertStatus(200);
        $response->assertViewIs('programa_academico.edit'); 
    }

    /**
     * Prueba unitaria del método create del controlador ProgramaAcademicoController
     */
    public function test_programa_create(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $data = [
            'id_programa_academico' => 900,
            'nombre_programa_academico' => 'prueba_programa',
            'pregrado' => 1,
        ];
        $response = $this->post("programas_academicos/create", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método update del controlador ProgramaAcademicoController
     */
    public function test_programa_update(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $id = 1;
        $data = [
            'nombre_programa_academico' => 'prueba_programa_update',
            'pregrado' => 0,
        ];
        $response = $this->put("programas_academicos/update/{$id}", $data);

        $response->assertStatus(302);
    }
}