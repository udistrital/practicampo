<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PractiCampoUD\programacion;
use PractiCampoUD\User;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use PractiCampoUD\estudiante;

class PdfControllerTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * Prueba unitaria de ejemplo
     */
    public function test(): void{
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Prueba unitaria del método exportResolucionPdf del controlador PdfController
     */
    public function test_pdf_exportResolucionPdf(): void{
        $user = User::find(79494815);
        $this->actingAs($user);
        $ids = '546,547';
        $response = $this->get("resolucionpdf/{$ids}");
        $response->assertStatus(200);
        $response->assertDownload();
    }

    /**
     * Prueba unitaria del método exportFormatoPracticaPdf del controlador PdfController
     */
    public function test_pdf_exportFormatoPracticaPdf(): void{
        $user = User::find(79494815);
        $this->actingAs($user);
        $ids = '547';
        $response = $this->get("formatoPracticapdf/{$ids}");
        $response->assertStatus(200);
        $response->assertDownload();
    }

    /**
     * Prueba unitaria del método exportAvancePdf del controlador PdfController
     */
    public function test_pdf_exportAvancePdf(): void{
        $user = User::find(79494815);
        $this->actingAs($user);
        $ids = '546,547';
        $response = $this->get("avancepdf/{$ids}");
        $response->assertStatus(200);
        $response->assertDownload();
    }

    /**
     * Prueba unitaria del método exportOficioPdf del controlador PdfController
     */
    public function test_pdf_exportOficioPdf(): void{
        $user = User::find(79494815);
        $this->actingAs($user);
        $ids = '546,547';
        $response = $this->get("oficiopdf/{$ids}");
        $response->assertStatus(200);
        $response->assertDownload();
    }

    /**
     * Prueba unitaria del método exportGiroPdf del controlador PdfController
     */
    public function test_pdf_exportGiroPdf(): void{
        $user = User::find(79494815);
        $this->actingAs($user);
        $ids = '546,547';
        $response = $this->get("giropdf/{$ids}");
        $response->assertStatus(200);
        $response->assertDownload();
    }
    /**
     * Prueba unitaria del método exportTransportePdf del controlador PdfController
     */
    public function test_pdf_exportTransportePdf(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $ids = '824';
        $response = $this->get("transportepdf/{$ids}");
        $response->assertStatus(200);
        $response->assertDownload();
    }
    /**
     * Prueba unitaria del método declaracion_resp_docente del controlador PdfController
     */
    public function test_pdf_declaracion_resp_docente(): void{
        $user = User::where('id_role',5)->first();
        $this->actingAs($user);
        $id = 824;
        $response = $this->get("declaracion_resp_docente/{$id}");
        $response->assertStatus(200);
        $response->assertDownload();
    }
    /**
     * Prueba unitaria del método declaracion_resp_estudiante del controlador PdfController
     */
    public function test_pdf_declaracion_resp_estudiante(): void{
        $user = estudiante::where('id_role',8)->first();
        $this->actingAs($user);
        $email = 'prueba@udistrital.edu.co';
        $email = Crypt::encrypt($email);
        $id_solicitud = 1074;
        $id_solicitud = Crypt::encrypt($id_solicitud);
        $response = $this->get("declaracion_resp_estudiante/{$email}/{$id_solicitud}");
        $response->assertStatus(200);
        $response->assertDownload();
    }
    /*
    Métodos que no se usan:
    accionesPdf
    dwn_doc_estud
    */
}