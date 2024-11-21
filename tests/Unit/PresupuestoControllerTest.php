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
        $user = User::find(79308666);
        $this->actingAs($user);
        $response = $this->get("presupuesto");
        $response->assertStatus(200);
        $response->assertViewIs('presupuesto.edit'); 
    }

    /**
     * Prueba unitaria del método update del controlador PresupuestoController
     */
    public function test_presupuesto_update(): void{
        $user = User::find(79308666);
        $this->actingAs($user);
        $data = [
            '1' => 1000,
            '10' => 2000,
            '13' => 3000,
            '14' => 4000,
            '21' => 5000,
            '32' => 6000,
            '81' => 7000,
            '85' => 8000,
            '110' => 9000,
            '114' => 10000,
            '131' => 11000,
            '180' => 12000,
            '181' => 13000,
            '185' => 14000,
            '200' => 15000,

        ];
        $response = $this->put("presupuesto", $data);

        $response->assertStatus(200);
        $response->assertViewIs('home2'); 
    }

}