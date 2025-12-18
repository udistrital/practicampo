<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PractiCampoUD\programacion;
use PractiCampoUD\solicitud;
use PractiCampoUD\User;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;
use Illuminate\Http\UploadedFile;
use PractiCampoUD\estudiante;
use PractiCampoUD\estudiantes_practica;
use Illuminate\Support\Facades\Auth;

class EstudianteControllerTest extends TestCase
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
     * Prueba unitaria del método edit del controlador EstudianteController
     */
    public function test_estudiante_edit(): void{
        $user = estudiante::where('email','juldgonzalez@udistrital.edu.co')->first();
        $this->actingAs($user, 'estud');
        $solicitud = solicitud::find(1074);
        $id = Crypt::encrypt($solicitud->id);
        $email= 'juldgonzalez@udistrital.edu.co';
        $email= Crypt::encrypt($email);
        $response = $this->get("editEst/{$id}/{$email}");
        $response->assertStatus(200);
        $response->assertViewIs('estudiantes.cargue_docs_est'); 
    }

    /**
     * Prueba unitaria del método filterEstudiante del controlador EstudianteController
     */
    public function test_estudiante_filterEstudiante(): void{
        $user = estudiante::where('email','juldgonzalez@udistrital.edu.co')->first();
        $this->actingAs($user, 'estud');
        $id = 'sol_estudiante';
        $response = $this->get("Estudiante/filtrar/{$id}");
        $response->assertStatus(200);
        $response->assertViewIs('estudiantes.index_solic_est'); 
    }
    /**
     * Prueba unitaria del método importDoc del controlador EstudianteController
     */
    public function test_estudiante_importDoc(): void{
        $user = estudiante::where('email','juldgonzalez@udistrital.edu.co')->first();
        $this->actingAs($user, 'estud');
        $solicitud = solicitud::find(1074);
        $id_sol = Crypt::encrypt($solicitud->id);
        $id= $user->email;
        $id= Crypt::encrypt($id);
        $archivo = UploadedFile::fake()->create(
            'declaracion_responsabilidad_estudiante.pdf',
            100,
            'application/pdf'
        );
        $data = [
            'declaracion_responsabilidad' => $archivo,
            'id_tipo_identificacion' => 1,
            'num_identificacion' => 1111,
            'fecha_nacimiento' => '2000-03-03',
            'celular' => 123,
            'eps' => 'eps',
        ];
        $response = $this->post("imp-doc-estudiantes/{$id}/{$id_sol}", $data);
        $response->assertStatus(302);
        $response->assertRedirect('/Estudiante/filtrar/sol_estudiante'); 
    }

    /**
     * Prueba unitaria del método update_datos_basicos del controlador EstudianteController
     */
    public function test_estudiante_update_datos_basicos(): void{
        $user = estudiante::where('email','juldgonzalez@udistrital.edu.co')->first();
        $this->actingAs($user, 'estud');
        $email= $user->email;
        $email= Crypt::encrypt($email);
        $solicitud = solicitud::find(1074);
        $id_sol = Crypt::encrypt($solicitud->id);
        $data = [
            'id_tipo_identificacion' => 1,
            'num_identificacion' => 1111,
            'fecha_nacimiento' => '2000-03-03',
            'celular' => 123,
            'eps' => 'eps',
        ];
        $response = $this->post("update_datos_basicos/{$email}/{$id_sol}", $data);
        $response->assertStatus(302);
    }
    /**
     * Prueba unitaria del método ver_documentos_estudiante del controlador EstudianteController
     */
    public function test_estudiante_ver_documentos_estudiante(): void{
        $user = estudiante::where('email','juldgonzalez@udistrital.edu.co')->first();
        $this->actingAs($user, 'estud');
        $email= $user->email;
        $solicitud = solicitud::find(1074);
        $data = [
            'email' => $email,
            'id' => $solicitud->id,
        ];
        $response = $this->get("ver-documentos-estudiante", $data);
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'documentos',
                ]);
    }
    /**
     * Prueba unitaria del método crear_estudiante del controlador EstudianteController
     */
    public function test_estudiante_crear_estudiante(): void{
        $user = estudiante::where('email','juldgonzalez@udistrital.edu.co')->first();
        $this->actingAs($user, 'estud');
        $email= $user->email;
        $solicitud = solicitud::find(1074);
        $data = [
            'email' => $email,
            'id_solicitud' => $solicitud->id,
            'codigo_estudiante' => 1111,
            'nombre_completo' => 'Julian Gonzalez',
            'grupo' => 301,
        ];
        $response = $this->post("crear-estudiante", $data);
        $response->assertStatus(200);
    }
    /**
     * Prueba unitaria del método eliminar_estudiante del controlador EstudianteController
     */
    public function test_estudiante_eliminar_estudiante(): void{
        $user = estudiante::where('email','bjulian@udistrital.edu.co')->first();
        $this->actingAs($user, 'estud');
        $email= $user->email;
        $solicitud = solicitud::find(1074);
        $data = [
            'email' => $email,
            'id' => $solicitud->id,
        ];
        $response = $this->post("eliminar-estudiante", $data);
        $response->assertStatus(200);
    }

    /**
     * Prueba unitaria del método verificar_asistencia_estudiante del controlador EstudianteController
     */
    public function test_estudiante_verificar_asistencia_estudiante(): void{
        $user = estudiante::where('email','juldgonzalez@udistrital.edu.co')->first();
        $this->actingAs($user, 'estud');
        $email= $user->email;
        $solicitud = solicitud::find(1074);
        $data = [
            'email' => $email,
            'id' => $solicitud->id,
            'valor' => 1,
        ];
        $response = $this->post("verificar-asistencia-estudiante", $data);
        $response->assertStatus(200);
    }
    /**
     * Prueba unitaria del método index_listar del controlador EstudianteController
     */
    public function test_estudiante_index_listar(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $response = $this->get("estudiantes");
        $response->assertStatus(200);
        $response->assertViewIs('estudiantes.index_listar');
    }

    /**
     * Prueba unitaria del método listar_estudiantes del controlador EstudianteController
     */
    public function test_estudiante_listar_estudiantes(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $solicitud = solicitud::find(1074);
        $data = [
            'id_solicitud' => $solicitud->id,
        ];
        $response = $this->post("listar_estudiantes", $data);
        $response->assertStatus(200);
        $response->assertViewIs('estudiantes.index_listar');
    }
    /**
     * Prueba unitaria del método update_estudiante del controlador EstudianteController
     */
    public function test_estudiante_update_estudiante(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $email = 'juldgonzalez@udistrital.edu.co';
        $data = [
            'num_identificacion' => 4213,
            'codigo_estudiante' => 1234,
            'nombre_completo' => 'nombre prueba',
            'email' => 'prueba@udistrital.edu.co',
            'fecha_nacimiento' => '2000-03-03',
            'celular' => 123,
            'eps' => 'eps',
        ];
        $response = $this->put("estudiantes/update/{$email}", $data);
        $response->assertStatus(200);
    }
    /**
     * Prueba unitaria del método estudiantes_delete_docs del controlador EstudianteController
     */
    public function test_estudiante_estudiantes_delete_docs(): void{
        $user = User::where('id_role',2)->first();
        $this->actingAs($user);
        $data = [
            'fecha_inicial' => '2025-08-01',
            'fecha_final' => '2025-12-31',
        ];
        $response = $this->put("estudiantes_delete_docs", $data);
        $response->assertStatus(302);
    }
}
