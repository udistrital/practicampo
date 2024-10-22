<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PractiCampoUD\proyeccion;
use PractiCampoUD\User;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

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

    /*
    Métodos que no se usan:
    exportTransportePdf
    accionesPdf
    dwn_doc_estud
    */
}