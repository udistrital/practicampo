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

class SolicitudControllerTest extends TestCase
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
     * Prueba unitaria del método edit del controlador SolicitudController
     */
    public function test_solicitud_edit(): void{
        $user = User::find(79794356);
        $this->actingAs($user);
        $proyeccion = proyeccion::find(1170);
        $id = Crypt::encrypt($proyeccion->id);
        $ruta= 1;
        $ruta= Crypt::encrypt($ruta);
        $response = $this->get("solicitudes/{$id}/{$ruta}");
        $response->assertStatus(200);
        $response->assertViewIs('solicitudes.edit'); 
    }

    /**
     * Prueba unitaria del método update del controlador SolicitudController
     */
    public function test_solicitud_update(): void{
        $user = User::find(79794356);
        $this->actingAs($user);
        $proyeccion = proyeccion::find(1170);
        $id = Crypt::encrypt($proyeccion->id);
        $ruta= 1;
        $ruta= Crypt::encrypt($ruta);
        $data = [
            'id_tipo_transporte_rp_' => [1,null,null],
            'id_tipo_transporte_ra_' => [1,null,null],
            'det_tipo_transporte_rp_' => 'Detalle RP',
            'det_tipo_transporte_ra_' => 'Detalle RA',
            'capac_transporte_rp_' => [40],
            'capac_transporte_ra_' => [40],
            'docente_resp_transp_rp' => 'Docente RP',
            'docente_resp_transp_ra' => 'Docente RA',
            'id_espacio_academico' => 110,
            'id_programa_academico' => 180,
            'integrada' => 1,
            'id_periodo_academico' => 2,
            'anio_periodo' => 2024,
            'id_semestre_asignatura' => 1,
            'num_estudiantes_aprox' => 35,
            'cant_grupos' => 2,
            'grupo_1' => 301,
            'grupo_2' => 302,
            'grupo_3' => 303,
            'grupo_4' => 304,
            'destino_rp' => 'Destino RP solicitud',
            'destino_ra' => 'Destino RA solicitud',
            'cant_url_rp' => 4,
            'cant_url_ra' => 3,
            'ruta_principal' => 'https://goo.gl/maps/principal1',
            'ruta_principal_2' => 'https://goo.gl/maps/principal2',
            'ruta_principal_3' => 'https://goo.gl/maps/principal3',
            'ruta_principal_4' => 'https://goo.gl/maps/principal4',
            'ruta_principal_5' => 'https://goo.gl/maps/principal5',
            'ruta_principal_6' => 'https://goo.gl/maps/principal6',
            'ruta_alterna' => 'https://goo.gl/maps/alternate1',
            'ruta_alterna_2' => 'https://goo.gl/maps/alternate2',
            'ruta_alterna_3' => 'https://goo.gl/maps/alternate3',
            'ruta_alterna_4' => 'https://goo.gl/maps/alternate4',
            'ruta_alterna_5' => 'https://goo.gl/maps/alternate5',
            'ruta_alterna_6' => 'https://goo.gl/maps/alternate6',
            'det_recorrido_interno_rp' => 'Recorrido Interno RP solicitud',
            'det_recorrido_interno_ra' => 'Recorrido Interno RA solicitud',
            'lugar_salida_rp' => 1,
            'lugar_salida_ra' => 2,
            'lugar_regreso_rp' => 3,
            'lugar_regreso_ra' => 4,
            'fecha_salida_aprox_rp' => '2025-10-01',
            'fecha_salida_aprox_ra' => '2025-10-02',
            'fecha_regreso_aprox_rp' => '2025-10-03',
            'fecha_regreso_aprox_ra' => '2025-10-04',
            'id_espa_aca_1' => 1,
            'id_espa_aca_2' => 2,
            'id_espa_aca_3' => 3,
            'id_espa_aca_4' => 4,
            'id_espa_aca_5' => 5,
            'id_espa_aca_6' => 6,
            'id_espa_aca_7' => 7,
            'cant_espa_aca' => 3,
            'id_docen_espa_aca_1' => 1,
            'id_docen_espa_aca_2' => 2,
            'id_docen_espa_aca_3' => 3,
            'id_docen_espa_aca_4' => 4,
            'id_docen_espa_aca_5' => 5,
            'id_docen_espa_aca_6' => 6,
            'id_docen_espa_aca_7' => 7,
            'num_acompaniantes' => 3,
            'num_apoyo' => 3,
            'total_docentes_apoyo' => 3,
            'doc_apoyo_1' => 1,
            'doc_apoyo_2' => 2,
            'doc_apoyo_3' => 3,
            'doc_apoyo_4' => 4,
            'doc_apoyo_5' => 5,
            'doc_apoyo_6' => 6,
            'doc_apoyo_7' => 7,
            'doc_apoyo_8' => 8,
            'doc_apoyo_9' => 9,
            'doc_apoyo_10' => 10,
            'apoyo_1' => 'doc1',
            'apoyo_2' => 'doc2',
            'apoyo_3' => 'doc3',
            'apoyo_4' => 'doc4',
            'apoyo_5' => 'doc5',
            'apoyo_6' => 'doc6',
            'apoyo_7' => 'doc7',
            'apoyo_8' => 'doc8',
            'apoyo_9' => 'doc9',
            'apoyo_10' => 'doc10',
            'cant_transporte_rp_edit' => 1,
            'cant_transporte_ra_edit' => 1,
            'exclusiv_tiempo_rp_1' => 1,
            'exclusiv_tiempo_rp_2' => 1,
            'exclusiv_tiempo_rp_3' => 1,
            'exclusiv_tiempo_ra_1' => 1,
            'exclusiv_tiempo_ra_2' => 1,
            'exclusiv_tiempo_ra_3' => 1,
            'cant_trans_menor_rp' => 2,
            'cant_trans_menor_ra' => 2,
            'trans_menor_rp_1' => 'Valor1',
            'trans_menor_rp_2' => 'Valor2',
            'trans_menor_rp_3' => 'Valor3',
            'trans_menor_rp_4' => 'Valor4',
            'vlr_trans_menor_rp_1' => rand(1000, 5000),
            'vlr_trans_menor_rp_2' => rand(1000, 5000),
            'vlr_trans_menor_rp_3' => rand(1000, 5000),
            'vlr_trans_menor_rp_4' => rand(1000, 5000),
            'docente_resp_t_menor_rp' => 'Docente RP',
            'trans_menor_ra_1' => 'Valor1',
            'trans_menor_ra_2' => 'Valor2',
            'trans_menor_ra_3' => 'Valor3',
            'trans_menor_ra_4' => 'Valor4',
            'vlr_trans_menor_ra_1' => rand(1000, 5000),
            'vlr_trans_menor_ra_2' => rand(1000, 5000),
            'vlr_trans_menor_ra_3' => rand(1000, 5000),
            'vlr_trans_menor_ra_4' => rand(1000, 5000),
            'docente_resp_t_menor_ra' => 'Docente RA',
            'det_materiales_rp' => 'Detalle Materiales RP',
            'det_materiales_ra' => 'Detalle Materiales RA',
            'det_guias_baquianos_rp' => 'Detalle Guías RP',
            'det_guias_baquianos_ra' => 'Detalle Guías RA',
            'det_otros_boletas_rp' => 'Detalle Otros Boletas RP',
            'det_otros_boletas_ra' => 'Detalle Otros Boletas RA',
            'areas_acuaticas_rp' => rand(0, 1),
            'areas_acuaticas_ra' => rand(0, 1),
            'alturas_rp' => rand(0, 1),
            'alturas_ra' => rand(0, 1),
            'riesgo_biologico_rp' => rand(0, 1),
            'riesgo_biologico_ra' => rand(0, 1),
            'espacios_confinados_rp' => rand(0, 1),
            'espacios_confinados_ra' => rand(0, 1),
            'vlr_materiales_rp' => rand(1000, 5000),
            'vlr_materiales_ra' => rand(1000, 5000),
            'vlr_guias_baquianos_rp' => rand(1000, 5000),
            'vlr_guias_baquianos_ra' => rand(1000, 5000),
            'vlr_otros_boletas_rp' => rand(1000, 5000),
            'vlr_otros_boletas_ra' => rand(1000, 5000),
            'vlr_materiales_rp' => rand(1000, 5000),
            'vlr_materiales_ra' => rand(1000, 5000),
            'vlr_guias_baquianos_rp' => rand(1000, 5000),
            'vlr_guias_baquianos_ra' => rand(1000, 5000),
            'vlr_otros_boletas_rp' => rand(1000, 5000),
            'vlr_otros_boletas_ra' => rand(1000, 5000),

        ];
        $response = $this->put("solicitudes/{$id}/{$ruta}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('solicitudes/filtrar/all');
    }

    /**
     * Prueba unitaria del método update del controlador SolicitudController para coordinador
     */
    public function test_solicitud_update_coordinador(): void{
        $user = User::find(12956);
        $this->actingAs($user);
        $proyeccion = proyeccion::find(1170);
        $id = Crypt::encrypt($proyeccion->id);
        $ruta = 1;
        $ruta = Crypt::encrypt($ruta);
        $data = [
            'observ_coordinador' => 'prueba unitaria coordinador solicitud',
            'aprobacion_coordinador' => 7,
        ];
        $response = $this->put("solicitudes/{$id}/{$ruta}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('solicitudes/filtrar/all');
    }

    /**
     * Prueba unitaria del método update del controlador SolicitudController para asistente
     */
    public function test_solicitud_update_asistente(): void{
        $user = User::find(79308666);
        $this->actingAs($user);
        $proyeccion = proyeccion::find(1170);
        $id = Crypt::encrypt($proyeccion->id);
        $ruta = 1;
        $ruta = Crypt::encrypt($ruta);
        $data = [
            'vlr_est_transp_rp' => rand(1000, 5000),
            'vlr_est_transp_ra' => rand(1000, 5000),
            'num_radicado_financiera'=> 0,
            'fecha_radicado_financiera' => null,
            'num_resolucion' => 10,
            'fecha_resolucion' => '2024-10-10',
            'num_cdp' => 123,
            'si_capital' => 1,
            'num_solicitud_necesidad' => 100,
        ];
        $response = $this->put("solicitudes/{$id}/{$ruta}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('solicitudes/filtrar/all');
    }

    /**
     * Prueba unitaria del método update del controlador SolicitudController para decano
     */
    public function test_solicitud_update_decano(): void{
        $user = User::find(79494815);
        $this->actingAs($user);
        $proyeccion = proyeccion::find(1170);
        $id = Crypt::encrypt($proyeccion->id);
        $ruta = 1;
        $ruta = Crypt::encrypt($ruta);
        $data = [
            'aprobacion_decano' => 7,
        ];
        $response = $this->put("solicitudes/{$id}/{$ruta}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('solicitudes/filtrar/all');
    }

    /**
     * Prueba unitaria del método consec_solic del controlador SolicitudController
     */
    public function test_solicitud_consec_solic(): void{
        $user = User::find(79494815);
        $this->actingAs($user);
        $solicitud = solicitud::where('id_proyeccion_preliminar', '=', 1170)->first();
        $id = $solicitud->id;
        $data = [
            'consec_dfamarena' => 123,
            'consec_cordis' => 456,
        ];
        $response = $this->put("consec_solic/{$id}", $data);

        $response->assertStatus(302);
        //$response->assertRedirect('solicitudes/filtrar/aprob');
    }

    /**
     * Prueba unitaria del método filterSolicitud del controlador SolicitudController
     */
    public function test_solicitud_filterSolicitud(): void{
        $user = User::find(79794356);
        $this->actingAs($user);
        $filter = 'all';
        $response = $this->get("solicitudes/filtrar/{$filter}");
        $response->assertStatus(200);
        $response->assertViewIs('solicitudes.index'); 
    }

    /**
     * Prueba unitaria del método listado_sol_aprob del controlador SolicitudController
     */
    public function test_solicitud_listado_sol_aprob(): void{
        $user = User::find(79494815);
        $this->actingAs($user);
        $solicitud= solicitud::where('id_docente_confirm', '=', 79794356)->get();
        $cant_sol = 0;
        $solicitudes = [];
        foreach ($solicitud as $sol) {            
            array_push($solicitudes, $sol->id); 
            $cant_sol++;     
        }
        $id = [
            'id_doc_resp' => 79794356,
            'full_name' => 'Name prueba unitaria',
            'cant_sol' => $cant_sol,
            'solic' => $solicitudes,
        ];
        $id = Crypt::encrypt($id);
        $response = $this->get("list_solic/aprob/{$id}");
        $response->assertStatus(200);
        $response->assertViewIs('solicitudes.index'); 
    }

    /**
     * Prueba unitaria del método listado_estud del controlador SolicitudController
     */
    public function test_solicitud_listado_estud(): void{
        $user = User::find(79794356);
        $this->actingAs($user);
        $id= 1170;
        $id = Crypt::encrypt($id);
        $response = $this->get("solic/{$id}");
        $response->assertStatus(200);
        $response->assertViewIs('solicitudes.lista_estudiantes'); 
    }

    /**
     * Prueba unitaria del método edit del controlador SolicitudController
     */
    public function test_solicitud_practica_realizada_edit(): void{
        $user = User::find(79794356);
        $this->actingAs($user);
        $proyeccion = proyeccion::find(1170);
        $id = Crypt::encrypt($proyeccion->id);
        $response = $this->get("practica_realizada/{$id}");
        $response->assertStatus(200);
        $response->assertViewIs('solicitudes.index'); 
    }

    public function test_solicitud_practica_realizada_update(): void{
        $user = User::find(79308666);
        $this->actingAs($user);
        $proyeccion = proyeccion::find(1170);
        $id = Crypt::encrypt($proyeccion->id);
        $data = [
            'practica_realizada' => 1
        ];
        $response = $this->put("practica_realizada/{$id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('solicitudes/filtrar/sol_realizadas');
    }
    /*
    Métodos que no se usan:
    duplicar_proy
    sendProy
    vbProy
    validar_electivas

    Métodos inactivos:
    creacion_proy
    aprob_coord_proy
    rechazo_coord_proy
    aprob_decano_proy
    rechazo_decano_proy
    cierre_coord_proy
    vb_decano_proy
    buscador
    */
}
