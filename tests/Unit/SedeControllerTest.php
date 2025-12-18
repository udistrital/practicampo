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

class SedeControllerTest extends TestCase
{
    /**
     * Prueba unitaria del método index del controlador SedeController
     */
    public function test_sede_index(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $response = $this->get("sedes");
        $response->assertStatus(200);
        $response->assertViewIs('sede.edit'); 
    }

    /**
     * Prueba unitaria del método create del controlador SedeController
     */
    public function test_sede_create(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $data = [
            'sede' => 'sede_prueba',
            'direccion' => 'direccion_prueba',
        ];
        $response = $this->post("sedes/create", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método update del controlador SedeController
     */
    public function test_sede_update(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $id = 7;
        $data = [
            'sede' => 'sede_prueba_update',
            'direccion' => 'direccion_prueba_update',
        ];
        $response = $this->put("sedes/update/{$id}", $data);

        $response->assertStatus(302);
    }
}