<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PractiCampoUD\proyeccion;
use PractiCampoUD\solicitud;
use PractiCampoUD\User;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;

class SistemaControllerTest extends TestCase
{
    /**
     * Prueba unitaria del método index del controlador SistemaController
     */
    public function test_sistema_index(): void{
        $user = User::find(79308666);
        $this->actingAs($user);
        $response = $this->get("sistema");
        $response->assertStatus(200);
        $response->assertViewIs('sistema.edit'); 
    }

    /**
     * Prueba unitaria del método update del controlador SistemaController
     */
    public function test_sistema_update(): void{
        $user = User::find(79308666);
        $this->actingAs($user);
        $data = [
            'fecha_apert_proy' => '2024-08-01',
            'fecha_cierre_proy' => '2024-08-01',
            'fecha_apert_solic' => '2024-09-01',
            'fecha_cierre_solic' => '2024-10-31',
            'vlr_docen_min' => 10000,
            'vlr_docen_max' => 20000,
            'vlr_estud_min' => 30000,
            'vlr_estud_max' => 40000,

        ];
        $response = $this->put("sistema", $data);

        $response->assertStatus(200);
        $response->assertViewIs('home2'); 
    }
}