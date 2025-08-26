<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class presupuesto_transporte_menor extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'presupuesto_transporte_menor';
    public $timestamps = false;
    protected $fillable = [
            'id',
            'presupuesto_inicial',
            'presupuesto_restante',
            'id_user_update',
            'fecha_update',	
    ];
}
