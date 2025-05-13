<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class historico_presupuesto_programa_academico extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'historico_presupuesto_programa_academico';
    public $timestamps = false;
    protected $fillable = [
            'id_presupuesto_programa',
            'id_programa_academico',
            'presupuesto_inicial_historico',
            'id_user_update',
            'fecha_update',	
    ];
}
