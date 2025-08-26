<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class presupuesto_transporte_menor extends Model
{
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

