<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class espacio_academico extends Model
{
    protected $table = 'espacio_academico';

    protected $fillable = [
            'codigo_espacio_academico',
            'id_programa_academico',
            'espacio_academico',
            'plan_estudios_1',
            'plan_estudios_2', 
            'tipo_espacio',   		
    ];

    public function prog_academico()
    {
        return $this->belongsTo(programa_academico::class,'id_programa_academico');
    }

    public function user()
    {
        return $this->hasMany(user::class);
    }
}
