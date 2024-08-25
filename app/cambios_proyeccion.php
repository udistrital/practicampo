<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class cambios_proyeccion extends Model
{
    protected $table = 'cambios_proyeccion';
    // public $timestamps = false;
    protected $fillable = [
            'cambiar_programa_academico',
            'cambiar_espacio_academico',
            'cambiar_sem_anio_per',
            'cambiar_integrada',    		
            'cambiar_estudiantes',    		
            'cambiar_grupos',    		
            'cambiar_personal_apoyo',
            'cambiar_destino_rp',    		
            'cambiar_url_rp',    		
            'cambiar_detalle_rp',    		
            'cambiar_sedes_rp',    		
            'cambiar_fechas_rp',    		
            'cambiar_transporte_rp',    		
            'cambiar_transporte_menor_rp',    		
            'cambiar_otros_rp',    		
            'cambiar_actividades_riego_rp',    		
            'cambiar_destino_ra',    		
            'cambiar_url_ra',    		
            'cambiar_detalle_ra',    		
            'cambiar_sedes_ra',    		
            'cambiar_fechas_ra',    		
            'cambiar_transporte_ra',    		
            'cambiar_transporte_menor_ra',    		
            'cambiar_otros_ra',    		
            'cambiar_actividades_riego_ra',   
            'id_user_hab',
    ];
}
