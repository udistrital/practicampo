<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class presupuesto_programa_academico extends Model
{
    protected $table = 'presupuesto_programa_academico';
    public $timestamps = false;
    protected $fillable = [
            'id_programa_academico',
            'presupuesto_inicial',
            'presupuesto_actual',	
    ];
}
