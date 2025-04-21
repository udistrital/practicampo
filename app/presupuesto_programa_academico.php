<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class presupuesto_programa_academico extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'presupuesto_programa_academico';
    public $timestamps = false;
    protected $fillable = [
            'id_programa_academico',
            'presupuesto_inicial',
            'presupuesto_actual',	
    ];
}
