<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class detalle_presupuesto_programa_academico extends Model
{
    protected $table = 'detalle_presupuesto_programa_academico';
    public $timestamps = false;
    protected $fillable = [
            'id_presupuesto_programa',
            'id_solicitud',
            'presupuesto_práctica',
            'id_user_aprobacion',
            'fecha_aprobacion', 
            'anio_periodo', 
            'id_periodo_academico',  		
    ];
}
