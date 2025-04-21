<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class solicitud extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'solicitud_practica';

    protected $fillable = [
            'id_proyeccion_preliminar',
            
    ];
}

