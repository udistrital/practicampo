<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class proyeccion extends Model
{
    protected $table = 'proyeccion_preliminar';

    protected $fillable = [
            'id_estado',
            'id_programa_academico',    		
            'id_espacio_academico',  
            'id_periodo_academico',  
            'anio_periodo',  
            'id_semestre_asignatura',
            'num_estudiantes_aprox',  
            'id_docente_responsable',   
            'cantidad_grupos',
            'grupo_1',  
            'grupo_2',  
            'grupo_3',  
            'grupo_4',  

            'destino_rp',  
            'cantidad_url_rp',
            'ruta_principal', 
            'ruta_principal_2',
            'ruta_principal_3',
            'ruta_principal_4',
            'ruta_principal_5',
            'ruta_principal_6', 
            'det_recorrido_interno_rp',  
            'lugar_salida_rp',  
            'lugar_regreso_rp',  
            'fecha_salida_aprox_rp',  
            'fecha_regreso_aprox_rp',  
            'duracion_num_dias_rp',
            
            'destino_ra',
            'cantidad_url_ra',
            'ruta_alterna', 
            'ruta_alterna_2',
            'ruta_alterna_3',
            'ruta_alterna_4',
            'ruta_alterna_5',
            'ruta_alterna_6', 
            'det_recorrido_interno_ra',
            'lugar_salida_ra',  
            'lugar_regreso_ra',  
            'fecha_salida_aprox_ra',  
            'fecha_regreso_aprox_ra',  
            'duracion_num_dias_ra',

            'confirm_creador',
            'id_creador_confirm',
            'confirm_docente',
            'id_docente_confirm',
            'confirm_coord',
            'confirm_asistD',
            'aprobacion_coordinador',
            'aprobacion_asistD',
            'aprobacion_decano',
            'aprobacion_consejo_facultad',
            'fecha_diligenciamiento',
        ];
    }
    