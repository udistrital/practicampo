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

class PresupuestoControllerTest extends TestCase
{
    /**
     * Prueba unitaria del método index del controlador PresupuestoController
     */
    public function test_presupuesto_index(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $response = $this->get("presupuesto");
        $response->assertStatus(200);
        $response->assertViewIs('presupuesto.edit'); 
    }

    /**
     * Prueba unitaria del método update del controlador PresupuestoController
     */
    public function test_presupuesto_update(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $id = 1;
        $data = [
            'nuevo_presupuesto_programa_academico' => 100000,
        ];
        $response = $this->put("presupuesto/update/{$id}", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método sum del controlador PresupuestoController
     */
    public function test_presupuesto_sum(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $id = 1;
        $data = [
            'sumar_presupuesto_programa_academico' => 150000,
        ];
        $response = $this->put("presupuesto/sum/{$id}", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método update_tm del controlador PresupuestoController
     */
    public function test_presupuesto_update_tm(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $data = [
            'nuevo_presupuesto_transporte_menor' => 100000,
        ];
        $response = $this->put("presupuesto_tm/update", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método sum_tm del controlador PresupuestoController
     */
    public function test_presupuesto_sum_tm(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $id = 3;
        $data = [
            'sumar_presupuesto_transporte_menor' => 999999,
        ];
        $response = $this->put("presupuesto_tm/sum/{$id}", $data);

        $response->assertStatus(302);
    }
}