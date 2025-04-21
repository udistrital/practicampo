<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class control_sistema extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'control_sistema';
    public $timestamps = false;
    protected $fillable = [
            'fecha_apertura_proy',
            'fecha_cierre_proy',
            'fecha_apertura_solic',
            'fecha_cierre_solic',    		
    ];
}
