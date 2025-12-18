<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PractiCampoUD\programacion;
use PractiCampoUD\solicitud;
use PractiCampoUD\User;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use PractiCampoUD\Exports\ReportSolicitudesAprobadasExport;
use PractiCampoUD\Exports\ReportSolicitudesRealizadasExport;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

use DB;

class ExcelControllerTest extends TestCase
{
    /**
     * Prueba unitaria del método exportExcel del controlador ExcelController
     */
    public function test_excel_exportExcel()
    {
        $response = $this->get("exp-users-list-excel");

        $response->assertStatus(302);
    }

    /**
     * Prueba unitaria del método exportprogramacionesExcel del controlador ExcelController
     */
    public function test_excel_exportprogramacionesExcel()
    {
        $data = [
            'programacion_list' => [974,1118,1119,1120],
        ];
        $response = $this->get("exp-proyecc-list-excel", $data);

        $response->assertStatus(302);
    }

    /**
     * Prueba unitaria del método exportFormatoUsers del controlador ExcelController
     */
    public function test_excel_exportFormatoUsers()
    {
        $response = $this->get("exp_formato_users");

        $response->assertStatus(302);
    }

    /**
     * Prueba unitaria del método exportFormatoProy del controlador ExcelController
     */
    public function test_excel_exportFormatoProy()
    {
        $response = $this->get("exp_formato_proy");

        $response->assertStatus(302);
    }

    /**
     * Prueba unitaria del método exportFormatoEstud del controlador ExcelController
     */
    public function test_excel_exportFormatoEstud()
    {
        $response = $this->get("exp_formato_estud");

        $response->assertStatus(302);
    }

    /**
     * Prueba unitaria del método importEstudiantesExcel del controlador ExcelController
     */
    public function test_excel_importEstudiantesExcel()
    {
        $user = User::find(79794356);
        $this->actingAs($user);
        $pathToFile = 'E:\xampp\htdocs\practicampo\excel\listado_estudiantes.xlsx';
        $file = new UploadedFile(
            $pathToFile,
            'listado_estudiantes.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true 
        );
        $id = 621;
        $response = $this->post(route('import_list_estud.excel', ['id' => $id]), [
            'listado_estudiantes' => $file,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect("solicitudes/filtrar/proy-comp");
    }

    /**
     * Prueba unitaria del método excel_solicitudes_edit del controlador ExcelController
     */
    public function test_excel_solicitudes_edit(): void{
        $user = User::find(79308666);
        $this->actingAs($user);
        $response = $this->get("excel_solicitudes");

        $response->assertStatus(200);
        $response->assertViewIs('excel.edit'); 
    }

    /**
     * Prueba unitaria del método excel_solicitudes_realizadas del controlador ExcelController
     */
    public function test_excel_solicitudes_aprobadas_transporte()
    {
        $data = [
            'fecha_inicial' => '2024-08-01',
            'fecha_final' => '2024-12-31',
        ];
        $response = $this->get("excel_solicitudes_aprobadas_transporte", $data);

        $response->assertStatus(302);
    }

    /**
     * Prueba unitaria del método excel_solicitudes_aprobadas_transporte del controlador ExcelController
     */
    public function test_excel_solicitudes_realizadas()
    {
        $data = [
            'fecha_inicial' => '2024-10-01',
            'fecha_final' => '2024-12-31',
        ];
        $response = $this->get("excel_solicitudes_realizadas", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método excel_programaciones_plan_salidas del controlador ExcelController
     */
    public function test_excel_programaciones_plan_salidas()
    {
        $data = [
            'fecha_inicial' => '2025-01-01',
            'fecha_final' => '2025-12-31',
        ];
        $response = $this->get("excel_programaciones_plan_salidas", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método excel_programaciones_aprobadas_coord del controlador ExcelController
     */
    public function test_excel_programaciones_aprobadas_coord()
    {
        $data = [
            'anio' => 2025,
            'periodo' => 1,
        ];
        $response = $this->get("excel_programaciones_aprobadas_coord", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método excel_programaciones_aprobadas_cons_fac del controlador ExcelController
     */
    public function test_excel_programaciones_aprobadas_cons_fac()
    {
        $data = [
            'anio' => 2025,
            'periodo' => 1,
        ];
        $response = $this->get("excel_programaciones_aprobadas_cons_fac", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método excel_solicitudes_aprobadas_coord del controlador ExcelController
     */
    public function test_excel_solicitudes_aprobadas_coord()
    {
        $data = [
            'anio' => 2025,
            'periodo' => 1,
        ];
        $response = $this->get("excel_solicitudes_aprobadas_coord", $data);

        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método excel_historico_presupuestos del controlador ExcelController
     */
    public function test_excel_historico_presupuestos()
    {
        $data = [
            'fecha_inicial' => '2025-01-01',
            'fecha_final' => '2025-12-31',
        ];
        $response = $this->get("excel_historico_presupuestos", $data);

        $response->assertStatus(302);
    }
}