<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class detalle_presupuesto_programa_academico extends Model implements Auditable
{
    use AuditableTrait;
    
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
